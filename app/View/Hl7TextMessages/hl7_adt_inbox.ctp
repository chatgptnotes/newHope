<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
<script>
    //var encrypted = CryptoJS.AES.encrypt("First Message", "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");

    //alert(encrypted); // {"ct":"tZ4MsEnfbcDOwqau68aOrQ==","iv":"8a8c8fd8fe33743d3638737ea4a00698","s":"ba06373c8f57179c"}

    //var decrypted = CryptoJS.AES.decrypt(encrypted, "0xb613679a0814d9ec772f95d778c35fc5ff1697c493715653c6c712144292c5ad");
//alert(decrypted);
    //alert(decrypted.toString(CryptoJS.enc.Utf8)); // Message
</script>
<?php  echo $this->Html->script('fckeditor/fckeditor');  ?>
 <?php //echo $javascript->link('fckeditor'); ?> 
 
<style>

.is_read{
font-weight: bold;
font-size: 12px;
}
#forward_message_text{
display:none;
}
#open_message{
display:none;
}
.class_td{
font-size:12px;
font-weight:bold;
background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
border-bottom: 1px solid #3E474A;
color: #FFFFFF;
}

.class_td1{background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
   border-bottom: 1px solid #3E474A;
   color: #FFFFFF; font-size:12px;font-weight:bold;
}
.class_td2{background: -moz-linear-gradient(center top , #3E474A, #343D40) repeat scroll 0 0 transparent;
   border-bottom: 1px solid #3E474A;
   color: #FFFFFF; font-size:12px;font-weight:bold;
}
.table_format{
border: 1px solid #3E474A;}
.email_format{border: 1px solid #3E474A;}

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

.inner_title{
	padding: 0px;
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
<div id="message_error" align="center"></div>

<div class="inner_title" >
	<h3>
	&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo __('Syndromic Mailbox >') ?>
	</h3>
	<span style="margin-right: 980px;margin-bottom: 5px;" class="inner_t" >
		<?php echo __(' Inbox'); ?>
	
	</span>
</div>

<table class="table_first" width="100%"  cellspacing='0' cellpadding='0'>
	<tr>
		<td valign="top" width="5%">
			<div class="mailbox_div">
				<?php echo $this->element('mailbox_adt');?>
			</div>
		</td>
		<td class="td_second" valign="top">	
<!-- 			<div class="mailbox_div"> -->
				<?php //echo $this->element('hl7_list_adt');?>
<!-- 			</div> -->
			<div class="inner_title"></div>
		</td>
	</tr>
</table>