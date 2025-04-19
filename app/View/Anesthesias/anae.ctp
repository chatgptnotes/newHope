<style>
.a{
	 text-align: center;
}

textarea{
	width: 433px !important ;
	height :35px;
}
</style>
<?php
if($action=='print' && !empty($lastId)){
	echo "<script>var openWin = window.open('".$this->Html->url(array('action'=>'anae_print',$this->request->params['pass'][0],$this->request->params['pass'][1]))."', '_blank',
                       'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=600,left=200,top=200'); </script>"  ;
}
?>
  
	<div class="inner_title"><h3 class="a">ANAESTHESIA NOTES</h3>

	</div>
<?php  //$anaedata=$this->data;
echo $this->Form->create('anaeSearch',array('id'=>'anaeSearch','inputDefaults'=>array('label'=>false,'div'=>false)));
?>
<table>
	<tr>
  <?php if($this->params->isAjax!='1'){?>
		<td>Patient Name</td><td><?php 
		echo $this->Form->input('patient_name',array('type'=>'text','id'=>'pat_name',
													'div'=>false,'label'=>false));
 		echo $this->Form->hidden('',array('type'=>'text','id'=>'patient_id','name'=>'patient_id',
													'div'=>false,'label'=>false,'value'=>$this->request->params['pass'][0]));?></td>
     <td><?php //echo $this->Html->link('Submit','javascript:void(0);',array('class'=>'blueBtn','id'=>'dSubmit','onclick'=>'submitData();'))?></td>
    <?php }?>
		
	</tr>
</table>

<?php 
	echo $this->Form->end();
	echo $this->Form->create('anae',array('id'=>'anae','inputDefaults'=>array('label'=>false,'div'=>false)));
	echo $this->Form->hidden('',array('value'=>$patient['Patient']['id'],'type'=>'hidden','name'=>'patient_id'));
	echo $this->Form->input('',array('type'=>'hidden','id'=>'surgery_id','name'=>'surgery_id',
			'div'=>false,'label'=>false,'value'=>$this->request->params['pass'][1]));
?>

<div style="float: right;">
<?php 
      echo $this->Html->link('Print','javascript:void(0);',array('class'=>'blueBtn','onclick'=>'printOA();'))
    ?>
    </div>
<table  width="100%" border="0px" class="table_format">
<tr>
    <td> Surgery :<font color="red">*</font></td>
    <td colspan="5">
      <?php 
        if(isset($returnArray)){
            echo $this->Form->hidden('id',array('id'=>'anaeid'));
            echo $this->Form->input('surgeryname',array('type'=>'select','id'=>'surgery_name1','empty'=>'Please Select','options'=>$returnArray,'div'=>false,'label'=>false));
        }else{
            echo $this->Form->input('surgeryname',array('type'=>'select','id'=>'surgery_name11','empty'=>'Please Select',
            'div'=>false,'label'=>false ));
        }
        
     ?></td>
  </tr>
