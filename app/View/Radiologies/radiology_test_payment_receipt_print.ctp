
 <table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%"  >
		  <tr>
			  <td colspan="3" align="right">
			  <div id="printButton">
			  <?php 
			 
			   		echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));
			  ?>
			  </div>
		 	 </td>
		  </tr><!--
		  <tr>
		  	<td>&nbsp;</td>
		  	<td align="" valign="top" colspan="1" style="text-decoration:underline;letter-spacing: 0.2em;"><strong>RECEIPT</strong></td>
		  </tr>
		  --><tr><td>&nbsp;</td></tr>
		  
		  <tr>
		  	<td width="200">Received with thanks from</td>
		  	<td>: <?php echo $receiptData['PatientInitial']['name'].' '.$receiptData['Patient']['lookup_name']." (".$receiptData['Patient']['admission_id'].")"; ?></td>	
		  </tr>
		  <tr>
		  	<td>The sum of</td>
		  	<td>: <?php echo $this->RupeesToWords->no_to_words($receiptData['RadiologyTestPayment']['paid_amount']); ?></td>
		  </tr>
		  <tr>
		  	<td>By</td>
		  	<td>: Cash</td>
		  </tr>
		  <tr>
		  	<td>Remarks</td>
		  	<td>: <?php echo $receiptData['RadiologyTestPayment']['remark']; ?></td>
		  </tr>
		  <tr>
		  	<td>Date</td>
		  	<td>: <?php if($receiptData['RadiologyTestPayment']['create_time'])
		  	echo $this->DateFormat->formatDate2Local($receiptData['RadiologyTestPayment']['create_time'],Configure::read('date_format'),true);
								   		   ?></td>
		  </tr>
		    <?php  if(!empty($this->params->query['identifier']) && !empty($test_ordered)){ ?>
		  		 
				    <tr class=" "> 
					   <td class="" valign="top"><?php echo __('Test Name', true); ?></td> 
					    <td>
					    	<table cellpadding="0" cellspacing="0" width="100%">
					  <?php 
						  $toggle =0;
						  foreach($test_ordered as $labs){ 
									  ?>
									  <tr>
									   <td class="row_format"><?php echo ucfirst($labs['Radiology']['name']); ?> </td>
									    </tr>
						  <?php }   ?> 
					</table></td> 
		  		<?php 
		  	}
		  ?>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr><td>&nbsp;</td></tr>
		  <tr>
		  	<td>
		  		<?php 
		  			//echo $this->Html->image('icons/rupee_symbol.png');
		  			echo $this->Number->currency($receiptData['RadiologyTestPayment']['paid_amount'])."/-"; ?>
		  	</td>
		  	<td>Name & Sign of Patient &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Authorised Signatory</td>
		  </tr>
	</table>
