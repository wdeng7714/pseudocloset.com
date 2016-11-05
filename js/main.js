$( document ).ready(function() {
    $('#all').addClass('active');

    $('#views a').click(function(){
       	$('#views a').removeClass('active');
    	$(this).addClass('active');

    	var viewValue = this.getAttribute('id');
		// $('.viewstage h4').text("view: " + viewValue);
		if(viewValue != "new")
			$('#viewstage h4').text("view: " + viewValue);
    	if(viewValue == "all"){
    		$('.thumbnail-item').removeClass("thumbnail-hide");
    	}
    	else if(viewValue == "tops"){
    		$('.thumbnail-item').addClass("thumbnail-hide");
    		$('[type = "sweater"').parents().removeClass("thumbnail-hide");
    		$('[type = "shirt"').parents().removeClass("thumbnail-hide");
    	}else if(viewValue == "bottoms"){
			$('.thumbnail-item').addClass("thumbnail-hide");
			$('[type = "pants"').parents().removeClass("thumbnail-hide");
    	}else if(viewValue == "misc"){
    		$('.thumbnail-item').addClass("thumbnail-hide");
    		$('[type = "socks"').parents().removeClass("thumbnail-hide");
    	}else if(viewValue == "outfits"){
    		$('.thumbnail-item').addClass("thumbnail-hide");
    	}

    });


    // global variables
    var name;
    var url;
    var color;
    var timesworn;
    var lastworn;
    var type;
    var id;

    $('.thumbnail').click(function(){
    	// $('.modal-body').empty();
    	name = $(this).attr('name');
    	url = $(this).attr('url');
    	color = "#" + $(this).attr('color');
    	timesworn = $(this).attr('timesworn');
    	lastworn = $(this).attr('lastworn'); 
    	type = $(this).attr('type');
    	id = $(this).attr('id');

    	$('.modal-title').text(name);
    	$('.item-color p').css('background-color', color);
    	$('.modal-body .item-img').attr('src',url);
    	$('.item-lastworn p').text(lastworn);
    	$('.item-timesworn p').text(timesworn);

    	$('#edit-button').attr('href',"editclothing.php?clothingid=" + id);
    });


});