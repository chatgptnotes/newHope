<?php echo $this->Html->css(array('internal_style.css'));  
echo $this->Html->script(array('jquery-1.5.1.min'));
?>
<style>
.serviceHighlighted {
	border: 1px solid aqua;
}
</style>
<table  width="100%" align="center" cellpadding="0" cellspacing="0" border="0" id="runtimeChargeTable">
<tr class="row_title"><td class="table_cell" align="center">Bill Item</td></tr>
<?php foreach($cdmDSetails as $key=>$cdmDSetail){?>
<tr><td align="center" class="dblclick" id="<?php echo $key;?>"><?php echo $cdmDSetail['TariffList']['name'];?></td></tr>

<?php } ?>
</table>

<script>
$( ".dblclick" ).dblclick(function() {
	var selectedId = $(this).attr('id');
	parent.addRowWithCDMDetails(selectedId,selectedId);
	parent.$.fancybox.close();
});
$( ".dblclick" ).click(function() {
	$('#runtimeChargeTable td').removeClass('serviceHighlighted');
	$(this).addClass('serviceHighlighted');
	
});
</script>