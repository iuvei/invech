<?php
header('Content-Type:text/html; charset=utf-8');
include ("../mysqli.php");
//auto_7
//新疆时时彩
//$html_data = file_get_contents("http://c.apiplus.net/newly.do?token=8c72e19ff2174223&code=xjssc&format=json");
$html_data = file_get_contents("http://47.90.17.50/caiji/xjssc.php");
$data = json_decode($html_data,true);

$all = array();


foreach ($data['data'] as $k => $v) {

	$qishu = substr($v['expect'], 0,8).substr($v['expect'], 9,2);

	$time = $v['opentime'];
	if(empty($v['opentime'])) continue;
	$code = explode(',', $v['opencode']);if($code[0]=='*')$code[0]='1';
	$num1 = $code[0];
	$num2 = $code[1];
	$num3 = $code[2];
	$num4 = $code[3];
	$num5 = $code[4];

	$one = array($qishu,$time,array($num1,$num2,$num3,$num4,$num5));

	$all[] = $one;
}
//最新一期数据
$qishu = $all[0][0];
$time = $all[0][1];
$num1 = $all[0][2][0];
$num2 = $all[0][2][1];
$num3 = $all[0][2][2];
$num4 = $all[0][2][3];
$num5 = $all[0][2][4];
//print_r($all);

$lottery_type = '新疆时时彩';
$jiesuan ='';
foreach ($all as $k => $v) {
	$sql="select id from c_auto_7 where qishu='".$v[0]."' ";
	$tquery = $mysqli->query($sql);
	$tcou = $mysqli->affected_rows;
	if($tcou==0)
	{
		if($jiesuan) $jiesuan .= ",".$v[0]; else $jiesuan=$v[0];
		if(!preg_match('/[a-zA-Z]+/',$v[0])){
		    $addsql = "insert into weijiesuan (`type`,`qishu`) values ";
		    $addsql .= " ('$lottery_type','{$v[0]}');";
		    $mysqli -> query($addsql);
		}
		$sql = "insert into c_auto_7(qishu,datetime,ball_1,ball_2,ball_3,ball_4,ball_5) values ('".$v[0]."','".$v[1]."','".$v[2][0]."','".$v[2][1]."','".$v[2][2]."','".$v[2][3]."','".$v[2][4]."')";
		$mysqli->query($sql);
	}
}


?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<style type="text/css">
		<!--
		body,td,th {
			font-size: 12px;
		}
		body {
			margin-left: 0px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
		}
		-->
	</style></head>
<body>
<script>
	window.parent.is_open = 1;
</script>
<script>
	<!--
	var limit="31"
	if (document.images){
		var parselimit=limit
	}
	function beginrefresh(){
		if (!document.images)
			return
		if (parselimit==1)
			window.location.reload()
		else{
			parselimit-=1
			curmin=Math.floor(parselimit)
			if (curmin!=0)
				curtime=curmin+"秒后自动获取!"
			else
				curtime=cursec+"秒后自动获取!"
			timeinfo.innerHTML=curtime
			setTimeout("beginrefresh()",1000)
		}
	}
	window.onload=beginrefresh
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left">
			<input type=button name=button value="刷新" onClick="window.location.reload()">
			新疆时时彩<br>
			<?=$qishu?>期:<br>
			<?="$num1,$num2,$num3,$num4,$num5"?><br>
			<span id="timeinfo"></span>
		</td>
	</tr>
</table>
</body>
</html>