<style>

</style>
<div class="inner_title">
	<?php if($this->params->pass[0]=='free'){ 
		$type='VIP';
	}else if($this->params->pass[0]=='discount'){
		$type='Discounted';
	}else if($this->params->pass[0]=='all'){
		$type='VIP and Discounted';
	}?>
	<h3>
		<?php echo 'List Of '. $type .' Patients'?>
	</h3>
	<span><?php 
	echo $this->Html->link(__('Print'),
			'#',array('onclick'=>'window.print()','escape'=>false,'class'=>'blueBtn'));
	echo $this->Html->link(__('Back'),
			 array("action"=>"appointments_management"),array('escape'=>false,'class'=>'blueBtn'));
		?></span>
</div>
<div class='clr'></div>
	<?php if($patientList){?>
		<table border="0" cellpadding="0" cellspacing="0" width="100%"
		class="formFull">
			<tr>
				<th>Sr.no</th>
				<th><?php echo $this->Paginator->sort('Patient.lookup_name', __('Patient Name', true));?></th>
				<th>Total Amount</th>
				<th>Discount </th>
			</tr><?php 
			$toggle=0;
			if($this->params->paging['Patient']['page']==1) {
				$srno=0;
			}else{
				$srno= ($this->params->paging['Patient']['limit']*$this->params->paging['Patient']['page'])-$this->params->paging['Patient']['limit'] ;
			}
			foreach($patientList as $patient){
				$srno++;
				if($toggle == 0) {
					echo "<tr>";
					$toggle = 1;
				}else{
					echo "<tr  class='row_gray'>";
					$toggle = 0;
				}?>
				<td ><?php echo $srno;?></td>
				<td ><?php echo $patient['Patient']['lookup_name'];?></td>
				<td><?php echo 'Rs.'.$patient['FinalBilling']['total_amount'];?></td>
				<td><?php if($patient['FinalBilling']['discount_type']=='Percentage'){
					$dis_amt=($patient['FinalBilling']['discount']*$patient['FinalBilling']['total_amount'])/100;
					echo 'Rs.'.$dis_amt;}
				else if($patient['FinalBilling']['discount_type']=='Amount'){
					echo 'Rs.'.$patient['FinalBilling']['discount'];
				}?></td>
			<?php }?>
			<tr>
	<TD colspan="8" align="center">
			 <!-- Shows the page numbers -->
		 <?php //debug($this->params['pass']);
		  $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
		 $this->Paginator->options(array('url' =>array($this->params['pass'][0],"?"=>$queryStr)));
		  ?>
		 <!-- Shows the next and previous links -->
		 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
		 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links'));?>
		 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
		 <!-- prints X of Y, where X is current page and Y is number of pages -->
		 <span class="paginator_links"><?php echo '<br >'.$this->Paginator->counter(array('class' => 'paginator_links')); ?>
		    </TD>
		   </tr>
		</table>
	<?php }?>