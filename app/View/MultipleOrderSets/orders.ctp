<style>
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}

#fancybox-content .rightOrderAreaSection .middleOrderArea {
    border:none !important;
}
</style>

<?php

echo $this->Html->css(array('jquery.fancybox-1.3.4.css'/*,'jquery.autocomplete.css','validationEngine.jquery.css'*/));      
echo $this->Html->script(array('jquery.fancybox-1.3.4'/*,'jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js',*/,'jquery.blockUI',
	/*	'/js/languages/jquery.validationEngine-en','jquery.validationEngine2',*/'inline_msg'));?>

<script>

var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
</script>
<div class="inner_title" style=' padding-top: 55px'>
	<h3>
		&nbsp;
		<?php echo __('Orders Information');?>


		<span style='text-align: right;padding-top: 25px'><?php //echo $this->Html->link(__('Add Multiple Order Set'),'#',array('onclick'=>'orderaddmultiple("'.$patient_id.'")','class'=>'blueBtn','div'=>false,'label'=>false));?>&nbsp;&nbsp;
			<?php echo $this->Html->link(__('Back'), array('controller'=>'Users','action' => 'doctor_dashboard'), array('escape' => false,'class'=>'blueBtn'));?>
			<?php if($this->Session->read('roleid')!=Configure::read('nurseId')){echo $this->Html->link(__('Add Order'),'javascript:void(0)',array('onclick'=>'getPackage("'.$patient_id.'","'.$patientOrderEnc.'")','class'=>'blueBtn','div'=>false,'label'=>false));}?>
			<?php //echo $this->Html->link(__('Add multiple Order'),array('controller'=>'MultipleOrderSets','action' =>'index',$patient_id),array('class'=>'blueBtn','div'=>false,'label'=>false));?>
			
		</span>
		
	</h3>

</div>
<div class="inner_left" >
	<?php echo $this->element('patient_information');?>
