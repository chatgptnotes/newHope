<?php 
echo $this->Html->script(array('jquery-1.5.1.min','jquery.fancybox-1.3.4','jquery.autocomplete'/*,'inline_msg'*/,'jquery.blockUI'));
echo $this->Html->css(array('internal_style.css','order_set.css','jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));
echo $this->Html->script('ckeditor/ckeditor');
echo $this->Html->script('ckeditor/adapters/jquery.js');
?>

<style>
*{
	margin: 0px;
	padding:0px;
	font-size: 12px;
}
li{
list-style: none;
list-style-type: none;
}
body{
	font-size: 11px;
	padding: 0px;
}
.table_format{
	padding: 0px;
}
.table_format tr:first-child td{
	border-right: 1px solid #fff;
	padding-top:2px;
	padding-bottom:2px;
}
.orderMainWrapper{
	width:100%;
	margin-top: 10px;
	min-height: 400px;
}
.leftMainWrapper{
	width:0%;
	padding-right:10px;
}
.rightMainWrapper{
	width:100%;
	padding-left:50px;
	padding-right:50px;
}
.folderAddSection{
	width: 100%;
}
.mainWrapperBorder{
	border-right: 5px solid #fff;
	
}
.innerTop{
	font-size: 13px;
}
.rightOrderAreaSection{
	border: 1px solid #fff;
	margin-top:5px;
	
}
.orderArea{
	width:49%;
}
.middleOrderArea{
	width:1%;
	/*border-right: 1px solid #fff;*/
}
.filetrees li  {
	list-style: none;
	list-style-type: none;
	padding-left:3px;
	padding-bottom: 5px;
}
.innerOrderSet{
	padding-left: 10px;
	display:none;
}
.innerOrderSet li{
	padding-bottom: 10px;
	list-style: none;
	list-style-type: none;
}
.cllickedFolder{
	min-height: 250px;
	padding-top:10px;
}
.patientInfo{
	padding-bottom: 6px;
}
.highlight{
	background:none repeat scroll 0 0 #A1B6BD;
}
.highlightIcon{
	background:none repeat scroll 0 0 #A1B6BD;
}
.orderHighlight{
	color:#2D85E2;
}
fieldset {padding: 10px;border: 1px solid #fff;}
legend {padding: 2px;font-size: 13px;}
#at_location {
    width: 183px !important;
}
</style>

<div id="mainContentArea">
<table id="patientInfo" class="patientInfo" width="100%">

</table>
<table id="orderMainWrapper" class="orderMainWrapper" width="100%">

<tr>
<td></td>
<!--<td class="leftMainWrapper" id="leftMainWrapper">
<table id="patientInfo" class="patientInfo" width="100%">
<tr><td>
<fieldset>
<legend>Diaggnosis (Problem) being Addressed this Visits</legend>
<div class="folderAddSection">
<table id="innerTop" class="innerTop" width="100%">
<tr>
<td>+</td>
<td>Add</td>
<td></td>
<td>Convert</td>
<td style="border-right: 1px solid #fff;">&nbsp;</td>
<td>Display:DropDown</td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="table_format">
<tr style="" class="row_title">
		<td width="15%" valign="top" class="table_cell">&nbsp;</td>
		<td width="15%" valign="top" class="table_cell">&nbsp;</td>
		<td width="50%" valign="top" class="table_cell">Clinical Dx</td>
		<td width="20%" valign="top" class="table_cell" style="border:none">Code</td>
</tr>
</table>
</div>
</fieldset>
</td></tr>
</table>
</td>
<td class="mainWrapperBorder">&nbsp;</td>-->
<td class="rightMainWrapper" id="rightMainWrapper" valign="top" align="left">
<table id="patientInfo" class="patientInfo" width="100%">
<tr class="">
		<td><?php echo __('Find');?>:</td>
		<td valign="middle" style="width:155px;"><?php echo $this->Form->input('searchKey',array('class' => 'textBoxExpnd','label'=>false,'type'=>'text','id'=>'searchKey','style'=>'width:150px'));?></td>
		<td  valign="middle" style="width:10px;"><?php echo $this->Html->image('icons/order_set/lookup.png',array('id'=>'lookup'));?></td>
		<td  valign="middle"><?php echo $this->Form->input('like', array('label'=> false,'id'=>'like','style'=>'width:150px','options'=>array('1'=>__('Contains'),'2'=>__('Starts With'))));?></td>
		<td  valign="middle"><?php //echo $this->Form->input('advance', array('disabled' =>'disabled','label'=> false,'id'=>'advance','style'=>'width:150px','options'=>array('Advance Options'=>__('Advance Options'),'Starts With'=>__('Starts With'))));?></td>
		<td valign="middle" style="width:20px"><?php echo __('Type');?>:</td>
		<td  valign="middle"><?php echo $this->Html->image('icons/order_set/type.png',array('id'=>'type'));?></td>
		<td valign="middle"><?php echo $this->Form->input('patient_type', array('disabled' =>'disabled','label'=> false,'id'=>'patient_type','style'=>'width:150px','options'=>array('Inpatient'=>__('Inpatient'),'Ambulatory'=>__('Ambulatory'))));?></td>
</tr>
</table>
<table id="IconHub" class="patientInfo" width="100%">
<tr class="">
		<td valign="middle" style="width:25px;height:25px"><?php echo $this->Html->image('icons/order_set/up.png',array('id'=>'up','title'=>'Back','alt'=>'Back'));?></td>
		<td valign="middle" style="width:25px;height:25px"><?php echo $this->Html->image('icons/order_set/home.png',array('id'=>'home','title'=>'Home','alt'=>'Home'));?></td>
		<td  valign="middle" style="width:25px;height:25px"><?php echo $this->Html->image('icons/order_set/favourite.png',array('id'=>'favourite','title'=>'Favourite','alt'=>'Favourite'));?></td>
		<!--<td  valign="middle"><?php echo $this->Html->image('icons/order_set/arrow.png',array('id'=>'arrow'));?></td>-->
		<td  valign="middle"><?php echo $this->Html->image('icons/order_set/folder.png',array('id'=>'folder','title'=>'Common','alt'=>'Common'));?></td>
		<!--  <td valign="middle" style="width:25px;height:25px"><?php echo $this->Html->image('icons/order_set/pages.png',array('id'=>'pages'));?></td>
		-->
		<td  valign="middle"><?php echo __('Folder');?>: <span id="currentFolder"></span></td>
		<td valign="middle"><?php echo __('Search within');?>: </td>
		<td  valign="middle"><?php echo $this->Form->input('search_within', array('label'=> false,'id'=>'search_within','style'=>'width:150px','options'=>array('All'=>__('All'),'favourite'=>__('Favourite'),'common'=>__('Common'),'home'=>__('Home'))));?></td>
		<td ><?php echo __('At Location');?>: </td>
		<td valign="middle"><?php echo $this->Form->input('at_location', array('label'=> false,'id'=>'at_location','style'=>'width:150px','options'=>$locations,'value'=>$currentLocation));?></td>
		<td valign="middle" style="margin:0px!important;"><?php echo $this->Html->link(__('Done'),'javascript:void(0)',array('id'=>'done1','class'=>'blueBtn','div'=>false,'label'=>false,'style'=>"float:right"));?></td>
</tr>
</table>
<table id="rightOrderAreaSection" class="rightOrderAreaSection" width="100%">
<tr class="">
		<td valign="top" class="orderArea" align="left">
		<div class="revenue_panel" id="customOrderSet">
<ul class="filetrees" id="browser">
<?php //echo'sssssssss';pr($orderCategories);exit;
$lastOrderCategory = '';
foreach($orderCategories as $orderCategory){
	if(empty($lastOrderCategory)){
		echo '<li class="collapsable dataSetFolder"><div class="hitarea collapsable-hitarea"></div><span class="folder" id="folder'.$orderCategory["OrderCategory"]["id"].'">'.$orderCategory["OrderCategory"]["order_description"].'</span>';
	}else {if(!empty($orderCategory) && ($lastOrderCategory != $orderCategory['OrderCategory']['order_description'])){
		echo '</li><li class="collapsable dataSetFolder"><div class="hitarea collapsable-hitarea"></div><span class="folder" id="folder'.$orderCategory["OrderCategory"]["id"].'">'.$orderCategory["OrderCategory"]["order_description"].'</span>';
	}
}
	
?>	
		<ul class="innerOrderSet" id="ChildOrderSet_<?php echo $orderCategory['OrderCategory']['id'];?>">
		<?php
		
		
if($orderCategory['OrderCategory']['order_alias']=='med')
{
	
	foreach($medData as $medData){?>
						<li class="last serviecSelectableInput"><span class="orderSelectable" id="<?php echo preg_replace('/[^a-z\d ]/i', '', $medData["PharmacyItem"]["name"]);?>_serviecSelectable_<?php echo preg_replace('/[^a-z\d ]/i', '', $medData["PharmacyItem"]["name"]);?>"><?php echo $medData["PharmacyItem"]['name'];?>
						<input type="hidden" id="OrderCategory_id_<?php echo $orderCategory['OrderCategory']['id'];?>" value="<?php echo $orderCategory['OrderCategory']['id'];?>">
						<input type="hidden" id="OrderDataMaster_id_<?php echo $medData["PharmacyItem"]['id'];?>" value="<?php echo $medData["PharmacyItem"]['id'];?>">
						<input type="hidden" id="serviecSelectable__name_<?php echo $medData["PharmacyItem"]['name'];?>" value="<?php echo $medData["PharmacyItem"]['name'];?>">
						<input type="hidden" id="serviecSelectable__order_alias_<?php echo $orderCategory['OrderCategory']['order_alias'];?>" value="<?php echo $orderCategory['OrderCategory']['order_alias'];?>">
						<input type="hidden" id="serviecSelectable__PharmacyItem_order_id_<?php echo $medData["PharmacyItem"]['id'];?>" value="<?php echo __('PharmacyItem');?>">
						<input type="hidden" id="patientOrderEnc_<?php echo $patientOrderEnc;?>" value="<?php echo $patientOrderEnc;?>">
						
						</span>
						</li>
						<?php }
}
else if($orderCategory['OrderCategory']['order_alias']=='lab')
{
	foreach($labData as $labData){
?>
						<li class="last serviecSelectableInput"><span class="orderSelectable" id="<?php echo preg_replace('/[^a-z\d ]/i', '', $labData["Laboratory"]["name"]);?>_serviecSelectable_<?php echo preg_replace('/[^a-z\d ]/i', '', $labData["Laboratory"]["name"]);?>"><?php echo $labData["Laboratory"]['name'];?>
						<input type="hidden" id="OrderCategory_id_<?php echo $orderCategory['OrderCategory']['id'];?>" value="<?php echo $orderCategory['OrderCategory']['id'];?>">
						<input type="hidden" id="OrderDataMaster_id_<?php echo $labData["Laboratory"]['id'];?>" value="<?php echo $labData["Laboratory"]['id'];?>">
						<input type="hidden" id="serviecSelectable__name_<?php echo $labData["Laboratory"]['name'];?>" value="<?php echo $labData["Laboratory"]['name'];?>">
						<input type="hidden" id="serviecSelectable__order_alias_<?php echo $orderCategory['OrderCategory']['order_alias'];?>" value="<?php echo $orderCategory['OrderCategory']['order_alias'];?>">
						<input type="hidden" id="serviecSelectable__Laboratory_order_id_<?php echo $labData['Laboratory']['id'];?>" value="<?php echo __('Laboratory');?>">
						</span>
						</li>
						<?php }
}
else if($orderCategory['OrderCategory']['order_alias']=='rad')
{
	foreach($radData as $radData){?>
					<li class="last serviecSelectableInput"><span class="orderSelectable" id="<?php echo preg_replace('/[^a-z\d ]/i', '', $radData["Radiology"]["name"]);?>_serviecSelectable_<?php echo preg_replace('/[^a-z\d ]/i', '', $radData["Radiology"]["name"]);?>"><?php echo $radData["Radiology"]['name'];?>
						<input type="hidden" id="OrderCategory_id_<?php echo $orderCategory['OrderCategory']['id'];?>" value="<?php echo $orderCategory['OrderCategory']['id'];?>">
						<input type="hidden" id="OrderDataMaster_id_<?php echo $radData["Radiology"]['id'];?>" value="<?php echo $radData["Radiology"]['id'];?>">
						<input type="hidden" id="serviecSelectable__name_<?php echo $radData["Radiology"]['name'];?>" value="<?php echo $radData["Radiology"]['name'];?>">
						<input type="hidden" id="serviecSelectable__order_alias_<?php echo $orderCategory['OrderCategory']['order_alias'];?>" value="<?php echo $orderCategory['OrderCategory']['order_alias'];?>">
						<input type="hidden" id="serviecSelectable__Radiology_order_id_<?php echo $radData['Radiology']['id'];?>" value="<?php echo __('Radiology');?>">
					</span>
					</li>
					<?php }
}
else
{
		foreach($orderCategory['OrderDataMaster'] as $orderData){?>
				<li class="last serviecSelectableInput"><span class="orderSelectable" id="<?php echo preg_replace('/[^a-z\d ]/i', '', $orderData["name"]);?>_serviecSelectable_<?php echo preg_replace('/[^a-z\d ]/i', '', $orderData["name"]);?>"><?php echo $orderData['name'];?>
				<input type="hidden" id="OrderCategory_id_<?php echo $orderCategory['OrderCategory']['id'];?>" value="<?php echo $orderCategory['OrderCategory']['id'];?>">
				<input type="hidden" id="OrderDataMaster_id_<?php echo $orderData['id'];?>" value="<?php echo $orderData['id'];?>">
				<input type="hidden" id="serviecSelectable__name_<?php echo $orderData['name'];?>" value="<?php echo $orderData['name'];?>">
				<input type="hidden" id="serviecSelectable__order_alias_<?php echo $orderCategory['OrderCategory']['order_alias'];?>" value="<?php echo $orderCategory['OrderCategory']['order_alias'];?>">
				
				</span>
				</li>
				<?php }}?>
			</ul>
			
		
<?php 
	$lastOrderCategory = $orderCategory['OrderCategory']['order_description'];
} ?>		
		
	</ul>
</div>
<div id="cllickedFolder" class="cllickedFolder"></div>
		</td>
		<td valign="top" class="middleOrderArea"><div>&nbsp;</div></td>
		<td valign="top" class="orderArea"><div>&nbsp;</div></td>
		
</tr>
</table>
</td>
</tr>
<tr><td colspan="3" style="padding-top:10px;padding-right:50px;" align="right"><?php echo $this->Html->link(__('Done'),'javascript:void(0)',array('id'=>'done','class'=>'blueBtn','div'=>false,'label'=>false));?></td></tr>
</table>
<div>
<?php echo $this->Form->create('tests',array('controller'=>'MultipleOrderSets','action'=>'saveOrderSentence','type' => 'file','id'=>'saveOrderSentence','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<div id="finalOrderSet" class="finalOrderSet">
<input type="hidden" name="from" value="from" id="from">
</div>
<?php echo $this->Form->end();?>
</div>
</div>
<script>
var patientId = "<?php echo $patientId; ?>";
var timeoutReference = '';
var orderSubCategory = '';
var lastUniqueMasterOrderId = '';
var lastSelectedObj = '';
var lastSelectedFolderId = '';
var OrderSentenceajaxData = '';
var lastOrderCategoryId = 0;
var lastOrderDataMasterId = 0;
var lastClickedFolder = '';
var independentCounter = 0;
var lastSelectedOrderSentenceName = lastSelectedOrderName = '';
var orderSentenceUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "getOrderSentence","admin" => false)); ?>" ;
var selectOrderSentenceUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "selectOrderSentence","admin" => false)); ?>" ;
//var saveOrderSentenceUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "saveOrderSentence","admin" => false)); ?>" ;
var saveOrderSentenceUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "ordersentence","admin" => false)); ?>" ;
var orderSetUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "getCustomOrderSet","admin" => false)); ?>" ;
var getPackageUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "getPackage","admin" => false)); ?>" ;
var getSearchUrl = "<?php echo $this->Html->url(array("controller" => 'MultipleOrderSets', "action" => "serachOrderSet","admin" => false)); ?>" ;
var chosenOrderSentenceId = 'none';
var counter = 0;
var selectedOrderSets = new Array();
var selectedMasterDataIds = new Array();
var selectedOrderSetsNew = new Array();
var lastModelName = '';
var primaryId = '';
var customModelName = '';
var laboratoryCategoryId = "<?php echo $laboratory_category_id?>";
var radiologyCategoryId = "<?php echo $radiology_category_id?>";
var medicationCategoryId = "<?php echo $medication_category_id?>";
var lastSearchedRecords = lastSelectedTermOrderSet = '';
var medicationType = '';
var noteId =  '<?php echo $_SESSION['noteId']?>';
$( document ).ready(function() {
	lastClickedFolder = 'All';
	$( "#search_within" ).trigger( "change" );
	
});

