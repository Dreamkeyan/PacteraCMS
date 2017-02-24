/**
 * Created by pactera on 2016/9/9.
 */
var index;
var CRMcommon = {
    //  layer弹窗layer.open
    layer_boxs: function (_t, _area, _html) {
        var index = layer.open({
            type: 1,
            title: _t,
            skin: 'layui-layer-me', //样式类名
            area: _area,
            shift: 0,
            shade: 0.6,
            maxmin: true, //开启最大化最小化按钮
            content: _html
        });

        $(".j-cancel-btn ").on('click', function () {
            layer.close(index);
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

    //  多级树菜单treeview
    treeview_boxs: function (_n) {
        var _self = this;
        $('.j-tree' + _n).treeview({
            color: "#4a4a4a",
            selectedBackColor: "rgba(77, 156, 242, 0.3)",
            selectedColor: "#4a4a4a",
            expandIcon: 'fa fa-chevron-right',
            collapseIcon: 'fa fa-chevron-down',
            nodeIcon: 'fa fa-folder-open-o',
            data: _self.treeview_date()
        });
    },

    //  用户管理》添加用户html
    user_html: function () {
        var addUser = ' <div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form >' +
            '<div class="form-group">' +
            '<label for="Id">用户id</label>' +
            '<input type="text" id="Id" class="form-control" name="Id" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="chineseName">中文名称</label>' +
            '<input type="text" id="chineseName" class="form-control" name="chineseName" placeholder="请输入中文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="account">账号</label>' +
            '<input type="text" id="account" class="form-control" name="account" placeholder="请输入账号">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="password">密码</label>' +
            '<input type="text" id="password" class="form-control" name="password" placeholder="请输入密码">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="associationRole">关联角色</label>' +
            '<div class="clearfix">' +
            '<select class="form-control margin-b-10" title="请选择关联角色" name="associationRole" id="associationRole">' +
            '<option value="">请选择关联角色</option>' +
            '<option value="1">超级管理员</option>' +
            '<option value="2">模块管理员</option>' +
            '<option value="4">操作员</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="email">邮件地址</label>' +
            '<input type="text" id="email" class="form-control" name="email" placeholder="请输入邮件地址">' +
            '</div>' +
            '<div class="form-group">' +
            '<label class="radio-inline"><input type="radio" name="userStatus" id="Status1" value="1"><label for="Status1">启用</label></label>&nbsp;' +
            '<label class="radio-inline"><input type="radio" name="userStatus" id="Status2" value="0"><label for="Status2">禁用</label></label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="headPortrait" class="dis-b">头像</label>' +
            '<input type="file" name="headPortrait" id="headPortrait"  accept="image/jpeg" class="input-file">' +
            '<img class="headImg" id="uploading" src="../common/images/shangchuan.png" >' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addUser;
    },

    //  用户管理》打开添加/编辑用户layer
    establish_User: function () {
        var _self = this;
        $(".j-add ,.j-edit").on('click', function () {
            _self.layer_boxs('添加用户', ['80%', '80%'], _self.user_html());
            _self.upload_Img();
        })
    },

    //  用户管理》重置密码html
    password_html: function () {
        var addPassword = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<label class="alert alert-danger">注意：您正在修改用户***的登录密码，修改后请用新密码登录！</label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="newPassword">新密码</label>' +
            '<input type="password" class="form-control" name="password1" id="newPassword" placeholder="请输入新密码">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="twoPassword">新密码第二次</label>' +
            '<input type="password" class="form-control" name="password2" id="twoPassword" placeholder="请再输入一次">' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addPassword;
    },

    //  用户管理》打开重置密码layer
    establish_password: function () {
        var _self = this;
        $(".j-reset-password").on('click', function () {
            _self.layer_boxs('重置密码', ['50%', '50%'], _self.password_html());
        })
    },

    //  角色管理》添加角色html
    role_html: function () {
        var addRole = ' <div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<input type="text" id="roleId" class="form-control" name="roleId" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="roleName">角色名称</label>' +
            '<input type="text" id="roleName" class="form-control" name="roleName" placeholder="请输入中文名称">' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my ">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>';
        return addRole;
    },

    //  角色管理》打开添加/编辑用户layer
    establish_role: function () {
        var _self = this;
        //  添加角色
        $(".j-add  ,.j-edit").on('click', function () {
            _self.layer_boxs('添加角色', ['80%', '80%'], _self.role_html());
        });
    },

    //  授权管理》树列表
    treeview_date: function () {
        var treeData = [{
            text: '权限管理',
            href: '#jurisdiction',
            tags: ['2'],
            nodes: [{
                text: '用户管理',
                href: '#userControl',
                tags: ['0']

            }, {
                text: '角色管理',
                href: '#roleControl',
                tags: ['0']
            }, {
                text: '授权管理',
                href: '#accreditControl',
                tags: ['0']
            }]
        }, {
            text: '平台管理',
            href: '#platformControl',
            silent: true,
            tags: ['2'],
            state: {
                expanded: false,
            },
            nodes: [{
                text: '参数设置',
                href: '#parameterSetting',
                tags: ['0']

            }, {
                text: '平台信息',
                href: '#platformInf',
                tags: ['0']
            }, {
                text: '系统工具',
                href: '#systemTools',
                tags: ['0']
            }]
        }];
        return treeData;
    },

    //  授权管理》导入html
    lead_in: function () {
        var addLeadin = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<div class="alert alert-danger" role="alert">' +
            '注意!您正在导出文件（文件1、文件2）！' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="changeFile" class="dis-b">选择文件</label>' +
            '<input type="file" id="changeFile" name="changeFile">' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addLeadin;
    },

    //  授权管理》导出html
    export_html: function () {
        var addLeadin = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<div class="alert alert-danger" role="alert">' +
            '注意!您正在导出文件（文件1、文件2）！' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="changeFile" class="dis-b">选择文件</label>' +
            '<input type="file" id="changeFile" name="changeFile">' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addLeadin;
    },

    //  打开授权管理导入layer
    establish_leadin: function () {
        var _self = this;
        //  导入
        $(".j-import").on('click', function () {
            _self.layer_boxs('导入权限表', ['50%', '50%'], _self.lead_in());
        });
    },

    //  打开授权管理》导出layer
    establish_export: function () {
        var _self = this;
        //  导出
        $(".j-export").on('click', function () {
            _self.layer_boxs('导出权限表', ['50%', '50%'], _self.export_html());
        });
    },

    //  插件管理》注册html
    plugin_html: function () {
        var addPlugin = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<label for="Id">id</label>' +
            '<input type="text" id="Id" class="form-control" name="Id" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="chineseName">中文名称</label>' +
            '<input type="text" id="chineseName" class="form-control" name="chineseName" placeholder="请输入中文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="enName">中文名称</label>' +
            '<input type="text" id="enName" class="form-control" name="enName" placeholder="请输入中文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="plugin" class="dis-b">插件包</label>' +
            '<input type="file" id="plugin"  name="plugin" class="input-file" >' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addPlugin;
    },

    // 打开插件管理》注册页面
    establish_plugin: function () {
        var _self = this;
        //  导出
        $(".j-add ,.j-edit").on('click', function () {
            _self.layer_boxs('注册插件', ['80%', '80%'], _self.plugin_html());
        });
    },

    //插件管理》配置插件html
    configuration_html: function () {
        var addConfig = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<div class="alert alert-danger" role="alert">本页面显示插件的配置页面，该页面内容应在插件包中指明，或该插件不需要配置就可以使用</div>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addConfig;
    },

    //打开插件管理》配置插件
    establish_config: function () {
        var _self = this;
        //  导出
        $(".j-config").on('click', function () {
            _self.layer_boxs('配置插件', ['50%', '50%'], _self.configuration_html());
        });
    },

    //插件管理》导入
    establish_plugin_Import: function () {
        var _self = this;
        //  导入
        $(".j-import").on('click', function () {
            _self.layer_boxs('导入插件', ['50%', '50%'], _self.lead_in());
        });
    },

    //插件管理》导出
    establish_plugin_Export: function () {
        var _self = this;
        //  导出
        $(".j-export").on('click', function () {
            _self.layer_boxs('导出插件', ['50%', '50%'], _self.export_html());
        });
    },

    //  扩展管理》安装html
    extend_install_html: function () {
        var addInstall = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<div class="alert alert-danger" role="alert">' +
            '注意!您现在正在安装扩展**********。这个扩展是由******开发的，它的主要功能是：***************' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<img src="../common/images/bg.png"  class="headImg"/>' +
            '</div>' +
            '<div class="form-group">' +
            '<label >中文名称</label>' +
            '<div class="bg-primary">中文名称</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label >英文名称</label>' +
            '<div class="bg-primary">chajian名称</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label >开发者</label>' +
            '<div class="bg-primary">pactera</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">安装</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addInstall;
    },

    //  打开扩展管理》安装
    establish_install: function () {
        var _self = this;
        //  导出
        $(".j-install").on('click', function () {
            _self.layer_boxs('导出插件', ['80%', '80%'], _self.extend_install_html());
        });
    },
    //  扩展管理》注册html
    extend_register_html: function () {
        var addLeadin = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<label for="changeFile" class="dis-b">上传扩展包</label>' +
            '<input type="file" id="changeFile" name="changeFile">' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addLeadin;
    },
    //  打开扩展管理》注册
    establish_extend_register: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('注册', ['50%', '50%'], _self.extend_register_html());
        });
    },

    //  打开扩展管理》导入
    establish_extend_Import: function () {
        var _self = this;
        $(".j-import").on('click', function () {
            _self.layer_boxs('导入扩展', ['50%', '50%'], _self.lead_in());
        });
    },

    //  打开扩展管理》导出
    establish_extend_Export: function () {
        var _self = this;
        $(".j-export").on('click', function () {
            _self.layer_boxs('导出扩展', ['50%', '50%'], _self.export_html());
        });
    },

    //  数据标准化》字典管理》新建html
    standardization_dictionary_addHtml: function () {
        var addDictionary = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<label for="Id">id</label>' +
            '<input type="text" id="Id" class="form-control" name="Id" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="dicName">字典名称</label>' +
            '<input type="text" id="dicName" class="form-control" name="dicName" placeholder="请输入字典名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="enName">英文名称</label>' +
            '<input type="text" id="enName" class="form-control" name="enName" placeholder="请输入英文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="coding">编码</label>' +
            '<input type="text" id="coding" class="form-control" name="coding" placeholder="请输入编码">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="sortKey">排序码</label>' +
            '<input type="text" id="sortKey" class="form-control" name="sortKey" placeholder="请输入字典名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label class="radio-inline"><input type="radio" name="userStatus" id="Status1" value="1"><label for="Status1">启用</label>&nbsp;</label>' +
            '<label class="radio-inline"><input type="radio" name="userStatus" id="Status2" value="0"><label for="Status2">禁用</label>&nbsp;</label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addDictionary;
    },

    //  数据标准化》字典管理》新建打开
    establish_dictionary: function () {
        var _self = this;
        $(".j-add ,.j-edit ").on('click', function () {
            _self.layer_boxs('新建字典', ['80%', '80%'], _self.standardization_dictionary_addHtml());
        });
    },

    //  数据标准化》字典管理》导入
    establish_dictionary_Import: function () {
        var _self = this;
        $(".j-import").on('click', function () {
            _self.layer_boxs('导入', ['50%', '50%'], _self.lead_in());
        });
    },

    //  数据标准化》字典管理》导出
    establish_dictionary_Export: function () {
        var _self = this;
        $(".j-export").on('click', function () {
            _self.layer_boxs('导出', ['50%', '50%'], _self.export_html());
        });
    },

    //  数据标准化》字典项管理》新建html
    term_dictionary: function () {
        var addTermDic = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form >' +
            '<div class="form-group">' +
            '<label for="Id">id</label>' +
            '<input type="text" id="Id" class="form-control" name="Id" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="name">名称</label>' +
            '<input type="text" id="name" class="form-control" name="name" placeholder="请输入名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label class="radio-inline"><input type="radio" name="userStatus" id="Status1" value="1"><label for="Status1">启用</label></label>&nbsp;' +
            '<label class="radio-inline"><input type="radio" name="userStatus" id="Status2" value="0"><label for="Status2">禁用</label></label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="code">代码</label>' +
            '<input type="text" id="code" class="form-control" name="code" placeholder="请输入代码">' +
            '</div>' +
            '<div class="form-group">' +
            '<div class="checkbox"><label><input type="checkbox" id="stage"  name="stage" >是否末级</label></div>'+
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addTermDic;
    },

    //  数据标准化》字典项管理》新建打开
    establish_term_dictionary: function () {
        var _self = this;
        $(".j-add ,.j-edit ").on('click', function () {
            _self.layer_boxs('新建字典项管理', ['80%', '80%'], _self.term_dictionary());
        });
    },

    //  数据标准化》标准管理》新建html
    standard_management: function () {
        var addStandard = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<label for="Id">id</label>' +
            '<input type="text" id="Id" class="form-control" name="Id" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="chineseName">中文名称</label>' +
            '<input type="text" id="chineseName" class="form-control" name="chineseName" placeholder="请输入中文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="enName">英文名称</label>' +
            '<input type="text" id="enName" class="form-control" name="enName" placeholder="请输入英文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addStandard;
    },

    //  数据标准化》标准管理》新建打开
    establish_standard_management: function () {
        var _self = this;
        $(".j-add ,.j-edit ").on('click', function () {
            _self.layer_boxs('新建标准', ['80%', '80%'], _self.standard_management());
        });
    },

    //  数据标准化》标准管理》 重命名html
    standard_rechristen: function () {
        var addRechristen = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form >' +
            '<div class="form-group">' +
            '<div class="alert alert-danger" role="alert">注意：将要修改标准（标准名）的名称！</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="newName">输入新的名称</label>' +
            '<input type="text" id="newName" class="form-control" name="newName" placeholder="请输入输入新的名称">' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addRechristen;
    },

    //  数据标准化》标准管理》 重命名打开
    establish_standard_rechristen: function () {
        var _self = this;
        $(".j-rename").on('click', function () {
            _self.layer_boxs('重命名', ['50%', '50%'], _self.standard_rechristen());
        });
    },

    //  数据标准化》元数据管理》 添加html
    metadata_management: function () {
        var addMetadata = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<label>预览</label>' +
            '<img src="../common/images/bg.png"  class="headImg"/>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="Id">引用id</label>' +
            '<input type="text" id="Id" class="form-control" name="roleId" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="chName">中文名称</label>' +
            '<input type="text" id="chName" class="form-control" name="chName" placeholder="请输入中文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="enName">英文名称</label>' +
            '<input type="text" id="enName" class="form-control" name="enName" placeholder="请输入英文名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="enShort">英文短名</label>' +
            '<input type="text" id="enShort" class="form-control" name="enShort" placeholder="请输入英文短名">' +
            '</div>' +
            '<div class="form-group">' +
            '<label>数据类型</label>' +
            '<div class="clearfix">' +
            '<select class="form-control margin-b-10" title="请选择数据类型" name="province">' +
            '<option value="">请选择数据类型</option>' +
            '<option value="1">下拉选择</option>' +
            '<option value="2">网址</option>' +
            '<option value="3">手机号码</option>' +
            '<option value="4">只有数字</option>' +
            '<option value="5">只有字母</option>' +
            '<option value="6">整型</option>' +
            '<option value="7">字符型</option>' +
            '<option value="8">单行文本</option>' +
            '<option value="9">多行文本</option>' +
            '<option value="10">下拉</option>' +
            '<option value="11">颜色选择</option>' +
            '<option value="12">文件上传</option>' +
            '<option value="13">百度地图</option>' +
            '<option value="14">字段分组合并</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>控件类型</label>' +
            '<div class="clearfix">' +
            '<select class="form-control margin-b-10" title="请选择控件类型" name="province">' +
            '<option value="">请选择控件类型</option>' +
            '<option value="">年/月/日 hh:mm:ss</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>校验类型</label>' +
            '<div class="clearfix">' +
            '<select class="form-control margin-b-10" title="请选择校验类型" name="province">' +
            '<option value="">请选择校验类型</option>' +
            '<option value="1">网址</option>' +
            '<option value="2">手机号码</option>' +
            '<option value="3">只有数字</option>' +
            '<option value="4">只有字母</option>' +
            '<option value="5">数字和字母</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="range">值域</label>' +
            '<div class="input-group">' +
            '<input type="text" id="range" name="range" class="form-control j-passVal" readonly>' +
            '<span class="input-group-btn"><button type="button" class="btn btn-my margin-r-0 j-change">选择</button></span>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="dataLength">数据长度</label>' +
            '<input type="text" id="dataLength" class="form-control" name="dataLength" placeholder="请输入数据长度">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="scale">小数点位数</label>' +
            '<input type="text" id="scale" class="form-control" name="scale" placeholder="请输入小数点位数">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="maxLength">最大出现位数</label>' +
            '<input type="text" id="maxLength" class="form-control" name="maxLength" placeholder="请输入数据长度">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="default">默认值</label>' +
            '<input type="text" id="default" class="form-control" name="default" placeholder="请输入数据长度">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addMetadata;
    },

    //  数据标准化》元数据管理》 添加打开
    establish_metadata_management: function () {
        var _self = this;
        $(".j-add ,.j-edit").on('click', function () {
            _self.layer_boxs('添加元数据', ['80%', '80%'], _self.metadata_management());
            _self.establish_metadata_change();
        });
    },

    //  数据标准化》元数据管理》 添加》 添加弹框 》选择html
    metadata_management_change_html: function () {
        var changeTable = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix">' +
            '<div class="treeview  j-tree1"></div>' +
            '<table class="table table-bordered my-table">' +
            '<thead>' +
            '<tr>' +
            '<th></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '<tr>' +
            '<th><input name="newtable" type="radio" value="1"></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '<tr>' +
            '<th><input name="newtable" type="radio" value="2"></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '<tr>' +
            '<th><input name="newtable" type="radio" value="3"></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '</tbody>' +
            '</table>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my j-confirm">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return changeTable;
    },

    //   数据标准化》元数据管理》 添加》 添加弹框 》选择打开
    establish_metadata_change: function () {
        var _self = this;
        $(".j-change").on('click', function () {
            var changeIndex = layer.open({
                type: 1,
                title: '值域',
                skin: 'layui-layer-me', //样式类名
                area: ['70%', '70%'],
                shift: 0,
                shade: 0.6,
                maxmin: true, //开启最大化最小化按钮
                content: _self.view_maintenance_change_html()
            });

            //  第二层弹框选择值关闭传递
            $(".j-confirm").on('click', function () {
                var inputVal = $('input:radio[name="newtable"]:checked').val();
                if (inputVal == null) {
                    layer.msg('您还没有选择！')
                } else {
                    $('.j-passVal').val(inputVal);
                    layer.close(changeIndex);
                }
            });

            //  第二层取消关闭
            $(".j-cancel-btn ").on('click', function () {
                layer.close(changeIndex);
            });
        });
    },

    //  建模管理》视图维护/模型管理》 添加html
    view_maintenance: function () {
        var addView = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form>' +
            '<div class="form-group">' +
            '<label for="Id">字段id</label > ' +
            '<input type="text" id="Id" class="form-control" name="Id" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="associationRole">字段类型</label>' +
            '<div class="clearfix">' +
            '<select class="form-control margin-b-10" title="请选择字段类型" name="associationRole" id="associationRole">' +
            '<option value="">请选择字段类型</option>' +
            '<option value="1">数据字段</option>' +
            '<option value="2">功能字段</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="showName">显示名称</label>' +
            '<input type="text" id="showName" class="form-control" name="showName" placeholder="请输入显示名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="enName">英文名称</label>' +
            '<input type="text" id="enName" class="form-control" name="enName" placeholder="请输入显示名称">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="quote">引用功能系统</label>' +
            '<div class="input-group my-form no-pull w100">' +
            '<input type="text" id="quote" name="quote" class="form-control j-passVal" readonly>' +
            '<span class="input-group-btn"><button type="button" class="btn btn-my margin-r-0 j-change">选择</button></span>' +
            '</div>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>可见：</label>' +
            '<label class="radio-inline"><input type="radio" name="visible" id="Status1" checked><label for="Status1">是</label></label>&nbsp;' +
            '<label class="radio-inline"><input type="radio" name="visible" id="Status2"><label for="Status2">否</label></label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>可空：</label>' +
            '<label class="radio-inline padding-t-1"><input type="radio" name="nullable" id="Status3" checked><label for="Status3">是</label></label>&nbsp;' +
            '<label class="radio-inline padding-t-1"><input type="radio" name="nullable" id="Status4"><label for="Status4">否</label></label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>必填：</label>' +
            '<label class="radio-inline padding-t-1"><input type="radio" name="required" id="Status5" checked><label for="Status5">是</label></label>&nbsp;' +
            '<label class="radio-inline padding-t-1"><input type="radio" name="required" id="Status6"><label for="Status6">否</label></label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label>是否列表选项：</label>' +
            '<label class="radio-inline padding-t-1"><input type="radio" name="list" id="Status7" checked><label for="Status7">是</label></label>&nbsp;' +
            '<label class="radio-inline padding-t-1"><input type="radio" name="list" id="Status8"><label for="Status8">否</label></label>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addView;
    },

    //  建模管理》视图维护/模型管理》 添加打开
    establish_view_maintenance: function () {
        var _self = this;
        $(".j-add ,.j-edit").on('click', function () {
            _self.layer_boxs('添加字段', ['80%', '80%'], _self.view_maintenance());
            _self.establish_view_change();
        });
    },

    //  建模管理》视图维护/模型管理》 添加弹框 》选择html
    view_maintenance_change_html: function () {
        var changeTable = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix">' +
            '<table class="table table-bordered my-table">' +
            '<thead>' +
            '<tr>' +
            '<th></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '<tr>' +
            '<th><input name="newtable" type="radio" value="1"></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '<tr>' +
            '<th><input name="newtable" type="radio" value="2"></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '<tr>' +
            '<th><input name="newtable" type="radio" value="3"></th>' +
            '<th>id</th>' +
            '<th>元数据名称</th>' +
            '<th>元数据英文名称</th>' +
            '<th>状态</th>' +
            '</tr>' +
            '</tbody>' +
            '</table>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my j-confirm">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return changeTable;
    },

    //  建模管理》视图维护/模型管理》 添加弹框 》选择打开
    establish_view_change: function () {
        var _self = this;
        $(".j-change").on('click', function () {
            var changeIndex = layer.open({
                type: 1,
                title: '添加字段',
                skin: 'layui-layer-me', //样式类名
                area: ['80%', '80%'],
                shift: 0,
                shade: 0.6,
                maxmin: true, //开启最大化最小化按钮
                content: _self.view_maintenance_change_html()
            });

            //  第二层弹框选择值关闭传递
            $(".j-confirm").on('click', function () {
                var inputVal = $('input:radio[name="newtable"]:checked').val();
                if (inputVal == null) {
                    layer.msg('您还没有选择！')
                } else {
                    $('.j-passVal').val(inputVal);
                    layer.close(changeIndex);
                }
            });
            //  第二层取消关闭
            $(".j-cancel-btn ").on('click', function () {
                layer.close(changeIndex);
            });
        });
    },

    //  建模管理》视图维护》 重命名打开
    establish_view_raname: function () {
        var _self = this;
        $(".j-rename").on('click', function () {
            _self.layer_boxs('重命名', ['50%', '50%'], _self.standard_rechristen());
        });
    },

    //  建模管理》视图维护》 视图维护html
    view_maintenance_html: function () {
        var addViewMain = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="input-group my-form">' +
            '<input type="text" placeholder="Search for..." class="form-control">' +
            '<span class="input-group-btn">' +
            '<button type="button" class="btn btn-my">查找</button>' +
            '</span>' +
            '</div>' +
            '</div>' +
            '<div class="ibox-content ho">' +
            '<div class="clearfix">' +
            '<div class="treeview  j-tree2"></div>' +
            '<div class="pull-left width-120 padding-l-r-10">' +
            '<dl>' +
            '<dt>' +
            '包含字段' +
            '</dt>' +
            '<dd>' +
            '<a href="javascript:;">xx</a>' +
            '</dd>' +
            '<dd>' +
            '<a href="javascript:;">aa</a>' +
            '</dd>' +
            '</dl>' +
            '</div>' +
            '<section class="content">' +
            '<div class="tab-group ho" id="j-tab">' +
            '<a href="#tab1" class="cur">单页</a>' +
            '<a href="#tab2">table</a>' +
            '<a href="#tab3">分类</a>' +
            '</div>' +
            '<div class="tabs ho">' +
            '<!--切换区域1 bg-->' +
            '<div id="tab1" class="tab active">' +
            '<textarea class="form-control" rows="20">单页代码 单页代码 单页代码 单页代码 单页代码 单页代码 </textarea>' +
            '</div>' +
            '<!--切换区域1 end-->' +
            '<!--切换区域2 bg-->' +
            '<div id="tab2" class="tab">' +
            '<textarea class="form-control" rows="20">tabletabletabletabletabletabletabletabletabletabletable </textarea>' +
            '</div>' +
            '<!--切换区域2 end-->' +
            '<!--切换区域3 bg-->' +
            '<div id="tab3" class="tab">' +
            '<textarea class="form-control" rows="20">分类 分类 分类 分类  分类 分类 分类 分类 分类 分类 分类 分类</textarea>' +
            '</div>' +
            '<!--切换区域3 end-->' +
            '</div>' +
            '<div class="ho">' +
            '<button type="button" class="btn btn-my pull-right">预览</button>' +
            '<button type="button" class="btn btn-my pull-right">保存</button>' +
            '<button type="button" class="btn btn-my pull-right">导出</button>' +
            '</div>' +
            '</section>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addViewMain;
    },

    //  建模管理》视图维护》 视图维护打开
    establish_view_maintenance_open: function () {
        var _self = this;
        $(".j-view").on('click', function () {
            _self.layer_boxs('视图维护', ['80%', '80%'], _self.view_maintenance_html());
            _self.tab_init();
            // _self.treeview_boxs(2);
        });
    },

    //  平台管理》模块注册》 注册模块 html
    register_module: function () {
        var addRegisterModule = '<div class="wrapper wrapper-content">' +
            '<div class="row">' +
            '<div class="col-sm-12">' +
            '<div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">' +
            '<form >' +
            '<div class="form-group">' +
            '<label for="Id">模块id</label>' +
            '<input type="text" id="Id" class="form-control" name="Id" value="132456789" readonly>' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="authCode">授权码</label>' +
            '<input type="text" id="authCode" class="form-control" name="authCode" placeholder="请输入授权码">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="installation" class="dis-b">安装包</label>' +
            '<input type="file" id="installation" name="installation" class="input-file">' +
            '</div>' +
            '<div class="form-group">' +
            '<label for="describe">描述</label>' +
            '<textarea class="form-control" name="userDesc" id="describe" placeholder="描述" rows="4"></textarea>' +
            '</div>' +
            '<div class="form-group pull-right">' +
            '<button type="submit" class="btn btn-my">确定</button>' +
            '<button type="button" class="btn btn-default mar-b4 j-cancel-btn">取消</button>' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        return addRegisterModule;
    },

    //  平台管理》模块注册》 注册模块打开
    establish_register_module: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('注册模块', ['80%', '80%'], _self.register_module());
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

    //  删除
    del_inf:function () {
        var _self = this;
        $(".j-del").on('click', function () {
            _self.layer_confirm('注意：确定要删除**吗？');
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
    }
}






