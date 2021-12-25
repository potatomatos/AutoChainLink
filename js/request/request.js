layui.define([], function (exports) {
    var $ = layui.$;
    var layer = layui.layer;
    var request = {
        get: function (url, data, success, error, loading) {
            if (loading) {
                var index = layer.load(1, {
                    shade: [0.1, '#fff'] //0.1透明度的白色背景
                });
            }
            $.ajax({
                //请求方式
                type: "get",
                //请求地址
                url: url + "?timestamp=" + new Date().getTime(),
                //数据，json字符串
                data: data,
                //请求成功
                success: function (result) {
                    if (loading) {
                        layer.close(index);
                    }
                    if (result.code === 5001 || result.code === 5002||result.code===5003) {
                        layer.msg(result.msg, {
                            icon: 2,
                            shade: this.shade,
                            scrollbar: false,
                            time: 3000,
                            shadeClose: true
                        });
                        return;
                    }
                    success(result);
                },
                //请求失败，包含具体的错误信息
                error: function (xhr, textstatus, thrown) {
                    if (loading) {
                        layer.close(index);
                    }
                    if (error) {
                        error(xhr, textstatus, thrown);
                    } else {
                        layer.msg('服务器发生错误', {icon: 5});
                    }
                }
            })
        },
        syncGet: function (url, data, success, error, loading) {
            if (loading) {
                var index = layer.load(1, {
                    shade: [0.1, '#fff'] //0.1透明度的白色背景
                });
            }

            $.ajax({
                //请求方式
                type: "get",
                //请求地址
                url: url + "?timestamp=" + new Date().getTime(),
                async: false,
                //数据，json字符串
                data: data,
                //请求成功
                success: function (result) {
                    if (result.code === 5001 || result.code === 5002||result.code===5003) {
                        layer.msg(result.msg, {
                            icon: 2,
                            shade: this.shade,
                            scrollbar: false,
                            time: 3000,
                            shadeClose: true
                        });
                        return;
                    }
                    if (loading) {
                        layer.close(index);
                    }
                    success(result);
                },
                //请求失败，包含具体的错误信息
                error: function (xhr, textstatus, thrown) {
                    if (loading) {
                        layer.close(index);
                    }
                    if (error) {
                        error(xhr, textstatus, thrown);
                    } else {
                        layer.msg('服务器发生错误', {icon: 5});
                    }
                }
            })
        },
        post: function (url, data, success, error, loading) {
            if (loading) {
                var index = layer.load(1, {
                    shade: [0.1, '#fff'] //0.1透明度的白色背景
                });
            }
            $.ajax({
                //请求方式
                type: "post",
                //请求地址
                url: url + "?timestamp=" + new Date().getTime(),
                //数据，json字符串
                data: data,
                dataType: "json",
                //请求成功
                success: function (result) {
                    if (loading) {
                        layer.close(index);
                    }
                    if (result.code === 5001 || result.code === 5002||result.code===5003) {
                        layer.msg(result.msg, {
                            icon: 2,
                            shade: this.shade,
                            scrollbar: false,
                            time: 3000,
                            shadeClose: true
                        });
                        return;
                    }
                    success(result);
                },
                //请求失败，包含具体的错误信息
                error: function (xhr, textstatus, thrown) {
                    if (loading) {
                        layer.close(index);
                    }
                    if (error) {
                        error(xhr, textstatus, thrown);
                    } else {
                        layer.msg('服务器发生错误', {icon: 5});
                    }
                }
            })
        },
        syncPost: function (url, data, success, error, loading) {
            if (loading) {
                var index = layer.load(1, {
                    shade: [0.1, '#fff'] //0.1透明度的白色背景
                });
            }
            $.ajax({
                //请求方式
                type: "post",
                //请求地址
                url: url + "?timestamp=" + new Date().getTime(),
                async: false,
                dataType: "json",
                //数据，json字符串
                data: data,
                //请求成功
                success: function (result) {
                    if (loading) {
                        {
                            layer.close(index);
                        }
                    }
                    if (result.code === 5001 || result.code === 5002||result.code===5003) {
                        layer.msg(result.msg, {
                            icon: 2,
                            shade: this.shade,
                            scrollbar: false,
                            time: 3000,
                            shadeClose: true
                        });
                        return;
                    }
                    success(result);
                },
                //请求失败，包含具体的错误信息
                error: function (xhr, textstatus, thrown) {
                    if (loading) {
                        layer.close(index);
                    }
                    if (error) {
                        error(xhr, textstatus, thrown);
                    } else {
                        layer.msg('服务器发生错误', {icon: 5});
                    }
                }
            })
        }
    }
    exports("request", request);
});
