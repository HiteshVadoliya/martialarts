<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
	protected $table  = 'schedule';

	protected $primaryKey = 'schedule_id';

	protected $allowedFields    = [
        'schedule_id',
        'schedule_title',
        'school_pid',
        'schedule_time',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}