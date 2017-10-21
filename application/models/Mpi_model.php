<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mpi_model extends CI_Model
{
  private $DB2;
  private $id;
  private $first_name;
  private $middle_name;
  private $last_name;
  private $sex;
  private $case_number;
  private $birth_date;
  private $address;
  private $city_province;
  private $mpi_table;

  public function __construct()
    {
        parent::__construct();
        $this->id = $this->config->item('id');
        $this->first_name = $this->config->item('first_name');
        $this->middle_name = $this->config->item('middle_name');
        $this->last_name = $this->config->item('last_name');
        $this->sex = $this->config->item('sex');
        $this->case_number = $this->config->item('case_number');
        $this->birth_date = $this->config->item('birth_date');
        $this->address = $this->config->item('address');
        $this->city_province = $this->config->item('city_province');
        $this->mpi_table = $this->config->item('mpi_table');
    }

  public function search_mpi($term)
  {
    $CI = &get_instance();
    $this->DB2= $CI->load->database('mpi', TRUE);
    $select = $this->id.",".$this->last_name.",".$this->first_name.",".$this->middle_name.",".$this->sex.",".$this->case_number.",".$this->birth_date.",".$this->address;
    $this->DB2->select($select);
    $this->DB2->like($this->case_number, $term);
    $this->DB2->or_like($this->first_name, $term);
    $this->DB2->or_like($this->middle_name, $term);
    $this->DB2->or_like($this->last_name, $term);
    $this->DB2->order_by($this->last_name, 'ASC', $this->first_name, 'ASC', $this->middle_name, 'ASC');
    $query = $this->DB2->get($this->mpi_table);
    return $query->result();
  }

  public function get_patient($id)
  {
    $CI = get_instance();
    $this->DB2 = $CI->load->database('mpi', TRUE);
    $select = $this->id.",".$this->last_name.",".$this->first_name.",".$this->middle_name.",".$this->sex.",".$this->case_number.",".$this->birth_date.",".$this->address;
    $this->DB2->select($select);
    $this->DB2->where($this->id, $id);
    $query = $this->DB2->get($this->mpi_table);
    return $query->result();
  }
}
