<style>
.main_wrap{ width:35%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px; height:187px;min-height:250px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:97%!important;}
</style>





<div class="">
   <div class="inner_title">
   <?php  
        echo $this->element('navigation_menu',array('pageAction'=>'Store'));
    ?>
      <h3>Manufacturing Company</h3>
	  </div>
   <div class="first_table">
      <table style="width:100%;padding:15px;">
        <tr>
						<td width="!important;" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Manufacture Company Name');?><font
							color="red">*</font></td>
						<td width="58%">
						<?php echo $this->Form->create(array('id'=>'ManufacturerCompany'));?>
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><?php echo $this->Form->input('name', array('class' => 'validate[required,custom[name]] textBoxExpnd','id' => 'first_name','value'=>$this->data[0]['ManufacturerCompany']['name'],'label'=>false,'div'=>false,)); ?>
									
									</td>
								</tr>
							</table>
						</td>
						<td width="">&nbsp;</td>

					</tr>
                    <tr>
                     <td colspan="3">
							<div class="btns" style="float:right!important">
							  <div class="save_btn" style="float:left">
                                <?php echo $this->Form->input('Submit',array('type'=>'submit','class'=>'blueBtn','id'=>'submit','label'=>false,'div'=>false))?>
                              </div>
                              <?php echo $this->Form->end();?>
						
                              <div class="save_btn" style="float:left;margin: 0 10px;">
                              <?php if($flagForBack!=1){?> 
                                <?php
									echo $this->Html->link(__('Back'), array('controller'=>'Pharmacy','action' => 'department_store','admin'=>false,'?'=>array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
									?>
								<?php }?>
                              </div>
                             <!-- <div class="save_btn" style="float:left">
                                <a href="#" class="blueBtn">cancel</a>
                              </div>
							   <span style="color:#ff0000; font-size:13px;padding: 0 0 0 13px;">(*)Mark Feild are Mandatory</span> -->
							  
							</div>
						</td>
                    </tr>
      </table>
     
      <?php 
      if(!empty($company)){?>
	  <table cellspacing="1" border="0" class="tabularForm" width="90%">
	     <tr>
		   <th>Manufacture Company Name</th>
		   <th>Edit</th>
		   <th>Delete</th>
		 </tr>
		 <?php $count=0;
		 foreach($company as $name){?>
		 <tr <?php if($count%2 == 0) echo "class='row_gray'"; ?>>
		   <td><?php echo $name['ManufacturerCompany']['name'];?></td>
		   <td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true))),array('action'=>'manufacturingCompany',$name['ManufacturerCompany']['id']), array('escape' => false))?></td>
		   <td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true))),array('action'=>'deleteManufacturer',$name['ManufacturerCompany']['id']), array('escape' => false),__('Do you Want to delete?', true))?></td>
		 </tr>
		 <?php $count++;}?>
	  </table>
	  <?php }?>
  		
   </div>
</div>

<script>

	$(document).ready(function(){	
		if('<?php echo $setManufacturerFlag ?>' == true){	//to close the manufacturer fancy box by Swapnil G.Sharma
			parent.$.fancybox.close();
		}
	});

	$("#submit").click(function(){
	var valid=jQuery("#ManufacturerCompany").validationEngine('validate');
	if(valid){
		$("#submit").hide();
		return true;
	}else{
		return false;
	}
	});</script>