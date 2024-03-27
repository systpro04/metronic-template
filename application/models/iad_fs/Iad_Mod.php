<?php
class Iad_Mod extends CI_Model
{

  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function emp_mod($emp_id)
  {
    $this->db->where('emp_id', $emp_id);
    $this->db->where('current_status', 'Active');
    $data = $this->db->get('pis.employee3');
    return $data->row_array();
  }

  public function find_employee($search)
  {
      $this->db->select('emp_id, name');
      $this->db->where('current_status', 'Active');
      $this->db->group_start();
      $this->db->like('emp_id', $search);
      $this->db->or_like('name', $search);
      $this->db->group_end();
      $this->db->limit(10);
      $query = $this->db->get('pis.employee3');
      return $query->result();
  }

  public function company()
  {
    $this->db->from('pis.locate_company');
    $query = $this->db->get();
    return $query->result();
  }

  public function b_unit()
  {
    $this->db->from('pis.locate_business_unit');
    $query = $this->db->get();
    return $query->result();

  }
  public function modules()
  {
    $this->db->from('ebs.ebm_modules');
    $query = $this->db->get();
    return $query->result();
  }

  public function user_list()
  {
    $this->db->select('*');
    $this->db->from('ebs.ebm_access_module_2020 as a');
    $this->db->join('pis.employee3', 'a.acc_employee = employee3.emp_id');
    $this->db->group_by('a.acc_employee');
    $query = $this->db->get();
    return $query->result();
  }

  public function details_mod($acc_employee)
  {
    $this->db->select('*');
    $this->db->where('a.acc_employee', $acc_employee);
    $this->db->join('pis.employee3', 'a.acc_employee = employee3.emp_id');
    $this->db->join('ebm_modules as b', 'a.acc_modID = b.mod_id');

    $data = $this->db->get('ebs.ebm_access_module_2020 as a');

    return $data->result_array();
  }

  public function get_update_data($empId)
  {
      $this->db->from('ebs.ebm_access_module_2020 as a');
      $this->db->join('pis.employee3', 'a.acc_employee = employee3.emp_id');
      $this->db->where('a.acc_employee', $empId);
      $query = $this->db->get();
  
      if ($query->num_rows() > 0) {
          $data = $query->row_array();
  
          $add_zero = [];
          $acc_companies = explode(',', $data['acc_company']);
          foreach ($acc_companies as $company) {
              $add_zero[] = str_pad($company, 2, '0', STR_PAD_LEFT);
          }
  
          $data['acc_company'] = $add_zero;
          $data['acc_business_unit'] = explode(',', $data['acc_business_unit']);
  
          $data['acc_modID'] = [];
  
          foreach ($query->result_array() as $row) {
              $data['acc_modID'][] = $row['acc_modID'];
          }
  
          return $data;
      } else {
          return null;
      }
  }
}  