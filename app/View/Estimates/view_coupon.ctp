
<style> 
.blueBtn2 {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: rgba(0, 0, 0, 0) linear-gradient(#FFFF94, #FFFF94) repeat scroll 0 0 !important;
    border-color: #1a5bb7 #1a5bb7 #589cb6;
    border-image: none;
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    color: #000 !important;
    font-weight: normal;
    height: 25px !important;
     padding: 4px 10px;
    position: relative;
}
.blueBtn0 {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: rgba(0, 0, 0, 0) linear-gradient(#B8FF94, #B8FF94) repeat scroll 0 0 !important;
    border-color: #1a5bb7 #1a5bb7 #589cb6;
    border-image: none;
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    color: #000 !important;
    font-weight: normal;
    height: 25px !important;
     padding: 4px 10px;
    position: relative;
}
.blueBtn1 {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: rgba(0, 0, 0, 0) linear-gradient(#FF8080, #FF8080) repeat scroll 0 0 !important;
    border-color: #1a5bb7 #1a5bb7 #589cb6;
    border-image: none;
    border-radius: 5px;
    border-style: solid;
    border-width: 1px;
    color: #000 !important;
    font-weight: normal;
    height: 25px !important;
     padding: 4px 10px;
    position: relative;
}
.color-box {
    border: 1px solid black !important;
    float: left;
    height: 10px;
    margin: 2px 10px 0 5px;
    width: 10px;
}

.table_view_format td {
  //  padding: 5px 24px !important;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Coupon Details', true); ?>
	</h3>
	
	<span> <?php echo $this->Html->link(__('Back To List', true),array('action' => 'couponBatchGeneration'),array('escape' => false,'class'=>'blueBtn')); 
	//echo $this->Html->link(__('Back', true),array('action' => 'couponNumberGenration'), array('escape' => false,'class'=>'blueBtn'));
	?>
	</span>
	
</div>

<table border="0" class="table_view_format" cellpadding="0"
	cellspacing="0" width="550" align="center">
	
	
	<tr class="row_gray">
		<td colspan="4" class="row_format" style="text-align: center;"><strong> <?php echo __('Coupon Details')?></strong>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="row_format"  ><strong> <?php echo __('Coupon Type')?></strong>
		</td>
		<td colspan="2"><?php echo $data[0]['Coupon']['type']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td colspan="3" class="row_format" ><strong> <?php echo __('Batch Name'); ?></strong>
		</td>
		<td colspan="2" ><?php  echo $data[0]['Coupon']['batch_name'];?>
		</td>
	</tr>
	<tr>
		<td  colspan="3" class="row_format"><strong> <?php echo __('No.of coupons ');  ?></strong>
		</td>
		<td colspan="2" ><?php  echo $data[0]['Coupon']['no_of_coupons']; ?>
		</td>
	</tr>
	<tr class="row_gray">
		<td colspan="3" class="row_format" ><strong> <?php echo __('Validate From ');  ?></strong>
		
		</td>
		<td colspan="2"><?php echo $this->DateFormat->formatDate2Local($data[0]['Coupon']['valid_date_from'],Configure::read('date_format')); ?>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="row_format"><strong> <?php echo __('Validate to ');  ?></strong>
		</td>
		<td colspan="2"><?php echo $this->DateFormat->formatDate2Local($data[0]['Coupon']['valid_date_to'],Configure::read('date_format')); ?>

		</td>
	</tr>

	
	
	
<?php $coupondata = unserialize($data[0]['Coupon']['coupon_amount']); $allServicesAmt = array();
foreach($coupondata as $key => $val){
   //  $service[]  = $val['serviceId'];
   //  $serviceName[] = $services[$val['serviceId']];
   $amt = ($val['type']=='Percentage') ? $val['value'].'%' : $val['value'].'.00' ;
$allServicesAmt[]  = ' '.$services[$val['serviceId']].' - '.$amt;
}
?>
	<tr class="row_gray">
		<td colspan="3" class="row_format"><strong> <?php echo __('Sevices Available ');  ?></strong>
		
		</td>
                <td colspan="2"><?php  echo implode(', ',$allServicesAmt);
										
	
		?>
		</td>
	</tr>
	<tr class="row_gray">
		<td colspan="2" class="row_format" ><strong> <?php echo __('Coupon Numbers'); ?></strong>
		</td>
		<td colspan="3">
		<table>
                            <tbody><tr>
  <td style="padding: 0px ! important;">
    <div style="background: rgb(255, 255, 148) none repeat scroll 0% 0%; float: left;" id="color-box15" class="color-box"></div>
    <div style="float: right">Used</div>
  </td>
  <td>
    <div style="background: #FF8080;" id="color-box15" class="color-box"></div>
  <div style="float: right">Inactive</div>
  </td>
  <td><div style="background: #B8FF94;" id="color-box15" class="color-box"></div>
  <div style="float: right">Active</div>
	</td>
</tr>
         </tbody></table>
		</td>
	</tr>
	</table>
	<table  border="0" class="table_view_format" cellpadding="0"
	cellspacing="0" width="550" align="center">	
	<tr> 
	<td colspan="4" class="row_format" style="text-align: center;"><div style="font-style: italic;" align="right">Click button to change coupon status</div>
		<table><tr>
	<?php 	$cntr = 0; ?>
		<?php foreach($data as $key=>$result) { ?>
		<?php  if($key == 0) continue;?>
		<?php $cntr++ ;  ?>
		<td><?php if($result['Coupon']['status']==2){
			echo $this->Form->button($result['Coupon']['batch_name'], array('type'=>'button','class'=>'blueBtn2'));
			}elseif($result['Coupon']['status']==0){
				echo $this->Form->button($result['Coupon']['batch_name'], array('type'=>'button','id'=>'1_'.$result['Coupon']['id'],'class'=>'blueBtn0 btnChange'));
			}else{
				echo $this->Form->button($result['Coupon']['batch_name'], array('type'=>'button','id'=>'0_'.$result['Coupon']['id'],'class'=>'blueBtn1 btnChange'));
			}
		?>
		 </td>
		<?php if($cntr%4 == 0){?>
		</tr>
		<tr>
		<?php }}?>	
		</tr>
		</table>
		</td> 
		
	</tr>
</table>
<script>
$(document).ready(function() {
    $('.btnChange').click(function(){ 
    	var id ='';
        CouponId = $(this).attr('id'); 
            splitedVal = CouponId.split("_");
            id = splitedVal[1];
        	status =splitedVal[0]; // 0
        	$.ajax({
                type :"get",
                url: "<?php echo $this->Html->url(array("controller" => "Estimates", "action" => "updateCouponStatus", "admin" => false)); ?>"+"/"+id+"/"+status,
                context: document.body,
                success: function(){
                if(status == 0){ 
                    $('#'+CouponId).removeClass("blueBtn1").addClass("blueBtn0").attr("id",'1_'+id);
                    }
                else{
                	$('#'+CouponId).removeClass("blueBtn0").addClass("blueBtn1").attr("id",'0_'+id);
                    }
            	}
            });      
            
    }); 
});
</script>