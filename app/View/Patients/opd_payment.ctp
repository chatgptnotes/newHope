<style>

	body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000;}

	.boxBorder{border:1px solid #3E474A;}
	.boxBorderBot{border-bottom:1px solid #3E474A;}
	.boxBorderRight{border-right:1px solid #3E474A;}
	.tdBorderRtBt{border-right:1px solid #3E474A; border-bottom:1px solid #3E474A;}
	.tdBorderBt{border-bottom:1px solid #3E474A;}
	.tdBorderTp{border-top:1px solid #3E474A; }
	.tdBorderRt{border-right:1px solid #3E474A; }
	.tdBorderTpBt{border:1px solid #3E474A;}
	.tdBorderTpRt{border-top:1px solid #3E474A; border-right:1px solid #3E474A; }
	.columnPad{padding:5px;}
	.columnLeftPad{padding-left:5px;}
	.tbl{background:#CCCCCC;}
	.tbl td{background:#FFFFFF;}
	.totalPrice{font-size:14px;}
	.adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
	.tdBorderTpBt td{ font-size: 13px !important;
	}
</style>
<div class="inner_title"><h3>Consultation Fees Payment</h3></div>
<p class="ht5"></p>
<?php echo $this->element('patient_information');?>

<div class="clr ht5"></div>
	<?php  
                echo $this->Form->create('Patient', array('url' => array('controller'=>'patients','action' => 'opd_payment',$patient_id)
										,'id'=>'orderfrm','inputDefaults' => array('label' => false,'div' => false,'error'=>false)
						));
	?>
	<!--<table width="100%" cellspacing="3" cellpadding="3" border="0" align="center" class="boxBorder">
  		<tbody>
  		<tr>
    		<td width="100%" valign="top" align="left" class="boxBorderBot">
				--><table width="100%" cellspacing="0" cellpadding="3" border="0" class="tdBorderTpBt">
			          <tbody> 
			           <tr>
			            <td valign="top" align="left" class="tdBorderTpRt"><strong>Charge</strong></td>
			            <td valign="top" align="right" class="tdBorderTpRt"><strong>Unit</strong></td> 
			            <td valign="top" align="right" class="tdBorderTp totalPrice"><strong>Amount</strong></td>
			          </tr><tr>
			            <td valign="top" align="right" class="tdBorderTpRt">&nbsp;</td>
			            <td valign="top" align="right" class="tdBorderTpRt">&nbsp;</td> 
			            <td valign="top" align="right" class="tdBorderTp totalPrice">&nbsp;</td>
			          </tr>
			          <?php 
			          		$lCost ='';
			          		$hosType = ($this->Session->read('hospitaltype')=='NABH')?'nabh_charges':'non_nabh_charges' ; 
			          		$totalCost= $data['TariffAmount'][$hosType]+$consultationCharge['TariffAmount'][$hosType];
			          		if( $totalCost >  0 || !empty($totalCost)){
			          ?>
          				 <tr>
					            <td class="tdBorderRt">&nbsp;&nbsp;<i><?php echo "Registration Charges";?></i></td>
					            <td align="right" valign="top" class="tdBorderRt"><strong>1</strong></td> 
					            <td align="right" valign="top"><strong><?php echo $this->Number->format($data['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false));?></strong></td>
					      </tr>
					       <tr>
					            <td class="tdBorderRt">&nbsp;&nbsp;<i><?php echo ($data['TariffList']['name'])?$data['TariffList']['name']:"Consultation Fees";?></i></td>
					            <td align="right" valign="top" class="tdBorderRt"><strong>1</strong></td> 
					            <td align="right" valign="top" ><strong><?php echo $this->Number->format($consultationCharge['TariffAmount'][$hosType],array('places'=>2,'decimal'=>'.','before'=>false));?></strong></td>
					      </tr>
			          	<?php } ?>
			          <tr>
			            <td valign="top" align="right" class="tdBorderTpRt"><strong>Total</strong></td>
			            
			            <td valign="top" align="right" class="tdBorderTpRt">&nbsp;</td>
			             
			            <td valign="top" align="right" class="tdBorderTp totalPrice"><strong><span class="WebRupee"></span><?php echo $this->Number->currency($totalCost) ;?></strong></td>
			          </tr>
			          <tr>
						    <td width="100%" align="left" valign="top" class="tdBorderTp" colspan="5">
						        <table width="100%" border="0" cellspacing="0" cellpadding="0">
						          <tr>
						            <td valign="top" class="boxBorderRight columnPad">
						            	Amount Chargeable (in words): &nbsp;&nbsp;&nbsp;
										<strong>
											<?php	echo $this->RupeesToWords->no_to_words($totalCost); ?></strong>            </td>
						            	<td width="292">
						            	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="">
						                	 
						                	<tr>
						                		
						                	   <td height="20" valign="top" class="tdBorderRtBt">&nbsp;To Pay</td>
						                	   
						                	  <td align="center" valign="top" class="tdBorderBt" style="text-align:right;">
						                	  		<?php 
						                	  			echo $this->Number->currency($totalCost);
						                	  		 	echo $this->Form->hidden('id',array('size'=>'40','value'=>$patient_id));
						                	  		 	echo $this->Form->hidden('cost',array('value'=>$totalCost));
						                	  		?>
						                	  </td>
						               	  	</tr>
						               	  	<tr>
						                	  <td height="20" valign="top" class="tdBorderRtBt">&nbsp;Remark</td>
						                	  <td align="center" valign="top" class="tdBorderBt" style="text-align:right;">
						                	  		<?php 
						                	  			
						                	  		 	echo $this->Form->textarea('remark',array('style'=>'width:215px;','size'=>'40','value'=>$data['Patient']['remark']));
						                	  		 	//echo $this->Form->hidden('id',array());
						                	  		?>
						                	  </td>
						               	  	</tr>
						               	  	<tr>
						               	  		<td align="center" colspan="2" height="40">
						               	  			<?php  
						               	  				if($data['Patient']['fee_status']!='paid' && ($totalCost >  0 || !empty($totalCost))){   
							               	  				echo $this->Form->submit('Pay',array('class'=>'blueBtn','align'=>'right','div'=>false,'label'=>false));
						               	  				}	 
							               	  				echo $this->Html->link('Cancel',array("controller" => "Appointments",'action'=>'appointments_management','?'=>array('type'=>'OPD')),array('escape'=>false,'class'=>'grayBtn'));
						               	  				
						               	  			?>
						               	  		</td>
						               	  	</tr>
						              </table>
						            </td>
						          </tr>
						        </table>
						    </td>
						  </tr>
			        </tbody>
			      </table>
			      <?php 					
				echo $this->Form->end();
				 
				if(isset($_GET['payment']) && !empty($_GET['id'])){
					echo "<script>var openWin = window.open('".$this->Html->url(array('action'=>'opd_payment_receipt_print',$_GET['id']))."', '_blank',
					           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');    </script>"  ;
				}
	?>
	<script>
	 
			
	jQuery(document).ready(function(){
	// binds form submission and fields to the validation engine
		jQuery("#orderfrm").validationEngine();
	});
	
</script>
				