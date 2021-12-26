<?php

function ajaxService()
{
    $act = GetVars('act', 'GET');
    if (isset($act)) {
        header('Content-Type:application/json');
        checkPermission();
        $functionName = "action_" . $act;
        if (function_exists($functionName)) {
            $functionName();
        } else {
            $response = array();
            $response['code'] = 404;
            $response['msg'] = '请求不存在';
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        }
    }
}

/**
 * 校验权限
 */
function checkPermission()
{
    global $zbp;
    $action = 'root';
    $response = array();
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
    //校验token
    if (!$zbp->ValidToken(GetVars('token', 'GET'))) {
        $response['code'] = 5003;
        $response['msg'] = '用户未登录';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
}

/**
 * 保存配置
 */
function action_save()
{
    global $zbp;
    $type = GetVars('type', 'GET');
    $data = GetVars('data', 'POST');
    if ($zbp->HasConfig('AutoChainLink')) {
        $zbp->Config('AutoChainLink')->{'config_' . $type} = $data;
        $zbp->Config('AutoChainLink')->updateTime = time();
        $zbp->SaveConfig('AutoChainLink');
    }
    $response=array();
    $response['code'] = 0;
    $response['msg'] = '保存成功';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

/**
 * 保存系统配置
 */
function action_save_setting()
{
    global $zbp;
    $data = GetVars('data', 'POST');
    if ($zbp->HasConfig('AutoChainLink')) {
        $zbp->Config('AutoChainLink')->setting = $data;
        $zbp->Config('AutoChainLink')->updateTime = time();
        $zbp->SaveConfig('AutoChainLink');
    }
    $response=array();
    $response['code'] = 0;
    $response['msg'] = '保存成功';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}

function action_get_data()
{
    global $zbp;
    $response=array();
    $response['code'] = 0;
    $response['msg'] = '成功';
    if ($zbp->HasConfig('AutoChainLink')) {
        $response['data'] = $zbp->Config('AutoChainLink');
    }
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
