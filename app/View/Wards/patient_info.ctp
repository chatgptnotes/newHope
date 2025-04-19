<?php echo $this->Html->css(array('home-slider.css','ibox.css')); ?>
 
<?php echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js')); ?>
 
 <style>
 #loginContainer {
    position:relative;
    float:right;
    font-size:12px;
    margin-top:40px;
    z-index:100;
}

/* Login Button */
#loginButton { 
    display:inline-block;
    float:right;
    background:#ffffff; 
    border:1px solid #cacaca; 
    border-radius:3px;
    -moz-border-radius:3px;
    position:relative;
    z-index:30;
    cursor:pointer;
}

/* Login Button Text */
#loginButton span {
    color:#0c8dc5; 
    font-size:14px; 
    font-weight:bold; 
    text-shadow:1px 1px #fff; 
    padding:7px 25px 9px 10px;
    background:url(../img/loginArrow.png) no-repeat 60px 9px;
    display:block
}

#loginButton:hover {
    background:#ffffff;
}

/* Login Box */
/*#loginBox {
    position:absolute;
    top:34px;
    right:0;
    display:none;
    z-index:29;
}*/

/* If the Login Button has been clicked */    
#loginButton.active {
    border-radius:3px 3px 0 0;
}

#loginButton.active span {
    background-position:60px -78px;
}

/* A Line added to overlap the border */
#loginButton.active em {
    position:absolute;
    width:100%;
    height:1px;
    background:#ffffff;
    bottom:-1px;
}

/* Login Form */
#loginForm {
    width:248px; 
    border:1px solid #cacaca;
    border-radius:3px 0 3px 3px;
    -moz-border-radius:3px 0 3px 3px;
    margin-top:-1px;
    background:#ffffff;
    padding:6px;
}

#loginForm fieldset {
    margin:0 0 12px 0;
    display:block;
    border:0;
    padding:0;
}

fieldset#body {
    background:#fff;
    border-radius:3px;
    -moz-border-radius:3px;
    padding:10px 13px;
    margin:0;
}

#loginForm #checkbox {
    width:auto;
    margin:1px 9px 0 0;
    float:left;
    padding:0;
    border:0;
    *margin:-3px 9px 0 0; /* IE7 Fix */
}

#body label {
    color:#3a454d;
    margin:9px 0 0 0;
    display:block;
    float:left;
}

#loginForm #body fieldset label {
    display:block;
    float:none;
    margin:0 0 6px 0;
}

/* Default Input */
#loginForm input {
    width:92%;
    border:1px solid #899caa;
    border-radius:3px;
    -moz-border-radius:3px;
    color:#3a454d;
    font-weight:bold;
    padding:8px 8px;
    box-shadow:inset 0px 1px 3px #bbb;
    -webkit-box-shadow:inset 0px 1px 3px #bbb;
    -moz-box-shadow:inset 0px 1px 3px #bbb;
    font-size:12px;
}

/* Sign In Button */
#loginForm #login {
    width:auto;
    float:left;
    background:#339cdf;
	background-image: -ms-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -moz-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -o-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #59ACEA), color-stop(1, #0197D8));
	background-image: -webkit-linear-gradient(top, #59ACEA 0%, #0197D8 100%);
	background-image: linear-gradient(top, #59ACEA 0%, #0197D8 100%);
    color:#fff;
	font-size:13px;
    padding:7px 10px 8px 10px;
    text-shadow:0px -1px #278db8;
    border:1px solid #339cdf;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
    box-shadow:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    margin:0 12px 0 0;
    cursor:pointer;
    *padding:7px 2px 8px 2px; /* IE7 Fix */
}

/* Forgot your password */
#loginForm span {
    text-align:center;
    display:block;
    padding:7px 0 4px 0;
}

#loginForm span a {
    color:#3a454d;
    text-shadow:1px 1px #fff;
    font-size:12px;
}

input:focus {
    outline:none;
}
#loginBox {
     display:none;
    position: absolute;
    right: 0;
    top: 34px;
    z-index: 29;
}
 </style>
	 
	<script>
	$(function() {
	    var button = $('#loginButton');
	    var box = $('#loginBox');
	    var form = $('#loginForm');
	    
	    button.removeAttr('href');
	    button.mouseup(function(login) {
	    	 
	    	/*if(box.css('height')=='0px'){
	    		box.css('height','248px');
	    	}else{
	    		box.css('height','0px');
	    		$("#loginForm").validationEngine('hide'); 
	    	}*/
	         box.toggle();
	    	
	        button.toggleClass('active');
	    });
	    form.mouseup(function() { 
	        return false;
	    });
	    $(this).mouseup(function(login) {
	        if(!($(login.target).parent('#loginButton').length > 0)) {
	            button.removeClass('active'); 
	            box.hide();
	           // box.css('height','0px');   
	           // $("#loginForm").validationEngine('hide');
	        }
	    });
	});
	</script>
	<div class="wrapper"> 
    <div class="header">
    	<div class="logo"><a href="#"><img src="img/logo.jpg" /></a></div>
        <!-- Login Starts Here -->
        <div id="loginContainer">
            <a href="#" id="loginButton"><span>Sign In</span><em></em></a>            
            <div style="clear:both"></div>
            <?php echo $this->Session->flash(); ?>
            <div id="loginBox">                
            	<!-- <form id="loginForm"> -->
            	<?php echo $this->Form->create('User', array('id'=>'loginForm','action' => 'login')); ?>
                	<div style="padding-left:12px;">Access your SaaS Business System.</div>
                    <fieldset id="body">
                        <fieldset>
                            <label for="email"><strong>Username</strong></label>
                            <?php  echo $this->Form->input('username',array('class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));?>
                        </fieldset>
                        <fieldset>
                            <label for="password"><strong>Password</strong></label>
                            <?php echo $this->Form->input('password',array('class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false)); ?>
                        </fieldset>
                        <input type="submit" id="login" value="Sign In" />
                        <div><a href="#" id="forgot" title="Forgot Password" >Forgot Password!</a></div>
                    </fieldset>
                    <?php echo $this->Form->end(); ?>
                 
            </div>
        </div>
        <!-- Login Ends Here -->
        
    </div><!-- .header end here -->
     
</div>
 
</body>
</html>