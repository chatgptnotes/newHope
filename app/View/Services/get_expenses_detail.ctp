<div class="inner_title">
	<h3>
		<?php echo __('Referal Detail', true); ?>
	</h3>	
</div>
<div class="clr ht5"></div>
<table class="tabularForm" width="80%" align="center">
	<thead>
		<tr>
		<th>Patient Name</th>
		<th>Total Bill Amnt</th>
		<th>S Amnt Given To Referal</th>
		<th>B Amnt Given To Referal</th>
		<th>Total Amnt Given To Referal</th>
		</tr>
	<thead>
	<tbody>
		<?php foreach($patArray as $pId=>$pData){?>
		<tr>
			<td><?php echo $pData['name'];?></td>
			<td><?php echo $this->Number->format(round($pData['billAmt']));?></td>
			<td><?php echo isset($pData['spot'])?$this->Number->format(round($pData['spot'])):'0';?></td>
			<td><?php echo isset($pData['back'])?$this->Number->format(round($pData['back'])):'0';?></td>
			<td><?php $total=$pData['spot']+$pData['back'];
			echo $this->Number->format(round($total));?></td>
		</tr>
		<?php 
			$spot=$spot+$pData['spot'];
			$back=$back+$pData['back'];
			$tbs=$tbs+$total;
			$total=0;
		}?>
		<tr>
		<th colspan="2" style="text-align: center">Total</th>
		<th><?php echo $this->Number->format(round($spot));?></th>
		<th><?php echo $this->Number->format(round($back));?></th>
		<th><?php echo $this->Number->format(round($tbs));?></th>
		</tr>
	</tbody>
</table>