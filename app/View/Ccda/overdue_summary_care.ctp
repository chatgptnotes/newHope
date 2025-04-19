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

/**
 * for left element1
 */
.table_first{
 	margin: -25px;
 	
}

.td_second{
	border-left-style:solid; 
	padding-left: 25px; 
	padding-top: 25px
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}
/* EOCode */


</style>
<div id="message_error"
	align="center"></div>
<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Mailbox') ?>
	</h3>
</div>
<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%">	
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second" valign="top">
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
						<td class="table_cell tdLabel" align="center"><strong><?php echo __('Type') ?>
						</strong></td>
						<td class="table_cell tdLabel"><strong><?php echo __('To') ?> </strong>
						</td>
						<td class="table_cell tdLabel"><strong><?php echo __('Subject') ?> </strong>
						</td>
						<td class="table_cell tdLabel"><strong><?php echo __('File Name') ?> </strong>
						</td>
						<td class="table_cell tdLabel"><strong><?php echo __('Date') ?> </strong>
						</td>
						<td class="table_cell tdLabel"><strong><?php echo  __('Action'); ?>
						</strong>
						</td>
					</tr>
					<?php 
					$replace = array(
							'/\s/' => '_',
							'/[^0-9a-zA-Z_\.]/' => '',
							'/_+/' => '_',
							'/(^_)|(_$)/' => '',
					);
					
					$preparedArray = array() ;
					foreach($receivedItems as $key=>$value){
						$splitted = explode("_",$key) ; 
						unset($splitted[0]); 
						$key = implode("_",$splitted); 
						$preparedArray[$key] = $value;
					}
					  
					
			$toggle =0; 
			 
			if(count($sentItems) > 0) { 
				foreach($sentItems as $message){ 
			        $sentTime  =$this->DateFormat->dateDiff($message['TransmittedCcda']['created_on'],date('Y-m-d H:i:s')); 
			         
			        $replacedFileName  = preg_replace(array_keys($replace), $replace, $message['TransmittedCcda']['file_name']) ;
					if(!empty($preparedArray[$replacedFileName]) ||  $sentTime->days  == "0") continue ; //check if xml is in incorparted_ccda list
					if($toggle == 0) {
						echo "<tr class='row_gray'>";
						$toggle = 1;
					}else{
						echo "<tr>";
						$toggle = 0;
					}
					$messageId = $message['TransmittedCcda']['id'];
					$isPatient = $message['TransmittedCcda']['is_patient'];
					//$isRead = $message['Outbox']['is_read'];
					$message['TransmittedCcda']['message'] = str_replace(" ", "+", $message['TransmittedCcda']['message']);
					//$message['Outbox']['subject'] = str_replace(" ", "+", $message['Outbox']['subject']);
					?>
						<td align="center"><?php 
						if($message['TransmittedCcda']['type'] == 'Urgent'){
					echo $this->Html->image('icons/urgent.jpg',array('title'=>'Urgent','alt'=>'Urgent','width'=> '15','height'=>'15'));
					}else{
					echo $message['TransmittedCcda']['type'];
					}
					?>
						</td>
						<td class="row_format is_read" id="from_<?php echo $messageId;?>"><a
							href="#"><?php echo $message['TransmittedCcda']['to']; ?> </a></td>
						<td class="row_format is_read" id="subject_<?php echo $messageId;?>"><a
							href="#"><?php echo $message['TransmittedCcda']['subject']; ?> </a>
						</td>
						<td class="row_format is_read" id="message_<?php echo $messageId;?>"><a
							href="#"><?php  
							echo $message['TransmittedCcda']['file_name'];
							if(strlen($dec_message) > 50) echo substr($dec_message, 0, 50).'...';else{echo $dec_message;
					} ?> </a>
						</td>
						<!--  <td><?php echo $dec_message;?> </td>-->
						<td class="row_format is_read" id="time_<?php echo $messageId;?>"><a
							href="#"><?php echo $this->DateFormat->formatDate2Local($message['TransmittedCcda']['referral_date'],Configure::read('date_format'),false); ?>
						</a></td>
						<td class="row_format is_read"><?php 
						echo $this->Html->link($this->Html->image("icons/edit-icon.png",array('alt'=>'Send Reminder','title'=>'Send Reminder')),
								array('controller'=>'Messages','action'=>'composeCcda',$message['TransmittedCcda']['patient_id'],'?'=>array('type'=>"reminder",'transmittedID'=>$message['TransmittedCcda']['id'])),
								array('escape' => false  ));
						echo "&nbsp;" ;
						echo $this->Html->link($this->Html->image("icons/view-icon.png",array('alt'=>'View CCDA','title'=>'View CCDA')),'#',
					 array('onclick'=>"view_message('".$message['TransmittedCcda']['id']."')",'escape' => false  )); ?> 
											  </td>
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
		</td>
	</tr>
</table>
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