$("#lookup" ).click(function() {
	if((lastSearchedRecords != '') && (lastSearchedRecords !== undefined) && (lastSelectedTermOrderSet != '') && (lastSelectedTermOrderSet !== undefined)){
		createUL(lastSearchedRecords,1,lastSelectedTermOrderSet);
	}
});


$( "#up" ).click(function() {
	$("#cllickedFolder ul").remove();
	$(".innerOrderSet").hide();
	$("#browser").show();
	
});

$( "#home" ).click(function() {
	$("#IconHub").find('td').removeClass('highlightIcon');
	$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
	$(this).parent().addClass('highlightIcon');
	lastClickedFolder = 'home';
	$("#search_within").val('home');
	$("#currentFolder").html('Home');
	getOrderSets('home');
	
});
$( "#folder" ).click(function() {
	$("#IconHub").find('td').removeClass('highlightIcon');
	$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
	$(this).parent().addClass('highlightIcon');
	lastClickedFolder = 'folder';
	$("#search_within").val('common');
	$("#currentFolder").html('Common');
	getOrderSets('common');
	
	
});
$( "#arrow" ).click(function() {
	$("#IconHub").find('td').removeClass('highlightIcon');
	$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
	$(this).parent().addClass('highlightIcon');
	lastClickedFolder = 'arrow';
	//$("#search_within").val('arrow');
	getOrderSets('');
});

