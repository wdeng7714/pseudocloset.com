
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

  	 // if(viewValue != 'new'){
	 // 	$.post( 
	 //        	"viewcloset.php",{view: viewValue},
	 //            function(data) {
	 //            	$('#viewstage').empty().html(data);
	 //            }
	 //        );
	 // }
    });

    $('.thumbnail').click(function(){
    	// $('.modal-body').empty();
    	var name = $(this).attr('name');
    	var url = $(this).attr('url');
    	var color = "#" + $(this).attr('color');
    	var timesworn = $(this).attr('timesworn');
    	var lastworn = $(this).attr('lastworn'); 
    	var type = $(this).attr('type');

    	$('.modal-title').text(name);
    	$('.item-color p').css('background-color', color);
    	$('.modal-body .item-img').attr('src',url);
    	$('.item-lastworn p').text(lastworn);
    	$('.item-timesworn p').text(timesworn);
    });



    // addoutfit.php 
    $('.outfit-item').addClass('item-hide');
    var minitems = 2;
    var numitems = minitems;
    for(var i  = 0; i < numitems; ++i) {
        $('[name = "item-group' + i + '"]').removeClass("item-hide");
    }


    $('#delete-button').prop('disabled', true);

    $('#add-button').click(function(e){
        e.preventDefault();
        numitems++;
        $('#delete-button').prop('disabled',false);
        $('[name = "item-group' + (numitems - 1) + '"]').removeClass("item-hide");
        if(numitems >= maxitems){
            $("#max-error").text("Sorry you have reached the limit");
            $('#add-button').prop('disabled',true);
        }

    });

    $('#delete-button').click(function(e){
        e.preventDefault();
        $('#add-button').prop('disabled',false);
        $("#max-error").text("");
        $('[name = "item-group' + (numitems - 1) + '"]').addClass("item-hide");
        numitems--;

        if(numitems <= minitems){
            $('#delete-button').prop('disabled',true);
        }         
    });


});