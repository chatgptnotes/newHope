<?php
	echo $this->Html->script(array('inline_msg','jquery.selection.js','jquery.fancybox-1.3.4'  ,'jquery.blockUI','jquery.contextMenu'));
?>



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
<?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
<h3>&nbsp; <?php echo __('Stock Register', true); ?></h3>
	 <span align="right" >
	 	
	</span>
</div>
 	<div class="clr ht5"></div>
			<table cellpadding="0" cellspacing="" border="0" align="center">
				<tr> 
					<!-- <td><?php echo __(" Department : "); ?></td>
					<td>
		 				<?php echo $this->Form->input('',array('type'=>'select','name'=>'department','value'=>$this->params->query['department'],'options'=>$department,'id'=>'department','class'=>'textBoxExpnd', 'label'=> false,'div' => false,)); ?>
		 			</td>
		 			<td>&nbsp;</td> 
		 			<td><?php echo __(" From : "); ?></td>-->
					<td>
						<?php echo $this->Form->input('dateFrom',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateFrom",'value'=>$this->params->data['dateFrom'],
															'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateFrom','placeholder'=>'Date From'));
						?>
			 		</td>
			 		<td>&nbsp;</td>
		 			<!-- <td><?php echo __(" To : "); ?></td> -->
					 <td>				
						<?php echo $this->Form->input('dateTo',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"dateTo",'value'=>$this->params->data['dateTo'],
											'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'dateTo','placeholder'=>'Date To'));
						?>
					</td>   
					<td>&nbsp;</td>
		 			
					<td><?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false)); ?></td>
					<td>&nbsp;</td>
					<td>
						<?php echo $this->Form->submit(__('Generate Excel'),array('style'=>'padding:0px;','name'=>'excel','class'=>'blueBtn','id'=>'ExcelGenerate','div'=>false,'label'=>false)); ?> 
					</td>
					<td>&nbsp;</td>
					<td>
						<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'all_stock_report'),array('escape'=>false, 'title' => 'refresh'));?>
					</td>
				</tr>
			</table> 
				<div class="clr ht5"></div>
			<table width="100%" cellpadding="0" cellspacing="0" border="" class="tabularForm">
				<thead>
					<tr>
						<!-- <th width="" valign="middle" align="center" style="text-align:center;">SNo.</th> -->
						<th width="" valign="middle" align="center" style="text-align:center;">Item Name</th>
						<th width="" valign="middle" align="center" style="text-align:center;">Opening Stock</th>
						<th width="" valign="middle" align="center" style="text-align:center;">Closing Stock</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$i = 0; 
					if (!empty($record)) {
						foreach ($record as $records) { 
							$i++;
							if ($records['name']) { 
								if (empty($records['opening_stock'])) {
									$records['opening_stock'] = 0;
								}
								if (empty($records['closing_stock'])) {
									$records['closing_stock'] = 0;
								}
				?>
				<tr>
					<!--<td><?php echo $i;?></td>-->
					<td><?php echo $records['name']; ?></td> 
					<td style="text-align:center"><?php echo $records['opening_stock']<0?0:$records['opening_stock'];?></td>
					<td style="text-align:center"><?php echo $records['closing_stock']<0?0:$records['closing_stock'];?></td>
				</tr>
				<?php 		}// END of systemn= added
				} }else{  ?>
				<tr>
					<td colspan="10" style="text-align:center"><strong>No result found..!!</strong></td>
				</tr>
				<?php } ?>
				</tbody>
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


	 $("#item_name").focus(function(){
	 	$("#item_name").val('');
	 	$("#item_id").val('');
	 	var departmentId = $('#department').val(); 
	    $(this).autocomplete({
	         source: "<?php echo $this->Html->url(array("controller" => "Store", "action" => "item_search_autocomplete","admin" => false,"plugin"=>false)); ?>"+'/'+departmentId,
	             minLength: 1,
	             select: function(event, ui ) {  
	            	var productId = ui.item.product_id;
	            	$("#product_id").val(productId); 
	             },
	             messages: {
	                    noResults: '',
	                    results: function() {},
	             },
	           
	        });
	  });

	 $("#ExcelGenerate").click(function(){
		 window.location.href = "<?php echo $this->Html->url(array('controller'=>'Reports','action'=>'stock_register_xls'))?>"
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

</script>



