<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>

<style>
.is_read { /*font-weight: bold;*/
	font-size: 13px;
}

#forward_message_text {
	display: none;
}

#open_message {
	display: none;
}

.class_td {
	font-size: 16px;
	font-weight: bold;
	background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 transparent;
	border-bottom: 1px solid #3E474A;
	color: #FFFFFF;
}

.class_td1 {
	background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 transparent;
	border-bottom: 1px solid #3E474A;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
}

.class_td2 {
	background: -moz-linear-gradient(center top, #3E474A, #343D40) repeat
		scroll 0 0 transparent;
	border-bottom: 1px solid #3E474A;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: bold;
}

.table_format { /*border: 1px solid #3E474A;*/
	background: #f5f5f5;
}

.email_format {
	border: 1px solid #3E474A;
}

.patient_infodiv {
	
}

.row_gray {
	background: none;
}

.nav_link {
	width: 92%;
	float: left;
	margin: 0px;
	padding: 20px;
}

.links {
	float: left;
	font-size: 13px;
	clear: left;
	line-height: 30px;
}

.links:hover {
	background: #F5F5F5;
	padding: 0px;
	margin: 0px;
	text-decoration: none;
}

.table_format td {
	border-bottom: 1px solid #DCDCDC;
}

.activelink a:active {
	font-weight: bold;
}
;
</style>
<div id="message_error"
	align="center"></div>
<div class="mailbox_div">
	<?php echo $this->element('mailbox_index');?>
</div>
<div align="center" id='temp-busy-indicator' style="display: none;">
	&nbsp;
	<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>
<div class="mid_section" style="width: 100%; float: left;">
	<div class="left_nav" style="width: 20%; float: left;">
		<?php echo $this->element('ccda_reports'); ?>
	</div>

	<table border="0" class="table_format" cellpadding="0" cellspacing="0"
		width="80%" style="float: right;">
		<tr class="row_title">
			<td class="table_cell tdLabel" align="center"><strong><?php echo __('Ordering Provider') ?>
			</strong></td>
			<td class="table_cell tdLabel"><strong><?php echo __('Test or appointment Ordered') ?> </strong>
			</td>
			<td class="table_cell tdLabel"><strong><?php echo __('Name of Specialist') ?> </strong>
			</td>
			<td class="table_cell tdLabel"><strong><?php echo __('Referral initiated date') ?> </strong>
			</td>
			<td class="table_cell tdLabel"><strong><?php echo __('Status') ?> </strong>
			</td>
			<td class="table_cell tdLabel"><strong><?php //echo  __('Action'); ?> </strong>
			</td>
		</tr>
		<?php 
		$replace = array(
				'/\s/' => '_',
				'/[^0-9a-zA-Z_\.]/' => '',
				'/_+/' => '_',
				'/(^_)|(_$)/' => '',
		);
	 
		  
		
$toggle =0; 
 
if(count($referralToSpecialist) > 0) { 
	foreach($referralToSpecialist as $messageData){  
        $message = $messageData['ReferralToSpecialist'] ;
       
        $transitionedDate  =$this->DateFormat->formatDate2Local($message['referral_initiated_date'],Configure::read('date_format'),true); 
          
		?>
		<tr>
		<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#"><?php echo $message['provider']; ?> </a></td>
		<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#"><?php echo $message['appt_order']; ?> </a></td>
		<td class="row_format is_read" id="from_<?php echo $messageId;?>"> <a href="#"><?php echo $message['specialist_name']; ?> </a></td>
		<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#"><?php echo $transitionedDate; ?> </a></td>
		<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a href="#"><?php echo $message['log']; ?> </a></td>
				
		 			 
			<td class="row_format is_read"><?php 
			/* echo $this->Html->link($this->Html->image("icons/edit-icon.png",array('alt'=>'Send Reminder','title'=>'Send Reminder')),
					array('controller'=>'Messages','action'=>'composeCcda',$message['TransmittedCcda']['patient_id'],'?'=>array('type'=>"reminder",'transmittedID'=>$message['TransmittedCcda']['id'])),
					array('escape' => false  ));
			echo "&nbsp;" ;
			echo $this->Html->link($this->Html->image("icons/view-icon.png",array('alt'=>'View CCDA','title'=>'View CCDA')),'#',
		 array('onclick'=>"view_message('".$message['TransmittedCcda']['id']."')",'escape' => false  ));  */?> 
								  </td>
								  </tr> 
	<?php } 
	}?>
	<tr>
		<TD colspan="8" align="center" style="border-bottom:none; padding-top:13px;">
			<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			<!-- prints X of Y, where X is current page and Y is number of pages -->
			<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
		
		</TD>
	</tr>
</table>
</div>

<script>
function view_message(id) {
	
	// id= $(this).attr("id");
	 
	 $.fancybox({ 
						'width' : '85%',
						'height' : '100%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_message")); ?>"
						+ '/' + id 
						});
		
/*	 var ajaxUrl = "<?php  echo $this->Html->url(array("controller" => "ccda", "action" => "isCcdaGenerated","admin" => false)); ?>";
        $.ajax({
          type: 'POST',
          url: ajaxUrl+"/"+id,
          data: '',
          dataType: 'html',
          success: function(data){
	           
				if(data==1){
					$.fancybox({ 
						'width' : '85%',
						'height' : '100%',
						'autoScale' : true,
						'transitionIn' : 'fade',
						'transitionOut' : 'fade',
						'type' : 'iframe',
						'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate")); ?>"
						+ '/' + id 
						});
				}else{
					alert("Please generate CCDA and try again");
					return false ;
				}
		  },
		  error: function(message){
              alert(message);
          }        
       });*/


          return false ;

          
/*	$.fancybox({

	'width' : '85%',
	'height' : '100%',
	'autoScale' : true,
	'transitionIn' : 'fade',
	'transitionOut' : 'fade',
	'type' : 'iframe',
	'href' : "<?php echo $this->Html->url(array("controller" => "ccda", "action" => "view_consolidate")); ?>"
	+ '/' + patient_id 
	});*/

 }
	


</script>