$( "#favourite" ).click(function() {
	$("#IconHub").find('td').removeClass('highlightIcon');
	$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
	$(this).parent().addClass('highlightIcon');
	lastClickedFolder = 'favourite';
	$("#search_within").val('favourite');
	$("#currentFolder").html('Favourite');
	getOrderSets('favourite');
	
});

$("#search_within").change(function() {
	lastClickedFolder = $(this).val();
	if(lastClickedFolder == 'common'){
		$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
		$("#folder").addClass('highlightIcon');
		$( "#folder" ).trigger( "click" );
	}else
	if(lastClickedFolder == 'All'){
		$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
		$("#IconHub").find('td').removeClass('highlightIcon');
		$("#currentFolder").html('');
	}else if(lastClickedFolder == 'home'){
		$( "#home" ).trigger( "click" );
		$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
		$("#"+lastClickedFolder).addClass('highlightIcon');
	}else if(lastClickedFolder == 'favourite'){
		$( "#favourite" ).trigger( "click" );
		$("#folder,#common,#arrow,#favourite,#home").removeClass('highlightIcon');
		$("#"+lastClickedFolder).addClass('highlightIcon');
	}
	
});

$(".collapsable").live('click', function() {

	var selectedFolder =  $(this).find('>span').attr('id');
	var name = lastSelectedFolderId =$(this).find('ul:first').attr('id');
	
	var html = $("#"+name).html();
	//html = html.replace("_serviecSelectable_Test_","_serviecSelectable_Test_New_");
	html = html.replace(/serviecSelectable/g, 'serviecSelectable_SelectEle');
	$("#cllickedFolder").append('<ul id="'+name+'_new" class="innerOrderSet">'+html+'</ul>');
	
	$("#cllickedFolder").find('span').each(function(index) {
		this.id = this.id.replace(/\W+/g,"");
		//this.id = this.id.replace(/[()]/g,'');
		
	});
	$("#browser").hide();
	$(".innerOrderSet").show();
	highlightSelectedOrders('searchEnter');
});

