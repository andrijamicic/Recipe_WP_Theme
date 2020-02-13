/*
	Andrija Mićić WORDPRESS TEMPLATED
	andrijamicic@gmail.com
	Released for free under the Creative Commons Attribution 2.0 license
*/

(function($) {	
	
	    $(document).ready(function() {

		var	$body 		= $('body');
        /////////////////////////////////////////////
	    // Slide cart icon
	    /////////////////////////////////////////////
	    $( 'a[href="#slide-cart"]' ).SideMenu({
		    panel: '#slide-cart',
		    close: '#cart-icon-close'
	    });
		
		// Menu.
			$('#menu')
				.append('<a href="#menu" class="close"></a>')
				.appendTo($body)
				.panel({
					delay: 500,
					hideOnClick: true,
					hideOnSwipe: true,
					resetScroll: true,
					resetForms: true,
					hideOnEscape: true,
					side: 'right'
			});		
	    });		
	   
	    $(function () {
            $(".sub-menu").hide();
	        $(".menu-item.menu-item-has-children  > a, #menu li.page_item_has_children > a").after(
			 "<span class='child-arrow'></span>"
		    );
            $(".child-arrow").click(function (e) {
                if (!$(e.target).closest("ul").is(".sub-menu")) {
					$(this).siblings(".sub-menu").toggle();
					$(this).toggleClass('toggle-on');
			        return true;
                }
            });
	        $(".sub-menu .child-arrow").click(function (e) {
                $(this).siblings(".sub-menu").toggle();
			//	$(".sub-menu .sub-menu .child-arrow").toggle().css('margin-left', '-=10px');
				$(this).toggleClass('toggle-on');
			    return true;
            });
        });
})(jQuery);
