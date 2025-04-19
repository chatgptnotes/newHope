<?php

 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));

?>
<h3>Pharmacy credit Details of <?php echo $patient['Patient']['lookup_name'];?> (<?php echo $patient['Patient']['admission_id'];?>)</h3>
<hr>
<table align="center" cellspacing="0" cellpadding="0">
    <tr>
        <td>Total Amount:</td><td align="left"><?php echo $this->Number->currency(ceil($total));?></td></tr>
        <tr><td>Paid Amount:</td><td align="left"><?php echo $this->Number->currency(ceil($paid));?></td></tr>
        <tr><td>Return Amount:</td><td align="left"><?php echo $this->Number->currency(ceil($returnAmt));?></td></tr>
       <!--   <tr> <td>Deposit Amount:</td><td align="left"><?php echo $this->Number->currency(ceil($deposit));?></td></tr>-->
       <tr><td style="border-top: solid 1px black">Balance Amount:</td><td align="left" style="border-top: solid 1px black"><?php echo $this->Number->currency(ceil(($bal)));?></td></tr>


</table>