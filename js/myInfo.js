var userName, userEmail, userIntro, userInter, userFavorite, userPic;
var favoriteData = [0, 0, 0, 0, 0];

getUserInfo();
setUserInfo();

function getUserInfo() {
	userName = '<?php echo $username; ?>';
	userEmail = '<?php echo $userEmail; ?>';
	userIntro = '<?php echo $userintro; ?>';
	userInter = '<?php echo $focuType; ?>';
	userFavoriteNum = '<?php echo $favoriteNum; ?>';
	userPic = '<?php echo $userpic; ?>';
	favoriteClassNum = <?php echo $favoriteClassNum; ?>;
	for(var i = 0; i < favoriteClassNum.length; i++) {
		favoriteData[favoriteClassNum[i][0]] = favoriteClassNum[i][1];
	}
}

function setUserInfo() {
	$('input[name=username]').val(userName);
	$('input[name=useremail]').val(userEmail);
	$('textarea[name=userintro]').html(userIntro);
	$('#favoriteNum').html(userFavoriteNum + '条');
	for(var i = 0; i < (userInter.length) - 1; i++) {
		var item = '<span>' + userInter[i] + '</span>';
		$('#inter').append(item);
	}
	$('.infoPic').css('background-image', 'url(' + userPic + ')');
}

chart();

function chart() {
	var myChart1 = echarts.init(document.getElementById('chartLeft'));

	// 指定图表的配置项和数据  
	option1 = {
		title: {
			text: '各分类收藏所占比例：',
			x: 'left'
		},
		tooltip: {
			trigger: 'item',
			formatter: "{a} <br/>{b} : {c} / {d}%"
		},
		series: [{
			name: '收藏条数/占比',
			type: 'pie', //定义为饼状
			radius: '55%',
			center: ['50%', '60%'],
			data: [{
					value: favoriteData[1],
					name: 'Java'
				},
				{
					value: favoriteData[2],
					name: 'Web'
				},
				{
					value: favoriteData[3],
					name: 'Android'
				},
				{
					value: favoriteData[4],
					name: 'PHP'
				}
			],
			itemStyle: {
				emphasis: {
					shadowBlur: 10,
					shadowOffsetX: 0,
					shadowColor: 'rgba(0, 0, 0, 0.5)'
				}
			}
		}]
	};
	// 使用刚指定的配置项和数据显示图表。  
	myChart1.setOption(option1);

	var myChart2 = echarts.init(document.getElementById('chartRight'));
	var options2 = {
		//定义一个标题
		title: {
			text: '关注类中收藏条数：'
		},
		tooltip: {
			trigger: 'axis',
			formatter: "{a} <br/>{b} : {c}"
		},
		//X轴设置
		xAxis: {
			data: ['Java', 'Web', 'Android']
		},
		yAxis: {},
		//name=legend.data的时候才能显示图例
		series: [{
			name: '收藏条数',
			type: 'bar', //定义为坐标系
			data: ['42', '12', '25']
		}]

	};
	myChart2.setOption(options2);
}