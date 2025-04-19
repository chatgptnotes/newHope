<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css','colResizable.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js')); ?>
<style>	
	.tableFoot{font-size:11px; color:#b0b9ba;}
	.tabularForm td td{padding:0;}
	.top-header
	{
		background:#3e474a;
		height:75px;
		left:0;
		right:0;
		top:0px;
		margin-top:10px;
		position: relative;
	}  
	textarea
	{
		width: 100px;
	}
	a.blueBtn{ height:15px !important;}
</style>
<?php // echo $this->element("reports_menu");?>
 <div class="clr">&nbsp;</div>
<div class="inner_title">
	<h3>
		<?php echo __('Surgeon Payment Report', true); ?>
	</h3>
		<div style="float:right;">
		<span style="float:right;">
					<?php 
				echo $this->Form->create('surgeonreport',array('url'=>array('controller'=>'Corporates','action'=>'surgeon_payment_report','admin'=>'TRUE'),'id'=>'surgeonreport','type'=>'get', 'style'=> 'float:left;')); 
				echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:right;margin-left:10px;'));  
			 echo $this->Html->link(__('Generate Excel Report'),array('controller'=>$this->params->controller,'action'=>$this->params->action,'excel',		
				'?'=>$this->params->query),array('id'=>'excel_report','class'=>'blueBtn'));		
					?>
		    </span>
    	</div>            
</div>
 <div class="clr">&nbsp;</div>
<table width="50%" cellpadding="0" cellspacing="0" border="0"
			class="tdLabel2" style="color: #b9c8ca;">
			<tr style="color:#000;">
		<td style="color:#000; width:45% ">
		<?php	echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name', 'value'=>$this->params->query['lookup_name'],'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'));
				?>
		</td>
		<td style="color:#000; width:50% ">	<?php echo $this->Form->input('fromDate',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"fromDate",'value'=>$this->params->query['fromDate'],'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'fromDate','placeholder'=>'Surgery Date From'));?>
					<!--<label>Date To:</label>-->
					<?php echo $this->Form->input('toDate',array('type'=>'text','class'=>'seen-filter textBoxExpnd','id'=>"toDate",'value'=>$this->params->query['toDate'],'autocomplete'=>'off','label'=>false,'div'=>false,'name'=>'toDate','placeholder'=>'Surgery Date To'));
					//echo "Show Completed "; ?>
	    </td>
		<td style="color:#000; width:11%;  id="look_up_name" class="LookUpName">	
			<?php 
				echo $this->Form->submit(__('Search'),array('style'=>'padding:0px; ','class'=>'blueBtn','div'=>false,'label'=>false));	
			?>
		</td>
		<td style="color:#000; width:5%; ">	<?php
				echo $this->Html->link($this->Html->image('icons/refresh-icon.png'), array('action'=>'surgeon_payment_report'),array('escape'=>false, 'title' => 'refresh'));				
			?> 
	  </td>
			</tr>
		</table>
		 <?php	echo $this->Form->end(); ?>	
<div id="container">                   
                   
<div class="clr ht5"></div>
	<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row"
	style="top:0px;overflow: scroll;">
	  <tr>
	  	<thead>
	  		<th valign="top" align="center" style="te xt-align:center;">#</th>
			<th valign="top" align="center" style="text-align:center;">Date of surgery</th>
			<th valign="top" align="center" style="text-align:center;">Patient Name</th>
			<th valign="top" align="center" style="text-align:center;">Surgeon</th>
			<th valign="top" align="center" style="text-align:center;">Anaesthetist</th>
			<th valign="top" align="center" style="text-align:center;">Surgery name</th>
			<th valign="top" align="center" style="text-align:center;">surgeon fees as per tariff</th>
			<th valign="top" align="center" style="text-align:center;">Surgeon to be paid</th>	
			<th valign="top" align="center" style="text-align:center;">Anaesthetist as per tariff</th>
			<th valign="top" align="center" style="text-align:center;">Anaesthetist to be paid</th>
			<!--<th valign="top" align="center" style="text-align:center;">Implant? as per tariff</th>
			<th valign="top" align="center" style="text-align:center;">Implant charges to be paid</th>
			<th valign="top" align="center" style="text-align:center;">Authorised</th> -->
   		</thead>
      </tr>                             	
			<?php
				$i=0;$val = 0;
		foreach($data as $ot)
		{
			$i++;
			$patient_id = $ot['Patient']['id'];
			$opt_id =$ot['OptAppointment']['id'];
	 $total = $ot['OptAppointment']['surgeon_amt'];
       $val = $val + $total;
       $total1 = $ot['OptAppointment']['cost_to_hospital'];
       $val1 = $val1 + $total1;
       
         $total2 = $ot['OptAppointment']['anaesthesist_amt'];
       $val2 = $val2 + $total2;
       
         $total3 = $ot['OptAppointment']['anaesthesia_cost'];
       $val3 = $val3 + $total3;
      
			?>
	 <tr>
		<td width="21px"  align="center" style="text-align:center;">
    			<?php 
    				echo $i;
    			?>
    		</td>
    		<td align="center">	
    			<?php $surDate= $this->DateFormat->formatDate2Local($ot['OptAppointment']['schedule_date'],Configure::read('date_format'), true);
						echo $surDate ?>
			</td>
			<td  align="center" style="text-align:center;">
				<?php  
				  	echo $ot['Patient']['lookup_name'];  ?>
	     	</td>
			<td>  
			<?php    //$doctorId = 'doctor_'.$ot['OptAppointment']['id']; //debug($doctorId);
		      		 echo $ot['DoctorProfile']['doctor_name'];
					?>  
			</td>
			
			<td>
				<?php
			 		 echo $ot['0']['name']; ?>
			</td>
		 	
			<td align="center">
					 <?php echo $ot['Surgery']['name']; ?>
			</td>
			
			<td align="center">
				 <?php echo $this->Form->input('surgeon_amt', array('id'=>'amt_'.$opt_id,'type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'surgeon_paid','value'=>$ot['OptAppointment']['surgeon_amt'])); ?>
			</td>
			
			<td align="center">
				<?php echo $ot['OptAppointment']['cost_to_hospital']; ?>
			</td>
			 <td align="center">
				<?php echo $this->Form->input('anaesthesist_amt', array('id'=>'amt_'.$opt_id,'type' => 'text','style'=>"width:20%",'label'=>false ,'div'=>false,'style'=>"width: 70%;",'class'=>'anaesth_paid','value'=>$ot['OptAppointment']['anaesthesist_amt'])); ?>
			</td>
		<td align="center">
				<?php echo $ot['OptAppointment']['anaesthesia_cost']; ?>
			</td>
		</tr>	
		<?php } ?>	
			<tr> 
	<td  align="center"style="text-align: center;font-weight:bold;"colspan="6">Actual  Amount Receivable </td>			
	<td   align="center"style="text-align: center; font-weight: bold;">
		<?php echo $val ?></td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  echo $val1?>	</td>
	<td  align="center"style="text-align: center;font-weight:bold;">
		<?php  echo $val2?>	</td>	
    <td  align="center"style="text-align: center;font-weight:bold;"colspan="">
		<?php  echo $val3?>	</td>
	</tr>
	</table> 
</div>
<tr>
			<td colspan="2" align="center">
				<!-- Shows the next and previous links --> <?php echo $this->Paginator->prev(__('« Previous', true), array('update'=>'#content-list',    												
						'complete' => "onCompleteRequest();",
		    		 	'before' => "loading();"), null, array('class' => 'paginator_links')); ?>
				<?php echo $this->Paginator->next(__('Next »', true), array('update'=>'#content-list',    												
						'complete' => "onCompleteRequest();",
		    		 	'before' => "loading();"), null, array('class' => 'paginator_links')); ?>
				<!-- prints X of Y, where X is current page and Y is number of pages -->
				<span class="paginator_links"><?php echo $this->Paginator->counter(array('class' => 'paginator_links')); ?>
			</span>
			</td>
	</tr> 
	

<!--******************************************* table closed *******************************************************-->                    
                     
                    
 <?php 
     function diff_bet_dates($start,$end)	// difference between two dates
     {
     	$start_ts = strtotime($start);
		$end_ts = strtotime($end);
		$diff = $end_ts - $start_ts;
		if($diff<0)
		{ 
			return "-";
		}
		else 
		{
			return round($diff / 86400);	//60 * 60 * 24	(60sec * 60min * 24hrs) = 86400
        }
     }
     
     function add_dates($cur_date,$no_days)		//to get the day by adding no of days from cur date
     {
 		$date = $cur_date; 
		$date = strtotime($date);
		$date = strtotime("+$no_days day", $date);
		return date('Y-m-d', $date);
     }
     
     

 ?>
                     
<!--*******************************************************************************************************************-->        

            
<script>
jQuery(document).ready(function()
{
	/*$(function() {
	$('.left_template').hide();		//to hide left menu from page
	});*/
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
$('.surgeon_paid').blur(function()
{var bill = $(this).attr('id'); 
	splittedId = bill.split("_");
	newId = splittedId[1];  
	var val = $(this).val(); 
	$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getSurgeonamt", "admin" => false));?>"+"/"+newId+"/"+val,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
		}
	});
});
$('.anaesth_paid').blur(function()
{var bill = $(this).attr('id'); 
	splittedId = bill.split("_");
	newId = splittedId[1];  
	var val = $(this).val(); 
	$.ajax({
		url : "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "getAnaesthesistamt", "admin" => false));?>"+"/"+newId+"/"+val,
		beforeSend:function(data){
		$('#busy-indicator').show();
		},
		success: function(data){
			$('#busy-indicator').hide();
		}
	});
});
	
$(function(){
			  
			  var onSampleResized = function(e){  
			    var table = $(e.currentTarget); //reference to the resized table
			  };  

			 $("#item-row").colResizable({
			    liveDrag:true,
			    gripInnerHtml:"<div class='grip'></div>", 
			    draggingClass:"dragging", 
			    onResize:onSampleResized
			  });    
			  
			});		

$('.LookUpName').click(function(){
		  	
		  	var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;

				var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "bsnl_report", "admin" => true));?>";
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

$("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", 
		{
				width: 80,
				selectFirst: true
		});	

		
	$('.filter').change(function()	//.checkMe is the class of select having patient's id as the id
	{
		var team = ($('#team').val()) ? $('#team').val() : 'null' ;
		var status = ($('#status').val()) ? $('#status').val() : 'null';
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "rgjay_report", "admin" => true));?>";
		$.ajax({
		url : ajaxUrl + '?assigned_to=' + team + '&update_status=' + status,
		success: function(data){
			$("#container").html(data).fadeIn('slow');
		}
		});
	});

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

</script>