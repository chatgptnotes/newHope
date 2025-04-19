 <style>
th,td {
padding-bottom:10px;
padding-top:10px;
padding-left:10px;
padding-right:10px;
}
.row_action img{float:inherit;}
h3{
text-align:left;
}
 #aro-user{
 	display:none;
 }
 #aro-role{
 	display:none;
 }
 #aro-user-label{
 	display:none;
 }
 #aro-role-label{
 	display:none;
 }
</style>
 <?php
 $permission_for="";
 ?>
<div class="inner_title" >
<h3><?php echo __('Permission Management - Package', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('action' => 'index', "admin"=>true), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>

  <div class="clr ht5"></div>
    <div class="clr ht5"></div>
	<table  cellpadding="0" cellspacing="0" border="0">
	<tr>
	  	<td><?php echo __("Select Mode");
	  	$hospitalModes = Configure::read('hospital_mode');
	  	$selectedMode = $this->Session->read('hospital_permission_mode');
	  	if(empty($selectedMode)){
	  		$selectedMode = Configure::read('hospital_default_mode');
	  	}
	  	?></td>
		<td><?php 
		if($selectedMode == 'Hospital'){
			$hospitalSelected = 'checked="checked"';
		}
		if($selectedMode == 'Clinic'){
			$clinicSelected = 'checked="checked"';
		}
		echo $hospitalModes['Clinic'];?><input <?php echo $clinicSelected;?> type="radio" name="hospital_mode" value="<?php echo $hospitalModes['Clinic'];?>"></td>
		<td><?php echo $hospitalModes['Hospital'];?><input <?php echo $hospitalSelected;?> type="radio" name="hospital_mode" value="<?php echo $hospitalModes['Hospital'];?>"></td>	  
	  </tr>
		<tr>
	  		<td><input type="radio" id="perm-user" name="prmissionfor" value="user"> User</td>
		    <td><input type="radio" id="perm-role" name="prmissionfor" value="role"> Role</td>
		</tr>
	</table>
	 <table  cellpadding="0" cellspacing="0" border="0">
	 
         <tr>
		 	<td  id="aro-user-label" >Select User:</td>
			<td  id="aro-user" >
 <select name="user_aro" onchange="if(this.value!=''){window.location.href='<?php echo $this->Html->url(array("action" => "package_permission","admin" => true,"plugin"=>false)); ?>/'+this.value}">
				<option value="">Select User</option>
				<?php
				foreach($users as $key => $value){
				?>
				<option value="<?php echo $value['Aro']['id'];?>" <?php if(isset($aro) && $aro ==  $value['Aro']['id']){echo " selected=selected";$permission_for="user";}?> ><?php echo $value['User']['full_name'];?> (<?php echo $value['Role']['name'];?>)</option>
				<?php
					}
				?>
				</select>
			</td>
			 <td  id="aro-role-label" >Select Role:</td>
			<td  id="aro-role" >
				<select name="role_aro" onchange="if(this.value!=''){window.location.href='<?php echo $this->Html->url(array("action" => "package_permission","admin" => true,"plugin"=>false)); ?>/'+this.value}">
				<option value="">Select Role</option>
				<?php
				foreach($roles as $key => $value){
				?>
				<option value="<?php echo $value['Aro']['id'];?>"   <?php if(isset($aro) && $aro ==  $value['Aro']['id']){echo " selected=selected";$permission_for="role";}?>><?php echo $value['Role']['name'];?></option>
				<?php
					}
				?>
				</select>
			</td>

		 </tr>
		 </table>
		  <?php
		 	if(isset($packages)){
		 ?>
		 <table>
			<tr>
				<td><?php echo $this->Html->image("/img/cross.png"); ?> Permission Denied! Click to grant permission</td>
				 <td>	<?php echo $this->Html->image("/img/tick.png");?> Permission Granted! Click to deny permission</td>
				 <td>	<?php echo $this->Html->image("/img/warning_small.png");?>Permission Granted but not fully! Click to grant permission</td>
        	</tr>
        </table>
 			<table  cellpadding="0" cellspacing="0" border="0" width="100%">
   			<tr  class="row_title">
			   <td style="text-align:left;" width="300">
			  		<strong>Package name</strong>
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
			 	foreach($packages as $key=>$value){
				$cnt++;
			 ?>
         <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			<td style="text-align:left;cursor:pointer;" onclick="window.location.href='<?php echo $this->Html->url(array("action" => "package_first_level","admin" => true,$value['PackagePermission']['id'],$aro,"plugin"=>false)); ?>'"><?php echo $value['PackagePermission']['package_name'];?></td>
			<td> </td>
			<td class="row_action" align="left">
			   <?php
						if($value['permission'] == "full")
							echo $this->Html->image("/img/tick.png",array("class"=>"deny" ,'aco' =>$value['PackagePermission']['id'],"aro"=>$aro));
						else if($value['permission'] == "deny")
							echo $this->Html->image("/img/cross.png",array("class"=>"acsess" ,'aco' =>$value['PackagePermission']['id'],"aro"=>$aro));
						else
							echo $this->Html->image("/img/warning_small.png",array("class"=>"acsess" ,'aco' =>$value['PackagePermission']['id'],"aro"=>$aro));
				?>
			 </td>
		 </tr>
		 <?php
		 }
		 ?>
		 </table>
       <?php
		  }
		 ?>



 <script>
  $(".acsess").live("click",function(){
		 	 var obj = $(this);
		 	 obj.attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		   $.ajax({
			  type: "POST",
			  url: "<?php echo $this->Html->url(array("action" => "assign_package_permission","admin" => true,"plugin"=>false)); ?>",
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
			  url: "<?php echo $this->Html->url(array("action" => "deny_package_permission","admin" => true,"plugin"=>false)); ?>",
			  data: "aco="+obj.attr("aco")+"&aro="+obj.attr("aro"),
			 }).done(function( msg ) {
				  obj.attr("src",'<?php echo $this->Html->url("/img/cross.png");?>');
				   obj.attr("class",'acsess');
			 });
		 })
 $("#perm-user").live("change",function(){
     $("#aro-user").show();
      $("#aro-role").hide();
	  $("#aro-user-label").show();
	  $("#aro-role-label").hide();
 })
  $("#perm-role").live("change",function(){
    $("#aro-user").hide();
      $("#aro-role").show();
	  $("#aro-user-label").hide();
	  $("#aro-role-label").show();
 })
 if("<?php echo $permission_for;?>" == "user"){
  		$("#aro-user").show();
   		$("#aro-user-label").show();
        $("#perm-user").attr("checked",true);
 }else if("<?php echo $permission_for;?>" == "role"){
 		$("#aro-role").show();
  		$("#aro-role-label").show();
    	$("#perm-role").attr("checked",true);
 }
 </script>