<?php // debug(unserialize($observation));?>
<?php echo $this->Form->hidden('ImmunoHistoChemistry.flag123',array(
							'name'=>'data[ImmunoHistoChemistry][flag]',
							'id'=>'ImmunoHistoChemistry_flag','value'=>$id,
							'type'=>'text','div'=>false,'label'=>false,'style'=>'width:400px;height:20px;',
					)); ?>
<style>
td {
    height: 20px;
     
}
</style>
<?php 

	$unserializeObservation = unserialize($observation);
	$readonly = 'readonly';
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="formFull" align="center" style="padding: 5px; margin-top: 5px">
<?php if($getPanelSubLab[0]['Laboratory']['name'] ==  Configure::read('IHC')){?>
	<tr>
		<td colspan="5"><u><b><?php echo "ER and PR Report";?></b></u></td>
	</tr>

<?php }else{?>
	<tr>
		<td colspan="5"><u><b><?php echo "Her-2-Neu report";?></b></u></td>
	</tr>
<?php }?>
	<tr>
		<td><?php echo $this->Form->input('text',array('type'=>'text','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('Result',array('type'=>'text','value'=>'Result(*)','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('Intensity',array('type'=>'text','value'=>'Intensity of stain','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('Positive',array('type'=>'text','value'=>'Positive cell %','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('TotalH',array('type'=>'text','value'=>'Total H socre(*)','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('EstrogenReceptor',array('type'=>'text','value'=>'Estrogen receptor','name' => "data[LaboratoryParameter][$id][EstrogenReceptor]",'readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('result_er',array('type'=>'text','value'=>$unserializeObservation['EstrogenReceptor']['result'],'name' => "data[LaboratoryParameter][$id][EstrogenReceptor][result]"));?>
		</td>
		<td><?php echo $this->Form->input('intensity_er',array('id'=>'intensity_er','type'=>'text','value'=>$unserializeObservation['EstrogenReceptor']['intensity'],'name' => "data[LaboratoryParameter][$id][EstrogenReceptor][intensity]",'autocomplete'=>'off'));?>
		</td>
		<td><?php echo $this->Form->input('positive_er',array('id'=>'positive_er','type'=>'text','value'=>$unserializeObservation['EstrogenReceptor']['positive'],'name' => "data[LaboratoryParameter][$id][EstrogenReceptor][positive]",'autocomplete' => 'off' ));?>
		</td>
		<td><?php echo $this->Form->input('total_er',array('id'=>'output_er','type'=>'text','value'=>$unserializeObservation['EstrogenReceptor']['total'],'name' => "data[LaboratoryParameter][$id][EstrogenReceptor][total]",'readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('ProgesteroneReceptor',array('type'=>'text','value'=>'Progesterone receptor','name' => "data[LaboratoryParameter][$id][ProgesteroneReceptor]",'readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('result_pr',array('type'=>'text','value'=>$unserializeObservation['ProgesteroneReceptor']['result'],'name' => "data[LaboratoryParameter][$id][ProgesteroneReceptor][result]"));?>
		</td>
		<td><?php echo $this->Form->input('intensity_pr',array('id'=>'intensity_pr','type'=>'text','value'=>$unserializeObservation['ProgesteroneReceptor']['intensity'],'name' => "data[LaboratoryParameter][$id][ProgesteroneReceptor][intensity]",'autocomplete' => 'off'));?>
		</td>
		<td><?php echo $this->Form->input('positive_pr',array('id'=>'positive_pr','type'=>'text','value'=>$unserializeObservation['ProgesteroneReceptor']['positive'],'name' => "data[LaboratoryParameter][$id][ProgesteroneReceptor][positive]",'autocomplete' => 'off'));?>
		</td>
		<td><?php echo $this->Form->input('total_pr',array('id'=>'output_pr','type'=>'text','value'=>$unserializeObservation['ProgesteroneReceptor']['total'],'name' => "data[LaboratoryParameter][$id][ProgesteroneReceptor][total]",'readonly'=>$readonly));?>
		</td>
	</tr>
<?php if($getPanelSubLab[0]['Laboratory']['name'] ==  Configure::read('IHC')){?>
	<tr>
		<td colspan="5"><u><b><?php echo "(*) Guideline for Interpretation of H Score (for ER & PR): ";?></b></u></td>
	</tr>
	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Staining intensity of nuclei','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Score','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Percentage cells','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Total H score','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'No staining','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'0','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'N %','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Weak','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'1+','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'N %','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Moderate','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'2+','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'N %','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Strong','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'3+','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'N %','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'','readonly'=>$readonly));?>
		</td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="5"><u><b><?php echo "(#) Her-2-Neu reporting guideline by CAP: ";?></b></u></td>
	</tr>
	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Staining pattern','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'% of invasive tumor cells','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Score','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Result','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'No staining ','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'0','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Negative','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Staining present','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'<10%','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'0','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Negative','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Faint/barely perceptive incomplete membrane staining','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'>10%','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'1+','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Negative','readonly'=>$readonly));?>
		</td>
	</tr>

	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Weak to moderate complete membrane staining','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'>10%','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'2+','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Equivocal','readonly'=>$readonly));?>
		</td>
	</tr>
	
	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Strong complete membrane staining','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'<30%','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'2+','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Equivocal','readonly'=>$readonly));?>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Strong complete membrane staining','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'>30%','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'3+','readonly'=>$readonly));?>
		</td>
		<td><?php echo $this->Form->input('',array('type'=>'text','value'=>'Positive','readonly'=>$readonly));?>
		</td>
	</tr>

	<?php }?>
</table>


<!--Her-2  -->
 
 
