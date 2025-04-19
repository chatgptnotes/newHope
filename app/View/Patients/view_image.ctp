<!-- <div style="padding-top: 20px; padding-left: 20px;"> -->
<div>
	<?php 
		if(file_exists(WWW_ROOT."uploads/patient_images/thumbnail/".$this->request->query['image']) && !empty($this->request->query['image'])){
			echo $this->Html->image("/uploads/patient_images/thumbnail/".$this->request->query['image'], array('alt' =>'Insurance Card',
					'title'=>'Insurance Card','width'=> '249', 'height' => '250'));

		}	?>
</div>
<!-- </div> -->

