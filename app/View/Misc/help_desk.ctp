<?php  echo $this->Html->script(array('inline_msg','jquery.fancybox-1.3.4'));
echo $this->Html->css(array('jquery.fancybox-1.3.4.css','jquery.fancybox-1.3.4.css'));   ?>
<style>
    .labTable {
        width: 100%;
    }

.Tbody {
        width: 100%;  
        display: list-item;
        overflow: auto;
    }

 .tabularForm {
        background-color: none;
    }

.roundClass{
	border-bottom-right-radius:4px;
	border-bottom-left-radius:4px;
	border-top-left-radius:4px;
	border-top-right-radius:4px;
	border:1px solid #4c5e64;
/*	background:none repeat scroll 0 0 rgba(0, 0, 0, 0) !important;*/
	width:90% !important;
}	

label {
        float: left;
        font-size: 13px;
        margin-right: 10px;
        padding-top: 7px;
        text-align: left;
        width: auto !important; 
    }

.tabularForm th{
	margin-top:0px;
	border-top:1px solid #3e474a;
	
}
.dataTables_length {
  margin-bottom:2%;
}

</style>

<div class="inner_title" style="padding: 2px 8px 4px">
    <h3>
		<?php echo __('Help Desk DashBoard', true); ?> 
	</h3>
	<span>
<?php
   echo $this->Html->link(__('Back', true),array('controller' => 'Misc', 'action' => 'index'), array('escape' => false,'class'=>'blueBtn' ));
?>
</span>
    <div class="clr "></div>
</div>
<?php 
echo $this->Form->create('', array('id'=>'helpDsk','type'=>'get','inputDefaults' => array('label' => false, 'div' => false,'error'=>false) ));
?>	

<table width="100%" cellpadding="0" cellspacing="0" border="0"
       class="formFull" align="center" style="padding: 5px; margin: 12px 0 11px">
    <tr>
       <td width="15%">
        <?php echo $this->Form->input('patient_name', array('id' => 'patient_name','label'=> false, 'value'=>'','style'=>'width:90% !important',
        	   'placeholder'=>'Patient Name', 'div' => false,'class'=>'textBoxExpnd  roundClass', 'error' => false,'title'=>'Patient Name','autocomplete'=>"off"));
              echo $this->Form->hidden('patient_id',array('id' =>'patient_id')); ?>
       </td>
       
        <td width="15%">
        <?php echo $this->Form->input('mobile_no', array('id' => 'mobile_no','label'=> false, 'value'=>'','style'=>'width:90% !important','maxLength'=>'10',
        	   'placeholder'=>'Mobile Number', 'div' => false,'class'=>'textBoxExpnd  roundClass', 'error' => false,'title'=>'Mobile Number','autocomplete'=>"off"));
              ?>
       </td>
       
        <td width="15%">
        <?php echo $this->Form->input('city', array('id' => 'city','label'=> false, 'value'=>'','style'=>'width:90% !important',
        	   'placeholder'=>'City', 'div' => false,'class'=>'textBoxExpnd  roundClass', 'error' => false,'title'=>'City','autocomplete'=>"off"));
               ?>
       </td>
       <td>
            <table>
                <tr>
                    <td>
						<?php echo $this->Form->submit(__('Search'),array('class'=>'blueBtn','div'=>false,'label'=>false,'id'=>'search'));?>			
                    </td>
                    <td>
						<?php echo $this->Html->image('icons/eraser.png',array('id'=>'resett','title'=>'Reset'));?>	
                    </td>
                    <!--  <td>
						<?php echo $this->Html->image('icons/print.png',array('id'=>'','title'=>'Print'));?>			
                    </td>-->
                    <td>
						<?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('action'=>'helpDesk'),array('escape'=>false,'title'=>'Reload current page'));?>			
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
 <?php echo $this->Form->end();?>
 <div class="clr "></div>
 
