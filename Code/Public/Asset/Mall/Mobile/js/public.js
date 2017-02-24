var publicFunction = {
    send_code_obj:'',
    iTime: 59,
    Account: '',
    iSecond:'',
    sSecond : "",
    sTime : "",
    send_sms: function (phone_obj,flag_obj,sms_code_obj,send_code_obj) {
        var mobile = $(phone_obj).val();
        var flag = $(flag_obj).val();
        var code = $(sms_code_obj).val();
        var url = $(send_code_obj).attr('data-url');
        this.send_code_obj = send_code_obj;
        if (mobile.length == '') {
            layer.msg('请填写手机号码');
            return false;
        }

        var send_data = {'mobile':mobile,'sms_code':code};
        this.send_ajax_post(url+"&flag="+flag,send_data);
    },
    send_ajax_post: function (url,send_data) {
        var _self = this;
        $.ajax({
            type: "POST",
            url: url,
            data: send_data,
            dataType: "json",
            async: false,
            success: function (result) {
                if (result.code == 2) {
                    layer.msg(result.msg);
                    _self.load_time();
                } else {
                    if (result.msg) {
                        layer.msg(result.msg);
                    } else {
                        layer.msg('手机验证码发送失败');
                    }
                }
            }
        });
    },
    load_time: function () {
        var _self = this;
        $(_self.send_code_obj).attr('disabled',true);
        if (_self.iTime >= 0) {
            _self.iSecond = parseInt(_self.iTime % 60);
            if (_self.iSecond >= 0) {
                _self.sSecond = _self.iSecond + "秒";
            }
            _self.sTime = _self.sSecond;
            if (_self.iTime == 0) {
                clearTimeout(_self.Account);
                _self.sTime = '获取验证码';
                _self.iTime = 59;
                $(_self.send_code_obj).attr('disabled',false);
            } else {
                _self.Account = setTimeout(function(){
                    _self.iTime--;
                    _self.load_time();
                }, 1000);
            }
        } else {
            _self.sTime = '没有倒计时';
        }
        $(_self.send_code_obj).html(_self.sTime);
    }
}
/*
function sendSms(obj) {
    var mobile = $('#mobile_phone').val();
    var flag = $('#flag').val();
    var code = $("#sms_code").val();
    var url = $(obj).attr('data-url');
    if (mobile.length != '11') {
        alert('请填写手机号码');
        return false;
    }
//	RemainTime();

    $.ajax({
        type: "POST",
        url: url + "&flag=" + flag,
        data: {"mobile": mobile, "sms_code": code},
        dataType: "json",
        async: false,
        success: function (result) {
            if (result.code == 2) {
                alert(result.msg);
                RemainTime();
            } else {
                if (result.msg) {
                    alert(result.msg);
                } else {
                    alert('手机验证码发送失败');
                }
            }
        }
    });
}


function submitForget() {
    var status = true;
    var mobile = $('#mobile_phone').val();
    var mobile_code = $('#mobile_code').val();
    if (mobile.length == '') {
        alert('请填写手机号码');
        return false;
    }
    if (mobile_code.length == '') {
        alert('请填写手机验证码');
        return false;
    }
    $.ajax({
        type: "POST",
        url: "index.php?m=Mobile&c=Sms&a=check",
        data: "mobile=" + mobile + "&mobile_code=" + mobile_code,
        dataType: "json",
        async: false,
        success: function (result) {
            if (result.code != 2) {
                alert(result.msg);
                status = false;
            }
        }
    });
    return status;
}
var iTime = 59;
var Account;
function RemainTime() {
    document.getElementById('zphone').disabled = true;
    var iSecond, sSecond = "", sTime = "";
    if (iTime >= 0) {
        iSecond = parseInt(iTime % 60);
        if (iSecond >= 0) {
            sSecond = iSecond + "秒";
        }
        sTime = sSecond;
        if (iTime == 0) {
            clearTimeout(Account);
            sTime = '获取验证码';
            iTime = 59;
            document.getElementById('zphone').disabled = false;
        } else {
            Account = setTimeout("RemainTime()", 1000);
            iTime = iTime - 1;
        }
    } else {
        sTime = '没有倒计时';
    }
    document.getElementById('zphone').value = sTime;
}

/!**
 * 手机验证码登录
 * @author sunny5156
 * @returns {Boolean}
 *!/
function loginWithPhone() {
    var status = true;
    var mobile = $('#mobile_phone').val();
    var mobile_code = $('#mobile_code').val();
    if (mobile.length == '') {
        alert('请填写手机号码');
        return false;
    }
    if (mobile_code.length == '') {
        alert('请填写手机验证码');
        return false;
    }

    $.ajax({
        type: "POST",
        url: "index.php?m=Mobile&c=Sms&a=check",
        data: "mobile=" + mobile + "&mobile_code=" + mobile_code + "&flag=login_with_phone",
        dataType: "json",
        async: false,
        success: function (result) {
            if (result.code != 2) {
                alert(result.msg);
                status = false;
            }
        }
    });
    return status;
}
/!**
 * 登录验证
 * @author sunny5156
 * @returns {Boolean}
 *!/
function login() {
    var username = $('#usrename').val();
    var password = $('#password').val();
    if (username.length == '') {
        alert('请填写账号');
        return false;
    }
    if (password.length == '') {
        alert('请填写密码');
        return false;
    }
}*/
