layui.use('form', function() {
	var form = layui.form;
});

var picStatus = 0;

$("#email").blur(function() {
	var ePattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(!ePattern.test($(this).val())) {
		$(this).val("");
		$(this).attr('placeholder', '请输入正确的邮箱');
		$(this).focus();
	}
});

$("#username").blur(function() {
	var uPattern = /^[a-zA-Z0-9\u4e00-\u9fa5]{3,6}$/;
	if(!uPattern.test($(this).val())) {
		$(this).val("");
		$(this).attr('placeholder', '长度为3-6个，且不能包含符号');
		$(this).focus();
	}
});

//		$("#phone").blur(function() {
//			var mPattern = /^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8}$/;
//			if(!mPattern.test($(this).val())) {
//				$(this).val("");
//				$(this).attr('placeholder', '请输入正确的手机格式');
//				$(this).focus();
//			}
//		});

function subCheck() {
	var reqpsw = document.getElementsByName('reqpsw')[0];
	var unique = 0;
	var username = $('#username').val();
	var email = $('#email').val();
	var intro = $('#intro').val();
	var password = $('#password').val();

	var focus = '';
	var fenlei = $('#fenlei .layui-form-checked span');
	if(fenlei.length == 0) {
		alert("请选择要关注的分类");
		return false;
	} else if(fenlei.length > 2) {
		alert("关注分类不得超过两项");
		return false;
	} else {
		for(var i = 0; i < fenlei.length; i++) {
			focus = focus + fenlei[i].innerHTML + '-';
		}
	}

	if(!(password == reqpsw.value)) {
		alert("两次密码输入不一致请检查");
		return false;
	}

	$.ajax({
		async: false,
		type: "post",
		url: "isUnique.php",
		data: {
			email: email
		},
		success: function(response, status, xhr) {
			result = JSON.parse(response);
			unique = result[0];
		}
	});
	if(unique == 1) {
		alert('当前邮箱已被注册，请使用新邮箱！');
		return false;
	}
	if(picStatus == 0) {
		alert('请上传头像！');
		return false;
	}
	var fileObj = document.getElementsByName('photo')[0].files[0];
	var formData = new FormData();
	formData.append('photo', fileObj);
	formData.append('username', username);
	formData.append('email', email);
	formData.append('intro', intro);
	formData.append('focus', focus);
	formData.append('password', password);

	$.ajax({
		async: false,
		type: "post",
		url: "register.php",
		data: formData,
		processData: false,
		contentType: false,
		success: function(response, xhr) {
			if(response == 1) {
				alert("注册成功");
				window.location.href = "login.html";
			} else {
				console.log(response);
			}
		}
	});
}

function imgPreview(fileDom) {
	//判断是否支持FileReader
	if(window.FileReader) {
		var reader = new FileReader();
	} else {
		alert("您的设备不支持图片预览功能，如需该功能请升级您的设备！");
	}

	//获取文件
	var file = fileDom.files[0];
	var imageType = /^image\//;
	//是否是图片
	if(!imageType.test(file.type)) {
		alert("请选择图片！");
		return;
	}
	//读取完成
	reader.onload = function(e) {

		picStatus = 1;

		//获取图片dom
		var imgs = document.getElementById("img");

		//图片路径设置为读取的图片
		imgs.style.backgroundImage = "url(" + e.target.result + ")";
	};
	reader.readAsDataURL(file);
}