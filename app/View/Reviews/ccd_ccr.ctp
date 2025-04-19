
<?php
 echo $this->Html->script('jquery.autocomplete');
  echo $this->Html->css('jquery.autocomplete.css');
  ?>

<div class="inner_title">
	<h3>CCD/CCR</h3>

	<span> <?php echo $this->Html->link(__('Back'),array('action' => 'index' ), array('class'=>'blueBtn', 'style'=>'width:30px, margin-right:30px'));?>
	
		<?php // echo $this->Html->link(__('Browse'),array('action' => '' ), array('class'=>'blueBtn'));?> </span>
</div>

<div class="btns">
			  	<form action="upForm.php" method="post"><br>
                <input type="file" name="uploadFile">
                 <input type="hidden" name="MAX_FILE_SIZE" value="15000" />
                      <input class="blueBtn" type=submit value="Submit">
                      <!--  <input type="submit" name="submit"  class="bluebtn" value="Submit" style="baccground:#c0cbcf">-->
                  </form>
	


</div>

<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%"
	style="text-align: center background:  none repeat scroll 0 0 #3E474A;">



	<tr class="row_title">

		<td class=" " align="right" width="20%"><label>
				<?php echo __('Date') ?>
		</label></td>
		<td class=" " align="right" width="20%"><label>
				<?php echo __('Operation(Import/Export)') ?>
		</label></td>
		<td class=" " align="right" width="20%"><label>
				<?php echo __('Type(CCD/CCR)') ?>
		</label></td>
		<td class=" " align="right" width="20%"><label>
				<?php echo __('To') ?>
		</label></td>
		<td class=" " align="right" width="20%"><label>
				<?php echo __('Action') ?>
		</label></td>
		<td class=" " align="right" width="20%"><label>
				<?php echo __('Edit') ?>
		</label></td>
	</tr>
	<?php //foreach ($getreview as $getdata){?>
	
	<?php 
				  	  $toggle =0;
				      if(count($getreview) > 0) {
				      		foreach($getreview as $getdata){
				       
							       if($toggle == 0) {
								       	echo "<tr class='row_gray'>";
								       	$toggle = 1;
							       }else{
								       	echo "<tr>";
								       	$toggle = 0;
							       }
								  ?>
	
	
		<!--  <td class=" " align="right" width="3%"><?php echo $this->Form->input('', array('checked'=> $nc,'type'=>'checkbox','hiddenField' => false,'name'=>'data[Note][][]','value'=>'')); ?>&nbsp;	</td>-->

		<td margin-left="4px">
			<?php echo date("d-m-Y H:i:s", strtotime($getdata['Review']['created']));?>
		</td>


		<td class=" " align="right" width="20%"><label>
				<?php echo (Export); ?>
		</label></td>

		<td class=" " align="left" width="20%"><?php echo $getdata['Review']['type_name'] ?></td>
		
		<td class=" " align="right" width="20%"><label>
				<?php echo $getdata['Review']['to_person'] ?>
		</label></td>

		<td class=" " align="right" width="20%"><label>
				<?php echo $this->Html->link(__('Download'),array('action' => '' ), array('class'=>'blueBtn')); ?>
		</label></td>

		<td class=" " align="right" width="20%"><label>
				<?php //echo $this->Js->link($this->Html->image('icons/edit-icon.png', array('title' => 'Edit', 'alt'=> 'View')),array('action' => 'edit_patient_xml',$getdata['Review']['id'] ), array('class'=>'blueBtn'));
								  echo $this->Html->link(__('Edit'),array('action' => 'edit_patient_xml',$getdata['Review']['id'] ), array('class'=>'blueBtn')); ?>
		</label></td>
		
	</tr>
	<?php } }?>




</table>

