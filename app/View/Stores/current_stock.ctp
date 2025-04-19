<style>
.table_format{
    padding:0px !important;
}
label{
    width:none;
    padding-top: 0px;
    margin-right: 0px;
    float:none;
    color:white !important;
} 
</style> 

<div class="inner_title">
    <?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Pharmacy'));
    ?>
    <h3>Current Stock</h3>
    <span> 
            <?php 
                    echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'department_store','admin'=>false,'?'=>array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
            ?>
    </span>
</div>
<div class="clr ht5"></div>
<?php echo $this->Form->create('',array('type'=>'get','url'=>array('action'=>'currentStock')));?>
<table class="table_format" cellspacing="0">
    <tr class="row_title"> 
        <td>
            <?php echo __('Search By : '); ?></td>
        </td>
        <td class="count" id="isZero"> 
            <?php echo $this->Form->input('', array('name'=>'is_zero','type'=>'checkbox','checked'=>$this->request->query['is_zero'],'label'=>"Empty Stock",'div'=>false,'hiddenField'=>false,'id' => 'is_zero','class'=>'selectedCheck')); ?>    
        </td>
        <td class="count" id="MOL"> 
            <?php echo $this->Form->input('', array('name'=>'is_MOL','type'=>'checkbox','label'=>"MOL (Maximum Order Limit",'checked'=>$this->request->query['is_MOL'],'div'=>false,'hiddenField'=>false,'id' => 'is_MOL','class'=>'selectedCheck')); ?>    
        </td>
        <td class="count" id="reorder"> 
            <?php echo $this->Form->input('', array('name'=>'is_reorder','type'=>'checkbox','label'=>"Reorder Level",'div'=>false,'checked'=>$this->request->query['is_reorder'],'hiddenField'=>false,'id' => 'is_reorder','class'=>'selectedCheck')); ?>    
        </td>
        <td class="count" id="expensive"> 
            <?php echo $this->Form->input('', array('name'=>'is_expensive','type'=>'checkbox','label'=>"Expensive Product",'checked'=>$this->request->query['is_expensive'],'div'=>false,'hiddenField'=>false,'id' => 'is_expensive','class'=>'selectedCheck')); ?>    
        </td> 
        <td> 
            <?php echo $this->Form->input('Search',array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false))?> 
        </td> 
        <td> 
            <?php echo $this->Form->input(__('Generate Report'), array('type'=>'submit','class'=>'blueBtn','label'=>false,'div'=>false,'name'=>'generate_report')); ?>
        </td> 
        <td> 
            <?php echo $this->Html->link($this->Html->image('icons/refresh-icon.png'),array('controller'=>'Store','action'=>'currentStock'),array('escape'=>false, 'title' => 'refresh'));?>
        </td> 
    </tr>
</table>
<?php echo $this->Form->end();?>
<div class="clr ht5"></div>  

<table cellspacing="1" border="0" class="table_format">
    <tr class="row_title"> 
        <td style="text-align:center"><?php echo __('Sr.No', true);?> </td>
        <td style="text-align:center"><?php echo __('Item Name', true);?> </td> 
        <td style="text-align:center">Current Stock</td> 
        <?php if($this->request->query['is_expensive'] == '1') { ?>
        <td style="text-align:center"><?php echo __('Purchase Price', true);?> </td>
        <?php } ?>
        <td style="text-align:center">Maximum Order Qty</td>
        <td style="text-align:center">ReOrder Level</td> 
    </tr>
        <?php if(!empty($results)){ ?>
        <?php $count=0;
            $srno=$this->params->paging['PharmacyItemRate']['limit']*($this->params->paging['PharmacyItemRate']['page']-1); 
            foreach($results as $product){ ?>
        <tr> 
                <td><?php echo ++$srno; ?></td>
                <td><?php echo $product['PharmacyItem']['name']; ?></td>
                <td style="text-align:center"><?php echo $product['0']['total_Stock']; ?></td>
                <?php if($this->request->query['is_expensive'] == '1') { ?>
                <td style="text-align:right"><?php echo number_format($product['PharmacyItemRate']['purchase_price'],2); ?></td>
                <?php } ?>
                <td style="text-align:center"><?php echo $product['PharmacyItem']['maximum']; ?></td>
                <td style="text-align:center"><?php echo $product['PharmacyItem']['reorder_level']; ?></td>  
        </tr>
        <?php }?>
        <tr>
            <td colspan="6" align="center">
                <?php
                    $queryStr = $this->General->removePaginatorSortArg($this->params->query);   
                    $this->Paginator->options(array('url' => array("?" => $queryStr)));
                ?>
                <?php echo $this->Paginator->numbers(array('class' => 'paginator_links')); ?>
                <?php echo $this->Paginator->prev(__('« Previous', true), null, null, array('class' => 'paginator_links')); ?>
                <?php echo $this->Paginator->next(__('Next »', true), null, null, array('class' => 'paginator_links')); ?>
                <span class="paginator_links"><?php echo $this->Paginator->counter(); ?></span>
            </td>
        </tr>
        <?php }else echo "<tr><td colspan=6 align=center>No Records found!</td></tr>";?>