$(".orderSelectable").live('click', function() {
	var name=$(this).find('input:hidden').eq(1).val();
	var id = $(this).find('input:hidden').eq(1).attr('id');
	lastOrderDataMasterId = $(this).find('input:hidden').eq(1).val();
	lastOrderCategoryId = $(this).find('input:hidden').eq(0).val();
	lastSelectedOrderName = $(this).find('input:hidden').eq(2).val();
	lastOrderAlias = $(this).find('input:hidden').eq(3).val();
	customModelName = $(this).find('input:hidden').eq(4).val();
//	patientOrderEnc = $(this).find('input:hidden').eq(5).val();
	var patientOrderEncid = $(this).find('input:hidden').eq(5).val();

	if(lastOrderAlias=='Multiple')
	{
		var redirectUrl="<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "index","","admin" => false,"plugin"=>false)); ?>";	
		parent.location.href=redirectUrl+"/"+patientId+"/"+lastOrderCategoryId;
		parent.$.fancybox.close();
	}
	lastUniqueMasterOrderId = $(this).attr('id');
	lastSelectedObj = this;
	var _this = $(this); // copy of this object for further usage
	//getOrderSentences(id);
	
	openOrderSentenceSelect(lastOrderCategoryId,patientOrderEncid);
});

function getLastOrderSetName(){

	return lastSelectedOrderName;
}

