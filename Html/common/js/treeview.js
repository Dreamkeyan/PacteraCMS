/**
 * Created by Chenyudan on 2016/7/25.
 */



$(function () {
    // 日志管理tree
    var logData = [{
        text: "平台日志",
        href: "#vipLog",
        icon: "none",
        tags: ["0"],
        nodes: [{
            text: "总日志",
            href: "#table1",
            icon: "none",
            tags: ["2"]
        }, {
            text: "登陆日志",
            href: "",
            icon: "none",
            tags: ["0"]
        }, {
            text: "操作日志",
            href: "",
            icon: "none",
            tags: ["0"]
        }, {
            text: "错误日志",
            href: "",
            icon: "none",
            tags: ["0"]
        }]
    }, {
        text: "插件日志",
        href: "#table1",
        icon: "none",
        tags: ["0"],
        nodes: [{
            text: "插件名称",
            href: "",
            icon: "none",
            tags: ["2"]
        }, {
            text: "会员系统",
            href: "#vipLog",
            icon: "none",
            tags: ["0"]
        }]
    }];
    //会员信息tree
    var vipAnalysisData = [{
        text: "属性分析",
        href: "#vipLog",
        icon: "none",
        tags: ["0"],
        nodes: [{
            text: "男女比例",
            href: "#tabContainer1",
            icon: "none",
            tags: ["2"]
        }]
    }, {
        text: "行为分析",
        href: "index.html",
        icon: "none",
        tags: ["0"],
        nodes: [{
            text: "浏览分析",
            href: "index.html",
            icon: "none",
            tags: ["2"]
        }, {
            text: "使用设备分析",
            href: "#tabContainer3",
            icon: "none",
            tags: ["0"]
        }, {
            text: "页面分析",
            href: "#tabContainer4",
            icon: "none",
            tags: ["0"]
        }]
    },{
        text: "交互分析",
        href: "#vipLog",
        icon: "none",
        tags: ["0"],
        nodes: [{
            text: "入口界面",
            href: "#tabContainer5",
            icon: "none",
            tags: ["2"]
        },{
            text: "离开界面",
            href: "#tabContainer6",
            icon: "none",
            tags: ["2"]
        },{
            text: "停留时间",
            href: "#tabContainer7",
            icon: "none",
            tags: ["2"]
        }]
    },{
        text: "模块分析",
        href: "#vipLog",
        icon: "none",
        tags: ["0"],
        nodes: [{
            text: "商城系统",
            href: "#tabContainer8",
            icon: "none",
            tags: ["2"]
        },{
            text: "会员中心",
            href: "#tabContainer9",
            icon: "none",
            tags: ["2"]
        }]
    }];
    // 字典项管理tree
    var dictTree = [{
        text: "基本数据管理",
        href: "#vipLog",
        icon: "none",
        tags: ["0"],
        nodes: [{
            text: "消息类型",
            href: "#table1",
            icon: "none",
            tags: ["2"]
        }]
    }, {
        text: "商城类数据标准",
        href: "#table2",
        icon: "none",
    }];

    $("#logTree").treeview({
        data: logData,
        levels: 2
    }),$("#vipAnalysisTree").treeview({
        data: vipAnalysisData
    }),$("#dictTree").treeview({
        data: dictTree
    })
});

$(function () {
   $(".treeview ul").find("li").each(function (i) {
       $(this).click(function () {
           change_tree(this);
       })
   });
});

/* 点击li，调用+或者-号的click事件 */
function change_tree(obj) {
    console.log(obj);
    if ($(obj).children(".glyphicon").hasClass("glyphicon-plus") || $(obj).children(".glyphicon").hasClass("glyphicon-minus")){
        $(obj).children(".glyphicon")[0].click();
    }
}
