<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
//用户权限判断
$action = 'root';
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6);
    die();
}
// 插件未启用直接退出本页面
if (!$zbp->CheckPlugin('AutoChainLink')) {
    $zbp->ShowError(48);
    die();
}
$title = '自动上链配置';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<link rel="stylesheet" href="js/layui/css/layui.css">
<script src="js/layui/layui.js"></script>
<script src="js/lay-config.js?v=2.0.0" charset="utf-8"></script>
<div class="divHeader"><?php echo $title; ?></div>
<div class="layuimini-container layuimini-page-anim layui-col-xs12 tableBorder">
	<div class="layui-tab layui-tab-brief" lay-filter="switch">
		<ul class="layui-tab-title">
			<li class="layui-this">站长资源平台</li>
			<li><i class="layui-icon layui-icon-set-fill"></i>设置</li>
			<li><i class="layui-icon layui-icon-help"></i>帮助</li>
		</ul>
		<div class="layui-tab-content layui-col-xs12">
			<div class="layui-tab-item layui-col-xs6 layui-show">
				<form class="layui-form" action="">
					<div class="layui-form-item">
						<label class="layui-form-label">id</label>
						<div class="layui-input-block">
							<input type="text"
							       name="id"
							       lay-verify="required"
							       lay-reqtext="必填项不能为空"
							       placeholder="请输入" autocomplete="off"
							       class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">sign</label>
						<div class="layui-input-block">
							<input type="text"
							       name="sign"
							       lay-verify="required"
							       lay-reqtext="必填项不能为空"
							       placeholder="请输入" autocomplete="off"
							       class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<div class="layui-input-block">
							<button type="submit" class="layui-btn" lay-submit="" lay-filter="save_2898">保存</button>
							<button type="reset" class="layui-btn layui-btn-primary">重置</button>
						</div>
					</div>
				</form>
			</div>
			<div class="layui-tab-item">
				<form class="layui-form" action="">

					<div class="layui-form-item">
						<label class="layui-form-label">开启缓存</label>
						<div class="layui-input-block">
							<input type="checkbox"
							       name="cache"
							       value="1"
							       checked
							       lay-filter="cacheSwitch"
							       lay-skin="switch"
							       lay-text="是|否">
						</div>
					</div>
					<div class="layui-form-item cachedTime">
						<label class="layui-form-label">缓存时间</label>
						<div class="layui-input-inline">
							<input type="number"
							       name="cachedTime"
							       lay-verify="cachedTime"
							       placeholder="请输入" autocomplete="off"
							       value="60000"
							       class="layui-input">
						</div>
						<div class="layui-form-mid layui-word-aux">秒</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label">新页面打开</label>
						<div class="layui-input-block">
							<input type="checkbox"
							       name="blank"
							       value="1"
							       checked
							       lay-filter="blankSwitch"
							       lay-skin="switch"
							       lay-text="是|否">
						</div>
					</div>
					<div class="layui-form-item">
						<div class="layui-input-block">
							<button type="submit" class="layui-btn" lay-submit="" lay-filter="save_setting">保存</button>
						</div>
					</div>
				</form>
			</div>
			<div class="layui-tab-item">
				<a href="action.php?act=get">获取数据</a>
			</div>
		</div>
	</div>
</div>
<script>
    layui.use(['form', 'request'], function () {
        var form = layui.form;
        var $ = layui.$;
        var request = layui.request;
        var layer = layui.layer;
        //2898配置提交
        form.on('submit(save_2898)', function (data) {
            layer.load(2);
            request.post("action.php?act=save&type=2898", {
                data: JSON.stringify(data.field)
            }, function (res) {
                layer.closeAll('loading');
                if (res.code === 0) {
                    layer.msg("保存成功", {icon: 1})
                } else {
                    layer.msg(res.msg, {icon: 2})
                }
            })
            return false;
        });

        //系统配置提交
        form.on('submit(save_setting)', function (data) {
            layer.load(2);
            request.post("action.php?act=save_setting", {
                data: JSON.stringify(data.field)
            }, function (res) {
                layer.closeAll('loading');
                if (res.code === 0) {
                    layer.msg("保存成功", {icon: 1})
                } else {
                    layer.msg(res.msg, {icon: 2})
                }
            })
            return false;
        });


        form.on('switch(cacheSwitch)', function (data) {
            if (this.checked) {
                $(this).val(1);
                $(".cachedTime").show();
            } else {
                $(this).val(0);
                $(".cachedTime").hide();
            }
        });

        form.on('switch(blankSwitch)', function (data) {
            if (this.checked) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });

        //自定义验证规则
        form.verify({
            cachedTime: [/(^[1-9]\d*$)/, '请输入正整数']
        });

    });
</script>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
