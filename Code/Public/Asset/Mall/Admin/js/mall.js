/**
 * javascript文件
 * author: 雨巷
 * mailto: 365879415@qq.com
 * date: 2016.11.11
 */
var mall = {
    init: function () {
    },
    /*layer弹窗*/
    layer_boxs: function (_type, _t, _area, _html, _btn, _func, _me) {
        var _self = this;
        var index = layer.open({
            type: _type, //1,2
            title: _t,
            skin: 'layui-layer-me', //样式类名
            area: _area, //['600px', '80%']
            shift: 0,
            shade: 0.6,
            maxmin: true, //开启最大化最小化按钮
            content: _html,
            btn: _btn || '', //['保存', '取消']
            yes: function (index, layero) {
                /*确定按钮回调事件*/
                if (_func) {
                    _func(index, _self, _me, layero);
                }
            },
            btn2: function (index, layero) {
                //取消按钮的回调事件，默认关闭弹窗
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
                $(tab).show().addClass('animated fadeInDown');
                setTimeout(function () {
                    $(tab).removeClass('fadeInDown animated');
                }, 1000);
            }
            return false;
        });
    },
    /*分页切换*/
    change_page: function () {
        $('.pagination > li.num').on('click', function () {
            $(this).addClass('active').siblings().removeClass('active');
        });
    },
    /*启用停用操作*/
    toggle_status: function () {
        $('.j-status').on('click', function () {
            var me = this;
            if ($(me).hasClass('btn-success')) {
                layer.confirm('确认停用吗?', {icon: 3, title: '提示'}, function (index) {
                    $(me).removeClass('btn-success').addClass('btn-default').attr('title', '启用').find('i.fa').removeClass('fa-check').addClass('fa-times');
                    layer.close(index);
                });
            } else {
                layer.confirm('确认启用吗?', {icon: 3, title: '提示'}, function (index) {
                    $(me).removeClass('btn-default').addClass('btn-success').attr('title', '停用').find('i.fa').removeClass('fa-times').addClass('fa-check');
                    layer.close(index);
                });
            }
        });
    },
    /*初始树菜单*/
    treeview_func: function (id, data, extend) {
        $(id).treeview($.extend({
            color: "#4a4a4a",
            selectedBackColor: "rgba(77, 156, 242, 0.3)",
            selectedColor: "#4a4a4a",
            expandIcon: 'fa fa-chevron-right',
            collapseIcon: 'fa fa-chevron-down',
            // nodeIcon: 'fa fa-folder-open-o',
            levels: 1,
            data: data
        }, extend));
    },
    /*新增字段、内容*/
    add_fields_box: '<div class="clearfix margin-30" style="max-width: 1000px;">\
    <div class="form-horizontal">\
    <div class="form-group">\
    <label class="col-sm-2 control-label">参数类型</label>\
    <div class="col-sm-10">\
    <div class="radio radio-inline">\
    <label>\
    <input type="radio" name="goodsParams" checked id="goods_attribute" value="attr">商品属性\
    </label>\
    </div>\
    <div class="radio radio-inline">\
    <label>\
    <input type="radio" name="goodsParams" id="goods_specifications" value="spec">商品规格\
    </label>\
    </div>\
    </div>\
    </div>\
    <div class="form-group">\
    <label class="col-sm-2 control-label">字段名称</label>\
    <div class="col-sm-9">\
    <input type="text" class="form-control" placeholder="不超过10字符" id="field_name">\
    </div>\
    </div>\
    <div class="form-group attr-input">\
    <label class="col-sm-2 control-label">内容类型</label>\
    <div class="col-sm-10 content-sort">\
    <div class="radio radio-inline">\
    <label>\
    <input type="radio" name="contentType" id="text" checked value="text">文本\
    </label>\
    </div>\
    <div class="radio radio-inline">\
    <label>\
    <input type="radio" name="contentType" id="select" value="select">单选下拉框\
    </label>\
    </div>\
    <div class="radio radio-inline">\
    <label>\
    <input type="radio" name="contentType" id="checkbox" value="textarea">多行文本\
    </label>\
    </div>\
    </div>\
    </div>\
    <div class="form-group attr-input attr-select">\
    <label class="col-sm-2 control-label">单选下拉</label>\
    <div class="col-sm-9">\
    <textarea class="form-control" rows="3" placeholder="一行代表一个可选值"></textarea>\
    </div>\
    </div>\
    <div class="form-group spec-input spec-select">\
    <label class="col-sm-2 control-label">规格项</label>\
    <div class="col-sm-9">\
    <textarea class="form-control" rows="3" placeholder="一行为一个规格项"></textarea>\
    </div>\
    </div>\
    </div>\
    </div>',
    add_fields_result: {attr: [], spec: []},
    add_fields_initform: function () {
        var _self = this;
        var contenttypeinit = function () {
            $("input:radio[name=contentType]").each(function () {
                if ($(this).attr("checked")) {
                    $(this).trigger('click');
                }
            });
        };
        $("input:radio[name=goodsParams]").click(function () {
            var val = $("input:radio[name=goodsParams]:checked").val();
            switch (val) {
                case 'attr':
                    _self.add_fields_goods_type = 'attr';
                    $(".attr-input").show();
                    $(".spec-input").hide();
                    contenttypeinit();
                    break;
                case 'spec':
                    _self.add_fields_goods_type = 'spec';
                    $(".spec-input").show();
                    $(".attr-input").hide();
                    break;
            }
        });
        $("input:radio[name=goodsParams]").each(function () {
            if ($(this).attr("checked")) {
                $(this).trigger('click');
            }
        });
        $("input:radio[name=contentType]").click(function () {
            var val = $("input:radio[name=contentType]:checked").val();
            switch (val) {
                case 'text':
                    $(".attr-text").show();
                    $(".attr-select").hide();
                    $(".attr-textarea").hide();
                    break;
                case 'select':
                    $(".attr-text").hide();
                    $(".attr-select").show();
                    $(".attr-textarea").hide();
                    break;
                case 'textarea':
                    $(".attr-text").hide();
                    $(".attr-select").hide();
                    $(".attr-textarea").show();
                    break;
            }
        });
        contenttypeinit();
    },
    add_fields_goods_type: '',
    add_fields_goods_cate: '',
    add_fields_ahtml_attr: function (field_name) {
        var html = '', val = $("input:radio[name=contentType]:checked").val();
        switch (val) {
            case 'text':
                this.add_fields_data_item_tmp.attr_type = 1;
                html = '<div class="form-group">\
                        <label class="col-sm-2 control-label">' + field_name + '：</label>\
                        <div class="col-sm-10">\
                        <input type="text" class="form-control" placeholder="仅做展示，不用填写！">\
                        </div>\
                        </div>';
                break;
            case 'select':
                this.add_fields_data_item_tmp.attr_type = 2;
                var val = $(".attr-select").find("textarea").val();
                if (val == '') {
                    layer.msg('下拉框内容不能为空！');
                    return '';
                }
                var options = val.split('\n');
                this.add_fields_data_item_tmp.attr_values = options;
                html = '<div class="form-group">\
                        <label class="col-sm-2 control-label">' + field_name + '：</label>\
                        <div class="col-sm-10">\
                        <select class="form-control">';
                $.each(options, function (k, v) {
                    html += '<option value="' + k + '">' + v + '</option>';
                });
                html += '</select></div></div>';
                break;
            case 'textarea':
                this.add_fields_data_item_tmp.attr_type = 3;
                html = '<div class="form-group">\
                        <label class="col-sm-2 control-label">' + field_name + '：</label>\
                        <div class="col-sm-10">\
                        <textarea class="form-control" rows="3" placeholder="仅做展示，不用填写！"></textarea>\
                        </div>\
                        </div>';
                break;
        }
        return html;
    },
    add_fields_ahtml_spec: function (field_name) {
        var html = '', val = $(".spec-select").find("textarea").val();
        if (val == '') {
            layer.msg('规格项不能为空！');
            return '';
        }
        var options = val.split('\n');
        this.add_fields_data_item_tmp.spec_item = options
        html = '<div class="form-group">\
                        <label class="col-sm-2 control-label">' + field_name + '：</label>\
                        <div class="col-sm-10">';
        $.each(options, function (k, v) {
            html += '<div class="checkbox checkbox-inline"><label><input type="checkbox">' + v + '</label></div>'
        });
        html += '</div></div>';
        return html;
    },
    add_fields: function () {
        var _self = this;
        $('.j-add-fields').on('click', function () {
            var _me = this;
            _self.add_fields_goods_cate = $("#cat3Id").val();
            _self.layer_boxs(1, '新增字段、内容', ['600px', '80%'], _self.add_fields_box, ['确定', '取消'], _self.add_fields_func, _me);
            _self.add_fields_initform();
        });
    },
    add_fields_attr_data_tmp: function (field_name) {
        return {
            cate_id: this.add_fields_goods_cate,
            attr_name: field_name,
            attr_type: '',
            attr_values: ''
        };
    },
    add_fields_spec_data_tmp: function (field_name) {
        return {
            cate_id: this.add_fields_goods_cate,
            spec_name: field_name,
            spec_item: [],
        };
    },
    add_fields_data_item_tmp: '',
    /*确定按钮的回调事件*/
    add_fields_func: function (index, obj) {
        var _self = obj, ahtml = '', field_name = $('#field_name').val();
        if (field_name == '') {
            layer.msg('字段名称不能为空！');
            $('#field_name').focus();
            return;
        }
        if (_self.add_fields_goods_type == 'attr') {
            _self.add_fields_data_item_tmp = _self.add_fields_attr_data_tmp(field_name);
            ahtml = _self.add_fields_ahtml_attr(field_name);
            if (ahtml == '') {
                return;
            }
            _self.add_fields_result.attr.push(_self.add_fields_data_item_tmp);
            $('.goods-attribute').append(ahtml).removeClass('hide');
        }
        if (_self.add_fields_goods_type == 'spec') {
            _self.add_fields_data_item_tmp = _self.add_fields_spec_data_tmp(field_name);
            ahtml = _self.add_fields_ahtml_spec(field_name);
            if (ahtml == '') {
                return;
            }
            _self.add_fields_result.spec.push(_self.add_fields_data_item_tmp);
            $('.goods-specifications').append(ahtml).removeClass('hide');
        }
        $('.add-parameter-box .btn.save-btn').removeClass('hide');
        $('.add-parameter-box .hr-line-dashed').removeClass('hide');
        layer.close(index);
    },
    /*内容类型切换*/
    content_sort: '01', /*01:文本；02：下拉框；03：多选框*/
    content_sort_change: function () {
        var _self = this;
        _self.content_sort = '01';
        $('.content-sort').find('input[name="contentSort"]').change(function () {
            var m = $(this).parent().parent().parent().parent().parent();
            if ($(this).is(':checked') && ($(this).attr('data-id') == '01')) {
                _self.content_sort = '01';
                $(m).find('.select-box').hide();
                $(m).find('.checkbox-box').hide();
                $(m).find('.text-box').show();
            } else if ($(this).is(':checked') && ($(this).attr('data-id') == '02')) {
                _self.content_sort = '02';
                $(m).find('.text-box').hide();
                $(m).find('.checkbox-box').hide();
                $(m).find('.select-box').show();
            } else if ($(this).is(':checked') && ($(this).attr('data-id') == '03')) {
                _self.content_sort = '03';
                $(m).find('.text-box').hide();
                $(m).find('.select-box').hide();
                $(m).find('.checkbox-box').show();
            }
        });
    },
    /*显示商品新增参数页面*/
    show_add_parameter_box: function () {
        $('.j-add-parameter').on('click', function () {
            $('.add-parameter-box').removeClass('hide');
            $(this).remove();
        });
    },
    /*新增字段内容回填页面操作*/
    add_fields_func_html: function (field_name) {
        var _self = this;
        var ahtml = '';
        switch (_self.content_sort) {
            //文本
            case '01':
                var limit_character = [];
                var limit_characters = '文本';
                $('.text-box01').find("input[type='checkbox']").each(function () {
                    if ($(this).is(':checked')) {
                        limit_character.push($(this).val());
                    }
                });
                if (limit_character.length > 0) {
                    limit_characters += "（只允许" + limit_character.join('+') + ")";
                }
                if ($('#less_character').val()) {
                    limit_characters += "，最少" + $('#less_character').val() + "字符";
                }
                if ($('#most_character').val()) {
                    limit_characters += "，最多" + $('#most_character').val() + "字符";
                }

                ahtml = '<div class="form-group">\
                        <label class="col-sm-2 control-label">' + field_name + '：</label>\
                        <div class="col-sm-10">\
                        <input type="text" class="form-control" name="" placeholder="' + limit_characters + '">\
                        </div>\
                        </div>';
                break;
            //下拉框
            case '02':
                ahtml = '<div class="form-group">\
                        <label class="col-sm-2 control-label">' + field_name + '：</label>\
                        <div class="col-sm-10">\
                        <select class="form-control">';
                var option_val = $('.select-box').find("input[type='text']").val();
                if (option_val == '') {
                    layer.msg('下拉框内容不能为空！');
                    $('.select-box').find("input[type='text']").focus();
                    return '';
                }
                var option_arr = option_val.split('，');
                for (var i = 0; i < option_arr.length; i++) {
                    ahtml += '<option value="' + i + '">' + option_arr[i] + '</option>';
                }
                ahtml += '</select></div></div>';
                break;
            //多选框
            case '03':
                ahtml = '<div class="form-group">\
                        <label class="col-sm-2 control-label">' + field_name + '：</label>\
                        <div class="col-sm-10">';
                var option_val = $('.checkbox-box').find("input[type='text']").val();
                if (option_val == '') {
                    layer.msg('多选框内容不能为空！');
                    $('.checkbox-box').find("input[type='text']").focus();
                    return '';
                }
                var option_arr = option_val.split('，');
                for (var i = 0; i < option_arr.length; i++) {
                    ahtml += '<div class="checkbox checkbox-inline"><label><input type="checkbox">' + option_arr[i] + '</label></div>'
                }
                ahtml += '</div></div>';
                break;
        }
        return ahtml;
    },
    /*添加标签*/
    add_label_html: '<div class="clearfix margin-30">\
            <div class="form-horizontal">\
            <div class="form-group">\
            <label class="col-sm-2 control-label">标签分类</label>\
            <div class="col-sm-9">\
            <select class="form-control sort-select" name="firstSort">\
            <option value="0">商品</option>\
            <option value="1">物流</option>\
            <option value="2">服务</option>\
            </select>\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-2 control-label">标签内容</label>\
            <div class="col-sm-9">\
            <textarea class="form-control" rows="3" placeholder="多个标签用中文逗号“，”隔开。不超过20个字符"></textarea>\
            </div>\
            </div>\
            </div>\
            </div>',
    add_label: function () {
        var _self = this;
        $('.j-add-label').on('click', function () {
            var _me = this;
            _self.layer_boxs(1, '添加标签', ['600px', '400px'], _self.add_label_html, ['确定', '取消'], _self.add_label_func, _me);
            _self.content_sort_change();
        });
    },
    /*添加标签的回调事件*/
    add_label_func: function (index, obj) {
        var _self = obj;

        layer.close(index);
    },
    /*商品其他服务控制*/
    initialize_goods_service: function () {
        $('input[name="line"]').change(function () {
            if ($('#online').is(':checked') && $('#offline').is(':checked')) {
                $('input[name="getinstore"]').parent().parent().removeClass('hide');
                $('#checkontime').removeClass('hide');
            } else {
                $('input[name="getinstore"]').parent().parent().addClass('hide');
                $('#checkontime').addClass('hide');
            }
        });
    },
    /*UE初始化*/
    initialize_ue_func: function (id) {
        return UE.getEditor(id, {
            toolbars: [
                ['fullscreen', 'source', '|', 'undo', 'redo', '|', 'fontfamily', 'fontsize', '|', 'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight', '|', 'link', 'unlink', '|', 'horizontal', 'date', 'time', '|', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'simpleupload', 'emotion', '|', 'inserttable', 'deletetable', '|', 'preview', 'help']]
        });
    },
    // 店铺管理-添加店铺html
    add_shop_html: function () {
        var add_shop_html = '<div class="clearfix margin-30">\
                <form class="form-horizontal">\
                <div class="form-group">\
                <label class="col-sm-2 control-label">小丸子的店</label>\
                <label class="col-sm-9 control-label text-left">ID：23422</label>\
                </div>\
                <div class="form-group">\
                <label class="col-sm-2 control-label">店铺头像：</label>\
                <div class="col-sm-2">\
                <img src="../images/bg.png" style="width: 100%;">\
                </div>\
                <div class="col-sm-8">\
                <input type="file" class="margin-t-10">\
                </div>\
                </div>\
                <div class="form-group">\
                <label class="col-sm-2 control-label">店铺名称：</label>\
                <div class="col-sm-9">\
                <input type="text" class="form-control" maxlength="12" name="shopName" id="shopName" placeholder=" 不超过12个字符">\
                </div>\
                </div>\
                <div class="form-group">\
                <label class="col-sm-2 control-label">店铺分类：</label>\
                <div class="col-sm-9">\
                <select class="form-control" title="店铺分类" name="tags">\
                <option value="0">店铺分类取商品分类里的一级分类</option>\
                <option value="1">1</option>\
                <option value="2">2</option>\
                <option value="3">3</option>\
                </select>\
                </div>\
                </div>\
                <div class="form-group">\
                <label class="col-sm-2 control-label">店铺模板：</label>\
                <div class="col-sm-10">\
                <div class="radio radio-inline"><label><input type="radio" name="shopTemplate" value="1" checked>1</label></div>\
                <div class="radio radio-inline"><label><input type="radio" name="shopTemplate" value="2">2</label></div>\
                <div class="radio radio-inline"><label><input type="radio" name="shopTemplate" value="3">3</label></div>\
                </div>\
                </div>\
                <div class="form-group">\
                <label class="col-sm-2 control-label">店铺性质：</label>\
                <div class="col-sm-10">\
                <div class="radio radio-inline"><label><input type="radio" name="shopProperty" value="1" checked>真实店铺</label></div>\
                <div class="radio radio-inline"><label><input type="radio" name="shopProperty" value="2">测试店铺</label></div>\
                </div>\
                </div>\
                 <div class="form-group">\
                <label class="col-sm-2 control-label">发货地址：</label>\
                <div class="col-sm-9">\
                <input type="text" class="form-control" name="address1" id="address1">\
                </div>\
                </div>\
                <div class="form-group">\
                <label class="col-sm-2 control-label">退货地址：</label>\
                <div class="col-sm-9">\
                <input type="text" class="form-control" name="address2" id="address2">\
                </div>\
                </div>\
                <div class="form-group">\
                <label class="col-sm-2 control-label">店铺介绍：</label>\
                <div class="col-sm-9">\
                <textarea class="form-control" id="" name="shopDesc" rows="3" placeholder="不超过300个字符"></textarea>\
                </div>\
                </div>\
                </form>\
                </div>';
        return add_shop_html;
    },
    // 打开添加店铺layer
    add_shop: function () {
        var _self = this;
        $(".j-add-shop").on('click', function () {
            _self.layer_boxs(1, '添加店铺', ['800px', '80%'], _self.add_shop_html(), ['确认开通', '确认开通并发布商品'], _self.add_shop_fun);
        });
    },
    // 添加店铺确认回调
    add_shop_fun: function (index, obj) {
        var _self = obj;
        layer.close(index);
    },
    //店铺违规统计
    shop_violations_statistics: function () {
        var myChart = echarts.init(document.getElementById('shop-violations-statistics'));
        option = {
            title: {
                text: '店铺违规统计',
                subtext: '实时更新最新等级',
                x: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient: 'vertical',
                x: 'left',
                data: ['正常店铺', '违规店铺(商品图文不符)', '违规店铺(买家投诉3次以上)', '违规店铺(商品造假)', '违规店铺(商品资质造假)']
            },
            toolbox: {
                show: true,
                feature: {
                    mark: {show: true},
                    dataView: {show: true, readOnly: false},
                    magicType: {
                        show: true,
                        type: ['pie', 'funnel'],
                        option: {
                            funnel: {
                                x: '25%',
                                width: '50%',
                                funnelAlign: 'left',
                                max: 1548
                            }
                        }
                    },
                    restore: {show: true},
                    saveAsImage: {show: true}
                }
            },
            calculable: true,
            series: [
                {
                    name: '店铺违规统计',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '60%'],
                    data: [
                        {value: 335, name: '正常店铺'},
                        {value: 310, name: '违规店铺(商品图文不符)'},
                        {value: 234, name: '违规店铺(买家投诉3次以上)'},
                        {value: 135, name: '违规店铺(商品造假)'},
                        {value: 1548, name: '违规店铺(商品资质造假)'}
                    ]
                }
            ]
        };
        myChart.setOption(option);
    },
    // 浮层
    hover_tip: function (hoverDiv, _showDiv) {
        var _hoverDiv = $("." + hoverDiv);
        var hideTimer;
        _hoverDiv.hover(function () {
            var _me = $(this);
            hideTimer = setTimeout(function () {
                _me.find('.' + _showDiv).show();
            }, 300);
        }, function () {
            clearTimeout(hideTimer);
            $(this).find('.' + _showDiv).hide();
        });
        return this;
    },
    //违规浮层
    violation_hover_tip: function () {
        //违规记录
        this.hover_tip('j-hover-show', 'j-hover-tip');
        //店铺关闭次数悬浮层
        this.hover_tip('j-shop-show', 'j-shop-tip');
        //保证金扣款浮层
        this.hover_tip('j-charge-show', 'j-charge-tip');
        //保证金余额悬浮层
        this.hover_tip('j-balance-show', 'j-balance-tip');
    },
    /*添加广告*/
    add_ad_html: '<div class="clearfix margin-30">\
            <div class="form-horizontal">\
            <div class="form-group">\
            <label class="col-sm-3 control-label">广告位置</label>\
            <div class="col-sm-9">\
            <select class="form-control" name="ad">\
            <option value="0">首页轮播图</option>\
            <option value="1">分类页广告图</option>\
            </select>\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-3 control-label">图片</label>\
            <div class="col-sm-3">\
            <img src="../images/bg.png">\
            </div>\
            <div class="col-sm-6">\
            <input type="file" class="margin-t-10">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-3 control-label">尺寸（像素）</label>\
            <div class="col-sm-4">\
            <input type="text" class="form-control" placeholder="请输入尺寸（宽）">\
            </div>\
            <label class="col-sm-1 text-center margin-t-10">x</label>\
            <div class="col-sm-4">\
            <input type="text" class="form-control" placeholder="请输入尺寸（高）">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-3 control-label">链接地址</label>\
            <div class="col-sm-9">\
            <input type="text" class="form-control" placeholder="请输入链接地址">\
            </div>\
            </div>\
            </div>\
            </div>',
    add_ad: function () {
        var _self = this;
        $('.j-add-ad').on('click', function () {
            var _me = this;
            _self.layer_boxs(1, '添加广告', ['600px', '60%'], _self.add_ad_html, ['确定', '取消'], _self.add_ad_func, _me);
        });
    },
    /*添加默认图*/
    add_dimg_html: '<div class="clearfix margin-30">\
            <div class="form-horizontal">\
            <div class="form-group">\
            <label class="col-sm-3 control-label">图片位置</label>\
            <div class="col-sm-9">\
            <select class="form-control" name="ad">\
            <option value="0">首页轮播图</option>\
            <option value="1">分类页广告图</option>\
            </select>\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-3 control-label">图片</label>\
            <div class="col-sm-3">\
            <img src="../images/bg.png">\
            </div>\
            <div class="col-sm-6">\
            <input type="file" class="margin-t-10">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-3 control-label">尺寸（像素）</label>\
            <div class="col-sm-4">\
            <input type="text" class="form-control" placeholder="请输入尺寸（宽）">\
            </div>\
            <label class="col-sm-1 text-center margin-t-10">x</label>\
            <div class="col-sm-4">\
            <input type="text" class="form-control" placeholder="请输入尺寸（高）">\
            </div>\
            </div>\
            </div>\
            </div>',
    add_dimg: function () {
        var _self = this;
        $('.j-add-dimg').on('click', function () {
            var _me = this;
            _self.layer_boxs(1, '添加默认图', ['600px', '400px'], _self.add_dimg_html, ['确定', '取消'], _self.add_dimg_func, _me);
        });
    },
    /*添加位置*/
    add_classification_html: '<div class="clearfix margin-30">\
            <div class="form-horizontal">\
            <div class="form-group">\
            <label class="col-sm-3 control-label">图片位置</label>\
            <div class="col-sm-9">\
            <input type="text" class="form-control" placeholder="请输入图片位置">\
            </div>\
            </div>\
            <div class="form-group">\
            <label class="col-sm-3 control-label">尺寸（像素）</label>\
            <div class="col-sm-4">\
            <input type="text" class="form-control" placeholder="请输入尺寸（宽）">\
            </div>\
            <label class="col-sm-1 text-center margin-t-10">x</label>\
            <div class="col-sm-4">\
            <input type="text" class="form-control" placeholder="请输入尺寸（高）">\
            </div>\
            </div>\
            </div>\
            </div>',
    add_classification: function () {
        var _self = this;
        $('.j-add-classification').on('click', function () {
            var _me = this;
            _self.layer_boxs(1, '添加位置', ['600px', '300px'], _self.add_classification_html, ['确定', '取消'], _self.add_classification_func, _me);
        });
    },
    table_sort_list: function () {
        $('td.j-all-classify').click(function () {
            var fold = $(this).attr('fold-change');
            if (!fold) {
                $(this).attr('fold-change', true);
                $(this).parent('tr').siblings('.j-' + this.id).hide();
                $(this).parent('tr').siblings('.j-classy-three').hide();
                $(this).find('i').addClass('fa-plus-square').removeClass('fa-minus-square');
                $(this).parent('tr').siblings('.j-' + this.id).find('.fold-td-two i').addClass('fa-plus-square').removeClass('fa-minus-square');
                $(this).parent('tr').siblings('.j-' + this.id).find('.fold-td-two').removeAttr('fold-change');
            } else {
                $(this).removeAttr('fold-change');
                $(this).parent('tr').siblings('.j-' + this.id).show();
                $(this).find('i').addClass('fa-minus-square').removeClass('fa-plus-square');
                $(this).parent('tr').siblings('.j-' + this.id).find('.fold-td-two').attr('fold-change', true);
            }
        });
        // 分点击
        $('td.j-two-classy').click(function () {
            var fold = $(this).attr('fold-change');
            if (!fold) {
                $(this).attr('fold-change', true);
                $(this).parent('tr').siblings('.j-' + this.id).hide();
                $(this).find('i').addClass('fa-plus-square').removeClass('fa-minus-square');
            } else {
                $(this).removeAttr('fold-change');
                $(this).parent('tr').siblings('.j-' + this.id).show();
                $(this).find('i').addClass('fa-minus-square').removeClass('fa-plus-square');
            }
        });
    }
};

/**
 * Bootstrap之表格checkbox复选框全选
 */
$(".j-checkAll").click(function () {
    $("input[name='sub']").prop("checked", this.checked);
});
$("input[name='sub']").click(function () {
    var $subs = $("input[name='sub']");
    $(".j-checkAll").prop("checked", $subs.length == $subs.filter(":checked").length ? true : false);
});