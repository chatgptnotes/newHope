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
	 <?php echo $this->Form->create('Facility',array('url'=>array('controller'=>'innovations','action'=>"module_list#main-grid"))); ?>
	  <table  cellpadding="0" cellspacing="0" border="0">
         <tr>
		 	<td>Select Role:</td>
			<td>
				 <?php 
				 	echo $this->Form->input('role_id',array('id'=>'role_id','options'=>$roles,'empty'=>__('Please select'),'label'=>false )) ;
				  
				 ?>
			</td>
		 </tr>
		  <tr>
		 	<td>Select Page :</td>
			<td>
				 <?php  
				 	echo $this->Form->input('module_id',array('id'=>'module_id','options'=>$moduleList,'empty'=>__('Please select'),'label'=>false )) ;
				 ?>
			</td>
		 </tr>
		  <tr>
		 	<td>Select Facility :</td>
			<td>
				 <?php  
				 	echo $this->Form->input('facility_id',array('id'=>'facility_id','options'=>$hospitals,'empty'=>__('Please select'),'label'=>false )) ;
				 ?>
			</td>
		 </tr>
		 <tr>
		 	<td><?php echo $this->Form->submit('Submit',array('class'=>'blueBtn')) ;?></td>
		 </tr>
		 </table>
		 <?php
		 echo $this->Form->end();
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
			  		<strong>Module</strong>
			   </td>	 
			  <td align="left">
			  	 	<strong>Permission</strong>
			   </td>
			     <td align="left">
			  	 	<strong>Sort Order</strong>
			   </td>
		     </tr>
		 	<?php
				$cnt =0;  
				 
				 for($s=1;$s<=count($modules);$s++){
				 	$sortDrop[$s] = $s ;
				 }
				foreach($modules as $key => $value){ 
				$cnt++; 
				?> 
			 <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
			 			    <td align="left">
			   <?php echo ($value['ModulePermission']['description'])?$value['ModulePermission']['description']:$value['ModulePermission']['module'];?>
			   </td> 
			   <td class="row_action" align="left">
			    <?php  
			    	if(in_array($value['ModulePermission']['id'],$linkedModule)) {
						echo $this->Html->image("/img/tick.png",array("style"=>"float:none;","class"=>"deny" ,
								"module_permission_id"=>$value['ModulePermission']['id'],"facility_id"=>$this->request->data['Facility']['facility_id'],
								"id"=>array_search($value['ModulePermission']['id'],$linkedModule)));
						$sortEnable  = '';
						$sortID = $value['ModulePermission']['id'] ;
					} else  {
						echo $this->Html->image("/img/cross.png",array("style"=>"float:none;","class"=>"access"  ,
								"module_permission_id"=>$value['ModulePermission']['id'],'id'=>$value['ModulePermission']['id']));
						 $sortEnable  = 'disabled';
						 $sortID = $value['ModulePermission']['id'];
					} 
				?>
			   </td>
			     <td class="row_action" align="left">
			    <?php   
			     
			    	$sortVal = $sortOrder[$sortID]; //key from sort array 
			    	echo $this->Form->input('sort_no',array('id'=>$sortID,'class'=>'sort-drop',
								'options'=>$sortDrop,'empty'=>'','label'=>false,'div'=>false,'value'=>$sortVal,$sortEnable));  

				?>
				<span id="div_<?php echo $sortID ;?>" ></span>
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
		 	 permission_id = $('#module_id').val(); 
		 	 role_id = $('#role_id').val();  
		 	 facility_id = $('#facility_id').val();  
		 	 module_permission_parent_id = obj.attr('module_permission_id'); 
		 	 var id= obj.attr('id'); 
			 $.ajax({
				  type: "POST",
				  url: "<?php echo $this->Html->url(array('controller'=>'innovations',"action" => "assign_module_set")); ?>",
				  data: "module_permission_id="+permission_id+"&role_id="+role_id+"&facility_id="+facility_id+"&module_permission_parent_id="+module_permission_parent_id ,
				 }).done(function( data ) {			 
				    obj.attr("src",'<?php echo $this->Html->url("/img/tick.png");?>');
				    obj.removeClass('access');	
					obj.addClass('deny');
					obj.attr("id",$.trim(data)); 
					$("#"+id).attr('disabled',false); //sort order dropdown id 	 
			 });
		 });
		 
        $(".deny").live("click",function(){
		   	 var obj = $(this);
		   	 $(obj).attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 	 permission_id = $('#module_id').val(); 
		 	 role_id = $('#role_id').val();  
		 	 module_permission_parent_id = obj.attr('module_permission_id');
			  facility_id = $('#facility_id').val(); 
		 	 var id= obj.attr('id'); 
		 	 $.ajax({
			  	type: "POST",
			  	url: "<?php echo $this->Html->url(array('controller'=>'innovations',"action" => "remove_module")); ?>",
			  	data: "id="+id+"&facility_id="+facility_id+"&module_permission_id="+permission_id,
			 }).done(function( msg ) {				 
				obj.attr("src",'<?php echo $this->Html->url("/img/cross.png");?>');	
				obj.addClass('access');	
				obj.removeClass('deny'); 	 
				$("#"+id).attr('disabled',true); //sort order dropdown id 	 	 
			 });		 
		 });

		 $(".sort-drop").live("change",function(){
			 obj = $(this); 
		 	 $(obj).attr("src",'<?php echo $this->Html->url("/img/ajax-loader.gif");?>');
		 	 permission_id = $('#module_id').val(); 
		 	 role_id = $('#role_id').val();  
		 	 module_permission_parent_id = obj.attr('module_permission_id'); 
		 	 var id = $(obj).attr('id');
		 	 $("#div_"+id).html("<img src='<?php echo $this->Html->url("/img/ajax-loader.gif");?>'>") ;
		 	 
			 $.ajax({
				  type: "POST",
				  url: "<?php echo $this->Html->url(array('controller'=>'innovations',"action" => "assign_module_set")); ?>", 
				  data: "module_permission_id="+permission_id+"&role_id="+role_id+"&module_permission_parent_id="+id+"&sort_order="+obj.val() ,
				 }).done(function( data ) {		
					  
				    obj.attr("src",'<?php echo $this->Html->url("/img/tick.png");?>'); 
				    $("#div_"+id).html('');
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
