<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>聊天室</title>
		<meta name="description" content="">
		<meta name="keywords" content="">

		<link href="css/style.css" rel="stylesheet">
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/common.js"></script>

		<script type="text/javascript">
			var timestamp = 0;
			var name = '';
			var ip = '<?php echo $ip; ?>'; 
			var url = 'index.php?func=ServerAction.connect'; 
			var error = false;

			function connect(){ 
				$.ajax({ 
					data : {
						'timestamp' : timestamp,
						'ip' : ip
					}, 
					url : url, 
					type : 'get', 
					timeout : 0,
					dataType : "json",
					success : function(data){ 
						error = false; 
						timestamp = data.timestamp;
						receive_ip = data.ip;
						
						var content = '';
						var	templete = '';

						if(ip == receive_ip) {
							templete = $("#me-content-templete").html();
						} else {
							templete = $("#other-content-templete").html();	
						}

						//console.log(ip);
						//console.log(receive_ip);
						
						var user = [];
						user['Name'] =  '<?php echo $userName?>';
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

			function scrollToBottom() {
			   var scrollTop = $("#chat-content")[0].scrollHeight;
			   $("#chat-content").scrollTop(scrollTop);
			}

			function send(msg,ip){
				$.ajax({
					url : 'index.php?func=SendAction.send',
					data : {
						'msg' : msg,
						'ip' : ip
					}, 
					type : 'get', 
					dataType : "json",
					success : function(data) {
						
					}

				}) 
			}


			document.onkeydown = function(e){
	            var ev = document.all ? window.event : e;
	            if(ev.keyCode==13) {
	                $("#submit").trigger('click');
	                return false;
	            }
	        } 

			$(document).ready(function(){ 
				connect();

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

	<body class="body-blue">
		<div id="container">
			<div id="header" style="position:relative;">
				<h1 style="position:absolute;bottom:0px;padding:0 10px">小成成聊天室v1.00</h1>
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


		<!-- 其他人聊天信息模板 -->
		<div id="other-content-templete" style="display:none">
			<div class="other clearfix">
				<span class="other-pic">
					<img src="images/other.gif" alt="">
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
					<img src="images/user/<?php echo $pic;?>" alt="">
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