/**
 * Banner Slider Plugin JavaScript
 */

(function($) {
    'use strict';

    /**
     * Banner Slider Class
     */
    class BannerSlider {
        constructor(container) {
            this.container = container;
            this.desktopSlider = null;
            this.mobileSlider = null;
            this.settings = this.getSettings();

            this.init();
        }

        /**
         * Get slider settings from data attributes or defaults
         */
        getSettings() {
            const container = this.container;
            const settings = container.data('settings') || {};

            return {
                slidesPerView: settings.slidesPerView || 3,
                spaceBetween: settings.spaceBetween || 20,
                sliderHeight: settings.sliderHeight || 300,
                enableAutoplay: settings.enableAutoplay || false,
                autoplayDelay: settings.autoplayDelay || 5000,
                showNavigation: settings.showNavigation !== false,
                enableTouch: settings.enableTouch || false
            };
        }

        /**
         * Initialize sliders
         */
        init() {
            this.initDesktopSlider();
            this.initMobileSlider();
            this.bindEvents();
        }

        /**
         * Initialize desktop slider
         */
        initDesktopSlider() {
            const desktopContainer = this.container.find('.banner-slider:not(.mobile)');

            if (desktopContainer.length === 0) {
                return;
            }

            this.desktopSlider = new Swiper(desktopContainer[0], {
                loop: false,
                autoplay: this.settings.enableAutoplay ? {
                    delay: this.settings.autoplayDelay,
                    disableOnInteraction: false
                } : false,
                speed: 600,
                slidesPerView: this.settings.slidesPerView,
                slidesPerGroup: 1,
                spaceBetween: this.settings.spaceBetween,
                centeredSlides: false,
                direction: 'horizontal',
                effect: 'slide',
                allowTouchMove: this.settings.enableTouch,
                simulateTouch: false,
                grabCursor: false,
                watchOverflow: true,
                rewind: true,
                keyboard: false,
                mousewheel: false,
                touchRatio: this.settings.enableTouch ? 1 : 0,
                touchAngle: 90,
                preventInteractionOnTransition: false,
                touchMoveStopPropagation: false,
                followFinger: false,
                navigation: this.settings.showNavigation ? {
                    nextEl: this.container.find('.banner-slider-next')[0],
                    prevEl: this.container.find('.banner-slider-prev')[0]
                } : false,
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 10,
                        allowTouchMove: this.settings.enableTouch
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 15,
                        allowTouchMove: this.settings.enableTouch
                    },
                    1024: {
                        slidesPerView: this.settings.slidesPerView,
                        spaceBetween: this.settings.spaceBetween,
                        allowTouchMove: this.settings.enableTouch
                    }
                }
            });
        }

        /**
         * Initialize mobile slider
         */
        initMobileSlider() {
            const mobileContainer = this.container.find('.banner-slider.mobile');

            if (mobileContainer.length === 0) {
                return;
            }

            this.mobileSlider = new Swiper(mobileContainer[0], {
                loop: false,
                autoplay: this.settings.enableAutoplay ? {
                    delay: this.settings.autoplayDelay,
                    disableOnInteraction: false
                } : false,
                speed: 600,
                slidesPerView: 1,
                spaceBetween: 10,
                direction: 'horizontal',
                effect: 'slide',
                allowTouchMove: this.settings.enableTouch,
                simulateTouch: false,
                grabCursor: false,
                watchOverflow: true,
                rewind: true,
                keyboard: false,
                mousewheel: false,
                touchRatio: this.settings.enableTouch ? 1 : 0,
                touchAngle: 90,
                preventInteractionOnTransition: false,
                touchMoveStopPropagation: false,
                followFinger: false,
                navigation: this.settings.showNavigation ? {
                    nextEl: this.container.find('.banner-slider-next')[0],
                    prevEl: this.container.find('.banner-slider-prev')[0]
                } : false
            });
        }

        /**
         * Bind additional events for link clicks
         */
        bindEvents() {
            const self = this;

            // Allow clicks on links but prevent dragging
            this.container.find('.banner-slider .swiper-wrapper, .banner-slider .swiper-slide').on('mousedown touchstart', function(e) {
                if ($(e.target).closest('.banner-slide-link').length > 0) {
                    return true; // Allow link clicks
                }
                e.preventDefault();
                e.stopPropagation();
                return false;
            });

            this.container.find('.banner-slider .swiper-wrapper, .banner-slider .swiper-slide').on('dragstart selectstart', function(e) {
                if ($(e.target).closest('.banner-slide-link').length > 0) {
                    return true; // Allow link clicks
                }
                e.preventDefault();
                return false;
            });

            // Pause autoplay on hover (if enabled)
            if (this.settings.enableAutoplay) {
                this.container.find('.banner-slider').on('mouseenter', function() {
                    if (self.desktopSlider) self.desktopSlider.autoplay.stop();
                    if (self.mobileSlider) self.mobileSlider.autoplay.stop();
                });

                this.container.find('.banner-slider').on('mouseleave', function() {
                    if (self.desktopSlider) self.desktopSlider.autoplay.start();
                    if (self.mobileSlider) self.mobileSlider.autoplay.start();
                });
            }

            // Handle window resize
            $(window).on('resize.banner-slider-' + this.container.attr('id'), function() {
                self.handleResize();
            });
        }

        /**
         * Handle window resize
         */
        handleResize() {
            // Reinitialize sliders if needed
            if (this.desktopSlider) {
                this.desktopSlider.update();
            }
            if (this.mobileSlider) {
                this.mobileSlider.update();
            }
        }

        /**
         * Destroy sliders (cleanup)
         */
        destroy() {
            if (this.desktopSlider) {
                this.desktopSlider.destroy();
                this.desktopSlider = null;
            }
            if (this.mobileSlider) {
                this.mobileSlider.destroy();
                this.mobileSlider = null;
            }

            $(window).off('resize.banner-slider-' + this.container.attr('id'));
        }
    }

    /**
     * Initialize all banner sliders on page load
     */
    $(document).ready(function() {
        $('.banner-slider-container').each(function() {
            new BannerSlider($(this));
        });
    });

    /**
     * Handle AJAX requests for dynamic content
     */
    $(document).on('banner_slider_reload', function(e, containerId) {
        const container = $('#' + containerId);
        if (container.length > 0) {
            // Destroy existing slider
            if (container.data('banner-slider-instance')) {
                container.data('banner-slider-instance').destroy();
            }

            // Create new slider instance
            const slider = new BannerSlider(container);
            container.data('banner-slider-instance', slider);
        }
    });

})(jQuery);

