<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Edit Student</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    label { display: block; margin-top: 14px; font-size: 14px; font-weight: bold; }
    input { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
    button { margin-top: 20px; padding: 10px 24px; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; }
    a { display: block; margin-top: 12px; color: #007bff; font-size: 14px; }
  </style>
</head>
<body>

  <h2>Edit Student</h2>
  <?php if (isset($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <p style="color:red; font-size:13px;">❌ <?= $error ?></p>
    <?php endforeach; ?>
  <?php endif; ?>
  <form action="<?= site_url('students/' . $student['id'] . '/edit') ?>" method="POST">
    <?= csrf_field() ?>

    <label>First Name</label>
    <input type="text" name="first_name" value="<?= esc($student['first_name']) ?>" required />

    <label>Last Name</label>
    <input type="text" name="last_name" value="<?= esc($student['last_name']) ?>" required />

    <label>Email</label>
    <input type="email" name="email" value="<?= esc($student['email']) ?>" required />

    <label>Phone</label>
    <input type="tel" name="phone" value="<?= esc($student['phone']) ?>" />

    <label>Date of Birth</label>
    <input type="date" name="dob" value="<?= $student['dob'] ?>" />

    <button type="submit">Update Student</button>
  </form>

  <a href="/ci4project/public/students">← Back to List</a>

</body>
</html>