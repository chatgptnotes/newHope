<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css'/*,'jquery.autocomplete.css'*/));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js'/*,'jquery.autocomplete.js'*/)); ?>
<style>	
	.tableFoot{font-size:11px; color:#b0b9ba;}
	.tabularForm td td{padding:0;}

	textarea
	{
		width: 78px;
	}
	
	.inner_title span 
	{
    	margin: -33px 0 0 !important;
 	}
 	.inner_menu
 	{
		padding: 10px 0px;
	}
        tr .selectedRowColor  td{
            background: #C1BA7C;
        }
</style>
<?php  //echo $this->element("reports_menu");?>
 <div class="inner_title"> 
 	<h3>&nbsp; RGJAY Payment Received Report</h3> 
    <div style="float:right;">
				<span style="float:right;">
					<?php
						echo $this->Form->create('Corporates',array('action'=>'admin_rgjayreport_xls', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm','style'=> 'float:left;'));
				       echo $this->Html->link('Back',array("controller"=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
						echo $this->Form->submit(__('Generate Excel Report'),array('style'=>'padding:0px;','class'=>'blueBtn','div'=>false,'label'=>false));
						echo $this->Form->end();
					?>
				</span>
	</div>
	<div class="clr"></div>
 	 </div> 	<!--<td align="right">
				<?php
					echo $this->Form->create('Corporates',array('action'=>'admin_rgjayreport_xls', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
					echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:center;')); 
					echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
			        echo $this->Form->end(); 
				?>
			</td>-->


<div class="inner_menu">
    <?php echo $this->Form->create('',array('type'=>'get','url'=>array('action'=>'rgjay_payment_received_report','admin'=>true))); ?>
 	<table cellpadding="0" cellspacing="0" border="0"  align="left">
		<tr>
                    <td style="padding-left: 50px">									  
		    	<?php
                            echo __("Patient Name : ") . "&nbsp;" . $this->Form->input('lookup_name', array('id' => 'lookup_name', 'label' => false, 'div' => false,
                    'value' => !empty($this->params->query['lookup_name']) ? $this->params->query['lookup_name'] : '', 'error' => false, 'autocomplete' => false, 'class' => 'name'));
                echo $this->Form->hidden('patient_id', array('value' => !empty($this->params->query['patient_id']) ? $this->params->query['patient_id'] : '', 'id' => 'patient_id'));
		    	?>  
                        <?php 
                                echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
                        ?> 
                    </td>
                    <td>
                        <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png', array('style' => 'height:20px;width:18px;')), array('controller' => 'Corporates', 'action' => 'rgjay_payment_received_report', 'admin' => true), array('id' => 'refresh', 'class' => 'refresh', 'escape' => false, 'title' => 'Refresh'));
                       ?>
                   </td>

		</tr>
    </table>
    <?php echo $this->Form->end(); ?>
</div>

<div class="clr">&nbsp;</div>
<div id="container">                
<div class="clr ht5"></div>
<div class="inner_title"></div> 
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm top-header">
      <tr>
        <thead>
            <th width="" valign="top" align="center" style="text-align:center;">#</th>
            <th width="" valign="top" align="center" style="text-align:center;">Set</th>
            <th width="" valign="top" align="center" style="text-align:center;">Patient Name</th>
            <th width="" valign="top" align="center" style="text-align:center;">Case No.</th>
            <th width="" valign="top" align="center" style="text-align:center;">Hospital No.</th>
            <th width="" valign="top" align="center" style="text-align:center;">Admission Date</th>
            <th width="" valign="top" align="center" style="text-align:center;">Package Amount</th>
            <th width="" valign="top" align="center" style="text-align:center;">Bank</th>
            <th width="" valign="top" align="center" style="text-align:center;">Amount Received</th>
            <th width="" valign="top" align="center" style="text-align:center;">Advance Received</th>
            <th width="" valign="top" align="center" style="text-align:center;">TDS</th>
            <th width="" valign="top" align="center" style="text-align:center;">Other Deduction</th>
            <th width="" valign="top" align="center" style="text-align:center;">Amount Received Date</th>
            <th width="" valign="top" align="center" style="text-align:center;">Remark</th>
            <th width="" valign="top" align="center" style="text-align:center;">Action</th>
         </thead>
    </tr>   	
          <?php
                  $i=0;
                  foreach($results as $result)
                  {	
                      $patient_id = $result['Patient']['id'];
                      $bill_id = $result['FinalBilling']['id'];
                          $i++;
                          ?>
                  <tr  id="row_<?php echo $patient_id; ?>" class="rowselected">
                          <td width="" align="center" style="text-align:center; min-width:21px;">
                                  <?php echo $i; ?>
                          </td>
                        <td width="" align="center" style="text-align:center;">
                            <?php
                                echo $this->Form->input('', array('type' => 'checkbox', 'div' => false, 'label' => false, 'class' => 'isSettled', 'id' => 'isSettled_' . $bill_id, 'patient_id' => $patient_id));
                            ?>
                        </td>
                          <td width="" >
                                  <?php echo $result['Patient']['lookup_name'];?>
                          </td>

                          <td width="" align="center" style="text-align:center; min-width:80px;">
                                  <?php echo $result['Patient']['case_no'];?>
                          </td>

                          <td width="" align="center" style="text-align:center; min-width:80px;">
                                  <?php echo $result['Patient']['hospital_no'];?>
                          </td>

                          <td width="" align="center" style="text-align:center; min-width:80px;">
                                  <?php echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format'));?>
                          </td>

                          <td width="" align="center" style="text-align:center; min-width:80px;">
                            <?php 
                                //echo $result['FinalBilling']['package_amount']; 
                                echo $this->Form->hidden('patientId',array('id'=>'patient_'.$bill_id,'value'=>$patient_id,'class'=>'patient_id'));
                                $hospitalInvoice = $packageAmount[$patient_id];
                                echo $this->Form->input('cmp_amt_paid', array('readonly'=>'readonly','id'=>'amt_'.$bill_id,'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'cmp_amt_paid','value'=>$hospitalInvoice)); 		
                        
                             ?>
                          </td>
                          <td width=""  align="center"style="text-align: center;">
                            <?php echo  $this->Form->input('bank',array('id'=>"bank_".$bill_id,'type' => 'select','autocomplete'=>false,'label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'bank','value'=>'','empty'=>'Please Select','options'=>$banks));
                                 ?>
                        </td>
                        <td width="" align="center" style="text-align: center;"> 
                     <?php 
                        echo  $this->Form->input('package_amount',array('id'=>"package_".$bill_id,'autocomplete'=>'off','type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'add_package_amount','value'=>'','patient_id'=>$patient_id));
                    ?> 
                </td>
                        <td width="" align="center" style="text-align: center;">
                    <?php
                        $advRecevied = $totalPaid[$patient_id] + $result['FinalBilling']['tds'] + $result['FinalBilling']['discount'];
                        echo $this->Form->hidden('advanced_received',array('class'=>'adv_rec','id'=>"advR_".$bill_id,'value'=>$advRecevied));
                        echo $this->Number->currency(ceil($advRecevied));          //advance recevied
                     ?> 
                </td>
                
                <td width="" align="center"  style="text-align: center;">
                    <?php                             // TDS
		 	 echo $this->Form->input('tds', array('id'=>'tds_'.$bill_id,'type' => 'text','autocomplete'=>false,'label'=>false ,'div'=>false,'style'=>"width: 100%;",'class'=>'add_tds','value'=>''));
		 	 $tdsAmnt=$result['FinalBilling']['tds']; 
                    ?> 
                </td>
                
                <td width="" align="center" style="text-align: center;">
                    <?php
                        echo $this->Form->input(' ', array('id'=>'otherDeduction_'.$bill_id,'autocomplete'=>false,'type' => 'text','label'=>false ,
                      'div'=>false,'style'=>"width: 100%;",'class'=>'add_other_deduction','value'=>$result['FinalBilling']['other_deduction']));
                      ?>
                </td> 
                <td width="" align="center" style="text-align: center;">
                    <?php
                        echo $this->Form->input(' ', array('id'=>'cmp_paid_date_'.$bill_id,'autocomplete'=>false,'type' => 'text','label'=>false ,
                      'div'=>false,'style'=>"width: 70%;",'class'=>'cmp_paid_date textBoxExpnd','value'=>''));
                      ?>
                </td>
<!--                          <td width="80" align="center" style="text-align:center; min-width:80px;">
                                  <?php echo $result['FinalBilling']['amount_paid'];?>
                          </td>

                          <td width="80" align="center" style="text-align:center; min-width:80px;">
                                  <table cellpadding="0" cellspacing="0">
                          <td>
                          <?php
                          echo $this->Form->input('tds', array('id'=>'tds'.$result['FinalBilling']['id'],'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_tds','value'=>$result['FinalBilling']['tds']));
                          ?>
                          </td>

                          <td>
                          <span id="<?php echo $result['Patient']['id']; ?>" >
                                  <?php echo $this->Html->image('icons/save.png',array('alt' => 'add', 'title'=>'Click to Add Case no'),array('escape' => false,'div'=>false)); ?>
                          </span>
                          </td>
                  </table>
                          </td>

                          <td width="80" align="center" style="text-align:center; min-width:80px;">
                                  <table cellpadding="0" cellspacing="0">
                          <td>
                          <?php
                          echo $this->Form->input('amount_denied', array('id'=>'amount_denied'.$result['FinalBilling']['id'],'type' => 'text','label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'add_case','value'=>$result['FinalBilling']['tds']));
                          ?>
                          </td>

                          <td>
                          <span id="<?php echo $result['Patient']['id']; ?>" class="Amount_Denied">
                                  <?php echo $this->Html->image('icons/save.png',array('alt' => 'add', 'title'=>'Click to Add Case no'),array('escape' => false,'div'=>false)); ?>
                          </span>
                          </td>
                  </table>
                          </td>-->
                <td width="" align="center" style="text-align: center;"> 
                    <?php echo $this->Form->input('',array('class'=>'remark','id'=>'remark_'.$patient_id,'rows'=>'1','cols'=>'10','div'=>false,'label'=>false)); ?>
                </td>
                <td width="" align="center" style="text-align: center;"> 
                    <?php
                    echo $this->Html->link($this->Html->image('icons/saveSmall.png'), 'javascript:void(0);', 
                         array('escape' => false,'title' => 'Save', 'alt'=>'Save','class'=>'saveForm','id'=>'save_'.$bill_id,
                             'patient_id'=>$patient_id));
                    echo $this->Html->link($this->Html->image('icons/delete-icon.png'), 'javascript:void(0);', array('escape' => false, 'title' => 'Remove from report', 'alt' => 'Remove from report', 'class' => 'remove', 'id' => 'remove_' . $patient_id), __('Are you sure?', true));
                    ?>
                </td>
                  </tr>
                  <?php } ?>              	
</table> 

</div>


<!--*******************************************************************************************************************-->        

            
<script>
jQuery(document).ready(function()
{

	$(function() {
		var $sidebar   = $(".top-header"),
            $window    = $(window),
            offset     = $sidebar.offset(),
            topPadding = 0;

        $window.scroll(function() {
            if ($window.scrollTop() > offset.top) {
                //$sidebar.stop().animate({
                 //   top: $window.scrollTop() - offset.top + topPadding
               // });

                $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
            } else {
                $sidebar.stop().animate({
                    top: 0
                });
            }
        });
       
    });
    
});
   
$(document).ready(function(){   
    $("#lookup_name").autocomplete({
        source: "<?php echo $this->Html->url(array("controller" => "patients", "action" => "autoSearchCorporatePatient", '25', 'IPD', "admin" => false, "plugin" => false)); ?>",
        minLength: 1,
        select: function( event, ui ) {
            $("#patient_id").val(ui.item.id);
        },
        messages: {
            noResults: '',
            results: function() {}
        }
    });  


    $( ".cmp_paid_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>", 
        buttonImageOnly: true,
        showTime: true,
        changeMonth: true,
        changeTime: true,
        changeYear: true,
        yearRange: '-50:+50',
        maxDate: new Date(),
        dateFormat:'dd/mm/yy HH:II:SS',
            
    });



$(".rowselected").click(function(){
        var id = $(this).attr('id').split("_")[1]; 
        $(".rowselected").each(function(key, value){
            $(this).removeClass('selectedRowColor');
        });
        $("#row_"+id).addClass('selectedRowColor');
    });
  
    $(".remove").click(function(){
        var patientId = $(this).attr('id').split("_")[1]; 
        $.ajax({
            url : "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "hideFromReportList", "admin" => false)); ?>"+"/"+patientId,
            beforeSend:function(data){
                $('#busy-indicator').show(); 
            }, 
            success: function(data){
                $('#busy-indicator').hide();
                $("#row_"+patientId).remove();
            }
        });
    });	

    $('.add_package_amount').focus(function(){
        var id = $(this).attr('id').split("_")[1];
        if($("#bank_"+id).val()!=''){

        }else{
            alert("please select bank first");
            $(this).val('');
            $(this).focus();
            return false;
        }
    });

 
    
    $(".saveForm").click(function(){ 
        var patientId = $(this).attr('patient_id');
        var id = $(this).attr('id').split("_")[1];
        var bank_id = $("#bank_"+id).val();
        var total_amount = $("#amt_"+id).val();
        var tds = $("#tds_"+id).val();
        var other_deduction = $("#otherDeduction_"+id).val();
        var amount_received = $("#package_"+id).val();
        var bill_no = $("#bill_"+id).val();
        var invoice_date = $("#cmp_paid_date_"+id).val();
        var remark = $("#remark_"+patientId).val(); 
        var isSettled = ($("#isSettled_"+id).is(':checked') == true)?'1':'0';
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');

        if(amount_received == ''){
            alert("please enter amount");
            return false;
        } 

        if(invoice_date == ''){
            alert("please select date");
            return false;
        } 

        $.ajax({
            type: 'POST',
            url : "<?php echo $this->Html->url(array("controller" => 'billings', "action" => "getAmountReceived", "admin" => false));?>"+"/"+id,
            data: 'bank_id='+bank_id+'&total_amount='+total_amount+'&advance_amount='+advAmt+'&amount='+amount_received+'&tds='+tds+'&other_deduction='+other_deduction+'&patient_id='+patientId+'&bill_no='+bill_no+'&invoice_date='+invoice_date+'&remark='+remark+'&is_setteled='+isSettled,
            beforeSend:function(data){  
                $('#busy-indicator').show();    
            },
            success: function(data){  
                var obj = jQuery.parseJSON( data );
                if(obj == 1){ 
                    window.location.reload();
                }else if(obj == 2){
                    $("#row_"+patientId).remove();
                    $('#busy-indicator').hide();
                }else{
                    alert("something went wrong, please try again..!!");
                    $('#busy-indicator').hide();
                } 
            }
        }); 
    });
    
    
    $(".isSettled").click(function(){
        console.log("GFDG");
        var id = $(this).attr('id').split("_")[1];
        var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
        var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
        var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');

        var tdsAdvOtherSum = advAmt + tdsAmt;
        var collectMoney = hospAmt - tdsAdvOtherSum;
    
        if($("#isSettled_"+id).is(':checked') == true){
            /*if(amtRec > collectMoney){
                alert("you could not able to collect amount more than Rs."+collectMoney); 
                $("#otherDeduction_"+id).val('');
                $(this).val('');
                $(this).focus();
                return false;
            }*/
            $("#otherDeduction_"+id).val(collectMoney - amtRec);
        }else{
            $("#otherDeduction_"+id).val('');
        }
    });

    $(".add_package_amount").keyup(function(){
        var id = $(this).attr('id').split("_")[1];
        var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
        var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
        var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');

        var tdsAdvOtherSum = advAmt + tdsAmt;
        var collectMoney = hospAmt - tdsAdvOtherSum;

        /*if(amtRec > collectMoney){
            alert("you could not able to collect amount more than Rs."+collectMoney); 
            $("#otherDeduction_"+id).val('');
            $(this).val('');
            $(this).focus();
            return false;
        }*/
        if($("#isSettled_"+id).is(':checked') == true){
            $("#otherDeduction_"+id).val(collectMoney - amtRec);
        }else{
            $("#otherDeduction_"+id).val('');
        }
    });
 
    $(".add_tds").keyup(function(){
        var id = $(this).attr('id').split("_")[1];
        var tdsAmt = parseInt($("#tds_"+id).val()!=''?$("#tds_"+id).val():'0'); 
        var amtRec = parseInt($("#package_"+id).val()!=''?$("#package_"+id).val():'0');
        var advAmt =  parseInt($("#advR_"+id).val()!=''?$("#advR_"+id).val():'0');
        var hospAmt = parseInt($("#amt_"+id).val()!=''?$("#amt_"+id).val():'0');
        var otherDeduction = parseInt($("#otherDeduction_"+id).val()!=''?$("#otherDeduction_"+id).val():'0');

        var tdsAdvOtherSum = advAmt + tdsAmt;
        var collectMoney = hospAmt - tdsAdvOtherSum;

        if((collectMoney - amtRec)>0 && $("#isSettled_"+id).is(':checked') == true){
            $("#otherDeduction_"+id).val(collectMoney - amtRec);
        }else{
            var remainAmount = (tdsAmt - otherDeduction);
            if($("#isSettled_"+id).is(':checked') == true){
                $("#otherDeduction_"+id).val(0);
                $("#package_"+id).val((amtRec)-remainAmount);
            } 
        }

        /*if($("#isSettled_"+id).is(':checked') == false){
            var tdsAdvOtherSum = advAmt + (amtRec + otherDeduction);
            var collectMoney = hospAmt - tdsAdvOtherSum; 
            if(tdsAmt > collectMoney){
                alert("Could not able to collect tds amount more than Rs."+collectMoney); 
                $("#otherDeduction_"+id).val('');
                $(this).val('');
                $(this).focus();
                return false;
            }
        } */
    });
});
</script>