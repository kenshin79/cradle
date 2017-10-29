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

  public function insert_new_admission($patient_id, $date_in, $time_in, $source, $phic, $initial_service, $current_service, $initial_location, $current_location)
  {
    $data = array(
      'patient_id'=>$patient_id,
      'date_in'=>$date_in,
      'time_in'=>$time_in,
      'source'=>$source,
      'phic'=>$phic,
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
  public function get_active_admissions($location)
  {
    $this->db->select('id, patient_id, date_in, time_in, source, phic, initial_service, current_service, initial_location,current_location, disposition, dispo_date, dispo_time');
    $this->db->where('current_location', $location);
    $this->db->where('disposition', "Admitted");
    $this->db->order_by('date_in', 'ASC');
    $this->db->order_by('time_in', 'ASC');
    $query = $this->db->get('admissions');
    return $query->result();
  }
  public function get_inactive_admissions($location)
  {
    $this->db->select('id, patient_id, date_in, time_in, source, phic, initial_service, current_service, initial_location,current_location, disposition, dispo_date, dispo_time');
    $this->db->where('current_location', $location);
    $this->db->where('disposition<>', "Admitted");
    $this->db->order_by('date_in', 'DESC');
    $this->db->order_by('time_in', 'DESC');
    $query = $this->db->get('admissions');
    return $query->result();
  }
  public function get_admissions(){
    $this->db->select('id, patient_id, date_in, time_in, source, phic, initial_service, current_service, initial_location,current_location, disposition, dispo_date, dispo_time');
    $this->db->order_by('current_location', 'ASC');
    $this->db->order_by('disposition', 'ASC');
    $this->db->order_by('date_in', 'DESC');
    $query = $this->db->get('admissions');
    return $query->result();
  }
  public function get_admission_info($id)
  {
    $this->db->select('id, patient_id, date_in, time_in, source, phic, initial_service, current_service, initial_location,current_location, disposition, dispo_date, dispo_time');
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
  public function update_phic($id, $phic)
  {
    if($phic)
    {
      $phic = 0;
    }
    else
    {
      $phic = 1;
    }
    $this->db->where('id', $id);
    $this->db->update('admissions', array('phic'=>$phic));
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
  public function update_current_location($id, $current_location)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('current_location'=>$current_location));
    return $this->db->affected_rows();
  }
  public function update_initial_service($id, $initial_service)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('initial_service'=>$initial_service));
    return $this->db->affected_rows();
  }
  public function update_current_service($id, $current_service)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('current_service'=>$current_service));
    return $this->db->affected_rows();
  }
  public function update_disposition($id, $disposition, $dispo_date, $dispo_time)
  {
    $this->db->where('id', $id);
    $this->db->update('admissions', array('disposition'=>$disposition, 'dispo_date'=>$dispo_date, 'dispo_time'=>$dispo_time));
    return $this->db->affected_rows();
  }
  public function count_active_admissions($location)
  {
    $this->db->where('current_location', $location);
    $this->db->where('disposition', "Admitted");
    $this->db->from('admissions');
    return $this->db->count_all_results();
  }
  public function count_all_active_admissions()
  {
    $this->db->where('disposition', "Admitted");
    $this->db->from('admissions');
    return $this->db->count_all_results();
  }
  public function get_period_admissions($date_start, $date_end)
  {
    $this->db->select('id, patient_id, date_in, time_in, source, phic, initial_service, current_service, initial_location,current_location, disposition, dispo_date, dispo_time');
    $this->db->where('date_in >=', $date_start);
    $this->db->where('date_in<=', $date_end);
    $this->db->order_by('date_in', 'DESC');
    $this->db->order_by('time_in', 'DESC');
    $query = $this->db->get('admissions');
    return $query->result();
  }
//reports
/*all admissions to specified area and date
ie all admissions to Emergency on 2017-10-24
*/
  public function count_day_admissions($date, $location)
  {
    $this->db->where('initial_location', $location);
    $this->db->where('date_in', $date);
    $query = $this->db->get('admissions');
    return $query->num_rows();

  }
  /*all dispos from area on specified date_in
- ie all admissions with disposition on 2017-10-24 (other than admitted)
  */
  public function count_day_dispo($date, $location )
  {
    $this->db->where('current_location', $location);
    $this->db->where('disposition<>', "Admitted");
    $this->db->where('dispo_date', $date);
    $query = $this->db->get('admissions');
    return $query->num_rows();
  }
/*all admissions to area before specified date still admitted or with dispo but dispo date later than specified date (gross, transfers not deducted)
- all admissions to the Emergency before 2017-10-24 still admitted or with dispo but after 2017-10-24
*/
  public function count_day_active_admissions($date, $location)
  {
    $sql = "SELECT id FROM admissions
            WHERE initial_location = ?
            AND date_in < ?
            AND (disposition = 'Admitted' OR (disposition <> 'Admitted' AND dispo_date >= ?))";
    $query = $this->db->query($sql, array($location, $date, $date));
    return $query->result();
  }

  /*all with both admission and dispo on the same date in specified location

  */
  public function count_day_admit_and_dispo($date, $location)
  {
    $sql = "SELECT id FROM admissions
            WHERE date_in = ? AND initial_location = ?
            AND dispo_date = ? AND disposition <> 'Admitted'";
    $query = $this->db->query($sql, array($date, $location, $date));
    return $query->num_rows();
  }

  public function count_day_admit_and_trans_out($date, $location)
  {
    $sql = "SELECT admissions.id as id FROM admissions, transfers
            WHERE transfers.admission_id = admissions.id
            AND date_in = ? AND initial_location = ?
            AND date_transfer = ? AND source_location = ? AND target_location <> ?";
    $query = $this->db->query($sql, array($date, $location, $date, $location, $location));
    return $query->num_rows();        
  }
/*
  Counts all admission on specified date
*/
  public function count_day_hospital_admissions($date)
  {
    $sql = "SELECT id FROM admissions
            WHERE date_in = ?";
    $query = $this->db->query($sql, array($date));
    return $query->num_rows();
  }
  /*Counts all admissions prior to specified date still admitted or with dispo and dispo date after specified date

  */
  public function count_day_active_hospital_admissions($date)
  {
    $sql = "SELECT id FROM admissions
            WHERE date_in < ?
            AND (disposition = 'Admitted' OR (disposition <> 'Admitted' AND dispo_date >= ?))";
    $query = $this->db->query($sql, array($date, $date));
    return $query->num_rows();
  }

/*
  Count all dispositions on the specified date
*/
  public function count_day_hospital_dispo($date)
  {
    $this->db->where('disposition<>', 'Admitted');
    $this->db->where('dispo_date', $date);
    $query = $this->db->get('admissions');
    return $query->num_rows();
  }

/*
 Count admissions and discharges on same date
*/
  public function count_day_hospital_admission_discharges($date)
  {
    $this->db->where('date_in', $date);
    $this->db->where('disposition<>', 'Admitted');
    $this->db->where('dispo_date', $date);
    $query = $this->db->get('admissions');
    return $query->num_rows();
  }

}
