<?php
require_once "functions.php";
# 注册插件
RegisterPlugin("AutoChainLink", "ActivePlugin_AutoChainLink");
// 注册接口函数
function ActivePlugin_AutoChainLink()
{
    //进到首页之后动态获取
    Add_Filter_Plugin('Filter_Plugin_Index_Begin', 'buildMod');
}

// 插件启用时调用
function InstallPlugin_AutoChainLink()
{
    global $zbp;
    // 判断配置项是否存在
    if (!$zbp->HasConfig('AutoChainLink')) {
        $zbp->Config('AutoChainLink')->setting ="{}";
        $zbp->SaveConfig('AutoChainLink');
    }
    //创建模块
    createMod();
}

//创建模块
function createMod()
{
    global $zbp;
    if (!isset($zbp->modulesbyfilename['AutoChainLink'])) {
        $mod = new Module();
        $mod->Name = "自动上链友情链接";
        $mod->FileName = "AutoChainLink";
        $mod->Source = "plugin_AutoChainLink";
        $mod->HtmlID = $mod->FileName;
        $mod->Type = "ul";
//        $mod->MaxLi = 5;
        $mod->Content = '';
        $mod->Save();
    }
}

//动态渲染模块
function buildMod()
{
    global $zbp;
    if ($zbp->HasConfig('AutoChainLink')) {
        $config = $zbp->Config('AutoChainLink');
        //获取系统配置
        $setting = json_decode($config->setting, true);

        //是否开启缓存
        $cache = $setting['cache'];
        //判断是否开启缓存
        if (!is_null($cache) && $cache == 1) {
            $cachedTime = $config->$setting['cachedTime'];
            //判断是否超过了缓存时间
            if ((time() -  $zbp->Config('AutoChainLink')->updateTime) > $cachedTime) {
                if (isset($zbp->modulesbyfilename['AutoChainLink'])) {
                    $mod = $zbp->modulesbyfilename("AutoChainLink");
                    $mod->Content = getModContent();
                    $mod->Save();
                }
            }

        } else {
            if (isset($zbp->modulesbyfilename['AutoChainLink'])) {
                $mod = $zbp->modulesbyfilename("AutoChainLink");
                $mod->Content = getModContent();
                $mod->Save();
            }
        }
    }

}

//获取模块内容
function getModContent()
{
    global $zbp;
    $links=array();
    if ($zbp->HasConfig('AutoChainLink')) {
        //2898
        if ($zbp->Config('AutoChainLink')->HasKey('config_2898')){
            $config_2898=json_decode($zbp->Config('AutoChainLink')->config_2898,true);
            $url="https://auto.link.2898.com/index/Autochain/AutoChainYL?sign=".$config_2898["sign"]."&id=".$config_2898["id"]."&dtype=json&text=false&code=utf-8";
            $res=httpGet($url);
            foreach($res as $value){
                $links["title"][]=$value["reurl_title"];
                $links["url"][]=$value["reurl"];
            }
        }
    }
    //数组去重
    $links=array_unique($links, SORT_REGULAR);
    //遍历数组
    $li='';
    foreach($links as $value){
        $li.='<li><a href="'.$value['url'].'" target="_blank">'.$value['title'].'</a></li>';
    }
    return $li;
}

// 插件关闭时调用
function UninstallPlugin_AutoChainLink()
{
    global $zbp;
    $zbp->DelConfig('AutoChainLink');
}
