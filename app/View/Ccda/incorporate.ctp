
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
	padding-top: 25px;
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}

.black_line{
	padding-top: 15px;
	border-top: 1px solid #4C5E64; 
}
.table_format{
	padding: 0px;
}
.inner_title h3{
	padding: 5px;
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
		<?php echo __(' Incorporate'); ?>
	
	</p>
</div>
	
<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%">	
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
			<td class="td_second" valign="top">
<!-- 			<div class="mailbox_div"> -->
				<?php //echo $this->element('referral_icon');?>
<!-- 			</div> -->
<!-- 			<div class="inner_title" > -->

 <!-- 				<h3 style="padding: 28px;" align="center">
					<?php //echo __('Incorporated Patient List') ?>
				</h3>   -->
<!-- 				<span>  -->
					<?php // echo $this->Html->link(__('Back'),array('controller'=>'messages','action'=>'ccdaMessage'),array('escape'=>false,'class'=>'blueBtn'));?>
<!-- 				</span> -->
<!-- 			</div> -->
					
			<table border="0" class="table_format" cellpadding="0" cellspacing="0"
				width="100%">
				<?php  if(isset($data) && !empty($data)){
					
					$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
					?>
				
				<tr class="row_title">
					<td class="table_cell"><strong><?php echo __('Patient Name') ?> </strong></td>
					<td class="table_cell"><strong><?php echo __('File Name') ?> </strong> </td>
					<td class="table_cell"><strong><?php echo __('Summary Care Date') ?> </strong> </td>
					<td class="table_cell"><strong><?php echo __('Action') ?> </strong> </td>
				</tr>
				<?php 
							  	  $toggle =0;
							      if(count($data) > 0) {
							      		foreach($data as $details){ 
										       if($toggle == 0) {
											       	echo "<tr class='row_gray'>";
											       	$toggle = 1;
										       }else{
											       	echo "<tr>";
											       	$toggle = 0;
										       }
											  ?>
					<td class="row_format">&nbsp;<?php echo $details['Patient']['lookup_name'] ?>
					</td>
					<td class="row_format">&nbsp;<?php echo $details['IncorporatedPatient']['xml_file'] ?>
					</td>
					<td class="row_format">&nbsp;<?php
						if(!empty($details['IncorporatedPatient']['summary_care_date'])){
							$localDate  = $this->DateFormat->formatDate2local($details['IncorporatedPatient']['summary_care_date'],Configure::read('date_format_us')) ;
							echo $localDate ;  }?>
					</td>
					<td class="row_format">&nbsp;
					<?php echo $this->Html->link($this->Html->image("icons/edit-icon.png",array('alt'=>'Edit','title'=>'Edit')),'#',
						array('onclick'=>"edit_date(".$details['IncorporatedPatient']['id'].")",'escape' => false )); ?>
					</td>
				</tr>
				<?php } 
						$this->Paginator->options(array('url' =>array("?"=>$queryStr))); 	
					   ?>
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
				}  else {
						 ?>
						  <tr>
						   <TD colspan="8" align="center" class="error"><?php echo __('No record found', true); ?>.</TD>
						  </tr>
						  <?php
						      }
						  ?>
				</table>
				<div class="clr">&nbsp;</div>
		  </td>
	 </tr>
</table>
	<script>

	function edit_date(id) {
 		$.fancybox({ 
			'width' : '85%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "edit_summary_care_date")); ?>"
			+ '/' + id+"/"+true
			});
 	}
	</script>