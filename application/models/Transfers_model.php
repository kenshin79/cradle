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
    $this->db->order_by('id', 'ASC');
    $query = $this->db->get('transfers');
    return $query->result();
  }
  public function get_transfer_info($id)
  {
    $this->db->where('id', $id);
    $query = $this->db->get('transfers');
    return $query->result();
  }
  public function update_transfer($id, $date_transfer, $time_transfer, $target_location, $target_service)
  {
    $data = array(
      'date_transfer'=>$date_transfer,
      'time_transfer'=>$time_transfer,
      'target_location'=>$target_location,
      'target_service'=>$target_service
    );
    $this->db->where('id', $id);
    $this->db->update('transfers', $data);
    return $this->db->affected_rows();
  }
  public function delete_transfer($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('transfers');
    return $this->db->affected_rows();
  }
}