<tr>
        <td width="20%">Date/Time</td>
       <td><?php echo $this->Form->input('anae_date',array('type'=>'text',
							'id'=>"anae_date",'label'=>false,'div'=>false,'style'=>'float:left','readonly'=>'readonly',
							'class'=>'validate[required,custom[mandatory-date]] anae_date textBoxExpnd',
							'value'=>$this->DateFormat->formatDate2Local($otList['OptAppointment']['schedule_date'],Configure::read('date_format')).' '.$otList['OptAppointment']['start_time']));?></td>
	  <td>Dept</td> <td>
	<?php   echo $department['Department']['name']." / ".$wardInfo['Ward']['name']; ?>
	  </td>
	  
	

	  <td>Wt</td><td><?php echo $this->Form->input(' ', array('type'=>'text','value'=>$anaedata['AnaesthesiaNote']['weight']
	  		,'name'=>"weight",'id' => "wt",'div'=>false,'label'=>false)); ?></td>

   
  </tr>
 <tr>
   <td >Name Of Patient</td>
   <td><?php echo $this->Form->input('lookup_name',array('value'=>$patientDetailsForView['Patient']['lookup_name'],'type'=>'text','class'=>'textBoxExpnd'));?></td>
   
   <td> Age</td><td><?php echo  $patientDetailsForView['Patient']['age']; ?></td>
  
  <td>Sex</td><td> <?php echo  ucfirst($patientDetailsForView['Patient']['sex']) ; ?></td>
  
    
  </tr>
  <tr>

    <td>Surgeon</td>
    <td><table width="100%" border="0" >
    <tr>
     <td>(1) <?php echo $surgeon =$MuraliData['DoctorProfile']['doctor_name']?></td>
    </tr>
    <tr>
    	 <td colspan="4"> (2)  <?php echo $this->Form->input(' ', array('type'=>'text','name'=>"surgeon2",'id' => "surgeon2",'div'=>false,'label'=>false,'value'=>$anaedata['AnaesthesiaNote']['surgeon2'],)); ?></td>
   	</tr>
    	</table>
    
    </td>
     <td colspan="1">Anaethesiologists </td> 
     <td><?php 
		     $anaesthesist = 'Dr. '.$otList['AnaeUser']['first_name']." ".$otList['AnaeUser']['last_name'];
		     if(empty($otList['AnaeUser']['first_name'])){
		     	$anaesthesist=$anaedata['AnaesthesiaNote']['anaethesiologists'];
		     }

     
		    
    	     echo $this->Form->input(' ', array('type'=>'text','name'=>"anaethesiologists",'id' =>"anaethesiologists",
		     		'value'=>$anaesthesist,'class'=>'textBoxExpnd')); 

     
     	?></td>
  		<td colspan="2"></td>
	  </tr>

  
  <tr>
  	<td>Name of Procedure</td>
		<td><?php //debug($anaedata['AnaesthesiaNote']);
			echo $this->Form->input(' ',array('name'=>'procedure_name','type'=>'text','class'=>'textBoxExpnd',
						'value'=>$_SESSION['packName']));?></td>
			
   
   
			<td> Consent</td>
				<td>
					 <?php echo $this->Form->input('',array('type'=>'select','empty'=>'Please Select','options'=>array('yes' => 'Yes','no' => 'No'),'value'=>$anaedata['AnaesthesiaNote']['consent'],'legend' => false,'div'=>false,'label'=>false,'name'=>"consent",'class'=>'textBoxExpnd')); ?>
				</td> 
			<td colspan="2"></td>
	<tr>	
    

   <td>ASA Grade </td><td><?php echo $this->Form->input(' ', array('type'=>'text','value'=>$anaedata['AnaesthesiaNote']['asa_grade'],
   		'name'=>"asa_grade",'id' => "asa_grade",'div'=>false,'label'=>false)); ?></td>

     <td>NBM Since</td><td><?php echo $this->Form->input(' ', array('type'=>'text','name'=>"nbm_since",'value'=>$anaedata['AnaesthesiaNote']['nbm_since'],
     		'id' => "nbm_since",'div'=>false,'label'=>false)); ?></td>
  <td colspan="2"></td>
  </tr>
