<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class QA_Details_Model extends Model
{
	protected $table = 'QA_Details';

	protected $primaryKey = 'QA_Det_id';

	protected $allowedFields = ['QA_pid', 'QAQues_pid', 'Score', 'Comment', 'Response'];

}