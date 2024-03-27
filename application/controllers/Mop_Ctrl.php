<?php
class Mop_Ctrl extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mop_mod');
        $this->load->database();
    }

    public function mop_view()
    {
        $this->load->view('header');
        $this->load->view('add_mode_of_payment/index');
        $this->load->view('footer');
    }

    public function mopCompanies()
    {

        $companies = $this->Mop_mod->company();
        $result = ['data' => []];

        foreach ($companies as $row) {
            $result['data'][] = [
                $row->company_code,
                $row->acroname,
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function view_mop_access()
    {
        $business_unit = $this->input->post('business_unit');
    
        $list = $this->Mop_mod->mop_list($business_unit);
        $result = ['data' => []];
    
        foreach ($list as $row) {
            $result['data'][] = [
                $row->mop_code,
                $row->mop_name,
                $row->dept_name
            ];
        }
    
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
    

    public function get_departments()
    {

        $company_code   = $this->input->post('bunit_code');
        $bcode          = $this->input->post('bcode');
        $result         = $this->Mop_mod->getDepartments($company_code, $bcode);
        header('Content-Type: application/json');
        echo $result;
    }
    
    public function save_mop_data() {
        $data = array(
            'mop_code' => $this->input->post('mop_code'),
            'mop_name' => $this->input->post('mop_name'),
            'bcode'    => $this->input->post('bcode'),
            'dcode'    => $this->input->post('dcode')
        );
    
        $this->db->insert('ebs.cs_bu_mode_of_payment', $data);
    
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }
    
    public function get_business_units()
    {
        $business_units = $this->Mop_mod->b_unit_filter();
        header('Content-Type: application/json');
        echo json_encode($business_units);
    }
    
}