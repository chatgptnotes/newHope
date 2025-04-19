 <style>
th,td {
padding-bottom:10px;
padding-top:10px;
padding-left:10px;
text-align:center;
}
.row_action img{float:inherit;}
h3{
text-align:left;
}
</style>

<div class="inner_title" >
<h3><?php echo __('Permission Management - User', true); ?></h3>
<span>
<?php  

				if(isset($screen)){
					$url = $this->Html->url(array("action" => "package_first_level","admin" => true,$packageid,"plugin"=>false));
					if($emer && $emer == 'emer'){
					echo $this->Html->link(__('Back', true),array('controller'=>'AuditLogs','action' => 'emergency_access',$aro_id, "admin"=>true), array('escape' => false,'class'=>'blueBtn'));
					
					}else{
						echo $this->Html->link(__('Back', true),array('action' => 'package_permission',$aro['Aro']['id'], "admin"=>true), array('escape' => false,'class'=>'blueBtn'));
					}
					$model = "Aro";
					$screen = "true";
				}else{
					$url = $this->Html->url(array("action" =>"user_permission","admin" => true,"plugin"=>false));
					if($emer && $emer == 'emer'){
						echo $this->Html->link(__('Back', true),array('controller'=>'AuditLogs','action' => 'emergency_access',$aro_id, "admin"=>true), array('escape' => false,'class'=>'blueBtn'));
							
					}else{
						echo $this->Html->link(__('Back', true),array('action' => 'index', "admin"=>true), array('escape' => false,'class'=>'blueBtn'));
					}
					$model = "User";
					$screen = "false";
					$packageid='false';
				}

			?>

