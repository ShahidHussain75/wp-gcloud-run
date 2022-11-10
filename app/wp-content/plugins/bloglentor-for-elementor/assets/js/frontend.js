(function ($, w) {
    "use strict";
    var $window = $(w);

    $window.on('elementor/frontend/init', function() {

        var Slick = elementorModules.frontend.handlers.Base.extend({
            onInit: function () {
                elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
                this.$container = this.$element.find('.blfe-carousel');
                this.run();
            },

            isCarousel: function() {
                if(this.$element.hasClass('elementor-widget-blfe-post-grid')){
                    return this.$element.hasClass('elementor-widget-blfe-post-grid');
                } else if(this.$element.hasClass('elementor-widget-blfe-post-list')){
                    return this.$element.hasClass('elementor-widget-blfe-post-list');
                } else if( this.$element.hasClass('elementor-widget-blfe-news-ticker') ){
                    return this.$element.hasClass('elementor-widget-blfe-news-ticker');
                }
            },
            getDefaultSettings: function() {
                return {
                    arrows: false,
                    dots: false,
                    checkVisible: false,
                    infinite: true,
                    slidesToShow: this.isCarousel() ? 3 : 1,
                    rows: 0,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                }
            },

            onElementChange: function() {
                this.$container.slick('unslick');
                this.run();
            },

            getReadySettings: function() {

                var skin = this.$container.data('skin');

                var settings = {
                    autoplay: !! this.getElementSettings(''+skin+'_autoplay'),
                    autoplaySpeed: this.getElementSettings(''+skin+'_autoplay_speed'),
                    pauseOnHover: !! this.getElementSettings(''+skin+'_pause_on_hover'),
                    infinite: !! this.getElementSettings(''+skin+'_loop'),
                    speed: this.getElementSettings(''+skin+'_animation_speed'),
                    slidesToScroll: 1,
                    fade: this.getElementSettings(''+skin+'_animation') === 'fade',
                };

                switch (this.getElementSettings(''+skin+'_navigation')) {
                    case 'arrows':
                        settings.arrows = true;
                        break;
                    case 'dots':
                        settings.dots = true;
                        break;
                    case 'both':
                        settings.arrows = true;
                        settings.dots = true;
                        break;
                }

                if ( this.isCarousel() ) {
                    settings.slidesToShow = this.getElementSettings(''+skin+'_slides_to_show') || 3;

                    settings.responsive = [
                        {
                            breakpoint: elementorFrontend.config.breakpoints.lg,
                            settings: {
                                slidesToShow: (this.getElementSettings(''+skin+'_slides_to_show_tablet') || settings.slidesToShow),
                            }
                        },
                        {
                            breakpoint: elementorFrontend.config.breakpoints.md,
                            settings: {
                                slidesToShow: (this.getElementSettings(''+skin+'_slides_to_show_mobile') || this.getElementSettings(''+skin+'_slides_to_show_tablet')) || settings.slidesToShow,
                            }
                        }
                    ];
                }

                return $.extend({}, this.getDefaultSettings(), settings);
            },

            run: function() {
                this.$container.slick(this.getReadySettings());
            }
        });

        var handlersClassMap = {
            'blfe-post-grid.classic1': Slick,
            'blfe-post-grid.classic2': Slick,
            'blfe-post-grid.hero1': Slick,
            'blfe-post-grid.hero2': Slick,
            'blfe-post-grid.hero3': Slick,
            'blfe-post-grid.hero4': Slick,
            'blfe-post-grid.hero5': Slick,
            'blfe-post-grid.hero6': Slick,
            'blfe-post-grid.hero7': Slick,
            'blfe-post-grid.hero8': Slick,
            'blfe-post-grid.hero9': Slick,
            'blfe-post-grid.hero10': Slick,

            'blfe-post-list.classic1': Slick,
            'blfe-post-list.classic2': Slick,

            'blfe-news-ticker.classic1': Slick,
            'blfe-news-ticker.classic2': Slick,
        };

        $.each( handlersClassMap, function( widgetName, handlerClass ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/' + widgetName, function( $scope ) {
                elementorFrontend.elementsHandler.addHandler( handlerClass, { $element: $scope });
            });
        });

    });
} (jQuery, window));