</table>
<table  width="100%" border="0px" class="table_format">
	<tr>
    	<td width="17%">
        		Past Illness   
            </td>
            <td>


                 <?php echo $this->Form->textarea(' ', array('type'=>'textarea','name'=>"past_illness",'value'=>$anaedata['AnaesthesiaNote']['past_illness'],'id' => "past_illness" )); ?></td>
	 </tr>
   	 <tr>
    		<td>
        		Past Anaesthetics 
            </td>

           <td><?php echo $this->Form->textarea(' ', array('type'=>'textarea','name'=>"past_anaesthetics",'value'=>$anaedata['AnaesthesiaNote']['past_anaesthetics'],'id' => "past_anaesthetics" )); ?></td>
    </tr>
    <tr>
    	<td>
        	Pre - Op condition
         </td>

       <td><?php echo $this->Form->textarea(' ', array('type'=>'textarea','name'=>"pre_opcondition",'value'=>$anaedata['AnaesthesiaNote']['pre_opcondition'],'id' => "pre_opcondition" )); ?></td> 

    </tr>
     <tr>
    	<td>
        	Mallampatti Grade 
         </td>

         <td><?php echo $this->Form->textarea(' ', array('type'=>'textarea','name'=>"mallampatti_grade",'value'=>$anaedata['AnaesthesiaNote']['mallampatti_grade'],'id' => "mallampatti_grade" )); ?></td>

         

    </tr>
    <tr>
    	<td>
        	Investigations
         </td>

         <td><?php echo $this->Form->textarea(' ', array('type'=>'textarea','name'=>"investigations",'value'=>$anaedata['AnaesthesiaNote']['investigations'],'id' => "investigations"  )); ?></td>

           
    </tr>
    <tr>
    	<td>&nbsp;</td>
            <td>&nbsp;</td>
    </tr> 
</table>
<table  width="100%" border="0px" class="table_format">
  <tr>
    <th scope="col">Pre Medication</th>
  </tr>

  <tr>
    <td width="100%" valign="top">
        <table width="100%" border="0px"> 
          <tr> 
            	<td>Time</td>
            	 <td><?php echo $this->Form->input('',array('name'=>'pre_med_time','type'=>'text',
							'id'=>"time",'label'=>false,'div'=>false,'style'=>'float:left','readonly'=>'readonly',
							'class'=>'validate[required,custom[mandatory-date]] anae_date',
							'value'=>!empty($anaedata['AnaesthesiaNote']['time'])?$this->DateFormat->formatDate2Local($anaedata['AnaesthesiaNote']['time'],Configure::read('date_format'),true):date('d/m/Y H:i:s')));?></td>
          </tr>
           <tr> 

            	<td>Drug </td>
            	<td><?php echo $this->Form->textarea(' ', array('type'=>'textarea','name'=>"pre_med_drug",'value'=>$anaedata['AnaesthesiaNote']['pre_med_drug'],'id' => "local_stand",'div'=>false,'label'=>false)); ?></td> 	
	      </tr>
    	</table>
	</td>
  </tr>
