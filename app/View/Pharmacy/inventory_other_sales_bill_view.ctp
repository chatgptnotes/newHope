<?php //debug($data['PharmacySalesBill']['customer_name']);exit;

	$website = $this->Session->read('website.instance');
	

?>
<div style="padding: 10px">
	<div class="inner_title">
		<h3>Sales View</h3>
		<span><?php

		echo $this->Html->link(__('Back'), array('action' => 'get_other_pharmacy_details','sales','inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
		?>
		</span>
	</div>

	<?php

	echo $this->Html->script(array(
			'jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','jquery.ui.all.css','internal_style.css'));

	echo $this->Html->script('jquery.autocomplete_pharmacy');
	echo $this->Html->css('jquery.autocomplete.css');
	?>
	<style>

/* .tdLabel{
	width: 21%;
}
.tdLabel2 {
	width: 125px;
}
.tdlab{
	width: 80px;
} */
.tdLabel{padding-left:15px!important;padding-right:0px!important;}
</style>
	<?php $name=$data['PharmacySalesBill']['customer_name'];?>
	
	
	<div class="clr ht5"></div>
	<table width="85%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	<td class="tdLabel" width="12%"> Patient Name <font color="red">*</font>:
	<lable name="PharmacySalesBill.customer_name" type="text" id="custname"
			style="width:50%;float:right;"  tabindex="1" ><?php echo $name;?></lable> 
	</td> 	 
	
	<td class="tdLabel" id="" align="center" class="dob" width="10%"><?php echo __('Date of Birth ');?> :
	<?php 	 $data['PharmacySalesBill']['p_dob'] = $this->DateFormat->formatDate2Local( $data['PharmacySalesBill']['p_dob'],Configure::read('date_format'));
	echo $this->Form->input('PharmacySalesBill.p_dob', array('type'=>'text','style'=>'width:80px;float:right;','readonly'=>'readonly','size'=>'20','class' => 'textBoxExpnd','div'=>false,'label'=>false, 'value' => $data['PharmacySalesBill']['p_dob']));?></td>
				
				<td class="tdLabel" id="boxSpace" width="5%">Age :
				<?php
				echo $this->Form->input('PharmacySalesBill.c_age', array('type'=>'text','style'=>'width:40px;float:right;','maxLength'=>'3','size'=>'20','class' => ' ','id' => 'age','div'=>false,'label'=>false ,'value' => $data['PharmacySalesBill']['c_age']));
			?>
	</td>
		
	<td class="tdLabel" id="" width="9%"><?php echo __('Gender');?>:
	<?php  
				echo $this->Form->input('PharmacySalesBill.gender', array('options'=>array(""=>__('Please Select gender'),"male"=>__('Male'),'female'=>__('Female')),'class' => ' textBoxExpnd','id' => 'gender','div'=>false,'label'=>false,'style'=>'float:right;','value' => $data['PharmacySalesBill']['gender'])); ?>
	</td>
	
	<td class="tdLabel" width="11%"> Address :
	<input name="[PharmacySalesBill][p_address]" type="text", id="custaddr"
			class="textBoxExpnd validate[required]" style="width:64%;float:right;" tabindex="4" value= "<?php echo $data['PharmacySalesBill']['p_address'];?>" />
	</td>
	
			
	<td class="tdLabel" width="15%"> Doctor Name<font color="red">*</font> :
	<lable name="[PharmacySalesBill][p_doctname]" id="doctname"
			style="width:63%;float:right;"><?php echo $data['PharmacySalesBill']['p_doctname'];?></lable>
			
	</td>
	
			
	</tr>
</table>
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0"
		class="tabularForm" id="billDetailTable">
		<tr>
			<th width="40" align="center" valign="top"
				style="text-align: center;">Sr. No.</th>
			<th width="50" align="center" valign="top"
				style="text-align: center;">Item Code</th>
			<th width="120" align="center" valign="top" style="text-align: center;">Item
				Name</th>
			<th width="100" align="center" valign="top"
				style="text-align: center;">Manufacturer</th>
			<th width="60" align="center" valign="top"
				style="text-align: center;">Pack</th>
			<th width="60" valign="top" style="text-align: center;">Batch No.</th>
			<th width="60" valign="top" style="text-align: center;">Expiry Date</th>
			<th width="60" valign="top" style="text-align: center;">MRP</th>

			<th width="60" valign="top" style="text-align: center;">Price</th>
			<th width="50" valign="top" style="text-align: center;">Qty</th>
			<th width="80" valign="top" style="text-align: center;">Amount</th>
		</tr>
		<?php
		$grandTotal=0.00;
		$itemObj = Classregistry::init('PharmacyItem');
		$count = 1; 
		foreach($data['PharmacySalesBillDetail'] as $key=>$value){ 
				$item = $itemObj->find('first',array('conditions' =>array('PharmacyItem.id' => $value['item_id'])));
				?>
		<tr id="row1">
			<td align="center" valign="middle" class="sr_number"><?php echo $count;?>
			</td>
			<td align="center" valign="middle">
			<lable name="item_code[]"
				id="item_code" type="text" ><?php echo $item['PharmacyItem']['item_code'];?></lable>
			</td>

			<td align="center" valign="middle">
			<lable name="item_name[]"
				id="item_name" type="text" ><?php echo $item['PharmacyItem']['name'];?></lable>
			</td>
				
			<td align="center" valign="middle">
			<lable name="manufacturer[]"
				id="manufacturer" type="text" ><?php echo $item['PharmacyItem']['manufacturer'];?></lable>
			</td>

			<td align="center" valign="middle">
			<lable name="pack[]"
				id="pack_item_name" type="text" ><?php echo $item['PharmacyItem']['pack'];?></lable>
			</td>
				
			<td align="center" valign="middle">
			<lable name="batch_number[]"
				id="batch_number" type="text"><?php echo $value['batch_number'];?></lable>
			</td>

			<td align="center" valign="middle">
			<lable name="expiry_date[]"
				id="expiry_date" type="text"><?php echo $this->DateFormat->formatDate2Local($value['expiry_date'],Configure::read('date_format'));?></lable>
			</td>
			<?php
			$qty = (int)$value['qty'];
			$itemRate = Classregistry::init('PharmacyItemRate');
			$rate = $itemRate->find('first',array('conditions' =>array('PharmacyItemRate.item_id' => $value['item_id'],'PharmacyItemRate.batch_number'=>$value['batch_number'])));
			$sale_price = (float)$value['sale_price'];
			$total = ($qty*$sale_price); 
			$grandTotal = $total+$grandTotal; 
			?>
			<td valign="middle" style="text-align: center;">
			<lable name="mrp[]"
				type="text" id="mrp"><?php echo $value['mrp'];?></lable>
			</td>
				
			<td valign="middle" style="text-align: center;">
			<lable name="rate[]" id="rate" 
				type="text" ><?php echo $value['sale_price'];?></lable>
			</td>
				
			<td valign="middle" style="text-align: center;">
			<lable name="qty[]"
				type="text" id="qty"><?php echo $value['qty'];?></lable>
			</td>


			<td valign="middle" style="text-align: center;">
			<lable name="value[]"
				type="text" id="value"><?php echo number_format($total,2);?></lable>
			</td>
		</tr>
		<?php
		$count++;
		}
		?>
	</table>
	<div class="clr ht5"></div>
	<table cellpadding="0" cellspacing="0" border="0">
		<?php
		$tax = (float)$data['PharmacySalesBill']['tax'];
		$taxamount = ($grandTotal*$tax)/100;  
		$grandTotal = $grandTotal+$taxamount; 
		?>
		<td width="18%" class="tdLabel2">Payment Mode:</td>
		<td width="50" class="tdLabel2"><?php echo ucfirst($data['PharmacySalesBill']['payment_mode']) ;?>
		</td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td class="tdLabel2"></td>
		<td width="35" class="tdLabel2">Tax:</td>
		<td width="80"><input name="tax" type="text" class="textBoxExpnd"
			id="tax" tabindex="35"
			value="<?php echo $data['PharmacySalesBill']['tax'] ;?>"
			readonly='true' /></td>
		<td width="35">&nbsp;</td>
		<td width="100" class="tdLabel2">Total Amount :</td>
		<td width="130"><?php echo $this->Number->currency($grandTotal);?>
		</span></td>
		</tr>
	</table>
	<div class="clr ht5"></div>
	<div class="clr ht5"></div>
	<div align="right">
		<?php 
		   if($website=="kanpur")
		   {
		   	$url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view_kanpur",'PharmacySalesBill',$data['PharmacySalesBill']['id'],'inventory'=>true));
		    $header_url = Router::url(array("controller" => "pharmacy", "action" => "inventory_prin_view_with_header",'PharmacySalesBill',$data['PharmacySalesBill']['id'],'inventory'=>true));
		   }
		   else	  
		        $url = Router::url(array("controller" => "pharmacy", "action" => "inventory_print_view",'PharmacySalesBill',$data['PharmacySalesBill']['id'],'inventory'=>true));
		?> 
		<?php 
		   if($website=="kanpur")
		   {
		?>
		<input name="print" type="button" value="Print with Header" class="blueBtn"
			tabindex="36"
			onclick="window.open('<?php echo $header_url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />
		<?php }?>
		<input name="print" type="button" value="Print" class="blueBtn"
			tabindex="36"
			onclick="window.open('<?php echo $url;?>','Print','fullscreen=no,height=800px,width=800px,location=0,titlebar=no,toolbar=no',true );" />
	</div>

</div>
<script>

$("#dob")
.datepicker(
		{
			showOn : "both",
			buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly : true,
			changeMonth : true,
			changeYear : true,
			yearRange: '-100:' + new Date().getFullYear(),
			maxDate : new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate();?>',
			onSelect : function() {
				//$(this).focus();										
				$(this).validationEngine("hide");
			}						
		});
$("body")
.click(
		function() {
			var dateofbirth = $("#dob").val();
			if (dateofbirth != "") {
				var currentdate = new Date();
				var splitBirthDate = dateofbirth
						.split("/");
				var caldateofbirth = new Date(
						splitBirthDate[2]
								+ "/"
								+ splitBirthDate[1]
								+ "/"
								+ splitBirthDate[0]
								+ " 00:00:00");
				var caldiff = currentdate
						.getTime()
						- caldateofbirth
								.getTime();
				var calage = Math
						.floor(caldiff
								/ (1000 * 60 * 60 * 24 * 365.25));
				$("#age").val(calage);
			}

		});
	
 </script>