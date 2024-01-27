<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class LocationModel extends Model
{
	protected $table  = 'location';

	protected $primaryKey = 'location_id';

	protected $allowedFields    = [
        'location_id',
        'location_title',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}