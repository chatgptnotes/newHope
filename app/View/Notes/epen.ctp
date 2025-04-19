<style type="text/css">

	/* / textaere  css  / */

	#present-cond_desc {
    width: 98%;
    min-height: 150px;
    border: 1px solid #999;
    padding: 5px 7px;
    background-color: #fff; 
    outline: none; 
    resize: none; 
    overflow: auto; 
}		
	
iframe {
  border-top: #ccc 1px solid;
  border-right: #ccc 1px solid;
  border-left: #ccc 1px solid;
  border-bottom: #ccc 1px solid;
} 
.btn {
    display: inline-block;
    margin-bottom: 0;
    margin-top: 2px;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>
<div class="inner_title">
<h3><?php echo __('Doctor Notes', true); ?></h3>
<span><?php 
    	if($getDataFormNote['Note']['epen_data']){
    		echo $this->Html->link(__('Print Notes'),
			'#',array('escape' => false,'class'=>'blueBtn','onclick'=>"var openWin = window.open('".$this->Html->url(array('controller'=>'Notes','action'=>'printEpenNotes',$patientId,$noteID))."', '_blank',
		           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=800,left=400,top=300,height=700');  return false;"));
    	}
  	 ?></span>
</div>
	<?php echo $this->Form->create('Note',array('id'=>'epenForm')); 
		  echo $this->Form->hidden('',array('name'=>'data[Note][patient_id]','id'=>'patientId','value'=>$patientId));
		  echo $this->Form->hidden('',array('name'=>'data[Note][note_id]','id'=>'noteId','value'=>$noteID))
	?>


	<table border="0"  cellpadding="0" cellspacing="0" width="100%"  align="center">
		<tr>
		<td valign="top" width="100%">
		<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull formFullBorder">
						<tr>
							<td width="27%" align="left" valign="top">
									<div align="center" id = 'temp-busy-indicator' style="display:none;">	
										&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
									</div>	
									<div id="templateArea-diagnosis">
										 <?php echo $this->requestAction('doctor_templates/add/diagnosis'); ?>			
										 		 
									</div>
										<?php echo $this->element('chatgpt',array('templateType'=>'diagnosis')); ?>
							</td>	    	    		
							<td width="70%" align="left" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" >	              	 
									  <tr>
										<td width="20">&nbsp;</td>	
										<td valign="top" colspan="4">
										
				
												<?php 
													$finalDiagnosis = isset($getDataFormNote['Note']['epen_data']) 
													? strip_tags(htmlspecialchars_decode($getDataFormNote['Note']['epen_data'])) 
													: '';
												


													echo $this->Form->textarea('Note.epen', array('id' => 'final_diagnosis', 'value' => $finalDiagnosis, 'rows' => '40', 'style' => 'width:98%'));
 
													echo $this->Js->writeBuffer();
												?>
										</td>			                    
									 </tr>
								  </table>
							  </td>
						</tr>
					</table>
		</td>


		
			<!-- <td valign="top" width="90%">
			
	
			 <textarea style="height: 450px; width: 95%; border: 1px;" id="gptResponse" name="data[Note][epen]" ><?php echo $getDataFormNote['Note']['epen_data']; ?></textarea>

			 
			</td> -->
		</tr>

		<tr>
				<td colspan="2" align="center" style="padding-top: 10px;padding-left: 90%">
		      		<input type=button name=Save value=Update class="blueBtn" onclick="saveEpenData()">	
				</td>
		</tr>
		
	</table>
	<table>
		<tr>
			<td>
			<p>
			    <span style="font-size: 18px; font-weight: bold;">📲 Hey everyone! Exciting news! We now have access to ChatGPT within our software. 🎉</span>
			    <br>
			    <span>Follow these simple steps to start using it:</span>
			</p>
			<ul style="font-size: 11px;">
			    <li>1.For OPD patients, go to the Epen page and click the "Fetch data" button. For IPD patients, go to the discharge summary page and click the "Fetch data" button.</li>
			    <li>2.Look for the "discharge summary" title in the template box above (for IPD patients) or the "OPD summary" title (for OPD patients).</li>
			    <li>3.Click on the respective title to open the template.</li>
			    <li>4.To utilize ChatGPT, click the magnifying glass icon next to the template.</li>
			    <li>5.Edit the prompt and hit the “Message ChatGPT” button.</li>
			    <li>6.ChatGPT will process your query and provide a response in no time. Remember, ChatGPT is designed to assist you, so feel free to ask any questions or seek help with any topic.</li>
			</ul>
			<p>
			    <span>Let's make the most of this powerful tool and enhance our productivity! 💪</span>
			    <br>
			    <span>If you encounter any issues or have further questions, don't hesitate to reach out to our support team.</span>
			    <br>
			    <span>Happy chatting!</span>
			</p>
		</td>
		<td>
				<?php echo $this->Html->image('/img/icons/chatgptinfo.jpeg',array('width'=>'200px','height'=>'200px')); ?>
		</td>
		</tr>
	</table>
<?php echo $this->Form->end(); ?>
<script type="text/javascript">
	// CodeCreatives


	$('.showImg').click(function(imgName){
		$('#loadepen').hide();
		$('#loadCross').show();
		$('#loadImg').show();
		$('#loadImg').html('<img style="width:100%;height:80%;" src=<?php echo $this->webroot?>files/epen/'+$(this).attr('id')+'>');
	});
	$('.k').click(function(){
		$('#loadepen').show();
		$('#loadCross').show();
		$('#loadImg').html('');
		$('#loadImg').hide();
	});

	// CodeCreatives
	/*$('.fetch_data').click(function() {
		var param = 'Diagnosis: ' + diagnosis + ', ';
		param += 'Presenting Complaints: ' + complaints + ',';
		param += 'ROS: ' + ros + ',';
		param += 'Examination: ' + examination + ',';
		param += 'Plan: ' + plan + ',';
		$('.gpt_input').val(param);
	});
*/
	/*$('.get_gpt_reply').click(function() {

		var input = $('.gpt_input').val();

	

		if (input != '') {
			$.ajax({
	        	beforeSend : function() {
	        		$("#busy-indicator").show();
	        	},
	        	complete: function() {
	        		$("#busy-indicator").hide();
	        	},
	        	type: 'POST',
	        	url: "/hope/notes/chatGPT",
	        	data: {'gpt_input' : input},
	        	success: function(response) {
	        		var content = $('#gptResponse').text();

	        		content += (content != '') ? '&#13;&#13;' : '';
	        		content += `Name: ` + name + `&#13;Age: ` + age + `&#13;Gender: ` + sex + ` &#13;Admission ID: ` + admission_id + `&#13;MRN ID: ` + patient_uid + '&#13;Date Of Birth: ' + dob + '&#13;' + response;
	        		if (response) {
	        			window.scrollTo(0, 0);
	        			$('#gptResponse').html(content);
	        		}
	        	},
	        });
		}
	});
*/
/*	$('.ques').click(function() {
		var question = $(this).attr('data-question');
		var prevVal = $('.gpt_input').val();
		var prevVal = $('.gpt_input').val(prevVal + ', ' + question);
		// $('.get_gpt_reply').click();
	});
*/
	function saveEpenData(){

		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Notes', "action" => "updateEpenData","admin" => false)); ?>";
		var formData = $('#epenForm').serialize();
		//
		$.ajax({
				  type: "POST",
				  url: ajaxUrl,
				  data: formData,
				  beforeSend:function(){
				  	// this is where we append a loading image
				  	$('#busy-indicator').show('fast');
				  },
				  success: function(data){
				  $('#busy-indicator').hide('slow');
				  alert('Saved Successfully');
				  relaodEpen();
			  }
		});
	}
function relaodEpen(){
		var patientId='<?php echo $patientId?>';
		var noteID='<?php echo $noteID?>';
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Notes", "action" => "epen","admin" => false)); ?>";
		 $.ajax({
	        	type: 'POST',
	        	url: ajaxUrl+'/'+patientId+'/'+noteID,
	        	dataType: 'html',
	        	beforeSend : function() {
					        $('#busy-indicator').show('fast');
					    },
	        	success: function(data){
		        	if(data!=''){
		       			 $('#loadepen').html(data);
		       			$('#busy-indicator').hide('fast');
		        	}
	        	},
	        	error: function(message){
		     	},
			});
	}

// 	document.addEventListener("DOMContentLoaded", function() {
//     let textarea = document.getElementById('final_diagnosis');
//     if (textarea) {
//         textarea.value = textarea.value.replace(/<[^>]*>/g, ''); // Removes all HTML tags
//     }
// });




	// End
</script> 