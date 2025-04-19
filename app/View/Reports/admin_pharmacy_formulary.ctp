 
<div class="inner_title">
<h3>&nbsp; <?php echo __('Pharmacy Formulary', true); ?></h3>
<span><?php
   echo $this->Html->link(__('Generate Report'), array('controller'=>'reports','action' => 'pharmacy_formulary','generate_excel','admin'=>true), array('escape' => false,'class'=>'blueBtn'));
   echo "&nbsp;";
   echo $this->Html->link(__('Back to Report'), array('controller'=>'pharmacy','action' => 'pharmacy_report','purchase','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
   ?></span>
</div> 
<div class="clr ht5"></div>
<div class="clr ht5"></div>
<table width="" cellpadding="0" cellspacing="0" border="" class="tabularForm">
	<thead>
		<tr>
			<th><?php echo __("Generic"); ?></th>
			<th><?php echo __("Product Name"); ?></th>
			<th><?php echo __("Pack"); ?></th>
			<th><?php echo __("Manufacturer"); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($result as $key=> $val){ ?>
		<tr>
			<td><?php echo $val['PharmacyItem']['generic']; ?></td>
			<td><?php echo $val['PharmacyItem']['name']; ?></td>
			<td align="center"><?php echo $val['PharmacyItem']['pack']; ?></td>
			<td><?php echo $val['PharmacyItem']['manufacturer']; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>