<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Users_Model extends Model
{
	protected $table  = 'tbl_user';

	protected $primaryKey = 'user_id';

	protected $allowedFields    = [
        'user_id',
        'fname',
        'lname',
        'username',
        'email',
        'phone',
        'hr_rate',
        'level_pid',
        'rank_pid',
        'class_pid',
        'location_pid',
        'password',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}