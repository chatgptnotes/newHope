


<div class="separator"></div>


<div class="separator"></div>

<div>

	<table border="0" cellpadding="5" cellspacing="2">
	
<?php
echo $this->element('Aros/links');
?>
<div class="separator"></div>
<h4 align="center"> Manage the label and Description for the Screen</h4>
<div class="separator"></div>
<div class="separator"></div>
<div class="separator"></div>	
	<form action="" method='post'>
	<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="save" value="Save"></td></tr>
	<tr><td>&nbsp;</td><td>Label</td><td>Description</td></tr>
	<?php
	$previous_ctrl_name = '';
	$i = 0;
	
		foreach($actions as $key => $value)
		{
	
			$aco = Classregistry::init('Aco');
		  	
			$parent = $aco->findById($value['Aco']['parent_id']);
		
		
	    		echo '<tr >
	    		';
	    		
	    		echo '<td>' . $parent['Aco']['alias'].'-->'.$value['Aco']['alias']. '</td>';
	    		
		    	echo '<td><input type="text" name="label['.$value['Aco']['id'].']" value="'.$value['Aco']["label"].'"></td>';
				echo '<td><input type="text" name="desc['.$value['Aco']['id'].']" value="'.$value['Aco']["desc"].'"></td>';
	    		
		    	echo '</tr>';
			
	}
	
	
	
	?>
	<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="save" value="Save"></td></tr>
		</form>

</div>


<?php
echo $this->element('design/footer');
?>