</div>
<table width="100%" border="0">
	<tr>
		<td width="15%" valign="top" style="border-right: 1px solid gray">
			<table border="0" cellpadding="0" cellspacing="0" width="100%"
				align="center">
				<tr>
					<td><h3>
							<?php echo __('Order Categories');?>
						</h3></td>
				</tr>
				<tr>
					<?php //debug($getOrderData);?>
					<?php $cnt=0; foreach($setdata as $getOrderData){

						if($getOrderData['OrderCategory']['id']==$setdata[$cnt][PatientOrder]['0']['order_category_id']){

					$checked='checked';
					}
					else{
						$checked="";
					}
					?>
					<td><?php echo $this->Form->checkbox('hi',array('name'=>'order_category','disabled'=>"disabled",'checked'=>$checked)) .$getOrderData['OrderCategory']['order_description']."<br/>";?>
					</td>

				</tr>
				<?php $cnt++; 
}?>

			</table>
		</td>
		
			<?php if($setCount<1){
			?>
			
				<td style="valign:top;">
				<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="100%">
				<tr class="showTr1">
					<td colspan="5" class="showList"><?php echo "Show Prevoius Orders List"; echo $this->Html->image('icons/plus_6.png' , 
							array('id'=>'','style'=>'padding-right: 5px;','title'=>"Prevoius Orders",'alt'=>'Prevoius Orders'));?></td>
				</tr>
				<tr class="showTr2" style="display:none;">
					<td colspan="5" class="showTr2"><?php echo "Hide Prevoius Orders List"; echo $this->Html->image('icons/plus_6.png' , 
							array('id'=>'','style'=>'padding-right: 5px;','title'=>"Hide Orders",'alt'=>'Hide Orders'));?></td>
				</tr>
				<tr id="showListViewId" style="display:none;">
					<td colspan="5" id="showListView"></td>
				</tr>
				</table></td>
		
			
		<?php } else{?>
		
		<td width="85%" valign="top">
			<table border="0" class="table_format" cellpadding="0"
				cellspacing="0" width="100%">
				<?php /* ?><tr>
					<td colspan="5"><?php echo 'This Order are given by Dr. <b>'.$getDocName['0']['fullname']."</b>.";?>
					</td>
				</tr>
				<tr>
					<td colspan="5"><?php echo " ";?>
					</td>
				</tr><?php */?>
				<tr class="showTr1">
					<td colspan="5" class="showList"><?php echo "Show Prevoius Orders List"; echo $this->Html->image('icons/plus_6.png' , 
							array('id'=>'','style'=>'padding-right: 5px;','title'=>"Prevoius Orders",'alt'=>'Prevoius Orders'));?></td>
				</tr>
				<tr class="showTr2" style="display:none;">
					<td colspan="5" class="showTr2"><?php echo "Hide Prevoius Orders List"; echo $this->Html->image('icons/plus_6.png' , 
							array('id'=>'','style'=>'padding-right: 5px;','title'=>"Hide Orders",'alt'=>'Hide Orders'));?></td>
				</tr>
				<tr id="showListViewId" style="display:none;">
					<td colspan="5" id="showListView"></td>
				</tr>
				<tr class="row_title">

					<td class="table_cell" width="15%"><strong><?php echo __('Order Categories'); ?> </strong>
					</td>
                   
					<td class="table_cell" width="30%"><strong><?php echo __('Order Name');?>
					</strong>
					</td>
					<td class="table_cell" width="10%"><strong><?php echo __('Status'); ?>
					</strong>
					</td>
					<td class="table_cell" width="30%"><strong><?php echo  __('Details'); ?>
					</strong>
					</td>

				</tr>


				<?php $k=0;
				
				foreach($setdata as $setdatas){

           $cnt_order=count($setdatas['PatientOrder']);
          
           if($cnt_order!=0)
           {
           	?>

				<tr class="row_gray">
					<td class="table_cell" colspan='5'><strong><?php echo $setdatas['OrderCategory']['order_description']?>
					</strong></td>

 
				</tr>
				<?php }
				$j=0;
				for($i=0;$i<count($setdatas['PatientOrder']);$i++){
			?>
				<tr class="">
					<?php if(($setdatas['PatientOrder'][$i]['status'])=='Ordered'){
						$orderchecked='checked';
					}
					else{
						$orderchecked='';
					}
				
					if($this->Session->read('roleid')!=Configure::read('nurseId'))
                    {
                    	//$ischkdisable="disabled'=>'disabled'";
                    	
                    }
					?>
					<td class="table_cell" align="right" width="10%"><?php echo $this->Form->checkbox('checkSataus',
							array('name'=>'checkSataus','class'=>'chkStatus','id'=>$i.$cnt_order.$k,'checked'=>$orderchecked,$ischkdisable,
'onclick'=>'update_patient_record("'.$setdatas['PatientOrder'][$i]['patient_id'].'","'.$setdatas['PatientOrder'][$i]['id'].'",this.id,"'.$setdatas['PatientOrder'][$i]['type'].'")')) ; ?>
					</td>
					<td class="table_cell"><a href="#formdisplayid"
							onclick="javascript:display_formdisplay(<?php echo $this->params->query[noteId]?>,<?php echo $patient_id?>,<?php echo $setdatas['PatientOrder'][$i]['id']?>,'<?php echo $setdatas[PatientOrder][$i][type]?>')"><?php echo __($setdatas['PatientOrder'][$i]['name']);?>
						</a>  <?php
						//echo  $this->Js->link('<input type="button" value="Add" class="blueBtn" id="submitMyData">',"#",
						///array('before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#busy-indicator')->effect('hide', array('buffer' => false)),'update'=>'#formdisplayid', 'data' => '{finddata:$("#finddata").val(),patientid:$("#patientid").val(),category:$("#category").val()}','dataExpression' => true,'htmlAttributes' => array('escape' => false) ));echo $this->Js->writeBuffer();
						?>
					</td>
					<td class="table_cell"><div
								id='updateStatus<?php echo $i.$cnt_order.$k?>'>
								<?php echo __($setdatas['PatientOrder'][$i]['status']); ?>
							</div> </td>
					<td class="table_cell"><?php echo __(rtrim($setdatas['PatientOrder'][$i]['sentence'],", ")); ?>
					
					</td>

				</tr>
				<?php }
				
				$k++;
}
unset($cnt_order);

?>

				<tr>
					<td id="formdisplayid" colspan="5" style="margin-top: 10px"></td>
				</tr>
			</table> <?php }?>
		</td>
	</tr>
