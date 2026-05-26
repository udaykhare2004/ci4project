<?php
namespace App\Controllers;
use App\Models\StudentModel;

class Students extends BaseController
{
    public function index() {
        $model = new StudentModel();
        $data['students'] = $model->findAll();
        return view('students/index',$data);
    }

    public function create() {
        return view('students/create');
    }

    public function store(){
        $rules = [
            'first_name' => 'required|max_length[50]',
            'last_name'  => 'required|max_length[50]',
            'email'      => 'required|valid_email|max_length[100]',
            'phone'      => 'permit_empty|max_length[20]',
            'dob'        => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return view('students/create', [
                'errors' => $this->validator->getErrors()
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

        return redirect()->to(site_url('students'));
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
            'first_name' => 'required|max_length[50]',
            'last_name'  => 'required|max_length[50]',
            'email'      => 'required|valid_email|max_length[100]',
            'phone'      => 'permit_empty|max_length[20]',
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
}