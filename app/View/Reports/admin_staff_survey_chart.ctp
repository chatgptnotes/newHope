<?php 
  App::import('Vendor', 'fusion_charts'); 
  echo $this->Html->script(array('/fusioncharts/fusioncharts'));
?>
<div class="inner_title">
<h3><?php echo __('Staff Survey Reports Chart', true); ?></h3>
</div>
     <div>&nbsp;</div>    
     <div class="clr ht5"></div>
     <div>
    <?php 
           $graph= new FusionCharts();
           $questionCount = 19;
		$yesTotalCent = 0;
		$noTotalCent = 0;
		for($i=1; $i <20; $i++) {
		if(in_array($i, $yesQuestionIdArray))  {
			$yesTotalCent += $yesResultArray[$i];
		}
		if(in_array($i, $noQuestionIdArray)) {
			$noTotalCent += $noResultArray[$i];
		}
						
		}
            

            $strXML = "<graph caption='Staff Survey Report Chart' showNames='1'  pieRadius='150' pieSliceDepth='30' decimalPrecision='0' >";
	    $strXML .= "<set name='Yes' value='".$yesTotalCent."' />";
            $strXML .= "<set name='No' value='".$noTotalCent."' />";
            $strXML .= "</graph>";

           echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_Pie3D.swf"), "", $strXML, "myNext", 600, 300);
 ?>                 
                   
              
                   </div>
                   <div>&nbsp;</div>
                   <div class="clr ht5"></div>
   <div class="btns" style="padding-right: 255px;">
           <?php echo $this->Html->link(__('Cancel'),array('controller'=>'reports','action'=>'staff_survey_reports', 'admin'=> true),array('class'=>'grayBtn','div'=>false)); ?>
       </div>