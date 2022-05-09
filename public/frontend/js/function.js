function openQuickShop(selector) {
    var btnOpen = $(selector);
    btnOpen.parent().next().children().children().addClass('active');
}

function closeQuickShop(selector) {
    var quickShopPannel = $(selector).parent().parent().parent();
    quickShopPannel.removeClass('active');
}

function setActiveColorQuickShop(selector) {
    $(selector).parent().children().removeClass('active');
    $(selector).addClass('active');
}

    var items = $('.cl-main-page-wrapper .cl-wrapper-container .cl-main-collection .cl-product-item');
console.log(items);

function setNumberCol(number, selector) {
    var items = $('.cl-main-page-wrapper .cl-wrapper-container .cl-main-collection .cl-product-item');
    if (number == 1) {
        items.removeClass('col-6')
        items.removeClass('col-md-4');
        items.removeClass('col-lg-3');
        items.addClass('col-12');
    }
    if (number == 2) {
        items.removeClass('col-12');
        items.removeClass('col-md-4');
        items.removeClass('col-lg-3');
        items.addClass('col-6')
    } else if (number == 3) {
        items.removeClass('col-lg-3');
        items.addClass('col-md-4');
    } else if (number == 4) {
        items.addClass('col-lg-3');
    }
    $(selector).parent().find('.active').removeClass('active');
    $(selector).addClass('active');
}

function slideToggleCategories(selector) {
    if ($(selector).hasClass('showed')) {
        $(selector).removeClass('showed');
    } else {
        $(selector).addClass('showed');
    }
    $('.cl-main-page-wrapper .cl-wrapper-container .cl-banner-collection .cl-catetogies-shop .cl-cat-items').slideToggle('fast');
}

function showFeature(selector) {
    var featureMenu = $('.cl-main-page-wrapper .cl-wrapper-container .cl-top-collection .shop-tools .shopify-ordering .cl-select_orderby');
    if (featureMenu.hasClass('active')) {
        featureMenu.removeClass('active');
    } else {
        featureMenu.addClass('active');
    }
    var arrow = $(selector).find('.a1a');
    arrow.css('transition', '300ms all');
    if (arrow.hasClass('flip-verticaly')) {
        arrow.removeClass('flip-verticaly');
    } else {
        arrow.addClass('flip-verticaly');
    }
}


function validatePassword() {
var password = document.getElementById("password"),
    confirm_password = document.getElementById("confirm_password");
    if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
    } else {
        confirm_password.setCustomValidity('');
    }
}

