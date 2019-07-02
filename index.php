<style>
	*{font-size:11px;font-family: arial;}
</style>
<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

require_once "fungsi_pisah_waktu.php";
require_once "routeros_api.class.php";

$ipserver = "192.168.88.1";
$username = "admin";
$password = "";

$API = new routeros_api();
$API->debug = false;


if ($API->connect($ipserver, $username, $password))
{
	$IPUser = $API->comm("/ip/hotspot/user/print");
	foreach($IPUser as $row_user){
		$name			 = isset($row_user['name'])?$row_user['name']:"";
		$password		 = isset($row_user['password'])?$row_user['password']:"";
		$profile		 = isset($row_user['profile'])?$row_user['profile']:"";
		$limit_uptime	 = isset($row_user['limit-uptime'])?$row_user['limit-uptime']:"";
		$uptime			 = isset($row_user['uptime'])?$row_user['uptime']:"";
		$comment		 = isset($row_user['comment'])?$row_user['comment']:"";
		if(isset($row_user['limit-uptime'])){
			$session_time_left = time_elapsed_A(get_menit($limit_uptime,'s') - get_menit($uptime,'s'));
			if($session_time_left == 0){
				$session_time_left = "1s";
			}
			echo '/ip hotspot user add name="<b style="color:blue;">'.$name.'</b>" password="'.$password.'" limit-uptime="<b>'.$session_time_left.'</b>" comment="'.$comment.'"<br>';
		} else {
			
			echo '/ip hotspot user add name="<b style="color:blue;">'.$name.'</b>" password="'.$password.'" comment="'.$comment.'"<br>';
		}
	}
}
else
{
	$msg = "Error while connecting to Mikrotik. Check your login configuration.";
	echo $msg;
}
