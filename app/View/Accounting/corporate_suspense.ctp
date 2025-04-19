<?php 
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
 ?>
<style>
.cost{
	text-align: right;
}
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	 background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
body{
font-size:13px;
}
</style>
<?php 
echo $this->Html->script('topheaderfreeze') ;
?>
<div class="inner_title">
    <h3>
        <?php echo __('Corporate Suspense', true); ?>
    </h3> 
</div>
<div class="clr">&nbsp;</div>
<?php if(!empty($errors)) { ?>
<table border="0" cellpadding="0" cellspacing="0" width="60%" align="center">
    <tr>
        <td colspan="2" align="left"><div class="alert">
            <?php 
            foreach($errors as $errorsval){
                echo $errorsval[0];
                echo "<br />";
             } ?>
                </div>
        </td>
    </tr>
</table>
<?php } 
echo $this->Form->create('accounting', array('url'=>array('controller'=>'Accounting','action'=>'account_receipt'),'id'=>'suspense',
		'inputDefaults' => array('label' => false,'div' => false,'error'=>false,'legend'=>false))) ;
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top" width="5%"><?php echo $this->element('accounting_menu'); ?></td>
        <td width="95%" valign="top">
			<table align="center" border="0" cellspacing="0" cellpadding="0" class="formFull"> 
				<tr>
					<td class="tdLabel" id="boxSpace" style="text-align: right;">
						<?php echo __("Suspense Account :");?><font color='red'>*</font>
                    </td>
                    <td valign="top" class="tdLabel">
                       	<?php echo $this->Form->input('AccountReceipt.user_id', array('type'=>'select','empty'=>'Please Select','options'=>$suspenseType,
                        		'class' =>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'name','label'=> false,'div'=>false,'error'=>false,
                        		'style'=>'width:230px','autocomplete'=>'off'));
                        	echo $this->Form->hidden('AccountReceipt.type',array('type'=>'text','id'=>'type','value'=>'SuspenseAccount'));
                        	echo $this->Form->hidden('AccountReceipt.corporate_action',array('type'=>'text','id'=>'corporate_action','value'=>'1'));
                        	echo $this->Form->hidden('AccountReceipt.suspense_amount',array('type'=>'text','id'=>'suspense_amount'));?>
                    </td>
                    <td class="tdLabel" id="boxSpace" style="text-align: right;">
                     	<?php echo __("Name Of Bank :");?><font color='red'>*</font>
                    </td>
                    <td valign="top" class="tdLabel">
                        <?php echo $this->Form->input('AccountReceipt.account_id', array('type'=>'select','empty'=>'Please Select','options'=>$bankTypes,
                        		'class' =>'validate[required,custom[mandatory-select]] textBoxExpnd','id'=>'bank','label'=> false,'div'=>false,'error'=>false,
                        		'style'=>'width:230px','autocomplete'=>'off' ));?>
                    </td>
               	</tr>
                  
                 <tr>
                     <td valign="top" class="tdLabel" style="text-align: right; vailgn: top;">
                     	<?php echo __("Amount :");?><font color='red'>*</font>
                     </td>
                     <td valign="top" class="tdLabel">
                        <?php echo $this->Form->input('AccountReceipt.paid_amount', array('type'=>'text','placeholder'=>'Suspense Amount',
                        		'class'=>'validate[required,custom[mandatory-enter]] textBoxExpnd cost','id'=>'paid_amount','style'=>'width:230px;','autocomplete'=>'off')); ?>
                     </td>
                     <td valign="top" class="tdLabel" style="text-align: right; vailgn: top;">
                     	<?php echo __("Date :");?><font color='red'>*</font>
                     </td>
                     <td valign="top" class="tdLabel">
                        <?php  $date = $this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'),true);
                        echo $this->Form->input('AccountReceipt.date', array('type'=>'text','placeholder'=>'Date','value'=>$date,
                        		'class'=>'textBoxExpnd date validate[required,custom[mandatory-date]]','id'=>'date','autocomplete'=>'off'));?>
                     </td>
                 </tr>
                  
                 <tr>
         		<!-- BOF TDS -->
					<td class="tdLabel" style="text-align: right; vailgn: top;">
						<?php echo __('TDS :'); ?>
					</td>
					<td align="right" class="tdLabel">
							<?php echo $this->Form->input('AccountReceipt.tds_amount',array('class'=>'textBoxExpnd cost','id'=>'tds','type'=>'text',
								'placeholder'=>'Amount only','style'=>'width:230px;','autocomplete'=>'off')); ?>
					</td>
				<!-- EOF TDS -->	
                     <td class="tdLabel" style="text-align: right;">
                     	<?php echo __("Narration :");?>
                     </td>
                     <td valign="top" class="tdLabel">
                      <?php echo $this->Form->input('AccountReceipt.narration', array('class'=>'inputBox','id'=>'narration','type'=>'textarea',
                      		'placeholder'=>'Narration','style'=>'width: 350px; height: 33px;'));?>
                     </td> 
                 </tr>
                    
                 <tr>
                   	<td id="boxSpace" style="text-align: right;" colspan="2">
	                    <?php echo $this->Form->submit(__('Save'), array('class'=>'blueBtn','div'=>false,'id'=>'submit')); ?>
	                </td>
	                <td>
	                    <?php $cancelBtnUrl =  array('controller'=>'Accounting','action'=>'corporateSuspense');?>
	                    <?php  echo $this->Html->link(__('Cancel'),$cancelBtnUrl,array('class'=>'blueBtn','div'=>false)); ?>
	                </td>
               	</tr>
            </table>
            <?php echo $this->Form->end();?>

