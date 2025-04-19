<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
	xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->Html->charset(); ?>
<title><?php echo __('Hope', true); ?> <?php echo $title_for_layout; //onload="window.print();window.close();"?>
</title>
<?php echo $this->Html->css(array('internal_style.css')); 
echo $this->Html->script(array('jquery-1.5.1.min'));?>
<style>

.parentDiv {
	border: 1px solid #000000;
	width: 100%;
}
</style>
</head>
<!--  onload="window.print();window.close();" -->
<body style="background: #fff; color: #000">
	<!--  onload="window.print()";> -->
	<div class="parentDiv">
		
		<div class="cardArea">
			<?php //debug($idCardArray);
			// echo $idCardArray['photo'];//$complete_name  = '' ; ?>
			<?php if(file_exists(WWW_ROOT."/uploads/user_images/".$idCardArray[0]['PatientDocument']['filename']) && !empty($idCardArray[0]['PatientDocument']['filename'])){
				$type=explode('/',$idCardArray[0]['PatientDocument']['type']);
				if($type[0]=="text"){
						echo file_get_contents(WWW_ROOT."/uploads/user_images/".$idCardArray[0]['PatientDocument']['filename'],true);
				}				
				else if($type[0]=="image"){
				echo $this->Html->image("/uploads/user_images/".$idCardArray[0]['PatientDocument']['filename'], array('alt' => $idCardArray[0]['name'],
						'title'=>$idCardArray[0]['name'],'width'=> '100%', 'height' => '100%','class'=>'cardName'));
				}
				/* else if($idCardArray[0]['PatientDocument']['type']="application/vnd.openxmlformats-officedocument.wordprocessingml.document"){
					echo file_get_contents(WWW_ROOT."/uploads/user_images/".$idCardArray[0]['PatientDocument']['filename'],true);
					} */
	         	$image = true;
			}else{
					echo "No Such File Exists!";
					$image = false;
					}	?>
			
		</div>		
	</div>

</body>
<script>
/*$(document).ready(function (){
				var condition = '<?php echo $image ?>';
				if(condition){
					window.print()
				}else{
					alert("please upload user's image.");
					parent.$.fancybox.close();
				}
});	*/			
</script>
</html>

