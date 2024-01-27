<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class QA_Model extends Model
{
	protected $table = 'QA';

	protected $primaryKey = 'QA_id';


	protected $allowedFields = ['Uniqueid', 'opinion', 'Score', 'QAA_id', 'QA_Comment_good', 'QA_Comment_bad', 'QAComment', 'Status', 'PDFfile', 'created', 'updated', 'delivered', 'reviewed'];

}