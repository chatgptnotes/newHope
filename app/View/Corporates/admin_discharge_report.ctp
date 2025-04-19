<?php $website= $this->Session->read('website.instance');?>

<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css'));  
	 echo $this->Html->script(array('jquery.fancybox-1.3.4','jquery.autocomplete.js')); ?>
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
	height: 60px;
	left: 0;
	right: 0;
	top: 0px;
	margin-top: 10px;
	position: relative;
}

textarea {
   
    width: 120px;
}

.inner_title span {
    float: right;
    margin: -3px 4px;
    padding: 0;
}

.inner_title span {
    float: none!important;
    margin: 0 !important;
}
.tdLabel2 img{ float:none !important;}

</style>
<?php // echo $this->element("reports_menu");?>
<div class="inner_title">
<h3 style="float: left;"><?php echo __('Discharge Report', true); ?></h3>
<table width="" cellpadding="0" cellspacing="0" border="0" class="tdLabel2" style="color:#b9c8ca;">
<tr>
<td width="84%"></td>
<td>	
	<span style="float:right;">	
<?php		echo $this->Form->create('dischargereport',array('url'=>array('controller'=>'Corporates','action'=>'discharge_report','admin'=>'TRUE'),'id'=>'dischargereport','admin'					 => true,'type'=>'get', 'style'=> 'float:left;'));
			echo $this->Html->link('Back',array("controller"=>'reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
				echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));		
					?></span>
</td></tr></table>
<div class="clr ht5"></div>			
</div>
<div class="clr ht5"></div>
		<table width="" cellpadding="0" cellspacing="0" border="0"
			class="tdLabel2" style="color: #b9c8ca;">
			<tr>
				<td style="color:#000; width=30%"><?php
							echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name','value'=>$this->params->query['lookup_name'], 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'));
				    	?> <td style="color:#000; width=25%"> 	<?php
                echo __("From : ").$this->Form->input('DischargeReport.from', array('id'=>'from','value'=>$this->request->query['from'],'label'=> false, 'div' => false, 'error' => false))."&nbsp;&nbsp;"?>
				</td> <td style="color:#000; width:25%"><?php 
                echo __("To : ").$this->Form->input('DischargeReport.to', array('id'=>'to','value'=>$this->request->query['to'],'label'=> false, 'div' => false, 'error' => false))."&nbsp;&nbsp;"?>
				</td>  
				    	<td style="color:#000; width=10%" >
						<?php 
							echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));	
						?>
				</td><td width=5%><?php 
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png',array()),array('controller'=>'Corporates','action'=>'discharge_report','admin'=>true),
		        array('escape' => false,'title'=>'Back to List'));
					?> 
				</td>
			</tr>
		</table>
<?php echo $this->Form->end();	?>		
<div class="clr ht5"></div>



<table width="100%" cellpadding="0" cellspacing="1" border="0"
	class="tabularForm ">
	
	<tr>
<thead>
		<th width="40px;" valign="top" align="center" style="text-align:center; ">DISCHARGE DATE</br>
			<?php 
		    if($website == 'kanpur')
              {?>DISCHARGED BY
              <?php }?></th>
		<th width="70px;" valign="top" align="center" style="text-align:center; ">PATIENT NAME</th>
		<th width="60px;" valign="top" align="center" style="text-align:center; ">BILL AMOUNT</th>
		<th width="60px;" valign="top" align="center" style="text-align:center; ">PATIENT PAID</th>
		<?php 
		$website= $this->Session->read('website.instance');
		if($website == 'kanpur')
        {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">RADIOLOGY</th>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">PHARMACY</th>
		<!-- <th width="82px;" valign="top" align="center" style="text-align:center; ">IMPLANT</th> -->
		<?php } else {?>
		<th width="82px;" valign="top" align="center" style="text-align:center; ">LAB<br>PHARMACY<br>IMPLANT<br>INSTRUMENTS</th>
		<?php }?>
		<th width="62px;" valign="top" align="center" style="text-align:center; ">HOSPITAL REVENUE</th>
		<th width="66px;" valign="top" align="center" style="text-align:center; ">REFFERED BY</th>
		<th width="140px;" valign="top" align="center" style="text-align:center; ">REMARKS</th>
		<!-- <th width="25" valign="top" align="center" style="text-align:center; min-width:25px;">PRINT</th> -->
		
