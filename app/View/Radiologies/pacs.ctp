<?php 	  
	
	 echo $this->Html->css(array('internal_style.css'));  
	  
	
  	 
  	 
?>

<div class="inner_title">
 <h3>
 <?php echo __('Pacs');?>

 
 </h3>
</div>
	<?php //debug($_SESSION);
		$pieces = parse_url(Router::url('/', true));
	  	$parentApp['authenticatedHost']=$authenticatedHost=$pieces['host'];
	 	$parentApp['authenticatedDatabase']=$authenticatedDatabase="dicom";
	 	$fullname=$this->Session->read('first_name')." ".$this->Session->read('last_name');
	 	$parentApp['fullname']=$fullname;
	 	$parentApp['lastActivity']=$lastActivity=1452066863;
	 	$parentApp['lastSort']=$lastSort='cmp_received_opt';
	 	$parentApp['sortToggle']=$sortToggle=0;
	 	/*if($this->Session->read('role')=='Admin'){
	 		$parentApp['authenticatedUser']=$authenticatedUser='root';
	 		$parentApp['authenticatedPassword']=$authenticatedPassword='';
	 	}else{*/
	 		$parentApp['authenticatedUser']=$authenticatedUser=$this->Session->read('username');
	 		$parentApp['authenticatedPassword']=$authenticatedPassword='Hope123@!';
	 	//}
 	?>
    <!--  <table width="100%" align="center">
	     <tr>
	     	<td align="center">
	     		<input id ='authenticatedHost' value="<?php echo $authenticatedHost?>"></input>
	     		<input id ='authenticatedDatabase' value="<?php echo $authenticatedDatabase?>"></input>
	     		<input id ='authenticatedUser' value="<?php echo $authenticatedUser?>"></input>
	     		<input id ='authenticatedPassword' value="<?php echo $authenticatedPassword?>"></input>
	     		<input id ='fullname' value="<?php echo $fullname?>"></input>
	     		<input id ='lastActivity' value="<?php echo $lastActivity?>"></input>
	     		<input id ='sortToggle' value="<?php echo $sortToggle?>"></input>
	     	</td>
	     </tr>
     </table> -->
	<!-- BOF new HTML -->	 
	 	 	 
			 <table width="100%" align="center">
			
			<tr><td align="center"><iframe name="aframe" id="aframe" frameborder="0" onload="load();" src="http://<?php echo $_SERVER['HTTP_HOST']?>/PacsOne/php/login.php"></iframe></td></tr>
			   
			  </table>	  
		 
		
	<!-- EOF new HTML -->


<script>
			function load() 
		    {
		         document.getElementById("aframe").style.height = "900px";
		         document.getElementById("aframe").style.width = "1500px";
		         //jQuery(".loader").hide();
	        }
			function submit_form()
			{
				alert('2');
				jQuery(".loader").show();
			  document.getElementById("aframe").style.height = "0px";
			  document.getElementById("aframe").style.width = "0px";
			  //document.getElementById('UserRxForm').submit();
			}


</script>