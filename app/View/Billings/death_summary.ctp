<style>
	.dots span {
        animation: blink 1.5s infinite;
    }
    .dots span:nth-child(1) { animation-delay: 0s; }
    .dots span:nth-child(2) { animation-delay: 0.2s; }
    .dots span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes blink {
        0% { opacity: 0; }
        50% { opacity: 1; }
        100% { opacity: 0; }
    }
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
	.death-textarea{
		width:400px;
	}

	.lab-textarea{
		width:600px;
		height: 300px;

	}
	.tabularForm td td.hrLine{background:url(../img/line-dot.gif) repeat-x center;}
	.tabularForm td td.vertLine{background:url(../img/line-dot.gif) repeat-y 0 0;}
</style>  
<div class="inner_title">
 	<h3>DEATH SUMMARY</h3>
 	<span style="float:right;text-decoration:none;" id="printButton">
		<?php //echo $this->Html->link(__('Death Certificate'),array('controller'=>'billings','action'=>'death_certificate',$patient['Patient']['id']),array('class'=>'blueBtn','div'=>false)); ?>

		<?php if($this->data['DeathSummary']['id'] !='') { 
		echo $this->Html->link(__('Print Preview'),
		     '#',
		     array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('action'=>'death_summary_print',$patient['Patient']['id']))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    
    }?>
                     		
 	</span>
