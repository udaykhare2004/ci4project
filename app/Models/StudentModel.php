<?php
namespace App\models;
use CodeIgniter\Model;

class StudentModel extends Model {
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'first_name',
        'last_name', 
        'email',
        'phone',
        'dob'
    ];
}