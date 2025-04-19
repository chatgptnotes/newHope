<?php echo $this->Html->script(array('inline_msg','permission','jquery.blockUI','jquery.fancybox'));
echo $this->Html->css(array('jquery.fancybox'));?>
 
<style> 

.ui-menu {
    display: block;
    list-style: outside none none;
    margin: 0;
    max-height: 300px;
    outline: medium none;
    overflow: scroll;
    padding: 2px;
}

</style> 
<div class="inner_title">
	<h3>&nbsp; <?php  echo __('Patient card List'); ?></h3>
	<span style="float:right">
	<?php echo $this->Html->link('Back',array('controller'=>'Users','action'=>'doctor_dashboard'),
				array('class'=> 'blueBtn','id'=>'backToIpd','escape' => false,'label'=>false,'div'=>false));?>
		
	</span>
	<div style="clear: both; padding: 10px 0px 10px 25px">
		<?php echo $this->Form->create('PatientCardList',array('url'=>array('controller'=>'Accounting','action'=>'patient_card_list'),'type'=>'GET'));
			echo '<table> <tr><td>';
			echo $this->Form->input('Patient.name',array('id'=>'patientName','div'=>false,'label'=>false));
			echo '</td>';
		    echo '<td>'.$this->Form->submit('Search',array('class'=>'blueBtn')).'<td>';
		    echo '<td>'.$this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'patient_card_list'),array('escape'=>false)).'</td>';
		    echo '</tr></table>';
		    echo $this->Form->end();
		?>
	</div>
</div>
<table   class="table_format" style="width:1000px;">
	<tr class="row_title">
		<td class="tdLabel">
		<?php echo $this->Paginator->sort('Patient.lookup_name',__("Patient Name",true));?>
		</td>
		<td class="tdLabel">
		<?php echo "Patient UID";?>
		</td>
		<td class="tdLabel">
		<?php echo "Patient Tariff";?>
		</td>
		<td class="tdLabel">
		<?php echo "Card Balance";?>
		</td>
		<td class="tdLabel">
		<?php echo "Add/View";?>
		</td>
	
	</tr>
	<?php if(!empty($patientData)){
			$queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
			$this->Paginator->options(array('url' =>array("?"=>$queryStr)));
			$toggle =0;
			foreach($patientData as $cardDetail){
				if($toggle == 0) {
					echo "<tr class='row_gray light'>";
					$toggle = 1;
				}else{
					echo "<tr class='light'>";
					$toggle = 0;
				}
				echo '<td style="padding-left:25px">'.$cardDetail['Patient']['lookup_name'].'</td>';
				echo '<td style="padding-left:25px">'.$cardDetail['Patient']['patient_id'].'</td>';
				echo '<td style="padding-left:25px">'.$cardDetail['TariffStandard']['name'].'</td>';
				echo '<td style="padding-left:25px">'.$cardDetail['Account']['card_balance'].'</td>';
				echo '<td style="padding-left:25px">'.$this->Html->link($this->Html->image('icons/view-icon.png',array('title'=>'View Card')),'javascript:void(0)',array('id'=>'card_'.$cardDetail['Patient']['id'] ,'class'=>'cardFancy','escape'=>false));
				//if(strtolower($cardDetail['TariffStandard']['name'])=='private')
					echo $this->Html->link($this->Html->image('icons/discount_ico.png',array('title'=>'Discount','width'=>24,'height'=>24)),array('controller'=>'Billings','action'=>'discount_only',$cardDetail['Patient']['id']),array('id'=>'discount_'.$cardDetail['Patient']['id'] ,'class'=>'discountFancy','escape'=>false)).'</td>';
				//else 
					//echo $this->Html->link($this->Html->image('icons/refund.png',array('title'=>'Refund','width'=>24,'height'=>24)),array('controller'=>'Billings','action'=>'discount_only',$cardDetail['Patient']['id']),array('id'=>'discount_'.$cardDetail['Patient']['id'] ,'class'=>'discountFancy','escape'=>false)).'</td>';
				echo '</tr>';
	 	   }
		 ?>
		<tr>
			<TD colspan="8" align="center">
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
			</TD>
		</tr>
	<?php 
	 }		
	?>		
</table>
<script>
$(document).ready(function(){
	$("#patientName").autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Patients", 
				"action" => "admissionComplete","admin" => false,"plugin"=>false)); ?>",
		select: function(event,ui){	
			//$( "#patientId" ).val(ui.item.id);			
	},
	 messages: {
         noResults: '',
         results: function() {},
   },
	
	});
});
//for Patient card-Pooja
$(".cardFancy").click(function(){ 
	 patientID=$(this).attr('id').split('_')[1];
	 $.fancybox({ 
		    'autoDimensions':false,
	    	'width'    : '85%',
		    'height'   : '90%',
		    'autoScale': true,
		  	'transitionIn': 'fade',
		    'transitionOut': 'fade', 
		    'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200,				    
		    'type': 'iframe',
		    'helpers'   : { 
		    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
		    },
		    'afterClose'  : function() { 
	            window.location.reload();
	        },
			'href' : "<?php echo $this->Html->url(array("controller" =>"Accounting","action" =>"patient_card","admin"=>false)); ?>"+'/'+patientID,
	 });
	 $(document).scrollTop(0);
});


	</script>