<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class PaymentModel extends Model
{
	protected $table  = 'payment';

	protected $primaryKey = 'payment_id';

	protected $allowedFields    = [
        'payment_id',
        'instructor_pid',
        'hourly_rate',
        'total_payment',
        'effective_date_from',
        'effective_date_to',
        'effective_date',
        'status',
        'isDelete',
        'created_at',
        'updated_at',
    ];

}