<script>
function copyStandards(){
document.copyStandard.action="<?php echo $this->Html->url('copyTariffAmount');?>";
document.copyStandard.submit();	
}
</script>
<?php 
echo $this->Form->create('',array('name'=>'copyStandard','controller'=>'tariffs','action'=>'copyTariffAmount','type' => 'file','id'=>'tariffamount','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));
?>

<table width="100%" cellspacing="1" cellpadding="0" border="0" style="margin-bottom:10px;">
<tr><td><strong><?php echo $tariffStandardsData['TariffStandard']['name'];?></strong></td>
<td>&nbsp;</td>
<td align="right">
Copy From
<?php echo $this->Form->input('TariffStandard.standardName', array('onchange'=>'copyStandards()','style'=>'width:160px','options'=>$tariffStandards,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'tariffstandard')); ?>
<?php //echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
</tr>
</table>
 <?php 
 echo $this->Form->hidden('TariffList.tariffStandardId', array('value'=>$tariffStandardId));
 echo $this->Form->end();?>
<?php 
echo $this->Form->create('',array( 'controller'=>'tariffs','action'=>'addCopyAmount','id'=>'tariffamount','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));
echo $this->Form->hidden('tariffStandardId', array('value'=>$tariffStandardId));
																								    ?>


<table width="100%" cellspacing="1" cellpadding="0" border="0" class="tabularForm">
                    	<tbody><tr>
                        <!-- 	<th width="30" style="text-align: center;">I.D.</th> -->
                            <th>Name</th>
                            <th width="80" style="text-align: center;"><?php echo $tariffStandardsData['TariffStandard']['name'];?> MOA Sr. No.</th>
                            <?php 
                            $nabhType=$this->Session->read('hospitaltype');
                            if($nabhType=='NABH'){?>
                            <th width="100" style="text-align: center;">NABH</th>
                            <?php }else{?>
                            <th width="100" style="text-align: center;">Non NABH</th>
                            <?php }?>
                            <th width="100" style="text-align: center;">Validity DAYS</th>
                            <!-- <th width="100" style="text-align: center;">Apply In a day</th> -->
                        </tr>
                        
 <?php 
 
 $i=0 ;
 foreach($data as $tariff){//pr($tariff);exit;
 	
 	?>                       
                   		<tr>
                   		<!--   <td align="center">1.</td> -->
                          <td><?php echo mb_convert_encoding($tariff['TariffList']['name'], 'HTML-ENTITIES', 'UTF-8');
        #echo $this->Form->hidden('', array('name'=>'data[TariffAmount][id][]','value'=>$tariff['TariffList']['id']));
                          ?></td>
        
   <td>
    <?php 
    if($tariff['TariffAmount']['moa_sr_no']!=''){
    	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]",'type'=>'text','value'=>$tariff['TariffAmount']['moa_sr_no']));
    ?>
    <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]";?>" value="<?php echo $tariff['TariffAmount']['moa_sr_no'];?>">
    <?php 	
    }else{
    	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]",'type'=>'text'));
    ?>
    <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][moa_sr_no]";?>" >
    <?php 
    }
    ?>
         
                   		  
   <?php 
   
   //echo $this->Form->hidden('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][tariff_standard_id]",'value'=>$tariffStandardId));    
  ?>
  <input type="hidden" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][tariff_standard_id]";?>" value="<?php echo $tariffStandardId;?>">
  </td>
  <?php 
   if($tariff['TariffAmount']['nabh_charges'])
   		$nabhAmt = $tariff['TariffAmount']['nabh_charges'] ;
   	else
   		$nabhAmt = 0.00;
   		
   	if($tariff['TariffAmount']['non_nabh_charges'])
   		$nonNabhAmt = $tariff['TariffAmount']['non_nabh_charges'] ;
   	else
   		$nonNabhAmt = 0.00;

    
   	//EOF current amt 
   	if($currentData[$i]['TariffAmount']['id']){
   		$amtID = $currentData[$i]['TariffAmount']['id'] ;
   	}else{
   		$amtID= '' ;
   	}	
   	if($nabhType=='NABH'){?>
   		
   <td align="center"> 		
   <?php 
   //echo $this->Form->hidden('', array('value'=>$amtID,'type'=>'text','name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][id]"));
   //echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][nabh_charges]",'type'=>'text','value'=>$nabhAmt,'class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;')); 
   ?>
   <input type="hidden" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][id]";?>" value="<?php echo $amtID;?>">
   <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][nabh_charges]";?>" value="<?php echo $nabhAmt;?>">
   </td>
   <?php }else{?>  
                   		  <td align="center">
                   		  
     <?php 
     //echo $this->Form->hidden('', array('value'=>$amtID,'type'=>'text','name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][id]"));
     //echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][non_nabh_charges]",'type'=>'text','value'=>$nonNabhAmt,'class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;')); 
     ?>
     <input type="hidden" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][id]";?>" value="<?php echo $amtID;?>">
     <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][non_nabh_charges]";?>" value="<?php echo $nonNabhAmt;?>">
     </td>
     <?php }?>
<td align="center">
     <?php 
     if($tariff['TariffAmount']['unit_days']!=''){
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]",'type'=>'text','value'=>$tariff['TariffAmount']['unit_days'],'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
	?>
	<input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]";?>" value="<?php echo $tariff['TariffAmount']['unit_days'];?>">
	<?php  	
     }else{
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]",'type'=>'text','value'=>1,'class' => 'validate[required,custom[mandatory-date]] textBoxExpnd','style'=>'width:150px;text-align:right;'));
     	?>
     	<input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][unit_days]";?>" value="1">
     <?php 		
     }
     ?>
     </td>
     
     <!-- 
     <td align="center">
     <?php 
     if($tariff['TariffAmount']['apply_in_a_day']!=''){
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]",'type'=>'text','value'=>$tariff['TariffAmount']['apply_in_a_day'],'class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','style'=>'width:50px;text-align:right;'));
     	?>
     <input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]";?>" value="<?php echo $tariff['TariffAmount']['apply_in_a_day'];?>">
     <?php 	 
     }else{
     	//echo $this->Form->input('', array('name'=>"data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]",'type'=>'text','class' => 'validate[required,custom[mandatory-enter-only]] textBoxExpnd','style'=>'width:50px;text-align:right;'));
     	?>
     	<input type="text" name="<?php echo "data[TariffAmount][".$tariff['TariffList']['id']."][apply_in_a_day]";?>" >
     <?php 		
     }
     ?>
     </td>
      -->
               		  </tr>
 <?php
	$i++;	
 }?>                  		                 		
                   </tbody></table>
          <?php 
                         //  	echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
					 		
					 		
					 		?>		
  <div class="btns">
          <?php 			
          echo $this->Html->link(__('Cancel'),'/tariffs/viewTariffAmount',array('escape' => false,'class'=>'grayBtn')) ;
          echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
					 		
					 		
					 		?>		
                    </div>                  
  <?php echo $this->Form->end();?>                           