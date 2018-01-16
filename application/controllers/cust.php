<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台画面控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		yaobin<645894453@qq.com>
 *
 */
class Cust extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('cust_model');
	}

	public function list_cust(){
		$data = $this->cust_model->list_cust();
		$this->load->view('manage/list_material.php',$data);
	}

	public function add_cust(){
		$this->load->view('manage/add_material.php');
	}

	public function save_cust(){
		$rs = $this->cust_model->save_cust();
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_cust");
		} else {
			form_submit_json("300", $rs);
		}
	}

	public function list_cust_dialog(){
		$data = $this->cust_model->list_cust(1);
		$this->load->view('manage/list_cust_dialog.php',$data);
	}



}
