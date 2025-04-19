  <div style="padding:10px">
<style>
.tdLabel2{
font-size:12px;
}
</style>

<?php
 echo $this->Html->script('jquery.autocomplete_pharmacy');
  echo $this->Html->css('jquery.autocomplete.css');
  

?>
                  <div class="inner_title">
                    	<h3>Purchase Return View</h3>
                  </div>
                  <div class="clr ht5"></div>
				  <input type="hidden" value="1" id="no_of_fields"/>
				
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                  	<tr>
                   	  	<td width="45" class="tdLabel2">Vr. No.</td>
                        <td width="80" class="tdLabel2"><input name="InventoryPurchaseDetail[vr_no]" type="text" class="textBoxExpnd validate[required]" id="vr_no" tabindex="1" value=""/></td>
                        <td width="10">&nbsp;</td>
                        <td width="45" class="tdLabel2">Vr. Dt.</td>
                        <td width="140" class="tdLabel2"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width=""><input name="InventoryPurchaseDetail[vr_date]" type="text" class="textBoxExpnd date validate[required]" id="vr_date" tabindex="2" value="" style="width:75%;" readonly="true"/></td>
                          
                          </tr>
                        </table>
                        </td>
                        <td width="50">&nbsp;</td>
                        <td width="75" class="tdLabel2">Party Code</td>
                        <td width="50" class="tdLabel2"><input name="InventoryPurchaseDetail[party_code]" type="text" class="textBoxExpnd" id="party_code" tabindex="3" value="" readonly="true"/></td>
                        <td width="50">&nbsp;</td>
                        <td width="80" class="tdLabel2">Party Name</td>
                        <td width="120" class="tdLabel2"><input name="InventoryPurchaseDetail[party_name]" type="text" class="textBoxExpnd  validate[required]" id="party_name" tabindex="4" value="" style="width:80%" readonly="true"/></td>
					
                        <td width="30">&nbsp;</td>
                        <td width="50" class="tdLabel2">Bill No.</td>
                        <td width="80" class="tdLabel2"><input name="InventoryPurchaseDetail[bill_no]" type="text" class="textBoxExpnd validate[required]" id="bill_no" tabindex="5" value=""/></td>
                        <td>&nbsp;</td>
                    </tr>
                  </table>
                  <div class="clr ht5"></div> 
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="item-row">
                  	<tr>
               	  	  	  <th width="40" align="center" valign="top"  style="text-align:center;">Sr. No.</th>
                          <th width="" align="center" valign="top"  style="text-align:center;">Date</th>
                          <th width="60" align="center" valign="top"  style="text-align:center;">Total</th>
                         
                     	</tr>
                        <tr id="initialRow">
                         
                     </tr>
                   </table>
                   <div class="clr ht5"></div>
				    
                  
				
                        
<p class="ht5"></p>
                <div align="right">
				  				   <?php 
   echo $this->Html->link(__('Back'), array('action' => 'index' ,'inventory'=>true), array('escape' => false,'class'=>'blueBtn'));
   ?>
				  </div>       
                  
                    <!-- Right Part Template ends here -->                </td>
            </table>
            <!-- Left Part Template Ends here -->
            
          </div>          
        </td>
        <td width="5%">&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
        <td class="footStrp">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>

<script>
 $('#vr_no').live('focus',function()
			  { 
			    $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_details",'true','vr_no',"inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			autoFill:true
		}
	);
}); 
 $('#bill_no').live('focus',function()
			  { 
			    $(this).autocomplete(
		"<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_details",'true','bill_no',"inventory" => true,"plugin"=>false)); ?>",
		{
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			autoFill:true
		}
	);
}); 	

	/* for auto populate the data */
function selectItem(li) {
	if( li == null ) return alert("No match!");
		var itemID = li.extra[0];
		loadData(itemID);
}		
 
function loadData(itemID){
		$.ajax({
		  type: "POST",
		  url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_details","inventory" => true,"plugin"=>false)); ?>",
		  data: "id="+itemID,
		}).done(function( msg ) {
		 	var details = jQuery.parseJSON(msg);
			
			
				showItemDisplay(details)
			
			});
			
	
}

function showItemDisplay(itemsDetails){
	 var number_of_field = 1;
	 var itemDetail ='';
	 var total =0;
	$.each(itemsDetails.InventoryPurchaseReturn, function() {
	 	
		 if($("#row'+number_of_field+'")){
				$("#row"+number_of_field).remove();
			}
		 var field = '';
		
		 field += "<tr id='row"+number_of_field+"' style='cursor:pointer;'><td align='center' valign='middle' class='sr_number'>"+number_of_field+"</td>";
		 field += '<td align="center" valign="middle">'+this.create_time+'</td>'; 
		 field += '<td align="center" valign="middle">'+this.total_amount+'</td>'; 
		   field += '<td align="center" valign="middle"><a href="<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "purchase_return_item_details","inventory" => true,"plugin"=>false)); ?>/'+this.id+'"><img src="../../../../img/icons/view-icon.png"/></a></td>';
	     field += '</tr>';
	  		
		   
		$('#initialRow').remove();
		$("#item-row").append(field);
		number_of_field = number_of_field+1;
		
	 });
	$("#row"+number_of_field).click(function(){
			window.location.href=url;
	
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