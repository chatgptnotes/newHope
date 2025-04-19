<?php
$image=explode(',',$imageName);
foreach($image as $images){
$img=  FULL_BASE_URL.Router::url("/")."uploads/radiology/".$images;

if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$images)) {
    echo $this->Html->image($img, array('alt' => 'Radiology Image','width'=>'100%','height'=>'100%','style'=>'hieght:100%;width:100%'));
}else{
	echo '<img src="'.htmlspecialchars($images).'">';
}

}?>
