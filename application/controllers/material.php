<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 面料管理
 *
 *
 */
class Material extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('material_model');
	}

	public function list_cust(){
		$data = $this->material_model->list_material();
		$this->load->view('material/list_material.php',$data);
	}

	public function add_cust(){
		$this->load->view('material/add_material.php');
	}

	public function save_cust(){
		$rs = $this->material_model->save_material();
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_material");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function list_cust_dialog(){
		$data = $this->cust_model->list_cust(1);
		$this->load->view('manage/list_cust_dialog.php',$data);
	}



}
