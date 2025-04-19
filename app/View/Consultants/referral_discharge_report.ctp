<?php
	echo $this->Html->script(array('jquery.autocomplete','jquery.autocomplete.js','topheaderfreeze'));   
	echo $this->Html->css('jquery.autocomplete.css');

?>


<style>
body{
font-size:13px;
}
.red td{
	background-color:antiquewhite !important;
}
.idSelectable:hover{
		cursor: pointer;
		}
.tabularForm {
    background:#d2ebf2 !important;
	}
	.tabularForm td {
		 background: #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
#msg {
    width: 180px;
    margin-left: 34%;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Referral Discharge Report', true); ?>
	</h3>
	<span>
		<?php echo $this->Html->link(__('Back to Report'), array('controller'=>'Reports','action' => 'admin_all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
	</span>
</div> 
<?php echo $this->Form->create('ReferralDischarge',array('id'=>'voucher','type'=>'GET','url'=>array('controller'=>'Consultants','action'=>'referralDischargeReport','admin'=>false)));?>

		<table align="center" style="margin-top: 10px">
			<tr>

	            <td class="tdLabel" id="boxSpace"><?php echo __('District');?></td>
	            <td><?php echo $this->Form->input('district', array('class' => 'validate[optional,custom[onlyLetterNumber]] textBoxExpnd','id' => 'district','label'=>false)); ?></td>

	            <td class="tdLabel" id="boxSpace"><?php echo __('Corporate');?></td>
	            <td><?php echo $this->Form->input('tariff_standard_id',array('empty'=>'Please Select','options'=>$tariffList,
                                                        'class'=>'textBoxExpnd ','label'=>false)); ?></td>

                <td class="tdLabel" id="boxSpace"><?php echo __('Type');?></td>
	            <td><?php echo $this->Form->input('is_discharge',array('empty'=>'All','options'=>array('Non Discharged'=>'Non Discharged','Discharged'=>'Discharged'), 'class'=>'textBoxExpnd ','label'=>false)); ?></td>

			<?php 
				$monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                                        '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
                 	for($i=2010;$i<=date('Y')+5;$i++){
            			$yearArray[$i] = $i; 
            		}
            ?>
                <td align="center"><?php echo "Month";?></td>
                <td align="center">
                	<?php echo $this->Form->input('month',array('empty'=>'Please Select','options'=>$monthArray,
                                                        'class'=>'textBoxExpnd ','label'=>false,'default'=>date('m'))); ?>
                </td>
                <td align="center"><?php echo "Year"; ?></td>
                <td align="center">
                	<?php echo $this->Form->input('year',array('empty'=>'Please Select','options'=>$yearArray,
                                                        'class'=>'textBoxExpnd ','label'=>false,'default'=>date('Y')));?>
                </td>
				<td>
					<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false));?>
				</td>
				<td>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'referralDischargeReport'),array('escape'=>false));?>
				</td>
				<?php if($this->params->query){
						$qryStr=$this->params->query;
						}?>
				<td><?php echo $this->Html->link($this->Html->image('icons/excel.png'),array('controller'=>'Consultants','action'=>'referralDischargeReport','excel','?'=>$qryStr,'admin'=>false,'alt'=>'Export To Excel'),array('escape'=>false,'title' => 'Export To Excel'))?></td>
			</tr>
		</table>
	  
			<?php echo $this->Form->end();?>

			<table width="100%" cellpadding="0" cellspacing="1" border="0" 	class="tabularForm" id="container-table">
				<thead>
					<tr> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Patient Name');?></th> 
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Date Of Discharge');?></th> 
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Follow Up');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Diagnosis');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('City');?></th> 
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Corporate');?></th> 
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Treating Consultant');?></th>
						<th width="15%" align="center" valign="top" style="text-align: center;"><?php echo __('Referring Consultant');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Total Bill Paid');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Spot Amount');?></th>
						<th width="8%" align="center" valign="top" style="text-align: center;"><?php echo __('Backing Amount');?></th>
					</tr> 
				</thead>
				
				<tbody>
				<?php foreach($dischargeReferral as $key=> $value) { ?>
					<tr>
					
						<td align="left" style= "text-align: center;">
							<?php echo $value['Patient']['lookup_name'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
						  
						   <?php echo $this->DateFormat->formatDate2Local($value['Patient']['discharge_date'],Configure::read('date_format'),false); ?>
						</td>
						<td align="left" style= "text-align: center;">
						  
						   <?php echo $this->DateFormat->formatDate2Local($value['DischargeSummary']['review_on'],Configure::read('date_format'),false); ?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['DischargeSummary']['final_diagnosis'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['Person']['district'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['TariffStandard']['name'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['User']['first_name']." ".$value['User']['last_name'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php  $reffList = unserialize($value['Patient']['consultant_id']) ;
							    foreach ($reffList as $key => $reffData) {
							        echo $referralList[$reffData]."<br>";
							    }

							?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['FinalBilling']['amount_paid'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['Patient']['spot_amount'] ;?>
						</td>
						<td align="left" style= "text-align: center;">
							<?php echo $value['Patient']['b_amount'] ;?>
						</td>
						
				  	</tr>
			  	<?php }?>
					
				</tbody>
		
			</table>


<script type="text/javascript">

      
      $('#district').autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","District","name",'null',"no","no","admin" => false,"plugin"=>false)); ?>", {
				width: 250,
				 selectFirst: true
			});

$(document).ready(function(){
	
 	$("#container-table").freezeHeader({ 'height': '500px' });
});

</script>