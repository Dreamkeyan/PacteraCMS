/**
 * javascript文件
 * author: 雨巷
 * mailto: 365879415@qq.com
 * date: 2016-08-31
 */
var common = {
    init: function () {},
    n1: 0,
    n2: 0,
    /*一级菜单代码*/
    get_html: function (n, v) {
        var html = '<div class="custom_menu_list_group ho" data-id="'+ n +'">\
                    <div class="custom_menu_list cm_name js_li">\
                    <a href="javascript:;" class="fa fa-trash-o pull-right js_menu_remove"></a>\
                    <a href="javascript:;" class="btn btn-link btn_inList pull-right js_link">跳转到网页</a>\
                    <a href="javascript:;" data-text="" class="btn btn-link btn_inList pull-right js_choose">发送信息</a>\
                    <span class="fa fa-caret-down"></span>\
                    <span class="custom_menu_name ">' + v + '</span>\
                    <a href="javascript:;" class="fa fa-pencil js_change_name"></a>\
                    <input type="text" maxlength="8" autofocus="true" value="' + v + '" class="form-control width-360 custom_menu_input js_add_1_menu">\
                    <span class="custom_menu_notice">一级菜单名称不多于4个汉字或8个字母，超出部分自动截断。</span>\
                    </div>\
                    <div class="custom_menu_list cm_subname js_add_second">\
                    <span class="custom_menu_addName gray"><i class="fa fa-plus"></i>添加二级菜单</span>\
                    <input type="text" placeholder="二级菜单名称不多于8个汉字或16个字母" autofocus="true" maxlength="16" class="form-control width-360 custom_menu_input js_add_2_menu">\
                    <span class="custom_menu_notice">二级菜单名称不多于8个汉字或16个字母，超出部分自动截断。</span>\
                    </div>\
                    </div>';
        return html;
    },
    get_html2: function (n1, n2, v) {
        var html = '<div class="custom_menu_second_list_group ho" data-id="'+ n1 + '-' + n2 +'">\
                    <div class="custom_menu_list cm_subname js_li">\
                    <a href="javascript:;" class="fa fa-trash-o pull-right js_menu_remove2"></a>\
                    <a href="javascript:;" class="btn btn-link btn_inList pull-right js_link">跳转到网页</a>\
                    <a href="javascript:;" data-text="" class="btn btn-link btn_inList pull-right js_choose">发送信息</a>\
                    <span class="custom_menu_name ">' + v + '</span>\
                    <a href="javascript:;" class="fa fa-pencil js_change_name2"></a>\
                    <input type="text" maxlength="16" autofocus="true" value="' + v + '" class="form-control width-360 custom_menu_input js_add_3_menu">\
                    <span class="custom_menu_notice">二级菜单名称不多于8个汉字或16个字母，超出部分自动截断。</span>\
                    </div>\
                    </div>';
        return html;
    },
    /*添加一级菜单*/
    show_add_menu: function () {
        var _self = this;
        $('.js_add_menu').on('click', function () {
            $('.js_input_menu').removeClass('hide');
            $('.js_input_menu').find('input').focus();
        });
    },
    add_menu: function (obj) {
        var _self = this;
        var val = $(obj).val();
        if (val != '') {
            $(obj).parent().before(_self.get_html(_self.n1, val));
            _self.n1++;
            $(obj).val('');
            $('.js_change_name').unbind('click');
            _self.show_edit_menu();
            $('.js_menu_remove').unbind('click');
            _self.del_menu();
            $('.js_add_second').unbind('click');
            _self.show_add_menu_second();
            $('.js_link').unbind('click');
            _self.open_webpage('');
            $('.js_choose').unbind('click');
            _self.send_message();
            if (_self.n1 > 2) {
                $('.js_add_menu').attr('disabled', 'disabled');
            }
        }
        $(obj).parent().addClass('hide');
    },
    blur_add_menu: function () {
        var _self = this;
        $('.js_input_menu > input').blur(function () {
            _self.add_menu(this);
        });
    },
    keydown_add_menu: function () {
        var _self = this;
        $('.js_input_menu > input').keydown(function (e) {
            if (e.which == 13) {
                _self.add_menu(this);
            }
        });
    },
    /*一级菜单编辑*/
    show_edit_menu: function () {
        var _self = this;
        $('.js_change_name').on('click', function () {
            $(this).parent().addClass('editing');
            $('.js_add_1_menu').focus();
            _self.blur_edit_menu();
            _self.keydown_edit_menu();
        })
    },
    edit_menu: function (obj) {
        var _self = this;
        var v = $(obj).val();
        if (v == '') {
            layer.alert('菜单名称不能为空', {icon: 4});
            return;
        }
        $(obj).parent().find('.custom_menu_name').html(v);
        $(obj).parent().removeClass('editing');
    },
    blur_edit_menu: function () {
        var _self = this;
        $('.js_add_1_menu').blur(function () {
            _self.edit_menu(this);
        });
    },
    keydown_edit_menu: function () {
        var _self = this;
        $('.js_add_1_menu').keydown(function (e) {
            if (e.which == 13) {
                _self.edit_menu(this);
            }
        });
    },
    /*一级菜单删除*/
    del_menu: function () {
        var _self = this;
        $('.js_menu_remove').on('click', function () {
            $(this).parent().parent().remove();
            _self.n1--;
            $('.js_add_menu').removeAttr('disabled');
        });
    },

    /*添加二级菜单*/
    show_add_menu_second: function () {
        var _self = this;
        $('.js_add_second').find('.custom_menu_addName').on('click', function () {
            $(this).parent().addClass('editing');
            $('.js_add_2_menu').focus();
            _self.keydown_add_menu_second();
            _self.blur_add_menu_second();
        });
    },
    add_menu_second: function (obj) {
        var _self = this;
        var v = $(obj).val();
        $(obj).parent().removeClass('editing');
        if (v != '') {
            var n1 = $(obj).parent().parent().attr('data-id');
            $(obj).parent().before(_self.get_html2(n1, _self.n2, v));
            _self.n2++;
            $(obj).val('');
            $(obj).parent().parent().find('.cm_name').find('.btn_inList').hide();
           $('.js_change_name2').unbind('click');
            _self.show_edit_menu_second();
            $('.js_menu_remove2').unbind('click');
            _self.del_menu_second();
            $('.js_link').unbind('click');
            _self.open_webpage('');
            $('.js_choose').unbind('click');
            _self.send_message();

            if (_self.n2 > 4) {
                $(obj).parent().addClass('hide');
            }
        }

    },
    keydown_add_menu_second: function () {
        var _self = this;
        $('.js_add_2_menu').keydown(function (e) {
            if (e.which == 13) {
                _self.add_menu_second(this);
            }
        });
    },
    blur_add_menu_second: function () {
        var _self = this;
        $('.js_add_2_menu').blur(function () {
            _self.add_menu_second(this);
        });
    },
    /*二级菜单编辑*/
    show_edit_menu_second: function () {
        var _self = this;
        $('.js_change_name2').on('click', function () {
            $(this).parent().addClass('editing');
            $('.js_add_3_menu').focus();
            _self.blur_edit_menu_second();
            _self.keydown_edit_menu_second();
        })
    },
    edit_menu_second: function (obj) {
        var _self = this;
        var v = $(obj).val();
        if (v == '') {
            layer.alert('菜单名称不能为空', {icon: 4});
            return;
        }
        $(obj).parent().find('.custom_menu_name').html(v);
        $(obj).parent().removeClass('editing');
    },
    blur_edit_menu_second: function () {
        var _self = this;
        $('.js_add_3_menu').blur(function () {
            _self.edit_menu_second(this);
        });
    },
    keydown_edit_menu_second: function () {
        var _self = this;
        $('.js_add_3_menu').keydown(function (e) {
            if (e.which == 13) {
                _self.edit_menu_second(this);
            }
        });
    },
    /*二级菜单删除*/
    del_menu_second: function () {
        var _self = this;
        $('.js_menu_remove2').on('click', function () {
            $(this).parent().parent().parent().find('.js_add_second').removeClass('hide');
            _self.n2--;
            if (_self.n2 == 0) {
                $(this).parent().parent().parent().find('.cm_name').find('.btn_inList').show();
            }
            $(this).parent().parent().remove();
        });
    },
    /*layer弹窗*/
    layer_boxs: function (_type, _t, _area, _html, _btn, _func, _me) {
        var _self = this;
        var index = layer.open({
            type: _type,
            title: _t,
            skin: 'layui-layer-me', //样式类名
            area: _area,
            shift: 0,
            shade: 0.6,
            maxmin: true, //开启最大化最小化按钮
            content: _html,
            btn: _btn,
            yes: function(index, layero){
                /*确定按钮回调事件*/
                _func(index, _self, _me);
            },
            btn2: function(index, layero){
                //取消按钮的回调事件，默认关闭弹窗
            }
        });
    },
    /*跳转到网页*/
    uh: function (val) {
        return '<div class="clearfix margin-30">\
                <form  id="commentForm">\
                <div class="form-group">\
                <label for="enterpriseUrl">URL</label><span class="text-warning">*成员点击该菜单会跳到以下链接</span>\
                <input type="text" id="enterpriseUrl" class="form-control input-text" placeholder="以http://或https://开头" name="url" value="' + val + '">\
                </div>\
                </form>\
                </div>';
    },
    open_webpage: function (val) {
        var _self = this;
        $('.js_link').on('click', function () {
            var me = this;
            _self.layer_boxs(1, '设置菜单跳转链接', '600px', _self.uh(val), ['确定', '取消'], _self.open_webpage_func, me);
        });
    },
    open_webpage_func: function (index, obj, me) {
        var _self = obj;
        if (_self.url_validate().form()) {
            //通过表单验证，以下编写自己的代码
            $(me).parent().children('.btn_inList').hide();
            if ($(me).parent().hasClass('cm_name')) {
                $(me).parent().parent().children('.cm_subname').hide();
            }
            var val = $('.input-text').val();
            $(me).parent().after('<div class="custom_menuList_content ho"><div class="custom_menuLlist_content_word"><input type="text" value="' + val + '" class="form-control width-360 pull-left" disabled><a href="javascript:;" class="btn btn-default pull-left margin-l-10 js_modify">修改</a></div></div>');
            _self.modify_webpage();
            layer.close(index);
        } else {
            //校验不通过，什么都不用做，校验信息已经正常显示在表单上
        }
    },
    modify_webpage: function () {
        var _self = this;
        $('.js_modify').on('click', function () {
            var me = this;
            var val = $(this).parent().find('input').val();
            _self.layer_boxs(1, '设置菜单跳转链接', '600px', _self.uh(val), ['确定', '取消'], _self.modify_webpage_func, me);
        });
    },
    modify_webpage_func: function (index, obj, me) {
        var _self = obj;
        if (_self.url_validate().form()) {
            //通过表单验证，以下编写自己的代码
            var val = $('.input-text').val();
            $(me).parent().find('input').val(val);
            layer.close(index);
        } else {
            //校验不通过，什么都不用做，校验信息已经正常显示在表单上
        }
    },
    url_validate: function () {
        return $("#commentForm").validate({
            debug: true, //debug，只验证不提交表单
            success:"valid",
            submitHandler: function(){
                /*校验成功后执行*/
                // layer.close(index);
            },
            rules: {
                url: {
                    required: true,
                    isUrl: true
                }
            },
            messages: {
                url: {
                    required: "<i class='fa fa-exclamation-triangle'></i>必填项",
                    isUrl: "<i class='fa fa-exclamation-triangle'></i>请输入正确的URL"
                }
            }
        });
    },
    /*tab按钮切换*/
    tab_init: function () {
        var _self = this;
        $('#j-tab').find('a').on('click', function () {
            $(this).addClass('cur').siblings().removeClass('cur');
            var tab = $(this).attr('href');
            //e.target.hash
            $('.tabs').find('.tab').hide();
            if (tab) {
                $(tab).show().addClass('animated flash');
                setTimeout(function () {
                    $(tab).removeClass('flash animated');
                }, 1000);
            }
            return false;
        });
    },
    /*发送信息*/
    smh: function () {
        return '<div class="margin-30">\
                <div class="tab-group ho" id="j-tab">\
                <a href="#tab1" class="cur" data-type="1">文字</a>\
                <a href="#tab2" data-type="2">图片</a>\
                <a href="#tab3" data-type="3">图文</a>\
                </div>\
                <div class="tabs ho">\
                <div id="tab1" class="tab active">\
                <form>\
                <div class="form-group">\
                <textarea class="form-control" rows="3"></textarea>\
                </div>\
                </form>\
                </div>\
                <div id="tab2" class="tab">\
                <div class="upload_box ho">\
                <a href="javascript:;" class="upload"><i class="fa fa-plus"></i><br>上传图片<input type="file"></a>\
                <img src="../common/images/p1.jpg">\
                <a href="javascript:;">删除</a>\
                </div>\
                </div>\
                <div id="tab3" class="tab">\
                <div class="upload_box ho">\
                <div class="clearfix margin-30">\
                <form>\
                <div class="form-group">\
                <label for="articleTitle">标题</label>\
                <span class="color-red">* （必填）</span>\
                <input type="text" id="articleTitle" class="form-control" maxlength="64">\
                </div>\
                <div class="form-group">\
                <label for="exampleInputFile">封面图片</label>\
                <span class="color-red">*（推荐尺寸：900像素x500像素）</span>\
                <div class="checkbox">\
                <label>\
                <input type="checkbox"> 封面图片显示在正文中\
                </label>\
                </div>\
                <input type="file" id="exampleInputFile">\
                </div>\
                <div class="form-group">\
                <label>作者</label>\
                <span class="color-red">（选填）</span>\
                <input type="text" class="form-control" maxlength="8">\
                </div>\
                <div class="form-group">\
                <label>原文链接</label>\
                <span class="color-red">（选填）</span>\
                <input type="text" class="form-control">\
                </div>\
                <div class="form-group">\
                <label>摘要</label>\
                <span class="color-red">（选填，如果不填写会默认抓取正文前54个字）</span>\
                <textarea class="form-control" rows="3"></textarea>\
                </div>\
                <div class="form-group">\
                <label for="articleContent">正文</label>\
                <span class="color-red">*（必填）</span>\
                <textarea class="form-control" rows="3" id="articleContent"></textarea>\
                </div>\
                </form>\
                </div>\
                </div>\
                </div>\
                </div>\
                <!--<div class="btn-block margin-t-30">\
                <button type="submit" class="btn btn-my">确定并返回</button>\
                </div>-->\
                </div>';
    },
    send_message: function () {
        var _self = this;
        $('.js_choose').on('click', function () {
            var me = this;
            _self.layer_boxs(1, '回复内容', ['600px', '80%'], _self.smh(), ['确定并返回'], _self.send_message_func, me);
            _self.tab_init();
        });
    },
    send_message_func: function (index, obj, me) {
        var _self = obj;
        $(me).parent().children('.btn_inList').hide();
        if ($(me).parent().hasClass('cm_name')) {
            $(me).parent().parent().children('.cm_subname').hide();
        }
        var type;
        var $a = $('#j-tab').find('a');
        for(var i = 0; i < $a.length; i++) {
            if ($($a[i]).hasClass('cur')) {
                type = $($a[i]).attr('data-type');
            }
        }
        if (type == 1) {
            $(me).parent().after('<div class="custom_menuList_content ho" data-type="1"><div class="cc"><p>测试文字详情</p></div><a href="javascript:;" class="btn btn-default pull-right js_modify">修改</a></div>');
        } else if (type == 2) {
            $(me).parent().after('<div class="custom_menuList_content ho" data-type="2"><div class="cc"><img src="../common/images/p1.jpg"></div><a href="javascript:;" class="btn btn-default pull-right js_modify">修改</a></div>');
        } else if (type ==3) {
            $(me).parent().after('<div class="custom_menuList_content ho" data-type="3"><div class="cc"><p>标题</p><img src="../common/images/p1.jpg"><p>摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要摘要</p><a href="../Message/pictext-details.html" target="_blank">查看详情</a></div><a href="javascript:;" class="btn btn-default pull-right js_modify">修改</a></div>');
        }
        _self.modify_send_message();
        layer.close(index);
    },
    modify_send_message: function () {
        var _self = this;
        $('.js_modify').on('click', function () {
            var me = this;
            _self.layer_boxs(1, '回复内容', ['600px', '80%'], _self.smh(), ['确定并返回'], _self.modify_send_message_func, me);
            var type = $(this).parent().attr('data-type');
            var $a = $('#j-tab').find('a');
            for(var i = 0; i < $a.length; i++) {
                if ($($a[i]).attr('data-type') == type) {
                    $($a[i]).addClass('cur').siblings().removeClass('cur');
                }
            }
            _self.tab_init();
        });
    },
    modify_send_message_func: function (index, obj, me) {
            var _self = obj;
            //修改后的值传递
    }
};
