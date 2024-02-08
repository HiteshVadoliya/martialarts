<?php
namespace App\Models;
use CodeIgniter\Model;
class HWTModel extends Model
{
    public static function add_or_update( $table, $wh, $data ) {
		$db = db_connect();
		$builder = $db->table( $table );
		$builder->where( $wh );
		$count = $builder->countAllResults();
		if( $count > 0 ) {
			$builder->where( $wh );
			$res = $builder->update( $data );
		} else {
			$res = $builder->insert( $data );
		}
		return $res;
	}   
    public static function get_data( $table, $wh ) {
        $db = db_connect();
		$builder = $db->table( $table );
		$builder->where( array( $wh) );
		$result = $builder->get()->getResultArray();
		return $result;
	}

	public static function get_row( $table, $wh, $type = 'list' ) {
        $db = db_connect();
        $builder = $db->table($table);
        $builder->where($wh);
        $query = $builder->get();
        if( $type == 'list' ) {
            return $query->getResultArray();
        } else {
            return $query->getRowResult();
        }
    }

	public static function get_schedule_details( $schedule_id ) {

		$wh = array(
			'schedule_id' => $schedule_id,
		);
		$db = db_connect();
        $builder = $db->table( 'schedule s' );
        $builder->where($wh);
        $builder->join( 'weekdays w', 'w.weekdays_id = s.weekday_pid' );
        $builder->join( 'classes_all c', 'c.class_id = s.class_pid' );
        $builder->join( 'school_all sc', 'sc.school_id = s.school_pid' );
        $builder->join( 'tbl_user u', 'u.user_id	 = s.instructor_pid' );
        $query = $builder->get();
        return $query->getRowArray();
		// echo '<pre>';
		// print_r($dd);
		// echo '</pre>';
	}
}
