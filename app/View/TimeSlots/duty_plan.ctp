<?php  echo $this->Html->script(array('jquery.blockUI','pager.js')); ?>
<style>
.calenderDiv {
    background: none repeat scroll 3px 2px ghostwhite;
    border: 3px solid #d9d9d9;
    cursor: pointer;
    float: left;
    text-align: center;
    width: 7%;
    font-weight:bold
}
.formFull td {
    color: #000;
    font-size: 15px;
    font-weight: bold;
}
.ui-widget-header {
    color: #FFF;
    font-weight: bold;
}
.detailItem:hover {
	background-color: pink;
	cursor: default;
}
</style>
<div class="inner_title">
 <?php echo $this->element('duty_roster_menu');?>
	<h3>
		&nbsp;
		<?php echo __($title_for_layout, true); ?>
	</h3>
</div>
<table  width="100%" cellspacing="0" cellpadding="0" border="0"
	align="center" style="padding: 5px; margin-top: 5px" class="formFull">
	<tbody>
		<tr>
			<td align="center">Role</td>
			<td>
			<?php	echo $this->Form->input('role_id',array('options'=>$roles,'empty'=>__('Please Select'),'class'=>'validate[required,custom[mandatory-select]] textBoxExpnd roleId',
					'style'=>'width:20%;','label'=>false,'div'=>false,'id'=>'roleId','autocomplete'=>'off','onChange'=>"getUsers();")); ?>
			</td>
		</tr>
		<tr>
			<td   colspan="2" >
			<?php  for($i = date('n') ; $i<= 12 ; $i++ ){ ?>
				<div class="calenderDiv detailItem " id="<?php echo date ("m", mktime(0,0,0,$i,1,0)); ?>" onclick="setBackgroundAndMonth('<?php echo date ("m", mktime(0,0,0,$i,1,0)); ?>');"><?php echo __(date ("F", mktime(0,0,0,$i,1,0)));?></div>
				<?php  }?>
				
			<?php  for($i = 1 ; $i< date('n') ; $i++ ){ ?>
				<div class="calenderDiv detailItem"  id="<?php echo date ("m", mktime(0,0,0,$i,1,0)); ?>" onclick="setBackgroundAndMonth('<?php echo date ("m", mktime(0,0,0,$i,1,0)); ?>');"><?php echo __(date ("F", mktime(0,0,0,$i,1,0)));?></div>
				<?php  }?>	
			</td>
		</tr>
	</tbody>
</table>
<p class="ht5"></p>
<div id="mainForm"></div>
<p class="ht5"></p>
<?php echo $this->Js->writeBuffer(); ?>
<script>
$(function(){
	$('.ui-corner-all').remove();
});
var month = '';
function  getUsers(){
		$('#roleId').validationEngine('hide');
		if($('#roleId').val() == ''){
			$('#roleId').validationEngine('showPrompt', 'Please Select', 'text', 'topRight', true);
			return false;
		}
		if(month == ''){
			$('.calenderDiv').validationEngine('showPrompt', 'Please Select', 'text', 'topRight', true);
			return false;
		}
		$.ajax({
			  url: "<?php echo $this->Html->url(array("controller" => 'TimeSlots', "action" => "ajaxGetListOfuser", "admin" => false)); ?>",
			  context: document.body,
			  method : 'Get',
			  data : 'month='+month+'&role_id='+$('#roleId').val(),
			  beforeSend:function(){
				  loading();
			  }, 				  		  
			  success: function(data){
				  onCompleteRequest();
				  $('#mainForm').html(data);
				}  
			});
		}

function setBackgroundAndMonth(thisId){
	$('.calenderDiv').validationEngine('hide');
	$('.calenderDiv').css("background-color", "white");
	$('div#'+thisId).css("background-color", "#ddd"); 
	month = thisId;
	getUsers();
}
function loading(){
	 $('#mainForm').block({ 
       message: '<h1><img src="../theme/Black/img/icons/ajax-loader_dashboard.gif" /> Please Wait...</h1>', 
       css: {            
           padding: '5px 0px 5px 18px',
           border: 'none', 
           padding: '15px', 
           backgroundColor: '#DDDDDD', 
           '-webkit-border-radius': '10px', 
           '-moz-border-radius': '10px',               
           color: '#000',
           'text-align':'left' 
       },
       overlayCSS: { backgroundColor: '#cccccc' } 
   }); 
}

function onCompleteRequest(){
	$('#mainForm').unblock(); 
}
</script>