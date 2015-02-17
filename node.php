<?php
include_once 'class.inc.php';
// 获取节点信息
header("Content-Type: text/html; charset=UTF-8");
ini_set('user_agent','curl/7.37.1');
$result = explode(' ',file_get_contents('http://ip.cn'));
$node_ip = explode('：',$result[1]);
$node_ip = $node_ip[1];
$node_city = explode('：',$result[2]);
$node_city = $node_city[1];
unset($result);
// 获取MC服务器数据
if (!($servers_list = json_decode($_GET['servers'],true))){exit;}
$reply['node'] = array('ip' => $node_ip,'city' => $node_city);
foreach($servers_list as $name => $url){
    $url = explode(':',$url);
    if (!$url){
        exit;
    }else if($url[1]){
        $server = new MCServerStatus($url[0],$url[1]);
    }else{
        $server = new MCServerStatus($url[0]);
    }
    $reply['servers'][$name] =  ($server->online) ? array(
        'ping' => $server->ping,
        'player'=>$server->online_players,
        'max_players' => $server->max_players,
        'motd' => $server->motd) : false;
}
echo json_encode($reply);
