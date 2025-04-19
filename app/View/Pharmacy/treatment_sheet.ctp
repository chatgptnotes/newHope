<style>
    section{
        font-family: "trebuchet MS","Lucida sans",Arial;
    }
 ul.dateListing {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 100%;
    background-color: #f1f1f1; 
}

 li.dateList a {
    display: block;
    color: #000 !important;
    padding: 4px 0 4px 8px;
    text-decoration: none;  
}
  
li.dateList a:hover, li.active a {
    background-color: #555;
    color: white !important;
    text-decoration: none;
}

.left-menu {  
    width: 100px; 
    outline: 1px solid; 
    height:500px;
    overflow-y: auto;
    float: left; 
    padding-top: 5px;
    -moz-outline-radius:10px;
    -webkit-outline-radius:10px;
    outline-radius:10px;
}
.right { 
    outline: 1px solid;
    -moz-outline-radius:10px;
    -webkit-outline-radius:10px;
    outline-radius:10px;
    padding: 5px;
}
</style> 
<?php $dosage = Configure :: read("route_administration"); ?>
<div class="inner_title">
    <h3>
        <?php echo __("Treatment Sheet"); ?>
    </h3>  
</div>
<section style="width: 100%; margin: 0 auto;">
    <?php echo $this->Form->create('',array('url'=>array('action'=>'treatmentSheet'),'onkeypress'=>"return event.keyCode != 13;",'type'=>'post','id'=>'patientSearch')); ?>
    <table>
        <tr>
            <td>Select Patient : </td>
            <td><?php echo $this->Form->input('lookup_name',array('type'=>'text','value'=>$patientData['Patient']['lookup_name'],'div'=>false,'label'=>false,'id'=>'lookup_name')); 
                    echo $this->Form->hidden('patient_id',array('value'=>$patientData['Patient']['id'],'id'=>'patientId')); ?></td>
            <td><?php //echo $this->Form->submit(__('Search'),array('class'=>'blueBtn')); ?>
            <?php echo '&nbsp;'.$this->Html->image('icons/user_info.png',array('id'=>'userInfo','title'=>'Search','alt'=>'Search','id'=>'searchBtn','style'=>'float:none; height: 30px; width: 30px;')); ?></td>
        </tr>
    </table>
    <?php echo $this->Form->end(); ?>
    <table width="100%">
        <tr>
            <td width="7%" valign="top" style="">
                 <div class="left-menu" style="clear: both;">
                    <ul class="dateListing">
                    <?php if(!empty($dateListing)){
                        $activeDate = $this->params['pass']['1'];
                        foreach($dateListing as $key => $val){ 
                            $cls = '';  
                            if(trim($activeDate)==trim($key)){ 
                                $cls = " active";
                            }
                            echo "<li class='dateList".$cls."' id='dateList_".$key."'><a href='javascript:void(0);'>".$val."</a></li>";
                        }
                    } ?>
                    </ul>
                </div>
            </td>
            <td width="1%"></td>
            <td width="92%" valign="top" id="content-list" class="right">
                <div id="treatSheet">
                <?php if(!empty($activeDate)) { ?>
                    <?php echo $this->Form->create('TreatmentMedicationDetail',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'treatMentSheet')); ?>
                    <table width="100%" class="tabularForm">
                        <thead>
                            <tr>
                                <td align="left" width="2%"><?php echo __("#"); ?></td>
                                <td align="left" width="30%"><?php echo __("Drug Name"); ?><font color="red">*</font></td>
                                <td align="center" width="10%"><?php echo __("Dosage"); ?></td> 
                                <td align="center" width="15%"><?php echo __("Route"); ?></td>
                                <td align="right" width="10%"><?php echo __("Qty"); ?><font color="red">*</font></td> 
                                <td align="right" width="10%"><?php echo __("Stock"); ?></td>  
                                <td align="right" width="10%"><?php echo __("MRP"); ?></td> 
                                <td align="right" width="10%"><?php echo __("Amount"); ?></td>  
                                <td align="left" width="5%">#</td> 
                            </tr>
                        </thead>
                        <tbody id="prescribeTable">
                            <tr class="row" id="row_1">
                                <td><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'name'=>"data[TreatmentMedicationDetail][1][is_show]",'title'=>'check to show in treatment sheet','hiddenField'=>false,'value'=>'0','onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }")); ?></td>
                                <td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false,'class'=>'item validate[required,custom[mandatory-enter]]','id'=>'item_1','name'=>"data[TreatmentMedicationDetail][1][item_name]",'style'=>'width:100%')); 
                                          echo $this->Form->hidden('',array('id'=>'itemId_1','class'=>'item_id','value'=>'','name'=>"data[TreatmentMedicationDetail][1][item_id]"));
                                          echo $this->Form->hidden('',array('id'=>'batch_1','class'=>'batch_number','value'=>'','name'=>"data[TreatmentMedicationDetail][1][batch_number]"));
                                          echo $this->Form->hidden('',array('id'=>'expiry_1','class'=>'expiry','value'=>'','name'=>"data[TreatmentMedicationDetail][1][expiry_date]"));
                                          echo $this->Form->hidden('',array('id'=>'mrp_1','class'=>'mrp','value'=>'','name'=>"data[TreatmentMedicationDetail][1][mrp]"));
                                          echo $this->Form->hidden('',array('id'=>'pack_1','class'=>'pack','value'=>'','name'=>"data[TreatmentMedicationDetail][1][pack]")); ?></td> 
                                <td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false,'class'=>'routes','id'=>'routes_1','name'=>"data[TreatmentMedicationDetail][1][routes]",'style'=>'width:100%')); ?></td> 
                                <td><?php echo $this->Form->input('',array('type'=>'select','div'=>false,'label'=>false,'class'=>'dosage','id'=>'dosage_1','name'=>"data[TreatmentMedicationDetail][1][dosage]",'style'=>'width:100%','empty'=>'Select','options'=>Configure :: read('route_administration'))); ?></td>  
                                <td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false,'class'=>'quantity validate[required,custom[mandatory-enter]]','id'=>'quantity_1','name'=>"data[TreatmentMedicationDetail][1][quantity]",'style'=>'width:100%')); ?></td> 
                                <td align="right" class="stock" id="stock_1"></td> 
                                <td align="right" class="dispMrp" id="dispMrp_1"></td> 
                                <td align="right" class="amount" id="amount_1"></td> 
                                <td><?php echo $this->Html->link($this->Html->image("/img/icons/cross.png",array("align"=>"right","title"=>"Remove","alt"=>"Remove","class"=>"icd_eraser")),"javascript:void(0);",array('class'=>'removeBtn','id'=>'removeBtn_1','escape'=>false)); ?></td> 
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="7" align="right">
                                    <?php echo __('Total'); ?>
                                </td>
                                <td id="total_amount" align="right"></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td colspan="9" align="left">
                                    <div style="float: left;"><input type="button" id="addButton" value="Add Row"></div>
                                    <div style="float: right;"><input type="submit" id="submitBtn" value="Submit"></div>
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                    <?php echo $this->Form->end(); ?>
                <?php } ?>
                </div>
                <table width="100%">
                	<tr>
                		<td width="49%" valign="top">
			                <?php if(!empty($treatmentData)){ ?>
			                <?php //foreach($treatmentData as $sKey => $sVal) { ?>
			                    <table width="100%" class="tabularForm" style="margin-top: 15px;">
			                        <caption>Previous Treatment Record</caption>
			                        <thead>
			                            <tr>
			                                <td align="left" width=""><?php echo __("Sr.No"); ?></td>
			                                <td align="left" width=""><?php echo __("Drug Name"); ?></td>
			                                <td align="center" width=""><?php echo __("Dosage"); ?></td> 
			                                <td align="center" width=""><?php echo __("Route"); ?></td>
			                                <td align="center" width=""><?php echo __("Quantity"); ?></td> 
			                            </tr>
			                        </thead>
			                        <tbody>
			                            <?php $cnt =1; foreach ($treatmentData as $key => $value) { ?>
			                            <tr>
			                                <td align="center"><?php echo $cnt++; ?></td>
			                                <td align="left"><?php echo $value['PharmacyItem']['name']; ?></td>
			                                <td align="center"><?php echo $value['TreatmentMedicationDetail']['routes']; ?></td>
			                                <td align="center"><?php echo $dosage[$value['TreatmentMedicationDetail']['dosage']]; ?></td>
			                                <td align="center"><?php echo $value['TreatmentMedicationDetail']['quantity']; ?></td>
			                            </tr>
			                            <?php } ?>
			                            <tr>
			                            	<td colspan="5" align="right">
												<?php echo $this->Form->button(__('Delete Sheet'),array('onclick'=>"deleteTreatmentSheet()",'escape' => false,'title'=>'Delete Sheet')); 
		                            		  	?>
		                            			<?php echo $this->Form->button(__('Print Sheet'),array('onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'print_sheet',$patientData['Patient']['id'],$activeDate/*$value['TreatmentMedication']['id']*/,'inventory'=>false))."', '_blank',
										           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print')); 
		                            		  	?> 
			                            </tr>
			                        </tbody>
			                    </table>
			                <?php }?>
			                <?php //} ?>
               		 	</td>
                		<td width="2%"></td>
                		<td width="49%" valign="top">
                			<?php if(!empty($saleBillData)){ ?>
			                    <table width="100%" class="tabularForm" style="margin-top: 15px;">
			                        <caption>Sales Bill</caption>
			                        <thead>
			                            <tr>
			                                <td align="left" width=""><?php echo __("Sr.No"); ?></td>
			                                <td align="left" width=""><?php echo __("Bill No"); ?></td>
			                                <td align="center" width=""><?php echo __("Mode"); ?></td> 
			                                <td align="center" width=""><?php echo __("Date"); ?></td>
			                                <td align="right" width=""><?php echo __("Amount"); ?></td>
			                                <td align="center" width=""><?php echo __("Action"); ?></td>
			                                <td align="center" width=""><?php echo $this->Form->checkbox('selectAllPresc',array('id'=>'selectAllPresc','div'=>false,'label'=>false)); ?></td> 
			                            </tr>
			                        </thead>
			                        <tbody>
			                            <?php foreach ($saleBillData as $key => $value) { ?>
		                             	<tr>
		                             		<td align="center"><?php echo ++$key; ?></td>
		                             		<td><?php echo $value['PharmacyDuplicateSalesBill']['bill_code']; ?></td>
		                             		<td><?php echo $value['PharmacyDuplicateSalesBill']['payment_mode']; ?></td>
		                             		<td><?php echo $value['PharmacyDuplicateSalesBill']['create_time']; ?></td>
		                             		<td align="right"><?php echo $value['PharmacyDuplicateSalesBill']['total']; ?></td> 
		                             		<td align="center"><?php  echo $this->Html->link($this->Html->image('icons/print.png',array('style'=>'height:20px;width:18px;float:none;')),'javascript:void(0);',
		             array('onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Pharmacy','action'=>'print_view','PharmacyDuplicateSalesBill',$saleId = $value['PharmacyDuplicateSalesBill']['id'],'inventory'=>true))."', '_blank',
			           	'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200')",'escape' => false,'title'=>'Print'));
                                                        echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true), 'alt' => __('Edit', true),'style'=>'float:none;')), "javascript:getSalesDetail($saleId);", array('escape' => false)); 
                                                        ?></td>
		                             		<td><?php echo $this->Form->input('printPresc',array('type'=>'checkBox','hiddenField'=>false,'class'=>'prescriptionPrint',
						'value'=>$value['PharmacyDuplicateSalesBill']['id'],'div'=>false,'label'=>false)); ?></td>
		                             	</tr>
			                            <?php } ?>
			                            <tr>
			                            	<td colspan="7" align="right"><input type="button" id="printPrescription" onclick='viewPrescription();' value="Print Prescription"></td>
			                            </tr>
			                        </tbody>
			                    </table>
			                <?php }?>
                		</td>
                	</tr>
                </table>
            </td>
        </tr>
    </table> 
