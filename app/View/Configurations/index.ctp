<style>
 @import url(http://fonts.googleapis.com/css?family=Lato);
@charset "UTF-8";
/* Base Styles */
#cssmenu,
#cssmenu ul,
#cssmenu li,
#cssmenu a {
  margin: 0;
  padding: 0;
  border: 0;
  list-style: none;
  font-weight: normal;
  text-decoration: none;
  line-height: 1;
  font-family: 'Lato', sans-serif;
  font-size: 14px;
  position: relative;
}
#cssmenu a {
  line-height: 1.3;
  padding: 6px 15px;
  color: #ffffff !important;
}
#cssmenu {
  width: 200px;
}
#cssmenu > ul > li {
  cursor: pointer;
  background: #000;
  border-bottom: 1px solid #4c4e53;
}
#cssmenu > ul > li:last-child {
  border-bottom: 1px solid #3e3d3c;
}
#cssmenu > ul > li > a {
  font-size: 13px;
  display: block;
  color: #DDDDDD;
  text-shadow: 0 1px 1px #000;
  background: #64676e;
  background: -moz-linear-gradient(#64676e 0%, #4c4e53 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #64676e), color-stop(100%, #4c4e53));
  background: -webkit-linear-gradient(#64676e 0%, #4c4e53 100%);
  background: linear-gradient(#64676e 0%, #4c4e53 100%);
}
#cssmenu > ul > li > a:hover {
  text-decoration: none;
}
#cssmenu > ul > li.active {
  border-bottom: none;
}
#cssmenu > ul > li.active > a {
  background: #97c700;
  background: -moz-linear-gradient(#97c700 0%, #709400 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #97c700), color-stop(100%, #709400));
  background: -webkit-linear-gradient(#97c700 0%, #709400 100%);
  background: linear-gradient(#97c700 0%, #709400 100%);
  color: #4e5800;
  text-shadow: 0 1px 1px #709400;
}
#cssmenu > ul > li.has-sub > a:after {
  content: "";
  position: absolute;
  top: 10px;
  right: 10px;
  border: 5px solid transparent;
  border-left: 5px solid #ffffff;
}
#cssmenu > ul > li.has-sub.active > a:after {
  right: 14px;
  top: 12px;
  border: 5px solid transparent;
  border-top: 5px solid #4e5800;
}
/* Sub menu */
#cssmenu ul ul {
  padding: 0;
  display: none;
}
#cssmenu ul ul a {
  background: #686868;
  display: block;
  color: #797979;
  font-size: 13px;
}
#cssmenu ul ul li {
  border-bottom: 1px solid #c9c9c9;
}
#cssmenu ul ul li.odd a {
  background: #a8a8a8;
}
#cssmenu ul ul li:last-child {
  border: none;
}
 </style>

<div class="inner_title">
	<h3>
		<?php echo __('Configuration', true); ?>
	</h3>
	<span>
	<?php
	echo $this->Html->link(__('Back', true),array('controller' => 'Users', 'action' => 'menu', '?' => array('type'=>'master'),'admin'=>true), array('escape' => false,'class'=>'blueBtn','style'=>'margin-left:10px'));
	?>
	</span>
</div>
<div style="padding-top: 1%">	
</div>
<?php echo $this->Form->create('',array('id'=>'Configuration')); ?>
<table width="100%" cellpadding="0" cellspacing="5" border="0" align="center">
<tr>
<td width="25%" valign="top">
		<div id='cssmenu'>
			<ul>
			   <li class='active has-sub'><a><span>Configuration</span></a>
				  <ul>
			           <?php foreach ($configurationsMainData as $confignames){
							
			          	 $names=$confignames['Configuration']['name'];
			          	 $ids=$confignames['Configuration']['id'];
			           	?>
			          	<li class="config" name="<?php echo $names;?>" id="<?php echo $ids; ?>"><a><?php echo $names;?></a></li>
			          	<?php }?>
			          	<?php //echo $this->Form->hidden('configuration_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'configuration_id'))?> 
			          	<?php //echo $this->Form->hidden('configuration_name',array('type'=>'text','div'=>false,'label'=>false,'id'=>'configuration_name'))?> 
			      </ul>
			   </li>
			   <!--<li class='has-sub'><a><span>Products</span></a>
			      <ul>
			           <?php //debug($configurations);
					   foreach ($configurations as $configname){
			          	 $name=$configname['Configuration']['name'];
			          	 $id=$configname['Configuration']['id'];
			           	?>
			          	<li class="config" name="<?php echo $name;?>" id="<?php echo $id; ?>"><a><?php echo $name;?></a></li>
			          	
			          	<?php }?>
			          	<?php echo $this->Form->hidden('configuration_id',array('type'=>'text','div'=>false,'label'=>false,'id'=>'configuration_id'))?> 
			          	<?php echo $this->Form->hidden('configuration_name',array('type'=>'text','div'=>false,'label'=>false,'id'=>'configuration_name'))?> 
			      </ul>
			   </li>-->
			</ul>
		</div>
