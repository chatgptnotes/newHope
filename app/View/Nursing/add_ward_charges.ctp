<style>
.patientHub .patientInfo .heading {
    float: left;
    width: 174px;
}
<?php 
  echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
        <h3 >
        	<?php
        		echo $this->Html->image('icons/patient-owner-icon.png');
        		echo __("Generate Invoice");
        	?>        	
        </h3>
        <span>
        	<?php 
        		 echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information/',$this->params['pass'][0]), 
        		 array('escape' => false,'class'=>'blueBtn'));
        	?>
        </span>
</div>
<p class="ht5"></p>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div> 
	<?php       
		echo $this->Form->create('',array('type' => 'file','id'=>'servicefrm','inputDefaults' => array(
										'label' => false,'div' => false,'error' => false)));	    ?>                 
                    
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
        	<tr>
        		<td width="20%">
        			<?php 
        				echo $this->Html->link(__('View Patient Services'),array('controller'=>'billings','action' => 'viewAllPatientServices',
        				$patient['Patient']['id'],'?'=>array('return'=>'nursing')),array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:0px;'));
        			?>
        		</td>
                <td align="left" width="21%" >Service Name&nbsp;&nbsp;<?php echo $this->Form->input('', array('name'=>'service_name','type'=>'text','id' => 'serviceName','style'=>'width:150px;','autocomplete'=>'off')); ?>	
                <td width="2%"><?php echo $this->Form->submit('Search', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));?></td>
  				<td width="5%"><?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'addWardCharges', $patient_id),array('escape'=>false, 'title' => 'refresh'));?></td>
  				<td width="20%" style="text-align:right;">
  					&nbsp;
  				</td>                        	  
 			</tr>
 		</table>
 	<?php 	echo $this->Form->end();?> 
 	<?php if(!empty($services)){ ?>
    <?php
    		echo $this->Form->create('',array('type' => 'file','id'=>'servicefrm','inputDefaults' => array(
	        							  'label' => false,'div' => false,'error' => false)));
																								    
			echo $this->Form->hidden('Nursing.patient_id', array('value'=>$patient_id));																								    

    ?>     
      
     <!-- date section end here -->
     <div class="clr ht5"></div>  
      <table align="right" width="100%">
      	<tr>
                   			<td>
                   				<?php 
						            if($service_date!=''){
						            	echo $this->Form->input('date', array('value'=>$this->DateFormat->formatDate2Local($service_date,Configure::read('date_format')),'type'=>'text','id' => 'billDate','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;','readonly'=>'readonly')); 
						            }else{
						            	echo $this->Form->input('date', array('value'=>date('d/m/Y'),'type'=>'text','id' => 'billDate','class' => 'validate[required,custom[mandatory-date]]','style'=>'width:150px;','readonly'=>'readonly'));
						            }
					            ?>
                   			</td>
                   		</tr>
      </table>
                   <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" id="serviceGrid"> 
                   <tr>
                        <th width="150">PARTICULAR</th>
                           <!--  <th>&nbsp;</th> -->
                            <th width="85" style="text-align:right;">UNIT PRICE</th>
                            <th width="70" style="text-align:center;">MORNING</th>
                            <th width="70" style="text-align:center;">EVENING</th>
                            <th width="70" style="text-align:center;">NIGHT</th>
                            <th width="70" style="text-align:center;">No Of Times</th>
                        </tr>
                        
                        <?php 
                        $morning=$evening=$night='';
                       
                        foreach($services as $service){ 
	                        if($service['ServiceBill']['morning'] ==1){
	                        	$morning='checked';
	                        }
	                        if($service['ServiceBill']['evening'] ==1){
	                        	$evening='checked';
	                        }
	                        if($service['ServiceBill']['night'] ==1){
	                        	$night='checked';
	                        }
	                        if(!empty($service['ServiceBill']['no_of_times'])){
	                        	$noOfTimes=$service['ServiceBill']['no_of_times'];
	                        }
	                         
	                        ?>
	                        <tr>
		                        <td width="150"><?php echo mb_convert_encoding($service['TariffList']['name'], 'HTML-ENTITIES', 'UTF-8');?></td>
		                           <!--  <td>&nbsp;</td> -->
		                            <td width="85" style="text-align:right;"><?php 
			                            $hospitalType = $this->Session->read('hospitaltype');
			                            if($hospitalType == 'NABH'){
			                            	echo $this->Number->currency($service['TariffAmount']['nabh_charges']);
			                            }else{
			                            	echo $this->Number->currency($service['TariffAmount']['non_nabh_charges']);
			                            }
		                            ?></td>
		                            <td width="70" style="text-align:center;">
		                            <?php $temp = $service['TariffList']['id']; 
			                            echo $this->Form->checkbox('', array('name'=>"data[Nursing][$temp][morning]",'id' => 'morning'.$temp,'value'=>1,
			                            'checked'=>$morning,'onchange'=>"defaultNoOfTimes('morning$temp','$temp');
			                            checkApplyInADay(".$service['TariffList']['id'].",".$patient['Patient']['tariff_standard_id'].",$temp,"
									 			.$service['TariffList']['apply_in_a_day'].");")); ?>                          
		                            </td>
		                            <td width="70" style="text-align:center;">
									 	<?php echo $this->Form->checkbox('', array('name'=>"data[Nursing][$temp][evening]",'id' => 'evening'.$temp,'value'=>1,
									 			'checked'=>$evening,'onchange'=>"defaultNoOfTimes('evening$temp','$temp');
									 			checkApplyInADay(".$service['TariffList']['id'].",".$patient['Patient']['tariff_standard_id'].",$temp,"
									 			.$service['TariffList']['apply_in_a_day'].");")); ?>
									</td>
									<td width="70" style="text-align:center;">
										<?php echo $this->Form->checkbox('', array('name'=>"data[Nursing][$temp][night]",'id' => 'night'.$temp,'value'=>1,
										'checked'=>$night,'onchange'=>"defaultNoOfTimes('night$temp','$temp');
										checkApplyInADay(".$service['TariffList']['id'].",".$patient['Patient']['tariff_standard_id'].",$temp,"
									 			.$service['TariffList']['apply_in_a_day'].");")); ?>                            
									</td>
									<td width="70" style="text-align:center;">
									  	<input type="text" id="noOfTimes<?php echo $temp;?>" name="data[Nursing][<?php echo $temp;?>][no_of_times]" 
									  	value="<?php echo $noOfTimes;?>"> 
									</td>                               
	                        </tr>
                        <?php } ?>
                   </table>
                   <div id="pageNavPosition" align="center"></div>
                   <!-- billing activity form end here -->
                   <div>&nbsp;</div>
               <div class="btns">
               <?php 
                    echo $this->Html->link(__('Back', true),array('controller'=>'nursings','action' => 'patient_information/',$this->params['pass'][0]), array('escape' => false,'class'=>'grayBtn'));
				 	echo $this->Form->submit('Save', array('div'=>false,'label'=>false,'error'=>false,'class'=>'blueBtn'));
				 ?>		
               </div>                    
      <?php echo $this->Form->end();?>
     
	<script>
	   var pager = new Pager('serviceGrid', 15); 
	   pager.init(); 
	   pager.showPageNav('pager', 'pageNavPosition'); 
	   pager.showPage(1); 
   </script>
	<?php 
      
 	}
      ?>                  
     
  <script><!-- 
	   
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#servicefrm").validationEngine();	
		 
	});
	         //script to include datepicker
	$(function() {
		$("#billDate").datepicker({
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',				 
			dateFormat:'<?php echo $this->General->GeneralDate();?>',		
			minDate : new Date(<?php $this->General->minDate($patient['Patient']['form_received_on'])?>),	
			maxDate: new Date(),	
			onSelect: function (theDate)
		    {	// The "this" keyword refers to the input (in this case: #someinput)
		   		window.location.href = '?serviceDate='+theDate;
		    }	
		}); 
		$("#serviceName").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name",'null','null','null', "admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				selectFirst: true
		});
	});
	
	function clearLookup(){
		 
		$('#patient_id').val('');
	}	


	 function defaultNoOfTimes(id,tariffListId){
		currentCount = Number($('#noOfTimes' + tariffListId).val()) ;		
		if($('#' + id).is(":checked")){			
			$('#noOfTimes' + tariffListId).val(currentCount+1);
		}else{
			if(currentCount > 0) 
				$('#noOfTimes' + tariffListId).val(currentCount-1);
			else
				$('#noOfTimes' + tariffListId).val('');
		}
	 }	

	 function checkApplyInADay(tarrifListID,standardId,tmp,apply_in_a_day){
			var count = 0;
			 if($.trim(apply_in_a_day)!="" && parseInt(apply_in_a_day)>0){
			  	if(parseInt(apply_in_a_day)>3)
			  		apply_in_a_day =3;
			  	var arr = new Array("morning"+tmp,"evening"+tmp,"night"+tmp);
				if($("#morning"+tmp).attr("checked")==true)
					count = count+1;
				if($("#evening"+tmp).attr("checked")==true)
					count = count+1;
				if($("#night"+tmp).attr("checked")==true)
					count = count+1;		
		  		if(parseInt(apply_in_a_day) == count){
		  			if($("#morning"+tmp).attr("checked")!=true)
		  				$("#morning"+tmp).attr("disabled","disabled")
		  			if($("#evening"+tmp).attr("checked")!=true)
		  				$("#evening"+tmp).attr("disabled","disabled")
		  			if($("#night"+tmp).attr("checked")!=true)
		  				$("#night"+tmp).attr("disabled","disabled")
		 		}else if(count < parseInt(apply_in_a_day)){
					if($("#morning"+tmp).attr("checked")!=true)
		  				$("#morning"+tmp).removeAttr("disabled", "disabled");
		  			if($("#evening"+tmp).attr("checked")!=true)
		  				$("#evening"+tmp).removeAttr("disabled", "disabled");
		  			if($("#night"+tmp).attr("checked")!=true)
		  				$("#night"+tmp).removeAttr("disabled", "disabled");
				}			
		   }
		 }
--></script>