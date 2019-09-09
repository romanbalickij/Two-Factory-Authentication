(function() {
  var __sections__ = {};
  (function() {
    for(var i = 0, s = document.getElementById('sections-script').getAttribute('data-sections').split(','); i < s.length; i++)
      __sections__[s[i]] = true;
  })();
  (function() {
  if (!__sections__["footer"]) return;
  try {

jQuery(document).ready(function($) {


	// CHECK FORM POSTED
	$('.contact-form').each(function (){
		$(this).on('submit', function(e){
			var formCookie = $(this).attr('class');
			$.cookie('formSended', formCookie);
		});
	});

	if( document.location.href.indexOf('?customer_posted=true') > 0 && $.cookie('formSended') == 'contact-form') {
		$('#newsletter_form .form_wrapper').hide();
		$('#newsletter_form .form_text').hide();
		$('#newsletter_form .alert-success').show();
	}

});

  } catch(e) { console.error(e); }
})();

(function() {
  if (!__sections__["header"]) return;
  try {

(function($) {

	// SET COOKIE CURRENCY //////////////////////////////////////////////////////////////////////////////////////////////////////////



	// CURRENCY SELECTOR ////////////////////////////////////////////////////////////////////////////////////////
	if ( typeof theme.shopCurrency != 'undefined' ) {

		var shopCurrency = theme.shopCurrency;

		var currencyActive = $('#currency_active');
		var currencySelector = $('#currency_selector');
		var currencySelectorItem = $('.currency_selector__item');

		// Sometimes merchants change their shop currency, let's tell our JavaScript file
		Currency.money_with_currency_format[shopCurrency] = theme.moneyFormatCurrency;
		Currency.money_format[shopCurrency] = theme.moneyFormat;

		// Cookie currency
		var cookieCurrency = Currency.cookie.read();

		// Saving the current price
		$('span.money').each(function() {
			$(this).attr( 'data-currency-' + theme.shopCurrency, $(this).html() );
		});

		// If there's no cookie.
		if ( cookieCurrency == null ) {
			Currency.currentCurrency = shopCurrency;
		}
		// If the cookie value does not correspond to any value in the currency dropdown.
		else if ( $('#currency_selector li[data-value=' + cookieCurrency + ']').length === 0 ) {
			Currency.currentCurrency = shopCurrency;
			Currency.cookie.write(shopCurrency);
		}
		else if ( cookieCurrency === shopCurrency ) {
			Currency.currentCurrency = shopCurrency;
		}
		else {
			Currency.convertAll( shopCurrency, cookieCurrency, 'span.money', 'money_format' );
		};

		currencySelectorItem.on('click', function(e) {
			var newCurrency = $(this).data('value');
			Currency.convertAll( Currency.currentCurrency, newCurrency, 'span.money', 'money_format' );
			currencyActive.text(newCurrency);

			currencyActive.removeClass('opened');
			currencySelector.removeClass('opened');

		});

		currencySelectorItem.each(function() {
			var currencyValue = $(this).data('value');

			if ( currencyValue == cookieCurrency ) {
				currencyActive.text(currencyValue);
			};

		});

		currencyActive.on('click', function() {
			if ( currencyActive.hasClass('opened') ) {
				currencyActive.removeClass('opened');
				currencySelector.removeClass('opened');
			}
			else {
				currencyActive.addClass('opened');
				currencySelector.addClass('opened');
			};
		});

		$(document).on('click', function(){
			if ( currencyActive.hasClass('opened') ) {
				currencyActive.removeClass('opened');
				currencySelector.removeClass('opened');
			};
		});

		currencyActive.on('click', function(e) {
			e.stopPropagation();
		});

	};










	// STICKY MENU v.1 //////////////////////////////////////////////////////////////////////////////////////////////////////////
	stickyHeader = function() {

		var target = $('#page_header');
		var pseudo = $('#pseudo_sticky_block');
		var stick_class = 'megamenu_stuck';

		$(window).on('load scroll resize', function() {

			if ( $(window).width() > 991 ) {
				var scrolledValue = parseInt( $(window).scrollTop() );
				var offsetValue = parseInt( pseudo.offset().top );
				var headHeight = target.outerHeight();

				if ( scrolledValue > offsetValue ) {
					target.addClass( stick_class );
					pseudo.css({ 'height' : headHeight });
				}
				else {
					target.removeClass( stick_class );
					pseudo.css({ 'height' : 0 });
				};
			}
			else {
				target.removeClass( stick_class );
				pseudo.css({ 'height' : 0 });
			};

		});

		$(window).on('load', function() {
			setTimeout(
				function(){ $(window).trigger('scroll') }
			, 180 );
		});

	};

	stickyHeader();




	// USER MENU TOGGLE
	var userMenu = $('.header_user_menu');

	$('.header_user_toggle').on('click', function(e){
		userMenu.addClass('open').fadeIn(400);
	});

	$(document).mouseup(function (e) {
		if ( $('.header_user').has(e.target).length === 0 ){
			if ( userMenu.hasClass('open') ) {
				userMenu.removeClass('open').fadeOut(400);
			};
		};
	});





})(jQuery);

  } catch(e) { console.error(e); }
})();

(function() {
  if (!__sections__["index-products-carousel"] && !window.DesignMode) return;
  try {

jQuery(document).ready(function($) {
	$('.products_carousel').each(function(i) {

		var sliderId = '#' + $(this).attr('id');
		var sliderVar = $(this).attr('id');
		var sliderPrev = '#carousel_swiper__prev_' + sliderVar.replace('products_carousel_', '');
		var sliderNext = '#carousel_swiper__next_' + sliderVar.replace('products_carousel_', '');
		var productsQ = $(this).data('products');
		var sliderRows = $(this).data('rows');
		var sliderDir = $(this).data('dir');

		if ( productsQ > 4 && sliderRows == 1 ) {
			var carouselVar = new Swiper( sliderId, {
				effect: 'slide',
				slidesPerView: 3,
				spaceBetween: 30,
				loop: true,
				speed: 500,
				autoplayDisableOnInteraction: false,

				breakpoints: {
					992: {
						slidesPerView: 2
					},
					768: {
						slidesPerView: 2
					},
					480: {
						slidesPerView: 1
					}
				},

				prevButton: sliderPrev,
				nextButton: sliderNext,

			});

			$(window).on('load', function() {
				carouselVar.onResize(); // updating swiper after loading
			});
		};



		if ( productsQ > 8 && sliderRows == 2 ) {

			var slider1 = sliderId + ' .swiper_1';
			var slider2 = sliderId + ' .swiper_2';
			var slider1_prev = sliderId + ' .swiper_1 .carousel_1_prev';
			var slider1_next = sliderId + ' .swiper_2 .carousel_1_next';
			var slider2_prev = sliderId + ' .swiper_1 .carousel_2_prev';
			var slider2_next = sliderId + ' .swiper_2 .carousel_2_next';

			var carousel_1 = new Swiper( slider1, {
				effect: 'slide',
				slidesPerView: 3,
				spaceBetween: 30,
				loop: true,
				speed: 500,
				autoplayDisableOnInteraction: false,

				breakpoints: {
					992: {
						slidesPerView: 2
					},
					768: {
						slidesPerView: 2
					},
					480: {
						slidesPerView: 1
					}
				},

				prevButton: slider1_prev,
				nextButton: slider1_next,

			});


			var carousel_2 = new Swiper( slider2, {
				effect: 'slide',
				slidesPerView: 3,
				spaceBetween: 30,
				loop: true,
				speed: 500,
				autoplayDisableOnInteraction: false,

				breakpoints: {
					992: {
						slidesPerView: 2
					},
					768: {
						slidesPerView: 2
					},
					480: {
						slidesPerView: 1
					}
				},

				prevButton: slider2_prev,
				nextButton: slider2_next,

			});

			if (sliderDir == 1) {
				$(sliderPrev).on('click', function() {
					carousel_1.slidePrev();
					carousel_2.slidePrev();
				});
				$(sliderNext).on('click', function() {
					carousel_1.slideNext();
					carousel_2.slideNext();
				});
			} else {
				$(sliderPrev).on('click', function() {
					carousel_1.slidePrev();
					carousel_2.slideNext();
				});
				$(sliderNext).on('click', function() {
					carousel_1.slideNext();
					carousel_2.slidePrev();
				});
			};

			$(window).on('load', function() {
				carousel_1.onResize(); // updating swiper after loading
				carousel_2.onResize();
			});

		};



	});

});

  } catch(e) { console.error(e); }
})();

(function() {
  if (!__sections__["index-slideshow"] && !window.DesignMode) return;
  try {

jQuery(document).ready(function($) {
	$('.section_slideshow').each(function(i) {

		var sliderId = '#' + $(this).attr('id');
		var sliderVar = $(this).attr('id');
		var sliderPrev = '#slider_prev_' + sliderVar.replace('slideshow_', '');
		var sliderNext = '#slider_next_' + sliderVar.replace('slideshow_', '');

		var sliderAutoplay = $(this).data('autoplay');
		if ( sliderAutoplay == true ) {
			sliderAutoplay = $(this).data('speed');
		};

		var sliderVar = new Swiper( sliderId, {
			effect: 'fade',
			autoplay: sliderAutoplay,
			loop: true,
			speed: 500,
			autoplayDisableOnInteraction: false,

			prevButton: sliderPrev,
			nextButton: sliderNext,

		});

		$(window).on('load', function() {
			sliderVar.onResize(); // updating swiper after loading
		});

	});

});

  } catch(e) { console.error(e); }
})();

})();
