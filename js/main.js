$( document ).ready(function() {
    $('#all').addClass('active');

    $('#views a').click(function(){
       	$('#views a').removeClass('active');
    	$(this).addClass('active');

    	var viewValue = this.getAttribute('id');
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

  //   	if(viewValue != 'new'){
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
    	var color = $(this).attr('color');
    	var timesworn = $(this).attr('timesworn');
    	var lastworn = $(this).attr('lastworn'); 
    	var type = $(this).attr('type');

    	$('.modal-title').text(name);

    	$('.modal-body .img-responsive').attr('src',url);
    });


});