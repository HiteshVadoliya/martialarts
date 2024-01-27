<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Phrases_Model extends Model
{
	protected $table = 'Phrases';

	protected $primaryKey = 'Phrase_id';

	protected $allowedFields = ['Phrase', 'Good', 'Weight', 'Camp_pid', 'Client'];

}