<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Transfers_model extends CI_Model
{
  public function insert_new_transfer($admission_id, $new_location, $current_location, $new_service, $current_service, $date_transfer, $time_transfer)
  {
    $data = array(
      'admission_id'=>$admission_id,
      'target_location'=>$new_location,
      'source_location'=>$current_location,
      'target_service'=>$new_service,
      'source_service'=>$current_service,
      'date_transfer'=>$date_transfer,
      'time_transfer'=>$time_transfer
    );
    $this->db->insert('transfers',$data);
    return $this->db->affected_rows();
  }
  public function get_transfers($admission_id)
  {
    $this->db->where('admission_id', $admission_id);
    $query = $this->db->get('transfers');
    return $query->result();
  }
}