</td>
<td width="75%" >
<div>
<table width="100%" cellpadding="0" cellspacing="5" border="0" align="center" id="table_0">
	<!-- <tr>
		<td  class="tdLabel2" align="right"  >New Configuration:</td>
		<td  align="left"><?php echo $this->Form->input('new',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'is_new'))?></td>  
	</tr>
	
	 
	<tr style="display:none;" id="add-config"> 
		<td  class="tdLabel2" align="right"  >Add Configuration:</td>
		<td  align="left"><?php echo $this->Form->input('name',array('type'=>'text','div'=>false,'label'=>false,'id'=>'name'))?></td>  
	</tr>
	
	<tr >
		<td  class="tdLabel2" align="right"  >Select Configuration:</td>
		<td  align="left"><?php echo $this->Form->input('configuration_id',array('type'=>'select','empty'=>'Please Select','options'=>$configurations,
				'div'=>false,'label'=>false,'id'=>'configuration','class'=>' textBoxExpnd','autoComplete'=>false))?>
						<?php echo $this->Form->hidden('configuration_name',array('type'=>'text','div'=>false,'label'=>false,'id'=>'configuration_name'))?>
		</td>  
	</tr> -->
	
	<tr id="is_pharmacy" style="display:none;">
		<!--  <td  class="tdLabel2" align="right"  >Pharmacy:</td>-->
		<td  align="left"><?php echo $this->Form->input('included_in_bill',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'pharmacy','class'=>' '));
		echo "Pharmacy"; ?>
		</td>  
	</tr>
	<?php 
		$var=$redirect['Configuration']['value'];
		$redrct=unserialize($var);
	?>
	<tr id="is_redirect" style="display:none;">
		<!-- <td  class="tdLabel2" align="right"  >Redirect From Registration:</td> -->
		<td  align="left"><?php echo $this->Form->input('Redirect From Registration',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'redirect','class'=>'','checked'=>$redrct));
		echo "Redirect From Registration";?>
		</td>  
	</tr>
	
	<?php $uniqueId = Configure::read('prefix');?>
	<tr id="prefix" style="display:none;">
		<td><?php echo __('Prefix')?></td>
		
		<td id='prefixTdID' style="display:none;"><?php echo $this->Form->input('value_key_prefix',array('type'=>'select','options'=>array(''=>'Please Select',$uniqueId),'div'=>false,'label'=>false,'id'=>'value_key'))?></td>
		<td id="pharmacyTdID" style="display:none;"><?php echo $this->Form->input('value_key_phar',array('type'=>'text','div'=>false,'label'=>false,'id'=>'pharmacy_id'))?></td>
		<td><?php echo $this->Form->input('prefix',array('type'=>'text','div'=>false,'label'=>false,'id'=>'prefix_id'))?></td>
	</tr>

	<?php
	$countSignature = count(unserialize($signature['Configuration']['value']));
	$unserializeArray = (unserialize($signature['Configuration']['value']));
	
	$arrayCount = array();
	foreach($unserializeArray as $keyCount => $countValue){
		$arrayCount[] = count($countValue);
	}
	$sum = 0;
	foreach($arrayCount as $counterVal){
		$sum = $counterVal+$sum;
	}
	 if($sum == '0'){
	 	$countSignature ='1';
	 }else{
	 	$countSignature = $sum;
	 }
	$i=0; 
	if(empty($unserializeArray)){?>
		<tr class="signatureTrID" style="display: none;" id="signatureTrID_<?php echo $i;?>">
			<td><?php echo __('Select Sub Specialty:');?></td>
			<td><?php 
				$valTestGroupArray = Configure::read('lab_type');
				 
				echo $this->Form->input('specialty',array('type'=>'select','options'=>$valTestGroupArray,'empty' => __ ( 'Please Select ' ),'id'=>'specialty_'.$i,'name'=>"data[User][specialty][$i]",'div'=>false,'label'=>false));
			?>
			</td>

			<td><?php echo __('Signature')?></td>
			<td><?php echo $this->Form->input('signature',array('type'=>'textarea','id'=>'signature_'.$i,'div'=>false,'label'=>false,'name' => "data[User][signature][$i]",'value'=>$loopSignature,'placeholder'=>'Ex:- Dr.DoctorName (MBBS)'))?>
				<?php if($i==0){ ?> <span style="float: right;"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addMore_".$i,'title'=>'Add1','class'=>'addMore'));?>
			</span> <?php }?>
			</td>
		</tr>
		 
	<?php }else{
	 
	 foreach($unserializeArray as $key=> $loopSignature){
			 
	 	foreach($loopSignature as $keyInner => $innerVal){?>
		<tr class="signatureTrID" style="display: none;" id="signatureTrID_<?php echo $i;?>">
				<?php if($uniqueName != $key){
					$uniqueName = $key;
					?>
			<td><?php echo __('Select Sub Specialty:');?></td>
			<td><?php echo $this->Form->input('specialty',array('type'=>'select','options'=>Configure::read('lab_type'),'empty' => __ ( 'Please Select' ),'id'=>'specialty_'.$i,'name'=>"data[User][specialty][$i]",'div'=>false,'label'=>false,'value'=>$key));?></td>
			<td><?php echo __('Signature')?></td>
			<?php }else{?>
				  <td></td>
				  <td><?php echo $this->Form->input('specialty',array('type'=>'select','options'=>Configure::read('lab_type'),'empty' => __ ( 'Please Select' ),'id'=>'specialty_'.$i,'name'=>"data[User][specialty][$i]",'div'=>false,'label'=>false,'value'=>$key));?></td>
				  <td></td>
			<?php }?>
			<td><?php echo $this->Form->input('signature',array('type'=>'textarea','id'=>'signature_'.$i,'div'=>false,'label'=>false,'name' => "data[User][signature][$i]",'value'=>$innerVal))?>
				
			</td>
			<?php if($i==0){ ?>
				<td style="float: right;"><?php echo $this->Html->image('icons/plus_6.png', array('id'=>"addMore_".$i,'title'=>'Add2','class'=>'addMore'));?></td>
				<?php }?>
			<td><?php echo $this->Html->image('icons/cross.png',array('id'=>'cross_'.$i,'class'=>'cross','title'=>'REMOVE ITEM'));?> </td>
		</tr>
		
		<?php $i++;}?>
		
		<?php }
	}?>

	<tr>
	<td>
	<div id="smsConfig" style="display:none;">
	</div>  <!--BOF-Mahalaxmi For SMS -->
	</td>
	</tr>
	<tr id="select-user" style="display:none;">
	    <td width="120" class="tdLabel2" align="right">Select User to give privileges: <font color="red"> *</font></td>
	    <td width="300">
	    	<table class="example" border=0>
				<tr>
					 <td>
					 	<?php echo $this->Form->input('left_user',array('type'=>'select','options'=>array(),'multiple'=>true,'size'=>10,'div'=>false,'label'=>false,'id'=>'left','style'=>'width:150px'));?>
					 </td>
					 
					 <td>
						<input type="button" name="right" value="&gt;&gt;"  onClick="move_list_items('left','right')"><br><br>
						<input type="button" name="right" value="All &gt;&gt;" onClick="move_list_items_all('left','right')"><br><br>
						<input type="button" name="left" value="&lt;&lt;" onClick="move_list_items('right','left')"><br><br>
						<input type="button" name="left" value="All &lt;&lt;"  onClick="move_list_items_all('right','left')">
					 </td>
					 
					 <td>
					 	<?php echo $this->Form->input('right_user',array('type'=>'select','options'=>array(),'multiple'=>true,'size'=>10,'div'=>false,'label'=>false,'id'=>'right','style'=>'width:150px'));?>
					 </td>
				</tr>
			</table>
	    </td>                         
	</tr>
	
	<!-- Re-test -->
	<tr id="reTest" style="display:none;">
	    <td width="120" class="tdLabel2" align="right">Select User to give privileges: <font color="red"> *</font></td>
	    <td width="300">
	    	<table class="example" border=0>
				<tr>
					 <td>
					 	<?php echo $this->Form->input('left',array('type'=>'select','options'=>array(),'multiple'=>true,'size'=>10,'div'=>false,'label'=>false,'id'=>'left-reTest','style'=>'width:150px'));?>
					 </td>
					 
					 <td>
						<input type="button" name="right" value="&gt;&gt;"  onClick="move_list_items_retest('left-reTest','right-reTest')"><br><br>
						<input type="button" name="right" value="All &gt;&gt;" onClick="move_list_items_all_retest('left-reTest','right-reTest')"><br><br>
						<input type="button" name="left" value="&lt;&lt;" onClick="move_list_items_retest('right-reTest','left-reTest')"><br><br>
						<input type="button" name="left" value="All &lt;&lt;"  onClick="move_list_items_all_retest('right-reTest','left-reTest')">
					 </td>
					 
					 <td>
					 	<?php echo $this->Form->input('right',array('type'=>'select','options'=>array(),'multiple'=>true,'size'=>10,'div'=>false,'label'=>false,'id'=>'right-reTest','style'=>'width:150px'));?>
					 </td>
				</tr>
			</table>
	    </td>                         
	</tr>
	
	<!-- EOF Re-test -->
	<tr id="appointmentTime" style="display:none;">
	<!--  <td><?php echo __('Allow Appointment Time')?></td>-->	
		
		<td ><?php echo $this->Form->input('Configuration.value',array('type'=>'checkbox','div'=>false,'label'=>false,'id'=>'appointmentTime'));
					echo __('Allow Appointment Time');?></td>
	</tr>
	<!-- BOF EMAIL CONFIGURATION -->
	
