
<style>
.camp {
	width: 76%;
	background: #ffffd0 !important;
	padding: 10px;
	margin-top: 10px;
	border: solid 1px #DFDB2C;
}

.camp td {
	background: none !important;
}

.headTr {
	background: #dfdb2c;
}
.camp tr:nth-child(2n+1){
	background: #dfdb2c none repeat scroll 0 0 !important;
}
.camp tr:nth-child(2n){
	background: #ffffd0 none repeat scroll 0 0 !important;
}

</style>
<?php if($camp){ 
	$campData=$camp['0']['CampDetail'];
}else{
		$campData=$parent['0']['CampDetail'];
}?>
<div class="inner_title">
	<h3>Camp Participant Details</h3>
	<span><?php echo $this->Html->link('View Patients',array('action'=>'add_camp_participant',$campData['id'],'?'=>'view=view'),
							array('class'=>'blueBtn','escape'=>false));
			echo $this->Html->link('Generate Excel',array('action'=>'add_camp_participant',$campData['id'],'?'=>'excel=excel'),
					array('id'=>'print','class'=>'blueBtn','escape'=>false));
			echo $this->Html->link('Back',array('action'=>'camp_list'),array('escape'=>false,'class'=>'blueBtn'));?>
	</span>
</div>

<table>
	<tr>
		<th>Name Of Camp :</th>
		<th><?php echo ucwords(strtolower($campData['camp_name']));?></th>
	</tr>
	<tr>
		<th>Camp Date :</th>
		<th><?php echo $this->DateFormat->formatDate2Local($campData['camp_date'],Configure::read('date_format'),false)?>
		</th>
	</tr>
</table>
<?php echo $this->Form->create('camp_participants',array('onkeypress'=>"return event.keyCode != 13;",'id'=>'camp_participants'));?>
<table class="camp" cellspacing="0" id="addPatient">
	<tr class="headTr">
		<th>Sr no</th>
		<th>Name of visitor/participants</th>
		<th>Doctor</th>
		<th>Age(in years)</th>
		<th align="center">Sex</th>
		<th>Mobile No</th>
		<th>Address</th>
		<th>Remark</th>
		<th>Ask To Admit</th>
		<th>Add Investigation</th>
		<td>&nbsp;</td>
	</tr>
	<?php  $i=2;?>
	<tr  id="row_1" class="addRows">
		<td>1.</td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[name][]','type'=>'text','class'=>'validate[required,custom[mandatory-enter]] name','id'=>'name_1','div'=>false,'label'=>false));?>
		</td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[doctor_id][]',
						'multiple'=>false,'class'=>'validate[required,custom[mandatory-select]] doctor',
						'options'=>$doctors,'empty'=>'Please Select','style'=>'width: 130px ;',
						'id'=>'doct_1','div'=>false,'label'=>false));
				 // echo $this->Form->input('',array('name'=>'Camp[doctor_name][]','type'=>'text','class'=>'name','id'=>'doct_1','div'=>false,'label'=>false));?>
		</td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[age][]','type'=>'text','id'=>'age_1','div'=>false,
				'class'=>'validate[optional,custom[onlyNumber]]',
				'label'=>false,'style'=>'width:50px'));?>
		</td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[sex][]','id'=>'sex_1','div'=>false,'label'=>false,'legend' => false,'type'=>'radio',
				'options'=>array('male'=>'M','female'=>'F')));?>
		</td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[mobile_no][]','type'=>'text','id'=>'mobile_1','div'=>false,
				'class'=>'validate[optional,custom[onlyNumber]]',
				'label'=>false,'maxlength'=>'10'))?>
		</td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[address][]','type'=>'textarea','rows'=>'1','cols'=>'10',
				'id'=>'addr_1','div'=>false,'label'=>false,'style'=>'width: 150px; height: 13px;'))?>
		</td>		
		<td><?php echo $this->Form->input('',array('name'=>'Camp[remark][]','id'=>'remark_1','type'=>'textarea','rows'=>'1','cols'=>'10',
				'div'=>false,'label'=>false,'style'=>'width: 150px; height: 13px;'))?>
		</td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[admit_chk][]','id'=>'admit_1','type'=>'checkbox',
				'class'=>'admit',
				'div'=>false,'label'=>false));?></td>
		<td><?php echo $this->Form->input('',array('name'=>'Camp[invttxt][]','id'=>'txt_1','type'=>'text','class'=>'service',
				'div'=>false,'label'=>false,'style'=>'width: 150px;'));
		 echo $this->Form->input('',array('name'=>'Camp[invt][]','id'=>'invt_1','type'=>'textarea','rows'=>'1','cols'=>'10',
				'div'=>false,'label'=>false,'style'=>'width: 150px; height: 43px;'))?></td>
		<td>&nbsp;</td>
	</tr>	
</table>
<div style="clear: both; padding-top: 10px;">
	<?php echo $this->Html->link('Add More Partcipants','javascript:void(0)',array('escape'=>false,'class'=>'blueBtn addMorePatient'));
	echo '&nbsp;&nbsp;'.$this->Form->button('Submit',array('id'=>'submit','class'=>'blueBtn','div'=>false));
	echo $this->Form->end();?>
</div>

