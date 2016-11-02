$( document ).ready(function() {
    $('#all').addClass('active');

    $('#views a').click(function(){
       	$('#views a').removeClass('active');
    	$(this).addClass('active');

    	var viewValue = this.getAttribute('id');
    	if(viewValue != 'new'){
			$.post( 
	        	"viewcloset.php",{view: viewValue},
	            function(data) {
	            	$('#viewstage').empty().html(data);
	            }
	        );
		}
    });

});