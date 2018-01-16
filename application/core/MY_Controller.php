<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 扩展业务控制器
 *
 * @package		app
 * @subpackage	Libraries
 * @category	controller
 * @author      yaobin<645894453@qq.com>
 *        
 */
class MY_Controller extends CI_Controller
{

    public function __construct ()
    {
        parent::__construct();
        //初始数据
        $this->cismarty->assign('base_url',base_url());//url路径
		ini_set('date.timezone','Asia/Shanghai');

	    $this->cismarty->assign('rel_name',$this->session->userdata('rel_name'));
	    $this->cismarty->assign('admin_group',$this->session->userdata('admin_group'));
    }

	function _remap($method,$params = array())
	{
		if(! $this->session->userdata('username'))
		{
			if($this->input->is_ajax_request()){
				header('Content-type: text/json');
				echo '{
                        "statusCode":"301",
                        "message":"\u4f1a\u8bdd\u8d85\u65f6\uff0c\u8bf7\u91cd\u65b0\u767b\u5f55\u3002"
                    }';
			}else{
				redirect(site_url('manage_login/login'));
			}

		}else{
			return call_user_func_array(array($this, $method), $params);
		}
	}
    
	//重载smarty方法assign
	public function assign($key,$val) {  
        $this->cismarty->assign($key,$val);  
    }  
    
	//重载smarty方法display
    public function display($html) {
        $this->cismarty->display($html);  
    }
    
    /**
     * 获取产品菜单的树状结构
     **/
    public function subtree($arr,$id=0,$lev=1)
    {
    	static $subs = array();
    	foreach($arr as $v){
    		if((int)$v['parent_id']==$id){
    		    $v['lev'] = $lev;
    		    $subs[]=$v;
    		    $this->subtree($arr,$v['id'],$lev+1);
    		}
    	}
    	return $subs;
    }
    
	
	/**
	 * 提示信息
	 * @param varchar $message 提示信息
	 * @param varchar $url 跳转页面，如果为空则后退
	 * @param int $type 提示类型，1是自动关闭的提示框，2是错误提示框
	 * @return array 显示页码的数组
	 **/
	public function show_message($message,$url=null,$type=1){
		if($url){
			$js = "location.href='".$url."';";
		}else{
			$js = "history.back();";
		}
	
		if($type=='1'){
			echo "<html class='no-js'>
				<head>
				  <meta charset='utf-8'>
				  <title>提示信息</title>
				  <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
				  <link rel='stylesheet' href='/assets/css/amazeui.min.css'>
				  <script src='/assets/js/jquery.min.js'></script>
				  <script src='/assets/js/amazeui.min.js'></script>
				</head>
				<body>
				<div class='am-modal am-modal-loading am-modal-no-btn' tabindex='-1' id='my-modal-loading'>
				  <div class='am-modal-dialog'>
				    <div class='am-modal-hd'>".$message."...</div>
				    <div class='am-modal-bd'>
				      <span class='am-icon-spinner am-icon-spin'></span>
				    </div>
				  </div>
				</div>

				<script>
				var callFn = function(){
				  ".$js."
				};
				$('#my-modal-loading').modal();
				setTimeout(callFn,1200); 
				</script>
				</body>
				</html>";
		}
		exit;
	}
	
	/**************************************************************
	*  生成指定长度的随机码。
	*  @param int $length 随机码的长度。
	*  @access public
	**************************************************************/
	function createRandomCode($length)
	{
		$randomCode = "";
		$randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for ($i = 0; $i < $length; $i++)
		{
			$randomCode .= $randomChars { mt_rand(0, 35) };
		}
		return $randomCode;
	}
	
	/**************************************************************
	*  生成指定长度的随机码。
	*  @param int $length 随机码的长度。
	*  @access public
	**************************************************************/
	function toVirtualPath($physicalPpath)
	{
		$virtualPath = str_replace($_SERVER['DOCUMENT_ROOT'], "", $physicalPpath);
		$virtualPath = str_replace("\\", "/", $virtualPath);
		return $virtualPath;
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */