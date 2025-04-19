<div class="inner_title">

	<h3>
		<?php echo __('View CCDA Message', true); ?>
	</h3>
	<?php if(strtolower($role) != 'patient'){?>
	<span><?php //  echo $this->Html->link(__('Back to list'),array('action'=>'patientList'),array('escape'=>false,'class'=>'blueBtn')); ?>
	</span>
	<?php }else {?>
	<span><?php // echo $this->Html->link(__('Back to list'),array('action'=>'ccdaMessage'),array('escape'=>false,'class'=>'blueBtn')); ?>
	</span>
	<?php }?>
</div>
<div>&nbsp;</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="formFull" class="t1">
	<tr>
		<td>
			<h3>
				&nbsp;
				<?php echo __(' View', true); ?>
			</h3>
		</td>
	</tr>
	<tr></tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Name') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['Patient']['lookup_name'];
		?>
		</td>
	</tr>


	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Sex') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['Patient']['sex'];
		?>
		</td>
	</tr>

	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Age') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		if( $message['Patient']['age']  > '1'){
			$years=' Years';
		}else{
			$years=' Year';
		}
		echo $message['Patient']['age'] . $years;
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace" width="200px"><?php echo __('Type') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['TransmittedCcda']['type'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace" width="200px"><?php echo __('Date') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $this->DateFormat->formatDate2Local($message['TransmittedCcda']['referral_date'],Configure::read('date_format'),false); 
		echo $date;
		?>
		</td>
	</tr>
	<tr id="is_ccda_attached">
		<td valign="middle" class="tdLabel" id="boxSpace" width="200px"><?php echo __('Attached Ccda') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['TransmittedCcda']['file_name'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('To') ?>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['TransmittedCcda']['to'];
		?>
		</td>
	</tr>
	<tr><td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Referral To') ?></td>
	<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['TransmittedCcda']['referral_to'];
		?>
		</td>
	</tr>
	<tr id="is_subject_show">
		<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Subject') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['TransmittedCcda']['subject'];
		?>
		</td>
	</tr>
	<tr>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Message') ?>
		</td>
		<td valign="middle" class="tdLabel" id="boxSpace"><?php 
		echo $message['TransmittedCcda']['message'];
		?>
		</td>
	</tr>
</table>
