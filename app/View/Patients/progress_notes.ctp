<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<style>

.titlle{
font-weight: bold;
font-size: large;
margin: 1%;
}
</style>

<html xmlns="http://www.w3.org/1999/xhtml" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo __('Hope', true); ?>
        </title>
        <?php echo $this->Html->css('internal_style.css'); ?>  
        <style>
            body{margin:10px 0 0 0; padding:0; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000000;}
            .heading{font-weight:bold; padding-bottom:10px; font-size:19px; text-decoration:underline;}
            .headBorder{border:1px solid #ccc; padding:3px 0 15px 3px;}
            .title{font-size:14px; text-decoration:underline; font-weight:bold; padding-bottom:10px;color:#000;}
            input, textarea{border:1px solid #999999; padding:5px;}
            .tbl{background:#CCCCCC;}
            .tbl td{background:#FFFFFF;}
            .tbl .totalPrice{font-size:14px;}
            .adPrice{border:1px solid #CCCCCC; border-top:0px; padding:3px;}
            .tabularForm td{background:none;}
            @media print {
                #printButton{display:none;}
            }
            .borderBottom{
                 border-bottom: 1px solid;
            }
            
        </style>
    </head>
    <body style="background:none;width:99%;margin:auto;">
        <?php if(isset($this->params->query['invoice'])) {
            $margin = "18%";
        }else{
             $margin = "10%";
        }
?>
        <table border="0" class="" cellpadding="0" cellspacing="0" width="100%" style="margin-top:<?php echo $margin; ?>">
			<tr>
                <td colspan="3">
                    <div style="float: left;">
                    <?php
                   		echo $this->Html->image("/".$admission_Id, array('alt' => '','title'=>'','width'=>'190','height'=>'30','style'=>'padding-left:20px;'));
                   		?>
                   		
                   <?php echo $this->Html->image("/".$lookup_name, array('alt' => '','title'=>'','width'=>'190','height'=>'30','style'=>'padding-left:50px;')); ?>
                    </div>
					<?php if(!empty($patient['Patient']['file_number'])){?>
					<div>File Number: <?php echo $patient['Patient']['file_number'];?></div>
					<?php }?>
                    
                </td>
            </tr>
        </table>
    	
        <table width="100%" border='0'>
            <tr>
                <td>Name :<b><?php echo $result['Patient']['lookup_name'];?></b></td>
                
                <td>Age :<b><?php echo $result['Patient']['age'];?></b></td>
                
                <td>Sex :<b><?php echo ucfirst($result['Patient']['sex']);?></b></td>

                <td>Admission ID :<b><?php echo ucfirst($result['Patient']['admission_id']);?></b></td>

                <td>Ward :<b><?php echo ucfirst($result['Ward']['name']);?></b></td>
            </tr>
        </table>

        <?php $path=Router::url("/")."patients/progressNotes/".$result['Patient']['id'];
        ?>
        <form action="<?php echo $path?>" method=post id="subject">
        <table width="100%" style="border:1px solid" cellspacing="0" cellpadding="0">
            <tr>
                <td width="30%" align="center" style="border-right:1px solid;border-bottom:1px solid">
                    Date and Time
                </td>
                
                <td width="70%" align="center" style="border-bottom:1px solid">
                    Doctor's Progress Notes
                </td>
            </tr>
            <tr>
                <td width="20%" align="center" valign="top" style="padding-top:5px;border-right:1px solid">
                <table width="100%">
                <tr>
                    <td>
                        <?php 
                            
                            $dateVal=isset($noteData['Progresstbl']['date_of_seen'])?$noteData['Progresstbl']['date_of_seen']:'';
                            if($dateVal!=''){
                                $dateVal=$this->DateFormat->formatDate2Local($dateVal,Configure::read('date_format'),true);
                            }else{
                                $dateVal='';
                            }
                            echo $this->Form->input('',array('id'=>'dateID','class' => 'validate[required,custom[mandatory-select]] textBoxExpnd','name'=>'date_of_seen','value'=>$dateVal));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="center"><b>List of Progress Notes</b></td>
                </tr>
                <?php 
                    
                    foreach ($noteList as $key => $value) {
                    echo "<tr><td align=\"center\">";
                    echo $this->Html->link($this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true),'javascript:void(0);',array('onclick'=>'printProgress("'.$patientID.'","'.$key.'");'));
                       //echo $this->Html->link($this->DateFormat->formatDate2Local($value,Configure::read('date_format'),true),array('action'=>'ajaxProgressView',$patientID,$key),array('title'=>'Print/View Notes'));
                    echo "</td><td>";
                    echo $this->Html->link($this->Html->image('icons/edit-icon.png'),array('action'=>'progressNotes',$patientID,$key),array('title'=>'Edit Notes','escape'=>false));
                    echo "</tr>";
                    }
                    
                ?>
                </tr>
                </table>
                </td>

                <td width="80%" align="left">
                   
                    <table width="100%">
                        <tr>   
                            <?php $optDoc=array('Dr. Reena Rao','Dr Praveen Dange','Dr. Rakesh Zanjal','Dr. Prashant Wankhede','Dr. Tarunkant Malnia','Dr. Mukul','Dr. Sonam Yadav','Dr. Asit Ramteke','Dr. Ashish Chandwani','Dr. Javed Khan','Dr. Gulshan Ali');
                            ?>

                            <td>Seen By:</td>
                           
                            <td>
                                <?php 
                                    $idVal=isset($noteData['Progresstbl']['id'])?$noteData['Progresstbl']['id']:"";
                                    echo $this->Form->input('',array('id'=>'id','type'=>'hidden','name'=>'id','value'=>$idVal));
                                    echo $this->Form->input('',array('id'=>'seenby','class' =>'textBoxExpnd','name'=>'seen_by','empty'=>'Please Select','options'=>$optDoc,'value'=>$noteData['Progresstbl']['seen_by']));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Diagnosis :</td>
                           
                            <td><b><?php echo $result['Diagnosis']['final_diagnosis'];?></b></td>
                        </tr>

                        <tr>
                            <td>Package Name :</td>
                           
                            <td><b><?php echo isset($result['TariffList']['name'])?$result['TariffList']['name']:$_SESSION['packName'];?></b></td>
                        </tr>

                        <tr>
                            <td>Complaints :</td>
                           
                            <td><?php echo $this->Form->input('',array('id'=>'','class' => 'textBoxExpnd','type'=>'textArea','name'=>'complaints','value'=>$noteData['Progresstbl']['complaints']));?></td>
                        </tr>
                        
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <th>On Examination:</th>
                                    </tr>
                                    <tr>    <?php $gcarry=array('Critical','Moderate','Stable');?>
                                        <td>GC :<?php echo $this->Form->input('',array('id'=>'gc','class' =>'textBoxExpnd','name'=>'gc','empty'=>'Please Select','options'=>$gcarry,'value'=>$noteData['Progresstbl']['gc']));?></td>
                                    </tr>
                                    <tr>
                                        <td>Temprature :<?php echo $this->Form->input('',array('id'=>'temp','class' =>'textBoxExpnd','name'=>'temp','value'=>$noteData['Progresstbl']['temp']));?></td>
                                    </tr>
                                    <tr>
                                        <td>BP :<?php echo $this->Form->input('',array('id'=>'bp','class' =>'textBoxExpnd','name'=>'bp','value'=>$noteData['Progresstbl']['bp']));?></td>
                                    </tr>
                                    <tr>
                                        <td>Heart Rate:<?php echo $this->Form->input('',array('id'=>'hr','class' =>'textBoxExpnd','name'=>'hr','value'=>$noteData['Progresstbl']['hr']));?></td>
                                    </tr>
                                    <tr>
                                        <td>Respiration Rate:<?php echo $this->Form->input('',array('id'=>'rr','class' =>'textBoxExpnd','name'=>'rr','value'=>$noteData['Progresstbl']['rr']));?></td>
                                    </tr>
                                </table>
                            </td>

                            <td>
                                <table>
                                    <tr>
                                        <th>Systemic Exmination:</th>
                                    </tr>
                                    <tr>
                                        <td>Respiratory System :<?php echo $this->Form->input('',array('id'=>'chest','class' =>'textBoxExpnd','name'=>'chest','value'=>$noteData['Progresstbl']['chest']));?></td>
                                    </tr>
                                    <tr>
                                        <td>CVS :<?php echo $this->Form->input('',array('id'=>'cvs','class' =>'textBoxExpnd','name'=>'cvs','value'=>$noteData['Progresstbl']['cvs']));?></td>
                                    </tr>
                                    <tr>
                                        <td>CNS :<?php echo $this->Form->input('',array('id'=>'cns','class' =>'textBoxExpnd','name'=>'cns','value'=>$noteData['Progresstbl']['cns']));?></td>
                                    </tr>
                                    <tr>
                                        <td>P/A:<?php echo $this->Form->input('',array('id'=>'pa','class' =>'textBoxExpnd','name'=>'pa','value'=>$noteData['Progresstbl']['pa']));?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <th>&nbsp;</th>
                                    </tr>
                                    <tr>
                                        <td width="70%">ET tube/TT tube :</td>
                                        <td width="30%">
                                             <?php
                                                if(trim($noteData['Progresstbl']['ettube'])=='1'){
                                                    $display='block';
                                                    $checked='checked';
                                                }else{
                                                    $display='none';
                                                    $checked='';
                                                }
                                                echo $this->Form->input('',array('id'=>'ettube','type' =>'checkbox','class' =>'showDays','name'=>'ettube','checked'=>$checked,'div'=>false,'label'=>false));
                                            ?>
                                             <span id='ettube_Text' style="display:<?php echo $display?>;">
                                            <?php echo $this->Form->input('',array('id'=>'ettubeText','class' =>'','style'=>'width: 22.3% !important;','name'=>'ettubetext','value'=>$noteData['Progresstbl']['ettubetext'],'div'=>false,'label'=>false))." Days";?></span>
                                           
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td width="70%">Follegs Catheter :</td>
                                        <td width="30%">
                                             <?php 
                                             if(trim($noteData['Progresstbl']['foll'])=='1'){
                                                    $display='block';
                                                    $checked='checked';
                                                }else{
                                                    $display='none';
                                                    $checked='';
                                                }
                                             echo $this->Form->input('',array('id'=>'foll','type' =>'checkbox','class' =>'showDays','name'=>'foll','checked'=>$checked,'div'=>false,'label'=>false));?>
                                             <span id='foll_Text' style="display:<?php echo $display?>;">
                                            <?php echo $this->Form->input('',array('id'=>'follText','class' =>'','style'=>'width: 22.3% !important;','name'=>'folltext','value'=>$noteData['Progresstbl']['folltext'],'div'=>false,'label'=>false))." Days";?></span>
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="70%">CVP line :</td>
                                        <td width="30%">
                                             <?php 
                                             if(trim($noteData['Progresstbl']['cvp'])=='1'){
                                                    $display='block';
                                                    $checked='checked';
                                                }else{
                                                    $display='none';
                                                    $checked='';
                                                }
                                             echo $this->Form->input('',array('id'=>'cvp','type' =>'checkbox','class' =>'showDays','name'=>'cvp','checked'=>$checked,'div'=>false,'label'=>false));?>
                                             <span id='cvp_Text' style="display:<?php echo $display?>;">
                                            <?php echo $this->Form->input('',array('id'=>'cvpText','class' =>'','style'=>'width: 22.3% !important;','name'=>'cvptext','value'=>$noteData['Progresstbl']['cvptext'],'div'=>false,'label'=>false))." Days";?></span>
                                           
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td>Local Examination :<?php echo $this->Form->input('',array('id'=>'','class' => 'textBoxExpnd','type'=>'textArea','name'=>'local_exam','value'=>$noteData['Progresstbl']['local_exam']));?>
                            </td>
                            <td>Investigation :<?php echo $this->Form->input('',array('id'=>'','class' => 'textBoxExpnd','type'=>'textArea','name'=>'investigation','value'=>$noteData['Progresstbl']['investigation']));?>
                            </td>
                             <td>Plan :<?php echo $this->Form->input('',array('id'=>'','class' => 'textBoxExpnd','type'=>'textArea','name'=>'plan','value'=>$noteData['Progresstbl']['plan']));?>
                             </td>
                        <tr>
                        <tr>
                            <td colspan="3" align="right">
                                <?php echo $this->Form->input(__('Submit'),array('type'=>'submit','id'=>'DateBtn','class'=>'blueBtn','label'=>false));?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <?php echo $this->Form->end();?>
    </body>
</html>
<script>
$(document).ready(function(){
    
});
$('#DateBtn').click(function(){
    if($('#dateID').val()==''){
        alert('Please Select Date.');
        return false;
    }
});
$( "#dateID" ).datepicker({
        showOn: "button",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        dateFormat:'<?php echo $this->General->GeneralDate("HH:II");?>',
        maxDate: new Date(),
        onSelect:function(){
            $(this).focus()
        }
    });
$('.showDays').click(function(){
    var currentId=$(this).attr('id');
    if($('#'+currentId).prop("checked")){
        $('#'+currentId+'_Text').fadeIn();
    }else{
        $('#'+currentId+'_Text').fadeOut();
    }

});
$('#gc').change(function(){
    if($('#gc').val()=='0'){
        $('#bp').val('110/60 mm of Hg');
        $('#hr').val('140/min');
        $('#rr').val('20/min');
        $('#temp').val('98.8 F');

        $('#chest').val('20/min');
        $('#cvs').val('S1 S2 Noral');
        $('#cns').val('Drowst, E2 V2 M3 Pupils: B/L Sluggishly reacting to light stimulus');
        $('#pa').val('Soft, Non Tender');
    }
});
function printProgress(patientID,Key){
   var url="<?php echo $this->Html->url(array('controller' => 'Patients', 'action' => 'ajaxProgressView')); ?>"+"/"+patientID+"/"+Key;
   window.open(url, "_blank","toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=900,height=500,left=200,top=200"); // will open new tab on document ready
  
}
</script>