<?php if(empty($email)){?>
	<tr class="emailID" style="display:none;">
		<td id="emailDiv">
		  <table id="EmailTable" border="0">
		 	<tr id="mainRow_1"> 
		   	 <td>
		  		<table id="EmailTable_1">
		    		<tr id="row_1" class="emailRow">
		    			<td><label><span>Email Config:</span> </td>
				     	<td>
				       <div class="input text"><input name="data[User][email_config][1]" id="configName_1" field_no="1" class="config_name" style="width:100px;" type="text"/></div>
				         <input type="hidden"  id="configId_1"/> </label> 
				     	</td>
				     </tr>
				     <tr>
				     	<td>&nbsp;</td>
					     <td>
					       <label><span>Email ID:</span> 
					        <div class="input text"><input name="data[User][Config][email_id][1][1]" class="email" field_no="1" id="email_1_1" style="width:190px;" type="text" placeholder="Ex:- test@testmail.com" /></div>
					        <input type="hidden"  class="emailId" id="emailId_1_1"/>      </label> 
					     </td>
				      <td>
				       <label><span>&nbsp;</span>  </label> 
				     </td>
				     <td>
				       <label><span>SMS Number:</span> 
				        <div class="input text"><input name="data[User][Config][sms_number][1][1]" class="smsNo" field_no="1" id="smsNo_1_1" style="width:190px;" type="text"  placeholder="SMS Number" maxlength="10"/></div>
				        <input type="hidden"  class="smsNum" id="smsNum_1_1"/>      </label> 
				     </td>
				     <td>
				       <label><span>&nbsp;</span> </label> 
				     </td>
				   </tr>
		  		 </table>
		   </td>
		   <td valign="bottom">
			     <label><span>&nbsp;</span>  
			      <input name="" type="button" value="Add More Emails" class="blueBtn Add_more" onclick="addFieldEmail('1')" />
			      <input type="hidden" value="1" id="nofield_1"/>
			     </label> 
		   </td>
		   <td></td>
		  </tr>
		 </table>
		</div>
		 <div>
		   <label>   
		    <input name="" type="button" value="Add More Email Config" class="blueBtn Add_more"onclick="addFieldsConfig()" />
		    <input type="hidden" value="1" id="no_of_field" />
		   </label> 
		 </div>
	 </td>
 </tr>
	<?php }else{ 
		?>
		
		<tr class="emailID" style="display:none;">
		<td id="emailDiv">
		  <table id="EmailTable" border="0">
		 	<tr id="mainRow_<?php echo $conKey;?>"> 
		   	 <td>
		  		<?php foreach ($email as $conKey=>$ConfigVal){// debug($ConfigVal['Configuration']['id']);?>
		  		<table id="EmailTable_<?php echo $conKey;?>">
		    		 <tr id="row_<?php echo $conKey;?>" class="emailRow">
		    			<td><label><span>Email Config:</span> </td>
				     	<td>
				      	 <div class="input text"><input name="data[User][email_config][<?php echo $conKey; ?>]" id="configName_<?php echo $conKey;?>" field_no="<?php echo $conKey;?>" value="<?php echo $ConfigVal['Configuration']['name'];?>" class="config_name" style="width:100px;" type="text"/></div>
				         <input type="hidden"  id="configId_<?php echo $conKey;?>"/>
				         <input name="data[User][ConfigId][<?php echo $conKey; ?>]" type="hidden"  id="emailConId" value="<?php echo $ConfigVal['Configuration']['id'];?>"/> 
				          </label> 
				     	</td>
				     </tr>
				     <?php 
						$unserData=unserialize($ConfigVal['Configuration']['value']); 
						$countUnserData=count($unserData['email_id']);
						for ($loopVar = 1; $loopVar<=$countUnserData; $loopVar++){
						
					?>	
					
			     <tr id="row_<?php echo $conKey."_".$loopVar;?>">
				     <td>&nbsp;</td>
				    
				     <td>
				      	<label><span>Email ID:</span> 
				        <div class="input text"><input name="data[User][Config][email_id][<?php echo $conKey?>][<?php echo $loopVar;?>]" class="email" field_no="<?php echo $loopVar;?>" id="email_<?php echo $conKey?>_<?php echo $loopVar;?>" style="width:190px;" type="text" placeholder="Ex:- test@testmail.com" value="<?php echo $unserData['email_id'][$loopVar];?>"/></div>
				        <input type="hidden"  class="emailId" id="emailId_<?php echo $conKey?>_<?php echo $loopVar;?>]"/>      </label> 
				     <td>
				       <label><span>&nbsp;</span>  </label> 
				     </td>
		      		 <td>
				       <label><span>SMS Number:</span> 
				        <div class="input text"><input name="data[User][Config][sms_number][<?php echo $conKey?>][<?php echo $loopVar;?>]" class="smsNo" field_no="<?php echo $loopVar;?>" id="smsNo_<?php echo $conKey?>_<?php echo $loopVar;?>" style="width:190px;" type="text"  maxlength="10" placeholder="SMS Number" value="<?php echo $unserData['sms_number'][$loopVar];?>" /></div>
				        <input type="hidden"  class="smsNum" id="smsNum_<?php echo $conKey?>_<?php echo $loopVar;?>"/>      </label> 
				     </td>
				    
				     <td>
				       <label><span>&nbsp;</span> </label> 
				     </td>
				      <td>
				      <a href="javascript:void(0);" id="delete" onclick="deletRow(<?php echo $conKey; ?>,<?php echo $loopVar;?>);"> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Item" /></a>
				     </td> 
			 	  </tr>

				   <?php } ?>
				   <tr>
				   <td colspan="5">
				       <label><span>&nbsp;</span> </label> 
				    </td>		
				   	<td valign="bottom">
						     <label><span>&nbsp;</span>  
						      <input name="" type="button" value="Add More Emails" class="blueBtn Add_more" onclick="addFieldEmail(<?php echo $conKey;?>)" />
						      <input type="hidden" value="<?php echo $loopVar-1;?>" id="nofield_<?php echo $conKey;?>"/>
						     </label> 
					   </td>
				   </tr>
			  		 </table>
				   <?php }?>
		   </td>
		 
		   <td></td>
		  </tr>
		 </table>
		</div>
		 <div>
		   <label>   
		    <input name="" type="button" value="Add More Email Config" class="blueBtn Add_more"onclick="addFieldsConfig()" />
		    <input type="hidden" value="1" id="no_of_field" />
		   </label> 
		 </div>
	 </td>
 </tr>

	<?php }?>	
	<!-- EOF EMAIL CONFIGURATION -->
