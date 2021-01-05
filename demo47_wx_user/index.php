<?php
ini_set('date.timezone','Asia/Shanghai');
session_start();
require_once '../class/Wechat_auth.php';
require_once '../class/Mysql.php';

$wechat = new WechatAuth();
$base_url = 'http://h5.chudaikeji.com/game/demo47_wx_user/';  //'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];	//' 
$sql_name = 'demo47_wx_user';

if (isset($_GET['code'])) {

	$code = $_GET['code'];
	$id = $_GET['state'];
	$token = $wechat->get_access_token($_GET['code']);

	if (!$token['openid']) {
		$url = $wechat->get_authorize_url($base_url . 'index.php', $id);
		header('Location:' . $url);
		exit;
	}
	$user = $wechat->get_user_info($token['access_token'], $token['openid']);
	$nickName = preg_replace('/[\xf0-\xf7].{3}/', '', $user['nickname']);  
	$data = array(
		'openid' => $user['openid'],
		'nickname' => $nickName,
		'utf8name' => utf8_encode($user['nickname']),
		'headimgurl' => $user['headimgurl'],
		'sex' => $user['sex'],
		'province' => $user['province'],
		'city' => $user['city'],
	);
  
	$ids = explode('.', $id);
	$aid = $ids[0];
	// $uid = count($ids) > 1 ? $ids[1] : 0;
	$mysql = new MMysql();
	$res = $mysql->where(array('openid' => $user['openid']))->select($sql_name);
	if (empty($res)) 
	{	
		$_SESSION['uid'] = $mysql->insert($sql_name, $data);
		//if ($uid > 0) {
		//	$mysql->insert('gamble_friend', array('from_id' => $uid, 'to_id' => $_SESSION['uid']));
		//}
	} else {
		if ($res[0]['headimgurl'] != $data['headimgurl'] || $res[0]['utf8name'] != $data['utf8name']) {
			$_SESSION['uid'] = $mysql->where(array('openid' => $user['openid']))->update($sql_name, $data);
		}
		$userid = $res[0]['uid'];
		$_SESSION['uid'] = $userid;
		//if ($uid > 0 && $uid != $res[0]['uid']) {
			//$res = $mysql->where("(from_id=$userid AND to_id=$uid) OR (from_id=$uid AND to_id=$userid)")->select('gamble_friend');
			//if (empty($res)) {
			//	$mysql->insert('gamble_friend', array('from_id' => $uid, 'to_id' => $userid));
			//}
		//}
	}
	header('Location:' . $base_url . 'main.php');
} else {
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$url = $wechat->get_authorize_url($base_url . 'index.php', $id);
	header('Location:' . $url);
}
exit;