<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>Send Email</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; padding: 0 16px; }
    h2 { margin-bottom: 20px; }
    label { display: block; margin-top: 14px; font-size: 14px; font-weight: bold; }
    input, select, textarea { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; box-sizing: border-box; }
    textarea { height: 150px; resize: vertical; }
    button { margin-top: 20px; padding: 10px 24px; background: #007bff; color: #fff; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; }
    a { display: block; margin-top: 12px; color: #007bff; font-size: 14px; }
  </style>
</head>
<body>

  <h2>Send Email to Student</h2>

  <?php if (isset($success)): ?>
    <p style="color:green;">✅ <?= $success ?></p>
  <?php endif; ?>

  <?php if (isset($error)): ?>
    <p style="color:red;">❌ <?= $error ?></p>
  <?php endif; ?>

  <form action="<?= site_url('students/email') ?>" method="POST">
    <?= csrf_field() ?>

    <label>Select Student</label>
    <select name="student_email" required>
      <option value="">-- Select Student --</option>
      <?php foreach($students as $student): ?>
        <option value="<?= esc($student['email']) ?>">
          <?= esc($student['first_name']) ?> <?= esc($student['last_name']) ?> (<?= esc($student['email']) ?>)
        </option>
      <?php endforeach; ?>
    </select>

    <label>Subject</label>
    <input type="text" name="subject" placeholder="Enter subject..." required />

    <label>Message</label>
    <textarea name="message" placeholder="Write your message here..."></textarea>

    <button type="submit">Send Email</button>
  </form>

  <a href="<?= site_url('students') ?>">← Back to List</a>

</body>
</html>