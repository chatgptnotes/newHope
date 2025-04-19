<?php echo $this->element('header'); ?>
	
<!-- Body Part Template 
<div class="body_template">-->

<!-- Left Part Template  
<div class="left_template">-->

<!-- First Tab Department
<div class="tab_dept">-->

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<!-- Left Part Template -->
		<td width="278" height="400" align="left" valign="top" class="left_template">
			<?php   
				#echo '<pre>';print_r($_SESSION);exit;
				$roleType = $this->Session->read('role');
				if($roleType == 'superadmin'){
					echo $this->element('left_navigation_superadmin');	
				}else if($roleType == 'admin'){
					echo $this->element('left_navigation_admin');	
				}else{
					echo $this->element('left_navigation');	
				}
			?>
		</td>
	 	<td valign="top" align="left" class="rightTopBg">
	    	 <?php echo $this->Session->flash(); ?></div>
			 <?php echo $content_for_layout; ?>
	    </td>
    </tr>
</table>

</div>
<!-- Body Part Template Ends here -->
<?php echo $this->element('footer'); ?>

 
	
