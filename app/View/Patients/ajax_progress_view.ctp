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
                    
                    <div id="printButton" style="float: right">
					<?php
					echo "&nbsp;".$this->Html->link(__('Print', true), '#', array('escape' => false, 'class' => 'blueBtn', 'onclick' => 'window.print();'));
					?>
                    </div>

                    <div id="Back" style="float: right">
                    <?php
                    echo "&nbsp;".$this->Html->link(__('Back', true), array('action'=>'progressNotes',$patientID), array('escape' => false, 'class' => 'blueBtn'));
                    ?>
                    </div>
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
            <tr>
                <td colspan="6" align="center" style="font-size:15px"><b>Progress Notes</b></td>
            </tr>
        </table>
    	
        <table width="100%" border='0'>
        <tr>
            <td width="50%"><?php echo $this->Html->image('hope-logo-sm.gif');?></td>
            <td width="50%"><b>Hope Hospitals</b> Plot No. 2, Behind Go Gas,Teka Naka, <br>Kamptee
                Road, Nagpur - 440 017 <br> <b>Phone: </b>+91 712 2980073 <b>Email:
            </b>info@hopehospital.com<br><b>Website: </b>www.hopehospital.com</td>
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
                <td width="20%" align="center" valign="top" style="padding-top:5px;border-right:1px solid"><?php echo $this->DateFormat->formatDate2Local($noteData['Progresstbl']['date_of_seen'],Configure::read('date_format'),true);?></td>
                
                <td width="80%" align="left">
                   
                    <table width="100%">
                        <tr>    
                            <?php $optDoc=array('Dr. Reena Rao','Dr Praveen Dange','Dr. Rakesh Zanjal','Dr. Prashant Wankhede','Dr. Tarunkant Malnia','Dr. Mukul','Dr. Sonam Yadav','Dr. Asit Ramteke','Dr. Ashish Chandwani','Dr. Javed Khan','Dr. Gulshan Ali');
                            ?>

                            <td>Seen By:</td>
                           
                            <td><b><?php echo $optDoc[$noteData['Progresstbl']['seen_by']]?></b></td>
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
                            <td> &nbsp;</td>
                        </tr>
                    </table>

                    <table width="100%">
                        <tr>
                            <td style="border-bottom:1px solid;"><b>On Examination:</b></td>
                        </tr>
                        <tr>
                            <td>GC :  <b><?php $gcarry=array('Critial','Moderate','Stable');
                                echo $gcarry[$noteData['Progresstbl']['gc']];?></td>
                        </tr>
                        </tr>
                        <tr>
                            <td>Temprature :  <b><?php echo $noteData['Progresstbl']['temp']?></b></td>
                        </tr>
                        <tr>
                            <td>BP :  <b><?php echo $noteData['Progresstbl']['bp']?></b></td>
                        </tr>
                        <tr>
                            <td>Heart Rate:  <b><?php echo $noteData['Progresstbl']['hr']?></b></td></td>
                        </tr>
                        <tr>
                            <td>Respiration Rate:  <b><?php echo $noteData['Progresstbl']['rr']?></b></td>
                        </tr>
                    </table>
                    <p>
                    
                    <table width="100%">
                        <tr> 
                            <td style="border-bottom:1px solid;"><b>Systemic Exmination:</b></td>
                        </tr>
                        <tr>
                            <td>Chest :  <b><?php echo $noteData['Progresstbl']['chest']?></b></td>
                        </tr>
                        <tr>
                            <td>CVS :  <b><?php echo $noteData['Progresstbl']['cvs']?></b></td>
                        </tr>
                        <tr>
                            <td>CNS :  <b><?php echo $noteData['Progresstbl']['cns']?></b></td>
                        </tr>
                        <tr>
                            <td>P/A:  <b><?php echo $noteData['Progresstbl']['pa']?></b></td>
                        </tr>
                    </table>
                    <p>

                    <table>
                        <tr>
                            <td>ET tube/TT tube :<b><?php if(!empty($noteData['Progresstbl']['ettubetext'])){echo isset($noteData['Progresstbl']['ettubetext'])?$noteData['Progresstbl']['ettubetext']." Days":'';}?></b></td>
                        </tr>
                        
                        <tr>
                            <td>Follegs Catheter :<b><?php if(!empty($noteData['Progresstbl']['folltext'])){echo isset($noteData['Progresstbl']['folltext'])?$noteData['Progresstbl']['folltext']." Days":'';}?></b></td>
                        </tr>
                        <tr>
                            <td>CVP line :<b><?php if(!empty($noteData['Progresstbl']['cvptext'])){echo isset($noteData['Progresstbl']['cvptext'])?$noteData['Progresstbl']['cvptext']." Days":'';}?></b></td>
                        </tr>
                    </table>
                    <p>

                    <table width="100%">
                        <tr>
                            <td><b>Local Examination :</b><br/><b><?php echo $noteData['Progresstbl']['local_exam']?></b>
                            </td>
                        </tr>
                    </table>
                    <p>

                    <table width="100%">
                        <tr>
                            <td><b>Investigation :</b><br/><b><?php echo $noteData['Progresstbl']['investigation']?></b>
                            </td>
                        </tr>
                    </table>
                    <p>

                    <table width="100%">
                        <tr>
                        <td><b>Plan :</b><br/><b><?php echo $noteData['Progresstbl']['plan']?></b>
                        </td>
                        <tr>
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
</script>