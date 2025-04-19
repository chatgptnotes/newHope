<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('Patient Survey Reports Chart', true); ?></h3>
</div>
    <div>&nbsp;</div>    
     <div class="clr ht5"></div><center>
<div id="chartContainer">FusionCharts will load here</div>
</center>
     <div>
      <?php 
           //$graph= new FusionCharts();
           $questionCount = 32;
		$strongAgreeTotalCent = 0;
		$agreeTotalCent = 0;
                $nandTotalCent = 0;
                $disagreeTotalCent = 0;
                $strongDisagreeTotalCent = 0;
                $naTotalCent = 0;
		for($i=1; $i <33; $i++) {
			if(in_array($i, $strongAgreeQuestionIdArray)) {
			$strongAgreeTotalCent += $strongAgreeResultArray[$i];
			}
			if(in_array($i, $agreeQuestionIdArray)) {
			$agreeTotalCent += $agreeResultArray[$i];
			}
			if(in_array($i, $nandQuestionIdArray)) {
			$nandTotalCent += $nandResultArray[$i];
			}
			if(in_array($i, $disagreeQuestionIdArray)) {
			$disagreeTotalCent += $disagreeResultArray[$i];
			}
			if(in_array($i, $strongDisagreeQuestionIdArray)) {
			$strongDisagreeTotalCent += $strongDisagreeResultArray[$i];
			}
			if(in_array($i, $naQuestionIdArray)) {
			$naTotalCent += $naResultArray[$i];
			}
                }

		
//echo $strongAgreeTotalCentVal;exit;

            $strXML = '<chart caption="Patient Survey Reports Chart" showNames="1"  pieRadius="150" pieSliceDepth="30" decimalPrecision="0">';
	    $strXML .= '<set name="Strongly Agree" value="'.$strongAgreeTotalCent.'" />';
            $strXML .= '<set name="Agree" value="'.$agreeTotalCent.'" />';
            $strXML .= '<set name="Neither Agree Nor Disagree" value="'.$nandTotalCent.'" />';
            $strXML .= '<set name="Disagree" value="'.$disagreeTotalCent.'" />';
            $strXML .= '<set name="Strongly Disagree" value="'.$strongDisagreeTotalCent.'" />';
            $strXML .= '<set name="Not Applicable" value="'.$naTotalCent.'" />';
            $strXML .= '</chart>';

           //echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_Pie3D.swf"), "", $strXML, "myNext", 600, 300);
      ?>    
    </div><script> var datastring = '<?php echo $strXML; ?>';</script>
						   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "patientsurvey", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
						   </div>  
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
       <div class="btns" style="padding-right: 255px;">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'patient_survey_reports', 'admin'=> true),array('class'=>'grayBtn','div'=>false)); ?>
       </div>
   