$("#done,#done1").live('click', function() {
	if(httpRequestSaveOrderSet) httpRequestSaveOrderSet.abort();
	var formData = $("#saveOrderSentence").serialize();
	var patientOrderEnId="<?php echo $patientOrderEnc;?>";
	var httpRequestSaveOrderSet = $.ajax({
		  beforeSend: function(){
			  //loading(); // loading screen
		  },
	      url: saveOrderSentenceUrl ,
	      context: document.body,
	      data : formData+"&patientEnId="+patientOrderEnId, 
	      type: "POST",
	      success: function(data){ 
		      if(data == true){
		      	$("#finalOrderSet").html('');
		      	parent.location.reload(true);
		      	parent.$.fancybox.close();
		      }
	    	  //alert(data);
	    	  
	    	 
		  },
		  error:function(){
				alert('Please try again');
				
			  }
	});
});

function showPrevSelectedSets(nameId,orderMasterId,name,orderCategoryId,ModelName,orderAlias){

	$("#cllickedFolder").append($('<ul>').attr('id',nameId + '_'+ orderMasterId + '_new').attr('class','innerOrderSet'));
	var appendName =  name.replace(/\W+/g,"");
	appendName = appendName+'_serviecSelectable_SelectEle_'+appendName;
	appendName = appendName.replace(/\s/g, '_');
	$("#"+ nameId + '_'+ orderMasterId + '_new').append($('<li>').
	        attr('class', 'serviecSelectableInput').append($('<span>').attr('id', appendName)
	        		.attr('class', 'orderSelectable').text(name)
	  .append($('<input>').
	        attr('type', 'hidden').attr('value', orderCategoryId).attr('id', 'OrderCategory_id_'+orderCategoryId))
	  .append($('<input>').
	        attr('type', 'hidden').attr('value', orderMasterId).attr('id', 'OrderDataMaster_id_'+orderMasterId))
	  .append($('<input>').
	        attr('type', 'hidden').attr('value', name).attr('id', 'serviecSelectable__name_'+name.replace(/\s/g, '_')))
	  .append($('<input>').
	        attr('type', 'hidden').attr('value', orderAlias).attr('id', 'serviecSelectable__order_alias_'+name.replace(/\s/g, '_')))
	        ));
}