</table>
<table  width="100%" border="0px" class="table_format">
  <tr>
   <th scope="col" align="left">Type Of Anaesthesia</th>
  </tr>
  <tr>
    <td width="100%" valign="top">
      <table width="100%" border="0px" >
            <tr>
              <td>Type Of Anaesthesia</td>
            <td><?php 
            $general=isset($loadData['AnaesthesiaNote']['general'])?$loadData['AnaesthesiaNote']['general']:"";

              $induction=isset($loadData['AnaesthesiaNote']['induction'])?$loadData['AnaesthesiaNote']['induction']:"";
              $type1=isset($loadData['AnaesthesiaNote']['type1'])?$loadData['AnaesthesiaNote']['type1']:"";
              
              $ettno=isset($loadData['AnaesthesiaNote']['ettno'])?$loadData['AnaesthesiaNote']['ettno']:"";
              $on=isset($loadData['AnaesthesiaNote']['on'])?$loadData['AnaesthesiaNote']['on']:"";
              
              $relaxation=isset($loadData['AnaesthesiaNote']['relaxation'])?$loadData['AnaesthesiaNote']['relaxation']:"";
              $type=isset($loadData['AnaesthesiaNote']['type'])?$loadData['AnaesthesiaNote']['type']:"";
              
              $gases=isset($loadData['AnaesthesiaNote']['gases'])?$loadData['AnaesthesiaNote']['gases']:"";
              $reversal=isset($loadData['AnaesthesiaNote']['reversal'])?$loadData['AnaesthesiaNote']['reversal']:"";
              
              $agent=isset($loadData['AnaesthesiaNote']['agent'])?$loadData['AnaesthesiaNote']['agent']:"";
              $extubatoin=isset($loadData['AnaesthesiaNote']['extubatoin'])?$loadData['AnaesthesiaNote']['extubatoin']:"";
              echo $this->Form->input(' ',array('name'=>"general",'empty'=>"Please Select",'options'=>array('General','Regional','Narve Blocks','Local / Stand - By'),'id' => "generalAna",'div'=>false,'label'=>false,'value'=>$general)); ?>
            </td>
          </tr>
          <tr id="GA1" style="display:none;">
            <td colspan="2">
            <table width="100%" border="0px">
              <tr>
                <td colspan="4"><b>General Anaesthesia</b></td>
              </tr>
              <tr>
                <td>Induction</td>
                <td><?php echo $this->Form->input('induction',array('class'=>'textBoxExpnd','value'=>$induction,'id'=>'induction'));?></td>
                <td>Type</td>
                <td><?php echo $this->Form->input('type1',array('class'=>'textBoxExpnd','value'=>$type1,'id'=>'type1'));?></td>
              </tr>
              <tr>
                <td>ETT No</td>
                <td><?php echo $this->Form->input('ettno',array('class'=>'textBoxExpnd','value'=>$ettno,'id'=>'ettno'));?></td>
                <td>Oral/Nasal</td>
                <td><?php echo $this->Form->input('on',array('class'=>'textBoxExpnd','value'=>$on,'id'=>'on'));?></td>
              </tr>
              <tr>
                <td>Relaxation</td>
                <td><?php echo $this->Form->input('relaxation',array('class'=>'textBoxExpnd','value'=>$relaxation,'id'=>'relaxation'));?></td>
                <td>Ventilation</td>
                <td><?php echo $this->Form->input('ventilation',array('class'=>'textBoxExpnd','value'=>$type,'id'=>'ventilation'));?></td>
              </tr>
              <tr>
                <td>Gases</td>
                <td><?php echo $this->Form->input('gases',array('class'=>'textBoxExpnd','value'=>$gases,'id'=>'gases'));?></td>
                <td>Reversal</td>
                <td><?php echo $this->Form->input('reversal',array('class'=>'textBoxExpnd','value'=>$reversal,'id'=>'reversal'));?></td>
              </tr>
              <tr>
                <td>Inhalational agent</td>
                <td><?php echo $this->Form->input('agent',array('class'=>'textBoxExpnd','value'=>$agent,'id'=>'agent'));?></td>
                <td>Extubatoin</td>
                <td><?php echo $this->Form->input('extubatoin',array('class'=>'textBoxExpnd','value'=>$extubatoin,'id'=>'extubatoin'));?></td>
              </tr>
            </table>
          </td>
            </tr>
          <tr id="RN1" style="display:none;">
              <td colspan="2">
          <table width="100%" border="0px">
            <?php 
              $anaedata=$loadData;
            ?>
            <tr>
              <th colspan="5" style="text-align: left;">Regional / Nerve Block</th>
              
            </tr>
             <tr>

              <td>Type</td>
               <td><?php echo $this->Form->input('type', array('type'=>'text','name'=>"type",'value'=>$anaedata['AnaesthesiaNote']['type'],'id' => "type")); ?></td>

            

              <td width="12%">Onset</td>
            <td ><?php echo $this->Form->input('onset', array('type'=>'text','name'=>"onset",'value'=>$anaedata['AnaesthesiaNote']['onset'],'id' => "onset")); ?></td>

            </tr>
            <tr>

              <td>Needle </td>
              <td><?php echo $this->Form->input('needle', array('type'=>'text','name'=>"needle",'value'=>$anaedata['AnaesthesiaNote']['needle'],'id' =>"needle")); ?></td>
              <td>Level</td>
             <td><?php echo $this->Form->input('level', array('type'=>'text','name'=>"level",'value'=>$anaedata['AnaesthesiaNote']['level'],'id' => "level")); ?></td>

            </tr>
            <tr>

              <td>Space</td>
             <td><?php echo $this->Form->input('space', array('type'=>'text','name'=>"space",'value'=>$anaedata['AnaesthesiaNote']['space'],'id' =>"space")); ?></td>
              <td>Duration </td>
              <td><?php echo $this->Form->input('duration', array('type'=>'text','name'=>"duration",'value'=>$anaedata['AnaesthesiaNote']['duration'],'id' => "duration")); ?></td>

            </tr>
            <tr>

              <td>Drug</td>
              <td><?php echo $this->Form->input('regional_drug', array('type'=>'text','name'=>"regional_drug",'value'=>$anaedata['AnaesthesiaNote']['regional_drug'],'id' => "drug")); ?></td>
              <td>Recovery</td>
              
              
                     <td><?php echo $this->Form->input('recovery', array('type'=>'text','name'=>"recovery",'value'=>$anaedata['AnaesthesiaNote']['recovery'],'id' => "recovery ",'div'=>false,'label'=>false)); ?></td>
              
            </tr>
            <tr>

              <td>Volume</td>
             <td><?php echo  $this->Form->input('volume', array('type'=>'text','name'=>"volume",'value'=>$anaedata['AnaesthesiaNote']['volume'],'id' => "volume")); ?></td>
              <td>Top - up</td>
             <td><?php echo $this->Form->input('top_up', array('type'=>'text','name'=>"top_up",'value'=>$anaedata['AnaesthesiaNote']['top_up'],'id' => "top_up")); ?></td>

            </tr>
          </table>
              </td>
            </tr>
            <tr id="LS1" style="display:none;">
              <td colspan="2">
          <table width="100%" border="0px">
            <tr>
              <th colspan="5" style="text-align: left;">Local / Stand -By</th>
            </tr>
            <tr>
              <td>Local / Stand -By</td>
              <td><?php echo $this->Form->input('local', array('type'=>'text','name'=>"local",'value'=>$anaedata['AnaesthesiaNote']['local'],'id' => "local")); ?></td>
            </tr>
          </table>
        </td>
      </tr>

            
        </table> 
    </td>
  </tr>
