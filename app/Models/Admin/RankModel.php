<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class RankModel extends Model
{
	protected $table  = 'rank';

	protected $primaryKey = 'rank_id';

	protected $allowedFields    = [
        'rank_id',
        'rank_title',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}