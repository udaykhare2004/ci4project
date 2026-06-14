<?php
namespace App\Controllers;
use App\Models\StudentModel;

class Students extends BaseController
{
    public function index() {
        $model = new StudentModel();
        $db = \Config\Database::connect();
        $search = $this->request->getGet('search');
        $course_filter = $this->request->getGet('course');

        if ($search) {
        $model->like('first_name', $search)
              ->orLike('last_name', $search)
              ->orLike('email', $search);
        }

        if ($course_filter) {
            $model->join('enrollments', 'enrollments.student_id = students.id', 'left')
                  ->where('enrollments.course_id', $course_filter);
        }

        $data['students'] = $model->paginate(3);
        $data['search'] = $search;

        $data['pager'] = $model->pager;

        $data['course']   = $course_filter;
        $data['courses']  = $db->table('courses')->get()->getResultArray();

        return view('students/index',$data);
    }

    public function create() {
        $db = \Config\Database::connect();
        $data['courses'] = $db->table('courses')->get()->getResultArray();
        return view('students/create', $data);
    }

    public function store() {
        $rules = [
            'first_name' => 'required|max_length[50]|regex_match[/^[a-zA-Z\s]+$/]',
            'last_name'  => 'required|max_length[50]|regex_match[/^[a-zA-Z\s]+$/]',
            'email'      => 'required|valid_email|max_length[100]',
            'phone'      => 'permit_empty|max_length[20]|regex_match[/^[0-9\+\-\s]+$/]',
            'dob'        => 'permit_empty|valid_date',
    ];

        if (!$this->validate($rules)) {
            $db = \Config\Database::connect();
            return view('students/create', [
                'errors'  => $this->validator->getErrors(),
                'courses' => $db->table('courses')->get()->getResultArray()
            ]);
        }

        $model = new StudentModel();
        $model->insert([
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'dob'        => $this->request->getPost('dob'),
        ]);

        $student_id = $model->getInsertID();

        $course_id = $this->request->getPost('course_id');
        if ($course_id) {
            $db = \Config\Database::connect();
            $db->table('enrollments')->insert([
                'student_id'      => $student_id,
                'course_id'       => $course_id,
                'enrollment_date' => date('Y-m-d'),
            ]);
        }

        $email = \Config\Services::email();
        $email->setTo($this->request->getPost('email'));
        $email->setSubject('Welcome to phplearn!');
        $email->setMessage('
            <h2>Welcome, ' . $this->request->getPost('first_name') . '!</h2>
            <p>You have been successfully registered on phplearn.</p>
            <p>We are glad to have you on board!</p>
        ');
        $email->setMailType('html');
        $email->send();

        return redirect()->to(site_url('students'));
    }

    public function export() {
        $db = \Config\Database::connect();
        $students = $db->table('students')
                   ->select('students.*, courses.course_name')
                   ->join('enrollments', 'enrollments.student_id = students.id', 'left')
                   ->join('courses', 'courses.id = enrollments.course_id', 'left')
                   ->get()
                   ->getResultArray();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Last Name');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Phone');
        $sheet->setCellValue('F1', 'Date of Birth');
        $sheet->setCellValue('G1', 'Course');


        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $row, $student['id']);
            $sheet->setCellValue('B' . $row, $student['first_name']);
            $sheet->setCellValue('C' . $row, $student['last_name']);
            $sheet->setCellValue('D' . $row, $student['email']);
            $sheet->setCellValue('E' . $row, $student['phone']);
            $sheet->setCellValue('F' . $row, $student['dob']);
            $sheet->setCellValue('G' . $row, $student['course_name'] ?? '—');
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="students.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function importForm(){
        return view('students/import');
    }

    public function import() {
        $file = $this->request->getFile('excel_file');

        if (!$file->isValid() || $file->getExtension() !== 'xlsx') {
            return view('students/import', [
                'error' => 'Please upload a valid .xlsx file'
            ]);
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = $sheet->toArray();

        $model = new StudentModel();
        $db = \Config\Database::connect();

        $imported = 0;
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; 

            $email = $row[3] ?? '';

            if (empty($email) || $model->where('email', $email)->first()) continue;

            $model->insert([
                'first_name' => $row[1] ?? '',
                'last_name'  => $row[2] ?? '',
                'email'      => $email,
                'phone'      => $row[4] ?? '',
                'dob'        => $row[5] ?? null,
            ]);

            $imported++;
        }

        return view('students/import', [
            'success' => "$imported students imported successfully!"
        ]);
    }

    public function show($id) {
        $model = new StudentModel();
        $data['student'] = $model->find($id);
        return view('students/show',$data);
    }

    public function edit($id) {
        $model = new StudentModel();
        $data['student'] = $model->find($id);
        return view('students/edit',$data);
    }

    public function update($id){
        $rules = [
            'first_name' => 'required|max_length[50]|regex_match[/^[a-zA-Z\s]+$/]',
            'last_name'  => 'required|max_length[50]|regex_match[/^[a-zA-Z\s]+$/]',
            'email'      => 'required|valid_email|max_length[100]',
            'phone'      => 'permit_empty|max_length[20]|regex_match[/^[0-9\+\-\s]+$/]',
            'dob'        => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            $model = new StudentModel();
            return view('students/edit', [
                'errors'  => $this->validator->getErrors(),
                'student' => $model->find($id)
            ]);
        }

        $model = new StudentModel();
        $model->update($id, [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'dob'        => $this->request->getPost('dob'),
        ]);

        return redirect()->to(site_url('students'));
    }

    public function delete($id) {
        $model = new StudentModel();
        $model->delete($id);
        return redirect()->to(site_url('students'));
    }

    public function emailForm() {
        $model = new StudentModel();
        $data['students'] = $model->findAll();
        return view('students/email', $data);
    }

    public function sendEmail() {
        $to      = $this->request->getPost('student_email');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');

        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->setMailType('html');

        if ($email->send()) {
            $data['success'] = "Email sent successfully to $to!";
        } else {
            $data['error'] = "Failed to send email.";
        }

        $model = new StudentModel();
        $data['students'] = $model->findAll();
        return view('students/email', $data);
    }
}