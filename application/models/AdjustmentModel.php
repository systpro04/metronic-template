<?php

class AdjustmentModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    public function get_adjustment($group_id, $start, $length, $search, $order_by, $order_dir)
    {
        $this->db->select('uni.inv_id, batch.batch_id, uni.item_code, des.design_name, cat.cat_type, supply.item_size, des.gender_status, uni.quantity, batch.b_remain_qty, batch.batch_code');
        $this->db->from('ebs.uni_inventory uni');
        $this->db->join('ebs.uni_batch batch', 'batch.group_id = uni.group_id AND batch.item_code = uni.item_code', 'inner');
        $this->db->join('ebs.uni_stocksupply_v2 supply', 'supply.item_type = uni.item_type AND supply.item_design = uni.item_design AND supply.item_code = uni.item_code AND supply.item_code = batch.item_code', 'inner');
        $this->db->join('ebs.uni_stockdesign_v2 des', 'des.design_type = uni.item_type AND des.design_id = uni.item_design', 'inner');
        $this->db->join('ebs.uni_stockcategory_v2 cat', 'cat.stock_id = uni.item_type', 'inner');
        $this->db->where('uni.status', 'active');
        $this->db->where('uni.group_id', $group_id);

        if (!empty($search)) {
            $this->buildSearchQuery($search);
        }

        $this->db->order_by($order_by, $order_dir);
        $this->db->limit($length, $start);

        $result = $this->db->get();
        return $result->result_array();
    }

    private function buildSearchQuery($search)
    {
        $this->db->group_start();
        $searchColumns = ['uni.item_code','batch.batch_code'];

        foreach ($searchColumns as $column) {
            $this->db->or_like($column, $search);
        }

        $this->db->group_end();
    }

    public function getTotalRecords($group_id, $search)
    {
        $this->db->from('ebs.uni_inventory uni');
        $this->db->join('ebs.uni_batch batch', 'batch.group_id = uni.group_id AND batch.item_code = uni.item_code', 'inner');
        $this->db->join('ebs.uni_stocksupply_v2 supply', 'supply.item_type = uni.item_type AND supply.item_design = uni.item_design AND supply.item_code = uni.item_code AND supply.item_code = batch.item_code', 'inner');
        $this->db->join('ebs.uni_stockdesign_v2 des', 'des.design_type = uni.item_type AND des.design_id = uni.item_design', 'inner');
        $this->db->join('ebs.uni_stockcategory_v2 cat', 'cat.stock_id = uni.item_type', 'inner');
        $this->db->where('uni.status', 'active');
        $this->db->where('uni.group_id', $group_id);

        if (!empty($search)) {
            $this->buildSearchQuery($search);
        }

        return $this->db->count_all_results();
    }

    public function insert_data($data)
    {
        return $this->db->insert('uni_admin_adjustment', $data);
    }

    public function update_inventory_and_batch_quantity($inv_id, $quantity, $batch_id, $b_remain_qty) 
    {
        $this->db->set('quantity', $quantity, false);
		// $this->db->set('datetime_updated', date('Y-m-d h:i:s'));
        $this->db->where('inv_id', $inv_id);
        $quantity_update = $this->db->update('uni_inventory');
    
        $this->db->set('b_remain_qty', $b_remain_qty, false);
		$this->db->set('datetime_updated', date('Y-m-d h:i:s'));
        $this->db->where('batch_id', $batch_id);
        $batch_update = $this->db->update('uni_batch');
    
        return $quantity_update && $batch_update;
    }
    
    public function get_adjustment_history($group_id, $start, $length, $search, $order_by, $order_dir) 
    {
        $this->db->select('*');
        $this->db->from('uni_admin_adjustment adjust');
        $this->db->where('adjust.adj_new_groupid', $group_id);
        $this->db->order_by($order_by, $order_dir);
        $this->db->limit($length, $start);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('adjust.adj_new_itemcode', $search);
            $this->db->or_like('adjust.adj_new_design_name', $search);
            $this->db->or_like('adjust.adj_new_itemsize', $search);
            $this->db->or_like('adjust.adj_old_quantity', $search);
            $this->db->or_like('adjust.adj_new_quantity', $search);
            $this->db->or_like('adjust.adj_old_batchqty', $search);
            $this->db->or_like('adjust.adj_new_batchqty', $search);
            $this->db->or_like('adjust.adj_new_date', $search);
            $this->db->or_like('adjust.adj_new_status', $search);
            $this->db->group_end();
        }
        $result = $this->db->get();
		return $result->result_array();
    }

    public function updateStatus($data, $adj_new_id)
    {
        $this->db->where('adj_new_id', $adj_new_id);
        return $this->db->update('uni_admin_adjustment', $data);
    }

    public function count_all(){
        $this->db->from('uni_admin_adjustment');
        return $this->db->count_all_results();
    }

    public function count_pending(){
        $this->db->from('uni_admin_adjustment adj');
        $this->db->where('adj.adj_new_status', 'pending');
        return $this->db->count_all_results();
    }
    public function count_approved(){
        $this->db->from('uni_admin_adjustment adj');
        $this->db->where('adj.adj_new_status', 'approved');
        return $this->db->count_all_results();
    }
    public function count_disapproved(){
        $this->db->from('uni_admin_adjustment adj');
        $this->db->where('adj.adj_new_status', 'disapproved');
        return $this->db->count_all_results();
    }
}


