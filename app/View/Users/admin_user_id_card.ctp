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
a {
	color: blue;
}

a:hover {
	color: blue;
}

.cardTop {
	height: 50px;
	padding: 4px;
}

.cardArea {
	height: 180px;
	padding: 4px;
	background-color: red;
}

.cardLeft {
	width: 225px;
	float: left;
}

.cardbottom {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
	height: 50px;
	margin-left: -18px;
	padding: 0;
	text-align: center;
}

.cardName {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	text-decoration: none;
	margin: 0;
	letter-spacing: -0.5px;
	padding-left: 60px;
}

.userInfo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	text-decoration: none;
	margin-top: 120px;
	padding: 0;
	letter-spacing: -0.5px;
}

.text-cls {
	color: #FFFFFF;
	list-style: none outside none;
	padding-left: 60px;
}

.ulbottom {
	list-style: none;
	margin-left: -21px;
}

.parentDiv {
	border: 1px solid #000000;
	width: 210px;
}
</style>
</head>
<!--  onload="window.print();window.close();" -->
<body style="background: #fff; color: #000">
	<!--  onload="window.print()";> -->
	<div class="parentDiv">
		<div class="cardTop">
			<?php echo $this->Html->image("logo_check.png", 
					array('style'=>'align:center;padding-left: 51px;', 'width'=> '100', 'height' => '46','alt' => 'logo','title'=>'logo'));

			?>
		</div>
		<div class="cardArea">
			<?php // echo $idCardArray['photo'];//$complete_name  = '' ; ?>
			<?php if(file_exists(WWW_ROOT."/uploads/user_images/".$idCardArray['userPhoto']) && !empty($idCardArray['userPhoto'])){ 
				echo $this->Html->image("/uploads/user_images/".$idCardArray['userPhoto'], array('alt' => $idCardArray['completeName'],
						'title'=>$idCardArray['completeName'],'width'=> '80', 'height' => '100','class'=>'cardName'));
	         	$image = true;
			}else{
					$image = false;
					}	?>
			<div class="userInfo">
				<div class="cardleft">
					<?php if(file_exists(WWW_ROOT."/uploads/userqrcodes/".$idCardArray['userName'].".png")){ 
					 echo $this->Html->image("/uploads/userqrcodes/".$idCardArray['userName'].".png",
							array('style'=>'float:left','alt' => $idCardArray['completeName'],'title'=>$idCardArray['completeName'], 'width'=> '55', 'height' => '53'));
					}
					?>
					<ul class="text-cls">
						<li style="font-color: #fff"><?php
						echo $idCardArray['completeName'];
						?>
						</li>
						<li><?php echo $idCardArray['role']; ?>
						</li>
						<li><?php echo $idCardArray['department']; ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="cardbottom">
			<ul class="ulbottom">
				<li><?php echo __($idCardArray['facilityAddress']);?></li>
				<li><?php echo __($idCardArray['facilityPhone']);?></li>
				<li><?php echo __("www.drmcadecues.com");?></li>
			</ul>

		</div>
	</div>

</body>
<script>
$(document).ready(function (){
				var condition = '<?php echo $image ?>';
				if(condition){
				window.print();
				}else{
					alert("please upload user's image.");
					parent.$.fancybox.close();
				}
});				
</script>
</html>