</section>

<script> 
	function viewPrescription(){
		 var pharmacyDuplicateSalesBillId = new Array;
		 $(".prescriptionPrint").each(function() {
			 if($(this).is(':checked'))
				 pharmacyDuplicateSalesBillId.push($(this).val());
		});
		 var duplicateSalesBill = pharmacyDuplicateSalesBillId.join();
		 if(duplicateSalesBill != '')
			window.open('<?php echo $this->Html->url(array("controller" => "pharmacy", "action" => "viewPrescription",$patientData['Patient']['id'],"inventory"=>false)); ?>/'+duplicateSalesBill+'/PharmacyDuplicateSalesBill',
				'_blank','toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');
		 else
			 alert('Please select sales record.');
	}

	$(document).ready(function(){
		$('#selectAllPresc').click(function(){
			if($(this).is(':checked'))
				$('.prescriptionPrint').prop('checked','checked')
			else
				$('.prescriptionPrint').prop('checked',false)
			});
	 });
	 
         function submitForm(){ 
            $('#searchBtn').trigger('click');
            return false;
        }

    $(document).ready(function(){ 
        $("#lookup_name").autocomplete({
            source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>",
            select: function(event,ui){	
                $("#patientId" ).val(ui.item.id);	
                window.location.href = ("<?php echo $this->Html->url(array('action'=>'treatmentSheet')); ?>"+"/"+$("#patientId").val());		
            },
            messages: {
               noResults: '',
               results: function() {}
           }
       });
       
        $("#searchBtn").click(function(){ 
            window.location.href = ("<?php echo $this->Html->url(array('action'=>'treatmentSheet')); ?>"+"/"+$("#patientId").val());
        });
         
        
        $(".dateList").click(function (event) {
            event.preventDefault();
            $(".dateList").removeClass("active"); 
            $(this).addClass("active"); 
            var id = $(this).attr('id').split("_")[1];  
            window.location.href = ("<?php echo $this->Html->url(array('action'=>'treatmentSheet')); ?>"+"/"+$("#patientId").val()+"/"+id);
            //fetchData(id); 
            blurElement('#content-list',1);
        });
        
//        function fetchData(selectedDate){
//            counter = 1;
//            $.ajax({
//                type : "GET",
//                url: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "getMedication", "inventory" => false)); ?>"+"/"+$("#patientId").val()+"/"+selectedDate, 
//                beforeSend:function(){ 						
//                    $('#busy-indicator').show('fast');
//                }, 	  		  
//                success: function(data){  
//                    $('#content-list').html('');
//                    $('#busy-indicator').hide('fast');
//                    $('#content-list').html(data).fadeIn('slow');
//                    window.location.hash = "date="+selectedDate;
//                }
//            });
//        }
        
    });
    
    var counter = 1; 
    var dosage = $.parseJSON('<?php echo json_encode($dosage); ?>');
    $("#addButton").on('click',function(event){
        event.preventDefault();
        counter = counter+1;
        var field = '';
            field += '<tr id="row_'+counter+'" class="row">';
            field +=    '<td><input type="checkbox" name="data[TreatmentMedicationDetail]['+counter+'][is_show]" title="check to show in treatment sheet" onclick="if(this.checked){ $(this).val(1); }else{ $(this).val(0); }"/></td>';
            field +=    "<td>";
            field +=        '<input type="text" class="item validate[required,custom[mandatory-enter]]" id="item_'+counter+'" name="data[TreatmentMedicationDetail]['+counter+'][item_name]" style="width:100%">';
            field +=        '<input type="hidden" name="data[TreatmentMedicationDetail]['+counter+'][item_id]" class="item_id" id="itemId_'+counter+'" value=""/>'; 
            field +=        '<input type="hidden" name="data[TreatmentMedicationDetail]['+counter+'][expiry_date]" class="expiry" id="expiry_'+counter+'" value=""/>'; 
            field +=        '<input type="hidden" name="data[TreatmentMedicationDetail]['+counter+'][pack]" class="pack" id="pack_'+counter+'" value=""/>'; 
            field +=        '<input type="hidden" name="data[TreatmentMedicationDetail]['+counter+'][batch_number]" class="batch" id="batch_'+counter+'" value=""/>'; 
            field +=        '<input type="hidden" name="data[TreatmentMedicationDetail]['+counter+'][mrp]" class="mrp" id="mrp_'+counter+'" value=""/>'; 
            field +=    "</td>";
            field +=    "<td>";
            field +=        '<input type="text" name="data[TreatmentMedicationDetail]['+counter+'][routes]" class="routes" id="routes_'+counter+'" style="width:100%">';
            field +=    "</td>";
            field +=    "<td>";
            field +=        '<select name="data[TreatmentMedicationDetail]['+counter+'][dosage]" id="dosage_'+counter+'" class="dosage" style="width:100%"></select>';
            field +=    "</td>";
            field +=    "<td>";
            field +=        '<input type="text" name="data[TreatmentMedicationDetail]['+counter+'][quantity]" class="quantity validate[required,custom[mandatory-enter]]" id="quantity_'+counter+'" style="width:100%">';
            field +=    "</td>";
            field +=    '<td align="right" class="stock" id="stock_'+counter+'"></td>';
            field +=    '<td align="right" class="dispMrp" id="dispMrp_'+counter+'"></td>';
            field +=    '<td align="right" class="amount" id="amount_'+counter+'"></td>';
            field += 	'<td><a href="javascript:void(0);" id="removeBtn_'+counter+'" class="removeBtn"><?php echo $this->Html->image("/img/icons/cross.png",array("align"=>"right","title"=>"Remove","alt"=>"Remove","class"=>"icd_eraser")); ?></a></td>';
            field += "</tr>"; 
        $("#prescribeTable").append(field); 
        $("#dosage").remove('options');
        $("#dosage_"+counter).append("<option value=''>Select</option>" );
        $.each(dosage, function(key,value){
            $("#dosage_"+counter).append("<option value='"+key+"'>"+value+"</option>" );
        });
        $("#item_"+counter).focus();
    });
      
    $(document).on('focus',".item",function(event){
        event.preventDefault();
        var id = $(this).attr('id').split("_")[1]; 
        $(this).autocomplete({
         source: "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "newPharmacyComplete","admin" => false,"plugin"=>false)); ?>",
         minLength: 1, 
            select: function( event, ui ) { 
                $("#itemId_"+id).val(ui.item.drug_id);
                $("#stock_"+id).text(ui.item.stock);
                $("#pack_"+id).val(ui.item.pack);
                $("#expiry_"+id).val(ui.item.expiry);
                $("#batch_"+id).val(ui.item.batch);
                $("#mrp_"+id).val(parseFloat(ui.item.mrp).toFixed(2));
                $("#dispMrp_"+id).text(parseFloat(ui.item.mrp).toFixed(2));
                $("#routes_"+id).focus();
            },
            messages: {
                noResults: '',
                results: function() {}
            }
        });
    });
    
    $(document).on('click',".removeBtn",function(){
        var count = 0; 
        $(".item").each(function(key,value){
            count++;
        });
        if(count==1){
            alert("single record could not delete");
            return false;
        }
        var id = $(this).attr('id').split("_")[1];  
        $("#row_"+id).remove();
        getTotal();
    });
	
        
    $(document).on('keyup',".quantity",function(e){
        if(/[^0-9]/g.test(this.value)){ this.value = this.value.replace(/[^0-9]/g,''); }
        var id = $(this).attr('id').split("_")[1];
        var quantity = parseInt($(this).val()!=''?$(this).val():0);
        var mrp = parseFloat($("#mrp_"+id).val()?$("#mrp_"+id).val():0);
        var total = parseFloat(quantity * mrp);
        $("#amount_"+id).text(total.toFixed(2)); 
        getTotal();
        if(e.keyCode == 13){
            $("#addButton").trigger('click');
        }
    });
    
    function getTotal(){
        var totalAmount = 0;
        $(".amount").each(function(){
            totalAmount += parseFloat($(this).text()!=''?$(this).text():0);
        });
        $("#total_amount").text(totalAmount.toFixed(2));
    }
    
    $(document).on('change',".dosage",function(){
        var id = $(this).attr('id').split("_")[1];
        console.log(id);
        $("#quantity_"+id).focus();
    });

    $("#submitBtn").click(function(){ 
		var valid=jQuery("#treatMentSheet").validationEngine('validate'); 
		if(valid){
		  $("#submitBtn").hide();
		  $('#busy-indicator').show();
		}else{
		  return false;
		}
        blurElement('#content-list',1);
    });
    
    //to blur the content by swapnil on 10.09.2015
    function blurElement(element, size){
    var filterVal = 'blur('+size+'px)';
    $(element)
      .css('filter',filterVal)
      .css('webkitFilter',filterVal)
      .css('mozFilter',filterVal)
      .css('oFilter',filterVal)
      .css('msFilter',filterVal);
    } 
	
	function deleteTreatmentSheet(){
		var selectedDate = "<?php echo $this->params['pass']['1']; ?>";
		var result = confirm("Are you sure to delete the treatment sheet?");
		if(result == true){
			$.ajax({
               type : "GET",
               url: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "deleteTreatmentSheet", "inventory" => false)); ?>"+"/"+$("#patientId").val()+"/"+selectedDate, 
               beforeSend:function(){ 				 
				   blurElement('#content-list',1);
               }, 	  		  
               success: function(data){    
					if(data==="true"){
						blurElement('#content-list',1);
						window.location.reload();
					}else{
					    alert("something went wrong, please try again!");
						blurElement('#content-list',1);
					}
               }
           });
		}else{
			console.log("noo");
			return false;
		}
	}
        
        function getSalesDetail(salesId){
             $.ajax({ 
                url: "<?php echo $this->Html->url(array("controller" => "Pharmacy", "action" => "editTreatmentSheetAjax", "inventory" => false)); ?>"+"/"+salesId, 
                beforeSend:function(){ 						
                    $('#busy-indicator').show('fast');
                }, 	  		  
                success: function(data){   
                    $('#busy-indicator').hide('fast');
                    $('#treatSheet').html(data).fadeIn('slow');  
                }
            });
        }
</script>