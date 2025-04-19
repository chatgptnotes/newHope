<?php 
echo $this->Html->script('jquery.autocomplete');
echo $this->Html->css('jquery.autocomplete.css');
?>
<div class="inner_title">
	<h3><?php echo __('Smart Templates'); ?></h3>
</div>
<?php echo $this->Form->create('',array('action'=>'smartTemplate','id'=>'doctortemplatefrm','default'=>false,'inputDefaults' => array('label' => false,'div' => false)));?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id="tabularForm">
<tr>
	<td>Medication</td>
	<td>
		<?php  echo $this->Form->input('', array('type'=>'text','class' => 'drugText validate[required,custom[mandatory-enter]]' 
				,'id'=>"drugText_0",'name'=> 'drugText[]','autocomplete'=>'off','counter'=>'0','style'=>'width:271px!important;','label'=>false)); ?>
		<input type="hidden" id="drug_id" name="drug_id[]"> 
		<input type="hidden" id="dose" name="dose[]">
		<input type="hidden" id="strength" name="strength[]">
		<input type="hidden" id="route" name="route[]">
		<input type="hidden" id="nameMed" name="nameMed[]">
		<input type="button" value="select" name="select" onclick="addMore()" class="blueBtn">
	</td>
	<td>
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tabularForm" id="medicationList">
			<tr>
				<td>Medication List</td>
				<td><input type="button" value="Done" name="DoneMed" onclick="DoneMed()" class="blueBtn"></td>
			</tr>
		</table>
	</td>
</tr>
</table>
<?php echo $this->Form->end();?>
<script>
$(document).ready(function(){
});

$('.drugText')
.live(
		'focus',
		function() {
			var currentId=	$(this).attr('id').split("_"); // Important
			var attrId = this.id;
			
		var counter = $(this).attr(
					"counter");
			
			if ($(this).val() == "") {
				$("#Pack" + counter).val("");
			}
			
			$(this)
					.autocomplete(
																														
							"<?php echo $this->Html->url(array("controller" => "Notes", "action" => "pharmacyComplete","PharmacyItem",'name',"drug_id",'MED_STRENGTH','MED_STRENGTH_UOM','MED_ROUTE_ABBR','Status=A',"admin" => false,"plugin"=>false)); ?>",
							{
								
								width : 250,
								selectFirst : true,
								valueSelected:true,
								minLength: 3,
								delay: 1000,
								isOrderSet:true,
								showNoId:true,
								loadId : $(this).attr('id')+','+$(this).attr('id').replace("Text_",'name')+','
								+$(this).attr('id').replace("drugText_",'dose_type')
								+','+$(this).attr('id').replace("drugText_",'strength')
									+','+$(this).attr('id').replace("drugText_",'route_administration'),
									
								onItemSelect:function(event, ui) {
									//lastSelectedOrderSetItem
									var compositStringArray = lastSelectedOrderSetItem.split("    ");
									if((compositStringArray[1] !== undefined) && (compositStringArray[1] != '')){
										var pharmacyIdArray = compositStringArray[1].split("|");
										$('#drug_id').val(pharmacyIdArray[0]);
										$('#dose').val(pharmacyIdArray[1]);
										$('#strength').val(pharmacyIdArray[2]);
										$('#route').val(pharmacyIdArray[3]);
										$('#nameMed').val(compositStringArray[0]);
									}
								}
								
							});
			

		});
var drugId=[];
var dose=[];
var strength=[];
var route=[];
var nameMed=[];
var cnt='0';
function addMore(){
	cnt++;
	if($('#drugText_0').val()==""){
		alert('Add Medication');
		return false;
	}
	drugId.push($('#drug_id').val());
	dose.push($('#dose').val());
	strength.push($('#strength').val());
	route.push($('#route').val());
	nameMed.push($('#drugText_0').val());
	var nameOFmed=$('#drugText_0').val();
	$("#medicationList").find('tbody')
    .append($('<tr>').attr('id',cnt)
			        .append($('<td>').text(" "+nameOFmed+" "))
			        .append($('<td>').attr('class','removeTr').attr('id', 'remove_'+cnt).html('<?php echo $this->Html->image('/img/icons/cross.png', array('alt' => 'Remove'));?>'))
			        .append($('<td>').text())
			       
    );
	$('#drugText_0').val(' ');
}

$('.removeTr').live("click",function(){
var cuurentId=$(this).attr('id');
var idNumber=cuurentId.split('_');
var newNo=idNumber[1];
alert('idNumber----'+idNumber[1]);
alert('newNo----'+(newNo-1));
$('#'+idNumber[1]).remove();
alert('elePOP-------------'+nameMed[newNo-1]);
var elePOP=nameMed[newNo-1];
alert('placed-----------'+elePOP);
nameMed.pop(elePOP); 
drugId.pop([idNumber[1]]);
strength.pop([idNumber[1]]);
dose.pop([idNumber[1]]);
route.pop([idNumber[1]]);
alert(nameMed);
});
</script>
                      