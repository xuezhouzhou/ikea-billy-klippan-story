<?php
class PublicAction extends Action{
	//生成验证吗 
 	public function verify(){
  	import('@.ORG.Util.Image');
   	Image::buildImageVerify('4','2','png','48','27','verify');
	}
}