<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Emergency_consults_model extends CI_Model
{
  public function check_active_consult($patient_id)
  {
    $this->db->where('patient_id', $patient_id);
    $this->db->where('disposition', 'Active');
    $this->db->from('emergency_consults');
    return $this->db->count_all_results();
  }

  public function insert_new_consult($patient_id, $date_in, $time_in, $disposition)
  {
    $data = array(
      'patient_id'=>$patient_id,
      'date_in'=>$date_in,
      'time_in'=>$time_in,
      'disposition'=>$disposition
    );
    if($this->check_active_consult($patient_id)==0)
    {
      $this->db->insert('emergency_consults', $data);
    }
    else{
      return false;
    }
    return $this->db->affected_rows();
  }

  public function get_active_consults()
  {
    $this->db->select('id, patient_id, date_in, time_in, disposition');
    $this->db->where('disposition', "Active");
    $this->db->order_by('date_in', 'ASC');
    $this->db->order_by('time_in', 'ASC');
    $query = $this->db->get('emergency_consults');
    return $query->result();
  }

  public function get_period_consults($date_start, $date_end){
    $this->db->select('id, patient_id, date_in, time_in, dispo_date, dispo_time, disposition');
    $this->db->where('date_in >=', $date_start);
    $this->db->where('date_in<=', $date_end);
    $query = $this->db->get('emergency_consults');
    return $query->result();
  }
  public function get_date_in($id)
  {
    $this->db->select('date_in');
    $this->db->where('id', $id);
    $query = $this->db->get('emergency_consults');
    return $query->result();
  }

  public function get_time_in($id)
  {
    $this->db->select('time_in');
    $this->db->where('id', $id);
    $query = $this->db->get('emergency_consults');
    return $query->result();
  }
  public function get_disposition($id)
  {
    $this->db->select('disposition');
    $this->db->where('id', $id);
    $query = $this->db->get('emergency_consults');
    return $query->result();
  }
  public function edit_date_in($id, $date_in)
  {
    $this->db->where('id', $id);
    $this->db->update('emergency_consults', array('date_in'=>$date_in));
    return $this->db->affected_rows();
  }

  public function edit_time_in($id, $time_in)
  {
    $this->db->where('id', $id);
    $this->db->update('emergency_consults', array('time_in'=>$time_in));
    return $this->db->affected_rows();
  }

  public function edit_disposition($id, $disposition, $dispo_date, $dispo_time)
  {
    $this->db->where('id', $id);
    $this->db->update('emergency_consults', array('disposition'=>$disposition, 'dispo_date'=>$dispo_date, 'dispo_time'=>$dispo_time));
    return $this->db->affected_rows();
  }
}