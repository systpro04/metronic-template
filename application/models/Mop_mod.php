<?php
class Mop_Mod extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  public function dept_add()
  {
    $this->db->select('*');
    $this->db->from('pis.locate_department as d');
    $this->db->join('pis.locate_business_unit as b', 'b.company_code = d.company_code AND b.bunit_code = d.bunit_code');
    $query = $this->db->get();
    return $query->result();

  }
  public function b_unit_filter()
  {

    $this->db->from('ebs.cs_bu_mode_of_payment as mop');
    $this->db->join('pis.locate_business_unit as b', 'b.bcode = mop.bcode');
    $this->db->join('pis.locate_department as d', 'd.dcode = mop.dcode');
    $this->db->group_by('mop.bcode');

    $query = $this->db->get();
    return $query->result();
  }

  public function mop_list($business_unit = null)
  {
    $this->db->select('mop.mop_code, mop.mop_name, d.dept_name');
    $this->db->from('ebs.cs_bu_mode_of_payment as mop');
    $this->db->join('pis.locate_business_unit as b', 'b.bcode = mop.bcode');
    $this->db->join('pis.locate_department as d', 'd.dcode = mop.dcode');

    $this->db->where('mop.status <> ', 'NOT APPLICABLE');
    $this->db->order_by('d.dept_name', 'asc');

    if ($business_unit) {
      $this->db->where('b.bcode', $business_unit);
      $this->db->group_by('mop.mop_code, mop.mop_name, d.dept_name');
      $this->db->order_by('d.dept_name', 'asc');

    }

    $query = $this->db->get();
    return $query->result();
  }
  public function getDepartments($companyCode, $businessUnitCode)
  {

    $this->db->select('*');
    $this->db->from('pis.locate_company');
    $this->db->where('status <>', 'inactive');
    $this->db->order_by('company', 'asc');
    $query = $this->db->get();
    $companies = $query->result();

    $htmlCompany = '';
    foreach ($companies as $company) {
      $htmlCompany .= '<option value="' . $company->company_code . '">' . $company->company . '</option>';
    }

    $this->db->select('*');
    $this->db->from('pis.locate_business_unit');
    $this->db->where('status <>', 'inactive');
    $this->db->order_by('business_unit', 'asc');
    $this->db->where('company_code', $companyCode);
    $query = $this->db->get();
    $businessUnits = $query->result();

    $htmlBcode = '';
    foreach ($businessUnits as $businessUnit) {
      $htmlBcode .= '<option value="' . $businessUnit->bcode . '">' . $businessUnit->business_unit . '</option>';
    }

    $this->db->select('*');
    $this->db->from('pis.locate_department');
    $this->db->join('pis.locate_business_unit', 'CONCAT(locate_department.company_code, locate_department.bunit_code) = CONCAT(locate_business_unit.company_code, locate_business_unit.bunit_code)');
    $this->db->where('locate_business_unit.company_code', $companyCode);
    $this->db->where('locate_business_unit.bcode', $businessUnitCode);
    $this->db->order_by('locate_department.dept_name', 'asc');
    $query = $this->db->get();
    $departments = $query->result();

    $htmlDepartment = '';
    foreach ($departments as $department) {
      $htmlDepartment .= '<option value="' . $department->dcode . '">' . $department->dept_name . '</option>';
    }

    return json_encode(
      array(
        'companyOptions' => $htmlCompany,
        'bcodeOptions' => $htmlBcode,
        'departmentOptions' => $htmlDepartment
      )
    );
  }
}