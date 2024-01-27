<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class SchoolAllModel extends Model
{
	protected $table  = 'school_all';

	protected $primaryKey = 'school_id';

	protected $allowedFields    = [
        'school_id',
        'school_title',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}