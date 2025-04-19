<style>
.TbodySales {
    width: 100%;
    max-height: 200px;
/*    display: list-item;*/
    overflow: auto;
}
body{
    font-size:13px;
}
.tabularForm {
    background: none repeat scroll 0 0 #d2ebf2 !important;
}
.tabularForm td {
    background: none repeat scroll 0 0 #fff !important;
    color: #000 !important;
    font-size: 13px;
    /*padding: 3px 8px;*/
} 
.ui-widget-content{
        color:#000 !important;
}
label{
    width: auto !important;
}
</style>

<div class="clr ht5"> </div>
<div class="inner_title">
    <h3><?php echo $corporateHead; ?></h3> 
</div> 
<div class="clr ht5"></div>
<div class="TbodySales">
<table width="100%" cellpadding="0" cellspacing="2" border="0" class="tabularForm " style="color: #000;">
    <thead> 
        <tr>
            <th width="50%"><?php echo __('Remarks');?></th>
            <th width="20%"><?php echo __('Remark By');?></th> 
            <th width="20%"><?php echo __('Date');?></th>
            <th width="10%"><?php echo __('File');?></th>
        </tr>   
    </thead>
    <tbody>
        <?php if(!empty($returnData)){ foreach($returnData as $key => $data) {  ?>
                <tr>
                    <td><?php echo $data['remark']; ?></td>
                    <td><?php echo $data['user_id']; ?></td>
                    <td><?php echo $data['create_time']; ?></td>
                    <td><?php echo !empty($data['file_name']) ? $this->Html->link($this->Html->image('icons/patient_report.png', array('title' => 'View document','alt'=>'View','escape'=>false)),'/uploads/Documents/'.$data['file_name'],array('target'=>'blank','escape'=>false)):''; ?></td>
                </tr>
<?php
        } } else { 
            echo <<<emptyReport
                <tr>
                    <td colspan="4" align="center"><b>No Record Found..!!</b></td>
                </tr>
emptyReport;
            
        }
?> 
    </tbody>
</table>
</div>
<?php echo $this->Form->create('Corporate',array('id'=>'addRemarkForm','enctype' => 'multipart/form-data','type' => 'file','url'=>array('action'=>'addRemarkForCorporate','admin'=>false))); ?>
<table width="100%" class="tabularForm"> 
    <tr> 
        <td width="100%" colspan="2"><?php echo $this->Form->hidden('patient_id',array('value'=>$patient_id)); echo $this->Form->input('remark',array('type'=>'textarea','rows'=>'3','div'=>false,'label'=>false,'placeholder'=>'start typing your remark here',
            'style'=>'width:100%')); ?></td>
    </tr>
    <tr>
        <td><?php echo $this->Form->input('upload_document',array('type'=>'file')); ?></td>
        <td><?php 
        echo $this->Form->submit(__('Add Remark'),array('class'=>'blueBtn')); 
        //echo $this->Html->link(__('Add Remark'),'javascript:void(0);', array('escape' => false,'class'=>'blueBtn addRGJAYRemark')); ?></td>
    </tr>
    <tr>
        <td colspan="2">
            <label title="Check if patient's document is not submitted">
                <table>
                    <tr> 
                        <td>
                             <?php if(isset($fileIsNotSubmitted) && $fileIsNotSubmitted == 1){
                                 $checked = "checked";
                             }
                             echo $this->Form->input('',array('type'=>'checkbox','div'=>false,'checked'=>$checked,'label'=>false,'id'=>'documentNotSubmitted','patient_id'=>$patient_id)); ?>
                        </td>
                        <td>If patient's document is not submitted</td>
                    </tr>
                </table>
            </label>
        </td>
    </tr>
</table>
<?php echo $this->Form->end(); ?>        

<script>
    $("#documentNotSubmitted").click(function(){
        var isChecked = '2';
        if($(this).is(':checked',true)){
            isChecked = '1';
        }
        $.ajax({
            type : "POST",
            url: "<?php echo $this->Html->url(array("controller"=>"Corporates", "action" => "documentIsNotSubmitted","admin"=>false)); ?>"+'/'+$(this).attr('patient_id')+'/'+isChecked,
            beforeSend:function(){
                $('#busy-indicator').show();
            }, 	  		  
            success: function(data){  
                $('#busy-indicator').hide();
            } 
        });
    });
</script>