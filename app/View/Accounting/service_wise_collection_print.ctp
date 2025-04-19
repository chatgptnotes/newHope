<?php
echo $this->Html->css(array('internal_style'));
echo $this->Html->script(array('jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));
?>

<style>
	body{
	font-size:13px;
	}
	.red td{
		background-color:antiquewhite !important;
	}
	.idSelectable:hover{
			cursor: pointer;
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
	#msg {
	    width: 180px;
	    margin-left: 34%;
	}
</style>

<table width="100%" cellpadding="0" cellspacing="2" border="0" style="padding-top:10px">
	<tr>
	<td width="95%" valign="top">
		<table border="0" class="" cellpadding="0" cellspacing="0" width="100%" style="padding-left:30px;" align="center" >
			  <tr>
				  <td colspan="4" align="right">
					  <div id="printButton">
					  	<?php echo $this->Html->link(__('Print', true),'#', array('escape' => false,'class'=>'blueBtn','onclick'=>'window.print();window.close();'));?>
					  </div>
			 	 </td>
			  </tr>
			  <tr>  
		  		<td valign="top" colspan="13" style="text-align:center;" align="center">
		  			<h2><?php echo "Service Wise Collection";?></h2>
		  		</td>
	    	</tr>
	    	<tr>
		    	<?php 
		    	if($this->params->query['from_date']){
					$getfromFinal = str_replace("/", "-",$this->params->query['from_date']);
					$fromDate=date('jS-M-Y', strtotime($getfromFinal));
				}else{
					$fromDate=$getToFinal=date('jS-M-Y');
				}
				
				if($this->params->query['to_date']){
					$getToFinal = str_replace("/", "-",$this->params->query['to_date']);
					$toDate=date('jS-M-Y', strtotime($getToFinal));
				}else{
					$toDate=date('jS-M-Y');
				}
				/*	$getTo=explode(" ",$date);
			    	$getToFinal = str_replace("/", "-",$getTo[0]);
			    	$getToFinal=date('jS-M-Y', strtotime($getToFinal));*/
		    	?>
		    	<td align="" valign="top" colspan="2" style="letter-spacing: 0.1em;text-align:center;">
				  	<?php echo $fromDate.' To '.$toDate; ?>
				</td>
	    	</tr>    
		</table>

		<div id="container">
			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm">
				<thead>
					<tr> 
						<th width="25%" align="center" valign="top">SubGroup Name</th> 
						<th width="25%" align="center" valign="top" style="text-align: center; ">Net Amount</th> 
						<th width="25%" align="center" valign="top" style="text-align: center;">Discount</th>
						<!-- <th width="25%" align="center" valign="top" style="text-align: center;">Net Amount</th> -->
					</tr> 
				</thead>
				
				<tbody>
				<?php 
				foreach ($dataDetails as $key=> $data){
				if($data['0']['total_amount'] || $data['0']['total_discount']){?>?>
					<tr>
						<td align="left" valign="top" style= "text-align: left;">
							<div style="padding-left:0px;padding-bottom:3px;">
								<?php  
								if($key==='Pharmacy'){
									echo 'Pharmacy' ;
								}else if($key==='OtPharmacy'){
									echo 'OtPharmacy' ;
								}else if($key==='Patient Card'){
									echo 'Patient Card' ;
								}else{
									if(strtolower($data['ServiceCategory']['alias'])=='laboratory'){
										echo $data['ServiceCategory']['alias'];
									}else
										echo !empty($data['ServiceSubCategory']['name'])?ucwords(strtolower($data['ServiceSubCategory']['name'])):ucwords(strtolower($data['ServiceCategory']['alias']));
								}?>
							</div>
						</td>
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo  round($data['0']['total_amount']);
							$totalRevenue +=  (int) round($data['0']['total_amount']);?>
						</td>						
						<td class="tdLabel"  style= "text-align: center;">
							<?php echo round($data['0']['total_discount']);
							$totalDiscount +=  (int) round($data['0']['total_discount']);?>
						</td>						
						<!-- <td class="tdLabel"  style= "text-align: center;">
						<?php $netAmount = ($data['0']['total_amount']);
							 echo $netAmount;
							$totalNetAmount +=  (int) $netAmount?>
						</td> -->
				  	</tr>
				<?php }
				} ?>
				</tbody>
			<tr>
				<td class="tdLabel" colspan="0" style="text-align: left;"><?php echo __('Grand Total :');?></td>
					<?php if(empty($totalRevenue)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						  }else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalRevenue)?></td>
					<?php } 
						if(empty($totalDiscount)){ ?>
							<td class="tdLabel"><?php echo " ";?></td><?php
						}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalDiscount)?></td>
					<?php }
						//if(empty($totalNetAmount)){ ?>
							<!--  <td class="tdLabel"><?php echo " ";?></td><?php
						//}else{ ?>
							<td class="tdLabel" style= "text-align: center;"><?php echo $this->Number->currency($totalNetAmount)?></td>-->
					<?php // } ?>
			</tr>  
			<?php echo $this->Form->end();?>
			</table>
		</div>
	</td>
	</tr>
</table>

<script>

$(document).ready(function(){
	$(".location").change(function(){
		 var id = ($(this).val()) ? $(this).val() : 'null' ;
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Accounting', "action" => "service_wise_collection", "admin" => false));?>";
			$.ajax({
			url : ajaxUrl + '?id=' + id,
			beforeSend:function(data){
			$('#busy-indicator').show();
			},
			success: function(data){
				$("#container").html(data).fadeIn('slow');
				$('#busy-indicator').hide();
			}
		 });
	 });
});
</script>