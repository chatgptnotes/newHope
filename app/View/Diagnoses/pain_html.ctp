<br> 
        <div style="width:450px; float:left;" class="">
	    <div style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px; padding: 0px; float: left; width: 223px;">Pain Present</h2><span style="float: left;"> : </span></div>
        <div style="float:left;"><select class="painPresentOption painPresent" autocomplete="off" id="painPresent_<?php echo $counter;?>" name="data[BmiResult][pain_present][]">
<option value="">Please Select</option>
<option value="0">Pain Present</option>
<option value="1">No Pain</option>
</select></div>
          </div> 
          <br> <br>
           
			<!--  	<input width="20px" type="hidden" readonly="readonly" autocomplete="off" size="20px" id="pain_date" name="data[BmiResult][pain_date]">
					<input type="hidden" style="width:40px" id="user_id_pain_<?php // echo $counter;?>" name="data[BmiResult][user_id_pain]">-->		 			 
					<input type="hidden" class="" autocomplete="off" id="pain_date_<?php echo $counter;?>" name="data[BmiResult][pain_date][]">				
					<input type="hidden" class="" autocomplete="off" id="user_id_pain_<?php echo $counter;?>" name="data[BmiResult][user_id_pain][]">
	    <!-- Location -->
	    <div style="float:left; clear:both">
			 <b style="float:left; width:222px;">Location</b><span style="float: left;margin:0 8px 0 0;"> : </span>
			<select class="painPresentOption" id="location_<?php echo $counter;?>" style="width:175px;" name="data[BmiResult][location][]">
<option value="">Please select</option>
<option value="Ribs">Ribs</option>
<option value="Sternum">Sternum</option>
<option value="Upper Back">Upper Back</option>
<option value="Abdomen Lower">Abdomen Lower</option>
<option value="Abdomen Upper">Abdomen Upper</option>
<option value="Achilles">Achilles</option>
<option value="Ankle">Ankle</option>
<option value="Arm">Arm</option>
<option value="Back">Back</option>
<option value="Buttock">Buttock</option>
<option value="Calf">Calf</option>
<option value="Chest">Chest</option>
<option value="Coccyx">Coccyx</option>
<option value="Ear">Ear</option>
<option value="Elbow">Elbow</option>
<option value="Epigastric">Epigastric</option>
<option value="Eye">Eye</option>
<option value="Face">Face</option>
<option value="Finger">Finger</option>
<option value="Flank">Flank</option>
<option value="Forearm">Forearm</option>
<option value="Generalized">Generalized</option>
<option value="Groin">Groin</option>
<option value="Head">Head</option>
<option value="Heel">Heel</option>
<option value="Hip">Hip</option>
</select>				

<input type="text" autocomplete="off" id="location1_<?php echo $counter ;?>" style="width:173px;margin-left:10px;" class="painPresentTextBox" size="12" name="data[BmiResult][location1][]">


<br>
		</div>
		<div style="float:left; clear:both">
			<b style="float:left; width:222px;">Duration</b><span style="float: left;margin:0 8px 0 0;"> : </span>
	 
			<input type="text" autocomplete="off" id="spo_<?php echo $counter;?>" style="width:173px;" class="painPresentTextBox" size="12" name="data[BmiResult][duration][]">		
			<br>
		</div>
		<div style="float: left; clear:both ">
			<br> <b style="float:left; width:222px;">Frequency</b><span style="float: left;margin:0 8px 0 0;"> : </span>
	
			<input type="text" autocomplete="off" id="frequency_<?php echo $counter;?>" style="width:173px;" class="painPresentTextBox" size="12" name="data[BmiResult][frequency][]">		
			<br> <br>
		</div><br> <br>
	    <!--Eof Location  -->
	     		     <div style="width:600px; float:left; display:none;" id="tools_<?php echo $counter;?>" class="tools">
	     <div class="clear" style="float:left;width: 236px;clear:both; "><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px; ">Preferred Pain Tool</h2>
         <span style="float: left;"> : </span></div>
         <div style="float:left; " class=""> <select class="painPresentOption preferredPainTool" autocomplete="off" id="preferredPainTool_<?php echo $counter;?>" name="data[BmiResult][preferred_pain_tool][]">
<option value="">Please Select</option>
<option value="0">Modified FLACC emotion</option>
<option value="1">Score by Number</option>
<option value="2">Score by Faces</option>
</select></div></div>

        
                    <div style="float:left; width:650px; display:none;" class="IIV_<?php echo $counter;?> clear">
	    <div class="IIV_<?php echo $counter;?>" style="width:600px; float:left">
	    <div style="float:left;width: 236px;"><h2 style="font-size: 13px; margin: 0px;padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Emotion</h2><span style="float: left;"> : </span></div>
        <div style="float:left;"> <select class="IV painPresentOption" autocomplete="off" id="modifiedFLACCEmotion_<?php echo $counter;?>" name="data[BmiResult][modified_flacc_emotion][]">
<option value="">Please Select</option>
<option value="0">Smiling or Calm</option>
<option value="1">Anxious/Irritable</option>
<option value="2">Almost in tears or crying</option>
</select></div></div>
	  
        
        
        <div class="IIV_<?php echo $counter;?>" style="width:600px; float:left">
	    <div style="float:left;width: 236px;" class=""><h2 style="font-size: 13px; margin: 0px;padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Movement</h2> <span style="float: left;"> : </span> </div>
		<div style="float:left;"><select class="IV painPresentOption" autocomplete="off" id="modifiedFLACCMovement_<?php echo $counter;?>" name="data[BmiResult][modified_flacc_movement][]">
