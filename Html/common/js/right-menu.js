/**
 * Created by Chenyudan on 2016/7/28.
 */
$(function(){
    $('.menubtn').on('click',function(e){
        if( $('body').hasClass('openMenu')) {
            doMenuAnimate('close');
        } else {
            doMenuAnimate('open');
        }
    });
    function doMenuAnimate(tog) {
        if(tog == 'open') {
            $('body').addClass('openMenu');
            $('#j-rightPanel').css("display", "block");
        }
        if(tog == 'close') {
            $('body').removeClass('openMenu');
            $('#j-rightPanel').css("display", "none");
        }
    }
});