<table border="1" class="tabularForm labTable " cellpadding="1" cellspacing="1" width="100%"  id="dataTab">
	<thead>
		<tr class="" id="" style="overflow: auto;">
			<th align="center" valign="middle" style="text-align: center; width:20%"><?php echo __("Patient Name");?></th>
			<th align="center" valign="middle" style="text-align: center; max-width:10%"><?php echo __("Ward/Room");?></th>
			<th align="center" valign="middle" style="text-align: center; max-width:10%"><?php echo __("Patient ID");?></th>
			<th align="center" valign="middle" style="text-align: center;width:10%"><?php echo __("Mobile No.");?></th> 
			<th align="center" valign="middle" style="text-align: center;width:10%"><?php echo __("City");?></th> 
			<th align="center" valign="middle" style="text-align: center; max-width:10%"><?php echo __("Total Bill");?></th>
			<th align="center" valign="middle" style="text-align: center; width:10%"><?php echo __("Total Deposit");?></th>
			<th align="center" valign="middle" style="text-align: center; width:10%"><?php echo __("Total Discount");?></th>
			<th valign="middle" style="text-align: center; max-width:10%;"><?php echo __("Outstanding Amount");?></th>
			<th valign="middle" style="text-align: center; max-width:10%;"><?php echo __("Registered In Portal");?></th>
		</tr>
	</thead>
  <?php
     if(!empty($patientDetails)){
      foreach ($patientDetails as $key=>$patientData){?>
        <tr>
           <td style="text-align: center;"><?php echo $patientData['Patient']['lookup_name'];?></td>
           <td style="text-align: center;">
           	<?php
	           if($patientData['Patient']['admission_type']=='IPD'){
	           		echo $patientData['Ward']['name']."/".$patientData['Room']['bed_prefix']."".$patientData['Bed']['bedno'];
	           }else{
	           		echo "";
	           }
	          ?>
	      </td>
           <td style="text-align: center;"><?php echo $patientData['Patient']['patient_id'];?></td>
           <td style="text-align: center;"><?php echo $patientData['Person']['mobile'];?></td>
           <td style="text-align: center;"><?php echo ucfirst($patientData['Person']['city']);?></td>
           <td style="text-align: center;"><?php echo $this->Number->currency(round($patientData['total_amount']));?></td>
           <td style="text-align: center;"><?php echo $this->Number->currency(round($patientData['amount_paid']+$patientData['card_balance']));?></td>
           <td style="text-align: center;"><?php echo $this->Number->currency(round($patientData['amount_discount']));?></td>
           <td style="text-align: center;"><?php echo $this->Number->currency($patientData['total_amount']-$patientData['amount_paid']-$patientData['card_balance']-round($patientData['amount_discount']));?></td>
		   <td style="image-align: center;" class="tdLabel" id="boxSpace">
		   <?php // Patient credentials
		             $patientId=trim($patientData['Patient']['id']);
		             $personId=trim($patientData['Patient']['person_id']);
		             if(!empty($patientData['Person']['patient_credentials_created_date'])){
						echo $this->Html->link($this->Html->image('icons/green.png',array('class'=>'')),'javascript:void(0)', 
						array('onClick'=>"createPatientCredentials('$personId','$patientId')",'escape' => false,'title'=>'Patient Credentials'));
					}else{
						echo $this->Html->link($this->Html->image('icons/red.png',array('class'=>'cred_'.$personId)),'javascript:void(0)',
						array('onClick'=>"createPatientCredentials('$personId','$patientId')",'escape' => false,'title'=>'Patient Credentials'));
			}?>
			</td>
        </tr>
        
      <?php }
      
      } else { ?>
      <tr><td align='center' class='error ' id='boxSpace'><?php echo __("No Record found");?></td></tr>      
      <?php }?>
</table>

<script type="text/javascript">
$(document).ready(function(){		
	
   	$('#patient_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "Patients", "action" => "admissionComplete","no","admin" => false,"plugin"=>false)); ?>",
		setPlaceHolder : false,
		select: function(event,ui){	
	   $('#patient_id').val(ui.item.id);   			
	},
	 messages: {
         noResults: '',
         results: function() {},
   		},
	});
});

$("#resett").click(function () {
    $("#patient_id").val(0);
    document.getElementById("helpDsk").reset();  
    $("#patient_id").val('');  
    $("#last_name").val('');
    $("#first_name").val('');
    $("#city").val('');
    $("#mobile_no").val('');
});
var ajaxcreateCredentialsUrl ="<?php echo $this->Html->url(array("controller" => "messages", "action" => "createCredentials","admin" => false)); ?>";
function createPatientCredentials(personid,patientid){

	$.fancybox({
		'width' : '50%',
		'height' : '50%',
		'autoScale' : true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'href' : "<?php echo $this->Html->url(array("controller" => "messages", "action" => "openFancyBox")) ?>"+"/"+personid+"/"+patientid+"?"+'clickedId='+personid,
	});
	
}
</script>