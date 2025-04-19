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
			<style>
	label{
		width:107px;
		padding:0px;
	}
</style>
</head>
<body>

<?php echo $this->Html->script(array('jquery-1.5.1.min.js','jquery.autocomplete'));
  if(!empty($errors)) { ?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
		<tr>
	  		<td colspan="2" align="left" class="error">
		   		<?php 
		     		foreach($errors as $errorsval){
		         		echo $errorsval[0];
		         		echo "<br />";
		     		} ?>
	  		</td>
	 </tr>
	</table>
<?php }  ?>
<div align="center" id = 'busy-indicator'>	
		&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
</div>		
<div class="inner_title">
	<h3> &nbsp; <?php echo __('Search Patient ID', true); ?></h3>
	<span></span>
</div>
<div class="clr">&nbsp;</div>
<?php echo $this->Form->create('',array('url'=>array('action'=>'patient_search',$this->request->params['pass']['0']),'type'=>'get'));?>
	
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
	<tbody> 		    			 				    
		<tr class="row_title"> 
			<td class="tabLable"><label><?php echo __('Patient Name') ?> :</label></td>	 
			<?php //echo ucfirst(strtolower($data['Patient']['Patient Name']));?>
			<td class="">											 
		    	<?php 
		    		 echo $this->Form->input('first_name', array('id' => 'first_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false));
		    	?>
		  	</td> 
			<td class="tabLable"><label><?php echo __('Last Name') ?> :</label></td>
			<td class="">											 
		    	<?php 
		    		 echo $this->Form->input('last_name', array('type'=>'text','id' => 'last_name', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td> 
			<td class="tabLable"><label><?php echo __('Patient ID') ?> :</label></td>
			<td class="">											 
		    	<?php 
		    		 echo $this->Form->input('patient_id', array('type'=>'text','id' => 'patient_id', 'label'=> false, 'div' => false, 'error' => false,'style'=>'width:100px'));
		    	?>
		  	</td> 
			<td class="tabLable" align="right">
				<input class="blueBtn" type="submit" value="Search" id="saveConsultantBill" />
			</td> 
		 </tr>	 		
	</tbody>	
</table>	
 <?php echo $this->Form->end();?>	
 <table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
	<?php if(isset($data) && !empty($data)){	
			 $queryString = $this->request->query ; 		
			 if(isset($queryString['first_name'])){ 
			 $queryArr = array('first_name'=>$queryString['first_name'],'last_name'=>$queryString['last_name'],
			 					'patient_id'=>$queryString['patient_id']);
			 $this->Paginator->options(array('url' => array("?"=>$queryArr))); 
			 }
			 
	 ?>	 
				  <tr class="row_title">
				  	   <td class="table_cell" width="15%" ><strong><?php echo ($this->Paginator->sort('Person.first_name', __('UID Patient Name'))); ?></strong></td>
				  	  <?php //echo ucfirst(strtolower($data['Patient']['Patient Name']));?>
					   <td class="table_cell" width="12%"><strong><?php echo $this->Paginator->sort('Person.patient_uid', __('Patient ID', true)); ?></strong></td>					  
					   <td class="table_cell" width="12%" align="left"><strong><?php echo $this->Paginator->sort('Person.mobile', __('Mobile', true)); ?></strong></td>					   
					   <td class="table_cell" width="12%" align="left"><strong><?php echo $this->Paginator->sort('Person.home_phone', __('Home Phone', true)); ?></strong></td>
					   <td class="table_cell" width="12%" align="left"><strong><?php echo $this->Paginator->sort('Person.email', __('Email', true)); ?></strong></td>
					   <td class="table_cell" width="12%" align="left"><strong><?php echo __('Action'); ?></strong></td>				   
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
								  ?>								  
								   <td class="row_format" ><?php echo $persons['Initial']['name']." ".$persons['Person']['first_name']." ".$persons['Person']['last_name'] ; ?></td>
								   <td class="row_format" ><?php echo $persons['Person']['patient_uid']; ?> </td>
								   <td class="row_format" ><?php echo $persons['Person']['mobile']; ?> </td>
								   <td class="row_format" ><?php echo $persons['Person']['home_phone']; ?> </td>						   
								   <td class="row_format" ><?php echo $persons['Person']['email']; ?> </td>
								   <td class="row_format" >
								   	 	<?php 
								   	 		//echo $this->Html->link(__('Pick this!'),
					 			            //           '#',array('onclick'=>"changeparent('".$complete_name."','".$persons['Person']['patient_uid']."','".$persons['Person']['age']."','".$persons['Person']['sex']."','".$persons['Person']['payment_category']."','".$persons['Person']['mobile']."','".$persons['Person']['email']."','".$persons['Person']['id']."','".$persons['Person']['known_fam_physician']."','".$persons['Person']['consultant_id']."','".$persons['Person']['relative_phone']."','".$persons['Person']['family_phy_con_no']."','".$persons['Person']['instruction']."');",'escape' => false,'class'=>'blueBtn')) ;
								   	 	/*if($sourceLocation == 'ShortVisit'){
											echo $this->Html->link(__('Select Patient!'),array('controller'=>'Persons','action'=>'quickPatientRagistration',$persons['Person']['id']),array('escape' => false,'class'=>'blueBtn')) ;
										}else{*/
								   	 		echo $this->Html->link(__('Select Patient!'),
					 			                       '#',array('onclick'=>"changeparent('".$complete_name."',".$persons['Person']['id'].",".$persons['Account']['balance'].");",'escape' => false,'class'=>'blueBtn','id'=>$persons['Person']['id'])) ;
								   	 	/*	} */
					 			     	?>  
					 			     	<input type="hidden" id="pData-<?php echo $persons['Person']['id'];?>" value='<?php echo json_encode($persons['Person']) ;?>' />  
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
			  <?php } ?>
		 </table>
 	</body>
 	</html>
		 
<script><!--
	   
  $(document).ready(function(){
    	 
			$("#first_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","first_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
			$("#last_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","last_name", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});			 
			$("#patient_id").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Person","patient_uid", "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
			});
		 
	 	});

		function changeparent1(perArr){
			movies = perArr.split(",");
			  alert(perArr);

		}
	 	function changeparent(name,id,amount)
		{	 	
	 		 	  
			var obj = jQuery.parseJSON($('#pData-'+id).val()); 
			 ///alert(obj);
	 		$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "ajaxinsurancedetails", "admin" => false)); ?>"+"/"+id,
				  context: document.body,
				  beforeSend:function(){
		    		//this is where we append a loading image
	    			$('#busy-indicator').show('fast');
		  		  },				  		  
				  success: function(data){
					// alert(obj.patient_uid);
		  			    $('#busy-indicator').hide('fast');	 
					   window.opener.document.getElementById('changeCreditTypeList').innerHTML= data	;	  	 				  			
					    window.opener.document.getElementById('lookup_name').value= name;
					 // for previous remaining amount by amit jain.
					    window.opener.document.getElementById('previous_receivable').value= amount; 
					    window.opener.document.getElementById('paymentType').value= obj.payment_category;
						window.opener.document.getElementById('patientID').value= obj.patient_uid;
						//window.opener.document.getElementById('patient_uid').value= obj.patient_uid;
						//window.opener.document.getElementById('insAuthorizationPatientId').value= obj.patient_uid;
						
						window.opener.document.getElementById('lookup_name').focus();
						window.opener.document.getElementById('age').value= obj.age;	
						window.opener.document.getElementById('sex').value= obj.sex;
						window.opener.document.getElementById('personID').value= obj.id; 
						//window.opener.document.getElementById('email').value= obj.email;
						//window.opener.document.getElementById('mobilePhone').value= obj.mobile; 
						window.opener.document.getElementById('phyContactNo').value= obj.family_phy_con_no;
						window.opener.document.getElementById('instructions').value= obj.instruction;
						//window.opener.document.getElementById('caseSummeryLink').value= obj.case_summery_link;
						//window.opener.document.getElementById('patientFile').value= obj.patient_file;
						//BOF sponsors details check
						 
						if(obj.credit_type_id==1){ 
							window.opener.document.getElementById('showwithcard').removeAttribute('style');
							window.opener.document.getElementById('showwithcardInsurance').style.display= "none";
				    		window.opener.document.getElementById('name_of_ip').value= obj.name_of_ip;	
							window.opener.document.getElementById('insurance_relation_to_employee').value= obj.relation_to_employee;
							window.opener.document.getElementById('insurance_executive_emp_id_no').value= obj.executive_emp_id_no; 
							window.opener.document.getElementById('insurance_non_executive_emp_id_no').value= obj.non_executive_emp_id_no;
							
							if(obj.non_executive_emp_id_no)
							window.opener.document.getElementById('insurance_esi_suffix').value= obj.relation_to_employee;
							 
							window.opener.document.getElementById('designation').value= obj.designation;
							window.opener.document.getElementById('insurance_number').value= "";
							window.opener.document.getElementById('sponsor_company').value= obj.sponsor_company;
							
						}else if(obj.credit_type_id==2){
							window.opener.document.getElementById('showwithcard').style.display= "none";
							window.opener.document.getElementById('showwithcardInsurance').removeAttribute('style');
							window.opener.document.getElementById('name_of_ip').value= obj.name_of_ip;	
							window.opener.document.getElementById('corpo_relation_to_employee').value= obj.relation_to_employee;
							window.opener.document.getElementById('corpo_executive_emp_id_no').value= obj.executive_emp_id_no; 
							window.opener.document.getElementById('corpo_non_executive_emp_id_no').value= obj.non_executive_emp_id_no;
							if(obj.non_executive_emp_id_no)
							window.opener.document.getElementById('corpo_esi_suffix').value= obj.relation_to_employee; 
							window.opener.document.getElementById('designation').value= obj.designation;
							window.opener.document.getElementById('insurance_number').value= obj.insurance_number;
							window.opener.document.getElementById('sponsor_company').value= obj.sponsor_company
						}else{
							window.opener.document.getElementById('showwithcard').style.display= "none";
							window.opener.document.getElementById('showwithcardInsurance').style.display= "none";
							$('.emp_id').val('');
						}
						//EOF sponsors details check
						
						//BOF known phy
						/*if(obj.known_fam_physician != ''){
							$.ajax({
								  url: "<?php echo $this->Html->url(array("controller" => 'patients', "action" => "ajaxdoctorlisting", "admin" => false)); ?>"+"/"+obj.known_fam_physician,
								  context: document.body,
								  beforeSend:function(){
						    		
					    			$('#busy-indicator').show('fast');
						  		  },				  		  
								  success: function(data){	
									  data= $.parseJSON(data);
							  			//window.opener.document.getElementById('doctorlisting').style.display= 'block'; 
							  			i=0;
										$.each(data, function(val, text) { 
											i++;
											var newOpt = new Option(text,val);  	
											window.opener.document.getElementById('doctorlisting').options[i] = newOpt ;
										});  
										window.opener.document.getElementById('doctorlisting').value=obj.consultant_id;
										window.opener.document.getElementById('familyknowndoctor').value= obj.known_fam_physician;
										
										window.close();		
						  		  }
							});
						}else */{
							window.close();
						}
						//EOF known phy 
				  }
			}); 
		}
		</script>
 
				 