function createUL(lastSearchedData,checkEnterKey,lastSelectedOrderSetItem){
	var serachedData = lastSearchedData.split("\n");
	serachedData.shift();
	serachedData.pop();
	
	var SelectedItemArr = lastSelectedOrderSetItem.split("    ");
	SelectedItemIdArr = SelectedItemArr[1].split("|");
	primaryId = SelectedItemIdArr[0].split("####");
	if((primaryId[0] !== undefined) && (primaryId.length > 1)){
		SelectedItemIdArr[0] = primaryId[1];
		primaryId = primaryId[0];
	}
	
	
	var reg = '/^[a-zA-Z]+$/';
	var re = new RegExp("[a-zA-Z]+$");
	lastOrderAlias =  SelectedItemIdArr[1].match(re);
			
	$("#cllickedFolder ul").remove();
	var resLength = serachedData.length;
	resLength = resLength;// -1;
	//checkEnterKey 
	if(checkEnterKey == 1){
		for(var i = 0; i< resLength; i++){
			var expArray = serachedData[i].split("    ");
			
			
			if(expArray === undefined) continue;
			if(expArray[1] === undefined) continue;
			
			var idArray = expArray[1].split("|");

			var prid = idArray[0].split("####");
			primaryId = prid;
			if((idArray[1] != '') && (idArray[1] !== undefined)){ 			
				if(idArray[1] == 'Laboratory'){
					if((primaryId[0] !== undefined)  && (primaryId.length > 1)){
						orderMasterId = '';
						orderCategoryId = primaryId[1];
						primaryId = primaryId[0];
					}
				}else if(idArray[1] == 'Radiology'){
					if((primaryId[0] !== undefined)  && (primaryId.length > 1)){
						orderMasterId = '';
						orderCategoryId = primaryId[1];
						primaryId = primaryId[0];
					}
				}else if(idArray[1] == 'PharmacyItem'){
					if((primaryId[0] !== undefined)  && (primaryId.length > 1)){
						orderMasterId = '';
						orderCategoryId = primaryId[1];
						primaryId = primaryId[0];
					}
				}else{
					var orderMasterId = idArray[1].replace ( /[^\d.]/g, '' );
					var orderCategoryId = idArray[0].replace ( /[^\d.]/g, '' );
					lastOrderAlias =  idArray[1].match(re);
				}
			}else{
					var orderMasterId = idArray[1].replace ( /[^\d.]/g, '' );
					var orderCategoryId = idArray[0].replace ( /[^\d.]/g, '' );
					lastOrderAlias =  idArray[1].match(re);
			}
			
			
			
			
			//alert(primaryId+'--'+idArray[1]);
			
			var name = '';
			if(orderMasterId != '0' && orderCategoryId != '0' && expArray[0] !== undefined && expArray[0] != ''){
				var nameId='none';
				if(expArray[0] !== undefined){
					var isFound = expArray[0].indexOf(SelectedItemArr[0]);
					if(isFound != -1){
						if(orderMasterId == ''){ 
							var ModelName = idArray[1];
							lastModelName = ModelName;
						}	
						else {
							ModelName = '';
							lastModelName = ModelName;
						}
						showPrevSelectedSets(nameId,orderMasterId,expArray[0],orderCategoryId,ModelName,lastOrderAlias);
					$("#" + nameId + '_'+ orderMasterId + '_new').show();
					
					independentCounter++;
				}
				$("#browser").hide();
				$(".innerOrderSet").show();
				highlightSelectedOrders('searchEnter');
			}
			
		}
	  }
	}else{
		var orderMasterId = SelectedItemIdArr[1].replace ( /[^\d.]/g, '' );
		var orderCategoryId = SelectedItemIdArr[0].replace ( /[^\d.]/g, '' );
		lastSelectedOrderName = SelectedItemArr[0];
		lastOrderCategoryId = orderCategoryId;
		lastOrderDataMasterId = orderMasterId;
		lastOrderAlias =  SelectedItemIdArr[1].match(re);
		if(orderMasterId != '0' && orderCategoryId != '0' && SelectedItemArr[0] !== undefined && SelectedItemArr[0] != ''){
			var nameId='none';
			if(orderMasterId == ''){
				var ModelName = SelectedItemIdArr[1];
				lastModelName = ModelName;
			}	
			else {
				ModelName = '';
				lastModelName = ModelName;
			}
			showPrevSelectedSets(nameId,orderMasterId,SelectedItemArr[0],orderCategoryId,ModelName,lastOrderAlias);
			$("#" + nameId + '_'+ orderMasterId + '_new').show();
			
			$("#browser").hide();
			$(".innerOrderSet").show();
			highlightSelectedOrders('searchEnter');
		}
		
	}
	independentCounter++;
}

$("#searchKey").autocomplete("<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "serachOrderSet","",'',"",'null',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true,
	valueSelected:true,
	isOrderSet:true,
	showNoId:true,
	max:1000,
    delay:2000,
	extraParams: {
		lastClickedFolder: function() { return lastClickedFolder; }, 
		like: function() { return $("#like").val(); }, 
		location: function() { return $("#at_location").val(); }, 
		 },
	loadId : 'searchKey,searchId',
	onItemSelect:function(event, ui) {
		lastSelectedFolderId = '';
		lastSearchedRecords = lastSearchedData;
		lastSelectedTermOrderSet = lastSelectedOrderSetItem;
		createUL(lastSearchedData,checkEnterKey,lastSelectedOrderSetItem);
		lastSelectedOrderSetItem = '';
		checkEnterKey = 0;
		lastSearchedData = '';
	}
});



/*function openOrderSentenceSelect(id){
	var orderSubCategory = $("#"+id).val();
	$.fancybox({

		'width' : '60%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : selectOrderSentenceUrl + '/' + orderSubCategory
	});
}*/

function chosenOrderSentence(){
	//alert(chosenOrderSentenceId);
}

