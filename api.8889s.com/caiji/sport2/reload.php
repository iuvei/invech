<?php
error_reporting(E_ALL);
set_time_limit(0);
$base = dirname(__FILE__);
include_once($base.'/include.php');
$sql = "select * from wangzhi_manage where id=5";
$query = $mysqli->query($sql);
$temprow = $query->fetch_assoc();
$webdb['datesite']		=	$temprow['wangzhi']; //读取为新表wangzhi30
$webdb['user']			=	$temprow['zhanghao']; //读取为新表zhanghao
$webdb['pawd']			=	$temprow['mima']; //读取为新表mima
$curl = new Curl_HTTP_Client();
$curl->store_cookies($cookie_path); 
$curl->set_user_agent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
//$v1='http://180.94.228.140/';
//$v2 = 'http://hg0088.com/';
//$curl->set_proxy_username_password('shanshan','shanshan');
//$curl->set_proxy('119.28.54.165');
//$curl->set_proxy_port('808');

$v1 = $webdb['datesite']; //对应到新表的wangzhi
$v2 = $webdb['datesite']; //对应到新表的wangzhi
$v = 'v'.rand(1,2);
$v = $$v;
$login=array();
$login['username']=$webdb["user"];
$login['password']=$webdb["pawd"];
$login['langx']="zh-tw";
$curl->set_referrer("".$v."");
$html_date=$curl->fetch_url("".$v."/app/member/","",5);
$html_date=$curl->send_post_data("".$v."/app/member/login.php",$login,"",5);
preg_match("/(uid=[\w]+)&/",$html_date,$uid);
$uid = str_replace(array("uid=","&"),array("",""),$uid[0]);
if(strlen($uid)>20  ){
	$cache	= "<?php\r\n";
	$cache .= "\$webdb['cookie']		=	'".$uid."';\r\n";
	$cache .= "\$webdb['datesite']		=	'".$v."';\r\n";
	$cache .= "\$webdb['user']			=	'".$webdb['user']."';\r\n";
	$cache .= "\$webdb['pawd']			=	'".$webdb['pawd']."';\r\n";
	$cache .= "\$webdb['uid']			=	'1';\r\n?>";
	if(!write_file($base."/db.php",$cache)){ //写入缓存失败
		$meg	=	"缓存文件写入失败！请先设db.php文件权限为：0777";
	}
}