</table>    
<div class="clear"></div>
<script>
$(document).ready(function() {	

	var location = $("#location").val(); 
	displayCheckes(location);
	if('<?php echo $sendRequisition; ?>' == "yes"){
		$("#sendRequest").show();
	} else if('<?php echo $expensive; ?>' == "yes"){
		$("#issue").show();
	}else{
		$("#report").show();
	}
	$('.checkbox1').attr('checked', true);
    $("#selectall").attr('checked', true);

	$('#supplier_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","InventorySupplier","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#supplier_id').val(ui.item.id);			  
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

	$('.supplier_name').blur(function(){
        if($(this).val()==''){
        	$("#selectall").attr('disabled','disabled');
        	$('.checkbox1').attr('disabled','disabled');
        	$('.select').hide();
        	$('.issue').hide();
        }
        });

	$('#selectall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });

  //If one item deselect then button CheckAll is UnCheck
    $(".checkbox1").click(function () {
        if (!$(this).is(':checked'))
            $("#selectall").attr('checked', false);
    });


    $('#first_name').autocomplete({
		source: "<?php echo $this->Html->url(array("controller" => "app", "action" => "advance_autocomplete","Product","name",'null',"no",'no',"admin" => false,"plugin"=>false)); ?>",
		 minLength: 1,
		 select: function( event, ui ) {
			 $('#product_id').val(ui.item.id);			  
		 },
		 messages: {
		        noResults: '',
		        results: function() {}
		 }
	});

    $(document).on('change','#is_zero',function(){
		if($(this).is(':checked',true)){
			$("#is_reorder").attr('checked',false);
			$("#is_expensive").attr('checked',false);
			$("#is_MOL").attr('checked',false);
		}
    });

    $(document).on('change','#is_reorder',function(){
		if($(this).is(':checked',true)){
			$("#is_zero").attr('checked',false);
			$("#is_expensive").attr('checked',false);
			$("#is_MOL").attr('checked',false);
			if($("#location").val() == "<?php echo $otPharId; ?>"){
				$("#subLocation").show();
			}
		}else{
			$("#subLocation").hide();
		}
    });

    $(document).on('change','#is_expensive',function(){
		if($(this).is(':checked',true)){
			$("#is_zero").attr('checked',false);
			$("#is_reorder").attr('checked',false);
			$("#is_MOL").attr('checked',false);
		}
    });

    $(document).on('change','#is_MOL',function(){
		if($(this).is(':checked',true)){
			$("#is_zero").attr('checked',false);
			$("#is_reorder").attr('checked',false);
			$("#is_expensive").attr('checked',false);
		}
    });
});

$("#location").change(function(){
	displayCheckes($(this).val());
});

function displayCheckes(id){ 
	var apamId = "<?php echo $apamId; ?>";
	var otPharId = "<?php echo $otPharId; ?>";
	var centralId = "<?php echo $centralId; ?>";
	var pharId = "<?php echo $pharId; ?>";
 
	switch(id){
		case apamId: 
			$("#MOL").show();
			$("#reorder").hide();
			$("#expensive").hide();
			$("#subLocation").hide();
			break;
		case centralId:
			$("#MOL").show();
			$("#reorder").hide();
			$("#expensive").hide();
			$("#subLocation").hide();
			break;
		case pharId:
			$("#MOL").hide();
			$("#reorder").show();
			$("#expensive").show();
			$("#subLocation").hide();
			break;
		case otPharId:
			$("#MOL").hide();
			$("#reorder").show();
			$("#expensive").hide();
			if($("#is_reorder").is(':checked')){
				$("#subLocation").show();
			}
			break;
	}
}

function displayButton(){
	if($("#is_expensive").is("checked",true)){
		alert("dello");
		$("#sendRequest").show();
	}
}
</script>
 
