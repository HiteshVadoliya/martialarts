<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
	protected $table  = 'schedule';

	protected $primaryKey = 'schedule_id';

	protected $allowedFields    = [
        'schedule_id',
        'class_pid',
        'school_pid',
        'instructor_pid',
        'weekday_pid',
        'day_time',
        'effective_date_from',
        'effective_date_to',
        'effective_date',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}