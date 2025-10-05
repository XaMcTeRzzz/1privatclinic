//"use strict";

document.addEventListener("DOMContentLoaded", function (event) {

    //    $('a').click(function (e) {
    //        if ($(this).attr('href') == 'https://medzdrav.com.ua/schedule/') {
    //            e.preventDefault();
    //        }
    //    })

    $('.trigger_tel_sections').click(function () {
        $('.overlay_new_sc').fadeIn(100, function () {
            $('.show_mobiles_modal_tel').fadeIn(100);
        })
    });
    $('.closed_modals_telephones, .overlay_new_sc').click(function () {
        $('.show_mobiles_modal_tel').fadeOut(100, function () {
            $('.overlay_new_sc').fadeOut(100);
        })
    });

    const cloneClock = $('.js__appendToJs__cloneClock'),
        cloneClockWrap = $('.js__cloneClock'),
        popMed = $('.js__medPop'),
        popMedTrigger = $('.js__medPop-trigger'),
        medChangeCityByIpTrigger = $('.js__medChangeCityByIp-trigger'),
        popRegion = $('.js__popRegion'),
        popRegionDesc = $('.js__popRegionDesc'),
        popCity = $('.js__popCity'),
        popCityMenu = $('.js__popCity_menu');

    // cloneClock.clone().appendTo(cloneClockWrap);

    function fadeThisDel(el) {
        el.fadeOut('normal', function () {
            $(this).removeAttr('style');
            $(this).removeClass('open');
        });
    }

    function fadeThisOpen(el) {
        el.fadeToggle('normal', function () {
            $(this).removeAttr('style');
            $(this).toggleClass('open');
        });
    }

    $('.wrapper').click(function (e) {
        let target = $(e.target);

        if (!target.is('.header *, .js__trigger-medPop')) {
            fadeThisDel(cloneClockWrap);
            fadeThisDel(popRegion);
            fadeThisDel(popRegionDesc);
            fadeThisDel(popMed);
            fadeThisDel(popCity);
            fadeThisDel(popCityMenu);
        }

        if (target.is('.header *') && !target.closest('.js__reg-city-desc').length) {
            fadeThisDel(popRegionDesc);
        }

        if (!target.is('.nav-title *')) {
            $('.list-doctor-mob').fadeOut('fast', function () {
                $(this).removeAttr('style');
                $(this).removeClass('open');
            });
        }
    });
    $('.js__cont-trigger').click(function () {
        fadeThisDel(popMed);
        fadeThisDel(popRegion);
        fadeThisDel(popCity);
        fadeThisOpen(cloneClockWrap);
    });
    $('.js__cont-trigger-region').click(function () {
        fadeThisDel(popRegion);
        fadeThisDel(popCity);
        $('.js__popRegion').removeClass('active');
    });
    $('.js__cont-trigger-city').click(function () {
        fadeThisDel(popCity);
        fadeThisDel(popCityMenu);
        $('.js__popRegion').removeClass('active');
        $('.js__popCity_menu').removeClass('open');
    });
    $('.js__reg-trigger').click(function () {
        fadeThisDel(popMed);
        fadeThisDel(cloneClockWrap);
        fadeThisOpen(popRegion);
    });
    $('.js__reg-city').click(function () {
        fadeThisOpen(popCity);
        $('.js__popRegion').toggleClass('active');
    });
    $('.js__reg-city-desc').click(function () {
        fadeThisOpen(popRegionDesc);
        console.log('xxx2');
    });
    $('.js__reg-city_menu').click(function () {
        fadeThisOpen(popCityMenu);
        $('.js__popCity_menu').toggleClass('open');
    });
    $(document).find('.js__trigger-medPop').click(function (e) {
        e.preventDefault();
        fadeThisOpen(popMed);
        $('.med-call-pop').find('input[type="text"]').focus();
    });
    popMedTrigger.click(function (e) {
        fadeThisDel(popMed);
    });

    medChangeCityByIpTrigger.click(function (e) {
        $.fancybox.close({
            src: '#check-city-modal',
            type: 'inline'
        });
    });

    $.fn.inline = function () {
        this.css({
            'display': 'flex'
        });
    };

    $(".nav-bottom__nav > ul > li").mouseenter(function (e) {
        if ($(window).width() > 992) {
            $(this).children("ul").stop(true, false).fadeIn(150, function () {
                $(this).addClass('open');
            }).inline();
            e.preventDefault();
        }

        $('#ajaxsearchlite1 .orig').focus(function () {
            $('#ajaxsearchlite1').addClass('active');
        });
        $('#ajaxsearchlite1 .orig').blur(function () {
            if ($(this).val().length === 0) {
                $('#ajaxsearchlite1').removeClass('active');
            }
        });
        $(".proclose").click(function () {
            $('#ajaxsearchlite1 .orig').val();
        });
    });
    $(".nav-bottom__nav > ul > li").mouseleave(function (e) {
        if ($(window).width() > 992) {
            $(this).children("ul").stop(true, false).fadeOut(150, function () {
                $(this).removeClass('open');
            }).inline();
            e.preventDefault();
        }
    });
    let mainElement = $('.content'),
        headerElement = $('.header'),
        stickyOffset = mainElement.position().top,
        heightHeader = headerElement.innerHeight();
    $(window).scroll(function () {
        if ($(window).width() > 992) {
            let scroll = $(window).scrollTop();

            if (scroll >= stickyOffset) {
                headerElement.addClass('sticky');
                $('.proclose').trigger('click');
                $('#ajaxsearchlite1').removeClass('active');
                mainElement.css('margin-top', heightHeader + 'px');
            } else {
                headerElement.removeClass('sticky');
                mainElement.removeAttr('style');
            }
        }
    }); //  resizeAddCard


    let certificateSettings = {
        slidesPerView: 'auto',
        watchOverflow: true,
        spaceBetween: 5,
        pagination: {
            el: '.swiper-pagination'
        },
        navigation: {
            nextEl: '.swiper-button-prev',
            prevEl: '.swiper-button-next '
        },
        breakpoints: {
            0: {
                pagination: {
                    type: 'bullets'
                }
            },
            768: {
                pagination: {
                    type: 'fraction'
                }
            },
            992: {
                pagination: {
                    type: 'fraction'
                }
            }
        }
    }


    let certificateSlider = undefined;
    const appendTable = document.querySelector('.js__lg-append-table'),
        getTabs = document.querySelector('.js__get-tabs-container'),
        appendCalendar = document.querySelector('.js__lg-append-calendar'),
        motTabContent = document.querySelector('.mob-tab-content'),
        lgGetCalendar = document.querySelector('.js__lg-get-calendar'),
        lgAppendTableBay = document.querySelector('.js__lg-append-table-bay'),
        getTabsContainerCalendar = document.querySelector('.js__get-tabs-containerCalendar');

    if (appendTable) {
        function resizeAddCard() {
            if (window.innerWidth > 1124) {
                getTabs.append(appendTable);
                getTabsContainerCalendar.append(appendCalendar, lgAppendTableBay);
            }

            if (window.innerWidth < 1124) {
                motTabContent.append(lgAppendTableBay, appendTable);
                lgGetCalendar.append(appendCalendar);
            }
            // certificateSlider = new Swiper('.js__certificate-slider', certificateSettings);
        }

        resizeAddCard();
        window.addEventListener("resize", function (event) {
            resizeAddCard();
        });
    } // end resizeAddCard

    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 300)


    let loopOrNot = false;
    if ($('.js__certificate-slider .certificate-slider-item').length > 5) {
        let loopOrNot = true;
    }

    let certificateSliderNew = new Swiper('.js__certificate-slider', {
        slidesPerView: 'auto',
        watchOverflow: true,
        loop: loopOrNot,
        spaceBetween: 5,
        pagination: {
            el: '.swiper-pagination'
        },
        navigation: {
            nextEl: '.swiper-button-prev',
            prevEl: '.swiper-button-next '
        },
        breakpoints: {
            0: {
                pagination: {
                    type: 'bullets'
                }
            },
            768: {
                pagination: {
                    type: 'fraction'
                }
            },
            992: {
                pagination: {
                    type: 'fraction'
                }
            }
        }
    });


    //dot nav home page


    const sectionPosition = [],
        headerHeight = $('.nav-bottom-row').innerHeight();
    $('.js__section-scroll').each(function () {
        sectionPosition.push($(this).offset().top);
    });
    $(document).scroll(function () {
        var position = $(document).scrollTop(),
            index;

        for (var i = 0; i < sectionPosition.length; i++) {
            if (position <= sectionPosition[i]) {
                index = i;
                break;
            }
        }

        $('#nav  a').removeClass('active');
        $('#nav a:eq(' + index + ')').addClass('active');
    });
    $('#nav  a').click(function () {
        $('#nav a').removeClass('active');
        $(this).addClass('active');
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - headerHeight - 10
        }, 500);
    });
    $('ul.tabs li').click(function () {
        let tabId = $(this).attr('data-tab');
        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#" + tabId).addClass('current');
    });
    $('ul.mob-tabs li').click(function () {
        let tabIdMob = $(this).attr('data-mob-tab');
        $('ul.mob-tabs li').removeClass('open');
        $('.mob-tab-content').removeClass('open');
        $(this).addClass('open');
        $("#" + tabIdMob).addClass('open');
    });
    const scheduleTable = $('.schedule-table-nav-wrap');
    // scheduleTable.mouseleave(function () {
    //   fadeThisDel(scheduleTable);
    // });

    $(document).on('mouseleave', '.schedule-table-nav-wrap', function () {
        fadeThisDel($('.schedule-table-nav-wrap'));
    });

    $(document).on('click', '.js__schedule', function () {
        $('.js__schedule').not(this).next().fadeOut('fast');
        $(this).next().fadeToggle('fast');
    });
    $(document).on('click', '.schedule-calendar-title', function () {
        if (window.innerWidth < 992) {
            $(this).toggleClass('open');
            $(this).next().slideToggle('fast', function () {
                $(this).removeAttr('style');
                $(this).toggleClass('open');
            });
        }
    });
    $(".js__list-doctor-mob-trigger, .list-doctor-mob__cross").click(function (e) {
        $('.list-doctor-mob').fadeToggle('fast', function () {
            $(this).removeAttr('style');
            $(this).toggleClass('open');
        });
    }); // Accordion ///

    const titAccordion = $(".product-accordion-title"),
        decrAccordion = $(".product-accordion-decr"),
        accordionClassActive = "active";
    titAccordion.on("click", function () {
        $(this).toggleClass(accordionClassActive);
        $(this).next(decrAccordion).slideToggle("normal", function () {
            $(this).toggleClass(accordionClassActive);
            $(this).removeAttr("style");
        }); /// up slider other

        if (!$(this).hasClass('js__not-next-ub')) {
            titAccordion.not(this).removeClass(accordionClassActive).next(decrAccordion).slideUp("normal", function () {
                $(this).removeClass(accordionClassActive);
                $(this).removeAttr("style");
            });
        }
    });
    $('.accordion-har-title').click(function () {
        $(this).toggleClass('active');
        $(this).next().slideToggle('normal', function () {
            $(this).removeAttr('style');
            $(this).toggleClass('open');
        });
    });
    $('.accordion-schedule-title').click(function () {
        $(this).parent().toggleClass('active');
        $(this).next().slideToggle('normal', function () {
            $(this).toggleClass('open');
        });
    });
    var number = 0;

    if ($('.counter-value').length) {
        $(window).scroll(function () {
            var oTop = $('#counter').offset().top - window.innerHeight;

            if (number == 0 && $(window).scrollTop() > oTop) {
                $('.counter-value').each(function () {
                    var $this = $(this),
                        countTo = $this.attr('data-count');
                    $({
                        countNum: $this.text()
                    }).animate({
                        countNum: countTo
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $this.text(this.countNum);
                            $this.addClass('plus');
                        }
                    });
                });
                number = 1;
            }
        });
    } // form-comment ajax


    //Click event to scroll to top

    $(".btn-ul").click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    function parallaxIt() {
        // create variables
        var $fwindow = $(window);
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        var $contents = [];
        var $backgrounds = []; // for each of content parallax element

        $('[data-type="content"]').each(function (index, e) {
            var $contentObj = $(this);
            $contentObj.__speed = $contentObj.data('speed') || 1;
            $contentObj.__fgOffset = $contentObj.offset().top;
            $contents.push($contentObj);
        }); // for each of background parallax element

        $('[data-type="background"]').each(function () {
            var $backgroundObj = $(this);
            $backgroundObj.__speed = $backgroundObj.data('speed') || 1;
            $backgroundObj.__fgOffset = $backgroundObj.offset().top;
            $backgrounds.push($backgroundObj);
        }); // update positions

        $fwindow.on('scroll resize', function () {
            scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            $contents.forEach(function ($contentObj) {
                var yPos = $contentObj.__fgOffset - scrollTop / $contentObj.__speed;
                $contentObj.css('top', yPos);
            });
            $backgrounds.forEach(function ($backgroundObj) {
                var yPos = -((scrollTop - $backgroundObj.__fgOffset) / $backgroundObj.__speed);
                $backgroundObj.css({
                    backgroundPosition: '50% ' + yPos + 'px'
                });
            });
        }); // triggers winodw scroll for refresh

        $fwindow.trigger('scroll');
    }



    if (window.innerWidth > 768) {
        parallaxIt();
    }



    $('.parent-accordion-arrow').click(function () {
        $(this).toggleClass('active')
        $(this).prev('span').toggleClass('open')
        $(this).next('ul').slideToggle();
    });



});
