<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>All Students</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ddd; font-size: 14px; text-align: left; }
    th { background: #f5f5f5; }
    a { color: #007bff; text-decoration: none; margin-right: 8px; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
    <h2>All Students </h2>
    <a href="/ci4project/public/students/create">+ Add new Students</a>
    <a href="/ci4project/public/students/export">Export to excel</a>
    <a href="<?= site_url('students/import') ?>">Import from Excel</a>
    <br></br>

    <br>
    <form method="GET" action="<?= site_url('students') ?>">
        <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search by name or email..." style="padding:8px; width:250px; border:1px solid #ccc; border-radius:4px;"/>

        <select name="course" style="padding:8px; border:1px solid #ccc; border-radius:4px;">
            <option value="">-- All Courses --</option>
            <?php foreach($courses as $c): ?>
                <option value="<?= $c['id'] ?>" <?= ($course ?? '') == $c['id'] ? 'selected' : '' ?>>
                    <?= esc($c['course_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" style="padding:8px 16px; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer;">Search</button>
        <a href="<?= site_url('students') ?>">Clear</a>
    </form>
    <br>

    <table>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date of Birth</th>
            <th>Actions</th>
        </tr>

        <?php foreach($students as $student):?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= esc($student['first_name']) ?></td>
            <td><?= esc($student['last_name']) ?></td>
            <td><?= esc($student['email']) ?></td>
            <td><?= esc($student['phone']) ?: '—' ?></td>
            <td><?= $student['dob'] ?: '—' ?></td>
            <td>
                <a href="/ci4project/public/students/<?= $student['id'] ?>">View</a>
                <a href="/ci4project/public/students/<?= $student['id'] ?>/edit">Edit</a>
                <form action="<?= site_url('students/' . $student['id'] . '/delete') ?>" method="POST" style="display:inline;">
                    <button type="submit"
                     onclick="return confirm('Are you sure?')"
                     style="background:none; border:none; color:red; cursor:pointer; font-size:14px;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<br>
<?= $pager->links('default', 'default_full', ['search' => $search, 'course' => $course]) ?>
</body>
</html>    