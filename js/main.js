
$( document ).ready(function() {;
    $('#all').addClass('active');

    $('#views li').click(function(){
       	$('#views li').removeClass('active');
    	$(this).addClass('active');

    	var viewValue = this.getAttribute('id');
		// $('.viewstage h4').text("view: " + viewValue);
		if(viewValue != "new")
			$('#viewstage h4').text("view: " + viewValue);
    	if(viewValue == "all"){
    		$('.thumbnail-item').removeClass("thumbnail-hide");
    		$('#outfits-gallery').addClass("thumbnail-hide");
    	}
    	else if(viewValue == "tops"){
    		$('.thumbnail-item').addClass("thumbnail-hide");
    		$('[type = "sweater"').parents().removeClass("thumbnail-hide");
    		$('[type = "shirt"').parents().removeClass("thumbnail-hide");
<<<<<<< HEAD
            $('[type = "jacket"]').parents().removeClass("thumbnail-hide");
            $('[type = "dress"]').parents().removeClass("thumbnail-hide");
    		$('.outfits-gallery').addClass("thumbnail-hide");
    	}else if(viewValue == "bottoms"){
			$('.thumbnail-item').addClass("thumbnail-hide");
			$('[type = "pants"').parents().removeClass("thumbnail-hide");
            $('[type = "dress"]').parents().removeClass("thumbnail-hide");
            $('[type = "skirt"]').parents().removeClass("thumbnail-hide");
			$('.outfits-gallery').addClass("thumbnail-hide");
=======
    		$('#outfits-gallery').addClass("thumbnail-hide");
    	}else if(viewValue == "bottoms"){
			$('.thumbnail-item').addClass("thumbnail-hide");
			$('[type = "pants"').parents().removeClass("thumbnail-hide");
			$('#outfits-gallery').addClass("thumbnail-hide");
>>>>>>> 6320732ac99e75db15d3ea57caf4c93e0177b16c
    	}else if(viewValue == "misc"){
    		$('.thumbnail-item').addClass("thumbnail-hide");
            $('[type = "shoes"]').parents().removeClass("thumbnail-hide");
    		$('[type = "socks"').parents().removeClass("thumbnail-hide");
<<<<<<< HEAD
            $('[type = "accessories"]').parents().removeClass("thumbnail-hide");
    		$('.outfits-gallery').addClass("thumbnail-hide");
=======
    		$('#outfits-gallery').addClass("thumbnail-hide");
>>>>>>> 6320732ac99e75db15d3ea57caf4c93e0177b16c
    	}else if(viewValue == "outfits"){
    		$('.thumbnail-item').addClass("thumbnail-hide");
    		$('#outfits-gallery').removeClass("thumbnail-hide");
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

    $('#delete-clothing-button').click(function(e){
		var result = confirm("Are you sure you wish to delete this item?");
		if(result){
			window.location = "deleteclothing.php?id=" + id;
		}
	});

    $('.delete-outfit-button').click(function(e){
        var result = confirm("Are you sure you wish to delete this outfit?");
        if(result){
            window.location  = "deleteoutfit.php?id=" + $(this).attr("outfitid");
        }
    });



    // addoutfit.php 

    var minitems = 2;
    for(var i  = 0; i < minitems; ++i) {
        $('[name = "item-group' + i + '"]').removeClass("item-hide");
    }

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
        $('[name = "item' + (numitems - 1) + '"]').val("");
        numitems--;

        if(numitems <= minitems){
            $('#delete-button').prop('disabled',true);
        }         
    });

    // planner
 
     $('.planner-item .thumbnail').click(function(){
        // $(this).toggleClass("active");
        $('#checkbox' + $(this).attr("id")).toggleClass("icon-check-empty");
        $('#checkbox' + $(this).attr("id")).toggleClass("icon-check");
    })

     $('[name = "radio-outfit"]').on('change', function(){
       
       if($(this).val() === "yes"){
            $('.collapsible').collapse('hide');
            $('#outfit-selection').prop('disabled', false);
        }else{
            
            $('.collapsible').collapse('show');
            $('#outfit-selection').prop('disabled', true);
        }
     })
     
    $('#today-button').click(function(){
        if($('[name = "radio-outfit"]:checked').val() === "yes"){
            if($('#outfit-selection').val() === null){
                $('#outfit-selection-error').text("Please select an outfit");
            }
            else{
                var outfitid = $('#outfit-selection').val();
                window.location.href = "planner.php?outfitselectionid=" + outfitid;
            }
        }else{
            var parts = "";
            var counter = 0;

            $('.icon-check').each(function(){
                counter++;
                parts += ($(this).attr("id")).substring(8) + " "; 
            })
            if(counter===0){
                $('#outfit-selection-error').text("Please select at least 1 article of clothing");
            }
            else if(counter > 10){
                $('#outfit-selection-error').text("Please only select up to 10 items at once");
            }
            else{
                window.location.href = "planner.php?outfitparts=" + parts + "&outfitnumparts=" + counter;
            }
        }
    })
    // addplan
     $('#addplan').click(function(){
                var date = $('[name = datechoice]').val();
                if(date === ""){
                    $('#outfit-selection-error').text("Date cannot be empty");
                }else{
                    if($('[name = "radio-outfit"]:checked').val() === "yes"){
                        if($('#outfit-selection').val() === null){
                            $('#outfit-selection-error').text("Please select an outfit");
                        }
                        else{
                            var outfitid = $('#outfit-selection').val();           
                            window.location.href = "addplan.php?outfitselectionid=" + outfitid +"&date=" + date;
                        }
                     }else{
                        var parts = "";
                        var counter = 0;

                        $('.icon-check').each(function(){
                            counter++;
                            parts += ($(this).attr("id")).substring(8) + " "; 
                        })
                        if(counter <2){
                            $('#outfit-selection-error').text("Please select at least 2 article of clothing");
                        }
                        else if(counter > 10){
                            $('#outfit-selection-error').text("Please only select up to 10 items at once");
                        }
                        else{
                            window.location.href = "planner.php?outfitparts=" + parts + "&outfitnumparts=" + counter;
                        }
                    }
                }
        })
    
});