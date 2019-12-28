(function() {
"use strict";
// -----------------------------
// Navbar fade
// -----------------------------

 $(window).scroll(function(){
      if ($(this).scrollTop() > 135) {
          $('#main-header').addClass('move');
      } else {
          $('#main-header').removeClass('move');
      }
  });





/*----------------------------
 jQuery MeanMenu
------------------------------ */
	jQuery('nav#mobile-menu').meanmenu();	
	
/*----------------------------
 wow js active
------------------------------ */
 new WOW().init();
 
 /*------------------------
Tooltip
-------------------------*/
	$('[data-toggle="tooltip"]').tooltip();

/*----------------------------
 owl active
------------------------------ */ 
  // Product List Carousel
  $(".product-list").owlCarousel({
      autoPlay: false,
      margin: 10, 
	  slideSpeed:2000,
	  pagination:false,
	  navigation:true,	  
      items : 4,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  navigationText:["<i class='arrow_carrot-left '></i>","<i class='arrow_carrot-right '></i>"],
      itemsDesktop : [1199,4],
	  itemsDesktopSmall : [980,3],
	  itemsTablet: [768,3],
	  itemsMobile : [479,1],
  });

  // Product List Carousel
  $(".related-products").owlCarousel({
      autoPlay: true,
      margin: 10, 
	  slideSpeed:500,
	  pagination:false,
	  navigation:true,	  
      items : 4,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  navigationText:["<i class='arrow_carrot-left'></i>","<i class='arrow_carrot-right'></i>"],
      itemsDesktop : [1199,4],
	  itemsDesktopSmall : [980,3],
	  itemsTablet: [768,2],
	  itemsMobile : [479,1],
  });

  // Latest News Carousel
  $(".latest-news-list").owlCarousel({
      autoPlay: false,
      margin: 10, 
	  slideSpeed:2000,
	  pagination:false,
	  navigation:true,	  
      items : 3,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  navigationText:["<i class='arrow_carrot-left '></i>","<i class='arrow_carrot-right '></i>"],
      itemsDesktop : [1199,3],
	  itemsDesktopSmall : [980,3],
	  itemsTablet: [768,3],
	  itemsMobile : [479,1],
  });
  
  // Brands Logos Crousel
  $(".brand-logos-carousel").owlCarousel({
      autoPlay: true,
      margin: 10, 
	  slideSpeed:500,
	  pagination:false,
	  navigation:false,	  
      items : 6,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  navigationText:["<i class='arrow_carrot-left '></i>","<i class='arrow_carrot-right '></i>"],
      itemsDesktop : [1199,6],
	  itemsDesktopSmall : [980,4],
	  itemsTablet: [768,4],
	  itemsMobile : [479,2],
  });

  // Sidebar News Post Carousel
  $(".sidebar-news-post-container").owlCarousel({
      autoPlay: true,
      margin: 10, 
	  slideSpeed:300,
	  pagination:false,
	  navigation:true,	  
      items : 1,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  navigationText:["<i class='arrow_carrot-left '></i>","<i class='arrow_carrot-right '></i>"],
      itemsDesktop : [1199,1],
	  itemsDesktopSmall : [980,1],
	  itemsTablet: [768,1],
	  itemsMobile : [479,1],
  });

  // Sidebar Best Seller Carousel
  $(".best-seller-columns").owlCarousel({
      autoPlay: true,
      margin: 10, 
	  slideSpeed:500,
	  pagination:false,
	  navigation:true,	  
      items : 1,
	  /* transitionStyle : "fade", */    /* [This code for animation ] */
	  navigationText:["<i class='arrow_carrot-left '></i>","<i class='arrow_carrot-right '></i>"],
      itemsDesktop : [1199,1],
	  itemsDesktopSmall : [980,1],
	  itemsTablet: [768,1],
	  itemsMobile : [479,1],
  });

/*----------------------------
 price-slider active
------------------------------ */  
	  $( "#slider-range" ).slider({
	   range: true,
	   min: 40,
	   max: 600,
	   values: [ 90, 530 ],
	   slide: function( event, ui ) {
		$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
	   }
	  });
	  $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
	   " - $" + $( "#slider-range" ).slider( "values", 1 ) );  
	   
/*--------------------------
 scrollUp
---------------------------- */	
	$.scrollUp({
        scrollText: '<i class="arrow_carrot-2up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    }); 	   
	   	   
/*------------------------
Category Menu
-------------------------*/


	$('#category-menu li.active').addClass('open').children('ul').show();
	$('#category-menu li.has-sub>a').on('click', function(){
		$(this).removeAttr('href');
		var element = $(this).parent('li');
		if (element.hasClass('open')) {
			element.removeClass('open');
			element.find('li').removeClass('open');
			element.find('ul').slideUp(500);
		}
		else {
			element.addClass('open');
			element.children('ul').slideDown(500);
			element.siblings('li').children('ul').slideUp(500);
			element.siblings('li').removeClass('open');
			element.siblings('li').find('li').removeClass('open');
			element.siblings('li').find('ul').slideUp(500);
		}
	});

/*------------------------
Cart Plus Minus Button
-------------------------*/
$(".cart-plus-minus").append('<div class="dec qtybutton">-</div><div class="inc qtybutton">+</div>');
$(".qtybutton").on("click", function () {
    var $button = $(this);
    var oldValue = $button.parent().find("input").val();
    if ($button.text() == "+") {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        // Don't allow decrementing below zero
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }
    $button.parent().find("input").val(newVal);
});




})();

 //Slider Main
  jQuery('.fullscreenbanner').revolution({
			delay:15000,
			startwidth:1170,
			startheight:400,
			hideThumbs:10,
			fullWidth:"off",
			fullScreen:"on",
			shadow:0,
			dottedOverlay:"none",
			fullScreenOffsetContainer: ""      
	 });



