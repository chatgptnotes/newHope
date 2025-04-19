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
                    <!-- Right Part Template -->
                  	<div class="inner_title">
                     	<h3>DEATH CERTIFICATE</h3>
                  	</div>
                   <p class="ht5"></p>
                   <?php echo $this->Form->create('DeathCertificate',array('id'=>'DeathCertificate','url'=>array('controller'=>'billings','action'=>'death_certificate'),
  							'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
                   		 echo $this->Form->hidden('patient_id',array('value'=>$this->params['pass'][0]));
                   		 echo $this->Form->hidden('id',array());
                   ?>
                   <?php echo $this->element('patient_header');?>
                   <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td  height="35" class="tdLabel2" colspan="2" style="font-size: 14px;"><p>This is to certify that 
                            	<strong><?php echo $patient[0]['lookup_name']; ?></strong>
                            	aged about <strong><?php echo ($patient['Patient']['age']>0)?$patient['Patient']['age']:1 ; ?> Yrs.</strong>
                            
                          residing at <?php echo str_replace('<br/>'," ",$address) ;?></p></td>                       
                        </tr>   
                         <tr>
                         
                            <td  height="35" class="tdLabel2" colspan="2">
                            <table>
                            <tr>
                            <td><?php echo __("Expired On") ; ?><font color="red">*</font> </td>
                            <td><span><?php 
                           	if($this->data['DeathCertificate']['expired_on'])
								$expired_on = $this->DateFormat->formatDate2Local($this->data['DeathCertificate']['expired_on'],Configure::read('date_format'),true);
							else if(!empty($patient['FinalBilling']['discharge_date']))
								$expired_on = $this->DateFormat->formatDate2Local($patient['FinalBilling']['discharge_date'],Configure::read('date_format'),true);
							echo $this->Form->input('expired_on',array('type'=>'text','id'=>'expired_on','value'=>$expired_on,'class'=>'textBoxExpnd validate[required,custom[mandatory-date]] expireCls'));
                             
                            ?></span></td> 
                            </tr>
                            </table>
                            </td>
                                                  
                        </tr>                     
                     	<tr>
                        	<td class="tdLabel2" height="30">Cause of Death</td>
                        </tr>
                    	 <tr>
                        	<td width="100%"><?php 
                        		echo $this->Form->textarea('cause_of_death',array('id'=>'cause_of_death','class'=>'textBoxExpand','rows'=>8,'style'=>'width:97%'));
                        	?></td>
                        </tr>
						<tr>
							<td colspan="2">
								<table>
									<tr>
										<td><?php echo __("Date:") ; ?></td>
										<td>
											<?php 
												if($this->data['DeathCertificate']['date_of_issue']){
													$dateOfIssue = $this->DateFormat->formatDate2Local($this->data['DeathCertificate']['date_of_issue'], Configure::read('date_format'), true);
												} else {
													$dateOfIssue = ''; // Default empty if no value
												}
												echo $this->Form->input('date_of_issue', array(
													'type' => 'text',
													'id' => 'date_of_issue',
													'value' => $dateOfIssue,
													'class' => 'textBoxExpnd'
												));
											?>
										</td>
									</tr>
								</table>
							</td>
						</tr>

                       
                       <tr>
                        	<td align="right">
                        		<?php
									//echo $this->Html->link(__('Cancel'),array('controller'=>'patients','action'=>'patient_information',$patient['Patient']['id']),array('class'=>'grayBtn','div'=>false));
									if($this->data['DeathCertificate']['id'])
									echo $this->Html->link(__('Print'),  '#',
		    									 array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'death_certificate_print',$patient['Patient']['id']))."', '_blank',
		           								'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
									echo $this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false)) ;
								?>
								<span><?php echo $this->Html->link(__('Back'),array('controller'=>'billings','action'=>'death_summary',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false)); ?></span>
                        	</td>
                        </tr> 
                   </table>
                    <div class="clr ht5"></div> 
                   <div class="clr ht5"></div>
				 
                    <script>
$(function() {
	$("#DeathCertificate").validationEngine();		
	 $(document).ready(function(){
	$("#expired_on" ).datepicker({		
			showOn: "button",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',	
			 maxDate: new Date(),
			dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
			//minDate : new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>)	
		
	});
	$( "#date_of_issue" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		//dateFormat: 'dd/mm/yy',
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>',
		minDate : new Date(<?php echo $this->General->minDate($patient['Patient']['form_received_on']); ?>)
	});
});	
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var dateField = document.getElementById("date_of_issue");
    if (dateField.value === '') {  // Agar koi purana date nahi hai
        var now = new Date();
        var formattedDate = now.getFullYear() + "-" + 
                            ("0" + (now.getMonth() + 1)).slice(-2) + "-" + 
                            ("0" + now.getDate()).slice(-2) + " " + 
                            ("0" + now.getHours()).slice(-2) + ":" + 
                            ("0" + now.getMinutes()).slice(-2);
        dateField.value = formattedDate;
    }
});
</script>
  