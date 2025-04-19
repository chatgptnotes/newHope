<?php 
//pr($data);exit;
  if(!empty($errors)) {
?>

<table border="0" cellpadding="0" cellspacing="0" width="60%"  align="center">
 <tr>
  <td colspan="2" align="left"><div class="alert">
   <?php 
     foreach($errors as $errorsval){
         echo $errorsval[0];
         echo "<br />";
     }
   ?></div>
  </td>
 </tr>
</table>
<?php } ?>
<div class="inner_title">
<h3>&nbsp; <?php echo __('Complaints', true); ?></h3>

</div>
 <?php 
echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'admin_complaints')
																	,'id'=>'orderfrm', 
															    	'inputDefaults' => array(
															        'label' => false,
															        'div' => false,'error'=>false
															    )
						));
?>
 <table align="center">
	
	 
	 <tr>
	 <td colspan="8" align="right">Format</td>
	 <td><b>:</b></td>
	 <td colspan="8" align="left"><?php
		echo $this->Form->input('format', array('id' => 'formattype', 'label'=> false, 'div' => false, 'error' => false,'options'=>array('EXCEL'=>'EXCEL','PDF'=>'PDF')));
	 ?></td>
	 </tr>
	<tr>
	 <td colspan="8" align="right">From</td>
	 <td><b>:</b></td>
	  <td colspan="8" align="left">
	    <?php 
	       $currentYear = date("Y");
                                 for($i=0;$i<=10;$i++) {
                                    $lastTenYear[$currentYear] = $currentYear;
                                    $currentYear--;
                                 }
		    		 echo    $this->Form->input('year', array('class' => 'validate[required,custom[mandatory-select]]', 'id' => 'year', 'label'=> false, 'div' => false, 'error' => false,'autocomplete'=>false,'options' =>$lastTenYear, 'value' =>$reportYear));
	  ?>
		
	  </td>
	  </tr> 
 </table>
 
	   <p class="ht5"></p>
	   <div align="center">
	  
		<div class="btns" style="float:none">
				<input type="submit" value="Get Report" class="blueBtn" id="submit" >&nbsp;&nbsp;
				
				 
				<?php echo $this->Html->link(__('Cancel', true),array('action' => 'all_report','admin'=>true), array('escape' => false,'class'=>'blueBtn'));?>
		</div>
		
	 </div> 
 <?php echo $this->Form->end(); ?>
 <script language="javascript" type="text/javascript">

 function changeRequest(action){
	 $('#orderfrm').attr('action',action);
	 $('#orderfrm').submit;
 }
   

	</script> 