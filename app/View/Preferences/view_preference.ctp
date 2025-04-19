<style>
.table_format label{width:135px;text-align:left;}
.table_formatCls{
    border: 1px solid black;
}
</style><div class="inner_title">
 <h3><?php echo __('Preference Card'); ?></h3>
<span> <?php echo $this->Html->link("Back",array('controller'=>!empty($returnController)?$returnController:'preferences','action'=>'user_preferencecard',$patient_id,$this->request->pass[2]),array('escape'=>false,'class'=>'blueBtn')); ?></span>
</div>

<div class="clr"></div>
<p class="ht5"></p>  

	<!-- BOF new HTML -->	 
	 	 	 
			 <table class="table_format table_formatCls"  id="schedule_form" align="center">	
			 <tr >
			    <td class="form_lables" align="right">
			    <?php echo __('Preference Card Title :');?>
			    </td>
			    <td>
			    	 
			    	<?php  
			    		echo $getData['Preferencecard']['card_title'];
			    	?>
			     	
			    </td>
			   </tr>			    			    
			   <tr>
			    <td class="form_lables" align="right">
			    <?php echo __('Procedure Name :');?>
			    </td>
			    <td align="center">
			    	<table align="center">
			    	<?php foreach($getData['Procedure'] as $key=>$val){?>
				    	<tr><td>
					    	<?php 	echo $val['Surgery']['name'];?>
				    	</td>
				    	</tr>
			    	<?php }?>
			    	</table>
			    </td>
			   </tr>				   
			   <tr>
			    <td class="form_lables" align="right">
			    <?php echo __('Primary Care Provider :');?>
			    </td>
			    <td>
			    	<?php
			    		echo $getData['User']['first_name'].' '.$getData['User']['last_name'];
			    	?>
			     	
			    </td>
			   </tr>
			   
			    <tr>
			    <td class="form_lables" align="right" valign="top">
			    <?php echo __('Instrument Set Name :');?>
			    </td>
			    <td valign="top">
			    	<?php 		    	
			    	$countInstr=1;				    	
			           foreach($getData['PreferencecardInstrumentitem'] as $keyInstr=>$getDataInstr){?>
					   <table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center" >
			           <tr>
			           <td style="padding-bottom:5px;"><strong><?php  echo $countInstr.'.'; ?></strong><?php echo $getDataInstr['item_name'];?>
			           </td>
			           </tr>
			           </table>
			           <?php $countInstr++;}?>
			           	     	
			    </td>
			   </tr>
			   
			    <tr>
			    <td class="form_lables" align="right">
			    <?php echo __('Equipment Name :');?>
			    </td>
			    <td>
			    	<?php
			    	echo $getData['Preferencecard']['equipment_name'];
			    	?>
			     	
			    </td>
			   </tr>
			   
			    <tr>
			    <td class="form_lables" align="right" valign="top">
			    <?php echo __('CSSD Name :');?>
			    </td>
			    <td valign="top">
			    	<?php 		    	
			    	$countCssd=1;	    	
			           foreach($getData['PreferencecardSpditem'] as $keyCssd=>$getDataCssd){?>
					   <table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
			           <tr>
			           <td style="padding-bottom:5px;"><strong><?php  echo $countCssd.'.'; ?></strong><?php echo $getDataCssd['item_name'];?><strong> | </strong> Qty : <?php echo $getData['PreferencecardSpditem'][$keyCssd]['quantity']?>
			           </td>
			           </tr>
			           </table>
			           <?php $countCssd++;}?>
			           	     	
			    </td>
			   </tr>
			   
			   <tr>
			    <td class="form_lables" align="right" valign="top">
			    <?php echo __('Lab Item Name :');?>
			    </td>
			    <td valign="top">
			    	<?php 		    	
			    	$countOr=1;				    	
			           foreach($getData['PreferencecardOritem'] as $keyOr=>$getDataOr){?>
					   <table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
			           <tr>
			           <td style="padding-bottom:5px;"><strong><?php  echo $countOr.'.'; ?></strong><?php echo $getDataOr['item_name'];?><strong> | </strong> Qty : <?php echo $getData['PreferencecardOritem'][$keyOr]['quantity']?>
			           </td>
			           </tr>
			           </table>
			           <?php $countOr++;}?>
			           	     	
			    </td>
			   </tr>
			   
                <tr>
			    <td class="form_lables" align="right" valign="top">
			    <?php echo __('Medications Name:');?>
			    </td>
			    <td valign="top">
			    	<?php  $getUnserMedData=unserialize($getData['Preferencecard']['medications']);	
			    	$getUnserQtyData=unserialize($getData['Preferencecard']['quantity']);
			    	$count=1;	
			    	$countAdd=0;    	
			           foreach($getUnserMedData['0'] as $keyMed=>$getDataMed){
						?>
					   <table border="0" cellpadding="0" cellspacing="0" width="100%"  align="center">
			           <tr>
			           <td style="padding-bottom:5px;"><strong><?php  echo $count.'.'; ?></strong> <?php echo $getPharmacyData[$countAdd]['PharmacyItem']['name'];?><strong> | </strong> Qty : <?php echo $getUnserQtyData['0'][$keyMed]?>
			           </td>
			           </tr>
			           </table>
			           <?php $countAdd++;
			           $count++;}?>
			           	     	
			    </td>
			   </tr>
			   
			    <tr>
			    <td class="form_lables" align="right">
			    <?php echo __('Dressing :');?>
			    </td>
			    <td>
			    	<?php
			            echo $getData['Preferencecard']['dressing'];
			    	?>
			     	
			    </td>
			   </tr>
			   
			    <tr>
			    <td class="form_lables" align="right">
			    <?php echo __('Prep and Position :');?>
			    </td>
			    <td>
			    	<?php
			            echo $getData['Preferencecard']['position'];
			    	?>
			     	
			    </td>
			   </tr>
			   <tr>
			    <td class="form_lables" align="right">
			    <?php echo __('Notes :');?>
			    </td>
			    <td>
			    	<?php
			            echo $getData['Preferencecard']['position'];
			    	?>
			     	
			    </td>
			   </tr>
			  </table>	