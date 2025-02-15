$(function () {

	"use strict";

	/* perfect scrol bar */

	new PerfectScrollbar('.header-message-list');

	new PerfectScrollbar('.header-notifications-list');

	// search bar

	$(".mobile-search-icon").on("click", function () {

		$(".search-bar").addClass("full-search-bar");

		$(".page-wrapper").addClass("search-overlay");

	});

	$(".search-close").on("click", function () {

		$(".search-bar").removeClass("full-search-bar");

		$(".page-wrapper").removeClass("search-overlay");

	});

	$(".mobile-toggle-menu").on("click", function () {

		$(".wrapper").addClass("toggled");

	});

	// toggle menu button

	$(".toggle-icon").click(function () {

		if ($(".wrapper").hasClass("toggled")) {
			// unpin sidebar when hovered
			$(".wrapper").removeClass("toggled");
			$(".sidebar-wrapper").unbind("hover");

			$(".toggle-icon i").removeClass('bx-last-page')
			$(".toggle-icon i").addClass('bx-first-page')
		} else {
			$(".wrapper").addClass("toggled");
			$(".wrapper").removeClass("sidebar-hovered");

			$(".toggle-icon i").removeClass('bx-first-page')
			$(".toggle-icon i").addClass('bx-last-page')
			
		}
	});


	$(".sidebar-wrapper").hover(function () {
		$(".wrapper").addClass("sidebar-hovered");
	}, function () {
		$(".wrapper").removeClass("sidebar-hovered");
	})

	/* Back To Top */

	$(".show_ligne_note").on("mouseover", function () {
		var id = $(this).attr("id")
		$("#ligne_note_"+id).show()
	})

	$(".show_ligne_note").on("mouseout", function () {
		$(".ligne_note").hide()
	})


	$(".show_detail_paid").on("mouseover", function () {
		var id = $(this).attr("id")
		$("#detail_paid_"+id).show()
	})

	$(".show_detail_paid").on("mouseout", function () {
		$(".detail_paid").hide()
	})

	$(document).ready(function () {

		
		  
		if(window.innerWidth <= 651) {	
			$(".responsive_button_text").css("display", "none")
		} else {
			$(".responsive_button_text").css("display", "block")
		}

		$( window ).resize(function() {
			if(window.innerWidth <= 651) {
				$(".responsive_button_text").css("display", "none")
			} else {
				$(".responsive_button_text").css("display", "block")
			}
		});

		$(window).on("scroll", function () {

			if ($(this).scrollTop() > 300) {

				$('.back-to-top').fadeIn();

			} else {

				$('.back-to-top').fadeOut();

			}

		});

		$('.back-to-top').on("click", function () {

			$("html, body").animate({

				scrollTop: 0

			}, 600);

			return false;

		});

	});

	// === sidebar menu activation js

	$(function () {

		for (var i = window.location, o = $(".metismenu li a").filter(function () {

			return this.href == i;

		}).addClass("").parent().addClass("mm-active");;) {

			if (!o.is("li")) break;

			o = o.parent("").addClass("mm-show").parent("").addClass("mm-active");

		}

	});

	// metismenu

	$(function () {

		$('#menu').metisMenu();

	});

	// chat toggle

	$(".chat-toggle-btn").on("click", function () {

		$(".chat-wrapper").toggleClass("chat-toggled");

	});

	$(".chat-toggle-btn-mobile").on("click", function () {

		$(".chat-wrapper").removeClass("chat-toggled");

	});

	// email toggle

	$(".email-toggle-btn").on("click", function () {

		$(".email-wrapper").toggleClass("email-toggled");

	});

	$(".email-toggle-btn-mobile").on("click", function () {

		$(".email-wrapper").removeClass("email-toggled");

	});

	// compose mail

	$(".compose-mail-btn").on("click", function () {

		$(".compose-mail-popup").show();

	});

	$(".compose-mail-close").on("click", function () {

		$(".compose-mail-popup").hide();

	});

	/*switcher*/

	$(".switcher-btn").on("click", function () {

		$(".switcher-wrapper").toggleClass("switcher-toggled");

	});

	$(".close-switcher").on("click", function () {

		$(".switcher-wrapper").removeClass("switcher-toggled");

	});

	$("#lightmode").on("click", function () {

		$('html').attr('class', 'light-theme');

	});

	$("#darkmode").on("click", function () {

		$('html').attr('class', 'dark-theme');

	});

	$("#semidark").on("click", function () {

		$('html').attr('class', 'semi-dark');

	});

	$("#minimaltheme").on("click", function () {

		$('html').attr('class', 'minimal-theme');

	});

	$("#headercolor1").on("click", function () {

		$("html").addClass("color-header headercolor1");

		$("html").removeClass("headercolor2 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8");

	});

	$("#headercolor2").on("click", function () {

		$("html").addClass("color-header headercolor2");

		$("html").removeClass("headercolor1 headercolor3 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8");

	});

	$("#headercolor3").on("click", function () {

		$("html").addClass("color-header headercolor3");

		$("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor8");

	});

	$("#headercolor4").on("click", function () {

		$("html").addClass("color-header headercolor4");

		$("html").removeClass("headercolor1 headercolor2 headercolor3 headercolor5 headercolor6 headercolor7 headercolor8");

	});

	$("#headercolor5").on("click", function () {

		$("html").addClass("color-header headercolor5");

		$("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor3 headercolor6 headercolor7 headercolor8");

	});

	$("#headercolor6").on("click", function () {

		$("html").addClass("color-header headercolor6");

		$("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor3 headercolor7 headercolor8");

	});

	$("#headercolor7").on("click", function () {

		$("html").addClass("color-header headercolor7");

		$("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor3 headercolor8");

	});

	$("#headercolor8").on("click", function () {

		$("html").addClass("color-header headercolor8");

		$("html").removeClass("headercolor1 headercolor2 headercolor4 headercolor5 headercolor6 headercolor7 headercolor3");

	});

	

	

	

   // sidebar colors 





    $('#sidebarcolor1').click(theme1);

    $('#sidebarcolor2').click(theme2);

    $('#sidebarcolor3').click(theme3);

    $('#sidebarcolor4').click(theme4);

    $('#sidebarcolor5').click(theme5);

    $('#sidebarcolor6').click(theme6);

    $('#sidebarcolor7').click(theme7);

    $('#sidebarcolor8').click(theme8);



    function theme1() {

      $('html').attr('class', 'color-sidebar sidebarcolor1');

    }



    function theme2() {

      $('html').attr('class', 'color-sidebar sidebarcolor2');

    }



    function theme3() {

      $('html').attr('class', 'color-sidebar sidebarcolor3');

    }



    function theme4() {

      $('html').attr('class', 'color-sidebar sidebarcolor4');

    }

	

	function theme5() {

      $('html').attr('class', 'color-sidebar sidebarcolor5');

    }

	

	function theme6() {

      $('html').attr('class', 'color-sidebar sidebarcolor6');

    }



    function theme7() {

      $('html').attr('class', 'color-sidebar sidebarcolor7');

    }



    function theme8() {

      $('html').attr('class', 'color-sidebar sidebarcolor8');

    }
});


// Paiement User

$(".paiement_type").on('click', function(){
	type = $(this).attr('id')
	$("#modalPaiementUser").modal('show')
	$("#paiement_selected").val(type)
	$(".paiement_type_selected").remove()
	$(".modal-body").append("<span style='font-size:16px' class='paiement_type_selected'>Êtes-vous sûr de choisir <strong>"+$("#"+type).text()+"</strong> comme choix de paiement ?</span>")
})




$( document ).ready(function() {
	
	if($.fn.dataTable){
		$.extend(true, $.fn.dataTable.defaults, {
			"showNEntries" : false,
			"language": {
				"search": "",
				"searchPlaceholder": "Rechercher...",
				"lengthMenu": "_MENU_",
				"paginate": {
					"previous": "<i class='fadeIn animated bx bx-chevron-left'></i>",
					"next": "<i class='fadeIn animated bx bx-chevron-right'></i>"
				  }
			},
			"oLanguage": {
				"sInfo" : "Affichage des entrées de _START_ à _END_ sur un total de _TOTAL_ ",
			 },
		});
	}

});