function buildOrders(){
	if(lastSelectedOrderName == 'none')
		lastSelectedOrderName = '';
	if(lastSelectedOrderSentenceName == 'none')
		lastSelectedOrderSentenceName = '';
	lastOrderDataMasterId = lastOrderDataMasterId.trim();
	
	var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
	
	if(numberRegex.test(lastOrderDataMasterId)) {
		var notNumber = true;
	}else{
		lastOrderDataMasterId = lastModelName; 
		var notNumber = false;
	}
	var isFound = $("#final_"+lastOrderDataMasterId).find('input:hidden').eq(0).val();
	if(isFound === undefined){
		if(lastOrderAlias === undefined){
			lastOrderAlias = '';
		}	
		if(lastOrderDataMasterId == 'Laboratory'){
			var type = 'lab';
			lastOrderCategoryId = laboratoryCategoryId;
		}else
		if(lastOrderDataMasterId == 'Radiology'){
			var type = 'rad';
			lastOrderCategoryId = radiologyCategoryId;
		}else
		if(lastOrderDataMasterId == 'PharmacyItem'){
			var type = 'med';
			lastOrderCategoryId = medicationCategoryId;
		}else
		{
			var type = lastOrderAlias;
		}
		
		
		if(notNumber == true){
			var type = lastOrderAlias;
		}//lastSelectedOrderName
		//if(notNumber === false){
			//lastSelectedOrderName = lastSelectedOrderName+'()';
			//lastOrderDataMasterIdAppend = lastSelectedOrderName.replace(/\(/g, '');
			//lastOrderDataMasterIdAppend = lastSelectedOrderName.replace(/\)/g, '');
			//lastOrderDataMasterIdAppend = lastSelectedOrderName.replace(/[()]/g,'');
			lastOrderDataMasterIdAppend = lastSelectedOrderName.replace(/\W+/g,"");
			lastOrderDataMasterIdAppend = lastOrderDataMasterIdAppend.replace(/\s/g, '_');
			
		//}else{
		//	lastOrderDataMasterIdAppend = lastOrderDataMasterId;
		//}
			
		
		$("#finalOrderSet").append($('<span>').attr('id','final_'+lastOrderDataMasterIdAppend).append($('<input>').
		        attr('type', 'hidden').attr('value', patientId).attr('name', 'PatientOrder['+counter+'][patient_id]'))
		  .append($('<input>').
		        attr('type', 'hidden').attr('value', lastSelectedOrderName).attr('name', 'PatientOrder['+counter+'][name]'))
		  .append($('<input>').
		        attr('type', 'hidden').attr('value', lastSelectedOrderSentenceName).attr('name', 'PatientOrder['+counter+'][sentence]')) 
		  .append($('<input>').
		        attr('type', 'hidden').attr('value', lastOrderCategoryId).attr('name', 'PatientOrder['+counter+'][order_category_id]')) 
		  .append($('<input>').
		        attr('type', 'hidden').attr('value', lastOrderDataMasterId).attr('name', 'PatientOrder['+counter+'][order_data_master_id]'))
		  .append($('<input>').
		        attr('type', 'hidden').attr('value', type).attr('name', 'PatientOrder['+counter+'][type]'))
		  .append($('<input>').
		        attr('type', 'hidden').attr('value', lastOrderAlias).attr('name', 'PatientOrder['+counter+'][lastOrderAlias]'))
		  .append($('<input>').
		        attr('type', 'hidden').attr('value', medicationType).attr('name', 'PatientOrder['+counter+'][review_id]'))
		        );
		
		counter++;
		medicationType = '';
		//$("#cllickedFolder ul").remove();//independentCounter
		if(lastSelectedFolderId == ''){
			
			//for(var i=0; i < independentCounter; i++){
				
				var pushItemName = 'none_' + lastOrderDataMasterId + '_new';
				//selectedOrderSets.push(pushItemName);
				selectedMasterDataIds.push(lastOrderDataMasterId);
				//var pushName = lastSelectedOrderName.replace(/\(/g, '');
				//lastOrderDataMasterIdAppend = lastSelectedOrderName.replace(/[()]/g,'');
				lastOrderDataMasterIdAppend = lastSelectedOrderName.replace(/\W+/g,"");
				lastOrderDataMasterIdAppend = lastOrderDataMasterIdAppend.replace(/\s/g, '_')
				//selectedOrderSetsNew.push();
				selectedOrderSetsNew.push(lastOrderDataMasterIdAppend);
				
			//}
		}else{
			var pushItemName = lastSelectedFolderId +'_new';
			selectedOrderSets.push(pushItemName);
			
			//pushItemName = lastSelectedOrderName.replace(/[()]/g,'');
			pushItemName = lastSelectedOrderName.replace(/\W+/g,"");
			selectedOrderSetsNew.push(pushItemName.replace(/\s/g, '_'));
		}
	}lastOrderDataMasterId = '';
	highlightSelectedOrders('searchEnter');
	
	
}

function highlightSelectedOrders(area){
	/*$.each(selectedOrderSets, function( index, value ) {
		$("#"+ value).find('span:first').addClass('orderHighlight');
	});
	var nameId = 'none';
	
	if(area == 'searchEnter'){
		$.each(selectedMasterDataIds, function( index, value ) {
			//$("#"+ nameId + '_'+ value + '_new').find('span').addClass('orderHighlight');
			var isFound = $("#final_"+value).find('input:hidden').eq(1).val();
			if(isFound !== undefined){
				isFound = isFound.replace(/\s/g, '_') + "_serviecSelectable_"+isFound.replace(/\s/g, '_');
				isFoundSecond = isFound.replace(/\s/g, '_') + "_serviecSelectable_Test_"+isFound.replace(/\s/g, '_');
				$("#"+ isFound).addClass('orderHighlight');
				$("#"+ isFoundSecond).addClass('orderHighlight');
				isFound = undefined;
				isFoundSecond = undefined;
			}
		});
		
		
	}*/
	
	$.each(selectedOrderSetsNew, function( index, value ) {
			//$("#"+ nameId + '_'+ value + '_new').find('span').addClass('orderHighlight');
			var isFoundStat = isFound = $("#final_"+value.replace(/\s/g, '_')).find('input:hidden').eq(1).val();
			if(isFound !== undefined){
				isFound12 = isFoundStat.replace(/\W+/g,"");
				isFound12 = isFound12.replace(/\s/g, '_') + "_serviecSelectable_SelectEle_"+isFound12.replace(/\s/g, '_');
				
				$("#"+ isFound12+":visible").addClass('orderHighlight');
				isFound = undefined;
				isFoundSecond = undefined;
				isFoundStat = undefined;
				isFoundSecondNew = undefined;
			}
		});
	
}

