    (function($) {
        //        'use strict';
        var button = $('.more_toggle');
        // console.log(button);
        button.bind('click', function(el) {
            el.preventDefault();
            $this = $(this);
            $this.toggleClass('change');
            var parent = $this.parentsUntil('element');
            var item = parent.children('.element_details');
            item.toggleClass('closed');
            // console.log(item);
        });
        $('.periodicTable').each(function() {
            var $periodicTable = $(this);
            var infiniteLoop = parseInt($periodicTable.attr("data-infiniteLoop"));
            var mode = $periodicTable.attr("data-mode");
            var controls = parseInt($periodicTable.attr("data-controls"));
            var speed = parseInt($periodicTable.attr("data-speed"));
            var auto = parseInt($periodicTable.attr("data-auto"));
            var autoHover = parseInt($periodicTable.attr("data-autoHover"));
            var randomStart = parseInt($periodicTable.attr("data-randomStart"));
            var pager = parseInt($periodicTable.attr("data-pager"));
            var pause = parseInt($periodicTable.attr("data-pause"));
            // console.log(infiniteLoop);
            $periodicTable.bxSlider({
                mode: mode,
                speed: speed,
                infiniteLoop: infiniteLoop,
                controls: controls,
                auto: auto,
                autoHover: autoHover,
                randomStart: randomStart,
                pager: pager,
                pause: pause,
                hideControlOnEnd: true,
                slideMargin: 1,
                slideSelector: '.element',
                nextText: '<span class="ptw-icon ptw-right-arrow"></span>',
                prevText: '<span class="ptw-icon ptw-left-arrow"></span>',
                pagerType: 'short',
                onSliderLoad: function() {
                    $(".periodicTable").css("visibility", "visible");
                }
            });
        });

        // $('.element_container').hover(function() {
        //     var wdParent = $(this).parents('.widget-periodic-table');
        //     var wdPid = wdParent.attr('id');
        //     var box = $('#' + wdPid).find('.box');
        //     var summary = $(this).find('.element_summary').html();
        //     box.html(summary);
        //     box.find('p').fadeIn('slow');
        //     console.log(summary);
        // }, function() {
        //     var wdParent = $(this).parents('.widget-periodic-table');
        //     var wdPid = wdParent.attr('id');
        //     var box = $('#' + wdPid).find('.box');
        //     box.find('p').fadeOut('slow', function() {
        //         $(this).remove();
        //     });
        // });


        $('.element_container').hover(function() {
            var positionLeft = $(this).offset().left;

            var wdParent = $(this).parents('.widget-periodic-table');
            var wdPid = wdParent.attr('id');
            var box = $('#' + wdPid).find('.box');
            // var boxP = box.find('p');

            var summary = $(this).find('.element_summary').html();
            box.html(summary);
            if(positionLeft < 200){
                box.find('p').fadeIn('slow').css('left','101%');
            }else{
               box.find('p').fadeIn('slow').css('right','101%');
            }

            // console.log(summary);
        }, function() {
            var wdParent = $(this).parents('.widget-periodic-table');
            var wdPid = wdParent.attr('id');
            var box = $('#' + wdPid).find('.box');
            box.find('p').fadeOut('slow', function() {
                $(this).remove();
            });
        });




    })(jQuery);