$(function(){
	//显示提示框
	function showAlert(tips){
		$('#alert-tips').text(tips);
		$('#alert-box,#body-hover').show();
	}
	
	//提交按钮点击
	$('#btn-send').click(function(){
		var name = $.trim($("#name").val());
		var email = $.trim($("#email").val());
		var addr = $.trim($("#addr").val());
		var	title = $.trim($("#title").val());
		var	story = $.trim($("#story").val());
		var verify = $.trim($("#verify").val());
		
		if(name==''){
			showAlert('请您输入姓名！');
		}else if(email==''){
			showAlert('请您输入邮箱！');
		}else if(addr==''){
			showAlert('请您输入居住国！');
		}else if(title==''){
			showAlert('请您输入主题！');
		}else if(story==''){
			showAlert('请输入您的故事！');
		}else if(verify==''){
			showAlert('请您输入验证码！');
		}else if(!/^[a-zA-Z0-9-_\.]{1,20}@[a-zA-Z0-9-_]{1,20}(\.[a-zA-Z0-9-_]{1,20}){1,3}$/.test(email)){
			showAlert('请您检查邮箱格式是否正确！');
		}else if(!$('#agree-check').is(':checked')){
			showAlert('必须接受条款及细则！');
		}else{
			$_this = $(this);
			$_this.val('提交中...');
			$('#ajax-loader').show();
			$("#story-info-form").ajaxSubmit({
				dataType: 'text',
				success: function(data){
					if(data=='success'){
						$('#tips-success').text('您的信息已经成功提交，感谢您的参与！');
						$('#tips-success').show();
						$('#story-info-form')[0].reset();
						setTimeout(function(){
							$('#tips-success').hide();
							$('#tips-success').text('');
						},5000)
						//showAlert('');  		
					}else{
						showAlert(data);
					}
					$_this.val('提交');
					$('#ajax-loader').hide();
				}
			});
		}
	});	
	
	//图片上传检测后缀名和重复
	$('.img-upload').change(function(){
		var $_this = $(this);
		var fileIndex = ($_this.attr("id")).replace('img','');
		//console.log(index);
		var fileName = $_this.val();
		if(fileName=='') return;
		var fileExt = fileName.substring(fileName.lastIndexOf('.')+1);
		fileExt = fileExt.toLowerCase()
		var extCheck = ['jpg','png','gif','jpeg'];
		//console.log(fileExt);
		if(extCheck.indexOf(fileExt)<0){
			showAlert('仅支持jpg，png，gif，jpeg格式的图片！');
			$_this.val('');
		}else{
			$('input[type="file"]').each(function(index, element) {
				if(fileIndex != (index+1)){
					if($(element).val() == fileName){
						showAlert('上传文件重复');	
						$_this.val('');
					}	
				}
      });
		}
	});
	
	//关闭提示框
	$('#btn-close').click(function(){
		$('#alert-box,#body-hover').hide();
		$('#alert-tips').text('');
	});
	
	//条款细则
	$('a.tkxz').click(function(){
		window.open(APP_PATH+'/Index/termsAndConditions','name','status=no,scrollbars=yes,resize=yes,toolbar=no,height=400,width=350'); 
	});
});
