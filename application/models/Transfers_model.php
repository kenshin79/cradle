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

    public function with_transfer($admission_id)
    {
      $this->db->where('admission_id', $admission_id);
      $query = $this->db->get('transfers');
      return $query->num_rows();
    }
//reports

/*all transfers in to specified area and date
- ie all admissions on 2017-10-24 in Emergency
*/
  public function count_day_transfers_in($date, $location)
  {
    $sql = "SELECT admission_id FROM transfers
            WHERE source_location <> ?
            AND target_location = ?
            AND date_transfer = ? ";
    $query = $this->db->query($sql, array($location, $location, $date));
    return $query->result();

  }
/*all transfers to area before specified date still admitted or with dispo but dispo date later than specified date (gross, transfers not deducted)
- ie all transfers into Emergency before 2017-10-24 (not coming from Emergency)
*/
    public function count_day_active_transfers($date, $location)
    {
      $sql = "SELECT admission_id, date_transfer FROM transfers, admissions
              WHERE admissions.id = admission_id
              AND source_location <> ?
              AND target_location = ?
              AND date_transfer < ?
              AND (disposition = 'Admitted' OR (disposition <> 'Admitted' AND dispo_date > ?))";
      $query = $this->db->query($sql, array($location, $location, $date, $date));
      return $query->result();
    }
/*check if admission has transfer out of area before specified date
- each of admissions to Emergency before 2017-10-24 checked if with transfer out of Emergency before 2017-10-24
*/
  public function with_trans_out($admission_id, $date, $location)
  {
    $sql = "SELECT id FROM transfers
            WHERE admission_id = ?
            AND date_transfer < ?
            AND source_location = ?
            AND target_location <> ?";
    $query = $this->db->query($sql, array($admission_id, $date, $location, $location));
    return $query->result();
  }
/*check if transfer has subsequent transfer out of area before specified date
- ie check the particular admission of each transfer into Emergency before 2017-10-24 if with trans out to other area
*/
  public function trans_with_trans_out($admission_id, $date_transfer, $date, $location)
  {
    $sql = "SELECT transfers.id as id FROM transfers, admissions
            WHERE admissions.id = admission_id
            AND admission_id = ?
            AND date_transfer >= ?
            AND date_transfer < ?
            AND source_location = ?
            AND target_location <> ?";
    $query = $this->db->query($sql, array($admission_id, $date_transfer, $date, $location, $location));
    return $query->result();
  }
  /*check for trans-outs on the specified date and location
  - ie all transfers out of emergency on 2017-10-24
  */
    public function count_day_transfers_out($date, $location)
    {
      $this->db->where('date_transfer', $date);
      $this->db->where('source_location', $location);
      $this->db->where('target_location<>', $location);
      $query = $this->db->get('transfers');
      return $query->num_rows();
    }
/*check for trans-out from area on same day as admission to the same area

  public function same_day_admit_trans_out($date, $location)
  {
    $sql = "SELECT transfers.id as tid FROM transfers, admissions
            WHERE admissions.id = admission_id
            AND date_in = ?
            AND initial_location = ?
            AND source_location = ?
            AND target_location <> ?
            AND date_transfer = ? ";
    $query = $this->db->query($sql, array($date, $location, $location, $location, $date));
    return $query->result();
  }
*/

/*check for same day transout in an area using admission_id of transfers in same date

*/
  public function same_day_trans_in_and_out($admission_id, $date, $location)
  {
    $sql = "SELECT id FROM transfers
            WHERE admission_id = ?
            AND date_transfer = ? AND source_location = ? AND target_location <> ?";
    $query = $this->db->query($sql, array($admission_id, $date, $location, $location));
    return $query->num_rows();
  }
  public function same_day_trans_in_and_dispo($admission_id, $date, $location)
  {
    $sql = "SELECT admissions.id as id FROM admissions, transfers
            WHERE admission_id = admissions.id
            AND admissions.id = ?
            AND date_transfer = ?
            AND source_location <> ?
            AND target_location = ?
            AND disposition <> 'Admitted'
            AND dispo_date = ?";
    $query = $this->db->query($sql, array($admission_id, $date, $location, $location, $date));
    return $query->num_rows();
  }
}
