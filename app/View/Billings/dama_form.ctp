<style>
	.tabularForm td td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:#1b1b1b;
	}
	.tabularForm th td{
	padding:0px;
	font-size:13px;
	color:#e7eeef;
	background:none;
	}
	.tabularForm td td.hrLine{background:url(../img/line-dot.gif) repeat-x center;}
	.tabularForm td td.vertLine{background:url(../img/line-dot.gif) repeat-y 0 0;}
</style> 
  
                  <div class="inner_title">
                     <h3>DAMA CONSENT FORM</h3>
                  </div>
                   <p class="ht5"></p>
                   <?php echo $this->Form->create('DamaConsentForm',array('id'=>'DamaConsentForm','url'=>array('controller'=>'billings','action'=>'dama_form'),
  							'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
                   		 echo $this->Form->hidden('patient_id',array('value'=>$this->params['pass'][0]));
                   		 echo $this->Form->hidden('id',array());
                   ?>
                   <?php echo $this->element('patient_header');?>
                   <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding-left:30px;line-height:2">
                        <tr>
	                        <td  colspan="2" class="tdLabel2" height="30" >
	                        	We have been informed on the status of our patient  
	                        	<?php echo $patient['Initial']['name'].ucfirst($patient[0]['lookup_name']); ?> by the doctor.
	                        </td>
                        </tr>  
                         <tr> 
                            <td width="" colspan="2" >
                            	The patient is suffering from
	                        	<?php   echo $this->Form->input('condition',array('type'=>'text','id'=>'condition','size'=>50));  ?>
	                        	
	                        	<?php
                            	/*if(!$this->data['DamaConsentForm']['suffering_from'])
									$form_received_on = $this->DateFormat->formatDate2Local($patientData['Patient']['form_received_on'],Configure::read('date_format'),true);
								else
									$form_received_on = $this->DateFormat->formatDate2Local($this->data['DamaConsentForm']['suffering_from'],Configure::read('date_format'),true);
									
                            	echo $this->Form->input('suffering_from',array('type'=>'text','id'=>'suffering_from','class'=>'','value'=> $form_received_on));*/  
                            	?></td><!--
                            <td width="20">&nbsp;</td>
                            <td width="400"><?php   //echo $this->Form->input('condition',array('type'=>'text','id'=>'condition','size'=>50));  ?></td>
                            <td width="20">&nbsp;</td>
                            <td width="90" class="tdLabel2">is very critical.</td>
                            <td>&nbsp;</td>
                        --></tr>    
                        <tr>
	                        <td   colspan="2" height="30" class="tdLabel2">We have been informed that the condition of the patient  is serious.<br/>

								We are moving the patient from <?php echo ucfirst($this->Session->read('facility'))?> at our own risk and take full responsibility for this.<br/>

								We take full responsibility for the death of the patient.<br/>

								No doctor or staff of Hope Hospital will be held responsible for the death of the patient.</td>
	                    </tr> 
	                    <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td   height="35" class="tdLabel2">Date
                           <?php  
                           	if($this->data['DamaConsentForm']['date']){
                           		$damaDate = $this->DateFormat->formatDate2Local($this->data['DamaConsentForm']['date'],Configure::read('date_format'),true);
                           	}else{
                           		$damaDate='';
                           	}
                           echo $this->Form->input('date',array('type'=>'text','id'=>'dama_date','class'=>'textBoxExpand','value'=>$damaDate)); ?> </td> 
                            <td  class="tdLabel2"  >Relationship with patient <?php 
                            echo $this->Form->input('relation',array('id'=>'relation','class'=>'textBoxExpand'));
                            ?></td>  
                        </tr>   
                        <tr>
                        	<td  align="right" colspan="2">
                        		<?php
									//echo $this->Html->link(__('Cancel'),array('controller'=>'patients','action'=>'patient_information',$patientData['Patient']['id']),array('class'=>'grayBtn','div'=>false));
									if($this->data['DamaConsentForm']['id'])
									echo $this->Html->link(__('Print'),  '#',
		    									 array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'dama_form_print',$patient['Patient']['id']))."', '_blank',
		           								'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
									echo $this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false)) ;
								?>
                        	</td>
                        </tr>           
                    </table> 
                    <div class="clr ht5"></div>
                    <div class="clr ht5"></div>
                   <!-- Right Part Template ends here -->
<script>
$(function() {
	$("#suffering_from" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		//dateFormat: 'dd/mm/yy',
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
	});
	$( "#dama_date" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		//dateFormat: 'dd/mm/yy',
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
	});
});	
</script> 
           