$(function() {

	var menuBlock = $('.jsNavBarContainer');
	var menuButton =  $('.jsNavBarButton');
	var textDefault = menuButton.attr('data-text-default');
	var textActive = menuButton.attr('data-text-active');

	menuButton.click(function(e) {
	    e.preventDefault();
	    if ( !menuBlock.hasClass('showed') ){
    		menuBlock.addClass('showed');
    		menuButton.addClass('active');
    		menuButton.text(textActive);
	    }
	    else{
	    	menuBlock.removeClass('showed');
	    	menuButton.removeClass('active');
	    	menuButton.text(textDefault);
	    }
	});


});


$(function() {

	var filtersToggleButton =  $('.jsFiltersToggleButton');
	var filtersToggleBlock =  $('.jsFiltersToggleBlock');
	var textDefault = filtersToggleButton.attr('data-text-default');
	var textActive = filtersToggleButton.attr('data-text-active');

	filtersToggleButton.click(function(e) {
	    e.preventDefault();
	    if ( !filtersToggleBlock.hasClass('showed') ){
    		filtersToggleBlock.addClass('showed');
    		filtersToggleButton.addClass('active');
    		filtersToggleButton.text(textActive);
	    }
	    else{
	    	filtersToggleBlock.removeClass('showed');
	    	filtersToggleButton.removeClass('active');
	    	filtersToggleButton.text(textDefault);
	    }
	});



});

