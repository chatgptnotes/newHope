<label>
  <span><?php echo __('Surgery'); ?><font color="red"> *</font>:</span>
  <?php echo $this->Form->input(null,array('name' => 'surgery_id', 'id'=> 'surgery_id', 'empty'=>__('Select Surgery'),'options'=> $surgerycategories, 'label' => false, 'div' => false, 'style'=>'width:190px;', 'class' => 'required safe'));?>
</label>
<script>
$(document).ready(function(){
        
        $("#surgery_id").change(function(){ 
             
          var surgery_id = $('#surgery_id').val();
          var data = 'surgery_id=' + surgery_id ; 
          // for surgery subcategory field //
          $.ajax({url: "<?php echo $this->Html->url(array("action" => "getSurgerySubcategoryList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { if(html == "norecord"){ $('#changeSurgerySubcategoryList').hide();} else {$('#changeSurgerySubcategoryList').show(); $('#changeSurgerySubcategoryList').html(html); } $('#busy-indicator').hide(); } });
          
         });
	
});
</script>