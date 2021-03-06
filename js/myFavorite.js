getFavoriteArticle();
fillFavoriteData(1);
var length = listData.length;
createPage(length);

//填充列表内容
function fillFavoriteData(page) {
	var pageEnd;
	var pageStart = (page - 1) * 10;
	var length = listData.length;
	var isEnd = Math.ceil(length / 10);
	if(page == isEnd) {
		pageEnd = length;
	} else {
		pageEnd = page * 10;
	}
	var types = ['', 'Java', 'Web', 'Android', 'PHP'];
	$('#listContent').html('');
	for(var i = pageStart; i < pageEnd; i++) {
		var list = '<li class="layui-clear"><div class="list-con"><h2><a href="articleDetail.php?random=' + listData[i].artiId + '" target="_bland">' + listData[i].artiTitle + '</a></h2><dl class="list-bar"><dd><span>来源：</span><span>' + listData[i].artiFrom + '</span></dd><dd><span>分类：</span><span>' + listData[i].artiType + '</span></dd><dd>收藏时间：<span>' + listData[i].addTime + '</span></dd></dl><a href="javascript:void(0);" class="unFav" id="outFavorite" data-random="' + listData[i].artiId + '">取消收藏</a></div></li>';
		$('#listContent').append(list);
	}
}

//获取文章内容
function getFavoriteArticle() {
	$.ajax({
		async: false,
		url: "getFavorite.php",
		type: "POST",
		success: function(response, status, xhr) {
			listData = JSON.parse(response);
		}
	});
}

//分页
function createPage(totalPages) {
	var totalPages = totalPages;
	layui.use('laypage', function() {
		var laypage = layui.laypage;
		//执行一个laypage实例
		laypage.render({
			elem: 'page',
			count: totalPages,
			jump: function(obj, first) {
				if(!first) {
					fillFavoriteData(obj.curr);
				}
			}
		});
	});
}

//取消收藏
$('#listContent').on('click', '#outFavorite', function() {
	var artiId = $(this).attr('data-random');
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
				getFavoriteArticle();
				fillFavoriteData(1);
			}
		}
	});
});