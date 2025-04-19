<?php  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));      
echo $this->Html->script(array('jquery-ui-1.8.5.custom.min.js?ver=3.3','slides.min.jquery.js?ver=1.1.9',
									'jquery.isotope.min.js?ver=1.5.03','jquery.custom.js?ver=1.0','ibox.js','jquery.fancybox-1.3.4')); ?>


<!-- <script
	src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script> -->

<?php // echo $this->Html->script('fckeditor/fckeditor');  ?>
<?php //echo $javascript->link('fckeditor'); ?>
<style>
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

.table_format {
	border: 1px solid #3E474A;
}

.email_format {
	border: 1px solid #3E474A;
}

/**
 * for left element1
 */
.table_first{
 	margin: -25px;
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
/* EOCode */

</style>
<div id="message_error"
			align="center"></div>
			
<div class="inner_title" style="margin-bottom: 25px;">
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Immunization Mailbox') ?>
	</h3>
</div>
<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%" style="padding-left: 25px;">
		   <div class="mailbox_div">
				<?php echo $this->element('mailbox_index');?>
			</div>
		</td>
		<td class="td_second" valign="top">
			<div class="mailbox_div">
				<?php echo $this->element('hl7_list_immunization');?>
			</div>
       </td>
     </tr>
 </table>
