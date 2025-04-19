<style>
	.line-height p{
		line-height:0.5;
	}
	.line-height{
		line-height:2;
	}
	body{
		padding:50px;
	}
</style>
<!-- Right Part Template -->
<div style="float:right;" id="printButton">
	<?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
<div style="padding:50px;"> 
	<p class="ht5"></p> 
	<div class="line-height">To,</div>
	<div class="line-height">The Chief Medical Officer,</div>
		<?php echo $this->element('hospital_address');?> 
	<div class="line-height">
	    <p>&nbsp;</p>
		<p>Dear Sir ,</p>
		<p>I am referring patient named <?php echo $patient['Patient']['lookup_name']; ?> 
		of age <?php echo $patient['Patient']['age'];?> years</p><p> resident of <?php echo str_replace("<br/>"," ",$address) ; ?></p>
		<p>for further expert management.</p>
		<p>&nbsp;</p>
		<p>Patient's presenting Complaints / Investigation / Treatment in brief is as follows:</p>
		<div style="margin-left:15px;"><?php 
			echo nl2br($this->data['PatientReferral']['complaints']);
		?></div>
		<p>&nbsp;</p>
		<p>Kindly do the needful</p>
		<p>&nbsp;</p>
		<p>Regards,</p> 
		<div style="float:left;">
			<?php 
				echo nl2br($this->data['PatientReferral']['doctor_detail']);
			?>
		</div>
		<div style="float:right;">
			Date:
			<?php 
	                        if($this->data['PatientReferral']['date_of_issue']){
	                           $dateOfIssue = $this->DateFormat->formatDate2Local($this->data['PatientReferral']['date_of_issue'],Configure::read('date_format'),true);
	                        }else{
	                           $dateOfIssue='';
	                        }
	                        echo $dateOfIssue;
	                        ?> 
		</div>
		<p>&nbsp;</p>
	    </div>
	</div>
    <div class="clr ht5"></div> 
    <div class="clr ht5"></div>
				  