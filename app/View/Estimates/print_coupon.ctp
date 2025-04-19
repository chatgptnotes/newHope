<style>
.tabularForm td {
    background: #ffffff none repeat scroll 0 0;
    color: #000;
    font-size: 15px;
    padding:0px 4px;
}
.sectd{
  width :60px;
  font-weight: bold;
}
.print_form{
	background:none;
	font-color:black;
	color:#000000;
}
</style>
<body class="print_form" onload="javascript:window.print();window.close();">  

<?php foreach($data as $couponkey=> $couponData) { 
	if($couponData['Coupon']['parent_id']==0){
		$batchName = $couponData['Coupon']['batch_name'];
		continue ;
		}
?>
		<table width="100%" cellspacing="0" cellpadding="0" border="1" height= "23%" class="tabularForm" style=" clear:both;">
		<?php //debug($couponData); ?>
		    <tr>
		        <td width="30"><?php echo __('Batch Name:',true); ?></td>
		        <td class="sectd"><?php echo $batchName?></td>
		    </tr>
		    <tr>
		        <td width="30"><?php echo $couponData['Coupon']['type'] ?></td>
		        <td class="sectd"><?php echo $couponData['Coupon']['batch_name']?></td>
		    </tr>
		    <tr>
		        
		        <td width="30"><?php echo __('Valid Services & Coupon Amount:',true); ?></td>
		        <td class="sectd"><?php $coupondata = unserialize($couponData['Coupon']['coupon_amount']);$allServices = array();
						foreach($coupondata as $key => $val){ #debug($val);
     						$amt = ($val['type']=='Percentage') ? $val['value'].'%' : $val['value'].'.00' ;
						     $allServices[]  = ' '.$services[$val['serviceId']].' - '.$amt;
						    
						} echo implode(',',$allServices);
						?> </td>
		    </tr>
		    
		    <tr>
		        <td width="30"><?php echo __('Valid :',true); ?></td>
		        <td class="sectd"><?php echo $this->DateFormat->formatDate2Local($couponData['Coupon']['valid_date_from'],Configure::read('date_format'))." ".'to'." ".$this->DateFormat->formatDate2Local($couponData['Coupon']['valid_date_to'],Configure::read('date_format'));?>
			</td>
		    </tr>
		    
		</table> 
		<?php if(count($data) != $couponkey+1) { ?>
				<table width="90%" height="2%" cellspacing="0" cellpadding="0" border="0" class="" style=" clear:both;">
				<tr><td>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
		<tr><td></td></tr>
		</table>
<?php } }?>