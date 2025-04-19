<style>
	input, select {
    	background: none;
    	border :0 ;
    	 
    }
</style>
<div style="margin-top:30px;text-align: left;">
<?php 
	//set this variable in ur action
	//fields coming form location table for "footer" and  "header_image" for  header image 
	echo $this->Session->read('footer') ; 
	//echo $this->Session->read('discharge_text_footer') ; 
?>
</div>