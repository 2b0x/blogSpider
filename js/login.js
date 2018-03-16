//获取上一页面的地址
var ref = '';
if(document.referrer.length > 0) {
	ref = document.referrer;
	if(ref.indexOf('register') > 0) {
		ref = 'index.php';
	}
} else {
	ref = 'index.php';
}

//登录按钮事件
$('#login').click(function() {
	var userEmail = $('#userEmail').val();
	var password = $('#password').val();
	$.ajax({
		type: "post",
		url: "checkLogin.php",
		async: false,
		data: {
			userEmail: userEmail,
			password: password
		},
		success: function(response, status, xhr) {
			if(response == 1) {
				alert('登录成功');
				window.location.href = ref;
			} else {
				alert('登录失败，请检查帐号及密码正确性');
			}
		}
	});
});