<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Weclome</title>
	<meta name="description" content="">
	<meta name="keywords" content="">

	<link href="css/login.css" rel="stylesheet">
	
	<link href="" rel="stylesheet">

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/common.js"></script>

	<style>
		.btn:hover{
		  background-color: #3f3f3f!important;
		}
	</style>
</head>
<body>
	<div id="container">	
		<div class="header">
			<h2>欢迎来到小成成Room</h2>
		</div>	
		
		<div class="box well center">

			<div class="box-alert">
				请输入你的昵称和密码，选择你要显示的头像
			</div>
			
			<div class="box-form">
				<form action="">
					<div class="box-input">
						<span class="add-on">
							<i class="icon-user"></i>
						</span>
						<input type="text" placeholder="请输入你的昵称" id="userName">
					</div>
					<div class="box-input">
						<span class="add-on">
							<i class="icon-lock"></i>
						</span>
						<input type="password" placeholder="请输入你的密码" id="password">
						<p class="tips" id="main_tip"></p>
					</div>

					<div class="box-input">
						<ul class="user-pic clearfix">
							<li>
								<a href="javascript:;" class="current">
									<img src="images/user/user1.gif" alt="" data-value="user1.gif" >
								</a>
							</li>
							<li>
								<a href="javascript:;">
									<img src="images/user/user2.gif" alt="" data-value="user2.gif" >
								</a>
							</li>
							<li>
								<a href="javascript:;" >
									<img src="images/user/user3.gif" alt="" data-value="user3.gif" >
								</a>
							</li>
							<li>
								<a href="javascript:;" >
									<img src="images/user/user4.gif" alt="" data-value="user4.gif" >
								</a>
							</li>
							<li>
								<a href="javascript:;" >
									<img src="images/user/user5.gif" alt="" data-value="user5.gif" >
								</a>
							</li>
							<li>
								<a href="javascript:;" >
									<img src="images/user/user6.gif" alt="" data-value="user6.gif" >
								</a>
							</li>
						</ul>
					</div>

					<div class="box-button center">
						<button type="button" class="btn login-btn" id="login">登录</button>
					</div>
				</form>
			</div>

		</div>
	
	</div>
</body>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".user-pic li > a").click(function() {

				$(".user-pic li > a").removeClass("current");
				$(this).addClass("current");

			})


			$("#login").click(function() {
				var userName = $("#userName").val();
				var password = $("#password").val();
				var pic = $(".user-pic .current>img").attr("data-value");

				if(userName == '') {
					$("#main_tip").text("昵称不能为空！");
					return;
				}

				if(password == '') {
					$("#main_tip").text("密码不能为空！");
					return;
				}

				$.ajax({
					type : "post",
					url : "index.php?func=LoginAction.checkLogin",
					data : {
						'userName' : userName,
						'password' : password,
						'pic' : pic
					},
					dataType:"json",
					success:function(responseText) {
						if(responseText) {
							window.location.href = "index.php?func=ClientAction.showClient";
						} else {
							$("#main_tip").text("密码错误！");
							return;
						}
					}

				})


			})


		})
	
	</script>
</html>