layui.use('element', function() {
	var element = layui.element;
});

layui.use('carousel', function() {
	var carousel = layui.carousel;
	//建造实例
	carousel.render({
		elem: '#slider',
		width: '100%',
		height: '500px',
		anim: 'fade',
		arrow: 'hover',
		autoplay: '!true',
		indicator: 'none'
	});
});

//广告图展示
var imgPath = ['img/5.jpg', 'img/6.jpg'];
var img = $('#slider .img');
for(var i = 0; i < img.length; i++) {
	img[i].style.backgroundImage = 'url(' + imgPath[i] + ')';
}

//收藏文章
$('#mainTop').on('click', '#addFavorite', function() {
	var artiId = '<?php echo $articleId; ?>';
	$.ajax({
		async: false,
		type: "post",
		url: "addFavorite.php",
		data: {
			artiId: artiId
		},
		success: function(response, xhr) {
			if(response == 1) {
				alert('收藏成功');
				$('#addFavorite span').html('取消收藏');
				$('#addFavorite').attr('id', 'outFavorite');
			}else if(response == 'unlogin') {
				alert("用户未登录，请登录！");
				window.location.href = 'login.html';
			}
		}
	});
});

//取消收藏
$('#mainTop').on('click', '#outFavorite', function() {
	var artiId = '<?php echo $articleId; ?>';
	$.ajax({
		async: false,
		type: "post",
		url: "outFavorite.php",
		data: {
			artiId: artiId
		},
		success: function(response, xhr) {
			if(response == 1) {
				alert('已取消收藏');
				$('#outFavorite span').html('收藏文章');
				$('#outFavorite').attr('id', 'addFavorite');
			}
		}
	});
});