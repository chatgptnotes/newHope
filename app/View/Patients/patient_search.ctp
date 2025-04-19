<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title>
		<?php echo __('Hope', true); ?>
		<?php echo $title_for_layout; ?>
</title>
			<?php  echo $this->Html->css(array('internal_style','jquery.autocomplete')); ?>
</head>
<body>
<?php
  echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete'));
 
   
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
	<h3> &nbsp; <?php echo __('Search Patient', true); ?></h3>
	<span></span>
</div>
<?php echo $this->Form->create('',array('action'=>'patient_search'));?>	
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
	<tbody>
					    			 				    
		<tr class="row_title">				 
			
			<td class="row_format"><label><?php echo __('Patient Name') ?> :</label></td>										
			
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input('full_name', array('id' => 'full_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		 </tr>		 
		 <tr class="row_title">				 
			<td class="row_format"><label><?php echo __('MRN') ?> :</label></td>
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
		 </tr>	
		 <tr class="row_title">				 
			<td class="row_format"><label><?php echo __('Patient ID') ?> :</label></td>
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
		 </tr>	
		 <tr class="row_title">				 
			<td class="row_format" align="right" colspan="2">
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
<?php if(isset($data) && !empty($data)){  ?>			
				 
				  <tr class="row_title">
				  	   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.full_name', __('Patient Name', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('MRN', true)); ?></strong></td>					  
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID', true)); ?></strong></td>					   
					 	 <td class="table_cell"><strong><?php echo  __('Action'); ?></strong></td>				   
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
							       
							       $complete_name = $patients['Patient']['lookup_name']; 
								  ?>								  
								   <td class="row_format"><a href="#" onclick="changeparent('<?php echo $complete_name ;?>','<?php echo $patients['Patient']['id']?>')";return false ;"><?php echo $complete_name ; ?></a></td>
								   <td class="row_format"><?php echo $patients['Patient']['patient_id']; ?> </td>
								   <td class="row_format"><?php echo $patients['Patient']['admission_id']; ?> </td>
								   	 <td class="row_format">
								   	 	<?php echo $this->Html->link(__('Pick this!'),
					 			                       '#',array('onclick'=>"changeparent('".$complete_name."','".$patients['Patient']['id']."');",'escape' => false,'class'=>'blueBtn')) ;
					 			     	?>                  
					 			     </td>
					 			                       							    
								  </tr>
					  <?php }  ?>
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
			   <TD colspan="8" align="center"><?php echo __('No record found', true); ?>.</TD>
			  </tr>
			  <?php
			      }
			  ?>
		  
		 </table>
 	</body>
 	</html>
 
		 
<script>
	   
  $(document).ready(function(){
    	 
			$("#full_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","full_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});			 
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
		 
	 	});
	 	function changeparent(name,id,person_id)
		{	 
			window.opener.document.getElementById('patient_name').value= name;
			window.opener.document.getElementById('patient_id').value= id;	
			window.opener.document.getElementById('person_id').value= person_id;	
			window.close();
		} 
  </script>
 
				 