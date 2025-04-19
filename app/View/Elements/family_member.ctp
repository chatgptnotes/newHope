<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formFull">
			
			<tr>
				<th style="padding-left: 10px;" colspan="4"><?php echo __('Details of family members');?>
				</th>
			</tr>
			<tr>
		<td colspan="3">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="formFull" id="familyMember">
				<tr>
					<th class="text" ><?php echo __('Sr.No');?>
					</th>
					<th ><?php echo __('Name');?>
					</th>
					<th><?php echo __('Sex');?>
					</th>
					<th><?php echo __('Relationship');?>
					</th>
					<th><?php echo __('Date of Birth');?>
					</th>
					<th><?php echo __('Age');?>
					</th>
					<th><?php echo __('Include in ESI');?>
					</th>
					<th><?php echo __('PF Nomiee');?>
					</th>
					<th><?php echo __('Gratuity Nominee');?>
					</th>
					<th><?php echo __('Included in Health Insurance');?>
					</th>
					<th><?php echo __('Action');?>
					</th>
				</tr>
				<tr>
					<td class="text" ><?php echo $srNo = 1;?>
					</td>
					<td><?php echo $this->Form->input('HrDetail.family_member.0.member_name',array('type'=>'text','id'=>'member_name-1','class'=>'textBoxExpnd'));?>
					</td>
					<td><?php echo $this->Form->input('HrDetail.family_member.0.member_sex', array('class' => 'textBoxExpnd', 'options' => array('M' => 'Male', 'F' => 'Female'), 'empty' => 'Select Gender', 'id' => 'member_sex', 'label'=> false, 'div' => false, 'error' => false));?></td>
					</td>
					<td><?php echo $this->Form->input('HrDetail.family_member.0.certificates',array('type'=>'text','style'=>'width:102px','id'=>'certificates-1','class'=>'textBoxExpnd'));?>
					</td>
					<td><?php echo $this->Form->input('HrDetail.family_member.0.member_dob', array('type'=>'text', 'id' => 'member_dob', 'class' => 'textBoxExpnd member_dob','style'=>'width:77px', 'label'=> false, 'div' => false, 'error' => false));
					?></td>
					<td>  <?php echo $this->Form->input('HrDetail.family_member.0.member_age', array('type'=>'text','class' => 'textBoxExpnd','id' => 'member_age','style'=>'width:60px', 'label'=> false, 'div' => false, 'error' => false));
			    	  ?></td>
					<td class="text">  <?php echo $this->Form->input('HrDetail.family_member.0.member_est', array('type'=>'checkBox', 'id' => 'member_est', 'label'=> false, 'div' => false, 'error' => false));
			    	  ?></td>
			     	 
					 <td class="text"> <?php echo $this->Form->input('HrDetail.family_member', array('type'=>'checkBox', 'id' => 'member_pf_nomiee', 'label'=> false, 'div' => false, 'error' => false));
	       				 ?></td>
					<td class="text">  <?php echo $this->Form->input('HrDetail.family_member', array('type'=>'checkBox', 'id' => 'member_gratuity_nominee', 'label'=> false, 'div' => false, 'error' => false)); ?>
					</td>
					<td class="text">  <?php echo $this->Form->input('HrDetail.family_member', array( 'type'=>'checkBox', 'id' => 'health_insurance', 'label'=> false, 'div' => false, 'error' => false)); ?></td>
					
					<td class="text" ><?php echo $this->Html->image('icons/plus_6.png', array('title'=> __('Add', true),
   			 					'alt'=> __('Add', true),'id'=>'addMorefamMember','style'=>'float:none;'));?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>  
	     <script> 
	     var srNo = parseInt('<?php echo $srNo;?>');
	 	
	 	$(function(){
	 		$('#addMorefamMember').click(function () {
	 			srNo++;//in
	 			$('#familyMember tbody:last')
	 				.append($('<tr>').attr('id','removeFamilynem-'+srNo)
	 					.append($('<td>').text(srNo).attr('class','text'))
	 				 		.append($('<td>')
	 				 			.append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_name]','type':'text','class':'textBoxExpnd','id' : 'member_name-'+srNo})))
	 			 		 	.append($('<td>')
	 				 		 		.append($('<select>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_sex]','class':'textBoxExpnd', 'id' : 'member_sex-'+srNo})
	 				 		 		.append(new Option("Please select", ""))
	 				 		 		.append(new Option("Male", "M"))
	 				 		 		.append(new Option("Female", "F"))))
	 			 		 	.append($('<td>')
	 			 		 			.append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_relationship]','class':'textBoxExpnd', 'id' : 'member_relationship-'+srNo})
	 		 			 		 			.css('width','102px')))
	 			 		 	.append($('<td>')
	 			 		 			.append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_dob]','class':'textBoxExpnd member_dob', 'id' : 'member_dob-'+srNo})
	 		 			 		 			.css('width','77px')))		
	 				 		.append($('<td>')
	 				 				.append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_age]','class':'textBoxExpnd', 'id' : 'member_age-'+srNo})
	 				 						.css('width','60px')))
	 		 			 	.append($('<td>').attr('class','text')
	 		 			 		    .append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_est]','type':'checkbox', 'id' : 'member_est-'+srNo})))
	 			 			 .append($('<td>').attr('class','text')
	 			 			 		 .append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_pf_nomiee]','type':'checkbox', 'id' : 'member_pf_nomiee-'+srNo})))
	 				 		.append($('<td>').attr('class','text')
	 				 			     .append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][member_gratuity_nominee]','type':'checkbox', 'id' : 'member_gratuity_nominee-'+srNo})))
	 					 	.append($('<td>').attr('class','text')		 	 		
	 				 				.append($('<input>').attr({'name':'data[HrDetail][family_member]['+srNo+'][health_insurance]','type':'checkbox','id' : 'health_insurance-'+srNo})))
	 				 		.append($('<td class="text">').attr('id','Td-'+srNo).append($('<span>').attr({'class':'removeFamilynem','id' : srNo})
	 			 		 		 	.append('<?php echo $this->Html->image('icons/cross.png', array('title'=> __('Remove', true),
	 		   			 					'alt'=> __('Remove', true),'style'=>'float:none;'));?>')))
	 			 );
	 			$('.removeFamilynem').on('click' , function (){
	 				$("#removeFamilynem-" + $(this).attr('id')).remove();
	 			});	
	 			$(".member_dob").datepicker({
	    			showOn : "both",
	    			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	    			buttonImageOnly : true,
	    			changeMonth : true,
	    			changeYear : true,
	    			yearRange: '-100:' + new Date().getFullYear(),
	    			maxDate : new Date(),
	    			dateFormat:'<?php echo $this->General->GeneralDate();?>',
	    			onSelect : function() {
	    				calculateAge();		 			
	    				$(this).validationEngine("hide");
	    			}						
	    		});
	 		});
	 			
	 	});
	    	 $(".member_dob").datepicker({
	    			showOn : "both",
	    			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	    			buttonImageOnly : true,
	    			changeMonth : true,
	    			changeYear : true,
	    			yearRange: '-100:' + new Date().getFullYear(),
	    			maxDate : new Date(),
	    			dateFormat:'<?php echo $this->General->GeneralDate();?>',
	    			onSelect : function() {
	    				calculateAge();		 			
	    				$(this).validationEngine("hide");
	    			}						
	    		});
	    	 function calculateAge() {	//function to calculate age using date of birth
	    			var dateofbirth = $("#member_dob").val();
	    			if (dateofbirth != "") {
	    				var currentdate = new Date();
	    				var splitBirthDate = dateofbirth.split("/");
	    				var caldateofbirth = new Date(splitBirthDate[2]+ "/"+ splitBirthDate[1]+ "/"+ splitBirthDate[0]+ " 00:00:00");
	    				var caldiff = currentdate.getTime()	- caldateofbirth.getTime();
	    				var calage = Math.floor(caldiff/(1000 * 60 * 60 * 24 * 365.25)); 
	    				$("#member_age").val(calage);
	    			}
	    		}
	    		
</script>
	     