<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class CampaignModel extends Model
{
	protected $table = 'Campaign';

	protected $primaryKey = 'Camp_id';

	protected $allowedFields = ['Camp_Name', 'Client_id'];

}