<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class InstructorLevelModel extends Model
{
	protected $table  = 'instructor_level';

	protected $primaryKey = 'level_id';

	protected $allowedFields    = [
        'level_id',
        'level_title',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}