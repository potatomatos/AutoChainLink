<?php

require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';

$zbp->Load();
header('Content-Type:application/json');
$response = array(
    'code' => 0,
    'msg' => '',
);

$action = 'root';
//校验权限
if (!$zbp->CheckRights($action)) {
    $response['code'] = 5001;
    $response['msg'] = '无权限';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    die();
}
// 插件未启用直接退出本页面
if (!$zbp->CheckPlugin('AutoChainLink')) {
    $response['code'] = 5002;
    $response['msg'] = '插件未启用！';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    die();
}

if (!$zbp->ValidToken(GetVars('token', 'GET'))) {
    $response['code'] = 5003;
    $response['msg'] = '用户未登录';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    die();
}
$type = GetVars('type', 'GET');

$act = GetVars('act', 'GET');
$functionName = "action_" . $act;
if (function_exists($functionName)) {
    $functionName();
} else {
    $response['code'] = 404;
    $response['msg'] = '请求不存在';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

function action_save()
{
    global $zbp;
    global $type;
    $data = GetVars('data', 'POST');
    $jsonData = json_decode($data);
    if ($zbp->HasConfig('AutoChainLink')) {
        $zbp->Config('AutoChainLink')->{'config_' . $type} = $jsonData;
        $zbp->Config('AutoChainLink')->updateTime=time();
        $zbp->SaveConfig('AutoChainLink');
    }
    $response['code'] = 0;
    $response['msg'] = '保存成功';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

function action_save_setting()
{
    global $zbp;
    $data = GetVars('data', 'POST');
    $jsonData = json_decode($data);
    if ($zbp->HasConfig('AutoChainLink')) {
        $zbp->Config('AutoChainLink')->setting = $jsonData;
        $zbp->Config('AutoChainLink')->updateTime=time();
        $zbp->SaveConfig('AutoChainLink');
    }
    $response['code'] = 0;
    $response['msg'] = '保存成功';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

function action_get(){
    global $zbp;
    $response['code'] = 0;
    $response['msg'] = '成功';
    if ($zbp->HasConfig('AutoChainLink')) {
       $response['data']=$zbp->Config('AutoChainLink');
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
