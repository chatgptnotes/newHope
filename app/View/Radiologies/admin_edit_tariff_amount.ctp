<script>
function copyStandards(){ 
	document.copyStandard.submit();	
}
</script>


<table width="100%" cellspacing="1" cellpadding="0" border="0" style="margin:10px 0px;">
<tr><td><strong><?php echo $tariffStandards[$tariffStandardId];?></strong></td>
<td align="right" width="">
	<?php  	
			echo $this->Html->css(array('internal_style','jquery.autocomplete'));  
	   		echo $this->Html->script(array('jquery-1.5.1.min','jquery.autocomplete'));
	   		/*echo $this->Form->create('',array('url'=>array('controller'=>'radiologies','action'=>'edit_tariff_amount',$tariffStandardId),'type' => 'get','id'=>'tariffAmountSearch',
								'inputDefaults' => array('label' => false,'div' => false,'error' => false)));
			echo $this->Form->input('rad_name',array('id'=>'rad_name','class'=>'','label'=>false,'div'=>false,'error'=>false)) ;
			echo $this->Form->submit('Search',array('class'=>'blueBtn','title'=>'Search','label'=>false,'div'=>false,'error'=>false));
			echo $this->Form->end();*/
	?>
	<?php 
		echo $this->Form->create('',array('name'=>'copyStandard','url'=>array('controller'=>'radiologies','action'=>'edit_tariff_amount',$tariffStandardId),'id'=>'copytariffamount','inputDefaults' => array(
																								        'label' => false,
																								        'div' => false,
																								        'error' => false
		)));
		echo $this->Html->link(__('Back'),array('action'=>'view_tariff'),array('escape' => false,'class'=>'blueBtn')) ;
	?>
	Copy From
	<?php
		echo $this->Form->input('TariffStandard.standardName', array('onchange'=>'copyStandards()','style'=>'width:160px','empty'=>'Please Select','options'=>$tariffStandards,'class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','id' => 'tariffstandard')); 
		echo $this->Form->end();
	?>
</td>
 
</td>
</tr>
</table>
	<?php 
		echo $this->Form->create('',array('url'=>array('controller'=>'laboratories','action'=>'corporate_lab_rate'),'id'=>'tariffamount',
								'inputDefaults' => array('label' => false,'div' => false,'error' => false)));
	?>
	<table width="100%" cellspacing="1" cellpadding="0" border="0" class="tabularForm">
    	<tbody><tr>
        	<!-- <th width="30" style="text-align: center;">I.D.</th> -->
            <th>Name</th>
            <?php 
                            $nabhType=$this->Session->read('hospitaltype');
                            if($nabhType=='NABH'){
                            
                            	?>
                            <th width="100" style="text-align: center;">NABH</th>
                            <?php }else{?>
                            <th width="100" style="text-align: center;">Non NABH</th>
                            <?php }?> 
                        </tr>
                        
 			<?php
	 
 			foreach($labData as $key=>$tariff){ ?>                       
                   	<tr>
                             
                            	<?php  $counter = $key+1 ;?> 
                                <td><?php echo $tariff['Radiology']['name'] ;?></td>
                                <td valign="top">
	                                <?php 
 										if(isset($tariff['CorporateLabRate']['id'])){
		                               		echo $this->Form->hidden('',array('name'=>"data[CorporateLabRate][$counter][id]",'value'=>$tariff['CorporateLabRate']['id']));
		                               		if(!empty($this->request->data['TariffStandard']['standardName'])){
		                               			$nabh_rate = $copyData[$key]['CorporateLabRate']['nabh_rate'];
		                               			$non_nabh_rate = $copyData[$key]['CorporateLabRate']['non_nabh_rate'];
		                               		}else{
		                               			$nabh_rate = $tariff['CorporateLabRate']['nabh_rate'];
		                               			$non_nabh_rate = $tariff['CorporateLabRate']['non_nabh_rate'];
		                               		}
		                               	}else{
		                               		 
		                               		if(!empty($this->request->data['TariffStandard']['standardName'])){
		                               			$nabh_rate = $copyData[$key]['CorporateLabRate']['nabh_rate'];
		                               			$non_nabh_rate = $copyData[$key]['CorporateLabRate']['non_nabh_rate'];
		                               		}else{
		                               			$nabh_rate = '0';
		                               			$non_nabh_rate='0';
		                               		}
		                               	}
		                               	if($nabhType=='NABH'){
		                               		echo $this->Form->input('', array('name'=>"data[CorporateLabRate][$counter][nabh_rate]",'type'=>'text','class' => '',
		                                	 								'value'=>$nabh_rate,'id' => "rate-$counter",'size'=>6,'maxLength'=>15,'width'=>'80%','label' => false,'div' => false,'error'=>false));
		                               	}else{ 
		                              		echo $this->Form->input('', array('name'=>"data[CorporateLabRate][$counter][non_nabh_rate]",'type'=>'text','class' => '',
		                                	 								'value'=>$non_nabh_rate,'id' => "rate-$counter",'size'=>6,'maxLength'=>15,'width'=>'80%','label' => false,'div' => false,'error'=>false));
		                               	}
		                               	echo $this->Form->hidden('',array('name'=>"data[CorporateLabRate][$counter][laboratory_id]",'value'=>$tariff['Radiology']['id']));
		                               	echo $this->Form->hidden('',array('name'=>"data[CorporateLabRate][$counter][department]",'value'=>'radiology'));
		                               	echo $this->Form->hidden('',array('name'=>"data[CorporateLabRate][$counter][tariff_standard_id]",'value'=>$tariffStandardId));
	                               	?>
                                </td>
                                
                   </tr>
 		 <?php } ?> </tbody></table> 
                    
                    <div class="btns">
               		<?php 
                           	echo $this->Html->link(__('Cancel'),array('action'=>'view_tariff'),array('escape' => false,'class'=>'grayBtn')) ;
					 		echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
					 		?>		
</div>
 
  <?php echo $this->Form->end();?>                           
  <script>
  $(document).ready(function(){
 	 
		$("#rad_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Radiology","name",'null','null','null','null','is_active=1', "admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true
		});
  });
  </script>
  