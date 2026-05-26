<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>View Student</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    p { font-size: 14px; margin: 8px 0; }
    span { font-weight: bold; }
    hr { margin: 20px 0; border: none; border-top: 1px solid #ddd; }
    a { color: #007bff; font-size: 14px; margin-right: 12px; }
  </style>
</head>
<body>

  <h2>Student Details</h2>

  <p>ID: <span><?= $student['id'] ?></span></p>
  <p>First Name: <span><?= esc($student['first_name']) ?></span></p>
  <p>Last Name: <span><?= esc($student['last_name']) ?></span></p>
  <p>Email: <span><?= esc($student['email']) ?></span></p>
  <p>Phone: <span><?= esc($student['phone']) ?: '—' ?></span></p>
  <p>Date of Birth: <span><?= $student['dob'] ?: '—' ?></span></p>
  <p>Registered: <span><?= $student['created_at'] ?></span></p>

  <hr>
  <a href="/ci4project/public/students/<?= $student['id'] ?>/edit">Edit</a>
  <a href="/ci4project/public/students">← Back to List</a>

</body>
</html>