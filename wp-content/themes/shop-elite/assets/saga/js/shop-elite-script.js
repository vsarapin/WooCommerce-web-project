!function (e) {
    "use strict";
    var n = window.SAGA_JS || {};
    n.stickyMenu = function () {
        e(window).scrollTop() > 350 ? e("#saga-header").addClass("nav-affix") : e("#saga-header").removeClass("nav-affix")
    },

        n.mobileMenu = {
            init: function () {
                this.toggleMenu(), this.menuMobile(), this.menuArrow()
            },
            toggleMenu: function () {
                e('#saga-header').on('click', '.toggle-menu', function (event) {
                    var ethis = e('.main-navigation .menu .menu-mobile');
                    if (ethis.css('display') == 'block') {
                        ethis.slideUp('300');
                        e("#saga-header").removeClass('mmenu-active');
                    } else {
                        ethis.slideDown('300');
                        e("#saga-header").addClass('mmenu-active');
                    }
                    e('.ham').toggleClass('exit');
                });
                e('#saga-header .main-navigation ').on('click', '.menu-mobile a i', function (event) {
                    event.preventDefault();
                    var ethis = e(this),
                        eparent = ethis.closest('li'),
                        esub_menu = eparent.find('> .sub-menu');
                    if (esub_menu.css('display') == 'none') {
                        esub_menu.slideDown('300');
                        ethis.addClass('active');
                    } else {
                        esub_menu.slideUp('300');
                        ethis.removeClass('active');
                    }
                    return false;
                });
            },
            menuMobile: function () {
                if (e('.main-navigation .menu > ul').length) {
                    var ethis = e('.main-navigation .menu > ul'),
                        eparent = ethis.closest('.main-navigation'),
                        pointbreak = eparent.data('epointbreak'),
                        window_width = window.innerWidth;
                    if (typeof pointbreak == 'undefined') {
                        pointbreak = 991;
                    }
                    if (pointbreak >= window_width) {
                        ethis.addClass('menu-mobile').removeClass('menu-desktop');
                        e('.main-navigation .toggle-menu').css('display', 'block');
                    } else {
                        ethis.addClass('menu-desktop').removeClass('menu-mobile').css('display', '');
                        e('.main-navigation .toggle-menu').css('display', '');
                    }
                }
            },
            menuArrow: function () {
                if (e('#saga-header .main-navigation div.menu > ul').length) {
                    e('#saga-header .main-navigation div.menu > ul .sub-menu').parent('li').find('> a').append('<i class="ion-ios-arrow-down">');
                }
            }
        },

        n.xsSearchReveal = function () {
            e('.icon-search').on('click', function (event) {
                e('body').toggleClass('reveal-search');
            });
            e('.close-popup').on('click', function (event) {
                e('body').removeClass('reveal-search');
            });
        },

        n.DataBackground = function () {
            var pageSection = e(".data-bg");
            pageSection.each(function (indx) {
                if (e(this).attr("data-background")) {
                    e(this).css("background-image", "url(" + e(this).data("background") + ")");
                }
            });
            e('.bg-image').each(function () {
                var src = e(this).children('img').attr('src');
                e(this).css('background-image', 'url(' + src + ')').children('img').hide();
            });
        },

        n.SagaSlider = function () {
            e(".saga-slider").slick({
                autoplay: true,
                autoplaySpeed: 10000,
                speed: 600,
                slidesToShow: 1,
                slidesToScroll: 1,
                pauseOnHover: false,
                dots: true,
                pauseOnDotsHover: true,
                cssEase: 'linear',
                fade: true,
                nextArrow: '<i class="slide-icon slide-next icon ion-ios-arrow-right"></i>',
                prevArrow: '<i class="slide-icon slide-prev icon ion-ios-arrow-left"></i>'
            });

            e(".shop_elite_product_widget.slider-enabled").each(function () {
                e(this).slick({
                    infinite: false,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    dots: true,
                    nextArrow: '<i class="slide-icon slide-next icon ion-ios-arrow-right"></i>',
                    prevArrow: '<i class="slide-icon slide-prev icon ion-ios-arrow-left"></i>',
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });

            e(".shop_elite_cat_products_widget.slider-enabled").each(function () {
                e(this).slick({
                    infinite: false,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    dots: true,
                    nextArrow: '<i class="slide-icon slide-next icon ion-ios-arrow-right"></i>',
                    prevArrow: '<i class="slide-icon slide-prev icon ion-ios-arrow-left"></i>',
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });

            e(".shop_elite_product_cat_widget.slider-enabled").each(function () {
                e(this).slick({
                    infinite: false,
                    dots: true,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    nextArrow: '<i class="slide-icon slide-next icon ion-ios-arrow-right"></i>',
                    prevArrow: '<i class="slide-icon slide-prev icon ion-ios-arrow-left"></i>',
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });

            e(".shop_elite_post_widget.slider-enabled").each(function () {
                e(this).slick({
                    infinite: false,
                    dots: true,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    nextArrow: '<i class="slide-icon slide-next icon ion-ios-arrow-right"></i>',
                    prevArrow: '<i class="slide-icon slide-prev icon ion-ios-arrow-left"></i>',
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            });
        },

        n.ToolTip = function () {
            e('[data-toggle="tooltip"]').tooltip();
        },

        n.WishListActions = function () {

            e('.saga-product-buttons .yith-btn .yith-wcwl-add-button').on('click', function () {
                e(this).addClass('loading');
            });

            e('body').on('added_to_wishlist', function (event, el, el_wrap) {
                el_wrap.addClass('added').find('.yith-wcwl-add-button').removeClass('loading');
                n.UpdateWishlistCounter();
            });

            e('body').on('removed_from_wishlist', function () {
                n.UpdateWishlistCounter();
            });
        },

        n.UpdateWishlistCounter = function () {
            e.ajax({
                url: shopElite.ajax_url,
                data: {
                    action: 'shop_elite_update_wishlist_count'
                },
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (data) {
                    if (data.count) {
                        e('.saga-wishlist .saga-woo-counter').html(data.count);
                    }
                },
                complete: function () {
                }
            });
        },

        n.CartActions = function () {

            if( e('.saga-product-buttons .cart-btn').length !== 0 && e( '#shop-elite-cart-popup-message' ).length === 0 ) {
                var message_div = e( '<div>' ).attr( 'id', 'shop-elite-cart-message' );
                var popup_div = e( '<div>' ).attr( 'id', 'shop-elite-cart-popup-message' ).html( message_div ).hide();
                e( 'body' ).prepend( popup_div );
            }

            e('body').on('added_to_cart', function (event, fragments, cart_hash, button) {

                button.find('.add-icon').addClass('hidden');
                button.find('.added-icon').removeClass('hidden');

                if (typeof fragments === 'undefined') {
                    fragments = e.parseJSON(sessionStorage.getItem(wc_cart_fragments_params.fragment_name));
                }
                e.each(fragments, function (key, value) {
                    if (key === 'shop_elite_added_to_cart_msg') {
                        var msg = e( '#shop-elite-cart-popup-message' );
                        e('#shop-elite-cart-message').html(value);
                        msg.fadeIn();
                        window.setTimeout( function() {
                            msg.fadeOut();
                        }, 5000 );
                        return false;
                    }
                });
            });
        },

        n.removePreloader = function () {
            e('.preloader').fadeOut('slow');
        },

        // SHOW/HIDE SCROLL UP //
        n.show_hide_scroll_top = function () {
            if (e(window).scrollTop() > e(window).height() / 2) {
                e("#scroll-up").fadeIn(300);
            } else {
                e("#scroll-up").fadeOut(300);
            }
        },

        // SCROLL UP //
        n.scroll_up = function () {
            e("#scroll-up").on("click", function () {
                e("html, body").animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        },

    e(document).ready(function () {
        n.mobileMenu.init(), n.xsSearchReveal(), n.DataBackground(), n.SagaSlider(), n.ToolTip(), n.WishListActions(), n.CartActions(), n.scroll_up();
    });
    e(window).load(function () {
        n.removePreloader();
    });
    e(window).scroll(function () {
        n.stickyMenu(), n.show_hide_scroll_top();
    });
    e(window).resize(function () {
        n.mobileMenu.menuMobile();
    })
}(jQuery);