$(document).ready(function() {

    function size_and_color() {
        $(".cl-choose_color").find(".cl-radio").eq(0).find('input[name="color_id"]').attr('checked', 'true');
        $(".cl-lish-size").find(".cl-radio").eq(0).find('input[name="size_id"]').attr('checked', 'true');

        $('.cl-result-size').text($("input:radio[name=size_id]:checked").attr('data-size'));
        $('.cl-result-color').text($("input:radio[name=color_id]:checked").attr('data-color'));

        $(document).on('click', '.cl-radio', function(event) {
            $('.cl-result-size').text($("input:radio[name=size_id]:checked").attr('data-size'));
            $('.cl-result-color').text($("input:radio[name=color_id]:checked").attr('data-color'));
        });
    }
    size_and_color();

    $(function() {
        function animation_hover_setting() {
            $('.cl-edit').hover(function() {
                $(this).children().toggleClass('fa-spin');
            });
        }
        animation_hover_setting();
    });


    $(function() {

    });

    /*--------------Accordion Mobile Colection Filter---------------*/

    $(function() {
        function Accordions_on_Mobile() {
            if ($(window).width() < 992) {
                $(".cl-click-acording").unbind().click(function(event) {
                    event.preventDefault();
                    // $(this).addClass('opened');
                    // $(this).siblings().removeClass('opened');
                    $(this).next('.cl-style-colection').slideToggle(200);
                    // $('.cl-style-colection').not($(this).next()).slideUp(200);
                });

            } else {
                $(".cl-click-acording").unbind('click');
            }
        }

        $(window).resize(Accordions_on_Mobile);
        $(window).load(Accordions_on_Mobile);
        Accordions_on_Mobile();
        $(window).resize(function() {
            if ($(window).width() >= 991) {
                $('.cl-style-colection').removeAttr('style');
            }
        })
    });

    /*------------------Sticky Menu------------------*/
    function Sticky_Menu() {
        var $header = $(".cl-wild-menu");
        var $clone = $header.before($header.clone().removeClass("clone"));
        var yourNavigation = $(".cl-main-page-wrapper");
        stickyDiv = "stickyOn";
        yourHeader = $(".cl-wild-menu.cl-min-height").outerHeight() + $(".cl-wild-menu.cl-min-height").offset().top;

        $(window).scroll(function() {
            if ($(window).scrollTop() > yourHeader) {
                yourNavigation.addClass(stickyDiv);
            } else {
                yourNavigation.removeClass(stickyDiv);
            }
        });

    }
    Sticky_Menu();

    /*------------------Open Menu On Mobile Responsible------------------*/
    $(function() {
        function open_menu_in_mobile() {
            $(".cl-show-menu.menu-toggle").click(function(e) {
                e.preventDefault();
                $(".cl-header-menu.cl-horizon-menu, .cl-overlay-mobile_menu").toggleClass("active");
            });

            $(".cl-overlay-mobile_menu").click(function(e) {
                e.preventDefault();
                $(".cl-header-menu.cl-horizon-menu, .cl-overlay-mobile_menu").removeClass("active");
            });

            $(document).on('keyup', function(evt) {
                if (evt.keyCode == 27) {
                    $(".cl-header-menu.cl-horizon-menu, .cl-overlay-mobile_menu").removeClass("active");
                }
            });
        }
        open_menu_in_mobile();
    });
    /*------------------Filter SideBar Responsible-------------*/

    $(function() {
        function Filter_Sidebar_on_Mobile() {
            $(".cl-toggle-filter").click(function(e) {
                e.preventDefault();
                $(".cl-filter_sidebar_colection-wrapper").toggleClass("cl-show");
                $(".hidden-scroll-y").toggleClass("active");
            });
        }

        Filter_Sidebar_on_Mobile();
    });


    /*---------------------Hide Sidebar-----------------------*/
    $(function() {
        function Hide_and_Show_Sidebar_on_Desktop() {
            $(".cl-click-hide_sidebar").click(function(e) {
                e.preventDefault();
                $(".cl-filter_sidebar_colection-wrapper").toggleClass("collapsed");
                $(".cl-product-wrapper.cl-colection-content_item, #row-main, .cl-show-side_bar_desktop").toggleClass("active");
            });

            $(".cl-show-side_bar_desktop .cl-filter-block").click(function(e) {
                e.preventDefault();
                $(".cl-show-side_bar_desktop").hide("active");
            });
        }

        Hide_and_Show_Sidebar_on_Desktop();
    });
    /*------------------Slick Slider Syncing Vertical------------------*/
    $(function() {
        function Slick_Slide_Syncing_Vertical() {
            $('.cl-slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: false,
                adaptiveHeight: true,
                infinite: false,
                useTransform: true,
                dots: false,
                speed: 300,
                asNavFor: $('.cl-slider-nav'),
            });

            $('.cl-slider-nav').slick({
                dots: false,
                infinite: false,
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: $('.cl-slider-for'),
                arrows: false,
                speed: 300,
                focusOnSelect: true,
                vertical: true,
                verticalSwiping: true,
                prevArrow: '<button class="cl-arrow-nav slide-arrow prev-arrow"><i class="fa fa-angle-up"></i></button>',
                nextArrow: '<button class="cl-arrow-nav slide-arrow next-arrow"><i class="fa fa-angle-down"></i></button>',
                responsive: [{
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        vertical: false,
                        verticalSwiping: false,
                    }
                }]
            });


            $('.cl-slider-for.cl-slider-for_2').on('beforeChange', function(event, slick, slide, nextSlide) {
                $('.cl-slider-nav.cl-slider-nav_2').find('.slick-slide').removeClass('slick-current').eq(nextSlide).addClass('slick-current');
            });

             // $('div[data-slide]').click(function() {
             //   var slideno = $(this).data('slide');
             //   $('.cl-slider-nav').slick('slickGoTo', slideno - 1);
             // });
        }

        Slick_Slide_Syncing_Vertical();
    });
    /*------------------Slick Slider Syncing------------------*/
    $(function() {
        function Slick_Slide_Alone() {
            $('.cl-insta-carousel').slick({
                arrows: true,
                dots: false,
                slidesToShow: 6,
                slidesToScroll: 1,
                infinite: true,
                speed: 300,
                responsive: [{
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 5
                        }
                    },

                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 4
                        }
                    },

                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 3
                        }
                    },

                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1
                        }
                    },
                ]
            });
        }
        Slick_Slide_Alone();
    });

    $(function() {
        function slide_related_item() {
            $('.cl-slide-related-product').slick({
                arrows: true,
                dots: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                speed: 300,
                swipeToSlide: true,
                responsive: [

                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3
                        }
                    },

                    {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 2
                        }
                    },

                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2
                        }
                    },

                    {
                        breakpoint: 320,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        }
        slide_related_item();
    });
    

    $(function() {
        function Slick_Slide_big() {
            $('.cl-big-carousel').slick({
                arrows: true,
                fade: true,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                speed: 300,
                autoplay: true,
                autoplaySpeed: 3000
            });
        }
        Slick_Slide_big();
    });

    $(function() {
        function Slick_Slide_child() {
            $('.cl-carousel-item-child').slick({
                arrows: true,
                fade: true,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                speed: 300,
                autoplay: false,

            });
        }
        Slick_Slide_child();
    });
    /*---------------------Zoom-img-----------------------*/
    $(function() {
        function Zoom_images() {
            $('.cl-main-page-wrapper .zoom__image img').each(function() {
                var $this = $(this);
                $this.trigger('zoom.destroy');
                var zoom_parent = $this.closest('.zoom__image')
                zoom_parent.zoom({
                    url: $this.attr('data-bigimg'),
                    touch: false
                });
            });
        }
        Zoom_images();
    });

    /*-----------------select-color-active------------------*/
    $('.cl-lish-color .cl-color').click(function(event) {
        event.preventDefault();
        $('.cl-lish-color .cl-color').removeClass('active');
        $(this).addClass('active');
    })

    /*-----------------select-size-active------------------*/
    $('.cl-lish-size .cl-size').click(function(event) {
        event.preventDefault();
        $('.cl-lish-size .cl-size').removeClass('active');
        $(this).addClass('active');
    })

    /*-----------------choose-color-sidebar------------------*/
    $('.cl-choose-color.cl-style-colection .cl-color').click(function(event) {
        event.preventDefault();
        $(this).toggleClass('active');
    })

    /*---------------------Quantity-----------------------*/
    $(function() {
        function Quantity_Box() {
            $('.cl-input-qty.cl-input-number').keyup(function() {
                var cong = $('input[type="number"]').data('max');
                var tru = $('input[type="number"]').data('min');
                if ($(this).val() > cong) {
                    alert("Do not enter more than "+cong+" products");
                    $(this).val(cong);
                }else if($('.cl-input-qty.cl-input-number.cl-exist').val()<tru){
                  alert('Do not reduce less than '+tru+' products');
                  $(this).val(tru);
                }
            });

            $('.cl-qtyplus.cl-quantity-plus').click(function () {
                var cong = $('input[type="number"]').data('max');
                if ($(this).prev().val() < cong) {
                    $(this).prev().val(+$(this).prev().val() + 1);
                }else{
                  alert('The maximum number has been reached '+cong);
                  $('input[name="qty"]').val(cong);
                }
            });

            $('.cl-qtyminus.cl-quantity-minus').click(function () {
                var tru = $('input[type="number"]').data('min');
                if ($(this).next().val() > tru) {
                    if ($(this).next().val() > tru) {
                      $(this).next().val(+$(this).next().val() - 1);
                    }
                }
            });
          }
        Quantity_Box();
    });

    /*---------------------Quantity-----------------------*/
    $(function() {
        function showing_result() {
            var n = $(".cl-product-item.cl-list-colection.cl-card-product").length;
            $(".result-count-order .cl-results-title span").text(n);

        }
        showing_result();
    });

    /*---------------------Scroll to top-----------------------*/
        $(document).on('scroll', function() {

            if ($(window).scrollTop() > 150) {
                $('#cl-scroll-top-wrapper').addClass('show');
            } else {
                $('#cl-scroll-top-wrapper').removeClass('show');
            }
        });

        $(document).on('click', '#cl-scroll-top-wrapper', function(event) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        });
    /*----------------------Tab Panels 1---------------------------*/

    $('.cl-main-page-wrapper .cl-tabs-wrapper .tabs.flex-tabs li.cl-bt-tab-1').click(function(event) {
        event.preventDefault();
        var tab_id_cl = $(this).attr('data-toggle-tab');

        $('.cl-tabs-wrapper .tabs.flex-tabs li.cl-bt-tab-1').removeClass('active');
        $('.cl-tabs-wrapper .tab-content').removeClass('active');
        $(this).addClass('active');
        $("#" + tab_id_cl).addClass('active');
    })

    $(function() {
        function change_position() {
            $('.cl-ordered-customer').insertAfter('.cl-welcome-dashboard');
        }
        change_position();
    });

    /*-----------------Modal box--------------------*/
    $(function() {
        $(".cl-main-page-wrapper .cl-click-size_guide").click(function(e) {
            e.preventDefault();
            $(".hidden-scroll-y").addClass("active");
            dataModal = $(this).attr("data-modal");
            $("#" + dataModal).css({
                "display": "flex"
            });
        });

        $(".cl-modal-size-guild.modal .modal-box .modal-header .close-modal").click(function() {
            $('#modal-size-guild').fadeOut(150);
            $(".hidden-scroll-y").removeClass("active");
        });

        $('#modal-size-guild ').click(function() {
            $('#modal-size-guild').fadeOut(150);
            $(".hidden-scroll-y").removeClass("active");
        })
        $('.cl-modal-size-guild.modal .modal-box').click(function(e) {
            e.stopPropagation();
        })
        $(document).on('keyup', function(evt) {
            if (evt.keyCode == 27) {
                $("#modal-size-guild").fadeOut(150);
                $(".hidden-scroll-y, .cl-popup_login").removeClass("active");
            }
        });
    });

    /*------------------Popup Login-------------*/

    $(function() {
        function popup_login() {
            $(".cl-popup_login_wild").click(function(e) {
                e.preventDefault();
                $(".cl-popup_login, .hidden-scroll-y").addClass("active");
            });

            $(".cl-close-form, .cl-popup_login .overlay").click(function() {
                $(".cl-popup_login, .hidden-scroll-y").removeClass("active");
            });

        }

        popup_login();
    });

    /*--Pagination admin page--*/
    function Pagination() {
        (function($) {
            var pagify = {
                items: {},
                container: null,
                totalPages: 1,
                perPage: 3,
                currentPage: 0,
                createNavigation: function() {
                    this.totalPages = Math.ceil(this.items.length / this.perPage);

                    $('.pagination', this.container.parent()).remove();
                    var pagination = $('<div class="pagination"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

                    for (var i = 0; i < this.totalPages; i++) {
                        var pageElClass = "page";
                        if (!i)
                            pageElClass = "page current";
                        var pageEl = '<a class="' + pageElClass + '" data-page="' + (
                            i + 1) + '">' + (
                            i + 1) + "</a>";
                        pagination.append(pageEl);
                    }
                    pagination.append('<a class="nav next" data-next="true">></a>');

                    this.container.after(pagination);

                    var that = this;
                    $("body").off("click", ".nav");
                    this.navigator = $("body").on("click", ".nav", function() {
                        var el = $(this);
                        that.navigate(el.data("next"));
                    });

                    $("body").off("click", ".page");
                    this.pageNavigator = $("body").on("click", ".page", function() {
                        var el = $(this);
                        that.goToPage(el.data("page"));
                    });
                },
                navigate: function(next) {
                    // default perPage to 5
                    if (isNaN(next) || next === undefined) {
                        next = true;
                    }
                    $(".pagination .nav").removeClass("disabled");
                    if (next) {
                        this.currentPage++;
                        if (this.currentPage > (this.totalPages - 1))
                            this.currentPage = (this.totalPages - 1);
                        if (this.currentPage == (this.totalPages - 1))
                            $(".pagination .nav.next").addClass("disabled");
                    } else {
                        this.currentPage--;
                        if (this.currentPage < 0)
                            this.currentPage = 0;
                        if (this.currentPage == 0)
                            $(".pagination .nav.prev").addClass("disabled");
                    }

                    this.showItems();
                },
                updateNavigation: function() {

                    var pages = $(".pagination .page");
                    pages.removeClass("current");
                    $('.pagination .page[data-page="' + (
                        this.currentPage + 1) + '"]').addClass("current");
                },
                goToPage: function(page) {

                    this.currentPage = page - 1;

                    $(".pagination .nav").removeClass("disabled");
                    if (this.currentPage == (this.totalPages - 1))
                        $(".pagination .nav.next").addClass("disabled");

                    if (this.currentPage == 0)
                        $(".pagination .nav.prev").addClass("disabled");
                    this.showItems();
                },
                showItems: function() {
                    this.items.hide();
                    var base = this.perPage * this.currentPage;
                    this.items.slice(base, base + this.perPage).show();

                    this.updateNavigation();
                },
                init: function(container, items, perPage) {
                    this.container = container;
                    this.currentPage = 0;
                    this.totalPages = 1;
                    this.perPage = perPage;
                    this.items = items;
                    this.createNavigation();
                    this.showItems();
                }
            };

            // stuff it all into a jQuery method!
            $.fn.pagify = function(perPage, itemSelector) {
                var el = $(this);
                var items = $(itemSelector, el);

                // default perPage to 5
                if (isNaN(perPage) || perPage === undefined) {
                    perPage = 3;
                }

                // don't fire if fewer items than perPage
                if (items.length <= perPage) {
                    return true;
                }

                pagify.init(el, items, perPage);
            };
        })(jQuery);
        $(".datatable").pagify(5, ".single-item");
        $(".datatables").pagify(4, ".single-items");
        $(".datatabless").pagify(12, ".single-itemss");
        // $(".cl-product-listing").pagify(9, ".cl-card-product");

    }
    Pagination();



});