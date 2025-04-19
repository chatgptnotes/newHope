<script>
var imageUrl= "<?php echo $this->Html->url("/img/color.png"); ?>";
</script>
<?php
echo $this->Html->script(array('izzyColor'));
?>

<div class="inner_title">
<h3><?php echo __('Preferences', true); ?></h3>
</div>

<?php 
  if(!empty($errors)) {
?>
	<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
	 <tr>
	  <td colspan="2" align="left">
	   <?php 
		 foreach($errors as $errorsval){
			 echo $errorsval[0];
			 echo "<br />";
		 }
	   ?>
	  </td>
	 </tr>
	</table>
<?php } ?>

<?php
echo ($this->Session->read('preference'));

?>
<form method="post" action="" name="preference" id="preference">
<table border="0" class="table_format" cellpadding="0" cellspacing="0" width="60%"  align="center">
   <tr>
	<td class="form_lables" align="right">
        <?php echo __('Preferences Mode',true); ?>: 
	</td>
	<td>
       <select name="mode" id="mode" onchange="makeDefault(this);">
		<option value="Default" <?php if($data['mode'] == "Default"){ echo " selected='selected'";}?>>Default</option>
		<option value="Custom" <?php if($data['mode'] == "Custom") {echo " selected='selected'";}?>>Custom</option>
		
	   </select>
	   
	</td>
    </tr>
        <tr>
	<td class="form_lables" align="right">
        <?php echo __('Background Color',true); ?>: 
	</td>
	<td>
       <input type="text" name="backgroundColor" id="backgroundColor" readonly="true" class = 'izzyColor' value="<?php echo $data['backgroundColor'];?>">
	   
	   <input onchange="if(this.checked==true && $('#backgroundColor').val()!=''){$('#backgroundColor').val('');$('#backgroundColor').css('background-color','#121212');}" type="checkbox" value="1" name="defaultSetbackgroundColor" <?php if(empty($data['backgroundColor'])){echo " checked=checked";}?>> Default
	</td>
    </tr>
	<tr>
	<td class="form_lables" align="right">
        <?php echo __('Font Color',true); ?>: 
	</td>
	<td>
       <input type="text" name="fontColor" id="fontColor" readonly="true" class = 'izzyColor' value="<?php echo $data['fontColor'];?>">
	   <input onchange="if(this.checked==true && $('#fontColor').val()!=''){$('#fontColor').val('');$('#fontColor').css('background-color','#121212');}" type="checkbox" value="1" name="defaultSetfontColor" <?php if(empty($data['fontColor'])){echo " checked=checked";}?>> Default
	</td>
        </tr>
	 <tr>
	<td class="form_lables" align="right">
        <?php echo __('Header Background Color',true); ?>: 
	</td>
	<td>
       <input type="text" name="HeaderbackgroundColor" id="HeaderbackgroundColor" readonly="true" class = 'izzyColor' value="<?php echo $data['HeaderbackgroundColor'];?>">
	<input onchange="if(this.checked==true && $('#HeaderbackgroundColor').val()!=''){$('#HeaderbackgroundColor').val('');$('#HeaderbackgroundColor').css('background-color','#121212');}" type="checkbox" value="1" name="defaultSetHeaderbackgroundColor" <?php if(empty($data['HeaderbackgroundColor'])){echo " checked=checked";}?>> Default
	</td>
        </tr>
	  <tr>
	<td class="form_lables" align="right">
        <?php echo __('Text Color for Input Field',true); ?>: 
	</td>
	<td>
       <input type="text" name="textColorforInputField" id="textColorforInputField" readonly="true" class = 'izzyColor' value="<?php echo $data['textColorforInputField'];?>">
		<input onchange="if(this.checked==true && $('#textColorforInputField').val()!=''){$('#textColorforInputField').val('');$('#textColorforInputField').css('background-color','#121212');}" type="checkbox" value="1" name="defaultSettextColorforInputField" <?php if(empty($data['textColorforInputField'])){echo " checked=checked";}?>> Default
	   </td>
        </tr>
		  <tr>
	<td class="form_lables" align="right">
        <?php echo __('Background Color for Input Field',true); ?>: 
	</td>
	<td>
       <input type="text" name="BackgroundColorforInputField" id="BackgroundColorforInputField" readonly="true" class = 'izzyColor' value="<?php echo $data['BackgroundColorforInputField'];?>">
	<input onchange="if(this.checked==true && $('#BackgroundColorforInputField').val()!=''){$('#BackgroundColorforInputField').val('');$('#BackgroundColorforInputField').css('background-color','#121212');}" type="checkbox" value="1" name="defaultSetBackgroundColorforInputField" <?php if(empty($data['BackgroundColorforInputField'])){echo " checked=checked";}?>> Default
	</td>
        </tr>
	<tr>
	<td class="form_lables" align="right">
        <?php echo __('Menu Navigation',true); ?>: 
	</td>
	<td>
       <select name="menuNavigation" id="menuNavigation">
		<option value="Left" <?php if($data['menuNavigation'] == "Left") echo " selected='selected'";?>>Left</option>
		<option value="Right" <?php if($data['menuNavigation'] == "Right") echo " selected='selected'";?>>Right</option>
		<option value="Top" <?php if($data['menuNavigation'] == "Top") echo " selected='selected'";?>>Top</option>
		<option value="Bottom" <?php if($data['menuNavigation'] == "Bottom") echo " selected='selected'";?>>Bottom</option>
		
	   </select>
	   <input onchange="if(this.checked==true){$('#menuNavigation').attr('selectedIndex', 0);}" type="checkbox" value="1" name="defaultSetBackgroundColorforleftPanel" <?php if(empty($data['menuNavigation']) || $data['menuNavigation'] == "Left"){echo " checked=checked";}?>> Default
	</td>
      </tr>
	  <tr>
	<td class="form_lables" align="right">
        <?php echo __('Background Color for Left Panel',true); ?>: 
	</td>
	<td>
       <input type="text" name="BackgroundColorforleftPanel" id="BackgroundColorforleftPanel" readonly="true" class = 'izzyColor' value="<?php echo $data['BackgroundColorforleftPanel'];?>">
	<input onchange="if(this.checked==true && $('#BackgroundColorforleftPanel').val()!=''){$('#BackgroundColorforleftPanel').val('');$('#BackgroundColorforleftPanel').css('background-color','#121212');}" type="checkbox" value="1" name="defaultSetBackgroundColorforleftPanel" <?php if(empty($data['BackgroundColorforleftPanel'])){echo " checked=checked";}?>> Default
	</td>
        </tr>
	 <tr>
	<td class="form_lables" align="right">
        <?php echo __('Background Color for Right Panel',true); ?>: 
	</td>
	<td>
       <input type="text" name="BackgroundColorforRightPanel" id="BackgroundColorforRightPanel" readonly="true" class = 'izzyColor' value="<?php echo $data['BackgroundColorforRightPanel'];?>">
	<input onchange="if(this.checked==true && $('#BackgroundColorforRightPanel').val()!=''){$('#BackgroundColorforRightPanel').val('');$('#BackgroundColorforRightPanel').css('background-color','#121212');}" type="checkbox" value="1" name="defaultSetBackgroundColorforRightPanel" <?php if(empty($data['BackgroundColorforRightPanel'])){echo " checked=checked";}?>> Default
	</td>
        </tr>
		</table>
		 <div class="btns">
		 
                            <input name="Save" type="submit" value="Save" class="blueBtn" tabindex="12"/>
							   <?php 
   //echo $this->Html->link(__('Back'), "/", array('escape' => false,'class'=>'blueBtn'));
   ?>
                  </div>
</form>
<script>
function makeDefault(obj){
	if(obj.value == "Default"){
		$(":input").each(function(i){ 
		 if(this.type == "text"){
			this.value ="";
			this.style.backgroundColor = '#121212';
		}
		if(this.type == "checkbox")
			this.checked =true;			
	});

		$('#menuNavigation').attr('selectedIndex', 0);


	}
}

</script>