<div class="inner_title"></div>
<?php echo $this->Form->create('searchAccounting', array('url'=>array('controller'=>'Accounting','action'=>'corporateSuspense'),'id'=>'serachAcc','inputDefaults'=>array('label'=>false,'div'=>false,'error'=>false,'legend'=>false))) ;?>
    <table border="0" cellpadding="2" cellspacing="0" align="center">
        <tbody>
            <tr class="row_title">
                <td valign="top" class="tdLabel">
                    <?php echo $this->Form->input('', array('name'=>'search_user_id','type'=>'select','empty'=>'Please Select','options'=>$suspenseType,
                            'class' =>'textBoxExpnd','id'=>'name','label'=> false,'div'=>false,'error'=>false,
                            'style'=>'width:230px','autocomplete'=>'off','value'=>$suspenseLedger));
                    ?>
                </td>
                <td>
                    <?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'searchSuspense'));?>
                </td>
                <td>
                    <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'corporateSuspense'),array('escape'=>false));?>    
                </td>
            </tr>
        </tbody>
    </table>       
    <?php echo $this->Form->end();?>           
		<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="container-table">
			<thead>
				<tr> 
					<th align="center" valign="top" style="text-align: center;"><?php echo __('Date');?></th>
					<th align="center" valign="top" style="text-align: center;"><?php echo __('Particulars');?></th> 
					<th align="center" valign="top" style="text-align: center;"><?php echo __('Voucher No.');?></th> 
					<th align="center" valign="top" style="text-align: center;"><?php echo __('Amount');?></th>
					<th align="center" valign="top" style="text-align: center;"><?php echo __('TDS amount');?></th>
					<th align="center" valign="top" style="text-align: center;"><?php echo __('Actions');?></th>
				</tr> 
			</thead>
			<tbody>
			<?php foreach($receiptData as $key=> $data){?>
                <tr>
					<td align="left" valign="top" style= "text-align: left;">
						<?php echo $this->DateFormat->formatDate2Local($data['AccountReceipt']['date'],Configure::read('date_format'),true); ?>
					</td>
					
					<td align="left" valign="top" style= "text-align: left;">
						<div style="padding-left:0px;padding-bottom:3px;">
							<?php echo ucwords($data['Account']['name']); ?>
						</div>
						
						<div style="padding-left: 35px; font-size:13px; font-style:italic;">
							<?php echo __('Entered By : ').$data['User']['first_name'].' '.$data['User']['last_name']; ?>
						</div>
					
						<div style="padding-left:35px;padding-top:5px; font-style:italic;" class="narration">
							<?php echo __('Narration : ').$data['AccountReceipt']['narration']; ?>
						</div>
					</td>
					
					<td align="left" valign="top" style= "text-align: center;">
						<?php echo $data['AccountReceipt']['id']; ?>
					</td>
					
					<td align="left" valign="top" style= "text-align: center;">
						<?php echo $this->Number->currency($data['AccountReceipt']['paid_amount']);?>
					</td>
					<td align="left" valign="top" style= "text-align: center;">
						<?php echo $this->Number->currency($data['AccountReceipt']['tds_amount']);?>
					</td>
					<td valign="top" style= "text-align: center;">
						<?php echo $this->Html->link(__('Pick'), 'javascript:void(0);', array('title'=>'Pick','class'=>'blueBtn pick','id'=>'pick_'.$data['AccountReceipt']['id'],'tariff'=>$data['Account']['system_user_id']));?>
					</td>
				</tr>
			<?php }?>
			</tbody>
		</table>            
        </td>
    </tr>
</table>
<?php echo $this->Form->end();?>

<script>
$(document).ready(function(){
	$("#container-table").freezeHeader({ 'height': '400px' });
	$("#submit").show();
	$("#date").datepicker({
		showOn : "both",
		buttonImage : "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly : true,
		changeMonth : true,
		changeYear : true,
		yearRange: '-100:' + new Date().getFullYear(),
		maxDate : new Date(),
		dateFormat:'<?php echo $this->General->GeneralDate('HH:II:SS');?>',
		onSelect : function() {
			$(this).focus();
		}
	});
});	

$("#submit").click(function(){
	var validateForm = jQuery("#suspense").validationEngine('validate');
	if(validateForm == true){
		$("#submit").hide();
	}else{
		return false;
	}
});

$(document).on('keyup','#paid_amount',function(){
	if (/[^0-9\.]/g.test(this.value)){
     this.value = this.value.replace(/[^0-9\.]/g,'');
    }
	$("#suspense_amount").val($(this).val());
});

var childSubmitted = false;	
var corporateReceiptURL = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "newCorporateAccountReceipt","admin" => false)); ?>" ;
$(".pick").click(function() {
    id = $(this).attr('id');
    receiptId = id.split("_");
    var tariffStdID = $(this).attr('tariff');
    $.fancybox({
        'width' : '70%',
        'height' : '80%',
        'autoScale' : true,
        'transitionIn' : 'fade',
        'transitionOut' : 'fade',
        'hideOnOverlayClick':false,
        'type' : 'iframe',
        'href' : corporateReceiptURL + '/' + receiptId[1] + '/' +tariffStdID,
        'onClosed':function(){
                if(childSubmitted == true){
                        window.parent.location.reload();
                }
        }
    });
});
</script>