</table>
<table width="100%" border="0px" class="table_format">
  <tr>
		<td colspan="6" class="a">
		<?php echo $this->Form->submit('Submit',array('id'=>'submit','class'=>'blueBtn','style'=>'float:right'));
			  echo $this->Form->end();?>
			 
		</td>
	</tr>
</table>
 
<script>
$(document).ready(function(){
	$('#dSubmit').hide();
  var general ="<?php echo $general?>";
  if(general!=""){
    if(general==0){
      $('#GA1').fadeIn();
      $('#RN1').fadeOut();
      $('#LS1').fadeOut();
    }else if(general==1 || general==2){
      $('#GA1').fadeOut();
      $('#RN1').fadeIn();
      $('#LS1').fadeOut();
    }else if(general==3){
      $('#GA1').fadeOut();
      $('#RN1').fadeOut();
      $('#LS1').fadeIn();
    }else{
      $('#GA1').fadeOut();
      $('#RN1').fadeOut();
      $('#LS1').fadeOut();
    }
  }
});


$("#anae_date").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	defaultDate: "+1w",				 
	dateFormat:'dd/mm/yy',	
	//maxDate : 0,//new Date(year,month,0),
	onSelect:function(selectedDate){
		//$("#contrast_reaction").validationEngine("hideAll");
		
    	
    }
});
$("#time").datepicker({
	showOn: "both",
	buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
	buttonImageOnly: true,
	changeMonth: true,
	changeYear: true,
	yearRange: '1950',
	defaultDate: "+1w",				 
	dateFormat:'dd/mm/yy HH:II:SS',	
	//maxDate : 0,//new Date(year,month,0),
	onSelect:function(selectedDate){
		//$("#contrast_reaction").validationEngine("hideAll");
		
    	
    }
});
$("#pat_name").autocomplete({
	source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete",'IPD',"admin" => false,"plugin"=>false)); ?>",
	select: function(event,ui){	
		$( "#patient_id" ).val(ui.item.id);
		 
		var patientId=ui.item.id; 
			//send ajax request
			  $.ajax({
			      url: "<?php echo $this->Html->url(array("controller" => 'OptAppointments', "action" => "surgeryAutocomplete", "admin" => false)); ?>"+"/"+patientId,
			      context: document.body,          
			      success: function(data){ 
			    	  $('#dSubmit').show();
			    	 $("#surgery_name1 option").remove(); 
				     data= $.parseJSON(data);
				     $.each(data, function(val, text) {
					    $("#surgery_name1").append( "<option value='"+text.id+"'>"+text.value+"</option>" );
					 }); 
		       }
			});
					
},
 messages: {
     noResults: '',
     results: function() {},
},

});

