/***************************************************
==================== JS INDEX ======================
****************************************************
01. PreLoader Js
****************************************************/

(function ($) {
	"use strict";


	// 01. nav-tabs
	function tabtable_active() {

		var e = document.getElementById("filt-monthly"),
			d = document.getElementById("filt-yearly"),
			t = document.getElementById("switcher"),
			m = document.getElementById("monthly"),
			y = document.getElementById("hourly");

		e.addEventListener("click", function () {
			t.checked = false;
			e.classList.add("toggler--is-active");
			d.classList.remove("toggler--is-active");
			m.classList.remove("hide");
			y.classList.add("hide");
		});

		d.addEventListener("click", function () {
			t.checked = true;
			d.classList.add("toggler--is-active");
			e.classList.remove("toggler--is-active");
			m.classList.add("hide");
			y.classList.remove("hide");
		});

		t.addEventListener("click", function () {
			d.classList.toggle("toggler--is-active");
			e.classList.toggle("toggler--is-active");
			m.classList.toggle("hide");
			y.classList.toggle("hide");
		})
	}
	if ($('#filt-monthly').length > 0) { 
		tabtable_active();
	}
	

	// 02. nav-tabs-2
	function tabtable_active_1() {
		
		var e = document.getElementById("filt-monthly-seo"),
			d = document.getElementById("filt-yearly-seo"),
			t = document.getElementById("switcher-seo"),
			m = document.getElementById("monthly-seo"),
			y = document.getElementById("hourly-seo");

		e.addEventListener("click", function () {
			t.checked = false;
			e.classList.add("analisis-toggler--is-active");
			d.classList.remove("analisis-toggler--is-active");
			m.classList.remove("analisis-hide");
			y.classList.add("analisis-hide");
		});

		d.addEventListener("click", function () {
			t.checked = true;
			d.classList.add("analisis-toggler--is-active");
			e.classList.remove("analisis-toggler--is-active");
			m.classList.add("analisis-hide");
			y.classList.remove("analisis-hide");
		});

		t.addEventListener("click", function () {
			d.classList.toggle("analisis-toggler--is-active");
			e.classList.toggle("analisis-toggler--is-active");
			m.classList.toggle("analisis-hide");
			y.classList.toggle("analisis-hide");
		})
	}
	
	if ($('#filt-monthly-seo').length > 0) { 
		tabtable_active_1();
	}
	

	// 03. nav-tabs-3
	function tabtable_active_2() {
		
		var e = document.getElementById("filt-monthly-price"),
			d = document.getElementById("filt-yearly-price"),
			t = document.getElementById("switcher-price"),
			m = document.getElementById("monthly-price"),
			y = document.getElementById("hourly-price");

		e.addEventListener("click", function () {
			t.checked = false;
			e.classList.add("toggler-price-active");
			d.classList.remove("toggler-price-active");
			m.classList.remove("price-is-hide");
			y.classList.add("price-is-hide");
		});

		d.addEventListener("click", function () {
			t.checked = true;
			d.classList.add("toggler-price-active");
			e.classList.remove("toggler-price-active");
			m.classList.add("price-is-hide");
			y.classList.remove("price-is-hide");
			document.getElementById("switcher").checked = true;
		});

		t.addEventListener("click", function () {
			d.classList.toggle("toggler-price-active");
			e.classList.toggle("toggler-price-active");
			m.classList.toggle("price-is-hide");
			y.classList.toggle("price-is-hide");
		})
	}
	
	if ($('#filt-monthly-price').length > 0) { 
		tabtable_active_2();
	}


	$('.col-custom').on("click", function () {
		// $('#features-item-thumb').removeClass().addClass($(this).attr('rel'));
		$(this).addClass('active').siblings().removeClass('active');
	});

	var windowOn = $(window);


	////////////////////////////////////////////////////
	// 04. PreLoader Js
	windowOn.on('load', function () {
		$("#loading").fadeOut(500);
	});


	////////////////////////////////////////////////////
	// 05. Mobile Menu Js
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991",
		meanExpand: ['<i class="fal fa-plus"></i>'],
	});


	////////////////////////////////////////////////////
	// 06. Mobile Menu Js
	$('#mobile-menu-2').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "1199",
		meanExpand: ['<i class="fal fa-plus"></i>'],
	});

	// last child menu
	$('.wp-menu nav > ul > li').slice(-4).addClass('menu-last');


	////////////////////////////////////////////////////
	// 07. Offcanvas Js
	$(".offcanvas-open-btn").on("click", function () {
		$(".offcanvas__area").addClass("offcanvas-opened");
		$(".body-overlay").addClass("opened");
	});
	$(".offcanvas-close-btn").on("click", function () {
		$(".offcanvas__area").removeClass("offcanvas-opened");
		$(".body-overlay").removeClass("opened");
	});


	////////////////////////////////////////////////////
	// 08. Body overlay Js
	$(".body-overlay").on("click", function () {
		$(".offcanvas__area").removeClass("offcanvas-opened");
		$(".cartmini__area").removeClass("cartmini-opened");
		$(".body-overlay").removeClass("opened");
	});


	$(".cartmini-open-btn").on("click", function () {
		$(".cartmini__area").addClass("cartmini-opened");
		$(".body-overlay").addClass("opened");
	});


	$(".cartmini-close-btn").on("click", function () {
		$(".cartmini__area").removeClass("cartmini-opened");
		$(".body-overlay").removeClass("opened");
	});



	////////////////////////////////////////////////////
	// 09.  Mobile Menu Js
	if($('.tp-main-menu-content').length && $('.tp-main-menu-mobile').length){
		let navContent = document.querySelector(".tp-main-menu-content").outerHTML;
		let mobileNavContainer = document.querySelector(".tp-main-menu-mobile");
		mobileNavContainer.innerHTML = navContent;
	
	
		let arrow = $(".tp-main-menu-mobile .has-dropdown > a");
	
		arrow.each(function () {
			let self = $(this);
			let arrowBtn = document.createElement("BUTTON");
			arrowBtn.classList.add("dropdown-toggle-btn");
			arrowBtn.innerHTML = "<i class='fa-regular fa-angle-right'></i>";
	
			self.append(function () {
				return arrowBtn;
			});
	
			self.find("button").on("click", function (e) {
				e.preventDefault();
				let self = $(this);
				self.toggleClass("dropdown-opened");
				self.parent().toggleClass("expanded");
				self.parent().parent().addClass("dropdown-opened").siblings().removeClass("dropdown-opened");
				self.parent().parent().children(".tp-submenu").slideToggle();
			});
			});
	}


	////////////////////////////////////////////////////
	// 10. Sticky Header Js
	windowOn.on('scroll', function () {
		var scroll = $(window).scrollTop();
		if (scroll < 200) {
			$("#header-sticky").removeClass("header-sticky");
		} else {
			$("#header-sticky").addClass("header-sticky");
		}
	});


	////////////////////////////////////////////////////
	// 11. Data CSS Js
	$("[data-background").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
	});

	$("[data-width]").each(function () {
		$(this).css("width", $(this).attr("data-width"));
	});

	$("[data-bg-color]").each(function () {
		$(this).css("background-color", $(this).attr("data-bg-color"));
	});



	// settings open btn
	$(".tp-theme-settings-open-btn").on("click", function () {
		$(".tp-theme-settings-area").toggleClass("settings-opened");
	});

	// rtl settings
	function tp_rtl_settings() {

		$('#tp-dir-toggler').on("change", function () {
			toggle_rtl();

		});


		// set toggle theme scheme
		function tp_set_scheme(tp_dir) {
			localStorage.setItem('tp_dir', tp_dir);
			document.documentElement.setAttribute("dir", tp_dir);

			if (tp_dir === 'rtl') {
				var list = $("[href='assets/css/bootstrap.css']");
				$(list).attr("href", "assets/css/bootstrap-rtl.css");
			} else {
				var list = $("[href='assets/css/bootstrap.css']");
				$(list).attr("href", "assets/css/bootstrap.css");
			}
		}

		// toogle theme scheme
		function toggle_rtl() {
			if (localStorage.getItem('tp_dir') === 'rtl') {
				tp_set_scheme('ltr');
				var list = $("[href='assets/css/bootstrap-rtl.css']");
				$(list).attr("href", "assets/css/bootstrap.css");
			} else {
				tp_set_scheme('rtl');
				var list = $("[href='assets/css/bootstrap.css']");
				$(list).attr("href", "assets/css/bootstrap-rtl.css");
			}
		}

		// set the first theme scheme
		function tp_init_dir() {
			if (localStorage.getItem('tp_dir') === 'rtl') {
				tp_set_scheme('rtl');
				var list = $("[href='assets/css/bootstrap.css']");
				$(list).attr("href", "assets/css/bootstrap-rtl.css");
				document.getElementById('tp-dir-toggler').checked = true;
			} else {
				tp_set_scheme('ltr');
				document.getElementById('tp-dir-toggler').checked = false;
				var list = $("[href='assets/css/bootstrap.css']");
				$(list).attr("href", "assets/css/bootstrap.css");
			}
		}
		tp_init_dir();
	}
	if ($("#tp-dir-toggler").length > 0) {
		tp_rtl_settings();
	}

	// dark light mode toggler
	function tp_theme_toggler() {

		$('#tp-theme-toggler').on("change", function () {
			toggleTheme();

		});


		// set toggle theme scheme
		function tp_set_scheme(tp_theme) {
			localStorage.setItem('tp_theme_scheme', tp_theme);
			document.documentElement.setAttribute("tp-theme", tp_theme);
		}

		// toogle theme scheme
		function toggleTheme() {
			if (localStorage.getItem('tp_theme_scheme') === 'tp-theme-dark') {
				tp_set_scheme('tp-theme-light');
			} else {
				tp_set_scheme('tp-theme-dark');
			}
		}

		// set the first theme scheme
		function tp_init_theme() {
			if (localStorage.getItem('tp_theme_scheme') === 'tp-theme-dark') {
				tp_set_scheme('tp-theme-dark');
				document.getElementById('tp-theme-toggler').checked = true;
			} else {
				tp_set_scheme('tp-theme-light');
				document.getElementById('tp-theme-toggler').checked = false;
			}
		}
		tp_init_theme();
	}
	if ($("#tp-theme-toggler").length > 0) {
		tp_theme_toggler();
	}


	// color settings
	function tp_color_settings() {

		// set color scheme
		function tp_set_color(tp_color_scheme) {
			localStorage.setItem('tp_color_scheme', tp_color_scheme);
			document.querySelector(':root').style.setProperty('--tp-theme-1', tp_color_scheme);
			document.getElementById("tp-color-setings-input").value = tp_color_scheme;
			document.getElementById("tp-theme-color-label").style.backgroundColor = tp_color_scheme;
		}

		// set color
		function tp_set_input() {
			var color = localStorage.getItem('tp_color_scheme');
			document.getElementById("tp-color-setings-input").value = color;
			document.getElementById("tp-theme-color-label").style.backgroundColor = color;


		}
		tp_set_input();

		function tp_init_color() {
			var defaultColor = $(".tp-color-settings-btn").attr('data-color-default');
			var setColor = localStorage.getItem('tp_color_scheme');

			if (setColor != null) {

			} else {
				setColor = defaultColor;
			}

			if (defaultColor !== setColor) {
				document.querySelector(':root').style.setProperty('--tp-theme-1', setColor);
				document.getElementById("tp-color-setings-input").value = setColor;
				document.getElementById("tp-theme-color-label").style.backgroundColor = setColor;
				tp_set_color(setColor);
			} else {
				document.querySelector(':root').style.setProperty('--tp-theme-1', defaultColor);
				document.getElementById("tp-color-setings-input").value = defaultColor;
				document.getElementById("tp-theme-color-label").style.backgroundColor = defaultColor;
				tp_set_color(defaultColor);
			}
		}
		tp_init_color();


		let themeButtons = document.querySelectorAll('.tp-color-settings-btn');

		themeButtons.forEach(color => {
			color.addEventListener('click', () => {
				let datacolor = color.getAttribute('data-color');
				document.querySelector(':root').style.setProperty('--tp-theme-1', datacolor);
				document.getElementById("tp-theme-color-label").style.backgroundColor = datacolor;
				tp_set_color(datacolor);
			});
		});



		const colorInput = document.querySelector('#tp-color-setings-input');
		const colorVariable = '--tp-theme-1';


		colorInput.addEventListener('change', function (e) {
			var clr = e.target.value;
			document.documentElement.style.setProperty(colorVariable, clr);
			tp_set_color(clr);
			tp_set_check(clr);
		});


		function tp_set_check(clr) {
			const arr = Array.from(document.querySelectorAll('[data-color]'));

			var a = localStorage.getItem('tp_color_scheme');

			let test = arr.map(color => {
				let datacolor = color.getAttribute('data-color');

				return datacolor;
			}).filter(color => color == a);

			var arrLength = test.length;

			if (arrLength == 0) {
				$('.tp-color-active').removeClass('active');
			} else {
				$('.tp-color-active').addClass('active');
			}
		}

		function tp_check_color() {
			var a = localStorage.getItem('tp_color_scheme');

			var list = $(`[data-color="${a}"]`);

			list.parent().addClass('active').parent().siblings().find('.tp-color-active').removeClass('active')
		}
		tp_check_color();

		$('.tp-color-active').on('click', function () {
			$(this).addClass('active').parent().siblings().find('.tp-color-active').removeClass('active');
		});

	}
	if (($(".tp-color-settings-btn").length > 0) && ($("#tp-color-setings-input").length > 0) && ($("#tp-theme-color-label").length > 0)) {
		tp_color_settings();
	}



	////////////////////////////////////////////////////
	// 13. Smooth Scroll Js
	function smoothSctoll() {
		$('.smooth a').on('click', function (event) {
			var target = $(this.getAttribute('href'));
			if (target.length) {
				event.preventDefault();
				$('html, body').stop().animate({
					scrollTop: target.offset().top - 120
				}, 1500);
			}
		});
	}
	smoothSctoll();

	function back_to_top() {
		var btn = $('#back_to_top');
		var btn_wrapper = $('.back-to-top-wrapper');

		windowOn.scroll(function () {
			if (windowOn.scrollTop() > 300) {
				btn_wrapper.addClass('back-to-top-btn-show');
			} else {
				btn_wrapper.removeClass('back-to-top-btn-show');
			}
		});

		btn.on('click', function (e) {
			e.preventDefault();
			$('html, body').animate({ scrollTop: 0 }, '300');
		});
	}
	back_to_top();





	// header-search
	$(".button-search-toggle").on("click", function () {
		$(".tp-search-area").slideToggle();
		$(this).toggleClass("tp-search-icon-active");
	});

	$("body > *:not(header)").on("click", function () {
		$(".tp-search-area").slideUp();
		$(".button-search-toggle").removeClass("tp-search-icon-active");
	});


	$("#filt-yearly").on("click", function () {
		$(".tp-price-toogle").removeClass("price-open");
	});
	$(".toggler-yearly.toggler--is-active").on("click", function () {
		$(".tp-price-toogle").removeClass("price-open");
	});
	$("#filt-monthly").on("click", function () {
		$(".tp-price-toogle").addClass("price-open");
	});


	/* Scroll Indicator Progress Bar */


	if ($('#scroll-indicator').length > 0) {
		const handleScrollIndicator = () => {
			const scrollIndicator = document.querySelector("#scroll-indicator");
			const maxHeight = document.body.scrollHeight - window.innerHeight;
	
			const widthPercentage = (window.scrollY / maxHeight) * 100;
			scrollIndicator.style.width = `${widthPercentage}%`;
		};
	
		window.addEventListener("scroll", handleScrollIndicator);
	};


	function seawave () {

		$.fn.wavify = function(options) {
			if ("function" !== typeof wavify) {
			  console.error(
				"wavify is not a function. Be sure to include 'wavify.js' before you include 'jquery.wavify.js'."
			  );
			  throw "Error: wavify is not a function";
			}
	
			return wavify(this, options);
		};
	
		$('#feel-the-wave').wavify({
			height: 150,
			bones: 7,
			amplitude: 70,
			color: 'rgba(255, 255, 255, 1)',
			speed: .21
		});
	
		$('#wave-two').wavify({
		height: 150,
		bones: 8,
		amplitude: 45,
		color: '#F7EFFD',
		speed: .24
		});
	}
	if ($('.wave-bg').length > 0) { 
		seawave();
	}




	////////////////////////////////////////////////////
	// 05. One Page Scroll Js
	if ($('.tp-onepage-menu li a').length > 0) { 
		function scrollNav() {
			$('.tp-onepage-menu li a').click(function () {
				$(".tp-onepage-menu li a.active").removeClass("active");
				$(this).addClass("active");
	
				$('html, body').stop().animate({
					scrollTop: $($(this).attr('href')).offset().top - 40
				}, 300);
				return false;
			});
		}
		scrollNav();
	}



})(jQuery);