<?php
header ("Expires: Mon, 28 Oct 2008 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment;  filename=\"Service_Group_Report_".$this->DateFormat->formatDate2Local(date('Y-m-d H:i:s'),Configure::read('date_format'), true)
.".xls");
header ("Content-Description: Generated Report" );
ob_clean();
flush();
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
#msg {
    width: 180px;
    margin-left: 34%;
}
</style>

	<table cellspacing="0" cellpadding="0" width="100%" align="center" style="margin-top: 20px">
		<tr>
			<td><b><?php 
			echo __('Ledger : '); echo ucwords($serviceType);?>
			</b></td>
			<td align="right" colspan="5"><?php  $from1=explode(' ',$from);echo $from1[0];
			echo "  To ";  $to1=explode(' ',$to);echo $to1[0];?>
			</td>
		</tr>
	</table>
	
	<table class="formFull" width="100%" align="center" cellspacing="0" cellpadding="1" border="1">
		<tr class="row_gray">
			<th class="tdLabel" style="width:9%"><?php echo __('Date');?></th>
			<th class="tdLabel" style="width:39%"><?php echo __('Particulars');?></th>
			<th class="tdLabel" style="width:7%"><?php echo __('Voucher Type');?></th>
			<th class="tdLabel" style="width:9%"><?php echo __('Voucher Number');?></th>
			<th class="tdLabel" style="width:14%"><?php echo __('Debit');?></th>
			<th class="tdLabel" style="width:14%"><?php echo __('Credit');?></th>
		</tr>
	<?php
	$toggle=0;$row=0;ksort($ledger);
			foreach($ledger as $key=>$entry){	
					ksort($entry);
					foreach($entry as $key=>$data)
					{
					if($toggle == 0) {
						echo "<tr>";
						$toggle = 1;
					}else{
						echo "<tr class='row_gray'>";
						$toggle = 0;
					}

	//for journal entry
	if(isset($data['VoucherEntry'])){?>
			<td class="tdLabel" align="center"><?php echo $this->DateFormat->formatDate2Local($data['VoucherEntry']['date'],Configure::read('date_format'),false); ?></td>
			<td class="tdLabel">
				<?php echo $data['AccountAlias']['name'];?>
				<br><i><?php echo __('Narration : ').$data['VoucherEntry']['narration'];?></i>
			</td>
			<td class="tdLabel"><?php echo 'Journal'; ?></td>
			<td class="tdLabel"><?php echo $data['VoucherEntry']['id'];?></td>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel">
				<?php 
				$credit=$credit+$data['VoucherEntry']['debit_amount'];
					echo $this->Number->currency($data['VoucherEntry']['debit_amount']);
				?>
			</td>	 
			<?php }
			} 
		}
			 // if no data to display...	
			 if(empty($ledger)){?>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="4" style="text-align: center;"><?php echo "No Records Found"?></td></tr>
			<tr><td colspan="7">&nbsp;</td></tr>
			<tr><td colspan="7">&nbsp;</td></tr><?php    }
			//?>
			<tr><td colspan="6" style="border-top: solid 2px #3E474A;margin-bottom:-1px"></td></tr>
	
		<tr>
		<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Opening Balance :');?></td>
		<?php if(empty($opening)){?>
		<td class="tdLabel"><?php echo " ";?></td>		
		<?php }
		else{
				if($type=='Dr'){
						$close=($opening+$debit)-$credit;	?>
						<td class="tdLabel">
						<?php echo $this->Number->currency($opening).' Dr';?></td>
						<td class="tdLabel" ><?php echo " ";?></td>
						
			<?php }
			elseif($type=='Cr'){
						$close=($opening+$credit)-$debit;	?>
						<td class="tdLabel" ><?php echo " ";?></td>
						<td class="tdLabel" >
						<?php echo $this->Number->currency($opening).' Cr';?></td>					
			<?php }	
   		}?>
		</tr>
		<tr class="row_gray">
		<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Current Balance :');?></td>
		<td class="tdLabel">
		<?php if(!empty($debit)){
				echo $this->Number->currency($debit).' Dr';
			}
				else echo " ";
		?>
		</td>
		<td class="tdLabel"><?php if(!empty($credit)){
				echo $this->Number->currency($credit).' Cr';
			}
				else echo " ";?>
		</td>
		</tr>
		<tr>
		<td class="tdLabel" colspan="4" style="text-align: right;"><?php echo __('Closing Balance :');?>
		</td>
		<?php 
		if(empty($opening)){
			$close=$credit-$debit;
			if(empty($close)){ ?>
				<td class="tdLabel"><?php echo " ";?></td>
				<td class="tdLabel"><?php echo " ";?></td><?php
			}elseif($close<0){ ?>
				<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
				<td class="tdLabel"><?php echo " ";?></td><?php 
			}else{ ?>
				<td class="tdLabel"><?php echo " ";?></td>
				<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
			<?php } 
		}//end of if
		elseif($close==$opening){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo $this->Number->currency($close * (-1)).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
		<?php }
		}//end  of else if
		elseif($close>0){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency($close).' Cr'?></td>
		<?php }
		}
		elseif($close<0){
		if($type=='Dr'){
		?>
			<td class="tdLabel"><?php echo " ";?></td>
			<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Cr'?></td>
		<?php }elseif($type=='Cr'){?>
			<td class="tdLabel"><?php echo $this->Number->currency(-($close)).' Dr'?></td>
			<td class="tdLabel"><?php echo " ";?></td><?php
		}
		} ?>
		</tr>  
</table>