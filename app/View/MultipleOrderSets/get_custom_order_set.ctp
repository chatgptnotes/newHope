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
}else{
		 foreach($orderCategory['OrderDataMaster'] as $orderData) {?>
		
				<li class="last serviecSelectableInput"><span class="orderSelectable" id="<?php echo preg_replace('/[^a-z\d ]/i', '', $orderData["name"]);?>_serviecSelectable_<?php echo preg_replace('/[^a-z\d ]/i', '', $orderData["name"]);?>"><?php echo $orderData['name'];?>
				<input type="hidden" id="OrderCategory_id_<?php echo $orderCategory['OrderCategory']['id'];?>" value="<?php echo $orderCategory['OrderCategory']['id'];?>">
				<input type="hidden" id="OrderDataMaster_id_<?php echo $orderData['id'];?>" value="<?php echo $orderData['id'];?>">
				<input type="hidden" id="serviecSelectable__name_<?php echo $orderData['name'];?>" value="<?php echo $orderData['name'];?>">
				<input type="hidden" id="serviecSelectable__order_alias_<?php echo $orderCategory['OrderCategory']['order_alias'];?>" value="<?php echo $orderCategory['OrderCategory']['order_alias'];?>">
				</span>
				</li>
			
<?php 
}
}

?>
</ul>
<?php
	$lastOrderCategory = $orderCategory['OrderCategory']['order_description'];
} ?>		
		
	</ul>