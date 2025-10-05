"use strict";

$(function () {
  let wow = new WOW({
    mobile: false // trigger animations on mobile devices (default is true)

  });
  wow.init();

  const inputTels = document.querySelectorAll('input[type="tel"]');

  if (inputTels != null) {
    inputTels.forEach(inputTel => {
      Inputmask({
        "mask": "+38 (999) 99 99 999"
      }).mask(inputTel);
    });
  }

  const inputDate = document.getElementById('cabinet-login-date');

  if (inputDate != null) {
    Inputmask({
      "mask": "99.99.9999",
      "placeholder": "дд.мм.рррр",
      "clearIncomplete": true
    }).mask(inputDate);
  }

  var sequenceInterval = 100;
  window.sr = ScrollReveal({
    reset: true
  }); // Custom reveal sequencing by container

  $('.js__grid').each(function () {
    let sequenceDelay = 0;
    $(this).find('.js__grid-item').each(function () {
      sr.reveal(this, {
        delay: sequenceDelay,
        distance: '10px',
        easing: 'ease-out',
        origin: 'top',
        reset: false,
        scale: 1,
        viewFactor: 0
      });
      sequenceDelay += sequenceInterval;
    });
  });
  const Nav = $('#main-nav').hcOffcanvasNav({
    maxWidth: 992,
    position: "right",
    levelTitles: true,
    customToggle: '.js__burger',
    levelTitlesAsBack: true,
    levelSpacing: 0,
  });

  $(".nav-wrapper-1").each(function() {
    $(this).find("h2").replaceWith("<p style='display: none;'>" + $(this).find("h2").html() + "</p>");
  });

  Nav.on('close', function() {
    $('.js__popCity_menu').fadeOut('normal', function () {
      $(this).removeAttr('style');
      $(this).removeClass('open');
    });
  });

  let hcOffcanvasNavLangItem = $(document).find('.hc-offcanvas-nav .list-lang__item-link'),
      hcOffcanvasNavSharedItem = $(document).find('.hc-offcanvas-nav .list-shared__item__link'),
      hcOffcanvasNavSharedItemTitle = $(document).find('.hc-offcanvas-nav .nav-content'),
      textTitleArow = `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 12L5 12" stroke="#707E98" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11 18L5 12L11 6" stroke="#707E98" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                         </svg>`;
  hcOffcanvasNavSharedItemTitle.each(function () {
    let textTitle = $(this).find('h2').text();
    $(this).find('.nav-back > a').html(`${textTitleArow} ${textTitle}`);
  });
  hcOffcanvasNavSharedItemTitle.click(function (e) {
    $('.js__popCity_menu').fadeOut('normal', function () {
      $(this).removeAttr('style');
      $(this).removeClass('open');
    });
  });
  hcOffcanvasNavLangItem.wrapAll("<div class='list-lang'/>");
  var swiperComment = new Swiper('.comment-slider', {
    autoHeight: true,
    watchOverflow: true,
    pagination: {
      el: '.swiper-pagination',
      type: 'fraction'
    },
    navigation: {
      nextEl: '.swiper-button-prev',
      prevEl: '.swiper-button-next'
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 20
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 40
      },
      992: {
        slidesPerView: 2,
        spaceBetween: 140
      }
    }
  });
  var swiperVideo = new Swiper('.video__slider', {
    loop: true,
    slidersPerView: 1,
    watchOverflow: true,
    pagination: {
      el: '.swiper-pagination',
      type: 'fraction'
    },
    navigation: {
      nextEl: '.swiper-button-prev',
      prevEl: '.swiper-button-next'
    }
  });
  var bannerVideo = new Swiper('.banner__slider', {
    loop: false, // ОТКЛЮЧАЕМ бесконечный цикл - показываем фото в порядке загрузки с границами
    autoplay: false, // ОТКЛЮЧАЕМ автопрокрутку - только ручное управление стрелочками
    speed: 600, // плавная анимация
    slidesPerView: 3, // показываем 3 фото одновременно на десктопе
    slidesPerGroup: 1, // прокручивать по одному слайду
    spaceBetween: 20, // отступы между слайдами
    centeredSlides: false,
    direction: 'horizontal',
    effect: 'slide',
    // ВКЛЮЧАЕМ перетаскивание мышкой для карусельного эффекта
    allowTouchMove: true, // ВКЛЮЧАЕМ перетаскивание мышкой
    simulateTouch: true, // симулируем касания мышью
    grabCursor: false, // ОТКЛЮЧАЕМ встроенный курсор Swiper (используем свой CSS)
    watchOverflow: true, // автоматически отключить если слайдов недостаточно
    rewind: true, // в конце - возврат к началу по кнопке
    keyboard: false, // ОТКЛЮЧАЕМ управление клавиатурой
    mousewheel: false, // ОТКЛЮЧАЕМ прокрутку колесиком мыши
    touchRatio: 1, // нормальная чувствительность к касаниям
    touchAngle: 45, // разрешаем касания под углом до 45 градусов
    preventInteractionOnTransition: false, // разрешаем взаимодействие во время анимации
    touchMoveStopPropagation: false, // не останавливаем события касаний
    followFinger: true, // следовать за пальцем/мышкой
    // Дополнительные настройки для карусельного перетаскивания мышью
    threshold: 5, // минимальное расстояние для начала перетаскивания
    resistanceRatio: 0.85, // сопротивление при достижении края
    longSwipesRatio: 0.3, // минимальное отношение для длинного свайпа
    longSwipesMs: 300, // максимальное время для длинного свайпа (мс)
    // ОТКЛЮЧАЕМ клики по ссылкам во время перетаскивания
    preventClicks: true, // Предотвращаем клики при перетаскивании
    preventClicksPropagation: true, // Останавливаем распространение кликов при перетаскивании
    slideToClickedSlide: false, // НЕ переходить к слайду при клике
    // Кнопки навигации
    navigation: {
      nextEl: '.banner-slider-next',
      prevEl: '.banner-slider-prev',
    },
    breakpoints: {
      0: {
        slidesPerView: 1, // 1 фото на мобильном
        spaceBetween: 10,
        allowTouchMove: true, // ВКЛЮЧАЕМ перетаскивание на мобильных
      },
      768: {
        slidesPerView: 2, // 2 фото на планшете
        spaceBetween: 15,
        allowTouchMove: true, // ВКЛЮЧАЕМ перетаскивание на планшетах
      },
      1024: {
        slidesPerView: 3, // 3 фото на десктопе
        spaceBetween: 20,
        allowTouchMove: true, // ВКЛЮЧАЕМ перетаскивание на десктопе
      }
    },
    // События для управления кликами и перетаскиванием
    on: {
      touchStart: function() {
        this.$el.addClass('swiper-container-dragging');
      },
      touchEnd: function() {
        var self = this;
        setTimeout(function() {
          self.$el.removeClass('swiper-container-dragging');
        }, 50);
      },
      click: function(swiper, event) {
        // Предотвращаем клики по ссылкам после перетаскивания
        if ($(event.target).closest('.banner-slide-link').length > 0) {
          event.preventDefault();
          event.stopPropagation();
          return false;
        }
      }
    }
  });
  
  // Предотвращаем выделение текста при перетаскивании
  $('.banner__slider .swiper-wrapper, .banner__slider .swiper-slide').on('selectstart dragstart', function(e) {
    e.preventDefault();
    return false;
  });
  
  // Отдельная конфигурация для мобильного слайдера
  var bannerMobile = new Swiper('.banner__slider.mobile', {
    loop: false, // ОТКЛЮЧАЕМ бесконечный цикл - границы прокрутки для мобильной
    autoplay: false, // ОТКЛЮЧАЕМ автопрокрутку - только ручное управление
    speed: 600, // плавная анимация
    slidesPerView: 1, // всегда 1 фото на мобильном
    spaceBetween: 10,
    direction: 'horizontal',
    effect: 'slide',
    allowTouchMove: true, // ВКЛЮЧАЕМ перетаскивание для мобильных
    simulateTouch: true, // симулируем касания
    grabCursor: false, // ОТКЛЮЧАЕМ встроенный курсор Swiper (используем свой CSS)
    watchOverflow: true, // автоматически отключить если слайдов недостаточно
    rewind: true, // в конце - возврат к началу по кнопке
    keyboard: false, // ОТКЛЮЧАЕМ управление клавиатурой
    mousewheel: false, // ОТКЛЮЧАЕМ прокрутку колесиком мыши
    touchRatio: 1, // нормальная чувствительность к касаниям
    touchAngle: 45, // разрешаем касания под углом до 45 градусов
    preventInteractionOnTransition: false, // разрешаем взаимодействие во время анимации
    touchMoveStopPropagation: false, // не останавливаем события касаний
    followFinger: true, // следовать за пальцем/мышкой
    // Дополнительные настройки для карусельного перетаскивания мышью
    threshold: 5, // минимальное расстояние для начала перетаскивания
    resistanceRatio: 0.85, // сопротивление при достижении края
    longSwipesRatio: 0.3, // минимальное отношение для длинного свайпа
    longSwipesMs: 300, // максимальное время для длинного свайпа (мс)
    // ОТКЛЮЧАЕМ клики по ссылкам во время перетаскивания
    preventClicks: true, // Предотвращаем клики при перетаскивании
    preventClicksPropagation: true, // Останавливаем распространение кликов при перетаскивании
    slideToClickedSlide: false, // НЕ переходить к слайду при клике
    // События для управления кликами и перетаскиванием
    on: {
      touchStart: function() {
        this.$el.addClass('swiper-container-dragging');
      },
      touchEnd: function() {
        var self = this;
        setTimeout(function() {
          self.$el.removeClass('swiper-container-dragging');
        }, 50);
      },
      click: function(swiper, event) {
        // Предотвращаем клики по ссылкам после перетаскивания
        if ($(event.target).closest('.banner-slide-link').length > 0) {
          event.preventDefault();
          event.stopPropagation();
          return false;
        }
      }
    }
  });

  // Предотвращаем выделение текста при перетаскивании в мобильном слайдере
  $('.banner__slider.mobile .swiper-wrapper, .banner__slider.mobile .swiper-slide').on('selectstart dragstart', function(e) {
    e.preventDefault();
    return false;
  });
  
  let pageSlider = new Swiper('.js__page-slider', {
    slidesPerView: 1,
    watchOverflow: true,
    pagination: {
      el: '.swiper-pagination'
    },
    navigation: {
      nextEl: '.swiper-button-prev',
      prevEl: '.swiper-button-next'
    },
    breakpoints: {
      0: {
        pagination: {
          type: 'bullets'
        }
      },
      568: {
        pagination: {
          type: 'fraction'
        }
      }
    }
  });


  $().fancybox({
    selector: '[data-fancybox="gallery"]',
    animationEffect: "fade",
    infobar: true,
    backFocus : false,
    buttons: ["close"],

  });

  if (document.querySelector('.js__slider-year')) {
    let sliderYear = undefined,
        sliderYearBottom = undefined;

    function initSwiper() {
      var screenWidth = $(window).width();

      if (screenWidth > 768 && sliderYearBottom == undefined) {
        sliderYear = new Swiper('.js__slider-year', {
          watchSlidesVisibility: true,
          watchSlidesProgress: true,
          loop: true,
          breakpoints: {
            768: {
              slidesPerView: 3,
              spaceBetween: 40
            },
            992: {
              slidesPerView: 4,
              spaceBetween: 30
            },
            1200: {
              slidesPerView: "auto",
              spaceBetween: 60
            }
          }
        });
        sliderYearBottom = new Swiper('.js__slider-year-bottom', {
          watchOverflow: true,
          loop: true,
          navigation: {
            nextEl: '.slider-year-bottom-next',
            prevEl: '.slider-year-bottom-prev'
          },
          thumbs: {
            swiper: sliderYear
          }
        });
      } else if (screenWidth < 768 && sliderYearBottom != undefined) {
        sliderYear.destroy();
        sliderYearBottom.destroy();
        sliderYear = undefined;
        sliderYearBottom = undefined;
        $('.swiper-wrapper').removeAttr('style');
        $('.swiper-slide').removeAttr('style');
      }
    }

    initSwiper();
    $(window).on('resize', function () {
      initSwiper();
    });
  }

  let docSlider = new Swiper('.js__doc-slider', {
    navigation: {
      nextEl: '.swiper-button-prev',
      prevEl: '.swiper-button-next'
    },
    watchOverflow: true,
    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 15
      },
      771: {
        slidesPerView: 2,
        spaceBetween: 30
      },
      1200: {
        slidesPerView: 3,
        spaceBetween: 30
      }
    }
  });
  const scheduleSelect = document.querySelector('#schedule-select'),
        mapSelectElement = document.querySelector('#radiusSelect'),
        signUpSelect = document.querySelector('#signUpSelect'),
        askQuestionSelect = document.querySelector('#askQuestionSelect');

  if(signUpSelect){
   new SlimSelect({
      select: signUpSelect,
      placeholder: true,
      showSearch: false
    });
  }


  if(askQuestionSelect){
    new SlimSelect({
      select: askQuestionSelect,
      placeholder: true,
      showSearch: false
    });
  }
  if (mapSelectElement) {
    const mapSelect = new SlimSelect({
      select: mapSelectElement,
      placeholder: true,
      showSearch: false
    });
  }

  $(".schedule-table-nav-wrap").mCustomScrollbar({
    theme: "my-theme",
    mouseWheelPixels: 80
  });

  if (document.querySelector('.js__guide-left')) {
    let sliderYear = undefined,
        sliderYearBottom = undefined;

    function initSwiperGuide() {
      var screenWidth = $(window).width();

      if (screenWidth > 768 && sliderYearBottom == undefined) {
        var galleryThumbs = new Swiper('.js__guide-left', {
          slidesPerView: 1,
          spaceBetween: 30,
          centeredSlides: true,
          centeredSlidesBounds: true,
          watchOverflow: true,
          watchSlidesVisibility: true,
          watchSlidesProgress: true,
          observer: true,
          observeParents: true,
          breakpoints: {
            0: {
              spaceBetween: 15
            },
            768: {
              direction: 'vertical',
              spaceBetween: 30
            },
            1200: {
              direction: 'horizontal'
            }
          }
        });
        var galleryTop = new Swiper('.js__guide-right', {
          slidesPerView: 1,
          watchOverflow: true,
          watchSlidesVisibility: true,
          watchSlidesProgress: true,
          preventInteractionOnTransition: true,
          observer: true,
          observeParents: true,
          navigation: {
            nextEl: '.swiper-button-prev',
            prevEl: '.swiper-button-next'
          },
          thumbs: {
            swiper: galleryThumbs
          },
          effect: 'fade',
          fadeEffect: {
            crossFade: true
          }
        });
      } else if (screenWidth < 768 && sliderYearBottom != undefined) {
        sliderYear.destroy();
        sliderYearBottom.destroy();
        sliderYear = undefined;
        sliderYearBottom = undefined;
        $('.swiper-wrapper').removeAttr('style');
        $('.swiper-slide').removeAttr('style');
      }
    }

    initSwiperGuide();
    $(window).on('resize', function () {
      initSwiperGuide();
    });
  }

/* Календарь для формы */

  flatpickr.defaultConfig.prevArrow = `<svg width="9" height="28" viewBox="0 0 9 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M8.19329 9.07846L6.63424 7.51941L0 14.1537L6.63424 20.7879L8.19329 19.2288L3.12915 14.1537L8.19329 9.07846Z" fill="black" fill-opacity="0.6"/>
</svg>
`;
  flatpickr.defaultConfig.nextArrow = `<svg width="9" height="28" viewBox="0 0 9 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M2.35934 7.51953L0.800293 9.07858L5.86443 14.1538L0.800293 19.229L2.35934 20.788L8.99358 14.1538L2.35934 7.51953Z" fill="black" fill-opacity="0.6"/>
</svg>`;


  let langSite  = document.documentElement.lang;
 let  flatpickrInput =  $("#flatpickrInput");
  flatpickrInput.flatpickr({
    minDate: "today",
    locale: flatpickrInput.data('lang'),
    dateFormat: "d. m. Y",
  });


});

