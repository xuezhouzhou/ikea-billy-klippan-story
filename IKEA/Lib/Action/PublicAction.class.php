<?php
class PublicAction extends Action{
	//PO系统登录页
	public function login(){
		$this->display("Index:login");
	}
	
	//生成验证吗 
 	public function verify(){
  	import('@.ORG.Util.Image');
   	Image::buildImageVerify('4','2','png','48','27','verify');
	}
	
	//登陆验证
	public function checkLogin(){
		$username = $_POST['uname'];
		$password = $_POST['pwd'];
		$verify = $_POST['verify'];
		
		if($username==""){
			exit('用户名不能为空！');
		}else if($password==""){
			exit('密码不能为空!');
		}else if($verify==""){
			exit('验证码不能为空!');
		}else if(md5(strtoupper($_POST['verify']))!=$_SESSION['verify']){
			exit('验证码错误!');
		}else{
			$User = M('User');
			$where['username'] = $username;
			$where['password'] = md5($password);
			$res = $User->field('ID,username,password')->where($where)->find();
			//$sql = $User->getLastSql();
			if($res===NULL){
				exit('error');
			}else{
				$_SESSION['is_login'] = "yes";
				$_SESSION['userID'] = $res['ID'];
				$_SESSION['username'] = $res['username'];
				$_SESSION['password'] = $res['password'];
				exit('success');
			}
		}
	}
	
	//清除所有的数据缓存
	public function clearAllCache(){
		$cache  = Cache::getInstance(); 
		$cache ->clear();
		$this->success('数据缓存清除成功',U('Article/index'));
	}
	
	//退出
	public function logOut(){
		session_destroy();
		redirect(__APP__);
	}
}