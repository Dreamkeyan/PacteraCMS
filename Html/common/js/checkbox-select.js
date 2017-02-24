/**
 * Created by Chenyudan on 2016/7/26.
 */

/**
 * Bootstrap之表格checkbox复选框全选
 */

$(".j-checkAll").click(function() {
    $("input[name='sub']").prop("checked", this.checked);
});

$("input[name='sub']").click(function() {
    var $subs = $("input[name='sub']");
    $(".j-checkAll").prop("checked" , $subs.length == $subs.filter(":checked").length ? true :false);
});