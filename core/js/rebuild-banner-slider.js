// Этот файл нужно подключить ПОСЛЕ scripts.min.js для переопределения настроек слайдера

jQuery(document).ready(function($) {
  // Переменные для отслеживания перетаскивания
  var isDragging = false;
  var dragStartX = 0;
  var dragStartY = 0;
  var dragThreshold = 8; // пикселей - уменьшаем для лучшего распознавания кликов

  // Удаляем старый слайдер если он существует
  if (typeof bannerVideo !== 'undefined' && bannerVideo && bannerVideo.destroy) {
    bannerVideo.destroy(true, true);
  }

  // Создаём новый слайдер с правильными настройками
  window.bannerVideo = new Swiper('.banner__slider', {
    loop: false,
    autoplay: {
      delay: 4000, // автопрокрутка каждые 4 секунды
      disableOnInteraction: false, // не останавливать автопрокрутку при взаимодействии
    },
    speed: 1200, // увеличиваем время анимации для плавности
    easing: 'ease-in-out', // плавная анимация
    slidesPerView: 3,
    slidesPerGroup: 1,
    spaceBetween: 20,
    centeredSlides: false,
    direction: 'horizontal',
    effect: 'slide',
    // ВКЛЮЧАЕМ перетаскивание мышкой
    allowTouchMove: true,
    simulateTouch: true,
    grabCursor: false,
    watchOverflow: true,
    rewind: true,
    keyboard: false,
    mousewheel: false,
    touchRatio: 1,
    touchAngle: 45,
    preventInteractionOnTransition: false,
    touchMoveStopPropagation: false,
    followFinger: true,
    threshold: 8,
    resistanceRatio: 0.85,
    longSwipesRatio: 0.3,
    longSwipesMs: 300,
    // БЛОКИРУЕМ клики Swiper, обрабатываем их сами
    preventClicks: true,
    preventClicksPropagation: true,
    slideToClickedSlide: false,
    navigation: {
      nextEl: '.banner-slider-next',
      prevEl: '.banner-slider-prev',
    },
    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 10,
        allowTouchMove: true,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 15,
        allowTouchMove: true,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
        allowTouchMove: true,
      }
    },
    on: {
      touchStart: function() {
        this.$el.addClass('swiper-container-dragging');
        isDragging = false;
        dragStartX = 0;
        dragStartY = 0;
      },
      touchEnd: function() {
        var self = this;
        setTimeout(function() {
          self.$el.removeClass('swiper-container-dragging');
          isDragging = false;
        }, 50);
      },
      click: function(swiper, event) {
        // Обрабатываем клики по ссылкам - упрощенная логика
        var linkElement = $(event.target).closest('.banner-slide-link');
        if (linkElement.length > 0) {
          var href = linkElement.attr('href');
          console.log('Swiper click detected, href:', href);

          if (href && href !== '#') {
            if (linkElement.attr('target') === '_blank') {
              window.open(href, '_blank', 'noopener,noreferrer');
            } else {
              window.location.href = href;
            }
            return false; // Останавливаем событие
          }
        }
      }
    }
  });

  // Прямой обработчик кликов по ссылкам для надежности
  $('.banner__slider .banner-slide-link').on('click.banner-direct', function(e) {
    var href = $(this).attr('href');
    console.log('Direct link click, href:', href);

    if (href && href !== '#') {
      if ($(this).attr('target') === '_blank') {
        window.open(href, '_blank', 'noopener,noreferrer');
      } else {
        window.location.href = href;
      }
      e.preventDefault();
      e.stopPropagation();
      return false;
    }
  });

  // Упрощенная обработка мыши - только для предотвращения выделения текста
  $('.banner__slider .swiper-slide').on('mousedown', function(e) {
    isDragging = false;
    dragStartX = e.pageX;
    dragStartY = e.pageY;
  });

  $('.banner__slider .swiper-slide').on('mouseup', function(e) {
    // Сбрасываем флаги после небольшого таймаута
    setTimeout(function() {
      isDragging = false;
      dragStartX = 0;
      dragStartY = 0;
    }, 50);
  });

  // Предотвращаем выделение текста
  $('.banner__slider .swiper-wrapper, .banner__slider .swiper-slide').on('selectstart dragstart', function(e) {
    e.preventDefault();
    return false;
  });

  // Удаляем старый мобильный слайдер если он существует
  if (typeof bannerMobile !== 'undefined' && bannerMobile && bannerMobile.destroy) {
    bannerMobile.destroy(true, true);
  }

  // Создаём мобильный слайдер
  window.bannerMobile = new Swiper('.banner__slider.mobile', {
    loop: false,
    autoplay: {
      delay: 4000, // автопрокрутка каждые 4 секунды
      disableOnInteraction: false, // не останавливать автопрокрутку при взаимодействии
    },
    speed: 1200, // увеличиваем время анимации для плавности
    easing: 'ease-in-out', // плавная анимация
    slidesPerView: 1,
    spaceBetween: 10,
    direction: 'horizontal',
    effect: 'slide',
    allowTouchMove: true,
    simulateTouch: true,
    grabCursor: false,
    watchOverflow: true,
    rewind: true,
    keyboard: false,
    mousewheel: false,
    touchRatio: 1,
    touchAngle: 45,
    preventInteractionOnTransition: false,
    touchMoveStopPropagation: false,
    followFinger: true,
    threshold: 8,
    resistanceRatio: 0.85,
    longSwipesRatio: 0.3,
    longSwipesMs: 300,
    preventClicks: true,
    preventClicksPropagation: true,
    slideToClickedSlide: false,
    on: {
      touchStart: function() {
        this.$el.addClass('swiper-container-dragging');
        isDragging = false;
        dragStartX = 0;
        dragStartY = 0;
      },
      touchEnd: function() {
        var self = this;
        setTimeout(function() {
          self.$el.removeClass('swiper-container-dragging');
          isDragging = false;
        }, 50);
      },
      click: function(swiper, event) {
        // Обрабатываем клики по ссылкам - упрощенная логика
        var linkElement = $(event.target).closest('.banner-slide-link');
        if (linkElement.length > 0) {
          var href = linkElement.attr('href');
          console.log('Swiper click detected, href:', href);

          if (href && href !== '#') {
            if (linkElement.attr('target') === '_blank') {
              window.open(href, '_blank', 'noopener,noreferrer');
            } else {
              window.location.href = href;
            }
            return false; // Останавливаем событие
          }
        }
      }
    }
  });

  // Прямой обработчик кликов по ссылкам для мобильного слайдера
  $('.banner__slider.mobile .banner-slide-link').on('click.banner-direct-mobile', function(e) {
    var href = $(this).attr('href');
    console.log('Direct mobile link click, href:', href);

    if (href && href !== '#') {
      if ($(this).attr('target') === '_blank') {
        window.open(href, '_blank', 'noopener,noreferrer');
      } else {
        window.location.href = href;
      }
      e.preventDefault();
      e.stopPropagation();
      return false;
    }
  });

  // Упрощенные обработчики для мобильного слайдера
  $('.banner__slider.mobile .swiper-slide').on('mousedown', function(e) {
    isDragging = false;
    dragStartX = e.pageX;
    dragStartY = e.pageY;
  });

  $('.banner__slider.mobile .swiper-slide').on('mouseup', function(e) {
    setTimeout(function() {
      isDragging = false;
      dragStartX = 0;
      dragStartY = 0;
    }, 50);
  });

  $('.banner__slider.mobile .swiper-wrapper, .banner__slider.mobile .swiper-slide').on('selectstart dragstart', function(e) {
    e.preventDefault();
    return false;
  });

  console.log('Banner slider reinitialize with improved click handling');
  
  // Дополнительная диагностика
  setTimeout(function() {
    var links = $('.banner__slider .banner-slide-link');
    console.log('Found banner links:', links.length);
    links.each(function(i) {
      console.log('Link ' + i + ':', $(this).attr('href'));
    });
  }, 1000);
});