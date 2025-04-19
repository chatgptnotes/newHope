<label>
  <span><?php echo __('Anesthesia'); ?><font color="red"> *</font>:</span>
  <?php echo $this->Form->input(null,array('name' => 'anesthesia_id', 'id'=> 'anesthesia_id', 'empty'=>__('Select Anesthesia'),'options'=> $anesthesiacategories, 'label' => false, 'div' => false, 'style'=>'width:190px;', 'class' => 'required safe'));?>
</label>
<script>
$(document).ready(function(){
        
        $("#anesthesia_id").change(function(){ 
             
          var anesthesia_id = $('#anesthesia_id').val();
          var data = 'anesthesia_id=' + anesthesia_id ; 
          // for anesthesia subcategory field //
          $.ajax({url: "<?php echo $this->Html->url(array("action" => "getAnesthesiaSubcategoryList", "admin" => false)); ?>",type: "GET",data: data,success:   function (html) { if(html == "norecord"){ $('#changeAnesthesiaSubcategoryList').hide();} else {$('#changeAnesthesiaSubcategoryList').show(); $('#changeAnesthesiaSubcategoryList').html(html); } $('#busy-indicator').hide(); } });
          
         });
	
});
</script>