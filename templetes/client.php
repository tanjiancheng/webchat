<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>小成成聊天室</title>
		<meta name="description" content="">
		<meta name="keywords" content="">

		<link href="css/style.css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/common.js"></script>

		<script type="text/javascript">
			var timestamp = 0;
			var userName = '<?php echo $userName?>';
			var ip = '<?php echo $ip; ?>';
			var pic = '<?php echo $pic; ?>';
			var error = false;

			//在线人数信息
			var onlineTimestamp = 0;
			var onlineError = false;

			function connect(){ 
				$.ajax({ 
					data : {
						'timestamp' : timestamp,
						'ip' : ip,
						'userName' : userName
					}, 
					url : 'index.php?func=ServerAction.connect', 
					type : 'get', 
					timeout : 0,
					dataType : "json",
					success : function(data){
						//console.log(data);
						error = false; 
						timestamp = data.timestamp;
						receive_ip = data.ip;
						
						var content = '';
						var	templete = '';

						var picture = "images/user/default.gif";
						//ip == receive_ip ||
						if( userName == data.userName) { 	 //我自己
							picture =  "images/user/"+pic;
							$("#me-picture").attr("src", picture);
							templete = $("#me-content-templete").html();
						} else {				 //其他人
							picture =  "images/user/"+data.pic;
							$("#other-picture").attr("src", picture);
							templete = $("#other-content-templete").html();	
						}

						
						var user = [];
						user['Name'] =  data.userName;
						user['Content'] =  data.msg;
						user['Time'] =  data.currentTime;
						
						content = format(templete, user);	
						$("#chat-content").append(content);
						
						scrollToBottom();			//div的滚动条始终在最下方
					}, 
					error : function(){ 
						error = true; 
						setTimeout(function(){ connect();}, 5000); 
					}, 
					complete : function(){ 
						if (error) {
							 // if a connection problem occurs, try to reconnect each 5 seconds 
							 setTimeout(function(){connect();}, 5000); 
						} else {
							connect(); 
						} 
					} 
				})
			}

			function onlineConnect() {
				$.ajax({ 
					data : {
						'timestamp' : onlineTimestamp,
					}, 
					url : "index.php?func=OnlineAction.connect", 
					type : 'get', 
					timeout : 0,
					dataType : "json",
					success : function(responseText){

						if(responseText != null) {
							onlineTimestamp = responseText.timestamp;
							drawOnline(responseText.online);
						}
						
					}, 
					error : function(){ 
						onlineError = true; 
						setTimeout(function(){ onlineConnect();}, 5000); 
					}, 
					complete : function(){ 
						if (onlineError) {
							 // if a connection problem occurs, try to reconnect each 5 seconds 
							 setTimeout(function(){onlineConnect();}, 5000); 
						} else {
							onlineConnect(); 
						} 
					} 
				})
			}



			function scrollToBottom() {
			   var scrollTop = $("#chat-content")[0].scrollHeight;
			   $("#chat-content").scrollTop(scrollTop);
			}

			function send(msg,ip){
				$.ajax({
					url : 'index.php?func=SendAction.send',
					data : {
						'msg' : msg,
						'ip' : ip,
						'pic' : pic,
						'userName' : userName
					}, 
					type : 'get', 
					dataType : "json",
					success : function(data) {
						
					}
				}) 
			}

			function drawOnline(data) {
				var onlineHtml = '';
				if(data != null) {
					for(var i  in data) {
						var user = data[i];
						onlineHtml += "<div>";
						onlineHtml += '<img src="images/user/'+ user["pic"]+'" class="img">';
						onlineHtml += "<div>"+user["userName"]+"</div>";
						onlineHtml += "</div>";
					}	
				}
					
				$("#online").html(onlineHtml);
			}

			var isClose = true;
			function logout(){
		        $.ajax({
					url : 'index.php?func=OnlineAction.deleteOnlineUser',
					data : {
						'ip' : ip,
						'userName' : userName
					},
					async : false,
					type : 'get', 
					dataType : "json"
				})
			}

			$(window).on('beforeunload', function() {
				if(isClose) {
					logout();
				}
			});


			function checkFirstVisit() {
				var is_reloaded = sessionStorage.getItem("is_reloaded");
				if(is_reloaded) {
					isClose = false;
					alert('Reloaded!')
				} else {
					sessionStorage.setItem("is_reloaded", true);
				}
			 
			}


			document.onkeydown = function(e){
	            var ev = document.all ? window.event : e;
	            if(ev.keyCode==13) {
	                $("#submit").trigger('click');
	                return false;
	            } else if(ev.keyCode==116) {
	            	ev.keyCode=0;
	            	ev.cancelBubble = true;   
	            	ev.returnValue = false;
	            }

	        }

	        document.oncontextmenu = function() {
	        	return false;
	        }

			$(document).ready(function(){ 
				connect();			
				onlineConnect();

				$("#submit").click(function() {
					var msg = $('#word').val();
					send(msg,ip);
					//console.log($("#word").val());
					$("#word").val("").focus();
					return false;
				})

			}) 
		</script> 

	</head>

	<body class="body-blue" onload="checkFirstVisit()">
		
		<div id="container">
			<div id="panelL">
				<div id="header" style="position:relative;">
					<h1 style="position:absolute;bottom:0px;padding:0 10px">小成成聊天室v1.50</h1>
				</div> 
				<div id="chat-content">
					<!-- <div class="other clearfix">
						<span class="other-pic">
							<img src="images/other.gif" alt="">
							<em>游客</em>
						</span>
						<table class="chat-table">
							<tr>
								<td>
									<div class="other-chat-conent">
										465465465465645
									</div>
								</td>
							</tr>
							<tr>
								<td>
									2014-04-26 17:24:43
								</td>
							</tr>
						</table>
					</div>
					<div class="other clearfix">
						<span class="other-pic me-pic">
							<img src="images/other.gif" alt="">
							<em>游客</em>
						</span>
						<table class="chat-table me-table">
							<tr>
								<td>
									<div class="other-chat-conent">
										465465465465645
									</div>
								</td>
							</tr>
							<tr>
								<td>
									2014-04-26 17:24:43
								</td>
							</tr>
						</table>
					</div> -->
				</div>
				<div id="inputP">
					<form action="" method="get" onsubmit="return false;"> 
						<div id="inputPL" class="fixPng"></div>
						<div id="inputPM" style="width: 766px;">
							<textarea rows="" cols="" id="word" name="word"></textarea>
						</div>
						<div id="inputPR" class="fixPng">
							<input type="submit" name="submit" id="submit" value="">
						</div>
					</form>
				</div>
			</div>

			<div id="panelR" class="sidebar">
				<div class="sidebar-header">在线用户</div>
				<div class="sidebar-content" id="online">
					<?php foreach($online as $user): ?>
						<div>
							<img src="images/user/<?php echo $user['pic']; ?>" class="img">
							<div><?php echo $user['userName']?></div>
						</div>
					<?php endforeach; ?>
					<!-- <div>
						<img src="images/user/user1.gif" class="img">
						<div>小成成</div>
					</div>
					<div>
						<img src="images/user/user1.gif" class="img">
						<div>小成成</div>
					</div> -->
				</div>
			</div>

		</div>


		<!-- 其他人聊天信息模板 -->
		<div id="other-content-templete" style="display:none">
			<div class="other clearfix">
				<span class="other-pic">
					<img src="" alt="" id="other-picture" class="img">
					<em>%Name</em>
				</span>
				<table class="chat-table">
					<tr>
						<td>
							<div class="other-chat-conent">
								%Content
							</div>
						</td>
					</tr>
					<tr>
						<td>
							%Time
						</td>
					</tr>
				</table>
			</div> 
		</div>
		<!-- end -->

		<!-- 自己聊天信息模板 -->
		<div id="me-content-templete" style="display:none">
			<div class="other clearfix">
				<span class="other-pic me-pic">
					<img src="" alt="" id="me-picture" class="img">
					<em>%Name</em>
				</span>
				<table class="chat-table me-table">
					<tr>
						<td>
							<div class="other-chat-conent me-chat-conent">
								%Content
							</div>
						</td>
					</tr>
					<tr>
						<td>
							%Time
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- end --> 
		
	</body>
	
</html>