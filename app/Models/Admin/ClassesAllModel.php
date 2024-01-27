<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ClassesAllModel extends Model
{
	protected $table  = 'classes_all';

	protected $primaryKey = 'class_id';

	protected $allowedFields    = [
        'class_id',
        'class_title',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}