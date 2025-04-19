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
                  
                   <p class="ht5"></p>
                   <?php echo $this->Form->create('DeathCertificate',array('id'=>'DeathCertificate','url'=>array('controller'=>'billings','action'=>'death_certificate'),
  							'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
                   		 echo $this->Form->hidden('patient_id',array('value'=>$this->params['pass'][0]));
                   		 echo $this->Form->hidden('id',array());
                   		 //pr($this->Session->read());
                   ?>
                    <div>To,</div>
					<div>The Chief Medical Officer</div>
					<?php echo $this->element('hospital_address');?> 
                    <div>
                   		<p>&nbsp;</p>
						<p>Dear Sir ,</p>
						<p>I am referring patient named <?php echo $patient['Patient']['lookup_name']; ?></p>
						<p>of age <?php echo $patient['Patient']['age'];?> years, resident of</p>
						<p><?php echo $address ; ?></p>
						<p>for further expert management.</p>
						<p>Patient's presenting Complaints / Investigation / Treatment in brief is as follows:</p>
						<p><?php 
							echo $this->Form->textarea('cause_of_death',array('id'=>'cause_of_death','class'=>'textBoxExpand','rows'=>8,'style'=>'width:97%'));
						?></p>
						<p>Kindly do the needful</p>
						<p>Regards,</p> 
						<div style="float:left;">
							<?php 
								 
								$doc  = $doctor_details[0]['doctor_name']."\n";
								$doc .= $doctor_details['User']['address1']."\n";
								$doc .= "Phone No: ".$doctor_details['User']['phone1']."\n"; 
								echo $this->Form->textarea('cause_of_death',array('value'=>$doc,'id'=>'cause_of_death','class'=>'textBoxExpand','rows'=>4,'style'=>'width:300px'));
							?>
						</div>
						<div style="float:right;">
							Date:
							<?php 
                        			if($this->data['DeathCertificate']['date_of_issue']){
		                           		$dateOfIssue = $this->DateFormat->formatDate2Local($this->data['DeathCertificate']['date_of_issue'],Configure::read('date_format'),true);
		                           	}else{
		                           		$dateOfIssue='';
		                           	}
                        			echo $this->Form->input('date_of_issue',array('type'=>'text','id'=>'date_of_issue','value'=>$dateOfIssue,'class'=>'textBoxExpand'));
                        		?> 
						</div>
						<p>&nbsp;</p>
                   </div>
                   <table width="100%" cellpadding="0" cellspacing="0" border="0"> 
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
                        	</td>
                        </tr> 
                   </table>
                    <div class="clr ht5"></div> 
                   <div class="clr ht5"></div>
				 
                    <script>
$(function() {
	$( "#date_of_issue" ).datepicker({
		showOn: "button",
		buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		yearRange: '1950',			 
		//dateFormat:'<?php //echo $this->General->GeneralDate("HH:II:SS");?>',
		dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
	});
});	
</script>