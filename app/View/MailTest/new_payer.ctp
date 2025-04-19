<?php echo $this->Html->css('internal_style.css');
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3','jquery.autocomplete'));
echo $this->Html->css('jquery.autocomplete.css');?>
<div class="inner_title">
	<h3>
		<?php echo __('Map Payer'); ?>
	</h3>
</div>
<div class="clr">&nbsp;</div>

<?php echo $this->Form->create('mapPayer',array('type' => 'file','id'=>'mapPayer','inputDefaults' => array(
		'label' => false,'action'=> 'newPayer',	'div' => false,	'error' => false))); ?>
<table border="0" class=" " cellpadding="0" cellspacing="0" width="100%"
	align="center">
	<tbody>

		<tr class="row_title">
			<td class=" " align="right" width="8% "><label><?php echo __('Payer Name') ?>
			</label>
			</td>
			<td class=" " align="right"><label><?php echo $this->Form->input('name', array('empty'=>__('Please Select'),'options'=>$getPayerName,'class' => '','id' => 'payername')); ?>
			
			</label>
			</td>
			<td class=" " align="right"><label><?php echo $this->Html->link($this->Html->image('/img/icons/search_icon.png',array('title'=>'Search','alt'=>'Search')),'javascript:void(0)', array('style'=>array('width:20px'),'escape' => false,'onclick'=>'getPayer()')); ?>
			</label>
			</td>
		</tr>
	</tbody>
</table>
<div id='showList'></div>
<?php echo $this->Form->end();?>
<script>

$('#tarif_name').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","TariffList","name","admin" => false,"plugin"=>false)); ?>",
		{
			width : 250,
			selectFirst : true
		});
function getPayer(){
	var id=$('#payername').val();
	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MailTest", "action" => "newPayerList","admin"=>false)); ?>"+"/"+id;
		$.ajax({
			type : "POST",
			url : ajaxUrl , 
			
			beforeSend:function(){
				$('#busy-indicator').show('fast');
          },
			success: function(data){
				$('#busy-indicator').hide('fast');
			$('#showList').html(data);
				},
			
			error: function(message){
			alert(message);
			}
			
		})
}
</script>
