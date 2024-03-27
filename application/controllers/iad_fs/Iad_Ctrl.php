<?php

class Iad_Ctrl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('iad_fs/Iad_Mod', 'iad_mod');
        $this->load->database();
    }
    public function add_access_iad_view()
    {
        $this->load->view('header');
        $this->load->view('iad_fs/add_access');
        $this->load->view('footer');
    }
    public function search() 
    {
        $search = $this->input->get('query', TRUE);
        $employees = $this->iad_mod->find_employee($search);
        $data = [];
    
        foreach ($employees as $employee) {
            $data[] = [
                'emp_id' => $employee->emp_id,
                'name' => $employee->name,
            ];
        }
        echo json_encode($data);
    }
    public function getCompanies() 
    {

        $companies = $this->iad_mod->company();
        $result = ['data' => []];
    
        foreach ($companies as $value) {
            $result['data'][] = [
                'company_code' => $value->company_code,
                'acroname' => $value->acroname,
            ];
        }
    
        echo json_encode($result);
    }

    public function getBunit() 
    {

        $bunit = $this->iad_mod->b_unit();
        $result = ['data' => []];
    
        foreach ($bunit as $value) {
            $result['data'][] = [
                'bcode' => $value->bcode,
                'business_unit' => $value->business_unit,
            ];
        }
    
        echo json_encode($result);
    }

    public function getModules()
    {
        $modules =  $this->iad_mod->modules();
        $result = ['data' => []];

        foreach ( $modules as $module ) {
            $result['data'][] = [
                'mod_id' => $module->mod_id,
                'mod_name' => $module->mod_name,
            ];
        }
        echo json_encode($result);
    }

    public function insertAccess() 
    {
        $empId = $this->input->post('emp_id');
        $moduleIds = $this->input->post('acc_modID');
        $companyIds = $this->input->post('acc_company');
        $businessUnitIds = $this->input->post('acc_business_unit');
    
        $existingAccess = $this->db->get_where('ebm_access_module_2020', array(
            'acc_employee' => $empId,
            'acc_modID' => $moduleIds[0]
        ))->row();

        if ($existingAccess) {
            $response = array('status' => 'error', 'message' => 'Employee already has access.');
        } else {

            $data = array();
            foreach ($moduleIds as $moduleId) {
                $data[] = array(
                    'acc_employee' => $empId,
                    'acc_modID' => $moduleId,
                    'acc_company' => $companyIds,
                    'acc_business_unit' => $businessUnitIds
                );
            }
    
            $this->db->insert_batch('ebm_access_module_2020', $data);
    
            $response = array('status' => 'success', 'message' => 'Access data successfully inserted.');
        }
    
        echo json_encode($response);
    }
    
    public function access_iad()
    {
        $list = $this->iad_mod->user_list();
        $result = ['data' => []];

        foreach ($list as $value) {
            $button = '<a href="#" class="btn btn-sm btn-primary" onclick="view_data(\'' . $value->acc_employee . '\')"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <a href="#" class="btn btn-sm btn-danger" onclick="show_update_data(\'' . $value->acc_employee . '\')"><i class="fa fa-pencil" aria-hidden="true" ></i></a>';

            $result['data'][] = [
                $value->acc_employee,
                $value->name,
                $button

            ];

        }
        echo json_encode($result);
    }
    
    public function view_data()
    {
        $acc_employee = $_POST['acc_employee'];
        $data = $this->iad_mod->details_mod($acc_employee); 
   
        $result =['data' => []];
   
        foreach ($data as $key => $value) 
        {
            $result['data'][] = array($value['name'], $value['mod_name'], $value['acc_company'], $value['acc_business_unit']);
        }
   
        echo json_encode($result);
    }

    public function get_access_data()
    {
        $empId = $this->input->post('emp_id');
        $accessData = $this->iad_mod->get_update_data($empId);
        echo json_encode($accessData);
    }

    public function emp_data()
    {
        $emp_id = $this->input->post('emp_id', TRUE);
        $data = $this->iad_mod->emp_mod($emp_id); 
    
        $result = [
            'emp_id' => $data['emp_id'],
            'name' => $data['name']
        ];
        echo json_encode($result);
    }

    public function get_ebs_module() 
    {
        $emp_id = $this->input->post('emp_id');
        $employeeData = $this->iad_mod->get_update_data($emp_id);
        if ($employeeData !== false) {
            echo json_encode($employeeData);
        }
    }
    
    public function updateAccess() 
    {
        $empId = $this->input->post('acc_employee');
        $moduleIds = $this->input->post('acc_modID');
        $companyIds = $this->input->post('acc_company');
        $businessUnitIds = $this->input->post('acc_business_unit');
    
        if (!empty($moduleIds) && !empty($companyIds) && !empty($businessUnitIds)) {
            $this->db->where('acc_employee', $empId);
            $this->db->delete('ebm_access_module_2020');
    
            foreach ($moduleIds as $moduleId) {
                $this->db->insert('ebm_access_module_2020', array(
                    'acc_employee' => $empId,
                    'acc_modID' => $moduleId,
                    'acc_company' => $companyIds,
                    'acc_business_unit' => $businessUnitIds
                ));
            }

            $response = array('status' => 'success', 'message' => 'Access data successfully updated.');
        } else {
            $response = array('status' => 'error', 'message' => 'No module IDs provided. Access data not updated.');
        }
        echo json_encode($response);
    }
    
}
