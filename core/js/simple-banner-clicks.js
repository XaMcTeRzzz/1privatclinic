// Простой обработчик кликов без Swiper
jQuery(document).ready(function($) {
  console.log('Simple banner clicks loaded');

  // Ждем загрузки страницы
  setTimeout(function() {
    // Удаляем все обработчики Swiper
    if (typeof bannerVideo !== 'undefined' && bannerVideo && bannerVideo.destroy) {
      bannerVideo.destroy(true, true);
    }
    if (typeof bannerMobile !== 'undefined' && bannerMobile && bannerMobile.destroy) {
      bannerMobile.destroy(true, true);
    }

    // Простые клики по ссылкам
    $('.banner__slider .banner-slide-link').off('click').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      var href = $(this).attr('href');
      console.log('Simple click detected, href:', href);
      
      if (href && href !== '#') {
        if ($(this).attr('target') === '_blank') {
          window.open(href, '_blank', 'noopener,noreferrer');
        } else {
          window.location.href = href;
        }
      }
      return false;
    });

    // Простые клики для мобильного слайдера
    $('.banner__slider.mobile .banner-slide-link').off('click').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      var href = $(this).attr('href');
      console.log('Simple mobile click detected, href:', href);
      
      if (href && href !== '#') {
        if ($(this).attr('target') === '_blank') {
          window.open(href, '_blank', 'noopener,noreferrer');
        } else {
          window.location.href = href;
        }
      }
      return false;
    });

    console.log('Simple click handlers attached');
  }, 2000);
});
