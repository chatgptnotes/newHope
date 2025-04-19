 
<style>
	body{
		font-size:13px;
	}
	.tabularForm {
	    background: none repeat scroll 0 0 #d2ebf2 !important;
	}
	.tabularForm td {
	    background: none repeat scroll 0 0 #fff !important;
	    color: #000 !important;
	    font-size: 13px;
	    padding: 3px 8px;
	}
</style> 

<script>
	jQuery(document).ready(function(){ 
		jQuery("#StockRegister").validationEngine();
	});	
</script>

<?php echo $this->Form->create('',array('id'=>'content-form','type'=>'GET','id'=>'StockRegister'));?>

<div class="inner_title">
<?php echo $this->element('navigation_menu',array('pageAction'=>'Store')); ?>
<h3>&nbsp; <?php echo __('Opening Closing Stock', true); ?></h3> 
</div>

 			<div class="clr ht5"></div>
			<table width="" cellpadding="0" cellspacing="" border="0" align="center">
				<tr>  
					<td>From : </td>
					<td>
						<?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",'value'=>!empty($this->params->data['dateFrom'])?$this->params->data['dateFrom']:date("d/m/Y"),
							'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));
						?>
			 		</td>
			 		<td>&nbsp;</td>
			 		<td>To : </td>
					 <td>				
						<?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",'value'=>!empty($this->params->data['dateTo'])?$this->params->data['dateTo']:date("d/m/Y"),
							'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));
						?>
					</td>  
					<td>&nbsp;</td>
					<!-- <td>Product : </td>
				 	<td>				
						<?php echo $this->Form->input('product_name',array('type'=>'text','class'=>'textBoxExpnd','id'=>"product_name",'value'=>$this->params->data['product_name'],
											'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'product_name'));
						echo $this->Form->hidden('product_id',array('value'=>$this->params->data['product_id'],))
						?>
					</td>    -->
					<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false,'onclick'=>"$('#busy-indicator').show();")); ?></td>
					<td>&nbsp;</td>
					<td>
						<?php 

						/*echo $this->Html->link(__('Generate Excel'),'javascript:void(0);',array('style'=>'padding:0px;','name'=>'excel','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false,'onclick'=>"$('#busy-indicator').show();"));*/
						echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','name'=>'excel','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false,'onclick'=>"$('#busy-indicator').show();")); ?> 
					</td>
					<td>&nbsp;</td>
					<td>
					<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Reports','action'=>'openingClosingStock'),array('escape'=>false, 'title' => 'refresh'));?>
				</td>
				</tr>
			</table>
				<div class="clr ht5"></div> 
			<table  width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm">
				<thead>
					<tr >
						<th width="" valign="middle" align="center" style="text-align:center;">SNo.</th>
						<th width="" valign="middle" align="center" style="text-align:left;">Item Name</th>
						<th width="" valign="middle" align="center" style="text-align:center;">Opening Stock</th> 
						<th width="" valign="middle" align="center" style="text-align:center;">Closing Stock</th> 
					</tr>
				</thead>
				<?php
					$i=0; 
					if(!empty($results)){
						$srno=$this->params->paging['PharmacyItem']['limit']*($this->params->paging['PharmacyItem']['page']-1);
						foreach ($results as $records){
							$srno++;
							$i++;
				?>
				<tr>
					<td style="text-align:center"><?php echo $srno;?></td> 
					<td style="text-align:left"><?php echo $records['PharmacyItem']['name'];?></td>
					<td style="text-align:center"><?php echo $records['opening'];?></td>
					<td style="text-align:center"><?php echo $records['closing'];?></td> 
				</tr>
				<?php } }else{  ?>
				<tr>
					<td colspan="4" style="text-align:center"><strong>No result found..!!</strong></td>
				</tr>
				<?php } ?>
			</table>
			<table width="100%">
				<tr>
					<td colspan="4" align="center">
						<?php $queryStr = $this->General->removePaginatorSortArg($this->params->query) ;  //for sort column
							  $this->Paginator->options(array('url' =>array("?"=>$queryStr))); 
						?>
						<?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
			     		<?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
			    		<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
			     		<span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
					</td>
				</tr>
			</table> 
<?php $this->Form->end(); ?>

<script>

$(document).ready(function(){		
	 
	$("#dateFrom").datepicker
	({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy',			
		});	
			
	 $("#dateTo").datepicker
	 ({
			showOn: "both",
			buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
			buttonImageOnly: true,
			changeMonth: true,
			changeYear: true,
			yearRange: '1950',
			maxDate: new Date(),
			dateFormat: 'dd/mm/yy',			
		});  
});			


(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here
                    "regex": "none",
                    "alertText":"Product name is required to search.", 
                },
            };

        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

/*$("#ExcelGenerate").click(function(){
	$.ajax({
		url: "<?php echo $this->Html->url(array('action'=>'')); ?>";
	});
});*/
</script>



