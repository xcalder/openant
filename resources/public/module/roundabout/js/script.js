$(document).ready(function(){

    $('#img-slider li').bind({
        reposition: function() {
            var degrees = $(this).data('roundabout').degrees,
                roundaboutBearing = $(this).parent().data('roundabout').bearing,
                rotateY = Math.sin((roundaboutBearing - degrees) * (Math.PI/180)) * 9;

            $(this).css({
                "-webkit-transform": 'rotate(' + rotateY + 'deg)',
                "-moz-transform": 'rotate(' + rotateY + 'deg)',
                "-ms-transform": 'rotate(' + rotateY + 'deg)',
                "-o-transform": 'rotate(' + rotateY + 'deg)',
                "transform": 'rotate(' + rotateY + 'deg)'
            });
        }
    });

    $('.jQ_sliderPrev').on('click', function(){
        $('#img-slider').roundabout('animateToNextChild');

        return false;
    });

    $('.jQ_sliderNext').on('click', function(){
        $('#img-slider').roundabout('animateToPreviousChild');

        return false;
    });

    $('body').on('keyup', function(e) {
        var keyCode = e.which || e.keyCode;

        if(keyCode == 37) {
            $('#img-slider').roundabout('animateToPreviousChild');
            e.preventDefault();
            return false;
        } else if(keyCode == 39) {
            $('#img-slider').roundabout('animateToNextChild');
            e.preventDefault();
            return false;
        }
    });

    $('.jQ_sliderSwitch li').on('click', function() {
        var $elem = $(this);
        var index = $elem.index();

        $('#img-slider').roundabout('animateToChild', index);

        return false;
    });

    $('#img-slider').roundabout({
        minScale: 0.4,
        maxScale: 0.9,
        duration: 750
    }).bind({
        animationEnd: function(e) {
            var index = $('#img-slider').roundabout('getChildInFocus');
            $('.jQ_sliderSwitch li').removeClass('active');
            $('.jQ_sliderSwitch li').eq(index).addClass('active');
        }
    });

});