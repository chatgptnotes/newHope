
<?php echo $this->Form->create('multipleorderindex',array('type' => 'file','id'=>'multipleorderindex','inputDefaults' => array(
		'label' => false,
		'div' => false,
		'error' => false,
		'legend'=>false,
		'fieldset'=>false,
		'url' => array('controller' => 'patients', 'action' => 'multipleorderindex',$patient_id,)
)
));

echo $this->Form->hidden('PatientOrderEncounter.id');
?>
<?php 
function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>
<style>
	.row20px tr td {
	    border-bottom: 1px solid #DDDDDD;
	    border-left-color: #FFFFFF !important;
	    border-left-width: 0 !important;
	    border-right: 1px solid #DDDDDD;
	    border-style: solid;
	    border-top-color: #FFFFFF !important;
	    border-top-width: 0 !important;
	    border-color:#4C5E64 !important;
	  /*  padding-top: 2px !important; */
	    color:none;
	    font-size: 12px;
	}
	
	.container{
	    /*height: 19px;*/
	    width:50px;
	}
	
	.tree-menu{
		background:#252C2F;
		color:#fff;
		min-width:200px;
	}
	
	.obj{
		overflow-x:scroll; 
		min-height:260px;
		background:#252C2F;
		max-width:1177px;
		max-height:700px;
		
	}
	
	.parent-obj1{
		min-height:260px;
		background:#252C2F;
		max-width:1177px;
		max-height:700px;
		overflow-x:scroll; 
	}
	
	.sub-cat{
		cursor:pointer;
	}
	
	.gray-container{
		background: #252C2F; 
		color: #fff; 
		text-align: center;
		padding:2px;
	}
	
	.treesubmenu{
		background:#a1b6bd;
		color:#fff;
		min-width:200px;
	}
	
	.time-area{
		width:50px;
	}
	
	
	
	#time-slot a {
		
	}
	 
	 #loginBox {
	    position:absolute;
	    top:34px;
	    right:0;
	    /*display:none;*/
	    height:0px;
	    z-index:29;
	    overflow:hidden;
	    background : #cccccc;
	    width:200px;
	}
	#loginBox ul{list-style:none;color:black;cursor:pointer;}
	#loginBox ul li:hover {background:#99CCFF; border:1px solid #00FFFF;}
	.two_img img{float:inherit;} 
	.excel-format{margin-bottom:10px;border-right: 1px solid #000000;}
	.treeview ul {  background-color: #252c2f;   margin-top: 4px; }
	.hasSelect{padding:0px;width:51px;}
	.custom-li{padding:0px;}
	/*.border{ border-style:none;}
	.size50{ border-style:none !important;  width: 50px;text-align:center;}*/
	.size50{ width: 50px;}
	.cell-color{color:#FF00FF ;}
	.custom-li{padding:0px;}
	.filetree li{padding: 0 0 0 16px;}
	.save-data{background-color: #CCCCCC;opacity: 0.5;}
	.save-data-enable{background-color: none;opacity: 1}
	#msg {
	    background-color: #EBF8A4;
	    background-image: url("../theme/Black/img/icons/tick.png");
	    background-position: 2px 40%;
	    background-repeat: no-repeat;
	    border: 1px solid #A2D246;
	    border-radius: 5px;
	    box-shadow: 0 1px 1px #FFFFFF inset;
	    color: #000000;
	    display: none;
	    font-weight: bold;
	    margin: 0.5em 0 1.3em;
	    padding: 5px 0 5px 18px;
	    position: absolute;
	    width: auto;
	    z-index: 200;
   }
</style>
<div class="inner_title">
	<h3>
		&nbsp;
		<?php echo __('Orders Information')."-".$multiOrderType;?>
		
		<span style="text-align: right;padding-top:18px"><?php
                                 echo $this->Html->link(__('Back'), array('controller'=>'Users','action' => 'doctor_dashboard'),array('class'=>'blueBtn'));
            ?></span>
	</h3>

</div>
<!--  <div style="float:left"><table width="100%" cellspacing="0" cellpadding="0" border="0" id="treeDivArea">
	<tbody>
		<tr>
			<td valign="top" class="tree-menu">
				<table>
					<tr>
						<td>
							<ul id="browser" class="filetree treeview-famfamfam">
								<?php 
									$classOpen = 'open' ;
								?>
										<li class="<?php echo $classOpen ;?>">
											<span class="folder main-cat" id="<?php echo $value['OrderCategory']['id'];?>"><?php echo Orders?></span>
											<ul>
												<?php 
													if(!empty($getCategory)){
														foreach($getCategory as $key => $value) {
													?>
															<li><span name="<?php echo clean($value['OrderCategory']['id']); ?>" id="<?php echo  $value['OrderCategory']['id'];?>" class="sub-cat"><?php echo $value['OrderCategory']['order_description']; ?></span>
													<?php 
														}
													}else{
												?>
												<li>&nbsp;</li>
												<?php } ?>
											</ul>
										</li>
								
							</ul>							 
							
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" style="width:80%;">
				 
				<div class="obj" id="excelArea">
					
			    </div>
			 </td>
		</tr>
    </tbody>
</table></div> -->
<div style="float:left; width:100%">
<table border="0" class="table_format" cellpadding="0" cellspacing="0"
	width="100%">

	<tr class="row_title">

		<td class="table_cell" width="10%"><strong><?php echo __(''); ?> </strong>
		</td>
		<td class="table_cell" width="30%"><strong><?php echo __('Component');?>
		</strong>
		</td>
		<td class="table_cell" width="30%"><strong><?php echo  __('Details'); ?>
		</strong>
		</td>
	</tr>
	<?php 
	
	echo $this->Form->hidden('id',array('value'=>$id,'id'=>"patient_id"));//debug($getMultiOrderData);
	foreach($getMultiOrderData as $datas){
	?>
	<tr class="row_title">
		<td class="table_cell" width="30%" colspan='4'><strong><?php echo $datas['OrderCategory']['order_description'];?>
		</strong>
	</tr>
	<?php  foreach ($datas['OrderSubcategory'] as $key=>$subData){?>
	<tr class="">
		<?php echo $this->Form->hidden('subCategory_id',array('value'=>$subData["id"],'id'=>'subCategory_id'));?>
		<td class="table_cell" width="10%"><strong><?php echo $this->Form->checkbox('checkSataus',array('id'=>$subData['id'],'name'=>'data[PatientOrder][multipleorder][]',
				'value'=>$datas['PatientOrder']['name'].'_'.$datas['PatientOrder']['sentence'],'checked'=>'checked','hiddenField'=>false,'class'=>'checkStatus')) ; ?>
		<td class="table_cell" width="10%"><strong><?php echo $this->Html->image('/img/icons/calendar.png',array('alt' => 'ordreset'));?>
				<?php echo $subData['name'];?>
			 <?php //echo $patient_id?><?php //echo $setdatas['PatientOrder'][$i]['id']?><?php //echo $setdatas[PatientOrder][$i][type]?>
						
		</strong>
		</td>
		<?php echo $this->Form->hidden('',array('name'=>'patientId','value'=>$patient_id));?>
		<?php echo $this->Form->hidden('',array('name'=>'conponentName[]','class'=>$subData['id'],
				'value'=>$datas['OrderDataMaster'][$key]["id"]."|".$subData["order_category_id"]."|".$subData["name"]."|".$datas['OrderCategory']['order_description']."|".$subData['order_sentence']));?>
		<td class="table_cell" width="30%"><strong><?php echo $subData['order_sentence'];?> </strong>
		</td>
		
	</tr>
	<?php }}?>
	<tr>
			<td id="formdisplayid" colspan="5" style="margin-top: 10px"></td>
	</tr>
	<?php  //echo $this->Form->hidden(alldata,array('value'=>$id.$datas['PatientOrder']['order_category_id'].$datas['PatientOrder']['name'].$datas['PatientOrder']['status'].$datas['PatientOrder']['sentence'].'isMulti','id'=>'myData'));}?>
	<tr>
		<td align="right" style="padding-right: 10px; padding-top: 10px"
			colspan="4"><input class="blueBtn" type="submit" value="Submit"
			id="submit">
		</td>
	</tr>
</table></div>
<?php echo $this->Form->end(); ?>
<script>	
		$('.checkStatus').click(function (){
			var thisId = $(this).attr('id'); 
			if($(this).prop('checked')){
				 $( "."+thisId ).prop( "disabled", false );
			}else{
				 $( "."+thisId ).prop( "disabled", true );
			}
			});
	$('#submit').click(function(){	
		 var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "index","admin" => false)); ?>";
			var updateFlag=1;
		   var formData = $('#multipleorderindex').serialize();
	         $.ajax({	
	        	 beforeSend : function() {
	        		// this is where we append a loading image
	        		$('#busy-indicator').show('fast');
	        		},
	        		                           
	          type: 'POST',
	          url: ajaxUrl,
	          data: formData,
	          dataType: 'html',
	          success: function(data){
		        
		        var splitedId=data.split('_');	
		        	
		      	 $('#busy-indicator').hide('fast');	        	
	        	  if(splitedId['0']==1){	        		  
	        		window.location.href="<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "orders")); ?>" +"/"+<?php echo $patient_id;?>+"/null/"+splitedId['1']+"?Preview=preview&noteId="+splitedId['2']
					}
			},
				error: function(message){
					alert("Error in Retrieving data");
	          }        });
	    
	    return false;	
	});
function add(){
	//2169/33/2382/Chloroguanide
	var ismultiple=0;
	var formdata = $('#multipleorderindex').serialize();
	$
	.fancybox({
		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'ajax',
	    
	    ajax : { 
	  	  type : "POST", 
	  	  url: ajaxUrl,
	  	  data : "pawan="+$('#myData').val(), 
	  	  success : function(data){
	  	   // do something on success
	  	  } 
	  	 }
	});
}
// to display the form which are clicked on
function display_formdisplay(patient_id,id,order_category_id,name,order_description){//patient_id,patient_order_id,patient_order_type

	  var ajaxUrl = "<?php echo $this->Html->url(array("controller" => "MultipleOrderSets", "action" => "displayorderform","admin" => false)); ?>"+"/"+patient_id+"/"+id+"/"+order_category_id+"/"+name+"/"+order_description;
	   var formData = $('#patientnotesfrm').serialize();
         $.ajax({	
        	 beforeSend : function() {
        		// this is where we append a loading image
        		$('#busy-indicator').show('fast');
        		},
        		                           
          type: 'POST',
         url: ajaxUrl+"/"+patient_id+"/"+id+"/"+order_category_id+"/"+name+"/"+order_description,
          data: formData,
          dataType: 'html',
          success: function(data){
        	  $('#busy-indicator').hide('fast');	
	        	$("#formdisplayid").html(data);
	        
	        
          },
			error: function(message){
				alert("Error in Retrieving data");
          }        });
    
    return false; 
}
</script>