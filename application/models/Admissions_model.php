<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admissions_model extends CI_Model
{
  public function check_admitted($patient_id)
  {
    $this->db->where('patient_id', $patient_id);
    $this->db->where('disposition', 'Admitted');
    $this->db->from('admissions');
    return $this->db->count_all_results();
  }

  public function insert_new_admission($patient_id, $date_in, $time_in, $source, $initial_service, $current_service, $initial_location, $current_location)
  {
    $data = array(
      'patient_id'=>$patient_id,
      'date_in'=>$date_in,
      'time_in'=>$time_in,
      'source'=>$source,
      'initial_service'=>$initial_service,
      'current_service'=>$current_service,
      'initial_location'=>$initial_location,
      'current_location'=>$current_location,
      'disposition'=>"Admitted"
    );
    if($this->check_admitted($patient_id)==0)
    {
      $this->db->insert('admissions', $data);
    }
    else{
      return false;
    }
    return $this->db->affected_rows();
  }
  public function get_admissions(){
    $this->db->select('id, patient_id, date_in, time_in, source, initial_service, current_service, initial_location,current_location, disposition, dispo_date, dispo_time');
    $this->db->order_by('current_location', 'ASC');
    $this->db->order_by('disposition', 'ASC');
    $this->db->order_by('date_in', 'DESC');
    $query = $this->db->get('admissions');
    return $query->result();
  }
  public function get_admission_info($id)
  {
    $this->db->select('id, patient_id, date_in, time_in, source, initial_service, current_service, initial_location,current_location, disposition, dispo_date, dispo_time');
    $this->db->where('id', $id);
    $query = $this->db->get('admissions');
    return $query->result();
  }
  public function update_admission_transfer($id, $new_location, $new_service)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('current_location'=>$new_location, 'current_service'=>$new_service));
    return $this->db->affected_rows();
  }
  public function update_source($id, $source)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('source'=>$source));
    return $this->db->affected_rows();
  }
  public function update_date_in($id, $date_in)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('date_in'=>$date_in));
    return $this->db->affected_rows();
  }
  public function update_time_in($id, $time_in)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('time_in'=>$time_in));
    return $this->db->affected_rows();
  }
  public function update_initial_location($id, $initial_location)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('initial_location'=>$initial_location));
    return $this->db->affected_rows();
  }
  public function update_initial_service($id, $initial_service)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('initial_service'=>$initial_service));
    return $this->db->affected_rows();
  }
  public function update_disposition($id, $disposition, $dispo_date, $dispo_time)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('disposition'=>$disposition, 'dispo_date'=>$dispo_date, 'dispo_time'=>$dispo_time));
    return $this->db->affected_rows();
  }
}
