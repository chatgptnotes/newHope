<?php
echo $this->Html->script(array('/js/jquery-1.5.1.min', '/fusionx_charts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
<div class="inner_title">
<h3><?php echo __('OPD Patient Survey Report', true)." - ".$reportYear; ?></h3>
</div>
<div class="clr ht5"></div><center>
<div id="chartContainer">FusionCharts will load here</div>
</center>
 <div>
    <?php
	//$graph= new FusionCharts();
        $monthIndex = 0;
        foreach($yaxisArray as $yaxisArrayVal) {
              $arrData[$monthIndex][1]  = $yaxisArrayVal;
              $monthIndex++;
        }
        
           $questions[1] = 'The cleanliness and comfort in the waiting area met my expectation?';
           $questions[2] = 'Toilets were clean and well maintained?';
           $questions[3] = 'All my doubts were answered by reception staff?';
           $questions[4] = 'Staff ensured that privacy of my information was maintained?';
           $questions[5] = 'I was seen at the appointment time by the doctor?';
           $questions[6] = 'I was guided for the doctor\'s consulation?';
           $questions[7] = 'I was taken in for my investigation at the appointed time?';
           $questions[8] = 'I was well informed about the procedure?';
           $questions[9] = 'I was informed about collecting report days and timing?';
           $questions[10] = 'Billing procedure was completed in 5 minute?';
           $questions[11] = 'I received my investigation reports at the scheduled time?';
           $questions[12] = 'I was able to get all the medicine in th Hospital pharmacy prescribed by the doctor?';
           $questions[13] = 'Reception Staff was polite,respectful and friendly with me?';
           $questions[14] = 'I was able to find my way to the investigation room easily?';
           $questions[15] = 'My personal privacy was maintained during  investigation?';
           $questions[16] = 'I was given full attention by the doctor?';
           $questions[17] = 'All my querries were answered by the doctor?';
           $questions[18] = 'I would recommend this hospital to others?';
           $questions[19] = 'Overall I am satisfied with the OPD services received in Hope Hospital?';
           $questionArray = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19');
           $cleanlinessQid = array('1', '2');
           $serviceQid = array('3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
           $satisfactionQid = array('13', '14', '15', '16', '17');
           $recommendationQid = array('18', '19');

           // for calculating total score //
           $totalScore=0; 
           $totalStrongAgree = 0;
           $totalAgree = 0;
           $totalNand = 0;
           $totalDisagree = 0;
           $totalStDisagree = 0;
           $highestCent = 0;
           for($i=1; $i <20; $i++) {
            foreach($yaxisArray as $key => $yaxisArrayVal) {
                         // for strong agree answer plus cleanliness parameter //
                         if(@in_array($i, $stAgreeQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountCleanArray[$i]))) {
                            $totalStrongAgree = $stAgreeAnsCountCleanArray[$i][$key]*5;
                           } else {
                            $totalStrongAgree = 0;
                           }
                         }
                         // for strong agree answer plus service parameter //
                         elseif(@in_array($i, $stAgreeQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountServiceArray[$i]))) {
                            $totalStrongAgree = $stAgreeAnsCountServiceArray[$i][$key]*5;
                           } else {
                            $totalStrongAgree = 0;
                           }
                         }
                         // for strong agree answer plus satisfaction parameter //
                         elseif(@in_array($i, $stAgreeQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountSatisArray[$i]))) {
                             $totalStrongAgree = $stAgreeAnsCountSatisArray[$i][$key]*5;
                           } else {
                            $totalStrongAgree = 0;
                           }
                         }
                         // for strong agree answer plus recommendation parameter //
                         elseif(@in_array($i, $stAgreeQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($stAgreeAnsCountRecomArray[$i]))) {
                            $totalStrongAgree = $stAgreeAnsCountRecomArray[$i][$key]*5;
                           } else {
                            $totalStrongAgree = 0;
                           }
                         }
                         else {
                            $totalStrongAgree = 0;
                         } 
                         
                         // for  agree answer plus cleanliness parameter//
                         if(@in_array($i, $agreeQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountCleanArray[$i]))) {
                            $totalAgree = $agreeAnsCountCleanArray[$i][$key]*4;
                           } else {
                            $totalAgree = 0;
                           }
                         }
                         // for agree answer plus service parameter //
                         elseif(@in_array($i, $agreeQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountServiceArray[$i]))) {
                            $totalAgree = $agreeAnsCountServiceArray[$i][$key]*4;
                           } else {
                            $totalAgree = 0;
                           }
                         }
                         // for agree answer plus satisfaction parameter //
                         elseif(@in_array($i, $agreeQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountSatisArray[$i]))) {
                            $totalAgree = $agreeAnsCountSatisArray[$i][$key]*4;
                           } else {
                            $totalAgree = 0;
                           }
                         }
                         // for  agree answer plus recommendation parameter //
                         elseif(@in_array($i, $agreeQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($agreeAnsCountRecomArray[$i]))) {
                            $totalAgree = $agreeAnsCountRecomArray[$i][$key]*4;
                           } else {
                            $totalAgree = 0;
                           }
                         } 
                         else {
                            $totalAgree = 0;
                         }
                         
                         // for neither agree nor disagree answer plus cleanliness //
                         if(@in_array($i, $nandQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($nandAnsCountCleanArray[$i]))) {
                            $totalNand = $nandAnsCountCleanArray[$i][$key]*3;
                           } else {
                            $totalNand = 0;
                           }
                         } 
                         // for neither agree nor disagree answer plus service parameter //
                         elseif(@in_array($i, $nandQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($nandAnsCountServiceArray[$i]))) {
                            $totalNand = $nandAnsCountServiceArray[$i][$key]*3;
                           } else {
                            $totalNand = 0;
                           }
                         }
                         // for neither agree nor disagree answer plus satisfaction parameter //
                         elseif(@in_array($i, $nandQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($nandAnsCountSatisArray[$i]))) {
                            $totalNand = $nandAnsCountSatisArray[$i][$key]*3;
                           } else {
                            $totalNand = 0;
                           }
                         }
                         // for neither agree nor disagree plus recommendation parameter //
                         elseif(@in_array($i, $nandQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($nandAnsCountRecomArray[$i]))) {
                            $totalNand = $nandAnsCountRecomArray[$i][$key]*3;
                           } else {
                            $totalNand = 0;
                           }
                         } 
                         else {
                            $totalNand = 0;
                         } 
                         
                         // for disagree answer plus cleanliness//
                         if(@in_array($i, $disgreeQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountCleanArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountCleanArray[$i][$key]*2;
                            echo $disgreeAnsCountCleanArray[$i][$key];
                           } else {
                            echo "0";
                           }
                         } 
                         // for strong agree answer plus service parameter //
                         elseif(@in_array($i, $disgreeQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountServiceArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountServiceArray[$i][$key]*2;
                           } else {
                            $totalDisagree = 0;
                           }
                         }
                         // for strong agree answer plus satisfaction parameter //
                         elseif(@in_array($i, $disgreeQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountSatisArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountSatisArray[$i][$key]*2;
                           } else {
                            $totalDisagree = 0;
                           }
                         }
                         // for strong agree answer plus recommendation parameter //
                         elseif(@in_array($i, $disgreeQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($disgreeAnsCountRecomArray[$i]))) {
                            $totalDisagree = $disgreeAnsCountRecomArray[$i][$key]*2;
                           } else {
                            $totalDisagree = 0;
                           }
                         } 
                         else {
                            $totalDisagree = 0;
                         } 
                         
                         // for strong disagree answer plus cleanliness//
                         if(@in_array($i, $stdQuestIdCleanArray)) {
                           if(@in_array($key, array_keys($stdAnsCountCleanArray[$i]))) {
                            $totalStDisagree = $stdAnsCountCleanArray[$i][$key]*1;
                           } else {
                            $totalStDisagree = 0;
                           }
                         } 
                         // for strong disagree answer plus service parameter //
                         elseif(@in_array($i, $stdQuestIdServiceArray)) {
                           if(@in_array($key, array_keys($stdAnsCountServiceArray[$i]))) {
                            $totalStDisagree = $stdAnsCountServiceArray[$i][$key]*1;
                           } else {
                            $totalStDisagree = 0;
                           }
                         }
                         // for strong disagree answer plus satisfaction parameter //
                         elseif(@in_array($i, $stdQuestIdSatisArray)) {
                           if(@in_array($key, array_keys($stdAnsCountSatisArray[$i]))) {
                            $totalStDisagree = $stdAnsCountSatisArray[$i][$key]*1;
                           } else {
                            $totalStDisagree = 0;
                           }
                         }
                         // for strong disagree answer plus recommendation parameter //
                         elseif(@in_array($i, $stdQuestIdRecomArray)) {
                           if(@in_array($key, array_keys($stdAnsCountRecomArray[$i]))) {
                            $totalStDisagree = $stdAnsCountRecomArray[$i][$key]*1;
                           } else {
                            $totalStDisagree = 0;
                           }
                         } 
                         else {
                            $totalStDisagree = 0;
                         } 
                        
                         // cent avg calculation //
                         $totalScore = ($totalStrongAgree + $totalAgree + $totalNand + $totalDisagree + $totalStDisagree);
                         $highestCent = ($totalScore/(70*5))*100; 
                         if(in_array($i, $cleanlinessQid)) {
                           $cleanlinessRate[$i]['cleanliness'][$key] = $highestCent;
                         }
                         if(in_array($i, $serviceQid)) { 
                           $serviceRate[$i]['service'][$key] = $highestCent;
                         }
                         if(in_array($i, $satisfactionQid)) { 
                           $satisfactionRate[$i]['satisfaction'][$key] = $highestCent;
                         }
                         if(in_array($i, $recommendationQid)) { 
                           $recommendationRate[$i]['recommendation'][$key] = $highestCent;
                         }
                         
                         $totalScore=0; 
                         $totalStrongAgree = 0;
                         $totalAgree = 0;
                         $totalNand = 0;
                         $totalDisagree = 0;
                         $totalStDisagree = 0;
                         $highestCent = 0;
        } // close for for axis array
                  
       } // close for questionid array
        
        // for cleanliness parameter //
        $cleanlinessCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          $totalCleanlinessRate =   (($cleanlinessRate[1]['cleanliness'][$key] + $cleanlinessRate[2]['cleanliness'][$key])/2);  
          
          if($totalCleanlinessRate > 0) {
                           $arrData[$cleanlinessCountIndex][2] = $totalCleanlinessRate;
          } else {
                           $arrData[$cleanlinessCountIndex][2] = 0;
          } 
          $cleanlinessCountIndex++;
        }
        
        // for service parameter //
        $serviceCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          $totalServiceRate =   (($serviceRate[3]['service'][$key] + $serviceRate[4]['service'][$key] + $serviceRate[5]['service'][$key] + $serviceRate[6]['service'][$key] + $serviceRate[7]['service'][$key] + $serviceRate[8]['service'][$key] + $serviceRate[9]['service'][$key] + $serviceRate[10]['service'][$key] + $serviceRate[11]['service'][$key] + $serviceRate[12]['service'][$key])/10);  
          if($totalServiceRate > 0) {
                           $arrData[$serviceCountIndex][3] = $totalServiceRate;
          } else {
                           $arrData[$serviceCountIndex][3] = 0;
          }
          $serviceCountIndex++;
        }
        // for satisfaction parameter //
        $satisfactionCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          $totalSatisfactionRate =   (($satisfactionRate[13]['satisfaction'][$key] + $satisfactionRate[14]['satisfaction'][$key] + $satisfactionRate[15]['satisfaction'][$key] + $satisfactionRate[16]['satisfaction'][$key] + $satisfactionRate[17]['satisfaction'][$key])/5);  
          if($totalSatisfactionRate > 0) {
                           $arrData[$satisfactionCountIndex][4] = $totalSatisfactionRate;
          } else {
                           $arrData[$satisfactionCountIndex][4] = 0;
          }
          $satisfactionCountIndex++;
        }
        // for recommendation parameter //
        $recommendationCountIndex=0;
        foreach($yaxisArray as $key => $yaxisArrayVal) {
          $totalRecommendationRate =   (($recommendationRate[18]['recommendation'][$key] + $recommendationRate[19]['recommendation'][$key])/2);  
          if($totalRecommendationRate > 0) {
                           $arrData[$recommendationCountIndex][5] = $totalRecommendationRate;
          } else {
                           $arrData[$recommendationCountIndex][5] = 0;
          }
          $recommendationCountIndex++;
        }
        
        //Initialize <graph> element
	$strXML = '<chart caption="OPD Patient Survey" xaxisname="Months" yaxisname="Rate"  showValues="0" decimalPrecision="1"  yAxisMaxValue="5" numberSuffix="%" >';
	
	//Initialize <categories> element - necessary to generate a multi-series chart
	$strCategories = '<categories>';
	//Initiate <dataset> elements
	$strDataCleanliness = '<dataset seriesName="Cleanliness" color="AFD8F8">';
	$strDataService = '<dataset seriesName="Service" color="F6BD0F">';
        $strDataSatisfaction = '<dataset seriesName="Satisfaction" color="CCCC00">';
        $strDataRecommendation ='<dataset seriesName="Recommendation" color="FF9933">';
        //Iterate through the data  
	 
	foreach ($arrData as $arSubData) {
        //Append <category name='...' /> to strCategories
        $strCategories .= '<category name="' . $arSubData[1] . '" />';
        //Add <set value='...' /> to both the datasets
        $strDataCleanliness .= '<set value="' . $arSubData[2] . '" />';
        $strDataService .= '<set value="' . $arSubData[3] . '" />';
        $strDataSatisfaction .= '<set value="' . $arSubData[4] .'" />';
        $strDataRecommendation .= '<set value="' . $arSubData[5] . '" />';
        
 	}
	
	//Close <categories> element
	$strCategories .= '</categories>';
	//Close <dataset> elements
        $strDataCleanliness .='</dataset>';
        $strDataService .= '</dataset>';
        $strDataSatisfaction .= '</dataset>';
        $strDataRecommendation .= '</dataset>';
         //Assemble the entire XML now
	$strXML .= $strCategories . $strDataCleanliness . $strDataService . $strDataSatisfaction . $strDataRecommendation .'</chart>';
	
   
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	//echo $graph->renderChart($this->Html->url("/fusioncharts/FCF_MSColumn3D.swf"), "", $strXML, "opdpatientsurvey", 900, 500);
	
        
   ?>
 <script> var datastring = '<?php echo $strXML; ?>';</script>
						   <?php echo $this->JsFusionChart->showFusionChart("/fusionx_charts/MSColumn3D.swf", "opdpatientsurvey", "900", "500", "0", "0", "datastring", "chartContainer"); ?>
						   </div>                
   <div class="btns" style="padding-right: 105px;">
           <?php echo $this->Html->link(__('Back'),array('controller'=>'reports','action'=>'opdpatientsurvey_reports', 'admin'=>true),array('class'=>'grayBtn','div'=>false)); ?>
   </div>