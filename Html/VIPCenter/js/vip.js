/**
 * Created by Chenyduan on 2016/8/22.
 */
var vipCommon = {
    //  多级树菜单treeview
    treeview_boxs: function (treeviewId) {
        $('.treeview').treeview({
            color: "#4a4a4a",
            selectedBackColor: "rgba(77, 156, 242, 0.3)",
            selectedColor: "#4a4a4a",
            expandIcon: 'fa fa-chevron-right',
            collapseIcon: 'fa fa-chevron-down',
            nodeIcon: 'fa fa-folder-open-o',
            data: treeviewId
        });
    },
    //  layer弹窗
    layer_boxs: function (_t, _area, _html) {
        var index = layer.open({
            type: 1,
            title: _t,
            skin: 'layui-layer-me', //样式类名
            area: _area,
            shift: 0,
            shade: 0.6,
            maxmin: true, //开启最大化最小化按钮
            content: _html,
        });

        $(".j-cancel-btn").on('click', function () {
            layer.close(index);
        });
    },

    // 会员分析生成报表html
    create_report_html: function () {
        var createReport = '<div class="wrapper wrapper-content">\
                <div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form id="j-edit-vrule-form" class="form-horizontal">\
                                <div class="form-group">\
                                    <label for="reportId">id</label>\
                                    <input type="text" class="form-control" name="reportId" id="reportId" value="a123456" readonly>\
                                </div>\
                                <div class="form-group">\
                                    <label for="reportCname">中文名称</label>\
                                    <input type="text" class="form-control" name="reportCname" id="reportCname" placeholder="请输入报表中文名称" >\
                                </div>\
                                <div class="form-group">\
                                    <label for="reportEname">英文名称</label>\
                                    <input type="text" class="form-control" name="reportEname" id="reportEname" placeholder="请输入报表英文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="reportDesc">描述</label>\
                                    <textarea class="form-control" name="reportDesc" id="reportDesc" placeholder="描述" rows="4"></textarea> \
                                </div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return createReport;
    },
    // 打开会员分析生成报表layer
    create_report: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('生成报表', ['80%', '80%'], _self.create_report_html());
        });
    },

    // 会员分析导出图片html
    export_html: function () {
        var exportHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm">\
                                <div class="form-group">\
                                    <div class="alert alert-danger">注意：您正在导出图片*******</div>\
                                </div>\
                                <div class="form-group">\
                                    <label for="reportDirectory" class="col-sm-2 control-label">存放位置</label>\
                                    <div class="col-sm-10"><input type="file" name="reportDirectory" id="reportDirectory"></div>\
                                </div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return exportHtml;
    },
    // 打开会员分析导出图片layer
    export: function () {
        var _self = this;
        $(".j-export").on('click', function () {
            _self.layer_boxs('导出图片', ['60%', '60%'], _self.export_html());
        });
    },

    // 会员审核添加审核html
    audit_html: function(){
        var addAuditHtml = '<div class="wrapper wrapper-content">\
                <div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form id="j-edit-vrule-form" class="form-horizontal">\
                                <div class="form-group">\
                                    <label for="vipId">用户id</label>\
                                    <input type="text" class="form-control" name="vipId" id="vipId" value="123456789" readonly>\
                                </div>\
                                <div class="form-group">\
                                    <label for="vipCname">中文名称</label>\
                                    <input type="text" class="form-control" name="vipCname" id="vipCname" placeholder="请输入中文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="vipUsername">账号</label>\
                                    <input type="text" class="form-control" name="vipUsername" id="vipUsername" placeholder="请输入账号">\
                                </div>\
                                <div class="form-group">\
                                    <label for="password">密码</label>\
                                    <input type="password" class="form-control" name="password" id="password" placeholder="请输入用户密码">\
                                </div>\
                                <div class="form-group">\
                                    <label for="vipEmail">邮件地址</label>\
                                    <input type="text" class="form-control" name="vipEmail" id="vipEmail" placeholder="请输入用户邮件地址">\
                                </div>\
                                <div class="form-group">\
                                    <label class="radio-inline">\
                                        <input type="radio" class="" name="vmodelStatus" id="vmodelStatus1" value="1">启用\
                                    </label>\
                                    <label class="radio-inline">\
                                        <input type="radio" class="" name="vmodelStatus" id="vmodelStatus2" value="0">禁用\
                                    </label>\
                                </div>\
                                <div class="form-group">\
                                    <label>头像</label><br>\
                                    <input type="file"  name="headPortrait" id="headPortrait" accept="image/jpeg">\
                                </div>\
                                <div class="form-group">\
                                    <img class="uploadingimg" id="uploading" src="../Common/images/shangchuan.png" style="width: 120px;height: 120px;">\
                                </div>\
                                <div class="form-group">\
                                    <label for="vipDesc">描述</label>\
                                    <textarea class="form-control" name="vipDesc" id="vipDesc" placeholder="描述" rows="4"></textarea> \
                                </div>\
                                <div class="form-group">\
                                    <label for="vipAuditResult">审核结果</label><br>\
                                    <select id="vipAuditResult"  name="vipAuditResult"  class="form-control my-form w100"  title="审核结果" >\
                                        <option>请选择审核结果</option>\
                                        <option value="0">通过</option>\
                                        <option value="1">拒绝</option>\
                                    </select>\
                                </div>\
                                <div class="form-group">\
                                    <label for="vipAuditMsg">审核意见</label><br>  \
                                    <select id="vipAuditMsg" name="vipAuditMsg"   class="form-control my-form w100"  title="审核意见" >\
                                        <option>请选择审核意见</option>\
                                        <option value="0">祝贺你成为会员</option>\
                                        <option value="1">对不起，由于您的资料不符合规定不能成为会员</option>\
                                    </select>\
                                </div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                    </div></div></div></div>';
        return addAuditHtml;
    },
    // 打开会员审核添加审核layer
    add_audit: function () {
        var _self = this;
        $(".j-audit").on('click', function () {
            _self.layer_boxs('添加审核', ['80%', '80%'], _self.audit_html());
            _self.upload_Img();
        });
    },

    // 会员审核重置密码html
    reset_pwd_html: function () {
        var resetPwdHtml = '<div class="wrapper wrapper-content">\
                <div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm" class="form-horizontal">\
                                <div class="form-group">\
                                    <label class="col-sm-2 control-label"></label>\
                                    <div class="alert alert-danger">注意：您正在修改用户***的登录密码，修改后请用新密码登录！</div>\
                                </div>\
                                <div class="form-group">\
                                    <label for="password1" class="col-sm-2 control-label">新密码</label>\
                                    <div class="col-sm-10"><input type="password" class="form-control" name="password1" id="password1" placeholder="请输入新密码"></div>\
                                </div>\
                                <div class="form-group">\
                                    <label for="password2" class="col-sm-2 control-label">新密码第二次</label>\
                                    <div class="col-sm-10"><input type="password" class="form-control" name="password2" id="password2" placeholder="请再次输入密码"></div>\
                                </div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return resetPwdHtml;
    },
    // 打开会员审核重置密码layer
    reset_pwd: function () {
        var _self = this;
        $(".j-reset-pwd").on('click', function () {
            _self.layer_boxs('重置密码', ['60%', '60%'], _self.reset_pwd_html());
        });
    },

    // 会员模型管理添加（编辑）会员模型
    model_html: function () {
        var addModelHtml = '<div class="wrapper wrapper-content">\
                <div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form id="j-edit-vrule-form" class="form-horizontal">\
                                <div class="form-group">\
                                    <label for="vmodelId">会员模型id</label>\
                                    <input type="text" class="form-control" name="vmodelId" id="vmodelId" value="123456789" readonly>\
                                </div>\
                                <div class="form-group">\
                                    <label for="vmodelCname">中文名称</label>\
                                    <input type="text" class="form-control" name="vmodelCname" id="vmodelCname" placeholder="请输入中文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="vmodelEname">英文名称</label>\
                                    <input type="text" class="form-control" name="vmodelEname" id="vmodelEname" placeholder="请输入英文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="vmodelFormName">创建表单名</label>\
                                    <input type="text" class="form-control" name="vmodelFormName" id="vmodelFormName" placeholder="请输入创建表单名">\
                                </div>\
                                <div class="form-group">\
                                    <div class="checkbox"><label><input type="checkbox" class="" name="vmodelFormChk" id="vmodelFormChk">使用基本会员表单创建</label></div>\
                                </div>\
                                <div class="form-group">\
                                    <label class="radio-inline">\
                                        <input type="radio" class="" name="vmodelStatus" id="vmodelStatus1" value="1">启用\
                                    </label>\
                                    <label class="radio-inline">\
                                        <input type="radio" class="" name="vmodelStatus" id="vmodelStatus2" value="0">禁用\
                                    </label>\
                                </div>\
                                <div class="form-group">\
                                    <label>审核方式</label><br>\
                                    <label class="radio-inline">\
                                        <input type="radio" class="" name="vmodelAudit" id="vmodelAudit1" value="1">自动\
                                    </label>\
                                    <label class="radio-inline">\
                                        <input type="radio" class="" name="vmodelAudit" id="vmodelAudit2" value="0">手动\
                                    </label>\
                                </div>\
                                <div class="form-group">\
                                    <label for="vmodelDesc">描述</label>\
                                    <textarea class="form-control" name="vmodelDesc" id="vmodelDesc" placeholder="描述" rows="4"></textarea> \
                                </div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return addModelHtml;
    },
    // 打开会员模型添加会员模型layer
    add_model: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('添加会员模型', ['80%', '80%'], _self.model_html());
        });
    },
    // 打开会员模型编辑会员模型layer
    edit_model: function () {
        var _self = this;
        $(".j-edit").on('click', function () {
            _self.layer_boxs('编辑会员模型', ['80%', '80%'], _self.model_html());
        });
    },
    // 会员模型管理设计等级字段
    set_level_field_html: function () {
        var setHtml = '<div class="wrapper wrapper-content">\
            <div class="row">\
                <div class="col-sm-12">\
                    <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                        <form  id="commentForm" class="form-horizontal">\
                            <div class="form-group">\
                                <label for="vFormName" class="col-sm-2 control-label">表单名称</label>\
                                <div class="col-sm-10"><input type="text" class="form-control" name="vFormName" id="vFormName" value="123456789" placeholder="会员表单"></div>\
                            </div>\
                            <div class="form-group">\
                                <label for="vLevelFields" class="col-sm-2 control-label">等级字段选择</label>\
                                <div class="col-sm-10"><input type="text" class="form-control" name="vLevelFields" id="vLevelFields" placeholder="等级字段选择"></div>\
                            </div>\
                            <div class="form-group">\
                                <label for="vFieldsDict" class="col-sm-2 control-label">等级字典</label>\
                                <div class="col-sm-10">\
                                    <div class="input-group my-form w100">\
                                        <input type="text" class="form-control" name="vFieldsDict" id="vFieldsDict" placeholder="等级字典" readonly>\
                                        <span class="input-group-btn">\
                                            <button type="button" id="changeTemplate" class="btn btn-my margin-r-0 j-select-btn">选择</button>\
                                        </span>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="form-group pull-right">\
                                <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                            </div>\
                        </form>\
                    </div>\
                </div>\
            </div>\
        </div>';
        return setHtml;
    },
    //  打开会员模型设定等级字段 layer
    level_field: function () {
        var _self = this;
        $(".j-set").on('click', function () {
            _self.layer_boxs('设定等级字段', ['80%', '80%'], _self.set_level_field_html());
            _self.get_select_layer();
        })
    },

    // 会员模型重命名html
    reset_name_html: function () {
        var resetNameHtml = '<div class="wrapper wrapper-content">\
            <div class="row">\
                <div class="col-sm-12">\
                    <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                        <form  id="commentForm" class="form-horizontal">\
                             <div class="form-group">\
                                <label for="newVmodelName" class="col-sm-2 control-label">输入新名称</label>\
                                <div class="col-sm-10"><input type="text" class="form-control" name="newVmodelName" id="newVmodelName" placeholder="请输入新名称"></div>\
                            </div>\
                            <div class="form-group pull-right">\
                                <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                            </div>\
                        </form>\
                    </div>\
                </div>\
            </div>\
        </div>';
        return resetNameHtml;
    },
    // 打开会员模型重命名layer
    reset_name: function () {
        var _self = this;
        $(".j-rename").on('click', function () {
            _self.layer_boxs('重命名', ['60%', '60%'], _self.reset_name_html());
        });
    },

    // 会员报表导出报表html
    export_report_html: function () {
        var exportHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm">\
                               <div class="form-group">\
                                    <div class="alert alert-danger" role="alert">注意：您正在导出报表*******</div>\
                               </div>\
                               <div class="form-group">\
                                    <label for="reportDirectory" class="col-sm-2 text-right control-label">存放位置</label>\
                                    <div class="col-sm-10"><input type="file" name="reportDirectory" id="reportDirectory"></div>\
                               </div>\
                               <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return exportHtml;
    },
    // 打开会员报表导出报表layer
    export_report: function () {
        var _self = this;
        $(".j-export").on('click', function () {
            _self.layer_boxs('导出报表', ['60%', '60%'], _self.export_report_html());
        });
    },

    // 会员规则管理编辑规则html
    edit_rule_html: function () {
        var editRuleHtml = '<div class="wrapper wrapper-content">\
                <div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form id="" class="form-horizontal">\
                                <div class="form-group">\
                                    <label>商城会员系统</label>&nbsp;<span>会员一级</span>\
                                </div>\
                                <div class="form-group">\
                                    <label>显示头像</label><br>\
                                    <input type="file" name="vruleLevelPhoto" id="fileimg" class="p-t7" accept="image/jpeg">\
                                </div>\
                                <div class="form-group">\
                                    <img class="uploadingimg padding-t-7" id="imgSrc" src="../Common/images/shangchuan.png" style="width: 120px;height: 120px;">\
                                </div>\
                                <div class="form-group">\
                                    <label for="vruleLevelUnit">计算值单位</label>\
                                    <input type="text" id="vruleLevelUnit"  class="form-control " name="vruleLevelUnit" placeholder="">\
                                </div>\
                                <div class="form-group">\
                                    <label>值计算公式</label>\
                                    <div id="value-formula">\
                                        <div class="add-line">\
                                            <label>值&nbsp;=</label>\
                                            <select class="form-control my-form width-90 no-pull" name="" id=""><option value="1">数值</option><option value="2">字段值</option></select>\
                                            <input type="text" class="form-control  width-90" name="" id="" placeholder="值" value="">\
                                            <select class="form-control my-form width-90 no-pull" name="" id=""><option value="1">数值</option><option value="2">字段值</option></select>\
                                            <input type="text" class="form-control width-90" name="" id="" placeholder="值" value="">\
                                        </div>\
                                    </div>\
                                    <button type="button" class="btn btn-my j-add-formula j-add-formula1" data-name="value-formula">加一行</button>\
                                </div>\
                                <div class="form-group">\
                                    <label>条件公式</label>\
                                    <div class="n-select" id="conditional-formula">\
                                        <label>当规则字段值</label><br>\
                                        <div class="add-line">\
                                            <select class="form-control my-form width-90 no-pull" name="" id=""><option value="1">=	</option><option value="2">!=</option><option value="3">&gt;</option><option value="4">&lt;</option></select>\
                                            <select class="form-control my-form width-90 no-pull" name="" id=""><option value="1">数值</option><option value="2">字段名</option></select>\
                                            <input type="text" class="form-control width-90" name="" id="" placeholder="值" value="">\
                                            <select class="form-control my-form width-90 no-pull" name="" id=""><option value="1">并且</option><option value="2">或者</option><option value="3">非</option></select>\
                                        </div>\
                                    </div>\
                                    <button type="button" class="btn btn-my j-add-formula j-add-formula2" data-name="conditional-formula">加一行</button>\
                                </div>\
                                <div class="form-group"><label>值计算工时</label><div><span>当规则大于10000分时位1级会员</span></div></div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return  editRuleHtml;
    },

    // 打开会员报表导出报表layer
    edit_rule: function () {
        var _self = this;
        $(".j-edit").on('click', function () {
            _self.layer_boxs('编辑规则', ['80%', '90%'], _self.edit_rule_html());
        });
    },

    // 会员报表导入规则html
    import_rule_html: function () {
        var importHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm" class="form-horizontal">\
                                <div class="form-group">\
                                    <div class="alert alert-danger" role="alert">注意:请选择需要导入的规则文件</div>\
                                </div>\
                                <div class="form-group">\
                                    <label for="ruleDirectory" class="dis-b">选择文件</label>\
                                    <input type="file" name="ruleDirectory" id="ruleDirectory">\
                                </div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                </div>\
                            </form>\
                        </div></div></div></div>';
        return importHtml;
    },
    // 打开会员报表导入规则layer
    import_rule: function () {
        var _self = this;
        $(".j-import").on('click', function () {
            _self.layer_boxs('导入规则', ['60%', '60%'], _self.import_rule_html());
        });
    },

    // 会员报表导出规则html
    export_rule_html: function () {
        var exportHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm" class="form-horizontal">\
                               <div class="form-group">\
                                    <label class="col-sm-2">&nbsp;</label>\
                                    <div class="col-sm-10 layer-notice-area">注意：您正在导出报表*******</div>\
                               </div>\
                               <div class="form-group">\
                                    <label for="reportDirectory" class="col-sm-2 text-right control-label">存放位置</label>\
                                    <div class="col-sm-10"><input type="file" name="reportDirectory" id="reportDirectory"></div>\
                               </div>\
                               <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return exportHtml;
    },
    // 打开会员规则导出规则layer
    export_rule: function () {
        var _self = this;
        $(".j-export").on('click', function () {
            _self.layer_boxs('导出规则', ['60%', '60%'], _self.export_rule_html());
        });
    },

    //  tab按钮切换
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

    // layer_confirm确认
    layer_confirm:function (_t) {
        layer.confirm(_t, {
            icon: 0,
            btn: ['确定', '取消'],
            title: '提示',
            skin: 'layui-layer-me',
            yes: function (index) {
                //confirm确认回调
                layer.close(index);
            }
        });
    },
    
    //  删除
    del_inf:function () {
        var _self = this;
        $(".j-del").on('click', function () {
            _self.layer_confirm('注意：确定要删除**吗？');
        });
    },
    // 撤销
    undo_inf:function () {
        var _self = this;
        $(".j-undo").on('click', function () {
            _self.layer_confirm('注意：确定要撤销**吗？');
        });
    },

    //  上传图片
    upload_Img: function () {
        $("#headPortrait").change(function () {
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = " + objUrl);
            if (objUrl) {
                $("#uploading").attr("src", objUrl);
            }
        });

        //建立一個可存取到該file的url
        function getObjectURL(files) {
            var url = null;
            if (window.createObjectURL != undefined) { // basic
                url = window.createObjectURL(files);
            } else if (window.URL != undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(files);
            } else if (window.webkitURL != undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(files);
            }
            return url;
        }
    },



    //点击选择弹出框html
    select_val_html:function () {
        var selectHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
                    <div class="col-sm-12">\
                                <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                                    <section class="content">\
                                        <table class="table table-bordered my-table j-checked-input">\
                                            <thead>\
                                                <tr>\
                                                    <th>&nbsp;</th>\
                                                    <th>ID</th>\
                                                </tr>\
                                            </thead>\
                                            <tbody>\
                                                <tr><td><input type="radio" name="fieldRadio" id="fieldRadio1" value="会员名称"></td><td>会员名称</td></tr>\
                                                <tr><td><input type="radio" name="fieldRadio" id="fieldRadio2" value="年龄"></td><td>年龄</td></tr>\
                                                <tr><td><input type="radio" name="fieldRadio" id="fieldRadio3" value="名称"></td><td>名称</td></tr>\
                                            </tbody>\
                                        </table>\
                                        <div class="form-group pull-right">\
                                            <button type="submit" class="btn btn-my  margin-b-0 j-submit-btn">确定</button>\
                                            <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                        </div>\
                                    </section>\
                                </div></div></div></div>';
        return selectHtml;
    },

    //选择弹出框值选取
    get_select_val:function (selectId, index) {
        $(".j-submit-btn").on("click", function () {
            var radioVal = $('.j-checked-input').find('input:radio[name="fieldRadio"]:checked').val();
            if( radioVal == null) {
                layer.alert('您还没有选择！', {
                    skin: 'layui-layer-me',
                    closeBtn: 0,
                    shift: 4
                });
            } else {
                $("#" + selectId).val(radioVal);
                layer.close(index);
            }
        });
    },
    //点击选择打开弹出框
    get_select_layer:function () {
        var _self = this;
        $(".j-select-btn").on('click',function(){
            var selectId = $(this).prev("input").attr("id");
            var index = layer.open({
                type: 1,
                title: "选择",
                skin: 'layui-layer-me', //样式类名
                area: ['75%', '75%'],
                shift: 0,
                shade: 0.6,
                maxmin: true, //开启最大化最小化按钮
                content: _self.select_val_html(selectId),
            });
            //  选择弹出层点击取消关闭layer
            $(".j-cancel-btn").on("click", function () {
                layer.close(index);
            });
            _self.get_select_val(selectId, index);
        });
    }
};
