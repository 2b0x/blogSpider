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

		var type = 1;
		var listData;
		
		init();

		//初始化数据
		function init(type){
			var type = type;
			getArticle(type,0,0);
			fillData(1, 1);
			var length = listData.length;
			createPage(length);
		}

		//分类切换
		$('#classList li').click(function() {
			var _index = $(this).index();
			type = (_index + 1);
			getArticle(type);
			fillData(type, 1);
			var length = listData.length;
			createPage(length);
		});

		//搜索  
		$('#search').click(function() {
			var search = $('input[name=search]');
			var isNull = search.val().trim().replace(/\s/g, "");
			if(isNull == null || isNull == "" || isNull == ' ') {
				alert('搜索关键字不能为空');
				search.val('');
				search.focus();
			}else {
				var keyword = search.val();
				getArticle(type, 1, keyword);
				fillData(type, 1);
				var length = listData.length;
				createPage(length);
				search.val('');
			}
		});

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
				var list = '<li class="blog-unit"><h3 class="blog-title"><a href="javascript:void(0);" data-href="' + listData[i].id + '">' + listData[i].title + '</a></h3><div class="unit-contorl"><span>来源：</span><span id="from">' + listData[i].from + '</span><span>分类：</span><span id="class">' + types[type] + '</span><span class="unit-con-right"></span></div></li>';
				$('#listContent').append(list);
			}
		}

		//获取文章内容
		function getArticle(type,isSearch,keyword) {
			var type = type;
			var isSearch =isSearch;
			var keyword = keyword;
			$.ajax({
				async: false,
				url: "getArticle.php",
				type: "POST",
				data: {
					type: type,
					isSearch: isSearch,
					keyword: keyword
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
							fillData(type, obj.curr);
						}
					}
				});
			});
		}

		//广告图展示
		var imgPath = ['img/5.jpg', 'img/6.jpg'];
		var img = $('#slider .img');
		for(var i = 0; i < img.length; i++) {
			img[i].style.backgroundImage = 'url(' + imgPath[i] + ')';
		}
		
		
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
//					console.log(response);
					if(response==1){
						var targetUrl = "articleDetail.php?random="+_href;
						window.open(targetUrl,"_blank"); 
					}else{
						console.log(response);
					}
				}
			});
		});