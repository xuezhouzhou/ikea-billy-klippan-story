<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	public function _initialize() {
		if($_SESSION['is_login']!='yes'){
			redirect(__APP__.'/Public/login');	
		}
	}
	
	public function index(){
		$this->display();
	}
	
	public function storyData(){
		$Story = M('Story');
		$res = $Story->field('ID,name,email,addr,title,add_time,file')->select();
		$storyList = array();
		
		foreach($res as $key => $value){
			$value['add_time'] = date('Y-m-d H:i:s',$value['add_time']);
			if($value['file']=='0'){
				$value['file'] = '<span class="label label-default">无图</span>';
			}else{
				$value['file'] = '<span class="label label-success">有图</span>';
			}
			$path = __APP__.'/Index/storyInfo/?ID='.$value['ID'];
			$value['operation'] = '<a target="story-iframe" class="btn btn-success seemore" href="'.$path.'"><span class="glyphicon glyphicon-search"></span> 查看详细</a>'; 
			$storyList[$key] = $value;
		}
		
		
		echo '{"aaData":'.json_encode($storyList).'}';
	}
	
	public function storyInfo(){
		$ID = $_GET['ID'];
		$Story = M('Story'); 
		$this->storyInfo = $Story->field('name,email,addr,title,add_time,file,story')->find($ID);
		//dump($this->storyInfo);
		$this->display();
	}
	
	public function images(){
		header('Content-type:text/html;charset=utf-8');
		if(empty($_GET['ID'])) exit('Not Access!');
		$ID = $_GET['ID'];
		
		$file_name = $ID;
		$file_dir = './Public/Uploads/';
		$file = fopen($file_dir . $file_name,"r"); // 打开文件
		// 输入文件标签
		Header("Content-type: application/octet-stream");
		Header("Accept-Ranges: bytes");
		Header("Accept-Length: ".filesize($file_dir . $file_name));
		Header("Content-Disposition: attachment; filename=" . $file_name);
		// 输出文件内容
		echo fread($file,filesize($file_dir . $file_name));
		fclose($file);
		exit();
	}
	
	
	
	
	
}