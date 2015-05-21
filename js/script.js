jQuery(document).ready(function(){
	//Get Form by #ID
	var form = jQuery('#ajax-contact');
	
	
	//Messages DIV
	var formMessages = jQuery('#form-messages');
	
	//From Event Handler
	jQuery(form).submit(function(event){
		//Stop browser from submiting form directly to mailer.php
		event.preventDefault();
		console.log('Contact Form Submited');
		
		//Serialzie data
		var formData = jQuery(form).serialize();
		console.log(formData);
		//Submit With Ajax
		jQuery.ajax({
			type: 'POST',
			url: jQuery(form).attr('action'),
			data: formData
		}).done(function(response){
			//Make sure message is success
			jQuery(formMessages).removeClass('error');
			jQuery(formMessages).addClass('success');
			
			//Set Message Text
			jQuery(formMessages).text(response);
			
			//Clear Form Fields
			jQuery('#name').val('');
			jQuery('#email').val('');
			jQuery('#message').val('');
		}).fail(function(data){
			//Make sure message is error
			jQuery(formMessages).removeClass('success');
			jQuery(formMessages).addClass('error');
			
			//Set Message Text
			if(data.responseText !== ''){
				jQuery(formMessages).text(data.responseText);
			}else{
				jQuery(formMessages).text('An error occured');
			}
		});
	});
	
});
