<?php
	echo $this->Html->script(array('jquery-1.5.1.min.js'));
	echo $this->Html->css(array('internal_style')); 
?>

<style>
	body{
	     background: url("../img/body-bg.gif") repeat-x scroll 0 0 #1E1E1E;
	    color: #E7EEEF;
	    font-family: Arial,Helvetica,sans-serif;
	    font-size: 13px;
	    margin: 0;
	    padding: 10px;
	}
	
</style>
<div class="inner_title">
	<h3>	 <?php echo __('View Currencies HTML Code'); ?>		</h3>	
			<span>
				<?php
		       		echo $this->Html->link(__('Close'), array('action' => '#'), array('escape' => false,'class'=>'blueBtn'));
				?>
			</span> 
	
	<div class="clr"></div>
</div>
<div class="clr">&nbsp;</div>
<table  class="tabularForm" cellpadding="1" cellspacing="1" align="center" width="100%" >
	<?php 
		$currencyHtml = array(
								'$'=>'&#36;',
								'₣'=>'&#x20a3;',
								'¢'=>'&#xa2',
								'£'=>'&#xa3',
								'¤'=>'&#xa4',
								'¥'=>'&#xa5',
								'฿'=>'&#xe3f',
								'₠'=>'&#x20a0',
								'₣'=>'&#x20a3',
								'₤'=>'&#x20a4',
								'₥'=>'&#x20a5',
								'₦'=>'&#x20a6',
								'₧'=>'&#x20a7',
								'₨'=>'&#x20a8',
								'₩'=>'&#x20a9',
								'₫'=>'&#x20ab',
								'₪'=>'&#x20aa',
								'€'=>'&#x20ac',
								'＄'=>'&#xff04',
								'﹩'=>'&#xfe69',
								'￡'=>'&#xffe1',
								'￥'=>'&#xffe5',
								'￦'=>'&#xffe6',
								'₡'=>'&#x20a2',
								'&#x20a8;'=>'&#x20b9;'
							);
		$i = 0 ;
		
		foreach($currencyHtml as $symbol=>$htmlCode){
			
			if($i == 0) echo "<tr>";			
		?> 
				<td class="row_format" ><strong><?php echo $symbol ;?></strong> </td>
				<td class="row_format html_code" style="text-decoration:underline;cursor:pointer;" id="<?php echo $symbol ;?>" class="">
				<?php echo htmlspecialchars($htmlCode) ?></td>
		 
		<?php
				
			
			if($i==2){ $i = 0 ;} else { $i++ ; }
			 
			if($i == 0) {
				echo "</tr>";
			}
		}
	?>
 
</table>
<script>
	$(document).ready(function(){
		html_code_array = <?php echo json_encode($currencyHtml); ?>;
		$(".html_code").click(function(){
			currentId = $(this).attr('id') ; 
			parent.$('#currency_symbol').val(html_code_array[currentId]);	 
			parent.$.fancybox.close();
		});
	});
		
</script>

 
	
