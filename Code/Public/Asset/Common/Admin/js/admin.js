var  lock  = 0;
function loading(){
    var boxHtml = '<div class="simplemsgbox"></div>';

    $(".simplemsgbox").css('top','300px');
    if($(".simplemsgbox").length  ==  0){
        $("body").append(boxHtml);
    }
    $(".simplemsgbox").html('<img src="'+SimpleO2O_PUBLIC+'/images/loading.gif" /><span  style=" color: blue;">正在加载中132...</span>');
    $(".simplemsgbox").show();
    lock = 1;
}
    
    
    
function success(msg,timeout,callback){
    var boxHtml = '<div class="simplemsgbox"></div>';
    if($(".simplemsgbox").length  ==  0){
        $("body").append(boxHtml);
    }
    $(".simplemsgbox").html('<img src="'+SimpleO2O_PUBLIC+'/images/right.gif" /><span  style=" color: green;">'+msg+'</span>').show();
    setTimeout(function(){
        lock = 0;
        $(".simplemsgbox").hide();
        eval(callback);
    },timeout ? timeout : 3000);
}
function error(msg,timeout,callback){
    var boxHtml = '<div class="simplemsgbox"></div>';
    if($(".simplemsgbox").length  ==  0){
        $("body").append(boxHtml);
    }
    $(".simplemsgbox").html('<img src="'+SimpleO2O_PUBLIC+'/images/wrong.gif" /><span  style=" color: red;">'+msg+'</span>').show();
    setTimeout(function(){
        lock = 0;
        $(".simplemsgbox").hide();
        eval(callback);           
    },timeout ? timeout : 1000);
}

function hidde(){
    $(".simplemsgbox").hide();
    lock = 0;
}

function jumpUrl(url){
    if(url){
    	if(window.main_frm != undefined){
    		window.main_frm.location.href = url;
    	}else{
    		window.location.href = url;
    	}
    }else{
        history.back(-1);
    }
}
    
function yzmCode(){ //更换验证码
    $("#j-verify-img").click();
}  

function dialog(title,content,width,height){
    var dialogHtml = '<div class="simpledialog"><div class="simpledialog_bg"></div><div class="simpledialog_main"><h1>&nbsp;&nbsp;&nbsp;&nbsp;'+title+'<span></span></h1><div class="simpledialog_content"></div></div></div>';
    if($(".simpledialog").length  ==  0){
        $("body").append(dialogHtml);
    }
    width = width > 0 ? width:600;

    if(width){
        $(".simpledialog_main").css('width',width+'px');
    }
    $(".simpledialog_main").css('left',(document.body.clientWidth - width)/2 + 'px');
    if(height){
        $(".simpledialog_main").css('height',height+'px');
        $(".simpledialog_content").css('height',height-44 + 'px');
    }
    $(".simpledialog_main").css('border-radius','5px');
    $(".simpledialog_content").html(content);
}

function selectCallBack(id,name,v1,v2){
    $("#"+id).val(v1);
    $("#"+name).val(v2);
   $(".simpledialog").hide().remove();
}


$(document).ready(function(e){
    $(document).on('click', '.simpledialog_main h1 span',function(){
        $(".simpledialog").remove();
    });
    $(document ).on("click","input[type='submit']",function(e){
        e.preventDefault();
        if(!lock){
            // loading();
            $(this).parents('form').submit();
        }         
    }); 
    $("#j-verify-img").click(function(){
        $(this).attr('src',SimpleO2O_ROOT+'/index.php?m=manage&c=login&a=verify&mt='+Math.random());
    });
    
    $(document).on("click","a[mini='act']",function(e){
        e.preventDefault();
        if(!lock){
            if(confirm("您确定要"+$(this).html())){
                loading();
                $("#simpleO2O_frm").attr('src',$(this).attr('href'));   
            }
        }  
    });
    
    //全选
    $(document).on("click",".checkAll",function(e){
        var child = $(this).attr('rel');
        $(".child_"+child).prop('checked',$(this).prop("checked"));
    });
    
    
    $(document).on('click',"a[mini='list']",function(e){
        e.preventDefault();
        if(!lock){
            if(confirm("您确定要"+$(this).html())){
                loading();
                $(this).parents('form').attr('action',$(this).attr('href')).submit();
            }
        }  
    });
    

    $(document).on("click","a[mini='load']",function(e){
        e.preventDefault();
        if(!lock){
            loading();
            var obj =$(this);
            $.get(obj.attr('href'),function(data){
                if(data){
                    dialog( obj.text(), data,obj.attr('w'),obj.attr('h')); 
                
                }
                hidde();
            },'html');
            
        }
    });
    $(document).on("click","a[mini='select']",function(e){
        e.preventDefault();
        if(!lock){
            loading();
            var obj =$(this);
            dialog( obj.text(), '<iframe id="select_frm" name="select_frm" src="'+obj.attr('href')+'" style="border:0px;width:'+(obj.attr('w')-30)+'px;height:'+(obj.attr('h')-80)+'px;"></iframe>',obj.attr('w'),obj.attr('h')); 

            hidde();
        }
    });
    
    
    
    
    //table 隔行换色 
    $(".rembertable tr").mouseover(function(){
       if(!$(this).hasClass('no')){ $(this).addClass('on');}
    }).mouseout(function(){
         if(!$(this).hasClass('no')){ $(this).removeClass('on');}
    });
    //table 隔行换色 
    $(".menuManage tr").mouseover(function(){
        if(!$(this).hasClass('no')){  $(this).addClass('on');}
    }).mouseout(function(){
        if(!$(this).hasClass('no')){  $(this).removeClass('on');}
    }); 
   
   
   
});