$('#surgery_name1').change(function(){
  if($('#surgery_name1').val()!=''){
    submitData1();
  }else{
    return false;
  }
});

function submitData1(){
	var patientId=$( "#patient_id" ).val();
	var optApptId=$( "#surgery_name1" ).val();	
	var url="<?php echo $this->Html->url(array('controller' => 'Anesthesias', 'action' => 'anae_ajx')); ?>/"+patientId+"/"+optApptId;
  var cnd='<?php echo $this->params->isAjax ?>';
  if(cnd=='1'){
    $.ajax({
      type: 'POST',
      url: url,
      dataType: 'html',
      beforeSend : function() {
              $('#busy-indicator').show('fast');
          },
      success: function(Anae){
            Anae= $.parseJSON(Anae);
            if(Anae['id'] !='' && Anae['id']!=null){
              $('#anaeid').val(Anae['id']);
            if(Anae['general']==0){
              $('#generalAna').val('0');
              $('#generalAna').trigger('change');
            }else if(Anae['general']==1){
              $('#generalAna').val('1');
              $('#generalAna').trigger('change');
            }
            else if(Anae['general']==2){
              $('#generalAna').val('2');
              $('#generalAna').trigger('change');
            }
            else if(Anae['general']==3){
              $('#generalAna').val('3');
              $('#generalAna').trigger('change');
            }
          $('#anae_date').val(Anae['anae_date']);
          $("#induction").val(Anae['induction']);
          $("#ventilation").val(Anae['ventilation']);
          $("#type1").val(Anae['type1']);
          $("#ettno").val(Anae['ettno']);
          $("#on").val(Anae['on']);
          $("#relaxation").val(Anae['relaxation']);
          $("#gases").val(Anae['gases']);
          $("#reversal").val(Anae['reversal']);
          $("#agent").val(Anae['agent']);
          $("#dept").val(Anae['dept']);
          $("#surgeon1").val(Anae['surgeon1']);
          $("#wt").val(Anae['weight']);
          $("#surgeon2").val(Anae['surgeon2']);
          $("#pre_med_time").val(Anae['pre_med_time']);
          $("#local_stand_by").val(Anae['local_stand_by']);
          $("#top_up").val(Anae['top_up']);
          $("#anaethesiologists").val(Anae['anaethesiologists']);
          $("#procedure_name").val(Anae['procedure_name']);
          $("#consent").val(Anae['consent']);
          $("#asa_grade").val(Anae['asa_grade']);
          $("#nbm_since").val(Anae['nbm_since']);
          $("#past_illness").val(Anae['past_illness']);
          $("#past_anaesthetics").val(Anae['past_anaesthetics']);
          $("#pre_opcondition").val(Anae['pre_opcondition']);
          $("#mallampatti_grade").val(Anae['mallampatti_grade']);
          $("#investigations").val(Anae['investigations']);
          $("#local_stand").val(Anae['pre_med_drug']);
          $("#recovery").val(Anae['recovery']);
          $("#narve_blocks").val(Anae['narve_blocks']);
          $("#type").val(Anae['type']);
          $("#space").val(Anae['space']);
          $("#volume").val(Anae['volume']);
          $("#onset").val(Anae['onset']);
          $("#level").val(Anae['level']);
          $("#duration").val(Anae['duation']);
          $("#needle").val(Anae['needle']);
          $("#regional_drug").val(Anae['regional_drug']);
          $("#re_epidural").val(Anae['re_epidural']);
          $("#re_spinal").val(Anae['re_spinal']);
          $("#re_combined").val(Anae['re_combined']);
          $("#agent1").val(Anae['agent1']);
          $("#extubatoin").val(Anae['extubatoin']);
          $("#local").val(Anae['local']);  
            }else{
              $('#anaeid').val("");

          $('#anae_date').val('');
          $("#induction").val('');
          $("#ventilation").val('');
          $("#type1").val('');
          $("#ettno").val('');
          $("#on").val('');
          $("#relaxation").val('');
          $("#gases").val('');
          $("#reversal").val('');
          $("#agent").val('');
          $("#dept").val('');
          $("#surgeon1").val('');
          $("#wt").val('');
          $("#surgeon2").val('');
          $("#pre_med_time").val('');
          $("#local_stand_by").val('');
          $("#top_up").val('');
          $("#anaethesiologists").val('');
          $("#procedure_name").val('');
          $("#consent").val('');
          $("#asa_grade").val('');
          $("#nbm_since").val('');
          $("#past_illness").val('');
          $("#past_anaesthetics").val('');
          $("#pre_opcondition").val('');
          $("#mallampatti_grade").val('');
          $("#investigations").val('');
          $("#local_stand").val('');
          $("#recovery").val('');
          $("#narve_blocks").val('');
          $("#type").val('');
          $("#space").val('');
          $("#volume").val('');
          $("#onset").val('');
          $("#level").val('');
          $("#duration").val('');
          $("#needle").val('');
          $("#regional_drug").val('');
          $("#re_epidural").val('');
          $("#re_spinal").val('');
          $("#re_combined").val('');
          $("#agent1").val('');
          $("#extubatoin").val('');
          $("#local").val('');
            }
            
            $('#busy-indicator').hide('fast');
      },
      error: function(message){
      },
    });
  }else{
    window.location=url;
  }
	
}