function processOrderSentence(data,id){
	OrderSentenceajaxData = data;
	data = jQuery.parseJSON(data);
	var dataCount = data.count; 
	data = data.orderSentences;
	if(dataCount == 0){
		buildOrders();
	}else if(dataCount > 0){
		openOrderSentenceSelect(id);
	}
}

function getOrderSets(folder){
	$( "#up" ).trigger( "click" );
	if(folder == ''){
		folder = 'none';
	}
	if(httpRequestOrderSet) httpRequestOrderSet.abort();
		var httpRequestOrderSet = $.ajax({
			  beforeSend: function(){
				  //loading(); // loading screen
			  },
		      url: orderSetUrl + "/" + patientId + "/" + folder + "/" + $("#at_location").val(),
		      context: document.body,
		      success: function(data){ 
		    	  $("#customOrderSet").html(data);
		      },
			  error:function(){
					alert('Please try again');
					
				  }
		});
	
		//lastOrderSubCategory = orderSubCategory;
}



function openOrderSentenceSelect(id,patientOrderEncid){
var toCheckExistingSenctence="0";
lastOrderDataMasterId = lastOrderDataMasterId.trim();

var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;

if(numberRegex.test(lastOrderDataMasterId)) {
	var notNumber = true;
}else{
	lastOrderDataMasterId = lastModelName; 
	var notNumber = false;
}

if((customModelName != '') && (customModelName !== undefined)){
	primaryId = lastOrderDataMasterId;
	lastOrderDataMasterId = customModelName;
	
}

if(lastOrderDataMasterId == 'Laboratory'){
	var lonicCode = 'Laboratory';
	var drugCode = false;
	var CodeId = primaryId;
	lastOrderCategoryId = laboratoryCategoryId;
}else
if(lastOrderDataMasterId == 'Radiology'){
		var lonicCode = 'Radiology';
		var drugCode = false;
		var CodeId = primaryId;
		lastOrderCategoryId = radiologyCategoryId;
}else
if(lastOrderDataMasterId == 'PharmacyItem'){
	var drugCode = 'PharmacyItem';
	var lonicCode = false;
	var CodeId = primaryId;
	lastOrderCategoryId = medicationCategoryId;
}else{

	var lonicCode = 'OrderDataMaster';
	var drugCode = null;
	var CodeId = lastOrderDataMasterId;
}
	$
			.fancybox({
			

				'width' : '100%',
				'height' : '100%',
				'autoScale' : true,
				'transitionIn' : 'fade',
				'transitionOut' : 'fade',
				'type' : 'iframe',
				'href' : saveOrderSentenceUrl+"/"+null+"/"+lastOrderCategoryId+"/"+lonicCode+"/"+drugCode+"/"+CodeId+"/"+patientOrderEncid+"/?noteId="+noteId,
				'onComplete' : function () {
					$(window).scrollTop(0);
			    }
				/*ajax: { 
				     //url: saveOrderSentenceUrl+"/"+null+"/"+lastOrderCategoryId+"/"+lonicCode+"/"+drugCode+"/"+CodeId,
				     data:{loincCode:lonicCode,drugCode:drugCode,CodeId:CodeId,OrderName:lastSelectedOrderName,fromPackage:1},
				   //  type:'POST',
				    }*/
				
						
			});
}

function loading(){	
	 $('#mainContentArea').block({ 
        message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Initializing...</h1>', 
        css: {            
            padding: '5px 0px 5px 18px',
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#fffff', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px',               
            color: '#fff',
            'text-align':'left' 
        },
        overlayCSS: { backgroundColor: '#cccccc' } 
    }); 
}

function onCompleteRequest(){
	$('#mainContentArea').unblock(); 
}

$( document ).ajaxStart(function() {
	loading();
});
$( document ).ajaxStop(function() {
	onCompleteRequest();
});

/*function getOrderSentences(id){
	var orderSubCategory = $("#"+id).val();
	if(httpRequest) httpRequest.abort();
	
		var httpRequest = $.ajax({
			  beforeSend: function(){
				  //loading(); // loading screen
			  },
		      url: orderSentenceUrl+"/"+orderSubCategory,
		      context: document.body,
		      success: function(data){ 
		    	  processOrderSentence(data,id)
		      },
			  error:function(){
					alert('Please try again');
					
				  }
		});
	
		lastOrderSubCategory = orderSubCategory;
}*/

</script>