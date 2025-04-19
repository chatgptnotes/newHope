<div class="inner_title"><h3>Radiology Test Payment Receipts</h3>
<span>
	<?php 
		   	echo $this->Html->link(__('Back', true),array('action' => 'receipts'), array('escape' => false,'class'=>'blueBtn'));
		   ?>
</span>
</div>
<p class="ht5"></p>
<?php echo $this->element('patient_information');?>
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%">
	 
	  <tr class="row_title">
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('id', __('Sr.No', true)); ?></strong></td> 
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('total_amount', __('Total Amount', true)); ?></strong></td>
		   <td class="table_cell"><strong><?php echo $this->Paginator->sort('paid_amount', __('Paid Amount', true)); ?></strong></td>
		   <td class="table_cell"><strong><?php echo __('Balance'); ?></strong></td>
		   <td class="table_cell"><strong><?php echo __('Order ID'); ?></strong></td>
		   <td class="table_cell"><strong><?php echo __('Print Receipt', true); ?></strong></td>
	  </tr>
	  <?php 
	  		$currentID ='';
	      $cnt =0;
	      $paid = 0;
	      if(count($receiptData) > 0) {
	       foreach($receiptData as $data):
	       $cnt++;
	       
	  ?>
	   <tr <?php if($cnt%2 == 0) echo "class='row_gray'"; ?>>
		   <td class="row_format"><?php echo $cnt; ?></td>
		   <td class="row_format"><?php echo $this->Number->format($data['RadiologyTestPayment']['total_amount'],array('places'=>2,'decimal'=>'.','before'=>false)); ?> </td>
		   <td class="row_format"><?php echo $this->Number->format($data['RadiologyTestPayment']['paid_amount'],array('places'=>2,'decimal'=>'.','before'=>false)); ?> </td>
		   <td class="row_format"><?php
		   					if($currentID != $data['RadiologyTestPayment']['batch_identifier'])  $paid =0;
							$paid	+= $data['RadiologyTestPayment']['paid_amount']  ; 
		  				 	$payAmt = (int)$data['RadiologyTestPayment']['total_amount']-(int)$paid; 
		   					echo $this->Number->format($payAmt,array('places'=>2,'decimal'=>'.','before'=>false)) ;
		   ?> </td>
		 	 <td class="row_format"><?php echo $currentID = $data['RadiologyTestPayment']['batch_identifier'] ; ?> </td>
		   <td>
			    <?php 
					echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Receipt')),'#',
					     array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'radiology_test_payment_receipt_print',$data['RadiologyTestPayment']['id']))."', '_blank',
					           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
					     
					     echo $this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'View Receipt with test details')),'#',
					     array('escape' => false,'onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'radiology_test_payment_receipt_print',$data['RadiologyTestPayment']['id'],'?'=>array('identifier'=>$data['RadiologyTestPayment']['batch_identifier'])))."', '_blank',
					           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
	   			  ?>
	   		</td>
	   </tr>
	   <?php endforeach; } ?>
	    <tr>
	    	<TD colspan="8" align="center">
	    	<!-- Shows the page numbers -->
	 		<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
	 		<!-- Shows the next and previous links -->
	 		<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
	 		<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
	 		<!-- prints X of Y, where X is current page and Y is number of pages -->
	 		<span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
	    </TD>
   </tr>
</table>