</table>
<script>
$(document).ready(function(){
	 if(<?php echo $setCount ?>< 1){
	//getPackage(<?php echo $patient_id?>);
	 }
});
function update_patient_record(id,order_id,chkId,type){
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "updateorderset","admin"=>false)); ?>"+"/"+id+"/"+order_id+"/"+type;
	//alert(ajaxUrl);
			$.ajax({
				type : "POST",
				url : ajaxUrl , 
				
				beforeSend:function(){
					$('#busy-indicator').show('fast');
                },
				success: function(data){
					data = jQuery.parseJSON(data);
					data = data.status;
					$('#busy-indicator').hide('fast');
					if(data=='Y'|| data=='1'){
						var changeStatus='Cancelled';
					}
					else if(data=='N'|| data=='0'){
						var changeStatus='Ordered';
					}
					else{
						var changeStatus='Pending';
					}
			$("#updateStatus"+chkId).html(changeStatus);
					$("#updateStatus"+chkId).html(changeStatus);
					changeStatus = '';
					
					//window.location.href="<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "orders")); ?>" +"/"+id+"/"+2
					},
				
				error: function(message){
				alert('Please try later.');
				}
				
			});
}

function orderadd(id) { 
	$.fancybox({
				'width' : '50%',
				'height' : '80%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "addorders")); ?>" +"/"+id,
				'onClosed':function (){
					window.top.location.href = '<?php echo $this->Html->url("/MultipleOrderSets/orders"); ?>'+"/"+id+"/"+1;
				}		
			});

}
function orderaddmultiple(id) { 
	$.fancybox({
		'width' : '50%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "addordermultiples")); ?>" +"/"+id
		 	
	});

}

function display_formdisplay(noteid,patient_id,patient_order_id,patient_order_type){	
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "displayorderform","admin" => false)); ?>";
	  var patientencounterId='<?php echo $patientOrderEnc?>';
	  var formData = $('#patientnotesfrm').serialize();
         $.ajax({	
        	 beforeSend : function() {
        		// this is where we append a loading image
        		$('#busy-indicator').show('fast');
        		},
        		                           
          type: 'POST',
         url: ajaxUrl+"/"+noteid+"/"+patient_id+"/"+patient_order_id+"/"+patient_order_type+"?patientencounterId="+patientencounterId,
          data: formData,
          dataType: 'html',
          success: function(data){
        	  $('#busy-indicator').hide('fast');
	        	$("#formdisplayid").html(data);
	        
	        
          },
			error: function(message){
				alert("Error in Retrieving data");
          }        });
    
    return false; 
}
function fillStartdate()
{
	if($('#chktn').is(':checked'))
	{
		$("#start_date").disabled = true;
	    var currentdate = new Date();
        var showdate = (currentdate.getMonth()+1)+"/"+currentdate.getDate()+"/"+currentdate.getFullYear()+" "+currentdate.getHours()+":"+currentdate.getMinutes();
        $( "#start_date" ).val(showdate);
           
	}
     
	else
	{
		$("#start_date").disabled = false;
		$( "#start_date" ).val(showdate);
	}
   
}
function getPackage(patientId,patientOrderEnc)
{
	
var getPackageUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "getPackage","admin" => false)); ?>" ;
	$.fancybox({

		'width' : '100%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : getPackageUrl+"/"+patientId+"/"+patientOrderEnc
});

}
// call list for order by the patients//
$('.showList').click(function(){
	 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "orderList","admin" => false)); ?>";
	  $.ajax({
       	beforeSend : function() {
       		$('#busy-indicator').show('fast');
       	},
       	type: 'POST',
       	url: ajaxUrl+"/"+'<?php echo $patient_id?>',
       	dataType: 'html',
       	success: function(data){          
       		$('#busy-indicator').hide('fast');
       		$('.showTr2').show();
       		$('.showTr1').hide();
       		$('#showListViewId').show();
       		$('#showListView').html(data);
       },
		});
});
$('.showTr2').click(function(){
	$('.showTr2').hide();
		$('.showTr1').show();
		$('#showListViewId').hide();
});




			</script>