<script>
$(document).ready(function(){
	$('form').validationEngine();	
});
$(document).on('click','.addMorePatient', function() { 
	if(count<=20){
		addMorePatientHtml();
	}else{
		alert("You can enter only 30 patients at time");
	}
});
$(document).on('focus','.service',function(){
//$('.service').focus(function(){
	var id=$(this).attr('id');
	var splitId=id.split('_')[1];
	$(this).autocomplete({
	    source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "combineServices", "admin" => false, "plugin" => false)); ?>",
	    setPlaceHolder : false,
	    select: function(event,ui){	        
	        $('#invt_'+splitId).val( $('#invt_'+splitId).val()+','+ui.item.value);
	       $(this).val('').focus();
	        return false ;	
	    },
	    messages: {
	        noResults: '',
	        results: function() {}
	    }
	});
});
var count="<?php echo $i?>";
var sexType = $.parseJSON('<?php echo json_encode(array('male'=>'Male','female'=>'Female'));?>');
var doctors = $.parseJSON('<?php echo json_encode($doctors);?>');
function addMorePatientHtml(){
	$("#addPatient")
			.append($('<tr>').attr({'id':'row_'+count,'class':'addRows'})
				.append($('<td>').append(count+'.'))
			    .append($('<td>').append($('<input>').attr({'id':'name_'+count,'class':'validate[required,custom[mandatory-enter]] name ','type':'text','name':'data[Camp][name][]','autocomplete':'off'})))
			    .append($('<td>').append($('<select>').attr({'id':'doct_'+count,'style':'width: 130px;','class':'validate[required,custom[mandatory-select]] doctor ','type':'text','name':'data[Camp][doctor_id][]','autocomplete':'off'})))
				.append($('<td>').append($('<input>').attr({'id':'age_'+count,'autocomplete':'off','type':'text','class':'validate[optional,custom[onlyNumber]]','style':'width:50px','name':'data[Camp][age][]'})))
				//.append($('<td>').append($('<select>').attr({'id':'sex_'+count,'class':'validate[required,custom[mandatory-select]] ','autocomplete':'off','name':'data[Camp][sex][]'})))
				.append($('<td>').append($('<input>').attr({'id':'Sex'+count+'Male','autocomplete':'off','type':'radio','value':'male','name':'data[Camp][sex]['+count+']'}))
								 .append('M')
								 .append($('<input>').attr({'id':'Sex'+count+'Female','autocomplete':'off','type':'radio','value':'female','name':'data[Camp][sex]['+count+']'}))
								 .append('F'))
								// .append($('<input>').attr({'id':'Sex'+count+'Female','autocomplete':'off','type':'radio','value':'female','name':'data[Camp][sex][]'}+'F')))
				.append($('<td>').append($('<input>').attr({'id':'mobile_'+count,'type':'text','name':'data[Camp][mobile_no][]','class':'validate[optional,custom[onlyNumber]]','maxlength':'10','autocomplete':'off'})))
				.append($('<td>').append($('<textarea>').attr({'id':'addr_'+count,'rows':'1','cols':'10','style':'width: 150px; height: 13px;','autocomplete':'off','type':'text','name':'data[Camp][address][]'})))
				.append($('<td>').append($('<textarea>').attr({'id':'remark_'+count,'rows':'1','style':'width: 150px; height: 13px;','autocomplete':'off','cols':'10','type':'text','name':'data[Camp][remark][]'})))
				.append($('<td>').append($('<input>').attr({'id':'admit_'+count,'class':'admit ','type':'checkbox','name':'data[Camp][admit_ckh][]','autocomplete':'off'})))
				.append($('<td>').append($('<input>').attr({'id':'txt_'+count,'autocomplete':'off','type':'text','class':'service','name':'data[Camp][txt]['+count+']'}))
								 .append($('<textarea>').attr({'id':'invt_'+count,'rows':'1','style':'width: 150px; height: 43px;','autocomplete':'off','cols':'10','type':'text','name':'data[Camp][invt][]'})))
				.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
				                 .attr({'class':'removePatient','id':'removePatient_'+count,'title':'Remove current row'}).css('float','left')))
		);
		//add options to doctors
		 var $options = $("#doct_1 > option").clone();
		 $('#doct_'+count).empty(); $('#doct_'+count).append($options);
		 $('#name_'+count).focus();
		count++;		
	 }

$(document).on('click','.removePatient', function() {
	if($('.camp').find('tr').length>=2){	
		currentId=$(this).attr('id');
		splitedId=currentId.split('_');
		ID=splitedId['1'];
		$("#row_"+ID).remove();
	}else{
		alert("You cannot delete this row!Record must contain atleast one record.");
	}
			
});

$(document).on('keypress','.name', function(e) {
	if(e.keyCode==13){//key enter
		if(count<=20){
			 setTimeout(addMorePatientHtml(),2000);
		}else{
			alert("You can enter only 20 patients at time");
		}	    
	}
});


//spot implant payment
$(".invest_form").click(function(){ 
 	  
	 //patientID='<?php echo $patientID;?>';
	 //appoinmentID='<?php echo $appoinmentID;?>';
	 $.fancybox({ 
		 	'width' : '50%',
			'height' : '100%',
			'autoScale' : true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'showCloseButton':true,
			'onClosed':function(){
			},
			'helpers'   : { 
		    	   'overlay' : {closeClick: false}, // prevents closing when clicking OUTSIDE fancybox 
		    },
			'href' : "<?php echo $this->Html->url(array("action" =>"investigation_form","admin"=>false)); ?>",
	 });
	 $(document).scrollTop(0);
 });


</script>
