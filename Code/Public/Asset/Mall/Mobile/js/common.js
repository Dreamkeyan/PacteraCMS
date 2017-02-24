/**
 * 公共函数
 * Created by 雨巷 on 2016/6/27.
 */

var common = {
    /*删除数组中某个值*/
    delArr: function (arr, val) {
        /*for (var i = 0; i < arr.length; i++ ) {
         if (arr[i] == val) {
         arr.splice(i, 1);
         }
         }*/
        var index = $.inArray(val, arr);
        arr.splice(index, 1);
    },

    r: function (min, max) {
        return Math.floor(min + Math.random() * (max - min));
    },

    /*输入框文本限制*/
    testTxtNum: function (LimitNum) {
        var this_val_len = $("textarea").val().length;
        $("textarea").val($("textarea").val().substring(0, LimitNum - 1));
        $("textarea").next().find("span").text(this_val_len);
    },

    /*文本溢出截取字符*/
    textNumSub: function (limitNum) {
        var textOverflow = $(".text-overflow").text().length;
        $(".text-overflow").text($(".text-overflow").text().substr(0, limitNum) + "...");
    },

    /*菜单切换*/
    menu_change: function (c) {
        $(c).on('click', function () {
            $(this).addClass('on').siblings().removeClass('on');
        });
    },

    /*tab按钮切换*/
    tab_change: function () {
        $('.j-tab').find('a').on('click', function () {
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

    /*加入购物车*/
    add_shopping_cart: function () {
        $('.product-list li .add-gwc').on('click', function () {
            var id = $(this).attr('data-id');
            var ll = $('.footer');
            var proImg = $(this).parent().parent().find('.product-img');
            var shopCar = $('.footer .sc-img');
            if (id == '0') {
                var newImg = proImg.clone();
                $('body').append(newImg);
                newImg.css({
                    position: 'absolute',
                    left: proImg.offset().left + 10,
                    top: proImg.offset().top,
                    opacity: 0.8,
                    width: 8 + 'em',
                    height: 4.5 + 'em',
                    'z-index': 99,
                    transition: "transform ease-in 1s",
                    transform: "rotate(720deg)"
                });
                newImg.stop().animate({
                    left: shopCar.offset().left,
                    top: shopCar.offset().top,
                    width: 10,
                    height: 10
                }, 1000, function () {
                    $(this).remove();
                });
                var num = ll.find('.num').text();
                num = parseInt(num);
                num++;
                ll.find('.num').html(num);
                ll.find('.num2').html(num);
                $(this).find('img').attr('src', 'images/productLibrary/icon_cancel.png');
                $(this).find('span').html('取消');
                $(this).attr('data-id', '1');
            } else {
                var num = ll.find('.num').text();
                num = parseInt(num);
                num--;
                ll.find('.num').html(num);
                ll.find('.num2').html(num);
                $(this).find('img').attr('src', 'images/productLibrary/icon_shopping.png');
                $(this).find('span').html('加购物车');
                $(this).attr('data-id', '0');
            }
        });
    },
    /*icheck组件*/
    icheck_func: function () {
        $("input[type='checkbox'], input[type='radio']").iCheck({
            checkboxClass: 'iradio_square-cyan',
            radioClass: 'iradio_square-cyan',
            hoverClass: 'hover'
        });
    },
    /*新建模板--保存模板*/
    save_template: function (msg) {
        $('.j-confirm-edit').on('click', function () {
            var template_name = $('#template_name').val();
            var bh = $(window).height();
            if (template_name == "") {
                $('.error-msg').find('span').html('模板名称不能为空').parent().show();
                window.scrollTo(0, bh);
                return false;
            }
            else {
                $('.error-msg').find('span').html('').parent().hide();
                layer.msg(msg, {
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function () {
                    window.location.href = 'oftenBuy.html';
                });
            }
        });
    },
    /*展开编辑信息*/
    show_edit_box: function () {
        $('.pc-subaccount li .rr').on('click', function () {
            /*if ($(this).parent().parent().hasClass('selected')) {
             $(this).parent().parent().find('.edit').removeClass('animated fadeInDown');
             } else {
             $(this).parent().parent().find('.edit').addClass('animated fadeInDown');
             }*/
            $(this).parent().parent().toggleClass('selected').siblings().removeClass('selected');
            $(this).parent().parent().siblings().find('.edit').removeClass('animated fadeInDown');
            $(this).parent().parent().find('.edit').toggleClass('animated fadeInDown');
        });
    },
    /*赠品展开信息*/
    show_gift_box: function () {
        $('.gift-btn').on('click', function () {
            $(this).parent().toggleClass('selected');
            $(this).parent().find('.product-list').toggleClass('animated fadeInDown');
        });
    },
    /*加减1数量操所*/
    less_func: function () {
        $('.less').on('click', function () {
            var num = Math.round($(this).parent().find('.form-num').val());
            if (num > 1) {
                num -= 1;
            }
            else if (num == 1) {
                num -= 1;
                $(this).css('color', '#d2d2d2');
            }
            else {
                $(this).css('color', '#d2d2d2');
                return;
            }
            num = parseFloat(num);
            $(this).parent().find('.form-num').val(num);
        });
    },
    add_func: function () {
        $('.add').on('click', function () {
            var num = Math.round($(this).parent().find('.form-num').val());
            $(this).parent().find('.less').css('color', '#2d2d2d');
            num += 1;
            num = parseFloat(num);
            $(this).parent().find('.form-num').val(num);
        });
    },
    //图片轮播
    img_play: function () {
        new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            paginationClickable: true,
            loop: true,
            autoplay: 3000
        });
    },
    // 首页顶部点击加载样式
    top_add: function () {
        $('.top-menu').find('dd').on('click', function () {
            $(this).addClass('top-add').siblings().removeClass('top-add');
            var i = $(this).index();
            $('.product-list').find('.product-list-show').eq(i).show().siblings().hide();
        })
    },
    // 星星评价
    star_grade: function () {
        // 商品详情评价
        $('.raty').raty({
            readOnly: true,
            score: function () {
                return $(this).attr('data-score');
            }
        });
        // 我的评价 总分
        $('.total-star').raty({
            readOnly: true,
            score: function () {
                return $(this).attr('data-score');
            }
        });
        // 我的评价 详情
        $('.person-star1').raty({
            readOnly: true,
            score: function () {
                return $(this).attr('data-score');
            }
        });
    },
    // 数量加减
    quantity_computation: function () {
        var _self = this;
        $(".less").click(function () {
            var t = $(this).parent().find('input[class*=form-num]');
            var numVal = $(this).parents('.show-goods-num').siblings('.show-goods').find('.num');
            t.val(parseInt(t.val()) - 1);
            numVal.text(t.val());
            if (parseInt(t.val()) < 1) {
                t.val(1);
                numVal.text(1);
                $(this).css('color', '#d6d6d6');
            }
            _self.price_total();
            return false;
        });
        $(".add").click(function () {
            var t = $(this).parent().find('input[class*=form-num]');
            var numVal = $(this).parents('.show-goods-num').siblings('.show-goods').find('.num');
            t.val(parseInt(t.val()) + 1);
            numVal.text(t.val());
            $(this).parent().find('.less').css('color', '#8c8c8c');
            _self.price_total();
            return false;
        });

    },
    // 数量总价计算
    price_total: function () {
        var s = 0;
        $(".num-index").each(function () {
            s += parseInt($(this).find('input[class*=form-num]').val()) * parseFloat($('.goods-price').text());
        });
        $(".j-total-price").html(s.toFixed(2));
    },
    // 线下查看更多展开收缩动画
    more_details: function () {
        var full_more = true;
        $('.j-more-inf').on('click', function () {
            if (full_more == true) {
                full_more = false;
                $('.j-hide-details').show();
                $('.j-more-inf').find('img').addClass('add-right-run');
                $('.delivery-time').hide();
            } else {
                full_more = true;
                $('.j-hide-details').hide();
                $('.j-more-inf').find('img').removeClass('add-right-run');
                $('.delivery-time').show();
            }

        });
    },
    //  分类列表切换样式
    classify_list_change: function () {
        $('.classify-menu').find('dd').on('click', function () {
            $(this).addClass('add-classify-style').siblings().removeClass('add-classify-style');
            var i = $(this).index();
            $('.classify-list').find('dl').eq(i).show().siblings().hide();
        })
    },
    //  菜单切换样式
    classify_menu_change: function () {
        $('.classify-list-left').find('dd').on('click', function () {
            $(this).addClass('classify-list-click').siblings().removeClass('classify-list-click');
            var i = $(this).index();
            $('.classify-list-right').find('.right-list').eq(i).show().siblings().hide();
        });
    },
    // 首页跳转到搜索页面
    run_seek: function (url) {
        $('.j-seek-run').click('on', function () {
            window.location.href = url;
        });
    },
    //  加入购物车规格选择动画样式//立即购买收藏跳转
    add_cart_animation: function (cart_url,goods_price, spec_goods_price) {
        var _self=this;
        $('.j-open-popup').click(function () {
            var popupVal = $(this).attr('date-change');
            $("#j-add-cart").popup();
            
            // 数量计算
            $(".less").unbind('click');
            $(".add").unbind('click');
            _self.quantity_computation();
            // 规格选择
            $('.cart-size').find('span').unbind('click');
            _self.cart_size_func(goods_price, spec_goods_price);
            
            if (popupVal == 0) {
                
                // 加入购物车动画
                $('.j-cart-animation').unbind('click');
                _self.cart_animation_func(cart_url);

            } else if (popupVal == 1) {
                $('.j-cart-animation').click(function () {
                    $('#j-goods-buy').submit();
                });
            }
            return false;
        });

    },
    //  加入购物车选择规格样式
    cart_size_func: function(goods_price, spec_goods_price) {
        var _self = this;
        $('.cart-size').find('span').on('click', function () {
            $(this).addClass('cart-add-change').siblings().removeClass('cart-add-change');
            $(this).siblings().find('input').removeProp('checked',false);
            $(this).find('input').prop('checked',true);
            _self.cart_goods_price(goods_price, spec_goods_price);
        });
    },
    //  选择规格价格修改
    cart_goods_price: function(goods_price, spec_goods_price) {
//        console.log(spec_goods_price);
        var _self = this;
        var goods_spec_name = '';
        // 如果有属性选择项
        if(spec_goods_price != null)
        {
                var goods_spec_arr = new Array();
                $("input[name^='goods_spec']:checked").each(function(){
                         goods_spec_arr.push($(this).val());
                });    
                var spec_key = goods_spec_arr.sort(_self.cart_sort_number).join(',');  //排序后组合成 key
                goods_price = spec_goods_price[spec_key]['price']; // 找到对应规格的价格	
                goods_spec_name = spec_goods_price[spec_key]['key_name']; // 找到对应规格的价格
        }
//        console.log(goods_spec_name);
        $("input[name=specname]").val(goods_spec_name);
//        console.log($("input[name=specname]").val());
        $("#goods_price").html(goods_price); // 变动价格显示
        $("input[name^='goodsprice']").val(goods_price);
        
    },
    cart_sort_number: function(a,b) { 
            return a - b; 
    },
    // 加入购物车飞入动画
    cart_animation_func: function (cart_url) {
        var _self = this;
        // 加入购物车动画
        // $('.j-cart-animation').unbind('click');
        $('.j-cart-animation').on('click', function () {
            var data = $('#j-goods-buy').serialize() ;
            var res = ajaxPost(cart_url, data);
            var proImg = $('.goods-img-none');
            var shopCar = $('.shopping-cart-number');
            var num = $(this).parent().siblings().find('.form-num').val();
            shopCar.text(num);
            var newImg = proImg.clone();
            $('body').append(newImg);
            newImg.css({
                position: 'absolute',
                left: proImg.offset().left + 10,
                top: proImg.offset().top,
                opacity: 0.8,
                width: 50 + 'px',
                height: 50 + 'px',
                borderRadius: 50 + 'px',
                zIndex: 99,
                transition: "transform ease-in 1s",
                transform: "rotate(720deg)"
            });
            newImg.stop().animate({
                left: shopCar.offset().left,
                top: shopCar.offset().top,
                width: 10,
                height: 10
            }, 1000, function () {
                $(this).remove();
            });

        });
    },
    // 配送方式选择
    delivery_method: function (url) {
        $('.show-goods-num').find('.j-delivery-show').on('click', function () {
            window._now_this = $(this);
            var type = _now_this.attr('data-val');
//            console.log(type);
            //快递费写入弹框
            $("#j-delivery-method").find('.j-express').html($(this).attr('data-express'));
            $("#j-delivery-method").find('.j-ture-delivery').attr('data-sid',$(this).attr('data-sid'));
            //弹框调用
            $("#j-delivery-method").popup();
            if(type == '1'){
                $('.delivery-change1').find('.j-check-delivery').eq(0).children('label').addClass('icon-iconcheckon').removeClass('icon-checkoff').addClass('add-label-style');
                $('.delivery-change1').find('.j-check-delivery').eq(0).find('input[name="delivery"]').prop('checked',true);
                $('.delivery-change1').find('.j-check-delivery').eq(1).find('label').removeClass('icon-iconcheckon').removeClass('add-label-style').addClass('icon-checkoff');
            }else{
                $('.delivery-change1').find('.j-check-delivery').eq(1).children('label').addClass('icon-iconcheckon').removeClass('icon-checkoff').addClass('add-label-style');
                $('.delivery-change1').find('.j-check-delivery').eq(1).find('input[name="delivery"]').prop('checked',true);
                $('.delivery-change1').find('.j-check-delivery').eq(0).find('label').removeClass('icon-iconcheckon').removeClass('add-label-style').addClass('icon-checkoff');
            }
            
        });
        // 弹框值选择
        $('.delivery-change1').find('.j-check-delivery').on('click', function () {
            $(this).find('label').addClass('icon-iconcheckon').removeClass('icon-checkoff').addClass('add-label-style');
            $(this).parent().siblings().find('label').removeClass('icon-iconcheckon').removeClass('add-label-style').addClass('icon-checkoff');
            var deliveryStyle = $(this).parent().find('input[name="delivery"]:checked').val();
            if (deliveryStyle == 0) {
                $('.j-new-show').text('现场配货');
            } else if (deliveryStyle == 1) {
            }
        });
        //  弹框选择值页面展示
        $('.j-ture-delivery').on('click', function () {
            var styleShow = $('.delivery-change1').find('input[name="delivery"]:checked').val();
            var  express_price= parseFloat($('.delivery-change1').find('.j-express').html());
            var time_out = $('.delivery-change1').find('.j-self-out').html();
            var price = parseFloat(_now_this.parents('.j-shop-order').find('.j-shop-total').attr('data-total'));
            if (styleShow == 1) {
                _now_this.html(' <span>自提</span><span>'+time_out+'</span><span>12:00以后</span>');
                _now_this.attr('data-val', 1);
                _now_this.parents('.j-shop-order').find('.j-shop-total').html(price);
            } else if (styleShow == 2) {
                _now_this.html(' <span>快递</span><span>¥</span><span>'+express_price+'</span>');
                _now_this.attr('data-val', 2);
                _now_this.parents('.j-shop-order').find('.j-shop-total').html(price+express_price);
            }
            
            var total = 0;
            
            $('.j-shop-total').each(function(i, n){
                total += parseFloat( $(this).html());
            })
            $('.j-total-price').html(total);
            var shop_id = $(this).attr('data-sid');
            var val = styleShow;
            var data = {'type':'shops', 'key':'deliver_type', 'sid':shop_id, 'value':val, 'express':express_price};
            ajaxPost(url, data);
            
        })

    },
    //  收藏、取消收藏
    succeed_add_cart: function (url) {
        $('.j-add-succeed').on('click', function () {
            var collectColor=$(this).attr('date-collect');
            var gid = $(this).attr('data-id');
            var param = {};
            if(collectColor){
                $(this).removeClass('icon-iconshoucang02').addClass('icon-iconshoucang');
                $(this).removeAttr('date-collect');
                param = {'gid':gid, 't':'1', 's':0};
                var res = ajaxPost(url, param);
                $.toast("已取消收藏", "cancel");
                return false;
            }else{
                $(this).removeClass('icon-iconshoucang').addClass('icon-iconshoucang02');
                $(this).attr('date-collect',false);
                var param = {'gid':gid, 't':'1', 's':1};
                ajaxPost(url, param);
                $.toast("已收藏");
                return false;
            }
            return false;
        })

    },
    //  地址选择
    change_ads: function () {
        $("#city-picker").cityPicker({
            title: "请选择所在地址"
        });
    },
    //  收藏顶部菜单切换
    collect: function () {
        $('.collect-menu').find('dd').on('click', function () {
            var indexI = $(this).index();
            $(this).addClass('collect-menu-check').siblings().removeClass('collect-menu-check');
            $('.collect-list').find('.collect-inf').eq(indexI).show().siblings().hide();
        })
    },
    //  我的订单顶部菜单切换
    my_order: function () {
        $('.order-specific').find('.order-specific-menu').find('dd').on('click', function () {
            var orderOne = $(this).index();
            $(this).addClass('order-specific-click').siblings().removeClass('order-specific-click');
            $('.order-details').find('.order-details-list').find('.order-details-list-inf').eq(orderOne).show().siblings().hide();
        });
        $('.order-menu').find('dd').on('click', function () {
            var orderI = $(this).index();
            $(this).addClass('order-menu-click').siblings().removeClass('order-menu-click');
            $('.order-specific').find('.order-specific-menu').eq(orderI).show().siblings().hide();
            $('.order-details').find('.order-details-list').eq(orderI).show().siblings().hide();

            $('.order-specific').find('.order-specific-menu').eq(orderI).find('dd').on('click', function () {
                var orderTwo = $(this).index();
                $(this).addClass('order-specific-click').siblings().removeClass('order-specific-click');
                $('.order-details').find('.order-details-list').eq(orderI).find('.order-details-list-inf').eq(orderTwo).show().siblings().hide();
                return false;
            });
        });

    },
    // 购物车菜单选择
    cart_menu: function () {
        var _self = this;
        $('.cart-menu').find('dd').on('click', function () {
            var cartI = $(this).index();
            $(this).addClass('cart-menu-click').siblings().removeClass('cart-menu-click');
            $('.cart-details ').find('.cart-details-list').eq(cartI).show().siblings().hide();
            $('.cart-details ').find('.cart-details-list').eq(cartI).addClass('j-change-cartList').siblings().removeClass('j-change-cartList');
            $(".j-all-check").find('input').prop('checked', false);//全选按钮也不被选中
            $(".j-all-check").find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
            $(".j-all-check").removeAttr('date-color');
            $(".j-goods-select").removeAttr('date-goods-color');
            $('.all-price').text('0.00');
            _self.cart_price_total();
        })
    },

    // 选择默认地址
    default_address:function (url) {

        $('.j-default-address').on('click',function(){
            var _handel = $(this);
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:{'id':_handel.attr('data-id')},
                success:function(res){
                    if (res.status == 1) {
                        _handel.parent().addClass('add-label-style');
                        _handel.find('label').addClass('icon-iconcheckon').removeClass('icon-checkoff');
                        _handel.parents('.address').siblings().find('.j-default').removeClass('add-label-style');
                        _handel.parents('.address').siblings().find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon');
                    }else{
                        alert('设置失败');
                    }
                }
        });
       });
    },
    // 删除默认地址
    detele_address:function (url, jump_url) {

        $('.js_delete').on('click',function(){
            var _handel = $(this);
            $.ajax({
                url:url,
                type:"post",
                dataType:"json",
                data:{'id':_handel.attr('data-id')},
                success:function(res){
                    if (res.status == 1) {
                         location.href = jump_url;
                    }else{
                        alert('操作失败');
                    }
                }
            });
       });
    },
    
    // 个人资料选择性别
    change_sex: function () {
        $('.check-sex').on('click', function () {
            $(this).find('.j-img-check').attr('src', '/Asset/Mall/Mobile/images/img_check_on.png');
            $(this).parent().siblings().find('.j-img-check').attr('src', '/Asset/Mall/Mobile/images/img_check_off.png');
        });
        // var selected = false;
        // $('.check-secrecy').on('click', function () {
        //     if (selected == false) {
        //         $(this).find('.j-img-secrecy').attr('src', '../images/img_check_on.png');
        //         selected = true;
        //     } else {
        //         $(this).find('.j-img-secrecy').attr('src', '../images/img_check_off.png');
        //         selected = false;
        //     }
        //
        // });

    },
    // 删除银行卡
    dels_bank: function (url) {
        var dels_show = false;
        $('.card-more').on('click', function () {
            var _this_change = $(this);
            if (dels_show == false) {
                $(this).next('.delete-card').show();
                $('.delete-card').click(function () {
                    var _handle = $(this);
                    $.confirm("您确定要删除吗？", function () {
                        
                        var id = _handle.attr('data-id');
                        var res = ajaxPost(url, {'id':id});
                        if(res == 1){
                            //点击确认后的回调函数
                            $.toast("删除成功");
                            $.closeModal();
                            _this_change.parents('dd').remove();
                        }else {
                            $.toast("删除失败");
                            $.closeModal();
                        }
                        
                    }, function () {
                        //点击取消后的回调函数
                        $.closeModal();
                    });
                });
                dels_show = true;
            } else {
                $(this).next('.delete-card').hide();
                dels_show = false;
            }
        });
    },
    goods_spec:function(url){
        $('.j-cart').click(function(){
            var gid = $(this).attr('data-id');

            var res = ajaxPostHtml(url, {'goods_id':gid});
            $('#j-add-cart').html(res.responseText);
            $("input[name=gid]").val(gid);
            $("#j-add-cart").popup();
            
        });
    },
    collect_add_cart:function(url){
        $('.j-cart-animation').click(function(){
            var res = ajaxPost(url, $('#j-goods-buy').serialize());
            if(res == 1){
                window.location.reload();
//                layer.msg('加入购物车操作成功');
                
            }else{
                layer.msg('加入购物车操作失败');
            }
            
        });
    },
    // 收藏页面省略号
    click_collect_more: function () {
        $('.j-open-more').on('click', function () {
            var id=$(this).attr('data-id');
            $("#j-collect-more").find('.j-add-succeed').attr('data-id', id);
            $("#j-collect-more").find('.j-cart').attr('data-id', id);
            $("#j-collect-more").popup();
            return false;
        });
    },
    //  收藏页面收藏
    collect_succeed_add_cart: function (url) {
        $('.j-add-succeed').on('click', function () {
            var collectColor = $(this).attr('date-collect');
            var gid = $(this).attr('data-id');
            
            if (collectColor) {
                var param = {'gid':gid, 't':'1', 's':1};
                var res = ajaxPost(url, param);
                $(this).find('i').removeClass('icon-iconshoucang').addClass('icon-iconshoucang02 add-i-orange');
                $.toast("已收藏");
                $(this).removeAttr('date-collect');
            } else {
                var param = {'gid':gid, 't':'1', 's':0};
                var res = ajaxPost(url, param);
                $(this).find('i').removeClass('icon-iconshoucang02 add-i-orange').addClass('icon-iconshoucang');
                $.toast("已取消收藏", "cancel");
                $(this).attr('date-collect', false);
            }
            return false;
        });
    },
    // 失效的时候取消收藏
    failure_abolish: function (url) {
        $('.j-failure').on('click', function () {
            var _self_now = $(this);
            var gid = _self_now.attr('data-id');
 
            $.confirm("确认取消收藏？", function () {
                
                var param = {'gid':gid, 't':'1', 's':0};
                var res = ajaxPost(url, param);
                //点击确认后的回调函数
                _self_now.parents('dd').remove();
                $.toast("取消成功");
            }, function () {
                //点击取消后的回调函数
                $.closePopup();
            });
            return false;
        });
    },
    //  购物车清除失效商品
    del_failure_goods: function (url) {
        $('.j-change-cartList').find('.j-del-failure').on('click', function () {
            var _self_now = $(this);
            var cart_invalid = {};
            $.confirm("确认清空失效宝贝吗？", function () {
                
                _self_now.parents('.lose-goods').find('.j-goods').each(function(i, n){
                    var id = $(this).attr('data-id');
                    cart_invalid[id] = 0;
                });
                
                var param = {'del':cart_invalid};
//                console.log(param);
                var operate = ajaxPost(url, param);
                console.log(operate);
                if(operate == 1){
    //                //点击确认后的回调函数
                _self_now.parents('.lose-goods').remove();
                $.toast("清空成功");
                }else{
                    $.closePopup();
                }
            }, function () {
                //点击取消后的回调函数
                $.closePopup();
            });
        });
    },
    compile_cart: function (url) {
        //  整体编辑
        $('.j-all-compile').on('click', function () {
            var compileAll = $(this).attr('date-compile');
            if (compileAll) {
                $(this).text('编辑');
                $('.j-compile-inf,.j-bottom-count').show();
                $('.j-compile-num,.j-bottom-change').hide();
                $(this).removeAttr('date-compile');
                $('.j-change-cartList').find('.j-now-compile').show();
            } else {
                $(this).text('完成');
                $('.j-compile-inf,.j-bottom-count').hide();
                $('.j-compile-num,.j-bottom-change').show();
                $(this).attr('date-compile', false);
                $('.j-change-cartList').find('.j-now-compile').hide();
            }
        });
        //  店铺编辑
        $('.j-now-compile').on('click', function () {
            var compileNow = $(this).attr('date-compiles');
            if (compileNow) {
                $(this).text('编辑');
                $(this).parents('.weui_cells_access').find('.j-compile-inf').show();
                $(this).parents('.weui_cells_access').find('.j-compile-num').hide();
                $('.j-bottom-change').hide();
                $('.j-bottom-count').show();
                $(this).removeAttr('date-compiles');
            } else {
                $(this).text('完成');
                $(this).parents('.weui_cells_access').find('.j-compile-inf').hide();
                $(this).parents('.weui_cells_access').find('.j-compile-num').show();
                $('.j-bottom-change').show();
                $('.j-bottom-count').hide();
                $(this).attr('date-compiles', false);
            }
        })
    },
    //  移到收藏夹
    cart_move: function (url) {
        $('.j-all-move').on('click',function () {

            var cart_goods = {};

            $('.j-goods-change:checked').parents('a').each(function(i, n){;
                var id = $(this).attr('data-id');
                var gid = $(this).attr('data-gid');
                cart_goods[i] = {};
                cart_goods[i]['id'] = id;
                cart_goods[i]['gid'] = gid;
            });

            var param = cart_goods;
            var operate = ajaxPost(url, param);

            if(operate == 0 && !$.isArray(operate)){
                layer.msg('收藏失败');
            }else{

                if(operate.length > 0){
                    //点击确认后的回调函数
                    $('.j-goods-change:checked').parents('a').each(function(i, n){

                        var id = parseInt($(this).attr('data-id'));

                        if($.inArray(id, operate) != -1){
                            $(this).remove();
                        }
                    });
                }
            }
        })
    },
    //  删除购物车商品
    cart_del: function (url) {
        // 单个编辑
        $('.j-cart-del').on('click', function () {
            var _self_now_dels = $(this);
            var id = _self_now_dels.attr('data-id');
            $.confirm("确认删除该宝贝吗？", function () {
                var param = {};
                param[0] = id;
                var operate = ajaxPost(url, {'del':param});

                if(operate == 1){
                    //点击确认后的回调函数
                    var i = 0;
                    _self_now_dels.parents('a').remove();
                    $.toast("已删除");
                }else{
                    $.closePopup();
                }
            }, function () {
                //点击取消后的回调函数
                $.closePopup();
            });
            return false;
        })
        //  整体编辑
        $('.j-all-del').on('click',function () {

            $.confirm("确认删除该宝贝吗？", function () {
                
                var cart_goods = {};
                $('.j-goods-change:checked').parents('a').each(function(i, n){
                    var id = $(this).attr('data-id');
                    cart_goods[i] = id;
                });

                var param = {'del':cart_goods};
                var operate = ajaxPost(url, param);
                if(operate == 1){
                    
                    //点击确认后的回调函数
                    $('.j-goods-change:checked').parents('a').remove();
                    $('.j-shop-check').find('input:checked').parents('.j-allow-buy').remove();
                    $.toast("已删除");
                }else{
                    $.closePopup();
                }
            }, function () {
                //点击取消后的回调函数
                $.closePopup();
            });
        })
    },
    //  购物车全部选择
    cart_all_check: function () {
        var _self = this;
        $('.j-all-check').on('click', function () {
            var laberColor = $(this).attr('date-color');
            if (laberColor) {
                $(this).find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                $(this).find('input').prop('checked', false);
                $('.j-change-cartList').find(".j-goods-check").prop('checked', false);
                $('.j-change-cartList').find(".j-goods-check").prev('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                $(this).removeAttr('date-color');
                $('.j-change-cartList').find('.j-goods-select').removeAttr('date-goods-color');
                $('.j-change-cartList').find('.j-shop-check').removeAttr('date-shop-color');
                _self.cart_price_total();
            } else {
                $(this).find('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                $(this).find('input').prop('checked', true);
                $('.j-change-cartList').find(".j-goods-check").prop('checked', true);
                $('.j-change-cartList').find(".j-goods-check").prev('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                $(this).attr('date-color', false);
                $('.j-change-cartList').find('.j-goods-select').attr('date-goods-color', false);
                $('.j-change-cartList').find('.j-shop-check').attr('date-shop-color', false);
                _self.cart_price_total();
            }

        })
    },
    // 点击店铺按钮全选
    cart_shop_check: function () {
        var _self = this;
        $('.j-shop-check').on('click', function () {
            var shopColor = $(this).attr('date-shop-color');
            if (shopColor) {
                $(this).find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                $(this).find('input').prop('checked', false);
                //如果店铺按钮不被选中
                $(this).parents(".weui_cells_access").find(".j-goods-change").prop('checked', false); //店铺内的所有商品也不被全选
                $(this).parents(".weui_cells_access").find(".j-goods-change").prev('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                $(".j-all-check").find('input').prop('checked', false);//全选按钮也不被选中
                $(".j-all-check").find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                _self.cart_price_total();
                $(this).removeAttr('date-shop-color');
                $('.j-all-check').removeAttr('date-color');
                $(this).parents('.j-allow-buy').find('.j-goods-select').removeAttr('date-goods-color');
            } else {
                $(this).find('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                $(this).find('input').prop('checked', true);
                $(this).parents(".weui_cells_access").find(".j-goods-change").prop('checked', true); //店铺内的所有商品按钮也被选中
                $(this).parents(".weui_cells_access").find(".j-goods-change").prev('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                if ($('.j-change-cartList').find(".j-goods-change").length == $('.j-change-cartList').find(".j-goods-change:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
                    $(".j-all-check").find('input').prop('checked', true); //全选按钮被选中
                    $(".j-all-check").find('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                    $('.j-all-check').attr('date-color', false);
                }
                _self.cart_price_total();
                $(this).attr('date-shop-color', false);
                $(this).parents('.j-allow-buy').find('.j-goods-select').attr('date-goods-color', false);
            }

        });
    },
    // 点击商品按钮
    cart_goods_check: function () {
        var _self = this;
        $('.j-change-cartList').find('.j-goods-select').on('click', function () {
            var goodsColor = $(this).attr('date-goods-color');
            var goods = $(this).parents(".weui_cells_access").find(".j-goods-change"); //获取本店铺的所有商品
            var goodsC = $(this).parents(".weui_cells_access").find(".j-goods-change:checked"); //获取本店铺所有被选中的商品
            var Shops = $(this).parents(".weui_cells_access").find(".j-shop-check"); //获取本店铺的全选按钮
            if (goodsColor) {
                $(this).find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                $(this).find('input').prop('checked', false);
                //如果选中的商品不等于所有商品
                Shops.find('input').prop('checked', false); //店铺全选按钮不被选中
                Shops.find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                $(".j-all-check").find('input').prop('checked', false);  //else全选按钮不被选中
                $(".j-all-check").find('label').addClass('icon-checkoff').removeClass('icon-iconcheckon add-label-style');
                // 计算
                _self.cart_price_total();
                $(this).removeAttr('date-goods-color');
                $('.j-all-check').removeAttr('date-color');
            } else {
                $(this).find('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                $(this).find('input').prop('checked', true);
                _self.cart_price_total();
                if (goods.length == goodsC.length) { //如果选中的商品等于所有商品
                    Shops.find('input').prop('checked', true); //店铺全选按钮被选中
                    Shops.find('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                    if ($('.j-change-cartList').find(".j-shop-check").length == $('.j-change-cartList').find(".j-shop-check input:checked").length) { //如果店铺被选中的数量等于所有店铺的数量
                        $(".j-all-check").find('input').prop('checked', true); //全选按钮被选中
                        $(".j-all-check").find('label').addClass('icon-iconcheckon add-label-style').removeClass('icon-checkoff');
                        $('.j-all-check').attr('date-color', false);
                    }
                }
                $(this).attr('date-goods-color', false);
            }
        });
    },
    // 购物车加减
    cart_computation: function (url) {
        var _self = this;
        var num = 1;
        window.urlInf=url;
        // 减
        $(".less").click(function (url) {
            
            var t = $(this).parent().find('.form-num');
            var showVal = $(this).parents('a').find('.num');
            t.val(parseInt(t.val()) - 1);
            showVal.text(t.val());
            
            if(t.val() >= 1){
                //调用ajax修改数据库
                var id = $(this).parents('.j-cart-num').attr('data-id');
                var param = {};
                param[id] =t.val() 
                var operation  = ajaxPost(urlInf, {'num':param});
            }
            
            if (t.val() <= 1) {
                t.val(1);
                showVal.text(1);
                $(this).css('color', '#d6d6d6');
            }
            
            //计算总价
            _self.cart_price_total();
            return false;
        });
        // 加
        $(".add").click(function () {
            
            var t = $(this).parent().find('.form-num');
            var showVal = $(this).parents('a').find('.num');
            t.val(parseInt(t.val()) + 1);
            showVal.text(t.val());
            $(this).parent().find('.less').css('color', '#8c8c8c');
            if (t.val() <= 1) {
                t.val(1);
            }else{
                //调用ajax修改数据库
                var id = $(this).parents('.j-cart-num').attr('data-id');
                var param = {};
                param[id] =t.val() 
                var operation  = ajaxPost(urlInf, {'num':param});
            }
            
            //计算总价
            _self.cart_price_total();
            return false;
        });
    },
    // 购物车总金额
    cart_price_total: function () {
        var allprice = 0; //总价
        var goodsNum = 0;// 总数量
        $('.j-change-cartList').find(".j-allow-buy").each(function () { //循环每个店铺
            var oprice = 0; //店铺总价
            $(this).find(".j-goods-change").each(function () { //循环店铺里面的商品
                if ($(this).is(":checked")) { //如果该商品被选中
                    var num = parseInt($(this).parents(".show-goods").find(".form-num").val()); //得到商品的数量
                    var price = parseFloat($(this).parents(".show-goods").find(".goods-price").text()); //得到商品的单价
                    var total = price * num; //计算单个商品的总价
                    oprice += total; //计算该店铺的总价
                }
            });
            var oneprice = parseFloat(oprice); //得到每个店铺的总价
            allprice += oneprice; //计算所有店铺的总价
        });

        $('.j-change-cartList').find(".j-goods-change").each(function () { //循环每个店铺
            if ($(this).is(":checked")) { //如果该商品被选中
                goodsNum++;
            }
            $('.j-settlement-amount').text(goodsNum); //输出结算总数
        });

        $(".all-price").text(allprice.toFixed(2)); //输出全部总价
    },
    // 规格重新选择弹框
    feature_selection: function (url) {
        var _self = this;
        $('.j-feature-selection').on('click', function () {
            window._now_standards = $(this);
            //本页面数据获取
            var gid = $(this).attr('data-id');
            var default_key = $(this).attr('data-key');
            var cid = $(this).attr('data-cid');
            var num = $(this).parents('.j-compile-num').find('.j-edit-num').val();
//            console.log(num);
            //弹框的页面的生成
            var res = ajaxPostHtml(url, {'goods_id':gid,'default_key':default_key, 'type':1});
            
            //弹框数据处理
            $('#j-add-cart').html(res.responseText);
            $("input[name=gid]").val(gid);
            $("input[name=cid]").val(cid);
            $("input[name=num]").val(num);
            $("#j-add-cart").popup();
            return false;
        })
    },
    // 商品规格弹框从新选择规格
    spec_click: function (spec_goods_price) {
        var _self = this;
        $('.cart-size').find('span').on('click', function () {
            $(this).addClass('cart-add-change').siblings().removeClass('cart-add-change');
            $(this).siblings().find('input').removeProp('checked',false);
            $(this).find('input').prop('checked',true);
            //  遍历取属性值
            _self.each_standrad();
            _self.cart_goods_price(0, spec_goods_price)
        })
    },
    //  遍历取属性值
    each_standrad: function () {
        var standardHtml = '';
        $(".cart-standard1").each(function () {
            var standards = $(this).find("span[class='cart-add-change']").text();
            var totalTitle = $(this).find('.cart-style').text();
            standardHtml += '<span>' + totalTitle + standards + '</span>';
        });
        _now_standards.parents('.goods-del').find('.j-standard-loop').html(standardHtml);
    },
    
    save_order:function(url, jump_url){
        $('.j_save_order').click(function () {

            var user_info = $(".shipping-address").find("span").text();

            if(user_info == "收货人：收货地址："){
                layer.msg('请填写收货信息');
                return false;
            }
            var data={'data': 'save'};
            var res = ajaxPost(url, data);
            if(res == 0){
                layer.msg('下单失败');
            }else{
                window.location.href = jump_url;
            }

        });
    },
    save_order_change_address:function(url){
        $('.js-change-address').click(function(){
            window.location.href = url;
        });
    },
    delete_order:function(url){
        $(".j-delete").click(function(){
            var data = {};
            var oid = $(this).parent().attr('data-id');
            data = {'id':oid, 'type':'del'}
            var res = ajaxPost(url, data);
            if(res == 1){
                window.location.reload();
            }else{
                layer.msg('删除失败');
            }
        });
    },
    operate_order:function(){
        $('.j-operate').click(function(){
            var data = {};
            var oid = $(this).parent().attr('data-id');
            var url = $(this).attr('data-url');
            var type = $(this).attr('data-type');
            if(type != "view" && type != 'appraise' && type != 'pay'){
                data = {'id':oid, 'type':type}
                var res = ajaxPost(url, data);
                if(res == 1){
                    window.location.reload();
                }else{
                    layer.msg('操作失败');
                }
            }else{
                window.location.href = url+'&id='+oid;
            }
            
        });
    },
    save_order_remark:function(url){
        //添加备注
        $('input[name="remark"]').on('blur', function () {

            var shop_id = $(this).parent().attr('data-sid');
            var val = $(this).val();
            var data = {'type':'shops', 'key':'remark', 'sid':shop_id, 'value':val};
            ajaxPost(url, data);
        });
    }

};

function ajaxPost(url, data){
    layer.load(2, {  shade: [0.3,'#999999'] });
    var result ;
    $.ajax({
    //图文消息
        url:url,
        type:"post",
        dataType:"json",
        data:data,
        async:false,
        success:function(res){
            layer.closeAll('loading');

            if (res.status == 1) {
                if(res.data){
                    result = res.data;
                }else{
                    result = 1;
                }
            }else{
                result = 0;
            }
        }
    });
    return result;
}

function ajaxPostHtml(url, data){
    layer.load(2, {  shade: [0.3,'#999999'] });
    var result ;
    result = $.ajax({
    //图文消息
        url:url,
        type:"post",
        dataType:"html",
        data:data,
        async:false,
        success:function(res){
            layer.closeAll('loading');
            result = res;
        }
    });
    return result;
}

/*iOS 系统下默认的 click 事件会有300毫秒的延迟，这个延迟是iOS系统的特性而不是jQuery WeUI设定的，可以使用 fastclick 来消除这个延迟*/
$(function () {
    FastClick.attach(document.body);
});