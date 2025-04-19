<div class="inner_title">
	<h3>
		<?php echo __('SMS Trigger', true); ?>
	</h3>
	<span><?php //echo $this->Html->link(__('Back', true),array('controller' => 'Locations', 'action' => 'index','admin'=>true), array('escape' => false,'class'=>'blueBtn'));
	?></span>
</div>


<?php //echo $this->Form->create('',array("controller"=>"Message","action" => "smsTrigger", "admin" => false,'type' => 'file','id'=>'locationfrm','inputDefaults' => array('label' => false, 'div' => false, 'error' => false	)));
//echo $this->Form->create('Return',array("controller"=>"Message","action" => "smsTrigger",'id'=>'returnForm'));?>
<table	border="0" class="table_format" cellpadding="0" cellspacing="0"	width="50%" align="left">
	<tr>
		<td>
		<?php $getSmsArr=Configure::read('sms_active');
		asort($getSmsArr);?>
		</td>
		<td align="left">
	   	<span style="float:left;width:500px;">
	    	 <div style="overflow-x: hidden; overflow-y: scroll; height: 400px;">
                  <?php echo $this->Form->checkBox('allLocation',array('value'=>$key,'hiddenField'=>false,'class'=>'all')); 
					 echo $this->Form->hidden('sms_idfg',array('type'=>'text','div'=>false,'label'=>false,'id'=>'configuration_id','name'=>'sms_id','value'=>$configurationsSmsData['Configuration']['id']))?>
                  <?php echo __('All');
				  if(!empty($configurationsSmsData['Configuration']['value'])){
					 $getUnserializeArr=unserialize($configurationsSmsData['Configuration']['value']);						
					 asort($getUnserializeArr);						 		
							foreach($getUnserializeArr as $selectedValue){							
								if(in_array($selectedValue,$getSmsArr)){
									$check[$selectedValue]='checked';
								}else{
									$check[$selectedValue]="";
								}
								
							}
							$getSmsArrs="";
				  }else{
						//$valueSms=$getSmsArrs;
						$check[$selectedValue]='';
				  }
				 ?>
                  <?php foreach ($getSmsArr as $key=>$getSmsArrs){
				 ?>
                  <div>
                      <?php 
					  echo $this->Form->checkBox('hhgg',array('name'=>'chk_box[]','value'=>$getSmsArrs,'hiddenField'=>false,'checked'=>$check[$getSmsArrs])); ?>
                      <?php echo $getSmsArrs; ?>
                  </div>
                  <?php } ?>
              </div>
	    </span>
	    </td>
	</tr>
</table>
 <!--<div align="center">  
	<div class="btns" style="float:none">
	<?php echo $this->Html->link(__('Submit'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn','id'=>'Submit1')); ?>
	</div>
 </div>-->

<?php //echo $this->Form->end(); ?>

<script>
$(function() {
	  $('.all').click(function() {
	        var $checkboxes = $(this).parent().find('input[type=checkbox]');
	        $checkboxes.prop('checked', $(this).is(':checked'));
	    });  
});
</script>