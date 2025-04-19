 <?php
	echo $this->Html->script ( 'jquery.fancybox-1.3.4' );
	echo $this->Html->css ( 'jquery.fancybox-1.3.4.css' );
	?>
<style>
.light:hover {
	background-color: #F7F6D9;
	/* text-decoration:none;
	    color: #000000;  */
}

.labTable {
	width: 100%;
	display: block;
}

.Tbody {
	width: 100%;
	height: 250px;
	display: list-item;
	overflow: auto;
}

.opd {
	background-color: #A4D7F2
}

.ipd {
	background-color: #86EFC5
}

.tabularForm {
	background-color: none;
}
</style>
<?php
echo $this->Html->css ( array (
		'tooltipster.css' 
) );
echo $this->Html->script ( array (
		'jquery.tooltipster.min.js' 
) );

?>

	<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm  labTable <!-- resizable sticky-->" id=""
	style="height: 390px; /* overflow: scroll; */">


	<tr class="light fixed">
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 10%">Sr.No.</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Employee Name</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Leave Type</th>
	 	<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">From</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">To</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Days/Hours</th>
		<th align="center" valign="top"
			style="text-align: center; padding-left: 5px; padding-right: 5px; width: 15%">Status</th>
	</tr>
	
	<tr>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	   <td></td>
	</tr>
</table>