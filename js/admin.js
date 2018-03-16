//右侧导航栏
		$('#topNav a').click(function() {
			var _this = $(this);
			var _index = $(this).index();

			_this.siblings().removeClass('active'); //移除所有的active样式
			_this.addClass('active'); //为当前激活对象添加active样式

		});

		var listData = null;
		var classType = 1;

		init(classType);

		//初始化数据
		function init(type) {
			var type = type;
			getArticle(type);
			fillData(1, 1);
			var length = listData.length;
			createPage(length);
		}

		//填充列表内容
		function fillData(type, page) {
			var type = type;
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
				var list = '<li class="blog-unit"><h3 class="blog-title"><a href="javascript:void(0);" data-href="' + listData[i].id + '">' + listData[i].title + '</a></h3><div class="unit-contorl"><span>来源：</span><span id="from">' + listData[i].from + '</span><span>分类：</span><span id="class">' + types[classType] + '</span><span>爬取时间：</span><span id="getTime">' + listData[i].gettime + '</span></div></li>';
				$('#listContent').append(list);
			}
		}

		//获取文章内容
		function getArticle(type) {
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
							fillData(classType, obj.curr);
						}
					}
				});
			});
		}

		//切换文章类型
		$('.classType a').click(function() {
			var _index = $(this).index();
			classType = _index+1;
			listData = null;
			getArticle(classType);
			fillData(classType, 1);
			var length = listData.length;
			createPage(length);
		});
		
		//查看文章详情
		$('#listContent').on('click','a',function(){
			var _href = $(this).attr('data-href');
			$.ajax({
				async:false,
				type:"post",
				url:"getContent.php",
				data:{
					href: _href
				},
				success:function(response,xhr){
					if(response==1){
						var targetUrl = "articleDetail.php?random="+_href;
						window.open(targetUrl,"_blank"); 
					}else{
//						console.log(response);
						console.log(0);
					}
				}
			});
//			console.log(_href);
//			console.log(response);
		});
		
		
		//爬取新文章
		$('#newSpider').click(function(){
			var type = $('.classType a').eq(classType-1).html();
//			console.log(type);
			$.ajax({
				async:true,
				type:"post",
				url:"spider.php",
				data:{
					type:type
				},
				success:function(response,xhr){
//					console.log(JSON.parse(response));
					console.log(response);
				}
			});
		});