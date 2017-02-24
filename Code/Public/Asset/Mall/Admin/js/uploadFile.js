/**
 * 上传图片
 * @param picker  上传文件 标签id
 * @param imgObj  图片预览 id
 * @param hiddenObj  表单传值路径 id
 * @param width  缩略图 宽
 * @param height 缩略图 高
 * @param isRemote 是否远程上传 false=>否 true=>是
 */
function uploaderImg(picker, imgObj, hiddenObj, width, height, isRemote){
    var isRemote = isRemote;
    var ratio = window.devicePixelRatio || 1;
    if (width) {
        thumbnailWidth = width * ratio;
    } else {
        thumbnailWidth = 300 * ratio;
    }
    if (height) {
        thumbnailHeight = height * ratio;
    } else {
        thumbnailHeight = 200 * ratio;
    }
    var url = $(imgObj).attr('url');
    var uploader = WebUploader.create({
        swf : Think.ASSET+"/Manage/plugins/webuploader-0.1.5/Uploader.swf",
        server : url,
        pick: {
            id: picker,
            multiple : false
        },
        auto : true,
        formData : {'file_type' : 'img', 'saveDir' : 'Images', 'is_remote' : isRemote},
        accept : {
            title : 'Images',
            extensions : 'gif,jpg,jpeg,bmp,png',
            mimeTypes : 'image/!*'
        }
    });
    uploader.on( 'fileQueued', function( file ) {
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                alert('暂时不能预览！');
                return;
            }
            $(imgObj).attr('width','300px');
            $(imgObj).attr( 'src', src).show();
        }, thumbnailWidth, thumbnailHeight);
    });
    uploader.on('uploadError', function( file ) {
        layer.msg('上传出错了，请稍后再试！', {time: 3000, icon:2});
    });
    uploader.on('uploadSuccess', function( file,response) {
        if(response.errCode == 1){
            var path = response.path;
            $(hiddenObj).val(path);
            layer.msg(response.errMsg, {time: 2000, icon:6});
        }else{
            layer.msg(response.errMsg, {time: 3000, icon:2});
        }
    });
}
/**
 * 上传Excel
 *  @param picker  上传文件 标签id
 *  @param fileObj  文件预览 id
 *  @param list 上传列表
 *  @param isRemote 是否远程上传 false=>否 true=>是
 */
function uploaderExcel(picker, fileObj, list, isRemote) {
    var isRemote = isRemote;
    var url = $(fileObj).attr('url');
    var uploader = WebUploader.create({
        //自动上传
        auto : true,

        multiple : false,

        swf : Think.ASSET+"/Manage/plugins/webuploader-0.1.5/Uploader.swf",

        // 文件接收服务端。
        server : url,

        // 选择文件的按钮。可选。
        pick : picker,

        // 存储文件夹
        formData : {'file_type' : 'import', 'saveDir': 'Excel', 'is_remote' : isRemote},

        // 只允许选择excel表格文件。
        accept : {
            title : 'Excel',
            extensions : 'xls,xlsx',
            mimeTypes : 'Excel/xls,Excel/xlsx'
        }
    });
    uploader.on('fileQueued', function(file) {
        $(list).append(file.name);
    });
    uploader.on('uploadError', function(file) {
        layer.msg('上传出错了，请稍后再试！', {time: 3000, icon:2});
    });
    uploader.on('uploadSuccess', function(file, response) {
        if(response.errCode == 1){
            layer.msg(response.errMsg, {time: 2000, icon:6});
            $(fileObj).val(response.path);
        }else{
            layer.msg(response.errMsg, {time: 3000, icon:2});
        }
    });
}

/**
 * 截取字符串 包含中文处理
 * @str 字符串
 * @len 长度
 * @hasDot 增加字符串
 */
function subString(str, len, hasDot) {
    var newLength = 0;
    var newStr = "";
    var chineseRegex = /[^\x00-\xff]/g;
    var singleChar = "";
    var strLength = str.replace(chineseRegex,"**").length;
    for(var i = 0; i < strLength; i++) {
        singleChar = str.charAt(i).toString();
        if(singleChar.match(chineseRegex) != null) {
            newLength += 2;
        } else {
            newLength++;
        }
        if(newLength > len) {
            break;
        }
        newStr += singleChar;
    }

    if(hasDot && strLength > len) {
        newStr += "...";
    }
    return newStr;
}

/**
 * 将字符转换为HTML实体
 */
function htmlspecialchars_decode(str){
    str = str.replace(/&amp;/g, '&');
    str = str.replace(/&lt;/g, '<');
    str = str.replace(/&gt;/g, '>');
    str = str.replace(/&quot;/g, "''");
    str = str.replace(/&#039;/g, "'");
    return str;
}

/**
 *过滤字符串中所有html标签
 */
function delHtmlTag(str) {
    return str.replace(/<[^>]+>/g, "");
}

//判断对象是否为空
function isNullObj(obj){
    for(var i in obj){
        if(obj.hasOwnProperty(i)){
            return false;
        }
    }
    return true;
}
