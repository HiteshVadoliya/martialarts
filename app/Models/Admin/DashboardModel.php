<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'Campaign';
    protected $primaryKey       = 'camp_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'Camp_id',
        'Camp_Name',	
        'Client_id'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public static function totalWaiting() {
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query = $db->table('Transcriptions t');
        $query->select('count(*) as total');
        $query->join('QA', "QA.Uniqueid= t.Uniqueid", 'left');
        $query->Where('QA.Uniqueid',NULL);
        $query->Where('t.Status',4);
        return $query->get()->getRowArray();
    }

    public static function totalAgentResponse() {
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query = $db->table("QA");
        $query->select('count(*) as total');
        $query->Where('Status',4);
        return $query->get()->getRowArray();
    }
    
    public static function totalDisputedForm() {
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query = $db->table("QA");
        $query->select('count(*) as total');
        $query->Where('Status',5);
        return $query->get()->getRowArray();
    }

    public static function totalCallLogEmpty() {
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query = $db->table("Call_log");
        $query->select('count(*) as total');
        $query->Where('Recording',"NOTFOUND");
        return $query->get()->getRowArray();
    }

    public static function filterDataWeekly(){
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query_weeks = $db->table("QA qa");
        $query_weeks->select('CONCAT(u.fname," ",u.lname) as Name, week(`delivered`) as week, count(*) as total');
        $query_weeks->join('tbl_user u', "qa.QAA_id=u.user_id", 'left');
        $query_weeks->Where('week(`delivered`) > week(CURRENT_DATE)-8');
        $query_weeks->groupBy('`QAA_id`,week(`delivered`)');
        $weeks = $query_weeks->get()->getResultArray();

        $ddate = date('Y-m-d');
        $duedt = explode("-", $ddate);
        $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
        $week_number  = (int)date('W', $date);

        $week_data = [];
        foreach ($weeks as $week) {
            for ($i=$week_number-7; $i <= $week_number; $i++) { 
                if($week['Name'] != "")
                {
                    $week_data['data'][$week['Name']][] = $week['week'] == $i ? $week['total'] : 0;
                }
            }
        }

        $labels = [];
        for ($i=$week_number-7; $i <= $week_number; $i++) { 
            $labels[] = $i;
        }
        $week_data['label'] = $labels;
        return $week_data;   
    }

    public static function chartDataCampaign(){
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query_weeks = $db->table("QA qa");
        $query_weeks->select('c.Camp_Name, week(`delivered`) as week, IFNULL(AVG(qa.Score),0) as score');
        $query_weeks->join('Call_log cl', "cl.Uniqueid=qa.Uniqueid", 'left');
        $query_weeks->join('Campaign c', "c.Camp_id=cl.Campaign", 'left');
        $query_weeks->Where('week(`delivered`) > week(CURRENT_DATE)-8');
        $query_weeks->Where('qa.Status > 2');
        $query_weeks->Where('qa.Status < 7');
        $query_weeks->groupBy('week(`delivered`),Campaign');
        $weeks = $query_weeks->get()->getResultArray();

        $ddate = date('Y-m-d');
        $duedt = explode("-", $ddate);
        $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
        $week_number  = (int)date('W', $date);

        $week_data = [];
        foreach ($weeks as $week) {
            for ($i=$week_number-7; $i <= $week_number; $i++) { 
                if($week['Camp_Name'] != "")
                {
                    $week_data['data'][$week['Camp_Name']][] = $week['week'] == $i ? $week['score'] : 0;
                }
            }
        }

        $labels = [];
        for ($i=$week_number-7; $i <= $week_number; $i++) { 
            $labels[] = $i;
        }
        $week_data['label'] = $labels;
        return $week_data;   
    }

    public static function filterDataMonthly(){
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query_weeks = $db->table("QA qa");
        $query_weeks->select('CONCAT(u.fname," ",u.lname) as Name, month(`delivered`) as month, count(*) as total');
        $query_weeks->join('tbl_user u', "qa.QAA_id=u.user_id", 'left');
        $query_weeks->Where('week(`delivered`) > week(CURRENT_DATE)-8');
        $query_weeks->groupBy('`QAA_id`,month(`delivered`)');
        $weeks = $query_weeks->get()->getResultArray();

        $week_data = [];
        foreach ($weeks as $week) {
            for ($i=1; $i <= 12; $i++) { 
                if($week['Name'] != "")
                {
                    $week_data['data'][$week['Name']][] = $week['month'] == $i ? $week['total'] : 0;
                }
                
            }
        }

        $labels = [];
        for ($i=1; $i <= 12; $i++) { 
            $labels[] = $i;
        }
        $week_data['label'] = $labels;
        return $week_data;   
    }

    public static function filterDataQuarter(){
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query_weeks = $db->table("QA qa");
        $query_weeks->select('CONCAT(u.fname," ",u.lname) as Name, quarter(`delivered`) as quarter, count(*) as total');
        $query_weeks->join('tbl_user u', "qa.QAA_id=u.user_id", 'left');
        $query_weeks->Where('week(`delivered`) > week(CURRENT_DATE)-8');
        $query_weeks->groupBy('`QAA_id`,quarter(`delivered`)');
        $weeks = $query_weeks->get()->getResultArray();

        $week_data = [];
        foreach ($weeks as $week) {
            for ($i=1; $i <= 4; $i++) { 
                if($week['Name'] != "")
                {
                $week_data['data'][$week['Name']][] = $week['quarter'] == $i ? $week['total'] : 0;
                }
            }
        }

        $labels = [];
        for ($i=1; $i <= 4; $i++) { 
            $labels[] = $i;
        }
        $week_data['label'] = $labels;
        return $week_data;   
    }

    public static function filterDataYTD(){
        $db = \Config\Database::connect(); // Assuming you have a database connection set up
        $query_weeks = $db->table("QA qa");
        $query_weeks->select('CONCAT(u.fname," ",u.lname) as Name, month(`delivered`) as month, count(*) as total');
        $query_weeks->join('tbl_user u', "qa.QAA_id=u.user_id", 'left');
        $query_weeks->Where('week(`delivered`) > week(CURRENT_DATE)-8');
        $query_weeks->groupBy('`QAA_id`,month(`delivered`)');
        $weeks = $query_weeks->get()->getResultArray();

        $week_data = [];
        foreach ($weeks as $week) {
            for ($i=1; $i <= date('m'); $i++) { 
                if($week['Name'] != "")
                {
                $week_data['data'][$week['Name']][] = $week['month'] == $i ? $week['total'] : 0;
                }
            }
        }

        $labels = [];
        for ($i=1; $i <= date('m'); $i++) { 
            $labels[] = $i;
        }
        $week_data['label'] = $labels;
        return $week_data;   
    }

}
