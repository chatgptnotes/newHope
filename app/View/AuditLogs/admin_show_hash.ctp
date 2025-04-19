<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#hashingfrm").validationEngine();
	});
</script>
<div class="inner_title">
	<h3>&nbsp; <?php echo __('Hashing/Encryption', true); ?></h3>
</div>
<form name="hashingfrm" id="hashingfrm" action="<?php echo $this->Html->url(array("action" => "show_hash")); ?>" method="post" >
	<table class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
			<tr>
			<td class="form_lables" align="center">
			<?php echo __('String'); ?><font color="red">*</font>
			</td>
			<td>
		        <?php 
		       	 	echo $this->Form->input(null, array('value'=>$this->request->data['name'], 'name' => 'name', 'class' => 'validate[required,custom[name]]','id'=>'name','label'=> false, 'div' => false, 'error' => false));
		        ?>
			</td>
			</tr>
	 
	 
	<tr>
		<td>
			 &nbsp;
		</td>
		<td>
			<?php				    			 
							 
						echo $this->Form->submit('Submit',array('class'=>'blueBtn','div'=>false));			
		    ?>	
			
		</td>
	</tr>
	</table>
</form>
<?php if(!empty($sha1Data) &&  !empty($md5Data) && !empty($sha1Data))  { ?>
<table class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
			<tr>
			
			<td>
		        
		        <?php echo "SHA1 value :  ". $sha1Data;
		              echo "<br />";
		              echo "MD5 value :  ". $md5Data;
		              echo "<br />";
		              echo "RIJNDAEL value :  ".$rijndaelData;
		              echo "<br />";
		                                      ?>
		       
			</td>
			</tr>
</table>
<?php } ?>