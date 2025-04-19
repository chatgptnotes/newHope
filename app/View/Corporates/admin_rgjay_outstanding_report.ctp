<?php echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.autocomplete.css','colResizable.css'));  
 echo $this->Html->script(array('jquery.fancybox-1.3.4','inline_msg.js','jquery.autocomplete.js','colResizable-1.4.min.js')); ?>
<style>	
	.tableFoot{font-size:11px; color:#b0b9ba;}
	.tabularForm td td{padding:0;}
  
	textarea
	{
		width: 78px;
	}
	
	.inner_title span 
	{
    	margin: -33px 0 0 !important;
 	}
 	.inner_menu
 	{
		padding: 10px 0px;
	}
 	
 /* 	.row_title 
 	{
    	color: #000;
    	padding: 7px 3px;
    	float:center;
	} */
</style>
<?php  echo $this->element("reports_menu");?>
 <div class="inner_title"> 
 	<h3>&nbsp; RGJAY Outstanding Report</h3> 
     <div style="float:right;">
				<span style="float:right;">
					<?php
						echo $this->Form->create('Corporates',array('action'=>'', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm','style'=> 'float:left;'));
				       echo $this->Html->link('Back',array("controller"=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'margin:0 10px 0 0;'));
						echo $this->Form->submit(__('Generate Excel Report'),array('style'=>'padding:0px;','class'=>'blueBtn','div'=>false,'label'=>false));
						echo $this->Form->end();
					?>
				</span>
	
			</div>

	<div class="clr"></div>
 	
 </div> 

<div class="inner_menu">
 	<table cellpadding="0" cellspacing="0" border="0"  align="left">
		<tr>
			<!--<td>
				<?php
					echo $this->Form->create('Corporates',array('action'=>'', 'admin' => true,'type'=>'post', 'id'=> 'losxlsfrm', 'style'=> 'float:left;'));
					echo $this->Html->link('Back',array('controller'=>'Reports','action'=>'admin_all_report'),array('escape'=>true,'class'=>'blueBtn','style'=>'float:center;')); 
					echo $this->Form->submit(__('Generate Excel Report'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
			        echo $this->Form->end(); 
				?>
			</td>-->
		
			<td style="">									  
		    	<?php
					echo __("Patient Name : ")."&nbsp;".$this->Form->input('lookup_name', array('id' => 'lookup_name', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'class'=>'name'));
		    	?> 
		    	<span id="look_up_name" class="LookUpName">
				<?php 
					echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false));	
				?>
				</span>
			</td>
			
		</tr>
    </table>
</div>

<div class="clr">&nbsp;</div>
<div id="container">                
<div class="clr ht5"></div>
<div class="inner_title"></div>
	<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm labTable resizable sticky" id="item-row" style="top:0px; overflow: scroll;">
	  <tr>
	  	<thead>
	  		<th width="21" valign="top" align="center" style="text-align:center; min-width:21px;">#</th>
			<th width="80" valign="top" align="center" style="text-align:center; min-width:80px;">Patient Name</th>
			<th width="70" valign="top" align="center" style="text-align:center; min-width:70px;">Admission Date</th>
			<th width="65" valign="top" align="center" style="text-align:center; min-width:65px;">Bill No</th>
			<th width="65" valign="top" align="center" style="text-align:center; min-width:65px;">Discharge Date</th>
			<th width="45"  valign="top" align="center" style="text-align:center; min-width:45px;">Total Amount</th>
			<th width="65" valign="top" align="center" style="text-align:center; min-width:65px;">Amount Received</th>
			<th width="65" valign="top" align="center" style="text-align:center; min-width:65px;">TDS & Other Deduct</th>
			<th width="46"  valign="top" align="center" style="text-align:center; min-width:46px;">Balance</th>
			<th width="65" valign="top" align="center" style="text-align:center; min-width:65px;">Bill Submission Date</th>
			<th width="46"  valign="top" align="center" style="text-align:center; min-width:46px;">Amount Approval</th> 
			<th width="120"  valign="top" align="center" style="text-align:center; min-width:120px;">Remark</th> 
			<!--<th width="21" valign="center" align="center" style="text-align:center; min-width:21px;"><?php echo $this->Html->image('icons/delete-icon.png'); ?></th>-->
   		</thead>
      </tr>
      </table>
              
    <table width="100%" cellpadding="0" cellspacing="1" border="0" class="tabularForm">  
    	
    	<?php 
    	$i = 0; 
    	foreach($results as $result)   
    	{
    		$i++;
			?>
		<tr>
			<td width="21" align="center" style="text-align:center; min-width:21px;">
				<?php echo $i; ?>
			</td>
			
			<td width="80" style="text-align:center; min-width:80px;">
				<?php echo $result['Patient']['lookup_name']; ?>
			</td>
			
			<td width="70" align="center" style="text-align:center; min-width:70px;">
				<?php echo $this->DateFormat->formatDate2Local($result['Patient']['form_received_on'],Configure::read('date_format'));?>
			</td>
			
			<td width="65" align="center" style="text-align:center; min-width:65px;">
				<?php echo $result['FinalBilling']['bill_number']; ?>
			</td>
			
			<td width="65" align="center" style="text-align:center; min-width:65px;">
				<?php echo $this->DateFormat->formatDate2Local($result['FinalBilling']['discharge_date'],Configure::read('date_format'));?>
			</td>
			
			<td width="45" align="center" style="text-align:center; min-width:45px;">
				<?php echo $result['FinalBilling']['total_amount']; ?>
			</td>
			
			<td width="65" align="center" style="text-align:center; min-width:65px;">
				<?php echo $result['FinalBilling']['amount_paid']-($result['FinalBilling']['paid_to_patient']);; ?>
			</td>
			
			<td width="65" align="center" style="text-align:center; min-width:65px;">
				-
			</td>
			
			<td width="45" align="center" style="text-align:center; min-width:45px;">
				<?php echo $result['FinalBilling']['amount_pending']; ?>
			</td>
			
			<td width="65" align="center" style="text-align:center; min-width:65px;">
				<?php echo $result['FinalBilling']['date']; ?>
			</td>
			
			<td width="45" align="center" style="text-align:center; min-width:45px;">
				-
			</td>
			
			<td width="120" align="center" style="text-align:center; min-width:120px;">
				-
			</td>
			
			<!--<td width="21" align="center" style="text-align:center; min-width:21px;"><?php echo $this->Html->image('icons/delete-icon.png'); ?></td>-->
			
		</tr>
		<?php } ?>
	</table> 

</div>
 
<!--******************************************* table closed *******************************************************-->                    
            
<script>
jQuery(document).ready(function()
{
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
	$(function() {
		var $sidebar   = $(".top-header"),
            $window    = $(window),
            offset     = $sidebar.offset(),
            topPadding = 0;

        $window.scroll(function() {
            if ($window.scrollTop() > offset.top) {
                //$sidebar.stop().animate({
                 //   top: $window.scrollTop() - offset.top + topPadding
               // });

                $sidebar.css("top",$window.scrollTop() - offset.top + topPadding)
            } else {
                $sidebar.stop().animate({
                    top: 0
                });
            }
        });
       
    });
    
 

$('.LookUpName').click(function()
  {
  	//alert("OK");
  	var lookup_name = $("#lookup_name").val() ? $('#lookup_name').val() : null;
  	//alert(lookup_name);
		
		var ajaxUrl = "<?php echo $this->Html->url(array("controller" => 'corporates', "action" => "rgjay_report", "admin" => true));?>";
		$.ajax({
		url : ajaxUrl + '?lookup_name=' + lookup_name,
		success: function(data){
			$("#container").html(data).fadeIn('slow');
		}
		});
	});


});


  $("#lookup_name").autocomplete("<?php echo $this->Html->url(array("controller" => "app", "action" => "autocomplete","Patient",'lookup_name',"admin" => false,"plugin"=>false)); ?>", {
	width: 250,
	selectFirst: true
}); 

</script>