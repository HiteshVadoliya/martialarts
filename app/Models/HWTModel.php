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
}
