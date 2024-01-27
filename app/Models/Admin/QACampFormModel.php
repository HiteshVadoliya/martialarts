<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class QACampFormModel extends Model
{
	protected $table = 'QACampForm';

	protected $primaryKey = 'QACF_id';

	protected $allowedFields = ['Camp_pid', 'QAQues_pid', 'weight', 'FormOrder'];

}