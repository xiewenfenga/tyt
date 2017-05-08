<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width"/>
		<link rel="stylesheet" type="text/css" href="//static.tianyantou.com/css/mobile/reset.css"/>
		<link rel="stylesheet" type="text/css" href="//static.tianyantou.com/css/mobile/defult.css"/>
		
		<title></title>
	</head>
	<body>
		<div class="platform">
			<div class="header">
				<a href="#" onClick="javascript :history.back(-1);"><img src="//static.tianyantou.com/images/mobile/11.png"/></a>
				<p class="plat-title">投资记录提交</p>
			</div>
			<div class="submit">
				<p class="submit-p1">请提交已投资信息</p>
				<p class="submit-p2">*投资成功后请务必保存投资信息（以便追单获得返利）</p>
				<form id="sendInComeGold" method="post" data-toggle="ajaxFormGold">
					{!! csrf_field() !!}
					<ul>
						<li>
							<p>理财平台：</p>
							<input type="text" id="moneyPlat" name="data[moneyPlat]" value="" />
						</li>
						<li>
							<p>投资标期：</p>
							<input type="text" id="investTarget" name="data[investTarget]" value="" />
						</li>
						<li>
							<p>手机号码：</p>
							<input type="text" id="phone" name="data[phone]" value=""  placeholder="请输入手机号码"/>
						</li>
						<li>
							<p>投资金额：</p>
							<input type="text" id="invesetMoney" name="data[invesetMoney]" value="" placeholder="请输入投资金额"/>
						</li>
					</ul>
					<input type="submit" class="btn-blue btn-l btn-submit submit-btn" value="提交">
					<!--<a href="javascript:;" id="submit-gold" class="submit-btn">提交</a>-->
				</form>
			</div>
			<img class="submit-img"  src="//static.tianyantou.com/images/mobile/2win.png"/>
		</div>
		<script src="//static.tianyantou.com/js/mobile/jquery-2.1.3.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="{!! config('app.static_url') !!}/js/lib/jquery.form.min.js"></script>
		<script type="text/javascript">
			$(function() {
				$('form[data-toggle=ajaxFormGold]').ajaxForm({
					delegation: true,
					beforeSubmit: function () {
					},
					success: function(data) {
						if(data.status == 1) {
							alert(data.message);
							setTimeout(function() {
								window.location.href = data.url;
							}, 3000);
						} else {
							alert(data.message);
						}
					},
					error:function(){
						var messageText = '系统繁忙请稍后重试，天眼投客服电话 010-57283503';
						alert(messageText);
					}
				});
			});
		</script>
	</body>
</html>