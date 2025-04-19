<style>
.main_wrap{ width:35%;float:left;margin:0px;padding:0px; border:1px solid #000; border-radius:5px; height:187px;min-height:250px;}
.btns{float:left !important;margin: 0 0 0 15px;}
.tabularForm{float:left; margin:10px 0 0 20px; width:92%!important;}
.inner_title{width:97%!important;}
.tdLabel {
    color: #000;
    font-size: 14px !important; 
    padding-left: 11px !important;
    padding-right: 15px;
    padding-top: 1px !important;
    text-align: left;
}
</style>

<div class="">
   <div class="inner_title">
      <h3>Marketing Teams </h3>
	  </div>
   <div class="first_table">
      <table style="width:100%;padding:15px;">
        <tr>
						<td width="136px" valign="middle" class="tdLabel" id="boxSpace"><?php echo __('Marketing Team Name');?><font
							color="red">*</font></td>
						<td width="58%">
						<?php echo $this->Form->create(array('id'=>'MarketingTeam'));?>
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td><?php echo $this->Form->input('name', array('class' => 'validate[required,custom[onlyLetterSp]]' ,'id' => 'first_name', 'value'=>$this->data[0]['MarketingTeam']['name'],'label'=>false,'div'=>false,)); ?>
									</td>
									<td><?php echo __('Mobile Number');?>
									    <?php
                                            echo $this->Form->input('mobile', array(
                                                'class' => '', 
                                                'id' => 'mobile', 
                                                'value' => $this->data[0]['MarketingTeam']['mobile'], 
                                                'label' => false, 
                                                'div' => false, 
                                                'required' => true, // Field required banata hai
                                                'maxlength' => 10, // Maximum 10 digits allow karega
                                                'pattern' => '[0-9]{10}', // Sirf 10 digits allow karega
                                                'title' => 'Please enter a valid 10-digit mobile number' // Invalid input pe message show karega
                                            )); 									    ?>
									</td>
								</tr>
							</table>
						</td>
						<td width="">&nbsp;</td>
					</tr>
					<script>$(document).ready(function() {
                        $('#mobile').on('input', function() {
                            let value = $(this).val();
                            if (!/^\d{0,10}$/.test(value)) {
                                $(this).val(value.slice(0, 10)); // Sirf 10 digits tak cut karega
                            }
                        });
                    });
                </script>
                    <tr>
                     <td colspan="3">
							<div class="btns" style="float:right!important">
							  <div class="save_btn" style="float:left">
                                <?php echo $this->Form->input('Submit',array('type'=>'submit','class'=>'blueBtn','id'=>'submit','label'=>false,'div'=>false))?>
                              </div>
                              <?php echo $this->Form->end();?>
						
                              <div class="save_btn" style="float:left;margin: 0 10px;"> 
                                <?php
									echo $this->Html->link(__('Back'), array('controller'=>'Users','action' => '','admin'=>false,'?'=>array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
									?>
								
                              </div>
                             <!-- <div class="save_btn" style="float:left">
                                <a href="#" class="blueBtn">cancel</a>
                              </div>
							   <span style="color:#ff0000; font-size:13px;padding: 0 0 0 13px;">(*)Mark Feild are Mandatory</span> -->
							  
							</div>
						</td>
                    </tr>
      </table>
      
      <?php if(!empty($company)){?>
	  <table cellspacing="1" border="0" class="tabularForm" width="90%">
	     <tr>
		   <th>Manufacture Company Name</th>
		   <th>Edit</th>
		   <th>Delete</th>
		 </tr>
		 <?php $count=0;
		 foreach($company as $name){?>
		 <tr <?php if($count%2 == 0) echo "class='row_gray'"; ?>>
		   <td><?php echo $name['MarketingTeam']['name'];?></td>
		   <td><?php echo $this->Html->link($this->Html->image('icons/edit-icon.png', array('title' => __('Edit', true))),array('action'=>'marketing_team',$name['MarketingTeam']['id']), array('escape' => false))?></td>
		   <td><?php echo $this->Html->link($this->Html->image('icons/delete-icon.png', array('title' => __('Delete', true))),array('action'=>'deleteTeam',$name['MarketingTeam']['id']), array('escape' => false))?></td>
		 </tr>
		 <?php $count++;}?>
	  </table>
	  <?php }?>
  	
   </div>
</div>

<script>

	$("#submit").click(function(){
	var valid=jQuery("#MarketingTeam").validationEngine('validate');
	if(valid){
		$("#submit").hide();
		return true;
	}else{
		return false;
	}
	});</script>