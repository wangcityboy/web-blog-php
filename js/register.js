//等在网页加载完毕再执行
window.onload = function () {
	code();
	var faceimg = document.getElementById('faceimg');
	if (faceimg != null) {
		faceimg.onclick = function () {
			window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
		}
	}
	
	//表单验证
	var fm = document.getElementsByTagName('form')[0];
	if (fm == undefined) return;
	fm.onsubmit = function () {
		//能用客户端验证的，尽量用客户端
		//JS对于PHP课程来说，选学，并不强制掌握
		//用户名验证
		if (fm.username.value.length < 2 || fm.username.value.length > 20) {
			alert('用户名不得小于2位或者大于20位');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;
		}
		if (/[<>\'\"\ ]/.test(fm.username.value)) {
			alert('用户名不得包含非法字符');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;
		}
		
		//密码验证
		if (fm.password.value.length < 6) {
			alert('密码不得小于6位');
			fm.password.value = ''; //清空
			fm.password.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.password.value != fm.notpassword.value) {
			alert('密码和密码确认必须一致');
			fm.notpassword.value = ''; //清空
			fm.notpassword.focus(); //将焦点以至表单字段
			return false;
		}
		
		//密码提示与回答
		if (fm.question.value.length < 2 || fm.question.value.length > 20) {
			alert('密码提示不得小于2位或者大于20位');
			fm.question.value = ''; //清空
			fm.question.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.answer.value.length < 2 || fm.answer.value.length > 20) {
			alert('密码回答不得小于2位或者大于20位');
			fm.answer.value = ''; //清空
			fm.answer.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.answer.value == fm.question.value) {
			alert('密码提示和密码回答不得相等');
			fm.answer.value = ''; //清空
			fm.answer.focus(); //将焦点以至表单字段
			return false;
		}
		
		//邮箱验证
		if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('邮件格式不正确');
			fm.email.value = ''; //清空
			fm.email.focus(); //将焦点以至表单字段
			return false;
		}
		
		//QQ号码
		if (fm.qq.value != '') {
			if (!/^[1-9]{1}[\d]{4,9}$/.test(fm.qq.value)) {
				alert('QQ号码不正确');
				fm.qq.value = ''; //清空
				fm.qq.focus(); //将焦点以至表单字段
				return false;
			}
		}
		
		//网址
		if (fm.url.value != '') {
			if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('网址不合法');
				fm.url.value = ''; //清空
				fm.url.focus(); //将焦点以至表单字段
				return false;
			}
		}
		
		//验证码验证
		if (fm.code.value.length != 4) {
			alert('验证码必须是4位');
			fm.code.value = ''; //清空
			fm.code.focus(); //将焦点以至表单字段
			return false;
		}
		
		
		return true;
	};
};









