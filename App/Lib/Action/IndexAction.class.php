<?php
class IndexAction extends Action {
	public function index(){
		$this->display();
	}
	
	//添加故事的处理
	public function addStory(){
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$addr = trim($_POST['addr']);
		$title = trim($_POST['title']);
		$story = trim($_POST['story']);
		$verify = trim($_POST['verify']);
		
		if($name==''){
			exit('请输入姓名！');
		}else if($email==''){
			exit('请输入邮箱！');
		}else if($addr==""){
			exit('请输入居住国！');
		}else if($title==''){
			exit('请输入主题！');	
		}else if($story==''){
			exit('请输入您的故事！');	
		}else if($verify==''){
			exit('请输入验证码！');	
		}else if(!preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z ]+$/u",$name)){
			exit('请查看姓名是否正确！');	
		}else if(!preg_match("/^[A-Za-z0-9-_\.]{1,20}@\w{1,20}(\.\w{1,20}){1,3}$/",$email)){
			exit('请检查邮箱否正确！');
		}else if(md5(strtoupper($verify))!=$_SESSION['verify']){
			exit('验证码错误');
		}else{
			
			//有文件上传的话才调用文件上传类和处理文件上传相关
			if(!empty($_FILES)){
				import('@.ORG.Util.UploadFile');
				$upload = new UploadFile();
				$upload->maxSize  = 1024*1024*2 ;
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
				$upload->savePath =  './Public/Uploads/';
				if(!$upload->upload()) {
					exit($upload->getErrorMsg());
				}else{
					$info =  $upload->getUploadFileInfo();
					$file_names = '';
					foreach($info as $value){
						$file_names .= $value['savename'].',';
					}
					$file_names = substr($file_names,0,-1);
				}
			}else{
				$file_names = '0';
			}
			$story = str_replace(array("\r\n", "\r", "\n"), "<br>", $story);
			$data = array(
				'ID' =>uniqid(),
				'name' =>$name,
				'email' =>$email,
				'addr' =>$addr,
				'title' =>$title,
				'story' =>$story,
				'name' =>$name,
				'file' =>$file_names,
				'add_time' =>time()
			);
			
			$Story = M('Story');
			
			if($Story->add($data)){
				
				import("@.ORG.Util.PHPMailer");
				import("@.ORG.Util.SMTP");
				$mail = new PHPMailer();   
		
				$mail->IsSMTP();// set mailer to use SMTP   
				$mail->Host = C('SMTP_HOST');  // SMTP服务器   
				$mail->CharSet ="utf-8";
				$mail->Port = 25;
				$mail->SMTPAuth = true;     // SMTP认证
				$mail->Username = C('SMTP_USER');  // 用户名   
				$mail->Password = C('SMTP_PASSWORD'); // 密码   
				$mail->From = C('SMTP_EMAIL'); //发件人地址   
				$mail->FromName = C('SMTP_USER');; //发件人   
				$mail->AddAddress(C('STORY_ADMIN_EMAIL')); 
				$mail->WordWrap = 50;              
				$mail->IsHTML(true);      // HTML格式   
				$mail->Subject = '《'.$data['title'].'》- '.$data['name'];
				
				$html = '<p><strong>姓名：</strong>'.$data['name'].'</p>';
				$html .= '<p><strong>邮箱：</strong>'.$data['email'].'</p>';
				$html .= '<p><strong>居住国家：</strong>'.$data['addr'].'</p>';
				$html .= '<p><strong>故事标题：</strong>《'.$data['title'].'》</p>';
				$html .= '<p><strong>内容：</strong></p>';
				$html .= '<div>'.$data['story'].'</div>';
				$mail->Body = $html;
				
				if($file_names != '0'){
					foreach($info as $value){
						$mail->AddAttachment($upload->savePath.$value['savename']);	
					}	
				}
			  $mail->Send();
				exit('success');
			}else{
				$this->error('抱歉，系统繁忙！');	
			}
		}
	}
	
	public function termsAndConditions(){
		$this->display('Index:terms-and-conditions');	
	}
	
	public function privacyPolicy(){
		$this->display('Index:privacy-policy');	
	}
	
	public function termsOfuse(){
		$this->display('Index:terms-of-use');	
	}
	
	
	
}