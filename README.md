Features

Student CRUD (Create, Read, Update, Delete)
Course enrollment
Search and filter by name, email, course
Pagination
Export students to Excel (.xlsx)
Import students from Excel (.xlsx)

Requirements

XAMPP (Apache + MySQL) or standalone MySQL
PHP 8.x
Composer

Setup

1. Clone the repo
   git clone https://github.com/udaykhare2004/phplearn.git
   cd phplearn
2. Install dependencies
   composer install
3. Set up the database
   Open MySQL Workbench or phpMyAdmin and run database.sql to create the database and tables.
4. Configure environment
   Copy .env.example to .env:
   cp .env.example .env
   Then update these values in .env:
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost/ci4project/public/'

database.default.hostname = localhost
database.default.database = phplearn
database.default.username = root
database.default.password = your_password_here
database.default.DBDriver = MySQLi

5. Run the app
   Make sure Apache and MySQL are running, then visit:
   http://localhost/ci4project/public/students

Project Structure
app/
Controllers/
Students.php — handles all student routes
Models/
StudentModel.php — DB model for students
Views/
students/
index.php — list all students
create.php — add new student
show.php — view student details
edit.php — edit student
import.php — import from Excel
