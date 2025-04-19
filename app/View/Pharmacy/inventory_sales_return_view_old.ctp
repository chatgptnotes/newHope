 <div style="padding:10px">
 <div class="inner_title">
   <h3>Sales Return View</h3>
 </div>

<?php
 echo $this->Html->script(array('jquery-1.5.1.min','validationEngine.jquery',
     	 			'jquery.validationEngine','/js/languages/jquery.validationEngine-en','jquery-ui-1.8.16.custom.min','jquery.ui.widget.js','jquery.ui.mouse.js','jquery.ui.core.js','ui.datetimepicker.3.js','permission.js'));
	echo $this->Html->css(array('datePicker.css','jquery-ui-1.8.16.custom','validationEngine.jquery.css','jquery.ui.all.css','internal_style.css'));
				
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
?>
<style>
.tdLabel2{
font-size:12px;
}
</style>
<?php echo $this->Form->create('InventoryPharmacySalesReturn');?>
   <div class="clr ht5"></div>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  	<tr>
               			 <td width="10">&nbsp;</td>
                        <td width="150" class="tdLabel2">Party Code (Customer)</td>
                        <td width="200" class="tdLabel2"><input name="party_code" type="text" class="textBoxExpnd validate[required]" id="party_code" tabindex="3" value=""/></td>
                        <td width="10">&nbsp;</td>
                        <td width="150" class="tdLabel2">Party Name(Customer)</td>
                        <td width="200" class="tdLabel2"><input name="party_name" class="textBoxExpnd validate[required]" type="text" class="party_name" id="party_name" tabindex="4" value="" readonly='true'/></td>
                        <!--<td width="50">&nbsp;</td>
                        <td width="45" class="tdLabel2">Cash Credit</td>
                        <td width="80" class="tdLabel2"><input name="textfield6" type="text" class="textBoxExpnd validate[required]" id="textfield6" tabindex="5" value="" readonly='true'/></td>-->
                        <td width="10">&nbsp;</td>
                        <td width="50" class="tdLabel2">Bill No.</td>
                        <td width="120" class="tdLabel2"><input name="bill_no" type="text" class="textBoxExpnd validate[required]" id="bill_no" tabindex="5" value=""/></td>
						<input type="hidden" name="InventoryPharmacySalesReturn[pharmacy_sales_bill_id]" id ="pharmacy_sales_bill_id"/>
                        <td>&nbsp;</td>
                    </tr>
					<tr>
						  <td width="10">&nbsp;</td>
                        <td width="150" class="tdLabel2">Dr. Name: <span id="doctorNameLable"></span></td>
                        
					 </tr>
                  </table>
                  <div class="clr ht5"></div> 
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="billDetailTable">
                  	<tr>
               	  	  	  <th width="40" align="center" valign="top"  style="text-align:center;">Sr. No.</th>
                          <th width="100" align="center" valign="top"  style="text-align:center;">Date</th>
                          <th width="" align="center" valign="top"  style="text-align:center;">Total</th>
                         
                     	</tr>
                        
                   </table>
                   <div class="clr ht5"></div>
                      
                   
                  </div> 
				  <div align="right">
				  				   <?php 
   echo $this->Html->link(__('Back'), array('action' => 'index' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
   ?>
				  </div>  
	 <?php echo $this->Form->end();?>     
<script>
 

$("#bill_no").live('focus',function()
			  { 
			  var t = $(this);
			 $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_bill","bill_code","inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:function (data1) {			
				selectItem(data1);
			},
			autoFill:true
		}
	);
			
});

function selectItem(li,selectedId) {
	if( li == null ) return alert("No match!");
		var billId = li.extra[0];
		loadDataFromRate(billId);
	
}	
/* load the data from supplier master */
function loadDataFromRate(billId){
	
	$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_sales_details","inventory" => true,"plugin"=>false)); ?>",
		  data: "billId="+billId,
		}).done(function( msg ) {
		 	var bill = jQuery.parseJSON(msg);
			$("#party_name").val(bill.Person.first_name);
			$("#party_code").val(bill.Person.patient_uid);
			$("#doctorNameLable").html(bill.DoctorProfile.doctor_name);
			$("#pharmacy_sales_bill_id").val(bill.PharmacySalesBill.id);
			$(".tax").show();
			$("#tax").val(bill.PharmacySalesBill.tax);
			loadBillItem(bill.InventoryPharmacySalesReturn);
		
	});
	}
	/* load the data from Bill PharmacySalesBillDetail */
function loadBillItem(billItem){
	 var number_of_field = 1;
	 var itemDetail ='';
	 var total =0;
	 $.each(billItem, function() {
	 	//	itemDetail = getItemDetail(this.item_id);
			  var field = '';
		   field += '<tr id="row'+number_of_field+'"><td align="center" valign="middle" class="sr_number">'+number_of_field+'</td>';
		     field += '<td align="center" valign="middle">'+this.create_time+'</td>';
			 
           field += '<td align="center" valign="middle">'+this.total+'</td>';
		   
		
           field += '<td align="center" valign="middle"><a href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "sales_return_detail","inventory" => true,"plugin"=>false)); ?>/'+this.id+'"><img src="../../../../img/icons/view-icon.png"/></a></td>';
           
            field += '</tr>';
		
     	$("#billDetailTable").append(field);
		number_of_field = number_of_field+1;
	 });
	
	
	}
	
 /* get the Item details*/
 function getItemDetail(itemId){
	 var res = '';
 $.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "view_item","inventory" => true,"plugin"=>false)); ?>",
		  async:false,
		  data: "item_id="+itemId,
		}).done(function( msg ) {
			res =  jQuery.parseJSON(msg);
			
	});
	return res;
 }
 
</script>      
 </div>  