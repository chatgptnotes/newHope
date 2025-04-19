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
	padding-top: 25px
}

.title_format{
	color: #31859c; 
	float: left; 
	font-size: 15px;
}
.table_format{
	padding: 0px;
}

.inner_title h3 {
    clear: both !important;
    float: left !important;
	padding:-5px !important;
}
.inner_title p{padding-top: 6px; margin:0px;}

.inner_t{
 	color: #1c7087;
    font-size: 14px;
    font-weight: bold;
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


<div id="message_error" align="center"></div>

<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Lab Mailbox >') ?>
	</h3>
	<p style="margin-right: 1030px;margin-bottom: 5px;" class="inner_t" >
		<?php echo __(' Inbox'); ?>
	
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
				<?php //echo $this->element('hl7_list'); ?>
<!-- 			</div> -->
			<div class="" >
			<!-- <span><?php  echo $this->Html->link('Back',array("controller"=>"Messages","action"=>"index"),array('escape'=>false,'class'=>'blueBtn')); ?></span> -->
			</div>
		</td>
	</tr>
</table>