$('#surgery_name1').change(function(){
  $('#dSubmit').show();

});
$('#generalAna').change(function(){
  var showOpt=$('#generalAna').val();
  if(showOpt==0){
    $('#GA1').fadeIn();
    $('#RN1').fadeOut();
    $('#LS1').fadeOut();
  }else if(showOpt==1 || showOpt==2){
    $('#GA1').fadeOut();
    $('#RN1').fadeIn();
    $('#LS1').fadeOut();
  }else if(showOpt==3){
    $('#GA1').fadeOut();
    $('#RN1').fadeOut();
    $('#LS1').fadeIn();
  }else{
    $('#GA1').fadeOut();
    $('#RN1').fadeOut();
    $('#LS1').fadeOut();
  }

});
function printOA(){
  if($('#surgery_name1').val()==''){
    alert('Please Select Surgery.');
    return false;
  }else{
   var url="<?php echo $this->Html->url(array('controller' => 'Anesthesias', 'action' => 'anae_print')); ?>"+"/"+$('#patient_id').val()+"/"+$('#surgery_name1').val()+"?flag=header";
   /*var url="<?php //echo $this->Html->url(array('controller' => 'OptAppointments', 'action' => 'operative_notes_print')); ?>"+"/"+$('#patient_id').val()+"/"+$('#surgery_name').val()+"?flag=header";*/
  }
   window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
  
}

</script>
