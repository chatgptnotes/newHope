<?php
echo $this->Html->script ( array (
		'jquery.autocomplete' 
) );
echo $this->Html->css ( 'jquery.autocomplete.css' );
?>
<div class="inner_title">
	<h3>Corporate Rate List</h3>
</div>
<p class="ht5"></p>
<!-- form elements start-->

<div>&nbsp;</div>
<?php
echo $this->Form->create ( 'Laboratory', array (
		'action' => 'corporate_lab_rate',
		'id' => 'laboratoryFrm',
		'default' => false,
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );

?>
<table width="" cellpadding="0" cellspacing="0" border="0"
	align="center">
	<tr>
		<td width="120" height="35" class="tdLabel2">Category Name<font
			color="red"> *</font>
		</td>
		<td width="300">
                         		<?php
																											$deptArr = array (
																													'lab' => 'Lab',
																													'radiology' => 'Radiology' 
																											); // ,'histology'=>'Histology'
																											echo $this->Form->input ( 'department', array (
																													'empty' => 'Please select',
																													'options' => $deptArr,
																													'class' => 'textBoxExpnd validate[required,custom[mandatory-select]]',
																													'id' => "department",
																													'label' => false,
																													'div' => false,
																													'error' => false,
																													'autocomplete' => 'off' 
																											) );
																											?>                         		
                            	 
                      		</td>
	</tr>
	<tr>
		<td height="35" class="tdLabel2">Test Name<font color="red"> *</font></td>
		<td><?php
		echo $this->Form->input ( 'laboratory_id', array (
				'type' => 'select',
				'class' => 'textBoxExpnd validate[required,custom[name]]',
				'id' => "laboratory_id",
				'autocomplete' => 'off',
				'label' => false,
				'div' => false,
				'error' => false 
		) );
		?>
                              </td>
		<td>
                              	<?php
																															echo $this->Form->submit ( 'Show', array (
																																	'id' => 'lab-rate',
																																	'escape' => false,
																																	'class' => 'blueBtn' 
																															) );
																															?>
                              </td>

	</tr>

	<tr>
		<td colspan="2" height="10"></td>
	</tr>
</table>
<div align="center" id='temp-busy-indicator' style="display: none;">	
								&nbsp; <?php echo $this->Html->image('indicator.gif', array()); ?>
					   </div>
<?php
echo $this->Form->end ();

echo $this->Form->create ( 'Laboratory', array (
		'action' => 'corporate_lab_rate',
		'id' => 'CorporateLabRate',
		'inputDefaults' => array (
				'label' => false,
				'div' => false,
				'error' => false 
		) 
) );

?>
<div id="corporateRateList"></div>

<?php
echo $this->Form->end ();
?>

<!-- Right Part Template ends here -->

<script>
	$(document).ready(function(){
		 
		 
       /* $('#laboratory_id').click(function()
         { 
                  $(this).autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Laboratory","name", "admin" => false,"plugin"=>false)); ?>", {
              		width: 250,
               		selectFirst:true,
          });
         }); */

			jQuery("#laboratoryFrm").submit(function(){
				var returnVal = jQuery("#laboratoryFrm").validationEngine('validate');						 
				if(returnVal){					 
			 		ajaxPost('laboratoryFrm','corporateRateList');
			 	}
			});
			$('#department').change(function(){
				 $('#corporateRateList').fadeOut('slow');
				  $.ajax({
			            action:"departmentwise_testlist", 
			            data:{"dept":$(this).val()},		           
			            dataType:"html",
			            beforeSend:function(){
						    // this is where we append a loading image
						    $('#temp-busy-indicator').fadeIn('fast');
						},				            
			            success:function (data, textStatus) {
			             	$('#temp-busy-indicator').fadeOut('slow');
			             	
			             	data= $.parseJSON(data);
				  			$("#laboratory_id option").remove();
							$.each(data, function(val, text) {
							    $("#laboratory_id").append( "<option value='"+val+"'>"+text+"</option>" );
							}); 
			               
			            }, 
			            type:"post", 
			            url:"<?php echo $this->Html->url((array('controller'=>'laboratories','action' => 'departmentwise_testlist','admin'=>false)));?>"
			        }); 
			});
						 
		function ajaxPost(formname,updateId){ 
				 
		        $.ajax({
		            action:"corporate_lab_rate", 
		            data:$("#"+formname).closest("form").serialize(), 
		            dataType:"html",
		            beforeSend:function(){
					    // this is where we append a loading image
					    $('#temp-busy-indicator').fadeIn('fast');
					},				            
		            success:function (data, textStatus) {
		             	$('#temp-busy-indicator').fadeOut('slow');
		                $("#"+updateId).html(data).fadeIn(400);
		               
		            }, 
		            type:"post", 
		            url:"<?php echo $this->Html->url((array('controller'=>'laboratories','action' => 'corporate_lab_rate')));?>"
		        }); 
		}
    });             
</script>