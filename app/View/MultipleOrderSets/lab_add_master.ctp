<style>
  .new{margin-left:20px;margin-top:20px;float:left;width:97%;}
  .inner_title{width:99% !important;}
  .inner_title span{margin:-19px 0!important;}
</style>
<?php 
echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3'));
echo $this->Html->script(array('jquery.autocomplete'));
echo $this->Html->css(array('jquery.autocomplete.css','internal_style.css'));
echo $this->Html->script(array('validationEngine.jquery','jquery.validationEngine','/js/languages/jquery.validationEngine-en'));
echo $this->Html->css(array('validationEngine.jquery.css'));
?>

<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Multiple Lab Orders', true); ?>
	</h3>
	<span><?php echo $this->Html->link(__('Back'),array('controller'=>'users','action' => 'menu',"admin"=>true,"?type=master"), array('escape' => false,'class'=>'blueBtn','style'=>'margin:0 22px 0 0;'));?></span>
</div>
<?php echo $this->Form->create('MultipleLabMaster',array('id'=>'multipleLabMaster','controller'=>'MultipleOrderSets','action'=>'labAddMaster'));?>
<table  border="0" cellspacing="0" cellpadding="0" class="formFull new" width="100%">
	<tr>
		<th colspan="5"><?php echo __("Add Multiple Lab Master") ; ?></th>
	</tr>
	<tr>
		<td width="10%" valign="middle" class="tdLabel" id="">
		<?php echo __("Title :");?><font color="red">*</font></td>
		<td width="10%"><?php echo $this->Form->input('title',array('type'=>'text','label'=>false,'style'=>'width:250px','id' =>'title',true,'class' => 'validate[required,custom[mandatory-enter]]')); ?></td>
	</tr>
	<tr>
	<td width="20%" valign="middle" class="tdLabel" id="">
		<?php echo __("Search Lab Name :");?></td>
		<td width="10%" valign="middle" class="tdLabel" id="" style="padding-left:0px!important;padding-right:10px;">
		<?php echo $this->Form->input('name',array('type'=>'text','label'=>false,'style'=>'width:250px','id' =>'name',true)); ?></td>
		<td>
		<?php echo $this->Html->link(__('Add'),'#',array('action'=>'#','class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'add'));?></td>
	</tr>
<tr>
		<td colspan="3" class='tdClass' style='display: none;'><ol></ol></td>
</tr>
	<tr>
		<td style="text-align: center; padding-top:12px;" colspan="2"><?php echo $this->Html->link(__('Submit'),'javascript:void(0)', array('class'=>'blueBtn','div'=>false,'id'=>'submit')); ?></td>
	</tr>
</table>
<?php echo $this->Form->end();?>
<div id="showList">
</div>
<!--  <table  border="0" cellspacing="0" cellpadding="0" class="formFull new">
	<tr>
		<th><?php echo __("Lab Master List") ; ?></th>
	</tr>
	<tr>
		<td><?php   foreach($getDataRecive as $getDataRecives){?>
			<table  border="0" cellspacing="0" cellpadding="0" class="formFull new">
					<tr>
						<th><?php echo $getDataRecives['MultipleLabMaster']['title']; ?></th>
					</tr>
					<?php  $explodeList=explode(',',unserialize($getDataRecives['MultipleLabMaster']['name'])); 
					foreach($explodeList as $explodeLists){?>
					<tr>
					    <td><?php echo $explodeLists;?></td>
					</tr>
					<?php }?>
			</table>
			<?php }?>
		</td>
	</tr>
</table>-->
<div align="center" id='busy-indicator' style="display: none;">
	&nbsp;
	<?php echo $this->Html->image('indicator.gif', array()); ?>
</div>

<script>
function getaddordermultiplesnew(){
	var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "ajaxaddordermultiplesnew","admin" => false)); ?>";
	// var data = { tile: title , nameLab: str};
		$.ajax({
				  type: "POST",
				  url: ajaxUrl,
				//  data:data,
				  beforeSend:function(){
				  	// this is where we append a loading image
				  	$('#busy-indicator').show('fast');
				  },
				  success: function(data){
					  $('#busy-indicator').hide('fast');
					  $('#showList').html(data);
			  }
		});
}
	$(document).ready(function(){
		getaddordermultiplesnew();
		$("#name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Laboratory","name",'null','null','null',"admin" => false,"plugin"=>false)); ?>", {
			width: 250,
			selectFirst: true,
		});	

		$("#submit").click(function(){
			
			 var validatePerson = jQuery("#multipleLabMaster").validationEngine('validate');
			 if (validatePerson) {
				 var str='';
				 $.each( PUSHArray, function( key, value ) {
					 str+=value+',';
					 });
				 var title=$('#title').val();
				 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "labAddMaster","admin" => false)); ?>";
				 var data = { tile: title , nameLab: str};
					$.ajax({
							  type: "POST",
							  url: ajaxUrl,
							  data:data,
							  beforeSend:function(){
							  	// this is where we append a loading image
							  	$('#busy-indicator').show('fast');
							  },
							  success: function(data){
								  $('.tdClass').hide();
								  $('#title').val('');
								  $('#showList').html(" ");
								  getaddordermultiplesnew();
						  							}
									});
							}
						else{
						return false;
						}	
				 });
			});
	
	var PUSHArray=new Array();
	 $("#add").click(function(){
		    var getname=$('#name').val();
		    $('.tdClass').show();
		    $("ol").append("<li>"+getname+"</li>");
		    $('#name').val("");
		    PUSHArray.push(getname);
		    
	 });
	 
	// for uppercase first letter by amit jain 
	 $("#title").keyup(function() {
	    toUpper(this);
	 });

	 function toUpper(obj) {
	     var mystring = obj.value;
	     var sp = mystring.split(' ');
	     var wl=0;
	     var f ,r;
	     var word = new Array();
	     for (i = 0 ; i < sp.length ; i ++ ) {
	         f = sp[i].substring(0,1).toUpperCase();
	         r = sp[i].substring(1).toLowerCase();
	         word[i] = f+r;
	     }
	     newstring = word.join(' ');
	     obj.value = newstring;
	     return true;  
	 }
</script>
