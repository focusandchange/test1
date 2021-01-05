<?php

session_start();

if(isset($_GET['test'])){

	$_SESSION['uid'] = 1;

}

if (!isset($_SESSION['uid']) ) {

	header('Location:index.php?test=2');

	exit;

}

$uid = $_SESSION['uid'];

require_once '../class/Mysql.php';

$mysql = new MMysql();

$res = $mysql->where(['uid' => $uid])->select('demo47_wx_user');

$nickname = $res[0]['nickname'];

$headimgurl = $res[0]['headimgurl'];

$score = $res[0]['score'];


?>
<!DOCTYPE html>
<html>
<head>
<title>躲避</title>
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, initial-scale=1, user-scalable=no"/>
<style>body{width:100vw;height:100vh;padding:0px;margin:0px;background:url("bg.png") no-repeat 0 0/100% 100%;}#game_area{position:fixed;display:block;left:50%;top:50%;}#img_rotate{position:fixed;display:none;left:50%;top:50%;}canvas{display:block;position:absolute;image-rendering:optimizeSpeed;image-rendering:crisp-edges;image-rendering:-moz-crisp-edges;image-rendering:-webkit-optimize-contrast;image-rendering:optimize-contrast;image-rendering:-o-crisp-edges;cursor:pointer;width:100%;height:100%;}</style>
<!--<script type="text/javascript">
     document.domain = location.host.replace(/^.*?([^.]+\.[^.]+)$/g,'$1');
</script>-->
<!-- <script>document.domain = '4399.com';</script> -->
<!-- <script src="soundjs-0.5.2.min.js"></script> -->
<script src="preloadjs-0.4.1.min.js"></script>
<script src="easeljs-0.7.1.min.js"></script>
<script src="pregame.min.js?test=38"></script>
<!--<script src="keyGamesAPI.js"></script>
<script src="keyGamesAPI-framework.js"></script>
<script src="/html5api/api/keyGamesAPI-game.js"></script>-->
<link type="text/css" rel="stylesheet" href="rankcss.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/template.js?s54"></script>
		<script type="text/javascript" language="javascript" src="https://www.chudaikeji.com/resource/js/wx_share.js?t=1212"></script>
		<style>
			@media all and (orientation : landscape) {
		body{
			display:none;
		}
	}
	@media all and (orientation : portrait){
		body{
			display:default;
		}
	}

	
	
	.animation{
		animation: animation 0.2s linear;
	}
	@keyframes animation
	{
	0 {transform:translateY(0%)}
	10%{transform:translateY(-4%)}
	20%{transform:translateY(4%)}
	30%{transform:translateY(-4%)}
	40%{transform:translateY(4%)}
	50%{transform:translateY(-4%)}
	60%{transform:translateY(4%)}
	70%{transform:translateY(-4%)}
	80%{transform:translateY(4%)}
	90%{transform:translateY(-4%)}
	100% {transform:translateY(0%)}
	}


		</style>
<script>
     function shareLabelTrue(){
          document.getElementById("shareLabel").style.display=""
     }
     function shareLabelFalse(){
          document.getElementById("shareLabel").style.display="none"
     }
     function rankLabelTrue(){
          document.getElementById("RankLabel").style.display=""
     }
     function rankLabelFalse(){
          document.getElementById("RankLabel").style.display="none"
     }
     function shouye(){
		sessionStorage.removeItem("best");
          game.location.Re();
      window_controller.Show("loc");
	  
	  document.getElementById("my_canvas").style.display="";
      document.getElementById("shouye").style.display="none"
     }
     function openRank(){
          $.ajax({
							
							type: "POST",
						
							//url: "https://h5.chudaikeji.com/dongyouji/tests/threegames/game/GameRanking.php?employeeno=ths1001",
						
							url: "https://h5.chudaikeji.com/game/GameRanking.php?gid=47&uid=<?php echo $uid;?>",
						
							async: true,
						
							dataType: "json",
						
							success: function(data) {
								// var rank = data.data;
								// console.log(data)
								// var data = template('rank_for', rank);
								// // var data1 = template('rank_my', rank);
						
								// document.getElementById('rank2').innerHTML = data;
						
								// // document.getElementById('my_ranking').innerHTML = data1;
								var rank = data.data;

var data = template('rank_for', rank);

var data1 = template('rank_my', rank);

document.getElementById('ranking').innerHTML = data;

document.getElementById('my_ranking').innerHTML = data1;
						
							},
						
							error: function(data) {
						
								alert('参数错误');
						
							}
						
						});

          document.getElementById("paihangbang").style.display=""
     }
     function closeRank(){
          document.getElementById("paihangbang").style.display="none"
     }


	function over(score){

var best=sessionStorage.getItem("best")
if(best==null)
{

best=<?php echo $score?$score:0; ?>;
}

if(score>best)
{


sessionStorage.setItem("best", score);	
var uid =<?php echo $uid?$uid:0; ?>;
$.ajax({

type: "POST",

url: "https://h5.chudaikeji.com/game/dosth.php",

data: {

gid: "47",

uid: uid,

update: 1,

score: Number(score),

},

dataType: "json",

success: function(data) {

console.log("data:", data);

},

error: function(data) {

console.log('参数错误');

}

});


}
else{
     sessionStorage.setItem("best", best);	
}

}
function share1(){

document.getElementById("share").style.display="";
}
function share2(){

document.getElementById("share").style.display="none";
}
weixinApi.share.init({
				title: '躲避',
				desc: '好玩到停不下来的游戏，快来挑战把',
				link: 'https://h5.chudaikeji.com/game/demo47_wx_user/',
				imgUrl: 'https://h5.chudaikeji.com/game/demo31/share.png',
			});
			function onunload(){
				sessionStorage.removeItem("best");
} 
function help(){
	document.getElementById("help").style.display=""
}
function help2(){
	document.getElementById("help").style.display="none"
} 
</script>
</head>
<body onload="init();" onunload="onunload()" style="overflow-x:hidden;overflow-y:hidden">
<div id="help" onclick="help2()" style="display:none;position:absolute;z-index:999;width:100%;height:100%;background-color:white;">
			<div style="width:100%;height:100%;display:flex;justify-content:center;align-items:center">
				<div style="margin:2em">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;点击拖动屏幕中的圆形，撞开所有掉落物，保护气球前进,气球被碰到,游戏结束。
				</div>
			</div>
