<?php 
   echo $this->Html->script(array('jquery.autocomplete','jquery.fancybox-1.3.4'));
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
<?php }
	
	//$queryStr =  $this->General->removePaginatorSortArg($this->params->query) ;
?>
<style>
	label{
		width:126px;
		padding:0px;
	}
</style>		
<div class="inner_title">
	<h3>&nbsp; <?php
		if($this->params->query['mod']=='assessment'){
			echo strtoupper($urlType).' - ';?><?php echo __('Assessment', true);
		}else{ 
			echo strtoupper($urlType).' - ';?><?php if($this->params->query['patientstatus']=='processed') echo __('Process Done Patient Enquiry', true); else if ($this->params->query['patientstatus']=='discharged') echo __('Discharged Patient Enquiry', true); else echo __('Generate HL7 Messages for patients', true); 
		} 
	?></h3>
	<span><?php 
		echo $this->Html->link(__('Patient Registration'), array('action' => 'add',"?"=>array('type'=>$this->params->query['type'])), array('escape' => false,'class'=>'blueBtn'));
		if($this->Session->read('role')=='doctor'){
			if(empty($this->params->query['doctor_id'])){
				$btnLabel   = 'My Patient';
				$btnAction = array('?'=>array_merge($queryStr,array('doctor_id'=>$this->Session->read('userid'))));
			}else{
				$btnLabel   = 'All Patient' ;
				$btnAction = array('?'=>array_merge($queryStr,array('doctor_id'=>'')));
			}
				
				echo $this->Html->link($btnLabel,$btnAction,array('escape'=>false,'class'=>'blueBtn'));
		}
			
	?></span>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('Patient',array('action'=>'search','type'=>'get'));?>	
<table border="0" class=" "  cellpadding="0" cellspacing="0" width="500px" align="center" >
	<tbody>
					    			 				    
		<tr class="row_title">				 
			
			<td class=" " align="right" width=" "><label><?php echo __('Patient Name') ?> :</label></td> 
			<td class=" ">											 
		    	<?php 
		    		 echo $this->Form->hidden('type',array('value'=>$this->request->query['type'])); 
		    		 echo $this->Form->hidden('patientstatus',array('value'=>$this->params->query['patientstatus'])); 
		    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td> 
			<td class=" " align="right"><label><?php echo __('Patient ID') ?> :</label></td>
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td>
			<td class=" " align="center"  >
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
  <tr>
			<td align="right" colspan="4">
				<?php 
			    		 echo    $this->Form->button(__('Export to Excel'), array('type'=>'button','id' => 'selection','label'=> false, 'div' => false, 'error' => false,'class'=>'blueBtn'));
			    	?>
			</td>
		</tr>
<?php if(isset($data) && !empty($data)){
	
	//set get variables to pagination url 
	 	 	 
			$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
	?>
			
				  
				  <tr class="row_title">
					   <td class="table_cell"><strong></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Person.first_name', __('Patient Name', true)); ?></strong></td>
                                          
					   <td class="table_cell" align="center"><strong><?php echo  __('Action'); ?></strong></td>
					   
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($data) > 0) {
				      		foreach($data as $patients){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
								  ?>								  
								   <td class="row_format"><?php echo $this->Form->checkbox('',array('name'=>$icd['icd']['id'],'value'=>$icd['icd']['icd_code']."::".$icd['icd']['description'])); ?></td>
								   <td class="row_format"><?php echo $patients['Patient']['patient_id']; ?> </td>
								   <td class="row_format"><?php echo ucfirst($patients[0]['lookup_name']); ?> </td>
								  						   
								   	 
								   <td align="center">
								   		<input name="" type="button" value="View" class="blueBtn_hl7" id="viewmsg" onclick="javascript:view_message(<?php echo $patients['Patient']['id']?>);"/>
								  </td>
								  </tr>
					  <?php } 
					 		$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
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
			<?php } ?> <?php					  
			      } else {
			 ?>
			  <tr>
			   <TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
			  </tr>
			  <?php
			      }
			  ?>
		  
		 </table>
 	
 
		 
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
			dateFormat: 'dd/mm/yy', 
		});
		});
			/*$("#PatientSearchForm").click(function(){
			  $('input:text').each(function(){
			    alert($(this).text())
			  });
			}); */
			
			
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

		
		
		 
   
  $(document).ready(function(){
    	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name",'null','null','null','admission_type='.$serachStr,"admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id",'null','null','null','admission_type='.$serachStr, "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});

			
	 	});

		function view_message(patient_id){
			alert(patient_id);
				
				$.fancybox({
		            'width'    : '90%',
				    'height'   : '90%',
				    'autoScale': true,
				    'transitionIn': 'fade',
				    'transitionOut': 'fade',
				    'type': 'iframe',
				    'href': "<?php echo $this->Html->url(array("controller" => "hl7_messages", "action" => "view_message")); ?>"+'/'+patient_id 
			    });
		}
  </script>
 
				