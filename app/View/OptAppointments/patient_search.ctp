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
<div align="center" id = 'busy-indicator'>	
		&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
</div>		
<div class="inner_title">
	<h3> &nbsp; <?php echo __('Search Patient', true); ?></h3>
	<span></span>
</div>
<?php echo $this->Form->create('',array('action'=>'patient_search','type'=>'get'));?>	
<table border="0" class=""  cellpadding="0" cellspacing="0" width="500px" align="center">
	<tbody>		    			 				    
		<tr class="row_title">				 
			
			<td class=" "><label><?php echo __('Patient Name') ?> :</label></td>										
			
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td>
		  				 
			<td class=" "><label><?php echo __('Patient ID') ?> :</label></td>
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
		 			 
			<td class=" "><label><?php echo __('MRN') ?> :</label></td>
			<td class=" ">											 
		    	<?php 
		    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false));
		    	?>
		  	</td>
	 			 
			<td class=" "  >
				<?php
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
			</td>
		 
		 </tr>	
							
	</tbody>	
</table>
<!-- 
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="500px" >
	<tbody>
					    			 				    
		<tr class="row_title">				 
			
			<td class="row_format"><label><?php echo __('Patient Name') ?> :</label></td>										
			
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
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
			<td class="row_format"><label><?php echo __('MRN') ?> :</label></td>
			<td class="row_format">											 
		    	<?php 
		    		 echo    $this->Form->input('admission_id', array('type'=>'text','id' => 'admission_id', 'label'=> false, 'div' => false, 'error' => false));
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
 -->
 <?php echo $this->Form->end();?>	
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	<?php if(isset($data) && !empty($data)){	
			 $queryString = $this->request->query ; 		
			 if(isset($queryString['first_name'])){ 
			 $queryArr = array('first_name'=>$queryString['first_name'],'last_name'=>$queryString['last_name'],
			 					'patient_id'=>$queryString['patient_id']);
			 $this->Paginator->options(array('url' => array("?"=>$queryArr))); 
			 }
			 
	 ?>			
				 
				  <tr class="row_title">
				  	   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.patient_id', __('Patient ID')); ?></strong></td>
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.admission_id', __('MRN', true)); ?></strong></td>					  
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true)); ?></strong></td>					   
					   <td class="table_cell"><strong><?php echo $this->Paginator->sort('Patient.create_time', __('Created Time', true)); ?></strong></td>
					   <td class="table_cell"><strong><?php echo __('Action'); ?></strong></td>				   
				  </tr>
				  <?php 
				  	  $toggle =0;
				      if(count($data) > 0) {
				      		foreach($data as $persons){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
							       
							       $complete_name = $persons['Person']['first_name']." ".$persons['Person']['last_name']; 
                                                               $bedno = $persons['Room']['bed_prefix']." ".$persons['Bed']['bedno'];
								  ?>								  
								   <td class="row_format"><a href="#" onclick="changeparent('<?php echo $complete_name ;?>','<?php echo $persons['Person']['patient_uid']?>','<?php echo $persons['Person']['age']?>','<?php echo $persons['Person']['sex']?>','<?php echo $persons['Person']['payment_category']?>','<?php echo $persons['Person']['mobile']?>','<?php echo $persons['Person']['email']?>','<?php echo $persons['Person']['id']?>','<?php echo $persons['Person']['known_fam_physician']?>','<?php echo $persons['Person']['consultant_id'];?>','<?php echo $persons['Person']['dob'];?>','<?php echo $persons['Patient']['admission_id'];?>','<?php echo $bedno ;?>')";return false ;"><?php echo $persons['Patient']['patient_id']; ?></a></td>
								   <td class="row_format"><?php echo $persons['Patient']['admission_id']; ?> </td>
								   <td class="row_format"><?php echo $persons['Patient']['lookup_name']; ?> </td>
								   <td class="row_format"><?php 
								     
								   echo $this->DateFormat->formatDate2Local($persons['Patient']['form_received_on'],Configure::read('date_format'),true);
								   ?> </td>
								   <td class="row_format">
								   	 	<?php echo $this->Html->link(__('Pick this!'),
					 			                       '#',array('onclick'=>"changeparent('".$complete_name."','".$persons['Person']['patient_uid']."','".$persons['Person']['age']."','".$persons['Person']['sex']."','".$persons['Person']['payment_category']."','".$persons['Person']['mobile']."','".$persons['Person']['email']."','".$persons['Person']['id']."','".$persons['Person']['known_fam_physician']."','".$persons['Person']['consultant_id']."','".$persons['Person']['dob']."','".$persons['Patient']['admission_id']."','".$bedno."');",'escape' => false,'class'=>'blueBtn')) ;
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
<?php echo $this->element('sql_dump'); ?>
 	</body>
 	</html>
 
		 
<script>
	   
  $(document).ready(function(){
    	 
			$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","lookup_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","patient_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});			 
			$("#admission_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient","admission_id", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
		 
	 	});
	 	function changeparent(name,id,age,sex,payment_type,mobilePhone,email,person_id,knownPhy,consultant,dob,reg_id, bedno)
		{	 			
	 		$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "ajaxinsurancedetails", "admin" => false)); ?>"+"/"+id,
				  context: document.body,
				  beforeSend:function(){
		    		  //this is where we append a loading image
	    			  $('#busy-indicator').show('fast');
		  		  },				  		  
				  success: function(data){ 
		  			    //$('#busy-indicator').hide('fast');	
		  			    window.opener.document.getElementById('patient_name').value= name;
                                            if(window.opener.document.getElementById('patient_uid')) {
                                              window.opener.document.getElementById('patient_uid').value= id;
                                            }
					   
                                            if(window.opener.document.getElementById('age')) {
                                              window.opener.document.getElementById('age').value= age;
                                            }
                                            if(window.opener.document.getElementById('registration_no')) {
                                              window.opener.document.getElementById('registration_no').value= reg_id;
                                            }
                                            if(window.opener.document.getElementById('gender')) { 
                                              window.opener.document.getElementById('gender').value= sex.charAt(0).toUpperCase();
                                            }
                                            if(window.opener.document.getElementById('bedno')) { 
                                              window.opener.document.getElementById('bedno').value= bedno;
                                            }

                                            if(window.opener.document.getElementById('dob')) { 
                                              if(dob !="" && dob != "0000-00-00") {
                                              dob = new Date(dob);
                                              window.opener.document.getElementById('dob').value= dob.getDate()+"/"+eval(dob.getMonth()+1)+"/"+dob.getFullYear();
                                              } else {
                                              window.opener.document.getElementById('dob').value= "";
                                              }
                                            }
					    window.close();
				 }
			}); 
                        
                        
		} 
  </script>
 
				 