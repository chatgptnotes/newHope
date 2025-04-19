<?php //html of button template listing 
 
 	echo "<ul>" ;
	foreach ($btnTemplate as $key => $value){ 
		echo "<li>" ;
		echo $this->Html->link($value,"javascript:void(0)",array('escape'=>false,'class'=>"search-btn-template",'id'=>"search-btn-template_$id-$key"));
		echo "&nbsp;&nbsp;&nbsp;";
		echo $this->Html->image('icons/cross.png',array('escape'=>false,'class'=>"delete-template",'id'=>$id."-".$key,'style'=>"float:right;"));
		echo "</li>"; 
	}
	echo "</ul>" ;
?>

 
