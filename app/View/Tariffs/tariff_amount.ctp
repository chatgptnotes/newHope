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
 echo $this->Form->hidden('tariffStandardId', array('value'=>$tariffStandardId));
 echo $this->Form->end();?>
<?php 
echo $this->Form->create('',array('controller'=>'tariffs','action'=>'saveTariffAmount','type' => 'file','id'=>'tariffamount','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
																								    )));

$nabhType=$this->Session->read('hospitaltype');																								    
?>


<table width="100%" cellspacing="1" cellpadding="0" border="0" class="tabularForm">
                    	<tbody><tr>
                        	<!-- <th width="30" style="text-align: center;">I.D.</th> -->
                            <th>Name</th>
                            <?php if($nabhType=='NABH'){?>
                            <th width="100" style="text-align: center;">NABH</th>
                            <?php }else{?>
                            <th width="100" style="text-align: center;">Non NABH</th>
                            <?php }?>
                        </tr>
                        
 <?php 
 echo $this->Form->hidden('tariffStandardId', array('value'=>$tariffStandardId));
 
                            
 foreach($data as $tariff){?>                       
                   		<tr>
                   		 <!--  <td align="center">1.</td> -->
                          <td><?php echo $tariff['TariffList']['name'];
        #echo $this->Form->hidden('', array('name'=>'data[TariffAmount][id][]','value'=>$tariff['TariffList']['id']));
                          ?></td>
   <?php if($nabhType=='NABH'){?>                       
                   		  <td align="center">
   <?php echo $this->Form->input('', array('name'=>"data[TariffAmount][nabh_charges][".$tariff['TariffList']['id']."]",'value'=>$tariff['TariffAmount']['nabh_charges'],'type'=>'text','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;')); ?>
  
  
   </td>
   <?php }else{?>       
                   		  <td align="center">
                   		  
     <?php echo $this->Form->input('', array('name'=>"data[TariffAmount][non_nabh_charges][".$tariff['TariffList']['id']."]",'value'=>$tariff['TariffAmount']['non_nabh_charges'],'type'=>'text','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;')); ?>
     </td>
     <?php }?>
               		  </tr>
 <?php }?>                  		                 		
                   </tbody></table>
                   <div class="btns">
          <?php 			
          echo $this->Html->link(__('Cancel'),'/tariffs/index',array('escape' => false,'class'=>'grayBtn')) ;
                           	echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
					 		
					 		
					 		?>		
                    </div>
  <?php echo $this->Form->end();?>                           