</div>
<img id="share" onclick="share2()"  style="display:none;position:absolute;z-index:110;width:100%;height:100%;" src="https://h5.chudaikeji.com/game/demo31/gfx/share1.png"></img>
     <div onclick="closeRank()" id="paihangbang" style="display: none;position: absolute;z-index: 30;width: 100%;height: 100%;background-color:lightgoldenrodyellow;">
     <div class="rank" style="padding-top:5%">
				<img src="https://h5.chudaikeji.com/game/demo00/img/rank_head.png" class="rank_head" />
				<div class="rank_whole">
					<img onclick="off()" src="https://h5.chudaikeji.com/game/demo00/img/del.png" class="rank_del" id="closeBtn" />
					<div class="rank_title">
						<div class="rank_item">排名</div>
						<div class="rank_item">昵称</div>
						<div class="rank_item">总分</div>
					</div>
					<div class="rank_overflow" id="rankflow">
						<div class="rank_content" id="ranking">
							<script id="rank_for" type="text/<!DOCTYPE html>">
								{{each ranking}}
								<div class="rank_content_for">
									<div class="rank_item rank_number">{{$value.ranking}}</div>
									<div class="rank_item rank_name">
										<img src="{{$value.headimgurl}}" />
										<div class="rank_gh">
											<div style="width:7rem;font-size: 1rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$value.nickname}}</div>
										</div>
									</div>
									<div class="rank_item rank_zf">{{$value.score}}</div>
								</div>
								{{/each}}
							</script>
						</div>
					</div>
				</div>
				<!--自己的排名-->
				<div class="rank_my">
					<div class="rank_content1" id="my_ranking">
						<script id="rank_my" type="text/<!DOCTYPE html>">
							{{each own}}
							<div class="rank_content_my">
								<div class="rank_item rank_number">{{$value.ranking}}</div>
								<div class="rank_item rank_name">
									<img src="{{$value.headimgurl}}" />
									<div class="rank_gh">
										<div style="width:7rem;font-size: 1rem;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$value.nickname}}</div>
									</div>
								</div>
								<div class="rank_item rank_zf">{{$value.score}}</div>
							</div>
							{{/each}}
						</script>
					</div>
				</div>
			</div>
     </div>
     <div id="shouye"  style="position: absolute;z-index:20;background-color: white;width:100%; height:100%">
     <div onclick="shouye()" style="position: absolute;z-index: 21;left:50%;top:50%;transform: translate(-50%,-50%);">开始游戏</div>
	 <div onclick="help()" style="position: absolute;z-index: 21;left:50%;top:55%;transform: translate(-50%,-50%);">游戏说明</div>
	 <div onclick="openRank()" style="position: absolute;z-index: 21;left:50%;top:60%;transform: translate(-50%,-50%);">排行榜</div>
     </div>
     <div onclick="share1()" id="shareLabel" style="display:none;position: absolute;z-index:10;left:50%;top:49%;transform: translate(-50%,-50%);font-size: 1.5em;color:white">Share</div>
     <div onclick="openRank()" id="RankLabel" style="display:none;position: absolute;z-index:10;left:50%;top:54%;transform: translate(-50%,-50%);font-size: 1.5em;color:white">Rank</div>
<div id="game_area">
<canvas id="my_canvas" style="display:none" width="640" height="960" oncontextmenu="return false;"></canvas>
</div>
</body>
</html>