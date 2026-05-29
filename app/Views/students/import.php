<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Import Students</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    input[type="file"] { margin-top: 10px; }
    button { margin-top: 20px; padding: 10px 24px; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; }
    a { display: block; margin-top: 12px; color: #007bff; font-size: 14px; }
  </style>
</head>
<body>

  <h2>Import Students from Excel</h2>

  <?php if (isset($error)): ?>
    <p style="color:red;">❌ <?= $error ?></p>
  <?php endif; ?>

  <?php if (isset($success)): ?>
    <p style="color:green;">✅ <?= $success ?></p>
  <?php endif; ?>

  <form action="<?= site_url('students/import') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <label>Select .xlsx file</label>
    <input type="file" name="excel_file" accept=".xlsx" required />
    <button type="submit">Import</button>
  </form>

  <a href="<?= site_url('students') ?>">← Back to List</a>

</body>
</html>