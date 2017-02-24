/**
 * 封装公共ajax 
 * @author 王荣
 * @version 2016.10.19
 */

var ajax = {

    init: function(){
        this.ajax_get();
        this.ajax_post();
    },

    /**
     * ajax-get请求
     * @author 清启
     * @version 2016.7.31
     */
    ajax_get: function(){
        var _self = this;

        $('.ajax-get').unbind();

        $('.ajax-get').click(function(){
            var target,
                that = this,
                ids,
                data,
                callback;

             //自定义回调
             try{
                 callback = $(this).attr('callback') ? eval($(this).attr('callback')) : ajax_callback;
             }catch(e){
             }

             //获取多选
             ids = $(this).attr('ids');

             if(ids){
                 var obj = $('input:checkbox[class*=' + ids + ']:checked');
                 data = obj.serialize(); 
             }

              if($(this).hasClass('confirm')){
                  layer.confirm('确认要执行该操作吗?', function(){
                      submit(that);
                  });
              }else{
                  submit(that);
              }

             function submit(obj){    
                  if( (target = $(obj).attr('href')) || (target = $(obj).attr('url')) ){
                      data && (target = target + '?' + data);
                      var index = layer.load();
                      $.get(target).success(function(data){
                          layer.close(index);
                          callback ? callback(data) : _self.ajax_callback(data);
                      });
                  };
              }

              return false;

        });

    },
    /**
     * ajax-post请求
     * @author 清启
     * @version 2016.7.31
     */
    ajax_post: function(){
      var _self = this;

      $('.ajax-post').unbind();

      $('.ajax-post').click(function(){
          var form = $(this).attr('form') ? eval($(this).attr('form')) : $(this).closest('form'),
              callback;

          //自定义回调
          try{
              callback = $(this).attr('callback') ? eval($(this).attr('callback')) : ajax_callback;
          }catch(e){
          }

          if($(this).hasClass('confirm')){
              layer.confirm('确定要执行该操作吗?', function(){
                  submit();
              });
          }else{
              submit();
          }

          function submit(){
//                var index = layer.load();
              $.post(form.attr('action'), form.serialize(), function(data){
//                    layer.close(index);
                  callback ? callback(data) : _self.ajax_callback(data);
              });
          }

          return false;
      });
    },
    ajax_callback: function(data){
        var _self = this;
          if(1 == data.status){
              layer.msg(data.info, {icon: 6});
              setTimeout(function (){
                  if(data.url){
                      location.href = data.url;
                  }else{
                      location.reload();
                  }
              }, 1500);
          }else{
              layer.msg(data.info, {icon: 5});
              setTimeout(function (){
                  if(data.url){
                      location.href = data.url;
                  }else{
                      $('.bui-ext-close').click();
                  }
              }, 1500);
          }
    },
    check_all: function(check_all_callback, ids_callback){
        //全选的实现
          $(".check-all").click(function(){
              $(".ids").prop("checked", this.checked);

              if('function' == typeof check_all_callback){
                  check_all_callback();
              }

          });
          $(".ids").click(function(){
              var option = $(".ids");
              option.each(function(i){
                  if(!this.checked){
                      $(".check-all").prop("checked", false);
                      return false;
                  }else{
                      $(".check-all").prop("checked", true);
                  }
              });

              if('function' == typeof ids_callback){
                  ids_callback(this);
              }

          });
    }

};
  
ajax.init();



