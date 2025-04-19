<style>
.rowtd td{
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
<h3><?php echo __('Module Permissions', true); ?></h3> 
</div>
  <div class="clr ht5"></div>
    <div class="clr ht5"></div>
	  <table  cellpadding="0" cellspacing="0" border="0">
         <tr>
		 	<td>Select Hospital:</td>
			<td>
				 <?php 
				 	echo $this->Form->create('Facility',array('url'=>array('controller'=>'hospitals','action'=>"permissions")));
				 	echo $this->Form->input('facility_id',array('options'=>$hospitals,'empty'=>__('Please select'),'label'=>false,'onchange'=>'this.form.submit();')) ;
				 	echo $this->Form->end();
				 ?>
			</td>
		 </tr>
		 </table>
		 <?php
		 	if(!empty($modules)){
		 ?>
		 <div class="clr ht5"></div>
		 <div class="clr ht5"></div>
		 <div class="clr ht5"></div>
		 <table>
			<tr>
				<td><?php echo $this->Html->image("/img/cross.png"); ?> Permission Denied! Click to grant permission</td>					
				 <td>	<?php echo $this->Html->image("/img/tick.png");?> Permission Granted! Click to deny permission</td>	 
        	</tr>
        </table>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" id='acoGrid' class="rowtd">
         <tr  class="row_title rowtd">
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
			   <td style="text-align:left;cursor:pointer;" class="screen" onclick="window.location.href='<?php echo $this->Html->url(array("action" => "screen_permission","admin" => true,$value['Aco']['id'],$role['Aro']['id'],$screen,$packageid,"plugin"=>false)); ?>'" width="150">
			   <?php echo $value['ModulePermission']['module'];?>
			   </td>
			    <td align="left">
			   <?php echo $value['ModulePermission']['description'];?>
			   </td>
			   
			   <td class="row_action" align="left">
			    <?php 
			   
					if(!empty($value['AssignedModulePermission']['module_permission_id'])) 
						echo $this->Html->image("/img/tick.png",array("style"=>"float:none;","class"=>"deny" ,
								"module_permission_id"=>$value['ModulePermission']['id'],"facility_id"=>$this->request->data['Facility']['facility_id'],
								"id"=>$value['AssignedModulePermission']['id']));
					else  
						echo $this->Html->image("/img/cross.png",array("style"=>"float:none;","class"=>"access"  ,
								"module_permission_id"=>$value['ModulePermission']['id'],"facility_id"=>$this->request->data['Facility']['facility_id']));
				 
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

	/*	var pager = new Pager('acoGrid', 15); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);*/

        
	    
       $(".access").live("click",function(){
		 	 var obj = $(this);
		 	 $(obj).attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 	 permission_id = obj.attr('module_permission_id'); 
		 	 facility_id = obj.attr('facility_id'); 
			 $.ajax({
				  type: "POST",
				  url: "<?php echo $this->Html->url(array("action" => "assign_permission","superadmin" => true,"plugin"=>false)); ?>",
				  data: "module_permission_id="+permission_id+"&facility_id="+facility_id ,
				 }).done(function( data ) {			 
				    obj.attr("src",'<?php echo $this->Html->url("/img/tick.png");?>');
				    obj.removeClass('access');	
					obj.addClass('deny');
					obj.attr("id",$.trim(data));				 
			 });
		 });
		 
        $(".deny").live("click",function(){
		   	 var obj = $(this);
		 	 obj.attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 	 permission_id = obj.attr('module_permission_id'); 
		 	 facility_id = obj.attr('facility_id'); 
		 	 id= obj.attr('id'); 
		 	 $.ajax({
			  	type: "POST",
			  	url: "<?php echo $this->Html->url(array("action" => "deny_permission","superadmin" => true,"plugin"=>false)); ?>",
			  	data: "id="+id+"&module_permission_id="+permission_id+"&facility_id="+facility_id,
			 }).done(function( msg ) {				 
				obj.attr("src",'<?php echo $this->Html->url("/img/cross.png");?>');	
				obj.addClass('access');	
				obj.removeClass('deny');		 
			 });		 
		 });
		 
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
</script>
