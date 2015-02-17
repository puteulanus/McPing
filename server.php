<?php
if (!(json_decode($_GET['servers'],true))){exit;}
// 设定节点列表
$node_list = array(
    'Coding' => 'http://mcping-5f55e.coding.io/node.php');
// 获取节点测速数据
$servers_list = $_GET['servers'];
$reply = array();
foreach($node_list as $n_name => $node){
    $result = json_decode(file_get_contents("{$node}?servers={$servers_list}"),true);
    foreach($result['servers'] as $name => $info){
        $reply[$name][$n_name] = $info;
    }
    $reply['node'][$n_name] = $result['node'];
}
echo json_encode($reply);
