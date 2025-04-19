<style>

#talltabs-blue {
    border-top: 6px solid #8A9C9C;
    clear: left;
    float: left;
    font-family: Georgia,serif;
    overflow: hidden;
    padding: 0;
    width: 100%;
}
#talltabs-blue ul {
   /*  left: 50%; */
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
    text-align: center;
}
#talltabs-blue ul li {
    display: block;
    float: left;
    list-style: none outside none;
    margin: 0;
    padding: 0;
    position: relative;
   /* right: 50%;*/
}
#talltabs-blue ul li a {
    background: none repeat scroll 0 0 #8A9C9C;
    color: #FFFFFF;
    display: block;
    float: left;
    margin: 0 1px 0 0;
    padding: 8px 10px 6px;
    text-decoration: none;
}

#talltabs-blue ul li a.active, #talltabs-blue ul li.active a:hover {
    padding: 30px 10px 6px;
}
.box{
	width:200px;
	height:40px;
	background-color:#8A9C9C;
	text-align:lef;
	border: 1px solid #fff;
	vertical-align:bottom;
	font-size:23px;
	
}
.text{
	font-size:20px;
	height:15px;
	
}
</style>
<div class="inner_title">
	<h3>
		<?php echo __('Day Sheet'); ?>
	</h3>
</div>
<?php echo $this->Form->create('Billing',array('controller'=>'Billings','action'=>'daySheetBilling','id'=>'accountReceivable','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false
)
));
?>
<table style="width:50%;padding-top:20px;">
<tr>
<td style="width:50px;"><?php echo __("Date")?></td>
<td style="width:150px;"><?php echo $this->Form->input('Billing.from',array('id'=>'from','type'=>'text','legend'=>false,'label'=>false,'readonly'=>'readonly','class'=>'textBoxExpnd validate[required,custom[mandatory-enter-only]]'));?></td>
<!-- <td style="width:150px;"><?php echo $this->Form->input('Billing.to',array('style'=>'width:150px;','id'=>'to','type'=>'text','legend'=>false,'label'=>false,'class'=>'textBoxExpnd validate[required,custom[mandatory-enter-only]]'));?></td>
 -->
<td style="width:180px;"><input type="submit" value="Submit" name="Submit" id="filter" class="blueBtn"></td>
</tr>
</table>
<?php echo $this->Form->end();?>
<div id="talltabs-blue">
	<ul>
		<li><a href="#tabs-1" class="active-menu-tabs" name="tabs-1">Grand Total</a></li>
		<li><a href="#tabs-2" class="active-menu-tabs" name="tabs-2">Credits and Adjustment</a></li>
		<li><a href="#tabs-3" class="active-menu-tabs" name="tabs-3">Patient Payments</a></li>
		<li><a href="#tabs-4" class="active-menu-tabs" name="tabs-4">Charges</a>
		</li>
	</ul>
	<div class="clear">&nbsp;</div>
	<div class="clear">&nbsp;</div>
	<table>
		<tr>
			<td> 
				<div id="tabs-1" class="child-tabs">
					<table>
						<tr>
							<td>
								<table>
									<tr>
										<td>
										<div class="box"><?php echo $todaysCollection;?></div>
										<div class="box text"><?php echo __("DEBIT");?></div>
										</td>
									</tr>
									
								</table>
							</td>
							<td>
								<table>
									<tr>
										<td>
										<div class="box"><?php echo $credit;?></div>
										<div class="box text"><?php echo __("CREDIT");?></div>
										</td>
									</tr>
									
								</table>
							</td>
							<td>
								<table>
									<tr>
										<td>
										<div class="box"><?php echo $copayCash;?></div>
										<div class="box text"><?php echo __("COPAY/CASH");?></div>
										</td>
									</tr>
									
								</table>
							</td>
							<td>
								<table>
									<tr>
										<td>
										<div class="box"><?php echo $adjustment;?></div>
										<div class="box text"><?php echo __("ADJUSTMENT");?></div>
										</td>
									</tr>
									
								</table>
							</td>
							
						</tr>

					</table>
				</div> 
				<div id="tabs-2" class="child-tabs" style="display:none;">
					<p>This is tab-2</p>
				</div>
				<div id="tabs-3" class="child-tabs" style="display:none;">
					<p>This is tab-3</p>
				</div>
				<div id="tabs-4" class="child-tabs" style="display:none;">
					<p>This is tab-4</p>
				</div>
			</td>
		</tr>
	</table>
</div>
<script>

$("#from").datepicker({
	showOn: "button",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	changeTime:true,
	showTime: true,  		
	yearRange: '1950',			 
	dateFormat:'<?php echo $this->General->GeneralDate("");?>', 
	onSelect:function(){$(this).focus();}
});
</script>
<script>
$(document).ready(function () {

	$(".active-menu-tabs").click(function(){  
    	var tabClicked = $(this).attr("name");
    	$(".child-tabs").hide();
    	$("#"+tabClicked).fadeIn('slow');
    	$(".active-menu-tabs").removeClass('active');
    	$(this).addClass('active');
		

        return false ;
	});
	
 })
</script>