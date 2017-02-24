/**
 * Created by Chenyduan on 2016/8/22.
 */
var websitCommon = {
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
        $(".j-cancel-btn ").on('click', function () {
            layer.close(index);
        });
    },


    //网站站点管理新建站点html
    add_websit_html: function () {
        var addHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
					<div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm">\
                                <div class="form-group">\
                                    <label for="websiteId">id</label>\
                                    <input type="text" id="websiteId"  class="form-control" name="id"  value="132456789" readonly>\
                                </div>\
                                <div class="form-group">\
                                    <label for="websiteCname">中文名称</label>\
                                    <input type="text" id="websiteCname"  class="form-control" name="name" placeholder="请输入中文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="websiteMarking">站点标识</label>\
                                    <input type="text" id="websiteMarking"  class="form-control" name="websiteMarking" placeholder="请输入站点标识">\
                                </div>\
                                <div class="form-group">\
                                    <label for="websiteEname">英文名称</label>\
                                    <input type="text" id="websiteEname"  class="form-control" name="name" placeholder="请输入英文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="websiteDesc">描述</label>\
                                    <textarea class="form-control" name="desc" id="websiteDesc" placeholder="描述" rows="4"></textarea>\
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
        return  addHtml;
    },
    // 打开站点管理新建站点layer
    add_websit: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('新建站点', ['80%', '80%'], _self.add_websit_html());
        });
    },
    edit_websit: function () {
        var _self = this;
        $(".j-edit").on('click', function () {
            _self.layer_boxs('编辑站点', ['80%', '80%'], _self.add_websit_html());
        });
    },

    // 会员审核重置密码html
    reset_pwd_html: function () {
        var resetPwdHtml = '<div class="wrapper wrapper-content">\
                <div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm">\
                                <div class="form-group">\
                                    <label for="password1" class="col-sm-2 control-label">新密码</label>\
                                    <div class="col-sm-10"><input type="password" class="form-control" name="password1" id="password1" placeholder="请输入新密码"></div>\
                                </div>\
                                <div class="form-group">\
                                    <label for="password2" class="col-sm-2 control-label">新密码第二次</label>\
                                    <div class="col-sm-10"><input type="password" class="form-control" name="password2" id="password2" placeholder="请再次输入密码"></div>\
                                </div>\
                                <div class="form-group">\
                                    <label class="col-sm-2 control-label"></label>\
                                    <div class="alert alert-danger">注意：您正在修改用户***的登录密码，修改后请用新密码登录！</div>\
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
            _self.layer_boxs('重置密码', ['80%', '80%'], _self.reset_pwd_html());
        });
    },

    //网站页面管理添加页面html
    add_page_html: function () {
        var addHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
					<div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm"  class="form-horizontal">\
                                <div class="form-group">\
                                    <label for="pageId">id</label>\
                                    <input type="text" id="pageId"   class="form-control"  name="pageId"  value="132456789" readonly>\
                                </div>\
                                <div class="form-group">\
                                    <label for="pageName">中文名称</label>\
                                    <input type="text" id="pageName"  class="form-control"  name="pageName" placeholder="请输入中文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="pageFileName">文件名称</label>\
                                    <input type="text" id="pageFileName"  class="form-control"  name="pageFileName" placeholder="请输入文件名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="pageTemplate">关联模板</label>\
                                    <div class="input-group my-form w100">\
                                        <input type="text" name="pageTemplate"  class="form-control"  id="pageTemplate" placeholder="请选择关联模板" readonly>\
                                        <span class="input-group-btn">\
                                            <button type="button" id="changeTemplate" class="btn btn-my margin-r-0 j-select-btn">选择</button>\
                                        </span>\
                                    </div>\
                                </div>\
                                <div class="form-group">\
                                    <label for="pageDesc">描述</label>\
                                    <textarea class="form-control" name="pageDesc" id="pageDesc" placeholder="描述" rows="4"></textarea>\
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
        return  addHtml;
    },
    // 打开网站页面管理添加页面layer
    add_page: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('添加页面', ['80%', '80%'], _self.add_page_html());
            _self.get_select_layer();
        });
    },
    edit_page: function () {
        var _self = this;
        $(".j-edit").on('click', function () {
            _self.layer_boxs('编辑页面', ['80%', '80%'], _self.add_page_html());
            _self.get_select_layer();
        });
    },

    // 网站页面管理重命名html
    reset_page_name_html: function () {
        var resetNameHtml = '<div class="wrapper wrapper-content">\
            <div class="row">\
					<div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm" class="form-horizontal">\
                                <div class="form-group">\
                                    <label for="newName" class="col-sm-2 text-right control-label">新的名称</label>\
                                    <div class="col-sm-10">\
                                        <input type="text" class="form-control" name="newName" id="newName" >\
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
        return resetNameHtml;
    },
    // 打开网站页面管理重命名layer
    reset_page_name: function () {
        var _self = this;
        $(".j-rename").on('click', function () {
            _self.layer_boxs('重命名', ['60%', '30%'], _self.reset_page_name_html());
        });
    },

    //网站域名管理添加域名html
    add_domain_html: function () {
        var addHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
					<div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm"  class="form-horizontal">\
                                <div class="form-group">\
                                    <label for="domainId">id</label>\
                                    <input type="text" id="domainId"  class="form-control" name="id"  value="132456789" readonly>\
                                </div>\
                                <div class="form-group">\
                                    <label for="domainName">域名</label>\
                                    <input type="text" id="domainName"  class="form-control" name="name" placeholder="请输入中文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="domainDesc">描述</label>\
                                    <textarea class="form-control" name="desc" id="domainDesc" placeholder="描述" rows="4"></textarea>\
                                </div>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default  j-cancel-btn">取消</button>\
                                </div>\
                            </form>\
                        </div>\
                    </div>\
				</div>\
			</div>';

        return  addHtml;
    },
    // 打开网站域名管理添加域名layer
    add_domain: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('添加域名', ['80%', '80%'], _self.add_domain_html());
        });
    },
    edit_domain: function () {
        var _self = this;
        $(".j-edit").on('click', function () {
            _self.layer_boxs('编辑域名', ['80%', '80%'], _self.add_domain_html());
        });
    },

    //网站栏目管理添加页面html
    add_part_html: function () {
        var addHtml = '<div class="wrapper wrapper-content">\
            <div class="row">\
                <div class="col-sm-12">\
                    <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                        <form  id="commentForm">\
                            <div class="tab-group ho" id="j-tab">\
                                <a href="#tab1" class="cur">基本属性</a>\
                                <a href="#tab2">权限属性</a>\
                                <a href="#tab3">功能属性</a>\
                            </div>\
                            <div class="tabs ho">\
                                <div id="tab1" class="tab active">\
                                    <div class="form-group">\
                                        <label for="partId">id</label>\
                                        <input type="text" id="partId"  class="form-control" name="partId" value="132456789" readonly>\
                                    </div>\
                                    <div class="form-group">\
                                        <label>目录形式</label>\
                                        <div class="clearfix">\
                                            <select class="form-control my-form w100" title="请选择目录形式" name="directoryStyle">\
                                                <option value="">请选择目录形式</option>\
                                                <option value="1">单页目录</option>\
                                                <option value="2">一般目录</option>\
                                                <option value="3">功能目录</option>\
                                            </select>\
                                        </div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="partName">中文名称</label>\
                                        <input type="text" id="partName"  class="form-control" name="partName" placeholder="请输入中文名称">\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="partEname">英文名称</label>\
                                        <input type="text" id="partEname"  class="form-control" name="partEname" placeholder="请输入英文名称">\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="partLink">跳转地址</label>\
                                        <input type="text" id="partLink" class="form-control" name="partLink" placeholder="请输入跳转链接">\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="indexModel">首页模板</label>\
                                        <div class="input-group my-form no-pull w100">\
                                            <input type="text" id="indexModel" name="indexModel" class="form-control" placeholder="请选择首页模板" readonly>\
                                            <span class="input-group-btn j-select-btn">\
                                                <button type="button" class="btn btn-my margin-r-0 changeTemplate">选择</button>\
                                            </span>\
                                        </div>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="listPageModel">列表页模板</label>\
                                        <div class="input-group my-form no-pull w100 ">\
                                            <input type="text" id="listPageModel" name="listPageModel" class="form-control" placeholder="请选择列表页模板" readonly>\
                                            <span class="input-group-btn j-select-btn">\
                                                <button type="button" class="btn btn-my margin-r-0 changeTemplate">选择</button>\
                                            </span>\
                                        </div>\
                                    </div>\
                                    <div class="form-group  j-content-object">\
                                        <label>内容对象</label>\
                                        <input type="hidden" id="addObject" name="addObject">\
                                        <button type="button" class="btn btn-my show j-select-btn">添加</button>\
                                    </div>\
                                </div>\
                                <div id="tab2" class="tab">\
                                    <div class="form-group">\
                                        <label for="maintainer">维护人员</label>\
                                        <input type="hidden" id="maintainer" class="form-control j-select-val">\
                                        <div class="input-group my-form no-pull  j-select-btn">\
                                            <button type="button" class="btn btn-my">选择</button>\
                                        </div>\
                                    </div>\
                                    <div class="form-group">\
                                        <table class="table table-bordered my-table j-authority-table" id="maintainerTable">\
                                            <thead>\
                                                <tr>\
                                                    <th>用户id</th>\
                                                    <th>用户名称</th>\
                                                    <th>账号</th>\
                                                    <th>建立时间</th>\
                                                </tr>\
                                            </thead>\
                                            <tbody>\
                                            </tbody>\
                                        </table>\
                                    </div>\
                                    <div class="form-group">\
                                        <label for="accessAuthority">访问权限</label>\
                                        <input type="hidden" id="accessAuthority" class="form-control j-select-val">\
                                        <div class="input-group my-form no-pull j-select-btn">\
                                            <button type="button" class="btn btn-my">选择</button>\
                                        </div>\
                                    </div>\
                                    <div class="form-group">\
                                        <table class="table table-bordered my-table j-authority-table" id="accessAuthorityTable">\
                                            <thead>\
                                                <tr>\
                                                    <th>会员id</th>\
                                                    <th>会员等级</th>\
                                                </tr>\
                                            </thead>\
                                            <tbody>\
                                            </tbody>\
                                        </table>\
                                    </div>\
                                </div>\
                                <div id="tab3" class="tab">\
                                    <div class="form-group">\
                                        <label>目录可见</label><br>\
                                        <label class="radio-inline"><input type="radio" name="isDirectoryVisible" id="isDirectoryVisible1" value="option1">是</label>\
                                        <label class="radio-inline"><input type="radio" name="isDirectoryVisible" id="isDirectoryVisible2" value="option2">否</label>\
                                    </div>\
                                    <div class="form-group">\
                                        <label>允许评论</label><br>\
                                        <label class="radio-inline"><input type="radio" name="allowComment" id="allowComment1" value="1">是</label>\
                                        <label class="radio-inline"><input type="radio" name="allowComment" id="allowComment2" value="0">否</label>\
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
        return  addHtml;
    },
    // 打开网站栏目管理添加页面layer
    add_part: function () {
        var _self = this;
        $(".j-add").on('click', function () {
            _self.layer_boxs('添加栏目', ['80%', '80%'], _self.add_part_html());
            //tab初始化
            _self.tab_init();
            _self.get_select_layer();
        });
    },
    // 打开网站栏目管理编辑页面layer
    edit_part: function () {
        var _self = this;
        $(".j-edit").on('click', function () {
            _self.layer_boxs('编辑栏目', ['80%', '80%'], _self.add_part_html());
            //tab初始化
            _self.tab_init();
            _self.get_select_layer();
        });
    },
    //网站栏目管理添加页面html
    move_part_html: function () {
        var moveHtml = '<div class="wrapper wrapper-content">\
            <div class="row">\
                <div class="col-sm-12">\
                    <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                        <form  id="commentForm" class="form-horizontal">\
                            <div class="form-group">\
                                <label class="col-sm-2">&nbsp;</label>\
                                <label class="col-sm-10 layer-notice-area">注意：请选择移动到的位置，只能在本站内移动！</label>\
                            </div>\
                            <div class="form-group">\
                                <div class="col-sm-2">\
                                    <div id="movePartTree" class="test treeview"></div>\
                                 </div>\
                                <div class="col-sm-10">\
                                    <div class="radio">\
                                        <label><input type="radio" name="partMove" id="thisPrevRadio" value="1">当前节点之前</label>\
                                    </div>\
                                    <div class="radio">\
                                        <label><input type="radio" name="partMove" id="thisNextRadio" value="2">当前节点之后</label>\
                                    </div>\
                                    <div class="radio">\
                                        <label><input type="radio" name="partMove" id="prevRadio" value="3">下一级</label>\
                                    </div>\
                                    <div class="radio">\
                                        <label><input type="radio" name="partMove" id="nextRadio" value="4">上一级</label>\
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
        return  moveHtml;
    },
    // 打开网站栏目管理移动页面layer
    move_part: function () {
        var _self = this;
        $(".j-move").on('click', function () {
            _self.layer_boxs('移动栏目', ['80%', '80%'], _self.move_part_html());
        });
    },
    // 网站标签与模板 重命名html
    reset_name_html: function () {
        var resetNameHtml = '<div class="wrapper wrapper-content">\
                <div class="row">\
					<div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm" class="form-horizontal">\
                                <div class="form-group">\
                                    <label for="ChineseName" class="col-sm-2 text-right control-label">新的中文名</label>\
                                    <div class="col-sm-10">\
                                        <input type="text" class="form-control" name="ChineseName" id="ChineseName" >\
                                    </div>\
                                </div>\
                                <div class="form-group">\
                                    <label for="enName" class="col-sm-2 text-right control-label">新的英文名</label>\
                                    <div class="col-sm-10">\
                                        <input type="text" class="form-control" name="enName" id="enName" >\
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
        return resetNameHtml;
    },
    // 打开网站标签与模板重命名layer
    reset_name: function () {
        var _self = this;
        $(".j-rename").on('click', function () {
            _self.layer_boxs('重命名', ['50%', '50%'], _self.reset_name_html());
        });
    },


    //网站添加模板/标签html
    model_mark_html: function () {
        var addHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
					<div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm">\
                                <div class="form-group">\
                                    <label for="fieldId">id</label>\
                                    <input type="text" id="fieldId"  class="form-control" name="fieldId"  value="123456789">\
                                </div>\
                                <div class="form-group">\
                                    <label>&nbsp;</label>\
                                    <label class="radio-inline"><input type="radio" name="addpage" id="addpage0" value="0" checked>发布</label>\
                                    <label class="radio-inline"><input type="radio" name="addpage" id="addpage1" value="1">撤销</label>\
                                </div>\
                                <div class="form-group">\
                                    <label for="ChineseName">中文名称</label>\
                                    <input type="text" id="ChineseName"  class="form-control" name="ChineseName" placeholder="请输入中文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="enName">英文名称</label>\
                                    <input type="text" id="enName"  class="form-control" name="enName" placeholder="请输入英文名称">\
                                </div>\
                                <div class="form-group">\
                                    <label for="desc">描述</label>\
                                    <textarea class="form-control" name="desc" id="desc" placeholder="描述" rows="4"></textarea>\
                                </div>\
                                <div class="form-group">\
                                    <label for="code">代码</label>\
                                    <textarea class="form-control" name="code" id="code" placeholder="代码" rows="10"></textarea>\
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
        return addHtml;
    },
    //打开添加标签/模板layer
    add_mark: function () {
        var _self = this;
        $(".j-add-mark").on('click', function () {
            _self.layer_boxs('添加标签', ['80%', '80%'], _self.model_mark_html());
        });
    },
    add_model: function () {
        var _self = this;
        $(".j-add-model").on('click', function () {
            _self.layer_boxs('添加模板', ['80%', '80%'], _self.model_mark_html());
        });
    },
    //打开编辑标签/模板layer
    edit_mark_model: function () {
        var _self = this;
        $(".j-edit").on('click', function () {
            _self.layer_boxs('编辑', ['80%', '80%'], _self.model_mark_html());
        });
    },

    // 添加分类目录html
    add_catalogue_html: function () {
        var add_catalogue = '<div class="wrapper wrapper-content">\
                <div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm">\
                                <div class="form-group">\
                                    <label for="catalogue">目录名称</label>\
                                    <input type="text" id="catalogue"  class="form-control" name="catalogue" placeholder="请输入目录名称">\
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
        return add_catalogue;
    },
    // 打开添加分类目录layer
    add_catalogue: function () {
        var _self = this;
        $(".j-catalogue").on('click', function () {
            _self.layer_boxs('添加分类目录', ['50%', '50%'], _self.add_catalogue_html());
        });
    },

    // 网站资源上传文件html
    upload_file_html: function () {
        var uploadFileHtml = '<div class="wrapper wrapper-content">\
				<div class="row">\
                    <div class="col-sm-12">\
                        <div class="clearfix" style="max-width: 800px; margin: 0 auto; padding: 12px;">\
                            <form  id="commentForm" class="form-horizontal">\
                               <div class="form-group">\
                                    <label for="uploadFile" class="col-sm-2 text-right control-label">选择文件</label>\
                                    <div class="col-sm-10"><input type="file" name="uploadFile" id="uploadFile"></div>\
                               </div>\
                               <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                               </div>\
                            </form>\
                        </div></div></div></div>';
        return uploadFileHtml;
    },
    // 打开网站资源上传文件layer
    upload_file: function () {
        var _self = this;
        $(".j-upload").on('click', function () {
            _self.layer_boxs('上传文件', ['50%', '50%'], _self.upload_file_html());
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
        // icon
        $("#iconSrc").change(function () {
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = " + objUrl);
            if (objUrl) {
                $("#uploadingIcon").attr("src", objUrl);
            }
        });
        // 水印
        $("#watermarkSrc").change(function () {
            var objUrl = getObjectURL(this.files[0]);
            console.log("objUrl = " + objUrl);
            if (objUrl) {
                $("#uploadingWatermark").attr("src", objUrl);
            }
        });
        /*建立一個可存取到該file的url*/
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

    //打开选择弹出框html
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
    //打开选择弹出框

   select_layer_box:function (_t, _content) {
        var selectIndex = layer.open({
            type: 1,
            title: "选择" + _t,
            skin: 'layui-layer-me', //样式类名
            area: ['70%', '70%'],
            shift: 0,
            shade: 0.6,
            maxmin: true, //开启最大化最小化按钮
            content: _content,
        });

        //  选择弹出层点击取消关闭layer
        $(".j-cancel-btn").on("click", function () {
            layer.close(selectIndex);
        });
       localStorage.setItem("selectIndex",selectIndex);
    },

    //选择弹出框值选取
   get_select_val:function (selectId) {
        var _self = this;
        $(".j-submit-btn").on("click", function () {
            var radioVal = $('.j-checked-input').find('input:radio[name="fieldRadio"]:checked').val();
            if( radioVal == '') {
                layer.alert('您还没有选择！', {
                    skin: 'layui-layer-me',
                    closeBtn: 0,
                    shift: 4
                });
            } else {
                $("#" + selectId).val(radioVal);
                if( selectId == "addObject" ){//对象选择添加
                    i++;
                    var str = '<div class="form-group j-object-item">'
                        + '<label for="listPageModel"  class="add-object-label">'+ radioVal +'</label>'
                        + '<div class="input-group my-form pull-left w60 j-select-object-layer"><input type="text" class="form-control" name="object_' + i + '" id="object_' + i + '" readonly>'
                        + '<div class="input-group-btn j-select-btn"><button  class="btn btn-my changeTemplate" type="button">选择</button></div></div><button class="btn btn-default j-delete-btn pull-left" type="button">删除</button>'
                        + '</div>';
                    $(".j-content-object").append(str);

                    $(".j-delete-btn").on("click",function () {
                        $(this).parents(".j-object-item").remove();
                    });
                }
                if( selectId == 'maintainer'){//维护人员选择追加到table里
                    var str = '<tr><td>123456</td><td>管理员1</td><td>admin</td><td>2016-05-02</td></tr>';
                    $("#maintainerTable tbody").append(str);
                }
                if( selectId == 'accessAuthority'){//访问权限选择追加到table里
                    var str = '<tr><td>123456</td><td>一级</td></tr>';
                    $("#accessAuthorityTable tbody").append(str);
                }
                layer.close(localStorage.getItem("selectIndex"));
                localStorage.clear();
            }
        });
    },

    get_select_layer:function () {
        var _self = this;
        $(".j-select-btn").on("click", function () {
            var selectId = $(this).prev("input").attr("id");
            var selectName = '选择某某'
            _self.select_layer_box(selectName, _self.select_val_html(selectId));
            _self.get_select_val(selectId);
        });
    }
};






















































/* 选择按钮 */
var i = 0;
function getSelectLayer(obj){
    var changeTable = '';
    console.log(obj);
    switch (obj) {
        //基本属性-选择首页模板
        case "indexModel":
            changeTable = '<div class="wrapper wrapper-content">\
				<div class="row">\
                    <div class="col-sm-12">\
                        <div class="ibox float-e-margins">\
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
                                        <button type="submit" class="btn btn-my margin-b-0 j-submit-btn">确定</button>\
                                        <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                    </div>\
                                </section>\
                            </div></div></div></div>';
            break;
        //基本属性-选择列表页模板
        case "listPageModel":
            changeTable = '<div class="wrapper wrapper-content">\
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
                                    <button type="submit" class="btn btn-my margin-b-0 j-submit-btn">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                </div>\
                            </section>\
                        </div></div></div></div>';
            break;
        //基本属性-内容对象选择
        case "addObject":
            changeTable = '<div class="wrapper wrapper-content">\
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
                                        <tr><td><input type="radio" name="fieldRadio" id="fieldRadio1" value="名称"></td><td>会员名称</td></tr>\
                                        <tr><td><input type="radio" name="fieldRadio" id="fieldRadio2" value="年龄"></td><td>年龄</td></tr>\
                                        <tr><td><input type="radio" name="fieldRadio" id="fieldRadio3" value="名称"></td><td>名称</td></tr>\
                                    </tbody>\
                                </table>\
                                <div class="form-group pull-right">\
                                    <button type="submit" class="btn btn-my margin-b-0 j-submit-btn">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                </div>\
                            </section>\
                        </div></div></div></div>';
            break;
        //权限属性-维护人员选择
        case "maintainer":
            changeTable = '<div class="wrapper wrapper-content">\
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
                                    <button type="submit" class="btn btn-my margin-b-0 j-submit-btn">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                </div>\
                            </section>\
                        </div></div></div></div>';
            break;
        //权限属性-访问权限选择
        case "accessAuthority":
            changeTable = '<div class="wrapper wrapper-content">\
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
                                    <button type="submit" class="btn btn-my margin-b-0 j-submit-btn">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                </div>\
                            </section>\
                        </div></div></div></div>';
            break;
        default:
            changeTable = '<div class="wrapper wrapper-content">\
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
                                    <button type="submit" class="btn btn-my margin-b-0 j-submit-btn">确定</button>\
                                    <button type="button" class="btn btn-default j-cancel-btn">取消</button>\
                                </div>\
                            </section>\
                        </div></div></div></div>';
            break;
    }

    var index = layer.open({
        type: 1,
        area: ['60%', '60%'],
        fix: false, //不固定
        maxmin: true,
        skin:"layui-layer-me",
        title: 'aaaaa',
        content:changeTable
    });

    $('.j-submit-btn').on('click', function() {
        var radioVal = $('.j-checked-input').find('input:radio[name="fieldRadio"]:checked').val();
        if( radioVal == null) {
            layer.alert('您还没有选择！', {
                skin: 'layui-layer-me',
                closeBtn: 0,
                shift: 4 //动画类型
            });
        } else {
            $("#" + obj).val(radioVal);
            if( obj == "addObject" ){//对象选择添加
                i++;
                var str = '<div class="form-group j-object-item">'
                    + '<label for="listPageModel"  class="add-object-label">'+ radioVal +'</label>'
                    + '<div class="input-group my-form pull-left w60 j-select-object-layer"><input type="text" class="form-control j-select-btn" name="object_' + i + '" id="object_' + i + '">'
                    + '<div class="input-group-btn"><button  class="btn btn-my changeTemplate j-btn-select" type="button">选择</button></div></div><button class="btn btn-default j-btn-delete pull-left" type="button">删除</button>'
                    + '</div>';
                $(".j-content-object").append(str);
                $(document).delegate(".j-select-object-btn","click",function () {
                    var this_id = $(this).find("input").attr("id");
                    getSelectLayer(this_id);
                });
            }
            if( obj == 'maintainer'){//维护人员选择追加到table里
                var str = '<tr><td>123456</td><td>管理员1</td><td>admin</td><td>2016-05-02</td></tr>';
                $(".maintainerTable tbody").append(str);
            }
            if( obj == 'accessAuthority'){//访问权限选择追加到table里
                var str = '<tr><td>123456</td><td>一级</td></tr>';
                $(".accessAuthorityTable tbody").append(str);
            }
            layer.close(index);
        }
    });

    //取消
    $(".j-cancel-btn").click(function () {
        layer.close(index);
    });
}