<option value="">Please Select</option>
<option value="0">Lying quietly or normal position, Moves easily</option>
<option value="1">Restless or slow decreased movement</option>
<option value="2">immobile, afraid to move or increased agitation</option>
</select></div></div>
	   
        
        <div class="IIV_<?php echo $counter;?>" style="width:600px; float:left">
	    <div style="float:left;width: 236px;" class=""><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Verbal Cues</h2><span style="float: left;"> : </span> </div>
		<div style="float:left;"><select class="IV painPresentOption" autocomplete="off" id="modifiedFLACCVerbalCues_<?php echo $counter;?>" name="data[BmiResult][modified_flacc_verbal_cues][]">
<option value="">Please Select</option>
<option value="0">Quiet</option>
<option value="1">Noisy Breathing, Whining or Whimpering</option>
<option value="2">Screaming, Crying Out</option>
</select></div></div>
	 
        
        <div class="IIV_1" style="width:600px; float:left">
	    <div style="float:left;width: 236px;" class=""><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Facial Cues</h2><span style="float: left;"> : </span> </div>
		<div style="float:left;"><select class="IV painPresentOption" autocomplete="off" id="modifiedFLACCFacialCues_<?php echo $counter;?>" name="data[BmiResult][modified_flacc_facial_cues][]">
<option value="">Please Select</option>
<option value="0">Relaxed, Calm Expression</option>
<option value="1">Drawn around mouth and eyes</option>
<option value="2">Facial frowning, Wincing</option>
</select></div></div>
	   
        
         <div class="IIV_<?php echo $counter;?>" style="width:600px; float:left">
	   <div style="float:left;width: 236px;" class=""><h2 style="font-size: 13px; margin: 0px;padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Position/Guarding</h2><span style="float: left;"> : </span> </div>
	   <div style="float:left;"><select class="IV painPresentOption" autocomplete="off" id="modifiedFLACCPositionGuarding_<?php echo $counter;?>" name="data[BmiResult][modified_flacc_position_guarding][]">
<option value="">Please Select</option>
<option value="0">Relaxed Body</option>
<option value="1">Guarding, Tense</option>
<option value="2">Fetal Position, Jumps When Touched</option>
</select></div></div>

        
        
        <div class="IIV_<?php echo $counter;?>" style="width:600px; float:left">
	    <div style="float:left;width: 236px;" class=""><h2 style="font-size: 13px; margin: 0px; padding: 10px 0px 15px 0px; float: left; width: 223px;">Modified FLACC Pain Score</h2><span style="float: left;"> : </span> </div>
	    <div style="float:left;"><input type="text" autocomplete="off" id="modifiedFLACCPainScore_<?php echo $counter;?>" class="" readonly="readonly" size="12" name="data[BmiResult][modified_flacc_pain_score][]"></div></div>
	 
	    </div>
	    
	    <!--EOF Intractive View  -->
	   
					  
	     
	    <div class="clear" style="display:none;" id="numScore_<?php echo $counter;?>">
	    <b style="float:left; clear:left; width:230px;">Pain :</b>
	    <div style="float:left;width: 236px; clear: both; margin:2px"><h2 style="font-size: 13px; margin: 0px; padding: 0px; float: left; width: 223px;">Select Pain Score</h2><span style="float: left;"> : </span></div>		    
	    
													<select autocomplete="off" id="spoId_<?php echo $counter;?>" class="painPresentOption num" name="data[BmiResult][pain][]">
<option value="">Please Select</option>
<option value="0">Not recorded</option>
<option value="1">0-No Pain</option>
<option value="2">1</option>
<option value="3">2</option>
<option value="4">3</option>
<option value="5">4</option>
<option value="6">5</option>
<option value="7">6</option>
<option value="8">7</option>
<option value="9">8</option>
<option value="10">9</option>
<option value="11">10</option>
</select>
						</div>
						
				
			<div style="display:none;" class="faces_<?php echo $counter;?> clear">
	    <b style="padding-bottom: 10px; clear: left; float: left;"> Pain Faces:</b>
	    <div style="float: left; clear: left; padding-bottom: 10px;">
	    
	     <?php echo $this->Html->link($this->Html->image('icons/smile_0-1.png',array('id'=>'smile_0-1','counter'=>$counter,'class'=>'smile painPresentRadio','title'=>'No Pain (0-1)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_2-3.png',array('id'=>'smile_2-3','counter'=>$counter,'class'=>'smile painPresentRadio','title'=>'Mild Pain (2-3)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_4-5.png',array('id'=>'smile_4-5','counter'=>$counter,'class'=>'smile painPresentRadio','title'=>'Moderate Pain (4-5)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_6-7.png',array('id'=>'smile_6-7','counter'=>$counter,'class'=>'smile painPresentRadio','title'=>'Severe Pain (6-7)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp; 
		    <?php echo $this->Html->link($this->Html->image('icons/smile_8-9.png',array('id'=>'smile_8-9','counter'=>$counter,'class'=>'smile painPresentRadio','title'=>'More Than Severe Pain (8-9)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp;
		    <?php echo $this->Html->link($this->Html->image('icons/smile_10-11.png',array('id'=>'smile_10','counter'=>$counter,'class'=>'smile painPresentRadio','title'=>'Worst Pain (10)')),'javascript:void(0)',array('escape'=>false));?> &nbsp; &nbsp;
	    
	    </div><br><br><br>
	     <b> Your Score</b> : &nbsp; &nbsp;<input type="text" style="width:40px; margin:17px 0px 0px 6px; float:left;" id="faceScore2_<?php echo $counter;?>" name="data[BmiResult][face_score][]">		   	  </div>
<input type="hidden" style="width:40px" id="commonPain_<?php echo $counter;?>" counter=<?php echo $counter;?> name="data[BmiResult][common_pain][]">