</table>
	<table width="100%" cellpadding="0" cellspacing="5" border="0" align="center" id= "submitTbl" style="display:none;">
		<tr>
			<td ></td>
			<td align="center"><?php			
			echo $this->Form->submit(__("Submit"),array('class'=>'blueBtn','div'=>false,'id'=>'Submit'));?>
			</td>
			<td align="center"><?php 
			echo $this->Html->link ( __ ( 'Back', true ), array ('controller' => 'users','action' => 'menu','?' => array ('type' => 'master')),
			 array ('escape' => false,'class' => 'blueBtn') );
			?>
			</td>
		</tr>
	</table>
</div>
</td>
</tr>	
</table>
<?php echo $this->Form->end(); ?>

<script>



function addFieldEmail(no){
	 var count = parseInt($("#nofield_"+no).val())+1;
	 var field = '';
	 field += '<tr id="row_'+no+'_'+count+'" class="emailRow">';
	 field += "<td>"; 
	 field += "</td>";
	 field += "<td>";
	 field +=   "<label><span>Email ID:</span> ";
	 field +=    "<input type='text' id='email_"+no+"_"+count+"' class='email' name='data[User][Config][email_id]["+no+"]["+count+"]' style='width:190px;' placeholder='Ex:- test@testmail.com'/>";
	 field +=    "<input type='hidden' id='emailId_"+no+"_"+count+"' class='emailId'/>";
	 field +=   "</label> ";
	 field += "</td>";
	 field +="<td>";
	 field +="</td>";
	 field += "<td>";
	 field +=   "<label><span>SMS Number:</span> ";
	 field +=    "<input type='text' id='smsNo_"+no+"_"+count+"' class='smsNo' name='data[User][Config][sms_number]["+no+"]["+count+"]' style='width:190px;' placeholder='SMS Number' maxlength='10' />";
	 field +=    "<input type='hidden' id='smsNum_"+no+"_"+count+"' class='smsNum'/>";
	 field +=   "</label> ";
	 field += "</td>";
	 field +="<td>";
	 field +="</td>";
	 field += "<td>";
	 field +=  "<label><span>&nbsp;</span>"; 
	 field +=    '<a href="javascript:void(0);" id="delete" onclick="deletRow('+no+','+count+');"> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Row" title="Remove Item" /></a>';
	 field +=  "</label>";
	 field += "</td>";
	 field += "</tr>";

	 $("#EmailTable_"+no).append(field);
	 $("#nofield_"+no).val(count);
	}


	function addFieldsConfig(){
	 var no_of_field = parseInt($("#no_of_field").val())+1; 
	 var field = '';
	 field += '<tr id="mainRow_'+no_of_field+'" class="emailRow">';
	 field += '<td>';
	 field += '<table id="EmailTable_'+no_of_field+'">';
	 field +=  '<tr id="row_'+no_of_field+'">';
	 field +=   '<td>';
	 field +=     '<label><span>Email Config:</span> ';
	 field +=    '</td>';
	 field +=    '<td>';
	 field +=     '<input name="data[User][email_config]['+no_of_field+']" id="configName_'+no_of_field+'" style="width:100px;" class="config_name"/>';
	 field +=     '<input type="hidden" id="configId_'+no_of_field+'" />';
	 field +=    '</label>'; 
	 field +=  '</td>';
	 field +=  '</tr>';
	 field +=  '<tr>';
	 field +=	'<td>';
	 field +=	'</td>';
	 field +=   "<td>";
	 field +=     "<label><span>Email ID:</span> ";
	 field +=      "<input type='text' name='data[User][Config][email_id]["+no_of_field+"][1]' class='email' id='email_"+no_of_field+"_1' style='width:190px;' placeholder='Ex:- test@testmail.com'/>";
	 field +=      "<input type='hidden' id='emailId_"+no_of_field+"_1' class='email'/>";
	 field +=     "</label> ";
	 field +=   "</td>"; 
	 field +=   "<td>";
	 field +=     "<label><span>&nbsp;</span>"; 
	 field +=     "</label>";
	 field +=   "</td>";
	 field +=   "<td>";
	 field +=     "<label><span>SMS Number</span> ";
	 field +=      "<input type='text' name='data[User][Config][sms_number]["+no_of_field+"][1]' class='smsNo' id='smsNo_"+no_of_field+"_1' style='width:190px;' placeholder='SMS Number' maxlength='10' />";
	 field +=      "<input type='hidden' id='smsNum_"+no_of_field+"_1' class='smsNum'/>";
	 field +=     "</label> ";
	 field +=   "</td>"; 
	 
	 field +=   "<td>";
	 field +=     "<label><span>&nbsp;</span>"; 
	 //field +=       '<a href="javascript:void(0);" id="delete" onclick="deletRow('+no_of_field+',1);"> <img src="/Vadodara/theme/Black/img/icons/cross.png" alt="Remove Row" title="Remove Item" /></a>';
	 field +=     "</label>";
	 field +=   "</td>";
	 field +=  "</tr>";
	 field += '</table>';
	 field += '</td>';
	 field += '<td valign="bottom">';
	 field +=   '<label><span>&nbsp;</span> ' ;
	 field +=    '<input name="" type="button" value="Add More Email" class="blueBtn Add_more" onclick="addFieldEmail('+no_of_field+')" />';
	 field +=    '<input type="hidden" value="1" id="nofield_'+no_of_field+'"/>';
	 field +=   '</label> ';
	 field += '</td>';
	 field += '<td valign="bottom">';
	 field +=   '<label><span>&nbsp;</span> ' ; 
	 field +=     '<a href="javascript:void(0);" id="delete" onclick="deleteEmailRow('+no_of_field+');"> <img src="<?php echo $this->webroot ?>theme/Black/img/cross.png" alt="Remove Email Config Row" title="Remove Email Config Row" /></a>';
	 field +=   '</label> ';
	 field += '</td>';
	 field += '</tr>';

	 $("#EmailTable").append(field);
	 $("#no_of_field").val(no_of_field);
	}
	 
	 function deletRow(configId,emailRow){ 
	  $("#row_"+configId+"_"+emailRow).remove(); 
	 }

	 function deleteEmailRow(configId){ 
	  $("#mainRow_"+configId).remove(); 
	 }
	 
	//validate form 
	$("#Submit").click(function(){
		if(!jQuery("#Configuration").validationEngine()){
			return false;
		}	
	});

	//this will move selected items from source list to destination list
	function move_list_items(sourceid, destinationid)
	{ 
	    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
	    $('#right option').prop('selected', true);
	}
	//this will move all selected items from source list to destination list
    function move_list_items_all(sourceid, destinationid)
	{
	    $("#"+sourceid+" option").appendTo("#"+destinationid);
	    $('#right option').prop('selected', true);
	}

	//~~~~~~BOF Re-Test
	
	//this will move selected items from source list to destination list
	function move_list_items_retest(sourceid, destinationid)
	{
	    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
	    $('#right-reTest option').prop('selected', true);
	}
	//this will move all selected items from source list to destination list
    function move_list_items_all_retest(sourceid, destinationid)
	{
	    $("#"+sourceid+" option").appendTo("#"+destinationid);
	    $('#right-reTest option').prop('selected', true);
	}
	
	//~~~~~~EOF Re-Test

	$("#is_new").change(function(){
		if ($(this).is(":checked")){
	         $("#add-config").show();
	         $("#select-config").hide();
	     }else{
	    	 $("#add-config").hide();
	    	 $("#select-config").show();
	     }
	});
	
	$(".config").click(function(){	
		$("#prefix_id").val('');
		$("#pharmacy_id").val('');
		var configId=$(this).attr('id');
		var configName=$(this).attr('name');
		
		$("#configuration_name").val(configName);
		$("#configuration_id").val(configId);
		$("#submitTbl").hide();
		 if(configName !=""){	
			if(configName == 'Prefix'){
				$("#smsConfig").hide();
				$("#submitTbl").show();
				$("#prefix").show();
				$("#is_pharmacy").hide();
				$("#prefixTdID").show();
				$('#left').find('option').remove();
				$('#right').find('option').remove();
				$("#select-user").hide();
				$("#pharmacyTdID").hide();
				$("#appointmentTime").hide();
				$(".signatureTrID").hide();
				$(".emailID").hide();
				$("#reTest").hide();
				$("#is_redirect").hide();
			}else if(configName== 'Laboratory Results'){
				$("#smsConfig").hide();
				$("#submitTbl").show();
				$("#is_pharmacy").hide();
				$("#select-user").show();
				$("#prefix").hide();
				$("#appointmentTime").hide();
		        $(".signatureTrID").hide();
		        $("#reTest").hide();
		        $(".emailID").hide();

				$.ajax({
				  url: "<?php echo $this->Html->url(array("controller" => 'Configurations', "action" => "findAuthenticateUser", "admin" => false)); ?>"+"/"+configId,
				  context: document.body,
				  	beforeSend:function(data){
						$('#busy-indicator').show();
					},
					success: function(data){
						parseData = jQuery.parseJSON(data);
	
						//left users (unselected usesr)
						$('#left').find('option').remove();
						$.each(parseData.all, function(val, text) {
						    $("#left").append( "<option value='"+val+"'>"+text+"</option>" );
						});		
						//right users selected users
						$('#right').find('option').remove();
						$.each(parseData.selected, function(val, text) {
						    $("#right").append( "<option value='"+val+"'>"+text+"</option>" );
						});		
						$('#right option').prop('selected', true);
						
						$('#busy-indicator').hide();
					}
		});	
			}else if(configName == 'Pharmacy'){
				$("#smsConfig").hide();
				$("#submitTbl").show();
				$("#is_pharmacy").show();
				$("#appointmentTime").hide();
				$(".signatureTrID").hide();
				$("#reTest").hide();
				$("#prefix").hide();
				$("#prefixTdID").hide();
				$('#left').find('option').remove();
				$('#right').find('option').remove();
				$("#select-user").hide();
				$(".emailID").hide();
				//$("#pharmacyTdID").show();
		}else if(configName== 'Redirect From Registration'){
				$("#smsConfig").hide();
				$("#submitTbl").show();
				$("#is_redirect").show();
				$("#is_pharmacy").hide();
				$("#prefix").hide();
				$("#prefixTdID").hide();
				$('#left').find('option').remove();
				$('#right').find('option').remove();
				$("#select-user").hide();
				$("#appointmentTime").hide();
				$(".signatureTrID").hide();
				$("#reTest").hide();
				$(".emailID").hide();
			}else if(configName == 'allowTimelyQuickReg'){
				$("#smsConfig").hide();
				$("#submitTbl").show();
				$("#appointmentTime").show();
				$("#is_pharmacy").hide();
				$("#is_redirect").hide();
				$("#prefix").hide();
				$("#prefixTdID").hide();
				$('#left').find('option').remove();
				$('#right').find('option').remove();
				$("#select-user").hide();
				$(".signatureTrID").hide();
				$("#reTest").hide();
				$(".emailID").hide();
		
			}else if(configName == 'Signature'){
				$("#smsConfig").hide();
				$("#submitTbl").show();
				$(".signatureTrID").show();
				$("#appointmentTime").hide();
				$("#is_redirect").hide();
				$("#prefix").hide();
				$("#prefixTdID").hide();
				$("#is_pharmacy").hide();
				$('#left').find('option').remove();
				$('#right').find('option').remove();
				$("#select-user").hide();
				$("#reTest").hide();
				$(".emailID").hide();

			}else if(configName == 'Re-test authority'){
				$("#Submit").removeAttr("onclick");
				$("#smsConfig").hide();
				$("#submitTbl").show();
				$("#is_pharmacy").hide();
				$("#select-user").hide();
				$("#prefix").hide();
				$("#appointmentTime").hide();
		        $(".signatureTrID").hide();
		        $("#reTest").show();
		        $(".emailID").hide();

				$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'Configurations', "action" => "findAuthenticateUser", "admin" => false)); ?>"+"/"+configId,
					  context: document.body,
					  	beforeSend:function(data){
							$('#busy-indicator').show();
						},
						success: function(data){
							parseData = jQuery.parseJSON(data);
		
							//left users (unselected usesr)
							$('#left-reTest').find('option').remove();
							$.each(parseData.all, function(val, text) {
							    $("#left-reTest").append( "<option value='"+val+"'>"+text+"</option>" );
							});		
							//right users selected users
							$('#right-reTest').find('option').remove();
							$.each(parseData.selected, function(val, text) {
							    $("#right-reTest").append( "<option value='"+val+"'>"+text+"</option>" );
							});		
							$('#right-reTest option').prop('selected', true);
							
							$('#busy-indicator').hide();
							}
					});	
			}else if(configName == 'Email'){
						
						$("#smsConfig").hide();
						$("#submitTbl").show();
						$(".signatureTrID").hide();
						$("#appointmentTime").hide();
						$("#is_redirect").hide();
						$("#prefix").hide();
						$("#prefixTdID").hide();
						$("#is_pharmacy").hide();
						$('#left').find('option').remove();
						$('#right').find('option').remove();
						$("#select-user").hide();
						$("#reTest").hide();
						$(".emailID").show();

			}else if(configName== 'SMS'){
				//$("#submitTbl").hide();
				$("#smsConfig").show();
				$("#Submit").attr('onclick','jsfunction();return false;');
				$("#submitTbl").show('slow');
				$(".signatureTrID").hide();
				$("#appointmentTime").hide();
				$("#is_redirect").hide();
				$("#prefix").hide();
				$("#prefixTdID").hide();
				$("#is_pharmacy").hide();
				$('#left').find('option').remove();
				$('#right').find('option').remove();
				$("#select-user").hide();
				$("#reTest").hide();
				$(".emailID").hide();
					$.ajax({
					  url: "<?php echo $this->Html->url(array("controller" => 'Messages', "action" => "smsTrigger", "admin" => false)); ?>"+"/"+configId,
					  context: document.body,
					  	beforeSend:function(data){
							$('#busy-indicator').show();
						},
						success: function(data){
							$('#smsConfig').html(data);
							$('#busy-indicator').hide();
							}
					});	
		}
	}else{
		$("#smsConfig").hide();
		$("#submitTbl").hide();
		$("#is_pharmacy").hide();
		$("#is_redirect").hide();
		$('#left').find('option').remove();
		$('#right').find('option').remove();
		$("#select-user").hide();
		$("#prefix").hide();
		$("#appointmentTime").hide();
		$(".signatureTrID").hide();
		$("#reTest").hide();
		$(".emailID").hide();
	}
		
});
	
		var  counterSignature = '<?php echo $countSignature;?>';
		$(document).ready(function(){
		$('.addMore').on('click',function(){
		idd = $(this).attr('id');
		
		newId = idd.split("_");
		 
		$("#table_"+newId[1])
		.append($('<tr>').attr({'id':'newRow_'+counterSignature,'class':'newRow'})
				.append($('<td>')).append($('<select>').attr({'id':'specialty_'+counterSignature,'type':'select','empty':'Please Select','name':'data[User][specialty]['+counterSignature+']'}))
			.append($('<td>'))
    		.append($('<td>').append($('<textarea >').attr({'id':'signature_'+counterSignature,'type':'textarea','rows':'6','cols':'30','name':'data[User][signature]['+counterSignature+']','autocomplete':'off','placeholder':'Ex:- Dr.DoctorName (MBBS)'})))

    		.append($('<td>').append($('<img>').attr('src',"<?php echo $this->webroot ?>theme/Black/img/cross.png")
			.attr({'class':'removeButton','id':'removeButton_'+counterSignature,'title':'Remove current row'}).css('float','right')))
			)	
			getSpecialty();
			counterSignature++;
		$('.removeButton').on('click',function(){
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#newRow_"+ID).remove();
			 
	 	});
		
	});

		function getSpecialty(){
	 	 var selectSpecialty = <?php echo json_encode(Configure::read('lab_type')); ?>;
	 	 	$.each(selectSpecialty, function(key, value) {
	 	 	 	$('#specialty_'+counterSignature).append(new Option(value , key) );
	 		});
	 	}
	 	
	 	/*$('#addSigMore').on('click',function(){
	 		var prev = $("#signature_0").val();
	 		var sig = $("#textSig").html();
	 		if(sig == ''){
	 			$("#textSig").html();
	 			$("#textSig").html(prev + '\r\n');
	 		}else{
	 			$("#textSig").html('----------------------------\r\n' + prev);
	 		}
	 	}*/

		 
			$('.cross').on('click',function(){
			currentId=$(this).attr('id');
			splitedId=currentId.split('_');
			ID=splitedId['1'];
			$("#signatureTrID_"+ID).remove();
			 
		});
	});
