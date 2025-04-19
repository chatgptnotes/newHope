// Login Form

$(function() {
    var button = $('#loginButton');
    var box = $('#loginBox');
    var form = $('#loginForm');
    
    button.removeAttr('href');
    button.mouseup(function(login) {
    	 
    	if(box.css('height')=='0px'){
    		box.css('height','248px');
    	}else{
    		box.css('height','0px');
    		$("#loginForm").validationEngine('hide'); 
    	}
        // box.toggle();
    	
        button.toggleClass('active');
    });
    form.mouseup(function() { 
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active'); 
            box.css('height','0px');   
            $("#loginForm").validationEngine('hide');
        }
    });
});