</div>

                   <?php echo $this->Form->create('DeathSummary',array('id'=>'DeathSummary','url'=>array('controller'=>'billings','action'=>'death_summary'),
  							'inputDefaults' => array('label' => false, 'div' => false,'error'=>false )));
                   		echo $this->Form->hidden('id',array());
                   		 echo $this->Form->hidden('patient_id',array('value'=>$this->params['pass'][0]));
                   		 
                   ?>
                    <?php #debug($patient);?>  
			        <table width="100%" border="0" cellspacing="1" cellpadding="3" class="table_format">
						
			        	<tr>
			        		<td>
			        			Name Of Patient:
			        		</td>
			        		<td>
			        			<?php 
			        				echo $patient[0]['lookup_name'];
			        			?>
			        		</td>	
							<tr>
								<td>
									Registration ID:
								</td>
								<td>
									<?php echo h($regData['Patient']['admission_id']); ?>
								</td>	
							</tr>
							<tr>
								<td>
									Registration Date:
								</td>
								<td>
									<?php echo h($regData['Patient']['form_received_on']); ?>
								</td>	
							</tr>

							<tr>
							<td>
			        			Addmission Type:
			        		</td>
			        		<td>
							<?php echo h($regData['Patient']['admission_type']); ?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			Age/Sex :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $age." / ".ucfirst($patient['Patient']['sex']);;
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			Residential Address  :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->textarea('address',array('class'=>'death-textarea','value'=>$address));
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			Contact Number : 
			        		</td>
			        		<td>
			        			<?php 
			        				echo $patient['Person']['mobile'];
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			Occupation:
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('occupation',array('class'=>'textBoxExpnd','id'=>'occupation','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>


			        	<tr>
			        		<td>
			        			Date of Onset of Illness :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('date_of_illness',array('class'=>'textBoxExpnd','id'=>'dateOfOnsetIllness','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			Sign & Symptoms (Details) :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->textarea('sign_and_symptoms',array('class'=>'death-textarea'));
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			Brief H/O Presumptive source of infection <br>(Brief travel history or H/O contact with positive case) :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->textarea('brief_history',array('class'=>'death-textarea'));
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			 Associated illness / Physiological condition (if any) :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('associated_illness', array('type'=>'text','class'=>'textBoxExpnd')); 
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			 Details of treatment given at 
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->textarea('treatment_given',array('class'=>'death-textarea'));
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			1. By First Doctor/Hospital
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('first_doctor', array('type'=>'text','class'=>'textBoxExpnd')); 
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			2. By Second Doctor/Hospital
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('second_doctor', array('type'=>'text','class'=>'textBoxExpnd')); 
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			3. By IIW
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('by_iiw', array('type'=>'text','class'=>'textBoxExpnd')); 
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			3. Name Of Referring Hospital
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('refering_hospital', array('type'=>'text','class'=>'textBoxExpnd')); 
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			Date & Time of Admission in Identified Isolation Ward :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('admission_date_iiw',array('class'=>'textBoxExpnd','id'=>'admission_date_iiw','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			Name Of IIW :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('name_of_IIW',array('class'=>'textBoxExpnd','id'=>'name_of_IIW','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			Date of Throat Of Swab Taken:
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('swab_taken_date',array('class'=>'textBoxExpnd','id'=>'swab_taken_date','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
			        		<td>
			        			Date of Result of Throat Swab :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('swab_result_date',array('class'=>'textBoxExpnd','id'=>'swab_result_date','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			Name Of Laboratory
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('name_of_laboratory',array('class'=>'textBoxExpnd','id'=>'name_of_laboratory','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>
						<tr>
							<td>
								Combined Lab, Radiology & Surgery Data:
							</td>
							<td>
								<?php 
									// Prepare laboratory results
									$lab_ordered = '';
									if (empty($this->data['DeathSummary']['laboratory_results'])) {
										if (!empty($labResults)) {
											foreach ($labResults as $result) {
												$lab_ordered .= $result['LaboratoryParameter']['name'] . ': ' . $result['LaboratoryHl7Result']['result'] . "\n\n";
											}
										} else {
											$lab_ordered = 'No laboratory results available.';
										}
									} else {
										$lab_ordered = $this->data['DeathSummary']['laboratory_results'];
									}
									
									// Prepare radiology results
									$radOrdered = '';
									if (!empty($radiologyResults)) {
										foreach ($radiologyResults as $result) {
											$radOrdered .= $result['Radiology']['name'] . ': ' . $result['RadiologyResult']['note'] . "\n\n";
										}
									} else {
										$radOrdered = 'No radiology results available.';
									}
									
									// Prepare surgery (OT schedule) data
							$surgeryOrdered = '';

if (!empty($optAppointment)) {
    $surgeryOrdered .= 'Schedule Date: ' . h($optAppointment['OptAppointment']['schedule_date']) . "\n\n";
    
    // ✅ Fixed Surgeon Name Concatenation Issue
    $surgeryOrdered .= 'Surgeon Name: ' . h($optAppointment['Users']['first_name']) . ' ' . h($optAppointment['Users']['last_name']) . "\n\n";
//   $surgeryOrdered .= '<strong>Department Users:</strong> ' . (!empty($departmentUsers) ? implode(', ', $departmentUsers) : 'No users found') . "<br><br>";

    // ✅ Fixed Anaesthesia Name Handling
    $anaesthesiaName = !empty($optAppointment['TariffList']['name']) 
        ? h($optAppointment['TariffList']['name']) 
        : 'N/A';

    $surgeryOrdered .= 'Anaesthesia Name: ' . $anaesthesiaName . "\n\n";
    $surgeryOrdered .= 'Description: ' . h($optAppointment['OptAppointment']['description']) . "\n\n";
    $surgeryOrdered .= 'Surgery Name: ' . h($surgeryName) . "\n\n";
} else {
    $surgeryOrdered = 'No OT schedule data available for this patient.';
}


									// Combine all data with clear labels
									$combinedResults = "Lab Data:\n" . $lab_ordered 
													. "\n\nRad Data:\n" . $radOrdered 
													. "\n\nSurgery Data:\n" . $surgeryOrdered;
									
									echo $this->Form->textarea('combined_results', array(
										'class' => 'combined-textarea',
										'value' => $combinedResults
									));
								?>
							</td>
						</tr>


			        	<tr>
			        		<td>
			        			Special mention of various treatment modalities <br>(Anti-retroviral drugs /oseltamivir/ HCQ or Chloroquine / Any other):
			        		</td>
			        		<td>
			        			
			        			<?php 
			        				echo $this->Form->textarea('various_treatment',array('class'=>'death-textarea'));
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        		<td>
			        			Stay Notes:
			        		</td>
			        		<td>
			        			
			        			<?php 
			        				echo $this->Form->textarea('stay_notes',array('class'=>'death-textarea'));
			        			?>
			        		</td>			        		
			        	</tr>

			        	<tr>
			        	<tr>
			        		<td>
			        			Date & Time of Death :
			        		</td>
			        		<td>
			        			<?php 
			        				echo $this->Form->input('death_on',array('class'=>'textBoxExpnd','id'=>'death_on','type'=>'text'));
			        			?>
			        		</td>			        		
			        	</tr>

						</tr>

			        	<tr>
			        		<td>
			        			Cause Of Death 
			        		</td>
			        		<td>
			        			
			        			<?php 
			        				echo $this->Form->textarea('cause_of_death',array('class'=>'death-textarea'));
			        			?>
			        		</td>			        		
			        	</tr>
			        	<tr>
							<td align="right" colspan="2">
								<?php 
									echo $this->Form->submit('Submit', ['class' => 'blueBtn', 'id' => 'submit', 'div' => false, 'label' => false]); 
								?>
								
								<button type="button" class="blueBtn" id="generateSummary">Generate Death Summary</button>

								<!-- Loader (Hidden Initially) -->
								<div id="loader" style="display: none; text-align: center; margin-top: 10px;">
									<span class="dots">Generating summary<span>.</span><span>.</span><span>.</span></span>
								</div>
							</td>
						</tr>
						<!--<pre><?php print_r($deathSummary); ?></pre>-->

						<tr>
							<td colspan="2">
								<textarea id="deathSummaryOutput" class="death-textarea" style="width: 600px; height: 400px; max-width: 100%; max-height: 100vh; resize: vertical;" placeholder="Generated summary will appear here..." readonly><?php 
									echo !empty($deathSummary['DeathSummary']['summary']) ? htmlspecialchars($deathSummary['DeathSummary']['summary']) : 'Click on "Generate Death Summary" button to generate summary!';
								?></textarea>
								<button type="button" class="blueBtn" id="updateSummary">Update Summary</button>
							</td>

						</tr>
			        </table>
                   <?php 
                   		echo $this->Form->end();
                   ?>
                    <div class="clr ht5"></div> 
                    <div class="clr ht5"></div>
					
<script>
		$(function() {
			$("#death_on" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				//dateFormat: 'dd/mm/yy',
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
			});

			$("#dateOfOnsetIllness" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				//dateFormat: 'dd/mm/yy',
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});

			$("#admission_date_iiw" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				//dateFormat: 'dd/mm/yy',
				dateFormat:'<?php echo $this->General->GeneralDate("HH:II:SS");?>'
			});


			$("#swab_taken_date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				//dateFormat: 'dd/mm/yy',
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});



			$("#swab_result_date" ).datepicker({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',			 
				//dateFormat: 'dd/mm/yy',
				dateFormat:'<?php echo $this->General->GeneralDate();?>'
			});
		});
</script>
<!--poonam-->
<script>
$(document).ready(function() {
    $("#generateSummary").click(function() {
        var patientData = {
			name: "<?php echo $patient[0]['lookup_name']; ?>", 
			age: "<?php echo $patient['Patient']['age']; ?>",  // Correcting age assignment
			address: "<?php echo $address; ?>", 
			contact_number: "<?php echo $patient['Person']['mobile']; ?>"
		};


        $.ajax({
            url: "<?php echo $this->Html->url(['controller' => 'billings', 'action' => 'generateDeathSummary', $this->params['pass'][0]]); ?>",
            type: "GET",
            dataType: "json",
            data: patientData, // Send patient data
			beforeSend: function() {
                $("#generateSummary").text("Generating...");
                $("#deathSummaryOutput").val("");  // Clear the textarea
                $("#loader").show(); // Show the loader animation
            },
            success: function(response) {
                console.log("Success response:", response); // Debugging response
                $("#generateSummary").text("Generate Death Summary");
                $("#loader").hide(); // Hide the loader
                
                if (response.summary) {
                    $("#deathSummaryOutput").val(response.summary); // Display the generated summary
                } else {
                    $("#deathSummaryOutput").val("Failed to generate summary. Try again.");
                }
            },
            error: function() {
                console.log("Error in AJAX request."); // Debugging AJAX error
                $("#generateSummary").text("Generate Death Summary");
                $("#loader").hide(); // Hide the loader
                $("#deathSummaryOutput").val("Error communicating with the server.");
            }
        });
    });

    // Update the summary into the database
    $("#updateSummary").click(function() {
        var updatedSummary = $("#deathSummaryOutput").val();  // Get the generated summary from the text area

        $.ajax({
            url: "<?php echo $this->Html->url(['controller' => 'billings', 'action' => 'updateDeathSummary', $this->params['pass'][0]]); ?>",
            type: "POST",
            dataType: "json",
            data: { summary: updatedSummary },  // Send the updated summary
            success: function(response) {
                if (response.success) {
                    alert("Summary updated successfully!");
                } else {
                    alert("Failed to update summary.");
                }
            },
            error: function() {
                alert("Error saving summary.");
            }
        });
    });

    // Fetch the latest summary on page load
    fetchLatestSummary();

    function fetchLatestSummary() {
        $.ajax({
            url: "<?php echo $this->Html->url(['controller' => 'billings', 'action' => 'fetchLatestSummary', $this->params['pass'][0]]); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.summary) {
                    $("#deathSummaryOutput").val(response.summary);  // Display saved summary
                }
            },
            error: function() {
                console.log("Error fetching summary.");
            }
        });
    }
});

</script>
<script>
$(document).ready(function() {
    fetchLatestSummary(); // Load saved summary on page load

    function fetchLatestSummary() {
        $.ajax({
            url: "<?php echo $this->Html->url(['controller' => 'billings', 'action' => 'fetchLatestSummary', $this->params['pass'][0]]); ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.summary) {
                    $("#deathSummaryOutput").val(response.summary);
                }
            },
            error: function() {
                console.log("Error fetching summary.");
            }
        });
    }
});
</script>
