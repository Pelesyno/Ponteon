<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $allowedFields = ['name', 'email', 'password'];
}