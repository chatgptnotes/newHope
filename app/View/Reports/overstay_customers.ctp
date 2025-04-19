<?php 
	echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));  
	echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js')); 
?>
<style>

.tableFoot {
	font-size: 11px;
	color: #b0b9ba;
}

.tabularForm td td {
	padding: 0;
}

.top-header {
	background: #3e474a;
	height: 75px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea  
{
	width: 80px;
}
#inner_menu img{ float:none !important;}
div{ font-size:13px;}
.inner_title span{ margin:-26px 0px;}

</style>
 <div class="inner_title" > 
 	<h3>&nbsp; Overstay Patients Report</h3> 
    <div style="float:right;">
				<span style="float:right;">
					<?php
						echo $this->Form->create('Reports',array('action'=>'overstay_customers_xls', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm'));
						echo $this->Html->link('Back',array('controller'=>'corporates','action' => 'lifespring_reports','admin'=>true),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
						//echo $this->Html->link(__('Generate Excel Report'),"javascript:void(0);",array('style'=>'padding:0px;','class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'generate_excel'));
						echo $this->Form->end();
					?>
				</span>
			</div>
 </div>

<div id="inner_menu" style="float:right; width:100%; padding-top:10px;">                
	<div cellpadding="0" cellspacing="0" border="0"  align="left" style="float:left; width:100%; ">
		<div style="float: Left;">

			<?php
				echo $this->Form->create('', array('action'=>'overstay_customers','admin' => true,'id'=>'main_form','type'=>'get', 'style'=> 'float:left;'));
				echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' =>'lookup_name', 'value'=>$this->params->query['lookup_name'],'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'))."&nbsp;&nbsp;&nbsp;";
			?> 
	    <span>
	    	<?php 
	    		echo "Date From : "."&nbsp;".$this->Form->input('MahiReport.from', array('id'=>'fromDate','value'=>$this->request->query['from'] ,'label'=> false, 'div' => false, 'error' => false)); 
	    	?>
	    </span>
	    <span>
	    	<?php 
	    		echo "To Date : "."&nbsp;".$this->Form->input('MahiReport.to', array('id'=>'toDate','value'=>$this->request->query['to'] ,'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
	    <span>
	    	<?php 
	    		echo "No of Days : "."&nbsp;".$this->Form->input('MahiReport.days', array('id'=>'','value'=>$this->request->query['days'] ,'label'=> false, 'div' => false, 'error' => false));
	    	?>
	    </span>
	    
	   	<span id="look_up_name" class="LookUpName">
			<?php 
				echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));	
			?>
			</span>
			<?php
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'overstay_customers'),array('escape'=>false, 'title' => 'refresh'));
				echo $this->Form->end();
			?>
	
		</div>
    </div>
</div>	
	
	<div class="clr">&nbsp;</div>
	<div id="container">
	<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm"> 
		<tr>
		  	<thead>
				
				<th width="5px" valign="top" align="center" style="text-align:center;">#</th>
				<th width="51px" valign="top" align="center" style="text-align:center;">Patient Name</th>
				<th width="60px" valign="top" align="center" style="text-align:center;">Visit ID</th>
				<th width="51px" valign="top" align="center" style="text-align:center;">Age</th>
				<th width="51px" valign="top" align="center" style="text-align:center;">Sex</th>
				<th width="60px" valign="top" align="center" style="text-align:center;">Admission Date</th>
				<th width="66px" valign="top" align="center" style="text-align:center;">Discharge Date</th>
				<th width="47px" valign="top" align="center" style="text-align:center;">Length of Stay</th>
				
	   		</thead>
      	</tr>
      
    
    
    <?php  $i=0; //debug($results);
    	foreach($results as $result) 
    	  {	
    	  	$patient_id = $result['Patient']['id'];
    	  	$bill_id = $result['FinalBilling']['id'];
    	  	$i++;  	
    ?>
    	<tr>
    		<td width="8px" valign="top" align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
    		<td width="55px" style="text-align:center;">
				<?php echo $result['Patient']['lookup_name'];?>
			</td>
    		
    		<td width="66px" style="text-align:center;">
				<?php 
					// Admission Date
	 				echo $result['Patient']['admission_id'];	
	 				
				?> 
			</td>
	    	
			
			<td align='center' height='17px'><?php echo $result['Person']['age'] ?></td>  
					    <td align='center' height='17px'><?php echo ucfirst($result['Person']['sex']); ?></td>
						
			<td width="66px" style="text-align:center;">
				<?php 
					// Admission Date
	 				$admitn_date =($result['Patient']['form_received_on']);	
	 				echo $this->DateFormat->formatDate2Local($admitn_date, Configure::read('date_format'));
				?> 
			</td>
			
			
			<td width="71px" style="text-align:center;">
				<?php 
						// Discharge Date
						if(!empty($result['Patient']['discharge_date']))
						{
		 				$discharg_date =($result['Patient']['discharge_date']);	
		 				echo $this->DateFormat->formatDate2Local($discharg_date, Configure::read('date_format'));
						}else 
						{
							$discharg_date = date('Y-m-d');
							echo "-";
						}
				?>
			</td>
			
			<td width="71px" style="text-align:center;">
				<?php 
				$losStr=" ";
						// LOS
		 				 $los = $this->DateFormat->dateDiff($result['Patient']['form_received_on'],$discharg_date) ;
		                $losStr .= " ".$los->days."Day(s)" ;
		                echo $losStr; ?>
			</td>
			
		
			
    		
			</tr>
    	
<!--     		<td>  -->
    		<?php //echo $bill_id; ?>
<!--     		</td> -->
    <?php } ?>	
    </table>
	<table align="center">
		<tr>
			<?php $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
			?>
			<TD colspan="8" align="center">
				<!-- Shows the page numbers --> <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			
			</TD>
		</tr>
	</table>




<Script>

/* $('.LookUpName').click(function()
		  {
		  	//alert("OK");
		  	var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
		  	//alert(lookup_name);
				
				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'reports', "action" => "overstay_customers", "admin" => true));?>";
				$.ajax({
				url : ajaxUrl + '?lookup_name=' + lookup_name,
				beforeSend:function(data){
				$('#busy-indicator').show();
			},
				success: function(data){
					$('#busy-indicator').hide();
					$("#container").html(data).fadeIn('slow');
					
				}
				});
			});

*/
		

 $("#lookup_name").autocomplete("<?php echo $this->Html->url(
				array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", 
		{
				width: 80,
				selectFirst: true
			});





		
		$("#fromDate").datepicker
		({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
				dateFormat: 'dd/mm/yy',			
			});	
				
		 $("#toDate").datepicker
		 ({
				showOn: "button",
				buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true,
				yearRange: '1950',
				maxDate: new Date(),
				dateFormat: 'dd/mm/yy',			
			});

		 $('#generate_excel').click(function (){
			 $.ajax({
				  type : "POST",
				  url: "<?php echo $this->Html->url(array("controller" => "reports", "action" => "overstay_customers_xls", "admin" => false)); ?>",
				  context: document.body,
				  data:$("#main_form").serialize(),
				    
				});
				 return true;     
			 });
		 
			 
			
			
</Script>