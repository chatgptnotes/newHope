	   
	   
	   		<td valign="middle">
	      		<?php
	      			echo $this->Form->hidden('Billing.id'); 
	      			echo $this->Form->input('Billing.amount',array('class' => 'validate[required,custom[mandatory-enter]]',
	      			"style"=>"width:100px;text-align:right",'div'=>false,'legend'=>false,'label'=>false,'id' => 'amount')); 
				?>
	       </td>
	       <td valign="middle">
	       		<table width="100%" cellspacing="0" cellpadding="0" border="0">
	            	<tbody>
		            	<tr>
				        	<td>
								<?php echo $this->Form->input('Billing.date',array('class' => 'validate[required,custom[mandatory-enter-only]]','type'=>'text','div'=>false,'legend'=>false,'label'=>false,'readonly'=>'readonly','id' => 'date','value'=>$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true)));?>	                                
				            </td>
		        		</tr>
	                </tbody>
	            </table>                            
	        </td>
	        <td valign="middle" style="text-align: left;">
				<?php echo $this->Form->input('Billing.reason_of_payment', array('div' => false,'label' => false,'empty'=>__('Please select'),'options'=>array('Advance'=>'Advance','Deposit'=>'Deposit','Partial'=>'Partial'),'id' => 'reason_of_payment','class'=>'validate[required,custom[mandatory-select]]',)); ?>
	        </td>
	        <td valign="middle" style="text-align: left">
	        	<span style="text-align: left;">
					<?php echo $this->Form->input('Billing.mode_of_payment', array("class"=>"textBoxExpnd",'div' => false,'label' => false,
						  'empty'=>__('Please select'),'options'=>array('Cash'=>'Cash','Cheque'=>'Cheque','Credit'=>'Credit','Credit Card'=>'Credit Card','NEFT'=>'NEFT'),
						  'id' => 'mode_of_payment','class'=>'validate[required,custom[mandatory-select]]',)); ?>
	            </span>
	            <?php if($this->data['Billing']['mode_of_payment']=='Cheque' || $this->data['Billing']['mode_of_payment']=='Credit Card'){
	            			$displayCreditBlock = '';
	            			$displayNeftBlock = 'none';	     
	            			$displayCreditOnlyBlock = 'none';       			
	            	  }else if($this->data['Billing']['mode_of_payment']=='NEFT'){
	            	  		$displayCreditBlock = 'none';
	            			$displayNeftBlock = '';
	            			$displayCreditOnlyBlock = 'none';
	            	  }else if($this->data['Billing']['mode_of_payment']=='Credit'){
	            	  		$displayCreditBlock = 'none';
	            			$displayNeftBlock = 'none';
	            			$displayCreditOnlyBlock = '';
	            	  }
	            ?>
	             	<table  id="bankInformation" style="display:<?php echo $displayCreditBlock ;?>;">
	             		
	             			  	<tr >
								    <td>Bank Name</td>
								    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
							    </tr>
							    <tr>
								    <td>Account No.</td>
								    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
							    </tr>
							    <tr>
								    <td>Cheque/Credit Card No.</td>
								    <td><?php echo $this->Form->input('Billing.check_credit_card_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'card_check_number'));?></td>
							    </tr>
					</table> 
	             	<table id="neftBankInformation" style="display:<?php echo $displayNeftBlock ;?>;">
             				<tr >
							    <td width="47%">Bank Name</td>
							    <td><?php echo $this->Form->input('Billing.bank_name',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
							</tr>
							    <tr>
							    <td>Account No.</td>
							    <td><?php echo $this->Form->input('Billing.account_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'account_number'));?></td>
							</tr> 
						    <tr>
							    <td>NEFT No.</td>
							    <td><?php echo $this->Form->input('Billing.neft_number',array('type'=>'text','legend'=>false,'label'=>false,'id' => 'neft_number'));?></td>
							</tr>
							<tr>
							    <td>NEFT Date</td>
							    <td>
							    	<?php
										if(!empty($this->data['Billing']['neft_date'])){
										    $neft_date = 
                     	  						$this->DateFormat->formatDate2Local($this->data['Billing']['neft_date'],Configure::read('date_format'),true);
										}else{
											$neft_date =   '';
										}
							    		echo $this->Form->input('Billing.neft_date',array('type'=>'text','legend'=>false,'label'=>false,
             								'style'=>'width:150px;','id'=>'neft_date','value'=>$neft_date));
							    	?>
							    </td>
							</tr>
					</table>
					<table id="creditDaysInfo" style="display:<?php echo $displayCreditOnlyBlock ;?>;">
						<tr>
						  	<td> 
						  		Credit Period<font color="red">*</font><br /> (in days)</td>
						    <td><?php 
						     
						    echo $this->Form->input('Billing.credit_period',array('type'=>'text','style'=>'width:80%;',
							    	       'legend'=>false,'label'=>false,'id' => 'credit_period','class'=> 'validate[required,custom[mandatory-enter-only]]'));?></td>
					    </tr>
					</table>
	        </td> 
			<td valign="middle" style="text-align: left">
				<?php echo  $this->Html->image('icons/refresh-icon.png',array('title'=>'Back','onclick'=>"location.reload(); ")) ;?>
			</td>    
			
					<script><!-- 

	$(document).ready(function(){   
		 $( "#date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>', 
				onSelect:function(){$(this).focus();}
			});
		 $("#neft_date").datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				changeTime:true,
				showTime: true,  		
				yearRange: '1950',			 
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>', 
				onSelect:function(){$(this).focus();}
			});
	 
	 	 
});
--></script>    
			 