</span>
</div>

  <div class="clr ht5"></div>
    <div class="clr ht5"></div>

	  <table  cellpadding="0" cellspacing="0" border="0">
	   <td> <?php // echo __("Select Mode");
	  	//$hospitalModes = Configure::read('hospital_mode');
	  	//$selectedMode = $this->Session->read('hospital_permission_mode');
	  	//if(empty($selectedMode)){
	  		$selectedMode = Configure::read('hospital_default_mode');
	  	//}
	  	?></td>
		<td><?php 
		if($selectedMode == 'Hospital'){
			$hospitalSelected = 'checked="checked"';
		}
		if($selectedMode == 'Clinic'){
			$clinicSelected = 'checked="checked"';
		}
		//echo $hospitalModes['Clinic'];
		 ?>
		
		<input <?php echo $clinicSelected;?> type="hidden" name="hospital_mode" value="<?php echo $selectedMode;?>"></td>
		<!--<td><?php //echo $hospitalModes['Hospital'];?>
		 <input <?php //echo $hospitalSelected;?> type="radio" name="hospital_mode" value="<?php //echo $hospitalModes['Hospital'];?>"></td>	  -->  
	  </tr>
         <tr>
		 	<td>Select User:</td>
			<td>

				<select name="aro" id="aro" onchange="getModules()">
				<option value="">Select User</option>
				<?php
				foreach($users as $key => $value){
				?>
				<option value="<?php echo $value[$model]['id'];?>" <?php if(isset($user) && $user[$model]['id']==$value[$model]['id']){ echo " selected=selected";}?>><?php echo $value['User']['first_name']." ".$value['User']['last_name'];?> (<?php echo $value['Role']['name'];?>)</option>
				<?php
					}
				?>
				</select>
			</td>
		 </tr>
		 </table>
		 <?php
		 	if(isset($modules)){
		 ?>
		 <table>
			<tr>
				<td><?php echo $this->Html->image("/img/cross.png"); ?> Permission Denied! Click to grant permission</td>
				 <td>	<?php echo $this->Html->image("/img/tick.png");?> Permission Granted! Click to deny permission</td>
				 <td>	<?php echo $this->Html->image("/img/warning_small.png");?>Permission Granted but not fully! Click to grant permission</td>
        	</tr>
        </table>
		 <div class="clr ht5"></div>
		 <div class="clr ht5"></div>
		 <div class="clr ht5"></div>

		 	  <table width="100%" cellpadding="0" cellspacing="0" border="0" id='acoGrid'>
         <tr  class="row_title">
			   <td style="text-align:left;" width="150">
			  		<strong>Module name</strong>
			   </td>
			  <td align="left">
			  	<strong>Description</strong>
			   </td>
			  <td align="left">
			  	<strong>Permission</strong>
			   </td>
		     </tr>
		 	<?php
				$cnt =0;
				foreach($modules as $key => $value){
				$cnt++;
				?>
			 <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			   <td style="text-align:left;cursor:pointer;width:20%;" class="screen" onclick="window.location.href='<?php echo $this->Html->url(array("action" => "screen_permission","admin" => true,$value['Aco']['id'],$user['Aro']['id'],$user['Role']['id'],$screen,$packageid,"plugin"=>false)); ?>'" width="150">
			   <?php echo $value['Aco']['alias'];?>
			   </td>
			    <td align="left" style="width:60%;">
			   		<div style="border-bottom:1px solid;text-align:left;width:95%;float:left;" class="permissionDesc" id="<?php echo "desc_".$cnt?>" aco="<?php echo $value['Aco']['id'];?>" contenteditable="true">&nbsp;
			   			<?php  echo $value['Aco']['desc']; ?>
			   		</div>
			   		<img class="loading_placeholder" id="<?php echo "loader_".$cnt?>" style="float:left;"/>
			   </td> 
			   <td class="row_action" align="left" style="width:60%;">
			    <?php
					 if($permission_on_module[$value['Aco']['id']] == "deny")
						echo $this->Html->image("/img/cross.png",array("class"=>"acsess" ,'aco' =>$value['Aco']['id'],"aro"=>$user['Aro']['id']));
					else if($permission_on_module[$value['Aco']['id']] == "full")
						echo $this->Html->image("/img/tick.png",array("class"=>"deny",'aco' =>$value['Aco']['id'],"aro"=>$user['Aro']['id']));
					else
						echo $this->Html->image("/img/warning_small.png",array("class"=>"acsess" ,'aco' =>$value['Aco']['id'],"aro"=>$user['Aro']['id']));
				?>
			   </td>

		     </tr>
		   <?php
					}
				?>
		 </table>
		 <div id="pageNavPosition" align="center"></div>

		 <?php
		 } ?>





 <script>
 var x;
 var y;
 $(document).mousemove(function(e) {
    x = e.pageX;
     y = e.pageY;
});

		var pager = new Pager('acoGrid', 15);
        pager.init();
        pager.showPageNav('pager', 'pageNavPosition');
        pager.showPage(1);
		 $(".acsess").live("click",function(){
		 	 var obj = $(this);
		 	 obj.attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		   $.ajax({
			  type: "POST",
			  url: "<?php echo $this->Html->url(array("action" => "assign_permission","admin" => true,"plugin"=>false)); ?>",
			  data: "aco="+obj.attr("aco")+"&aro="+obj.attr("aro"),
			 }).done(function( msg ) {
			    obj.attr("src",'<?php echo $this->Html->url("/img/tick.png");?>');
				obj.attr("class",'deny');
			 });
		 });
		  $(".deny").live("click",function(){
		   	 var obj = $(this);
		 	 obj.attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 	  $.ajax({
			  type: "POST",
			  url: "<?php echo $this->Html->url(array("action" => "deny_permission","admin" => true,"plugin"=>false)); ?>",
			  data: "aco="+obj.attr("aco")+"&aro="+obj.attr("aro"),
			 }).done(function( msg ) {
				  obj.attr("src",'<?php echo $this->Html->url("/img/cross.png");?>');
				   obj.attr("class",'acsess');
			 });
		 })
		 $(".screen").mouseover(function() {
		  	if($("#screenMessage")){
			$(this).append('<div id="screenMessage">Click to see permission on Individual <br> screen of '+$(this).html()+'</div>');
			$("#screenMessage").css("position", "absolute");
			$("#screenMessage").css("top", y);
			$("#screenMessage").css("left", x);
			$("#screenMessage").css("background-color", "#000");
			$("#screenMessage").css("border", "1px solid #4C5E64");
			$("#screenMessage").css("color", "#fff");
			}
    	});
		 $(".screen").mouseout(function() {
		  	if($("#screenMessage")){
			$("#screenMessage").remove();
			}
    	});

		function getModules(){
		    	var hospiitalMode = $('input[name=hospital_mode]:checked').val();
		    	window.location.href='<?php echo $url; ?>/'+$("#aro").val() + '/<?php echo $screen;?>/<?php echo $packageid;?>/' + hospiitalMode 
	    }	

		 
		 $(".permissionDesc").live('blur',function(){
			  id = $(this).attr('id') ;
			  splitted = id.split("_") ;
			  var obj = $("#loader_"+splitted[1]);
		 	  obj.attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 	  data = $(this).html() ;
		 	  data = data.trim();
			  data = data.replace(/(\r\n|\n|\r|\t|&nbsp;)/gm,""); 
				
		 	  $.ajax({
				  type: "POST",
				  url: "<?php echo $this->Html->url(array("action" => "add_acos_description","admin" => true,"plugin"=>false)); ?>",
				  data: "aco="+$(this).attr("aco")+"&desc="+data,
			  }).done(function( msg ) {				 
				  obj.attr("src",'<?php echo $this->Html->url("/img/tick.png");?>');	
				  obj.attr("class",'acsess');			 
			  });		 
		 });
</script>