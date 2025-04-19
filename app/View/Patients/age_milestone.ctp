<style>
.dev_inner span{ float:left;width: 117px;}
</style>

<div style="border-bottom: 0px solid #4C5E64; padding-left: 20px;padding-bottom:4px;" class="tdLabel">
	
		     <div class="dev_inner" style="">
				<br /> <span>Motor:</span>
				<?php echo $this->Form->input('BmiResult.location',array('options'=>Configure::read('location'),'style'=>"width:130px;float:left",'value'=>$result1['BmiResult']['location'],'id' => 'spo','label'=>false,));?>
				<br /> <br /> <br />
			</div>
			
			<div class="dev_inner" style="">
				 <span>Speech:</span>
				<?php echo $this->Form->input('BmiResult.location',array('options'=>Configure::read('location'),'style'=>"width:130px;float:left",'value'=>$result1['BmiResult']['location'],'id' => 'spo','label'=>false,));?>
				<br /> <br />
			</div>
			
			<div class="dev_inner" style="">
				<br /> <span>Vision and hearing:</span>
				<?php echo $this->Form->input('BmiResult.location',array('options'=>Configure::read('location'),'style'=>"width:130px;float:left",'value'=>$result1['BmiResult']['location'],'id' => 'spo','label'=>false,));?>
				<br /> <br />
			</div>
			
			<div class="dev_inner" style="">
				<br /> <span>Social:</span>
				<?php echo $this->Form->input('BmiResult.location',array('options'=>Configure::read('location'),'style'=>"width:130px;float:left",'value'=>$result1['BmiResult']['location'],'id' => 'spo','label'=>false,));?>
				<br /> <br />
			</div>
			<div class="dev_inner" style="">
				<br/><span> Age Is</span> : &nbsp; &nbsp;<?php echo $this->Form->input('BmiResult.face_score',array('type'=>'text','id'=>'faceScore','value'=>$result1['BmiResult']['face_score'],'label'=>false,'style'=>'width:40px'))?>
			</div>
</div>