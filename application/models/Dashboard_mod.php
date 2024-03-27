<?php

class Dashboard_mod extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function count_all(){
        $this->db->from('uni_admin_adjustment');
        return $this->db->count_all_results();
    }

    public function count_mop() {
        $this->db->select('COUNT(*) as total_count');
        $this->db->from('cs_bu_mode_of_payment mop');
        $this->db->where('mop.status <>', 'NOT APPLICABLE');
        $this->db->where('mop.mop_code <>', '0');
        $query = $this->db->get();
        return $query->row()->total_count;
    }
    public function count_iad() {
        $this->db->from('ebs.ebm_access_module_2020 as a');
        $this->db->group_by('a.acc_employee');
        return $this->db->count_all_results();
    }
    
}


