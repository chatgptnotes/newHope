
<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));      
echo $this->Html->script(array('jquery-1.9.1.js','jquery-ui-1.10.2.js','jquery-ui-1.8.5.custom.min.js','slides.min.jquery.js',
									'jquery.isotope.min.js','jquery.custom.js','ibox.js','jquery.fancybox-1.3.4','jquery.selection.js','jquery.autocomplete','ui.datetimepicker.3.js'));?>
<?php echo $this->Form->create('',array('id'=>'printLetterfrm'));?>
<style>
.classTr{
background-color:#CCCCCC;
 /* margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000000;*/ 
}
.classTd{
color:red;
}
.myTd{
 font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#000000;
}
</style>
<table width="100%" class=""  cellspacing="0" cellpadding="4" border='0'>
	<tr class="row_title" style='padding-top: 5px;'>
	<td id='hello'></td>
	<?php echo $this->Form->hidden('head',array('id'=>'head_text'));?>
	</tr>
	<tr class="row_title" style='padding-top: 5px;'>
	<td id='body'></td>
	<?php echo $this->Form->hidden('body',array('id'=>'body_text'));?>
	</tr>
	<tr class="row_title" style='padding-top: 5px;'>
	<td id='conclusion'></td>
		<?php echo $this->Form->hidden('tail',array('id'=>'conclusion_text'));?>
		<?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id));?>
	</tr>
	<tr>
	<td id='Sincerely' align='right'></td>
		<?php echo $this->Form->hidden('Sincerely',array('id'=>'Sincerely_txt'));?>
	</tr>
	</table>
	<?php echo $this->Form->end();?>
<script>

var body = parent.$("#printLetter").html();
var subjective_desc = parent.$("#subjective_desc").val();
var conclusion = parent.$("#conclusion").val();
var Sincerely=parent.$("#endText").html();
$("#hello").html(subjective_desc );
$("#body").html(body );
$("#conclusion").html(conclusion);
$("#Sincerely").html(Sincerely);


$("#head_text").val(subjective_desc);
$("#body_text").val(body);
$("#Sincerely_txt").val(Sincerely);
$("#conclusion_text").val(conclusion);

jQuery(document)
.ready(
		
		function() {
			
			 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "Recipients", "action" => "printLetter","admin" => false)); ?>";
			   var formData = $('#printLetterfrm').serialize();
			     $.ajax({	
		        	 beforeSend : function() {
		        		// this is where we append a loading image
		        		$('#busy-indicator').show('fast');
		        		},
		        		                           
		          type: 'POST',
		         url: ajaxUrl,
		          data: formData,
		          dataType: 'html',
		          success: function(data){
		        	  $('#busy-indicator').hide('fast');	
			        	$("#formdisplayid").html(data);
			        
			        
		          },
					error: function(message){
						alert("Error in Retrieving data");
		          }        });
		    
		    return false; 
			});
</script>