<?php 
  echo $this->Html->script(array('jquery.fancybox-1.3.4'));//jquery-1.9.1.js
  echo $this->Html->css(array('jquery.fancybox-1.3.4.css'));//,'internal_style.css'
 ?>
<style>
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
	background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    padding: 3px 8px;
}
.subHead{
	display:none;
}
.headRow{
	cursor:pointer;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Marketing Team Collection Report', true); ?>
	</h3>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('SpotBacking',array('id'=>'SpotBacking','url'=>array('controller'=>'Accounting','action'=>'teamWiseCollectionReport','admin'=>false)));?>
<table border="0" cellpadding="2" cellspacing="0" align="center">
	<tbody>
		<tr class="row_title">
			<?php 
				$monthArray = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                                        '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
                 	for($i=2010;$i<=date('Y')+5;$i++){
            			$yearArray[$i] = $i; 
            		}
            ?>
            <td align="center"><?php echo "Month";?></td>
            <td align="center">
            	<?php echo $this->Form->input('month',array('empty'=>'Please Select','options'=>$monthArray,'class'=>'textBoxExpnd ','label'=>false,'default'=>date('m'))); ?>
            </td>
            <td align="center"><?php echo "Year"; ?></td>
            <td align="center">
            	<?php echo $this->Form->input('year',array('empty'=>'Please Select','options'=>$yearArray,'class'=>'textBoxExpnd ','label'=>false,'default'=>date('Y')));?>
            </td>
			<td>
				<?php echo $this->Form->submit('Search',array('class'=>'blueBtn','label'=> false, 'div' => false,'id'=>'search'));?>
			</td>
			<td>
				<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'teamWiseCollectionReport'),array('escape'=>false));?>	
			</td>
		</tr>
	</tbody>
</table>
<?php  echo $this->Form->end();?>
<div class="clr inner_title" style="text-align: right;"></div>

<table width="50%" cellpadding="0" cellspacing="1" border="0" class="tabularForm" style="text-align : center;" align="center">
	<tr> 
		<th style="text-align : left;"><?php echo __("Marketing Team");?></th>
		<th style="text-align : right;"><?php echo __("Total Collection");?></th>
	</tr>
	<?php foreach($teamData as $teamKey=>$data){ ?>
	<tr id="<?php echo $teamKey; ?>" class="idSelectable">
	<input type="hidden" id="start_transaction_id_<?php echo $teamKey; ?>" value="<?php echo $date?>">
		<td style="text-align : left;"><?php echo $teamKey; ?></td>
		<td style="text-align : right;"><?php echo $data;
		$totalAmount += $data; ?></td>
	</tr>
	<?php } ?>
	<tr> 
		<td style="text-align : left;"><font color="red"><b><?php echo __("Total");?></b></font></td>
		<td style="text-align : right;"><font color="red"><b><?php echo $totalAmount; ?></b></font></td>
	</tr>
</table>
<script>
var getTeamPatientURL = "<?php echo $this->Html->url(array("controller"=>'Accounting',"action"=>"getTeamWisePatientData","admin"=>false)); ?>" ;

$(".idSelectable").click(function() {
	team = $(this).attr('id');
	var spot_date = $(this).find('input').val();
	var tran_date = spot_date.split("/");
	$.fancybox({
		'width' : '60%',
		'height' : '80%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : getTeamPatientURL + '/' + tran_date + '/' + team
	});
});
</script>