</thead>
</tr>
	
	<?php  //debug($results);
	$i=0;
	foreach($results as $key=>$result)
     { ?>
	<TR>
		<td width="78px;" align="center"><?php echo $this->DateFormat->formatDate2Local($result['Patient']['discharge_date'],Configure::read('date_format'),true).'</br>'?> 
			<?php if($website == 'kanpur')
                   { 	echo $userName;
	     	        }?> 
		</td>
		<td width="84px;" align="center"><?php echo $result['Patient']['lookup_name']; ?></td>
		<td width="72px;" align="right"><?php 
		        echo $this->Number->currency(ceil($bill_amt=$result['FinalBilling']['total_amount']));?></td>
		        
	    <td width="73px;" align="center"><?php 
	    
// 	    $this->Html->link($this->Html->image('icons/active.png'),array('controller'=>'Billings','action'=>'advancePayment',$result['Patient']['id'],'admin'=>false),
// 	    		array('escape' => false));
// 	    $pay_amount = 0;
// 	    foreach($advancePayment as $pay)
// 	    {
// 	    	if($result['Patient']['id'] == $pay['Billing']['patient_id'])
// 	    	{
// 	    		$pay_amount = $pay_amount+$pay['Billing']['amount'];
	    		
// 	    	}
// 	    }
// 	    echo $this->Number->currency(ceil($pay_amount));

	    echo $this->Number->currency(ceil($result['FinalBilling']['amount_paid']));
?>
	    </td>
		
		<?php 
		$website= $this->Session->read('website.instance');
		if($website == 'kanpur')
        {?>	
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($lab=$result['LaboratoryTestOrder']['total'])); ?></td>
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($rad=$result['RadiologyTestOrder']['total'])); ?></td>
        <td width="97px;"align="right"><?php echo $this->Number->currency(ceil($pharm=$result['PharmacySalesBill']['total']));?></td>
		<!-- <td></td> -->
		<?php }else{?>	
		<td width="97px;"align="right"><?php echo $this->Number->currency(ceil($lab=$result['LaboratoryTestOrder']['total']));
		echo "/"."<br>";
		echo $this->Number->currency(ceil($pharm=$result['PharmacySalesBill']['total']));
		echo "/"."<br>";
		 //echo$this->Number->currency(ceil($lab=$result['LabTestPayment']['total_amount']+ $result['RadiologyTestPayment']['total_amount'])); 
		?>
		</td>
		<?php }?>
		
		<td width="74px;" align="right"><?php echo $this->Number->currency(ceil($bill_amt-($pharm+$lab+$rad)))?> </td>
		
		<td width="79px;" align="center"><?php echo $result['Initial']['name']." ".$result[0]['name'];?></td>
	
		
		<td width="165px;"align="center">
		<table>
		     <tr>
		     	     
		        <td>
			<?php echo $this->Form->input('remark',array('id'=>'remark_'.$result['Patient']['id'],'type'=>'textarea','label'=>false,'rows'=>'1','cols'=>'2','class'=>'add_remark','value'=>$result['Patient']['remark']));?>
				</td></tr>	
		</table></td>
		
		
		<!-- <td width="25"  align="center"  min-width:25px;"><?php
		echo $this->Html->link($this->Html->image('icons/print.png',array('title'=>'Print Invoice')),'#',
						     		array('escape' => false,'onclick'=>"var openWin = window.open('".html_entity_decode($this->Html->url(array('action'=>'printReceipt',
						     		$result['Patient']['id'],$mode),true))."',
						           'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200');  return false;"));
	?>	</td> -->

	</TR>
	<?php } ?>
	
</table>
<table align="center">
 <tr>
 						<?php $this->Paginator->options(array('url' =>array("?"=>$this->params->query)));
 						?> 
					    <TD colspan="8" align="center">
					    <!-- Shows the page numbers -->
					 <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
					 <!-- Shows the next and previous links -->
					 <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
					 <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
					 <!-- prints X of Y, where X is current page and Y is number of pages -->
					 <span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
					    </TD>
					   </tr>
</table>


<script>
           jQuery(document).ready(function()
		   {
								
				$('.clickMe').click(function()
				{
				var patient = $(this).attr('id') ;
				var val = $("#remark"+patient).val();
				
				$.ajax({
				url : "<?php echo $this->Html->url(array("controller" => 'reports', "action" => "getdischargeRemark", "admin" => false));?>"+"/"+patient+"/"+val,
				success: function(data){
				alert(data);
				}
				});}
				);

				$('.add_remark').blur(function()
		    			  {
		    				  var patient = $(this).attr('id') ;
		    				  splittedId = patient.split("_");
		    				  remarkId = splittedId[1];
		    				 // alert(remarkId);
		    				  var val = $(this).val();
		    				  //alert(val);

		    				$.ajax({
		    				url : "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "getRemark", "admin" => false));?>"+"/"+remarkId+"/"+val,
		    				
		    				beforeSend:function(data){
		    					$('#busy-indicator').show();
		    					//inlineMsg(patient,'<?php echo $this->Html->image('/ajax-loader.gif') ?>')	
		    				},
		    				
		    				success: function(data){
		    							$('#busy-indicator').hide();
		    				     }
		    				
		    				});
		    				}
		    				);

				

				$(function() {

	                var $sidebar   = $(".top-header"), 
	                    $window    = $(window),
	                    offset     = $sidebar.offset(),
	                    topPadding = 0;

	                $window.scroll(function() {
	                    if ($window.scrollTop() > offset.top) {
	                        /*$sidebar.stop().animate({
	                            top: $window.scrollTop() - offset.top + topPadding
	                        });*/

	                        $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
	                    } else {
	                        $sidebar.stop().animate({
	                            top: 0
	                        });
	                    }
	                });
	                
	            });

		   });


           $('.LookUpName').click(function()
     			  {
     			  	//alert("OK");
     			  	var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
     			  	//alert(lookup_name);
     					
     					var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'Corporates', "action" => "discharge_report", "admin" => true));?>";
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


     	$("#lookup_name").autocomplete("<?php echo $this->Html->url(
 				array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", 
 		{
 				width: 80,
 				selectFirst: true
 			}); 
 			  	
$("#from").datepicker
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
				
		 $("#to").datepicker
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
</script>




