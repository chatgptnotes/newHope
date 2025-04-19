<style>
	.ho:hover{
		cursor: pointer;
		background-color:#C1BA7C;
		}
</style>

<div class="inner_title">
	<h3> &nbsp; <?php echo __('Generic Search', true); ?></h3>
</div>

<?php //echo $this->Form->create(array('id'=>'frmOne'));?>
<table border="0" class="table_format"  cellpadding="0" cellspacing="0" width="100%" >
	<tbody>
		<tr class="row_title">				 
			<td><?php echo __("Search Generic:"); ?></td>										
			<td><?php echo $this->Form->input('generic_name', array('id' => 'generic_name','type'=>'text', 'label'=> false, 'div' => false, 'error' => false,'class'=>'textBoxExpnd')); ?> </td>
			<td></td>
			<td align="right" colspan="2"> <?php echo $this->Form->button(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'submitG'));?>
		 </tr>	
	</tbody>	
</table>	
<?php //echo $this->Form->end(); ?>

<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" style="text-align:center;">
	
	<tr class="row_title">
		<td class="table_cell"><strong><?php echo  __('Product Name', true) ; ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Product Code', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Pack', true); ?></strong></td>
		<td class="table_cell"><strong><?php echo __('Stock (MSU)', true); ?></strong></td>
	</tr>
	
	<?php if(count($PharmacyData) > 0){ $count = 0; ?>
	<?php foreach($PharmacyData as $data) {$count++; ?>
	<?php if($count%2==0){
			$class = "ho"; 
		} else {
			$class = "row_gray ho"; 
		} ?>
	<tr class="<?php echo $class; ?>" onclick="return getProduct(<?php echo $data['PharmacyItem']['id']; ?>)">
		<td class="table_cell">
			<?php echo $data['PharmacyItem']['name'] ; ?>
		</td>
		<td class="table_cell">
			<?php echo $data['PharmacyItem']['item_code']; ?>
		</td>
		<td class="table_cell">
			<?php echo $pack = $data['PharmacyItem']['pack'] ?>
		</td>
		<td class="table_cell">
			<?php echo ((int)$pack * $data['PharmacyItem']['stock'])+ $data['PharmacyItem']['loose_stock'];?>
		</td>
	</tr>
	<?php } //end of foreach?>
	<?php }else { ?>
	<tr>
		<td colspan="10" align="center"><?php echo __('No record found', true); ?>.</td>
	</tr>
	<?php } ?>
