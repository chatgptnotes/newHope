<style>
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
</style>
<?php 

  echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js','jquery.autocomplete.js','jquery.fancybox-1.3.4.js') );
  echo $this->Html->css(array('jquery.autocomplete.css','jquery.fancybox-1.3.4.css'));
   
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
		   		<?php 
		     		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		}
		   		?>
	  		</td>
	 </tr>
	</table>
<?php } ?>
		
<div class="inner_title">
	<h3>&nbsp; <?php  echo __('Fax recipient selection', true); ?></h3>
	 <span style="float:right;margin: -24px 0; padding:0">
	
  
	
  </span>
</div>
 <?php if(!empty($patient_id)){
 ?>
<div class="patient_info">
 <?php echo $this->element('patient_information');?>
</div> <?php }?>
<div class="clr">&nbsp;</div>
<style>
	label{
		width:126px;
		padding:0px;
	}
</style>
<?php 





echo $this->Form->create("Recipient", array("action" => "search","id" => "searchForm"));?>	
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center">
	<tbody> 		    			 				    
		<tr class="row_title">				 
			
			<td class=" "><label><?php echo __('Recipient Name') ?> :</label></td>										
			
			<td class=" ">											 
		    	<?php  echo    $this->Form->input('keyword', array('id' => 'keyword','class' => 'drugText ', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		    		
		  	</td>
		 		 
			
		 		 
			<td class=" " align="right" colspan="2">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
  <div class="clr inner_title" style="text-align:right;"> </div>
	  		 
	 	
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
<?php //if(isset($data) && !empty($data)){  ?>
			
				  
				  <tr class="row_title">
				  <td class="table_cell"><strong><?php echo __('Sr. No.'); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Recipient Name'); ?></strong></td>
					   <td class="table_cell"><strong><?php  ?></strong></td>
                       <td class="table_cell"><strong><?php ?></strong></td>
                       <td class="table_cell"><strong><?php  ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Recipient Contact'); ?></strong></td>
					   <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>
					   
				  </tr>
				  <?php  $page = (isset($this->params->named['page']))?$this->params->named['page']:1 ;
 						 $srNo = ($this->params->paging[$this->Paginator->defaultModel()]['limit']) * ($page-1);
				  	  $toggle =0;
				     if(count($posts) > 0) {

				      		foreach($posts as $patients){
				       $cnt++;
						$srNo++;
							    if($toggle == 0) {
								      	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       echo "<tr>";
								       	$toggle = 0;
							      }
								  ?>	<td class="row_format"><?php echo $srNo;; ?> </td>							  
								   <td class="row_format"><?php echo $patients['Recipient']['name'].' '.$patients['Recipient']['last_name'];?></td>
								   
								   <!--<td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>  -->
								   <td class="row_format"><?php ?> </td>
								   <td class="row_format"><?php  ?> </td>						   
								   <td class="row_format"><?php 
								    echo $this->DateFormat->formatDate2Local($patients['Patient']['form_received_on'],Configure::read('date_format'),true); 
								   ?> </td>	
								   <td align="left"><?php 
								   		echo $patients['Recipient']['phone'];
								   ?>
								  </td>  
								  
								   <td align="center"><?php 
								   $id=$patients['Recipient']['id'];
								  
								  
								   echo $this->Html->link($this->Html->image('icons/edit-icon.png'),'#',array('onclick'=>"edit('".$patients['Recipient']['id']."')",'class'=>"",'escape' => false ));
								    echo $this->Html->link($this->Html->image('icons/view-icon.png'),'#',array('onclick'=>"preview('".$patients['Recipient']['id']."',$patient_id)",'class'=>"",'escape' => false ));
								     //$generate=$patients['Recipient']['is_generated'];
								   if(!empty($patients['Recipient']['is_generated'])) { 
									echo $this->Html->image('icons/active.png');
								  echo $this->Html->link($this->Html->image("icons/download.png",array('alt'=>'Download','title'=>'Download','width'=>'20','height'=>'18')),
								  		array('action'=>'download_fax',$patients['Recipient']['id'],$patient_id),array('escape'=>false )); 
									}
								 ?> 
								   </td>
								  </tr>
					  <?php } 
					 			//set get variables to pagination url
					  			//$this->Paginator->options(array('url' =>array("?"=>$this->params->query))); 
					   ?>
					   <tr>
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					 <!-- Shows the next and previous links -->
					 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
					    </TD>
					   </tr>
			<?php } else {?> 
			  <tr>
			   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
			  </tr>
			  <?php
			     }
			  ?>
		  
		 </table>
		 <div class="inner_title">
<h3><?php echo __('', true); ?></h3>
<span>
<?php 
 echo $this->Html->link(__('Add new recipients'),'#',array('onclick'=>"getRxHistory($patient_id)",'class'=>"blueBtn",'escape' => false )); 
 ?>
</span>
</div>
 	
 
		 
<script>
	//script to include datepicker
		$(function() {
			$("#dob").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			dateFormat:'<?php echo $this->General->GeneralDate();?>', 
		});
		});
			
			
			
		$('#PatientSearchForm').submit(function(){
			var msg = false ; 
			$("form input:text").each(function(){
			       //access to form element via $(this)
			       
			       if($(this).val() !=''){
			       		msg = true  ;
			       }
			    }
			);
			if(!msg){
				alert("Please fill atleast one field .");
				return false ;
			}		
		});
		
		 
   
  
  
  function getRxHistory(patient_id){
		$.fancybox({
			'width' : '50%',
			'height' : '70%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			
			'href' : '<?php echo $this->Html->url(array("controller" => "recipients", "action" => "add")); ?>'+ '/' + patient_id,

		});
	}

  function edit(id){
		$.fancybox({
			'width' : '50%',
			'height' : '70%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			
			'href' : '<?php echo $this->Html->url(array("controller" => "recipients", "action" => "edit")); ?>'+ '/' + id,

		});
	}
  function preview(id,patient_id){
		$.fancybox({
			'width' : '75%',
			'height' : '77%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			
			'href' : '<?php echo $this->Html->url(array("controller" => "recipients", "action" => "referral_preview_action",)); ?>'+ '/' + id+ '/' +patient_id,

		});
	}

 

  $('.drugText')
	.live(
	'focus',
	function() {
	$(this).autocomplete("<?php echo $this->Html->url(array("controller" => "recipients", "action" => "getdeviceused","admin" => false,"plugin"=>false)); ?>",
	{
	width : 250,
	selectFirst : false,
});
});
  </script>
 
				