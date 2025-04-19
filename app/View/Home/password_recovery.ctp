<?php 
		echo $this->Html->css(array('style','validationEngine.jquery.css'));
		echo $this->Html->script(array('jquery.min.js?ver=3.3','validationEngine.jquery',
	     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
?>
<style>
	#loginForm{
		 
	    margin: auto; 
	    width: 300px;
	}
	#passContainer{
		font-size: 12px;
		margin-top:40px;
	}
	#passBox{
		text-align:center;
	}
	 
</style>

 <!--[if IE]>
 <style>
 	 #loginForm input{
 	 	height:30px; 
 	 	line-height:30px;
 	 	
 	 } 
 	 #loginForm #login{
 	 height:auto;
 	 	line-height:normal;
 	 }
 </style>
 <![endif]-->
&nbsp;
<!-- Login Starts Here -->
        <div id="passContainer">  
            <?php echo $this->Session->flash(); ?>
            <div id="passBox">                
            <!-- <form id="loginForm"> -->
            <?php echo $this->Form->create('Home', array('id'=>'loginForm','url'=>array('controller'=>'home','action' => 'password_recovery'),'style'=>'padding:10px;width:350px;margin:0 auto;text-align:left;')); ?>
                <div style="padding-left:12px;padding-bottom:15px;text-align:center;"><strong>Please enter your Username and Email</strong></div>
                 
                        <fieldset>
                            <label for="email"><strong>Username</strong></label>
                            <?php  echo $this->Form->input('username',array('class' => 'validate[required,custom[mandatory-enter]]','div'=>false,'label'=>false));?>
                        </fieldset>
                        <fieldset>
                            <label for="password"><strong>Email</strong></label>
                            <?php echo $this->Form->input('email',array('class' => 'validate[required,custom[email]]','div'=>false,'label'=>false)); ?>
                        </fieldset>
                        <input type="submit" id="login" value="Submit" />
                         
                     <div style="clear:both"></div>
                    <?php echo $this->Form->end(); ?> 
                    
            </div>
        </div>
<!-- Login Ends Here -->
<script>
		$(document).ready(function(){
			// binds form submission and fields to the validation engine
		 	$("#loginForm").validationEngine();
			 
		});
</script>