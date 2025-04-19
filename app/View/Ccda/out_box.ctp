
<style>

/**
 * for left element1
 */
.table_first{
 	margin-bottom: -20px;
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 

}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}

.table_format{
	padding-top:10px;
	
}

.inner_title h3 {
    clear: both !important;
    float: left !important;
}

.inner_title p {
    margin: 0;
    padding-top: 6px;
}

.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
}

.inner_title h3{
	padding: 5px;
}
/* EOCode */

</style>

<?php
//List of XML files to be imported
echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
		'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4','jquery.autocomplete')); 
 
?>
<div id="message_error" align="center"></div>
	
<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Referral Mailbox >') ?>
	</h3>
	<p class="inner_t" >
		<?php echo __(' Outbox'); ?>
	
	</p>
</div>

<table class="table_first" width="100%"  cellspacing='0' cellpadding='0' >
	<tr>
		<td valign="top" width="5%" >	
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second" valign="top">
<!-- 			<div> -->
				<?php //echo $this->element('referral_icon');?>
<!-- 			</div> -->
			
<!-- 			<h3 style="padding: 28px;" align="center">
					<?php //echo __('Out Box Transmitted CCDA') ?>
				</h3>  -->
				<span> 
					<?php // echo $this->Html->link(__('Back'),array('controller'=>'messages','action'=>'ccdaMessage'),array('escape'=>false,'class'=>'blueBtn'));?>
				</span>
			</div>
			
			
			<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="100%" >
				<?php  if(isset($dataOfTransmitted) && !empty($dataOfTransmitted)){
					$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
					?>
				<tr class="row_title">
					<td class="table_cell"><strong><?php echo __('To') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('Subject') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('Name') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('Age') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('Sex') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('MRN') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('Date of Transmission') ?> </strong></td>
					 
					<td class="table_cell"><strong><?php echo __('Action') ?> </strong></td>
				</tr>
				<?php 
							  	  $toggle =0;
							      if(count($dataOfTransmitted) > 0) {
							      		foreach($dataOfTransmitted as $detail){ 
			
										       if($toggle == 0) {
											       	echo "<tr class='row_gray'>";
											       	$toggle = 1;
										       }else{
											       	echo "<tr>";
											       	$toggle = 0;
										       }
											  ?>
				
			
					<td class="row_format">&nbsp;<?php echo $detail['TransmittedCcda']['to'] ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $detail['TransmittedCcda']['subject'] ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $detail['Patient']['lookup_name'] ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $detail['Person']['age'] ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $detail['Person']['sex'] ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $detail['Patient']['admission_id'] ?>
					</td>
					<td class="row_format">&nbsp;<?php
					if(!empty($detail['TransmittedCcda']['referral_date'])){
							$localDate  = $this->DateFormat->formatDate2local($detail['TransmittedCcda']['referral_date'],Configure::read('date_format_us')) ;
							echo $localDate ;
					}?>
					</td>
					<td class="row_format" style="display:inline"> 
					<?php
				 if($detail['TransmittedCcda']['type']=='ccda')
					echo $this->Html->image('icons/view-icon.png',array('onclick'=>'view_consolidate_ccda(\''.$this->Html->url(array('action'=>'view_consolidate',$detail['TransmittedCcda']['patient_id'])).'\')','escape'=>false,'style'=>'margin:5px 0 0 15px;')); ?>
				</td>
				</tr>
			
				<?php }$this->Paginator->options(array('url' =>array("?"=>$queryStr))); ?>
			
				<tr>
								    <TD colspan="8" align="center">
								    <!-- Shows the page numbers -->
								 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
								 <!-- Shows the next and previous links -->
								 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
								 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
								 <!-- prints X of Y, where X is current page and Y is number of pages -->
								 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
								    </TD>
								   </tr>
								   <?php } ?> <?php		
								   } else {
								   	?>
								   			  <tr>
								   			   <TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
								   			  </tr>
								   			  <?php
								   			      }
								   			  ?>
			</table>
		</td>
	</tr>
</table>
			
			
			
<script>

function view_consolidate_ccda($url) { 
	$.fancybox({ 
		'width' : '85%',
		'height' : '100%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : $url 
	});
}

</script>