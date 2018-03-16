var type = $('#myInter .layui-this a').html();
var listData;

switch(type) {
	case "Java":
		type = 1;
		break;
	case "Web":
		type = 2;
		break;
	case "Android":
		type = 3;
		break;
	case "PHP":
		type = 4;
		break;
	default:
		break;
}
getInterArticle(type);
fillInterData(1);
var length = listData.length;
createPage(length);
//	init();

//初始化数据
function init(type) {
	var type = type;
	getInterArticle(type);
	fillInterData(1);
	var length = listData.length;
	createPage(length);
}

//填充列表内容
function fillInterData(page) {
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
		var list = '<li class="layui-clear"><div class="list-con"><h2><a href="javascript:void(0);" data-href="' + listData[i].id + '">' + listData[i].title + '</a></h2><dl class="list-bar"><dd><span>来源：</span><span>' + listData[i].from + '</span></dd><dd>分类：<span>' + types[type] + '</span></dd></dl></div></li>';
		$('#listContent').append(list);
	}
}

//获取文章内容
function getInterArticle(type) {
	var type = type;
	$.ajax({
		async: false,
		url: "getArticle.php",
		type: "POST",
		data: {
			type: type
		},
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
			elem: 'page', //注意，这里的 test1 是 ID，不用加 # 号
			count: totalPages, //数据总数，从服务端得到
			jump: function(obj, first) {
				//首次不执行
				if(!first) {
					fillInterData(obj.curr);
				}
			}
		});
	});
}

//点击文章链接
$('#listContent').on('click', 'a', function() {
	console.log(1);
	var _href = $(this).attr('data-href');
	$.ajax({
		async: false,
		type: "post",
		url: "getContent.php",
		data: {
			href: _href
		},
		success: function(response, status, xhr) {
			console.log(xhr);
			if(response == 1) {
				var targetUrl = "articleDetail.php?random=" + _href;
				window.open(targetUrl, "_blank");
			}
		}
	});
});