<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 网站后台模型
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Material_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }

    public function list_material($flag){
        // 每页显示的记录条数，默认20条
        $numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
        $pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;

        //获得总记录数
        $this->db->select('count(1) as num');
        $this->db->from('material');
        if($this->input->post('material_name'))
            $this->db->like('material_name',$this->input->post('material_name'));
        if($flag)
            $this->db->where('flag',1);
        $rs_total = $this->db->get()->row();
        //总记录数
        $data['countPage'] = $rs_total->num;

        $data['material_name'] = $this->input->post('material_name')?$this->input->post('material_name'):null;
        //list
        $this->db->select();
        $this->db->from('material');
        if($this->input->post('material_name'))
            $this->db->like('material_name',$this->input->post('material_name'));
        if($flag)
            $this->db->where('flag',1);
        $this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
        $this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
        $data['res_list'] = $this->db->get()->result();
        $data['pageNum'] = $pageNum;
        $data['numPerPage'] = $numPerPage;
        return $data;
    }

    public function save_material(){
        $data = array(
            'material_name'=>$this->input->post('material_name'),
            'create_date'=>date('Y-m-d H:i:s'),
            'modify_date'=>date('Y-m-d H:i:s'),
            'create_user'=>$this->session->userdata('user_id'),
            'modify_user'=>$this->session->userdata('user_id')
        );
        if(!$this->input->post('material_id')){
            $check = $this->db->select('*')->from('material')->where('material_name',$data['material_name'])->get()->row();
            if($check){
                return -2;
            }
            $rs = $this->db->insert('material',$data);
        }else{
            $check = $this->db->select('*')->from('material')->where(
                array(
                    'material_name'=>$data['material_name'],
                    'id <>'=>$this->input->post('material_id')
                )
            )->get()->row();
            if($check){
                return -2;
            }
            $rs = $this->db->insert('material',$data);
        }

        if($rs)
            return 1;
        else
            return -1;
    }

}
