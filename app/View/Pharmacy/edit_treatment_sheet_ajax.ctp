<?php echo $this->Form->create('',array('url'=>array('action'=>'updateTreatmentSheet',$patientId,$date))); ?>
<table class="tabularForm">
	<thead>
		<tr>
			<td align="left" width=""><?php echo __("#"); ?></td>
			<td align="left" width=""><?php echo __("Drug Name"); ?><font color="red">*</font></td>
			<td align="center" width=""><?php echo __("Dosage"); ?></td> 
			<td align="center" width=""><?php echo __("Route"); ?></td> 
		</tr>
	</thead>
	<tbody id="prescribeTable">
            <?php foreach ($results as $key => $val){ ?>
            <tr>
                <td><?php echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'label'=>false,'name'=>"data[TreatmentMedicationDetail][$key][is_show]",'title'=>'check to show in treatment sheet','hiddenField'=>false,'value'=>$isShow = $val['TreatmentMedicationDetail']['is_show'],'checked'=>$isShow=='1'?'checked':'','onclick'=>"if(this.checked){ $(this).val(1); }else{ $(this).val(0); }")); ?></td>
                <td><?php echo $this->Form->hidden('',array('value'=>$val['TreatmentMedicationDetail']['id'],'name'=>"data[TreatmentMedicationDetail][$key][id]")); echo $val['PharmacyItem']['name'];  ?>
                <td><?php echo $this->Form->input('',array('type'=>'text','div'=>false,'label'=>false,'class'=>'routes','id'=>'routes_1','name'=>"data[TreatmentMedicationDetail][$key][routes]",'value'=>$val['TreatmentMedicationDetail']['routes'])); ?></td> 
                <td><?php echo $this->Form->input('',array('type'=>'select','div'=>false,'label'=>false,'class'=>'dosage','id'=>'dosage_1','name'=>"data[TreatmentMedicationDetail][$key][dosage]",'style'=>'','empty'=>'Select','options'=>Configure :: read('route_administration'),'value'=>$val['TreatmentMedicationDetail']['dosage'])); ?></td>  
            </tr>
            <?php } ?>
	</tbody> 
	<tbody>
            <tr>
                <td colspan="4" align="left"> 
                    <div style="float: right;"><input type="submit" id="submitBtn" value="Submit" onclick="blurElement('#content-list',1);">&nbsp;<input type="button" id="addButton" value="Cancel" onclick="blurElement('#content-list',1); parent.window.location.reload();"></div>
                </td> 
            </tr>
	</tbody>
</table>
<?php echo $this->Form->end(); ?> 
               