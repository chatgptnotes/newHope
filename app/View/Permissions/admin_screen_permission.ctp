<style>
th , td {
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

<div class="inner_title">
<h3><?php echo __('Permission Management - Screen Based permission of '.$module['Aco']['alias'].'', true); ?></h3>
<span>
<?php
if($entity['Aro']['model'] == "User"){
						$action_name = "user_permission";
					}else{
						$action_name = "role_permission";
					}



				if($screen != "false"){
					$url = $this->Html->url(array("action" => "package_first_level","admin" => true,$packageid,"plugin"=>false));
					 echo $this->Html->link(__('Back', true),array('action' => 'package_first_level',$packageid,$entity['Aro']['id'], "admin"=>true), array('escape' => false,'class'=>'blueBtn'));
					$model = "Aro";
					$screen = "true";
				}else{
 					 echo $this->Html->link(__('Back', true),array('action' => $action_name, "admin"=>true), array('escape' => false,'class'=>'blueBtn'));

				}


 ?>
</span>
</div>

  <div class="clr ht5"></div>
    <div class="clr ht5"></div>

	  <table  cellpadding="0" cellspacing="0" border="0">
         <tr>
		 	<td>Select  <?php echo $entity['Aro']['model'];?>:</td>
			<td>
				<select name="aro" id="aro" onchange="if(this.value!=''){window.location.href='<?php echo $this->Html->url(array("action" => "screen_permission","admin" => true,"plugin"=>false)); ?>/<?php echo $module['Aco']['id'];?>/'+this.value}">
				<option value="">Select <?php echo $entity['Aro']['model'];?></option>
				<?php
					if($entity['Aro']['model'] == "User"){
						$fieldname = "full_name";
					}else{
						$fieldname = "name";
					}
				foreach($entities as $key => $value){
					if( $value['Aro']['model'] == "User"){
							$optionValue = $value['Aro']['id']."/".$value['Role']['id'];
					}else{
							$optionValue = $value['Aro']['id'];
					}
				?>
				<option value="<?php echo $optionValue;?>" <?php if(isset($entity) && $entity[$entity['Aro']['model']]['id']==$value[$entity['Aro']['model']]['id']){ echo " selected=selected";}?>><?php echo $value[$entity['Aro']['model']][$fieldname];?>
                    <?php
                        	if($entity['Aro']['model'] == "User"){

                                echo "(".$value['Role']['name'].")";
                            }
                    ?>
                </option>
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

        	</tr>
        </table>
		 <div class="clr ht5"></div>
		 <div class="clr ht5"></div>
		 <div class="clr ht5"></div>

		 	  <table width="100%" cellpadding="0" cellspacing="0" border="0" id='acoGrid'>
         <tr  class="row_title">
			   <td style="text-align:left;">
			  		<strong>Screen name</strong>
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
				$restrictAction = array("autocomplete","patient_info","get_state_city","redirect_to_last_request" ,"getCurrentUrl","print_patient_info","setAddressFormat");
				foreach($modules as $key => $value){
				if(!in_array($value['Aco']['alias'],$restrictAction)){
				$cnt++;
				?>
			 <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			   <td style="text-align:left;width:20%"  >
			   <?php echo $value['Aco']['alias'];?> (  <?php echo $value['Aco']['label'];?>)
			   </td>
			    <td align="left" style="width:60%">
			  		<div style="border-bottom:1px solid;text-align:left;width:95%;float:left;" class="permissionDesc" id="<?php echo "desc_".$cnt?>" aco="<?php echo $value['Aco']['id'];?>" contenteditable="true">&nbsp;
			   			<?php  echo $value['Aco']['desc']; ?>
			   		</div>
			   		<img class="loading_placeholder" id="<?php echo "loader_".$cnt?>" style="float:left;"/>
			   </td>

			   <td class="row_action" align="left" style="width:20%">
			    <?php
					if($value[0] == "false")
						echo $this->Html->image("/img/cross.png",array("style"=>"float:none;","class"=>"acsess" ,'aco' =>$value['Aco']['id'],"aro"=>$entity['Aro']['id']));
					else
						echo $this->Html->image("/img/tick.png",array("style"=>"float:none;","class"=>"deny",'aco' =>$value['Aco']['id'],"aro"=>$entity['Aro']['id']));
				?>
			   </td>

		     </tr>
		   <?php
		   			}
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
			    obj.removeClass('acsess').addClass('deny');
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
				  obj.removeClass('deny').addClass('acsess');
			 });
		 })
		 
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