</table>

 <script>
 	$(document).ready(function(){
 		$("#generic_name").autocomplete({
			source: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "generic_item",'name',"inventory" =>true,"plugin"=>false)); ?>",
			 minLength: 1,
			 select: function( event, ui ) {
				console.log(ui.item);
			 },
			 messages: {
		        noResults: '',
		        results: function() {}
			 }		
		});
 	});

 	function getProduct(id){
 	 	var fieldNo = '<?php echo $field_number; ?>';
		 setInformation(id,fieldNo);		//productId
         //parent.$.fancybox.close();
	}
	$('#submitG').click(function(){
		var fData='<?php echo $field_number?>';
		var ajaxUrl = '<?php echo $this->Html->url(array("controller"=>"Pharmacy","action" => "generic_search_new", 'inventory' => true)); ?>';
        $.ajax({
            beforeSend : function() {},
            type: 'POST',
            url: ajaxUrl,
            dataType: 'html',
            data:{val:$('#generic_name').val(),fData:fData},
            success: function(data){
                $("#TreatmentAdvised").html('TreatmentAdvised');
                if(data!=''){
                    $('#genericCode').html(data);
                }
            },
            error:function(data){},
        });
	});
	function loadDataFromRate(itemID,selectedId){ 
        var currentField = selectedId.split("-"); 
        var fieldno = currentField[1];
       // loading(fieldno);
        $("#expiry_date"+fieldno).val("");
        $("#stockQty"+fieldno).val("");
        $("#looseStockQty"+fieldno).val("");
        $("#mrp"+fieldno).val("");
        $("#vat_class_name"+fieldno).val("");
        $("#vat"+fieldno).val(""); 
        $("#rate"+fieldno).val("");
        $("#value"+fieldno).val("");
        $("#pack"+fieldno).val("");
        $("#qty_"+fieldno).val("");
        var tariff = $("#tariff_id").val();
        var room = $("#roomType").val(); 

        /*******************************/
 	
        var batchesArray = new Array();
        var batchesIDArray = new Array();
	
        $(".itemId").each(function(){
            if(itemID === $(this).val()){
                var fieldCount = $(this).attr('fieldNo'); 	//current fieldno of loop
                var batchNO = $("#batch_number"+fieldCount+" option:selected").text(); 
                var batchID = $("#batch_number"+fieldCount).val();
                batchesArray.push(batchNO);
                batchesIDArray.push(batchID);
            }
        });
 
        /********************************/
        $.ajax({
            type: "POST",
            url: "<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "fetch_rate_for_item", 'item_id', 'true', "inventory" => true, "plugin" => false)); ?>",
            data: "item_id="+itemID+"&tariff="+tariff+"&roomType="+room+"&batch_number="+batchesArray
        }).done(function( msg ) {
            var item = jQuery.parseJSON(msg);  
            var pack = parseInt(item.PharmacyItem.pack);
            console.log(item);
            $("#item_"+fieldno).val(item.PharmacyItem.name);
            var total=parseInt(item.PharmacyItem.pack)*(parseInt(item.PharmacyItem.stock)+parseInt(item.PharmacyItem.loose_stock));
            $("#stock_"+fieldno).html(total);
            $("#dispMrp_"+fieldno).html(item.PharmacyItemRate.mrp);
            $("#itemId_"+fieldno).val(item.PharmacyItem.id);
            $("#itemWiseDiscount"+fieldno).val(item.PharmacyItem.discount);
 
            if( item.PharmacyItem.discount != null ||  item.PharmacyItem.discount > 0 ){
                showDisc = "&nbsp;("+item.PharmacyItem.discount+"%)";
            }else{
                showDisc = '';
            }
			
            $("#displayDiscPer"+fieldno).html(showDisc);
            $("#item_code-"+fieldno).val(item.PharmacyItem.item_code);
            $("#pack"+fieldno).val(item.PharmacyItem.pack);
            $("#showPack_"+fieldno).html(item.PharmacyItem.pack);
            
            $("#doseForm"+fieldno).val(item.PharmacyItem.doseForm);
            $("#genericName"+fieldno).val(item.PharmacyItem.generic);
            batches= item.PharmacyItemRate; 

            var batches = item.batches;
            $("#batch_number"+fieldno+" option").remove(); 
            if(batches!='' && batches!=null){ 
                var totalBatches = 0;
                $.each(batches, function(index, value) { 
                    $("#batch_number"+fieldno).append( "<option value='"+index+"'>"+value+"</option>" );
                    totalBatches++;
                }) ;

                var totalRemovedBatches = 0;
                $.each(batchesIDArray, function(key, batchId) { 
                    $("#batch_number"+fieldno+" option[value='"+batchId+"']").remove(); 
                    totalRemovedBatches++;
                }); 

                if(totalBatches != totalRemovedBatches){
                    var stock = parseInt(item.PharmacyItemRate.stock!="" ? item.PharmacyItemRate.stock : 0);
                    var looseStock = parseInt(item.PharmacyItemRate.loose_stock!="" ? item.PharmacyItemRate.loose_stock:0);
                    var myStock = (stock * pack) + looseStock;
                    if(myStock > 0){
                        $("#expiry_date"+fieldno).val(item.PharmacyItemRate.expiry_date);
                        $("#stockWithLoose_"+fieldno).val(myStock);	
                        $("#showStock_"+fieldno).html(myStock); 
                        $("#stockQty"+fieldno).val(item.PharmacyItemRate.stock);
                        $("#looseStockQty"+fieldno).val(item.PharmacyItemRate.loose_stock);
                        $("#mrp"+fieldno).val(item.PharmacyItemRate.mrp);
                        $("#showMrp_"+fieldno).html(parseFloat(item.PharmacyItemRate.mrp).toFixed(2));
                        $("#vat_class_name"+fieldno).val(item.PharmacyItemRate.vat_class_name);
                        $("#vat"+fieldno).val(item.PharmacyItemRate.vat_sat_sum); 
                        $("#rate"+fieldno).val(item.PharmacyItemRate.sale_price);
                        $("#showRate_"+fieldno).html(parseFloat(item.PharmacyItemRate.sale_price).toFixed(2));
                    }else{
                        alert("Sorry, no stock available in this batch..!!");
                    }
                }else{
                    alert("Sorry, no stock available in another batche for this product..!!");
                }
            }else{
                alert("Sorry, no stock available in any batches..!!");
            }
            var itemrateid=$("#batch_number"+fieldno).val();
            var editUrl  = "<?php echo $this->Html->url(array('controller' => 'pharmacy', 'action' => 'edit_item_rate', 'inventory' => false)) ?>";
            $("#viewDetail"+fieldno).attr('href',editUrl+'/'+'?type=edit&itemId='+itemID+'&item_rate_id='+itemrateid+'&'+'popup=true');
            $("#qty_"+fieldno).attr('readonly',false);
            $("#qty_"+fieldno).focus();
            //onCompleteRequest(fieldno);
            $('#genericCode').html('');
        });
        selectedId='';
    }
    function setInformation(productId,fieldNo){	//this function will be called from fancy page of inventory_generic_search
          var selectedId = "item_name-"+fieldNo;
          loadDataFromRate(productId,selectedId);
    }
 </script>