/*** Script for Side-bar***/	 
		( function( $ ) {
			$( document ).ready(function() {
			$('#cssmenu ul ul li:odd').addClass('odd');
			$('#cssmenu ul ul li:even').addClass('even');
			$('#cssmenu > ul > li > a').click(function() {
			  $('#cssmenu li').removeClass('active');
			  $(this).closest('li').addClass('active');	
			  var checkElement = $(this).next();
			  if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			    $(this).closest('li').removeClass('active');
			    checkElement.slideUp('normal');
			    $("#is_pharmacy").hide();
				$("#is_redirect").hide();
				$('#left').find('option').remove();
				$('#right').find('option').remove();
				$("#select-user").hide();
				$("#prefix").hide();
				$("#appointmentTime").hide();
				$(".signatureTrID").hide();
				$("#reTest").hide();
				$("#submitTbl").hide();
				$(".emailID").hide();
			  }
			  if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			    $('#cssmenu ul ul:visible').slideUp('normal');
			    checkElement.slideDown('normal');
			  }
			  if($(this).closest('li').find('ul').children().length == 0) {
			    return true;
			  } else {
			    return false;	
			  }		
			});
			});
			} )( jQuery );

	
	function jsfunction(){
	 	 var formData = $('#Configuration').serialize();
		 var ajaxUrl= "<?php echo $this->Html->url(array("controller" => "Messages", "action" => "saveSmsTrigger","admin" => false)); ?>";
				$.ajax({					
					  type: 'POST',
					  url: ajaxUrl,
					  context: document.body,
					  data: formData,
	    	    	  dataType: 'html',
					  beforeSend:function(data){
							$('#busy-indicator').show();
					  },
					  success: function(data){	
						 // return false;
						   location.reload(); 						
							$('#busy-indicator').hide();
							}
					});	
	}
</script>
