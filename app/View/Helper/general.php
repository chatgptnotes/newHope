<?php  
//helper class add general purpose view fucntion
//created by : 1053
class GeneralHelper extends AppHelper {
	public $helpers = array('Html',"Session");

	/**function to pass minDate for JS calender
		@params : date => yyyy-mm-dd (strict)
	**/
	function minDate($date=null){
			
		if(empty($date)) return ;
		$splitTime  = explode(" ",$date);
		$splitDate = explode("-",$splitTime[0]);
		$splitDate[1] = $splitDate[1]-1 ;//reset month indexing
		return implode(",",$splitDate) ;//ymd
	}

	function removePaginatorSortArg($sortArray=  array()){
		foreach($sortArray as $key=>$value){
			if(empty($value)) unset($sortArray[$key]);
		}
		return  $sortArray;
	}
	//-------gaurav BOF
	/**function to pass general date format for JS calender
	@params : time => timeformat/false
	**/
	function GeneralDate($time=null){
		
		$dateformat = trim($this->Session->read('dateformat')) ;
		
		if(empty($dateformat))
		$dateformat = Configure::read('date_format') ; //if there is no format available use configured format
 
		if(substr($dateformat, -4, -1) == "yyy"){
			$datestring = substr($dateformat, 0, -2);
		}else if(substr($dateformat, 0, 4) == "yyyy"){
			$datestring = substr($dateformat, 2);
		}else{
			$datestring = $dateformat;
		}
		$format = $datestring.' '.$time;
			
		return trim($format);
	}


	/**
	 * @author Pawan Meshram
	 * @param unknown_type $start
	 * @param unknown_type $end
	 *
	 * To pass the format to JS with options like mm/dd/yyyy
	 */

	function GeneralDateForJS($time=null){
		return trim($this->Session->read('dateformat').' '.$time);
	}

	function diff($start,$end = false) {
		/*
		 * For this function, i have used the native functions of PHP. It calculates the difference between two timestamp.
		*
		* Author: Toine
		*
		* I provide more details and more function on my website
		*/

		// Checks $start and $end format (timestamp only for more simplicity and portability)

		// Convert $start and $end into EN format (ISO 8601)
		//$start  = date('Y-m-d H:i:s',$start);
		// $end    = date('Y-m-d H:i:s',$end);
		$d_start    = new DateTime($start);
		$d_end      = new DateTime($end);
		$diff = $d_start->diff($d_end);
		// return all data
		$this->year    = $diff->format('%y');
		$this->month    = $diff->format('%m');
		$this->day      = $diff->format('%d');
		$this->hour     = $diff->format('%h');
		$this->min      = $diff->format('%i');
		$this->sec      = $diff->format('%s');
			
		$years = $this->year * 12;
		$months = $this->month + $years;
		if($months > 0){
			return $months.' mos ago';
		}else if($this->day > 0){
			$weeks = $this->day % 7;
			if($weeks > 0)
				return $weeks.' wks ago';
			else
				return $this->day.' days ago';
		}
		//return $diff;
	}
	/**
	 * @author Swati
	 * @param date type $date1 (start date)
	 * @param date type $date2 (end date)
	 *
	 */
	function getDateDifference($dateStart,$dateEnd){
		$date1 = new DateTime($dateStart);
		$date2 = new DateTime($dateEnd);
		$interval = $date1->diff($date2);
		$date1_explode = explode("-",$date1);
		$person_age_year =  $interval->y . " Year";
		$personn_age_month =  $interval->m . " Month";
		$person_age_day = $interval->d . " Day";
		if($interval->y != 0){
			$returnVal = $person_age_year;
			if($interval->m != 0){
				$returnVal = $returnVal.' '.$personn_age_month;
			}
			if($interval->d != 0){
				$returnVal = $returnVal.' '.$person_age_day;
			}
			return $returnVal;
		}
		if($interval->m != 0){
			$returnVal = $personn_age_month;
			if($interval->d != 0){
				$returnVal = $returnVal.' '.$person_age_day;
			}
			return $returnVal;
		}
		if($interval->d != 0){
			$returnVal = $person_age_day;
				
			return $returnVal;
		}else{
			return '0 Day';
		}
	
	}
	
	//truncate sentence to limited words
	function truncate($text, $length) {
		$length = abs((int)$length);
		if(strlen($text) > $length) {
			$text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
		}
		return($text);
	}

	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	function formatPhone($phone){
		$phone = preg_replace("/[^0-9]/", "", $phone);
			
		if(strlen($phone) == 7)
			return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		elseif(strlen($phone) == 10)
		return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		else
			return $phone;
	}

	function getCurrentAge($dob){

		$date1 = new DateTime($dob);
		$date2 = new DateTime();
		$interval = $date1->diff($date2);
		$date1_explode = explode("-",$dob);
		$person_age_year =  $interval->y . " Year";
		$personn_age_month =  $interval->m . " Month";
		$person_age_day = $interval->d . " Day";
		if($person_age_year == 0 && $personn_age_month > 0){
			$age = $interval->m ;
			if($age==1){
				$age=$age . " Month";
			}else{
				$age=$age . " Months";
			}
		}else if($person_age_year == 0 && $personn_age_month == 0 && $person_age_day > -1){
			$age = $interval->d . " " + 1 ;
			if($age==1){
				$age=$age . " Day";
			}else{
				$age=$age . " Days";
			}
		}else{
			$age = $interval->y;
			if($age==1){
				$age=$age . " Year";
			}else{
				$age=$age . " Years";
			}
		}
		return $age;
	}
	/**
	 * function to create sentences for HPI & ROS
	 * @author Gaurav Cahuriya
	 */
	function createHpiSentence ($hpiMasterData = null,$hpiResultOther = null, $rosResultOther = null){
		/** BOF HPI & ROS sentence */
		$finalSentenceArrHPI = '';
		$finalSentenceArrROS = '';
		$loopCntr = 0;//debug($hpiMasterData);
		foreach($hpiMasterData as $sentenceArray){
			/** BOF HPI */
			if($sentenceArray['Template']['template_category_id'] == 3){ /** template_category_id = 3 is for HPI */
				/** HPI creates sentences on basis of perdefined sentence string stored in $sentenceArray['Template']['sentence'] */
				$finalSentence =  (!empty($sentenceArray['Template']['sentence'])) ? $sentenceArray['Template']['sentence']." " : '';
				$finalSentenceButton = '';
				$seperator ='';
				$btnCount  = count($sentenceArray['TemplateSubCategories']) ;
				foreach($sentenceArray['TemplateSubCategories'] as $key =>$selectedOptions){
					if(strtoupper($selectedOptions['sub_category']) == 'OTHER')continue;
					if($key  == $btnCount-1 && $btnCount != 1){
						$seperator = ' and ';
					}else if($key != 0 /*&& $key  == count($sentenceArray['TemplateSubCategories'])*/) $seperator = ', ';
					$finalSentenceButton  .= $seperator.$selectedOptions['sub_category'];

				}
				$otherSentence = '';
				for($i = 0; $i<count($hpiResultOther); $i++){
					$InnerSeperator = '';
					$otherSubCategory = array_keys($hpiResultOther);
					if($i  == count($hpiResultOther)-1 && count($hpiResultOther) != 1){
						$InnerSeperator = ' and ';
					}else if($i != 0 ) $InnerSeperator = ', ';
					$otherSentence  .= $InnerSeperator.$otherSubCategory[$i];
				}
				$finalSentence .= $finalSentenceButton;
				$finalSentenceArrHPI[] = $finalSentence;$finalSentence ='';
			}
			/** EOF HPI, BOF ROS */
			if($sentenceArray['Template']['template_category_id'] == 1){ /** template_category_id = 3 is for ROS */
				$chekSubCatDone = false;
				$negativeExcept = 'Negative except as documented in history of present illness';
				$finalSentenceButton = '';
				if( !empty($sentenceArray['TemplateSubCategories']) ){
					if(!$chekSubCatDone){
						if($loopCntr == 0)
							$rosSentence =  strtoupper($sentenceArray['Template']['category_name'])." : Historian reports ";
						else
							$rosSentence =  strtoupper($sentenceArray['Template']['category_name'])." : Reports ";
						$chekSubCatDone = true;
					}else{
						$rosSentence = '';
					}
					$rosSentenceButton = '';
					$seperate ='';
					$buttonCount  = count($sentenceArray['TemplateSubCategories']) ;
					foreach($sentenceArray['TemplateSubCategories'] as $keyRos =>$selectedOpt){
						if($keyRos  == $buttonCount-1 && $buttonCount != 1){
							$seperate = ' and ';
						}else if($keyRos != 0 ){
							$seperate = ', ';
						}$newLine = false;
						if( strtoupper(trim($selectedOpt['sub_category'])) == 'OTHER' )continue;
						if( strtoupper(trim($selectedOpt['sub_category'])) == 'NEGATIVE EXCEPT HPI' ){
							$subCategory = $negativeExcept;
							$newLine = true;
						}else{
							$subCategory = $selectedOpt['sub_category'];
							$newLine = false;
						}

						$rosSentenceButton  .= $seperate.$subCategory;
					}
					$rosSentence .= $rosSentenceButton;
					$finalSentenceArrROS[] = $rosSentence;
				}
				if( !empty($sentenceArray['TemplateSubCategoriesRed']) ){
					if(!$chekSubCatDone){
						if($loopCntr == 0)
							$rosSentenceRed =  strtoupper($sentenceArray['Template']['category_name'])." : Historian denies ";
						else
							$rosSentenceRed =  strtoupper($sentenceArray['Template']['category_name'])." : Denies ";
						$chekSubCatDone = true;
					}else{
						$rosSentenceRed = 'Denies ';
					}
					$rosSentenceButtonRed = '';
					$seperateRed ='';
					$buttonCntRed  = count($sentenceArray['TemplateSubCategoriesRed']) ;
					foreach($sentenceArray['TemplateSubCategoriesRed'] as $keyRosRed =>$selectedOptRed){
						if($keyRosRed  == $buttonCntRed-1 && $buttonCntRed != 1){
							$seperateRed = ' and ';
						}else if($keyRosRed != 0 ){
							$seperateRed = ', ';
						}
						$rosSentenceButtonRed  .= $seperateRed.$selectedOptRed['sub_category'];

					}
					$rosSentenceRed .= $rosSentenceButtonRed;
					$finalSentenceArrROS[] = $rosSentenceRed;
				}
				$otherSentenceRos = '';
				for($i = 0; $i<count($rosResultOther); $i++){
					$InnerSeperator = '';
					$otherSubCategory = array_keys($rosResultOther);
					if($i  == count($rosResultOther)-1 && count($rosResultOther) != 1){
						$InnerSeperator = ' and ';
					}else if($i != 0 ) $InnerSeperator = ', ';
					$otherSentenceRos  .= $InnerSeperator.$otherSubCategory[$i];
				}
				$finalSentence .= $finalSentenceButton;
				$finalSentenceArrROS[] = $finalSentence;$finalSentence ='';
			}
			/** EOF ROS */
			$loopCntr++;
		}
		$HpiNew = implode('. ',array_filter($finalSentenceArrHPI))." $otherSentence";
		if($newLine)
			$RosNew = implode('.<br>',array_filter($finalSentenceArrROS))." $otherSentenceRos";
		else
			$RosNew = implode('. ',array_filter($finalSentenceArrROS))." $otherSentenceRos";
		/** EOF sentence */
		return array('HpiSentence'=>$HpiNew,'RosSentence'=>$RosNew);
	}

	/**
	 * function to create sentences for Physical Exam
	 * @author Gaurav Cahuriya
	 */
	function createPhysicalExamSentenceOld ( $hpiMasterData = null, $peResultOther = null, $pEButtonsOptionValue = null ){
		/** BOF PE sentence */
		$finalSentenceArrPE = '';
		$loopCntr = 0;
		foreach($hpiMasterData as $sentenceArray){

			/** BOF PE */
			if($sentenceArray['Template']['template_category_id'] == 2){ /** template_category_id = 2 is for PE */

				$chekSubCatDone = false;
				$negativeExcept = 'Negative except as documented in history of present illness';
					
				if( !empty($sentenceArray['TemplateSubCategories']) ){
					if(!$chekSubCatDone){
						if($loopCntr == 0)
							$peSentence =  strtoupper($sentenceArray['Template']['category_name'])." : On examination ";
						else
							$peSentence =  strtoupper($sentenceArray['Template']['category_name'])." : ";
						$chekSubCatDone = true;
					}else{
						$peSentence = '';
					}
					$peSentenceButton = '';
					$seperate ='';
					$buttonCount  = count($sentenceArray['TemplateSubCategories']) ;
					foreach($sentenceArray['TemplateSubCategories'] as $keyPe =>$selectedOpt){
						//debug(unserialize($selectedOpt['extraSubcategoryDesc']));
						if($keyPe  == $buttonCount-1 && $buttonCount != 1){
							$seperate = ' and ';
						}else if($keyPe != 0 ){
							$seperate = ', ';
						}$newLine = false;
						if( strtoupper(trim($selectedOpt['sub_category'])) == 'NEGATIVE EXCEPT HPI' ){
							$subCategory = $negativeExcept;
							$newLine = true;
						}else{
							$subCategory = $selectedOpt['sub_category'];
							$newLine = false;
						}
						//debug($pEButtonsOptionValue);
						$extraSubCategory = unserialize($selectedOpt['extraSubcategoryDesc']);
						if($extraSubCategory != '') $subCategory .= " with ( ";
						for($cntrVal = 0; $cntrVal < count($extraSubCategory); $cntrVal++){
							if( $pEButtonsOptionValue[0][$selectedOpt[template_id]][$selectedOpt[id]][$cntrVal] == 1 )
								$subCategory.= $extraSubCategory[$cntrVal]." noted ";
							else if( $pEButtonsOptionValue[0][$selectedOpt[template_id]][$selectedOpt[id]][$cntrVal] == 2 )
								$subCategory.= $extraSubCategory[$cntrVal]." not evident ";
						}
						if($extraSubCategory != '') $subCategory .= ")";
						$extraSubCategory = '';
						$peSentenceButton  .= $seperate.$subCategory;

					}
					$peSentence .= $peSentenceButton." noted";

					$finalSentenceArrPE[] = $peSentence;
				}
				if( !empty($sentenceArray['TemplateSubCategoriesRed']) ){
					if(!$chekSubCatDone){
						if($loopCntr == 0)
							$peSentenceRed =  strtoupper($sentenceArray['Template']['category_name'])." : On examination ";
						else
							$peSentenceRed =  strtoupper($sentenceArray['Template']['category_name'])." : ";
						$chekSubCatDone = true;
					}else{
						$peSentenceRed = '';
					}
					$peSentenceButtonRed = '';
					$seperateRed ='';
					$buttonCntRed  = count($sentenceArray['TemplateSubCategoriesRed']) ;
					foreach($sentenceArray['TemplateSubCategoriesRed'] as $keyPeRed =>$selectedOptRed){
						if($keyPeRed  == $buttonCntRed-1 && $buttonCntRed != 1){
							$seperateRed = ' and ';
						}else if($keyPeRed != 0 ){
							$seperateRed = ', ';
						}

						$extraSubCategory = unserialize($selectedOptRed['extraSubcategoryDesc']);
						if($extraSubCategory != '') $selectedOptRed['sub_category'] .= " with ( ";
						for($cntrVal = 0; $cntrVal < count($extraSubCategory); $cntrVal++){

							if( $pEButtonsOptionValue[0][$selectedOptRed[template_id]][$selectedOptRed[id]][$cntrVal] == 1 )
								$selectedOptRed['sub_category'].= $extraSubCategory[$cntrVal]." noted ";
							else if( $pEButtonsOptionValue[0][$selectedOptRed[template_id]][$selectedOptRed[id]][$cntrVal] == 2 )
								$selectedOptRed['sub_category'].= $extraSubCategory[$cntrVal]." not evident ";
						}
						if($extraSubCategory != '')$selectedOptRed['sub_category'] .= ")";
						$extraSubCategory = '';
						$peSentenceButtonRed  .= $seperateRed.$selectedOptRed['sub_category'];
					}

					$peSentenceRed .= $peSentenceButtonRed." not evident";
					$finalSentenceArrPE[] = $peSentenceRed;
				}
				$otherSentencePe = '';
				for($i = 0; $i<count($peResultOther); $i++){
					$InnerSeperator = '';
					$otherSubCategory = array_keys($peResultOther);
					if($i  == count($peResultOther)-1 && count($peResultOther) != 1){
						$InnerSeperator = ' and ';
					}else if($i != 0 ) $InnerSeperator = ', ';

					$otherSentencePe  .= $InnerSeperator.$otherSubCategory[$i];
				}
				$finalSentence .= $finalSentenceButton;
				$finalSentenceArrPE[] = $finalSentence;
				$loopCntr++;
			}
			/** BOF ROS */
		}//debug($hpiMasterData);
		if($newLine)
			$peNewData = implode('.<br>',array_filter($finalSentenceArrPE))." $otherSentencePe";
		else
			$peNewData = implode('. ',array_filter($finalSentenceArrPE))." $otherSentencePe";
		/** EOF sentence */
		return $peNewData;
	}

	/**
	 * function to create sentences for Physical Exam
	 * @author Gaurav Cahuriya
	 */
	function createPhysicalExamSentence ( $hpiMasterData = null, $peResultOther = null, $pEButtonsOptionValue = null ){
		/** BOF PE sentence */
		//debug($hpiMasterData);
		//debug($pEButtonsOptionValue);

		$sentenceAry = array();
		foreach($hpiMasterData as $sentenceArray){
			$tempSentence = '';
			$tempSentenceHeading = '';
			/** BOF PE */
			if($sentenceArray['Template']['template_category_id'] == 2){ /** template_category_id = 2 is for PE */

				$tempSentenceHeading = strtoupper(trim($sentenceArray['Template']['category_name']))." : ";
				$templateId = $sentenceArray['Template']['id'];

				if( !empty($sentenceArray['TemplateSubCategories']) ){
					$countTemplate = count($sentenceArray['TemplateSubCategories']);
					$loopcounter = 1;
					foreach($sentenceArray['TemplateSubCategories'] as $subCategories){
						$templateName = strtolower(trim($sentenceArray['Template']['category_name']));
						if( strtoupper(trim($subCategories['sub_category'])) == 'OTHER' )continue;
						//if(empty($sentenceArray['TemplateSubCategoriesRed']) )
						$seperator = ($loopcounter == $countTemplate-1) ? ' and ' : ', ';
						//else $seperator = '';
						$templateSubCatID = $subCategories['id'];
						$dropDownButtons = unserialize($subCategories['extraSubcategory']);
						$positiveDropDownSentence = unserialize($subCategories['extraSubcategoryDesc']);
						$negativeDropDownSentence = unserialize($subCategories['extraSubcategoryDescNeg']);

						if(!empty($dropDownButtons[0])){
							/** dd button sentence */
							$countOfOptions = count($pEButtonsOptionValue[0][$templateId][$templateSubCatID]);/** $pEButtonsOptionValue[0] is selectedButton array*/
							$buttonSeleceted = false;
							for($i = 0; $i<= $countOfOptions; $i++){
								if($pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i] == 1){/** 1 is for green button */
									$tempSentence .= trim($positiveDropDownSentence[$i]).$seperator;/** positive sentence array */
									$buttonSeleceted = true;
								}
								if($pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i] == 2){/** 2 is for red button */
									$tempSentence .= trim($negativeDropDownSentence[$i]).$seperator;/** negative sentence array */
									$buttonSeleceted = true;
								}
							}
							if(!$buttonSeleceted){

								if( $templateName  == 'constitutional' )
									$tempSentence.= trim($subCategories['sub_category']).$seperator;
								else
									$tempSentence.= trim($subCategories['sub_category']).' present'.$seperator;
							}

						}else if( empty($dropDownButtons[0]) && empty($pEButtonsOptionValue[1][$templateId][$templateSubCatID]) ){
							/** only button Text*/
							if( $templateName  == 'constitutional' )
								$tempSentence.= trim($subCategories['sub_category']).$seperator;
							else
								$tempSentence.= trim($subCategories['sub_category']).' present'.$seperator;
						}else if(empty($dropDownButtons[0]) && !empty($pEButtonsOptionValue[1][$templateId][$templateSubCatID])){
							/** text area text */
							$tempSentence .= trim($pEButtonsOptionValue[1][$templateId][$templateSubCatID]).$seperator;
						}
						$loopcounter++;
					}
				}
				if( !empty($sentenceArray['TemplateSubCategoriesRed']) ){
					$countTemplate = count($sentenceArray['TemplateSubCategoriesRed']);
					$loopcounter = 1;
					foreach($sentenceArray['TemplateSubCategoriesRed'] as $subCategories){
						$templateName = strtolower(trim($sentenceArray['Template']['category_name']));

						//if(empty($sentenceArray['TemplateSubCategories']) )
						$seperator = ($loopcounter == $countTemplate-1) ? ' and ' : ', ';
						//else $seperator = '';
						$templateSubCatID = $subCategories['id'];
						$dropDownButtons = unserialize($subCategories['extraSubcategory']);
						$positiveDropDownSentence = unserialize($subCategories['extraSubcategoryDesc']);
						$negativeDropDownSentence = unserialize($subCategories['extraSubcategoryDescNeg']);
							
						if(!empty($dropDownButtons[0])){ /** this block will never execuit as we do not allow red button for !empty ddButton */
							/** dd button sentence */
							$countOfOptions = count($pEButtonsOptionValue[0][$templateId][$templateSubCatID]);/** $pEButtonsOptionValue[0] is selectedButton array*/
							$buttonSeleceted = false;
							for($i = 0; $i<= $countOfOptions; $i++){
								if($pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i] == 1){/** 1 is for green button */
									$tempSentence .= trim($positiveDropDownSentence[$i]).$seperator;/** positive sentence array */
									$buttonSeleceted = true;
								}
								if($pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i] == 2){/** 2 is for red button */
									$tempSentence .= trim($negativeDropDownSentence[$i]).$seperator;/** negative sentence array */
									$buttonSeleceted = true;
								}
							}
							if(!$buttonSeleceted){
								if( $templateName  == 'constitutional' )
									$tempSentence.= trim($subCategories['sub_category']).$seperator;
								else
									$tempSentence.= trim($subCategories['sub_category']).' absent'.$seperator;
							}
						}else if( empty($dropDownButtons[0]) && empty($pEButtonsOptionValue[1][$templateId][$templateSubCatID]) ){
							/** only button Text*/
							if( $templateName  == 'constitutional' )
								$tempSentence.= trim($subCategories['sub_category']).$seperator;
							else
								$tempSentence.= trim($subCategories['sub_category']).' absent'.$seperator;
						}else if(empty($dropDownButtons[0]) && !empty($pEButtonsOptionValue[1][$templateId][$templateSubCatID])){
							/** text area text */
							$tempSentence .= trim($pEButtonsOptionValue[1][$templateId][$templateSubCatID]).$seperator;
						}
						$loopcounter++;
					}
				}
				$otherSentencePe = '';
				$keyCountAry = array_count_values($peResultOther);
				$innerCount[$templateId] = 0;
				for($i = 0; $i<count($peResultOther); $i++){
					$keycount = $keyCountAry[$templateId];
					$otherSubCategory = array_keys($peResultOther);
					if($peResultOther[$otherSubCategory[$i]] == $templateId){
						$InnerSeperator = '';
						if($innerCount[$templateId]  == $keycount-1 && $keycount != 1){
							$InnerSeperator = ' and ';
						}else if($innerCount[$templateId] != 0 ) $InnerSeperator = ', ';
							
						$otherSentencePe  .= $InnerSeperator.$otherSubCategory[$i];
						$innerCount[$templateId]++;
					}
				}
				$tempSentence = trim($tempSentence).$otherSentencePe;$otherSentencePe = '';
				$sentenceAry[]  = $tempSentenceHeading.ucfirst(strtolower(rtrim($tempSentence,',')));
			}
		}
		$finalSentence = implode('.<br>',$sentenceAry);
		$finalSentence = str_replace('noted', 'present', $finalSentence);
		$finalSentence = str_replace('not evident', 'absent', $finalSentence);
		/** EOF sentence */
		return $finalSentence;
	}

	function createPhysicalExamSentenceWorking ( $hpiMasterData = null, $peResultOther = null, $pEButtonsOptionValue = null ){
		/** BOF PE sentence */
		/*debug($hpiMasterData);
		 debug($pEButtonsOptionValue);
		debug($peResultOther);*/
		$peSentence = '';
		$finalSentence = '';
		foreach($hpiMasterData as $sentenceArray){

			/** BOF PE */
			if($sentenceArray['Template']['template_category_id'] == 2){ /** template_category_id = 2 is for PE */
				$templateId = $sentenceArray['Template']['id'];

				$chekSubCatDone = false;
					
				if( !empty($sentenceArray['TemplateSubCategories']) ){
					foreach($sentenceArray['TemplateSubCategories'] as $subCategories){
						$templateSubCatID = $subCategories['id'];
						$dropDownOptions = unserialize($subCategories['extraSubcategoryDesc']);
						$countOfOptions = count($pEButtonsOptionValue[0][$templateId][$templateSubCatID]);/** $pEButtonsOptionValue[0] is selectedButton array*/
						if($pEButtonsOptionValue[0][$templateId][$templateSubCatID]){
							//debug($pEButtonsOptionValue[0][$templateId][$templateSubCatID]);
							$isDDButtonSelected = false;
							//debug($dropDownOptions);
							for($i = 0; $i<= $countOfOptions; $i++){
								//echo $pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i]."--";
								if($pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i] == 1){/** 1 is for green button */
									//echo $dropDownOptions[0][$i]."---".$pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i]."<br>";
									$peSentence[] = $dropDownOptions[0][$i];/** $dropDownOptions[0] is positive sentence array */
									$isDDButtonSelected = true;
								}
								if($pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i] == 2){/** 2 is for red button */
									//echo $dropDownOptions[1][$i]."---".$pEButtonsOptionValue[0][$templateId][$templateSubCatID][$i]."<br>";
									$peSentence[] = $dropDownOptions[1][$i];/** $dropDownOptions[0] is negative sentence array */
									$isDDButtonSelected = true;
								}
							}
							if(!$isDDButtonSelected && !isset($pEButtonsOptionValue[1][$templateId][$templateSubCatID])){
								$peSentence[] = $subCategories['sub_category'];
							}
						}else if($pEButtonsOptionValue[1][$templateId][$templateSubCatID]){
							$peSentence[] = $pEButtonsOptionValue[1][$templateId][$templateSubCatID];
						}else{ /** else is for buttons w/o dd options */
							$peSentence[] = $subCategories['sub_category'];
						}

					}


				}
				if( !empty($sentenceArray['TemplateSubCategoriesRed']) ){
					foreach($sentenceArray['TemplateSubCategoriesRed'] as $subCategoriesRed){

						$templateSubCatRedID = $subCategoriesRed['id'];
						$dropDownOptionsRed = unserialize($subCategoriesRed['extraSubcategoryDesc']);

						$countOfOptionsRed = count($pEButtonsOptionValue[0][$templateId][$templateSubCatRedID]);/** $pEButtonsOptionValue[0] is selectedButton array*/
						if($pEButtonsOptionValue[0][$templateId][$templateSubCatRedID]){

							for($i = 0; $i<= $countOfOptionsRed; $i++){
								if($pEButtonsOptionValue[0][$templateId][$templateSubCatRedID][$i] == 2)/** 1 is for red button */
									$peSentenceRed[] = $dropDownOptionsRed[1][$i]; /** $dropDownOptionsRed[1] is negative sentence array */
									
							}
						}else { /** else is for buttons w/o dd options */
							$peSentenceRed[] = $subCategoriesRed['sub_category'];
						}
						if($pEButtonsOptionValue[1][$templateId][$templateSubCatRedID]){
							$peSentenceRed[] = $pEButtonsOptionValue[1][$templateId][$templateSubCatRedID];
						}
					}


				}
				//				debug($peSentence);
				$finalSentence = strtoupper($sentenceArray['Template']['category_name'])." : ".ucfirst(implode(', ',$peSentenceGreen)).". ".ucfirst(implode(', ',$peSentenceRed));
			}
		}
		/** EOF sentence */
		return $finalSentence;
	}
	
	function getBrowser(){
		$u_agent = $_SERVER['HTTP_USER_AGENT'];
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";
	
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		}
		elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
			
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Internet Explorer';
			$ub = "MSIE";
		}
		elseif(preg_match('/Firefox/i',$u_agent))
		{
			$bname = 'Mozilla Firefox';
			$ub = "Firefox";
		}
		elseif(preg_match('/Chrome/i',$u_agent))
		{
			$bname = 'Google Chrome';
			$ub = "Chrome";
		}
		elseif(preg_match('/Safari/i',$u_agent))
		{
			$bname = 'Apple Safari';
			$ub = "Safari";
		}
		elseif(preg_match('/Opera/i',$u_agent))
		{
			$bname = 'Opera';
			$ub = "Opera";
		}
		elseif(preg_match('/Netscape/i',$u_agent))
		{
			$bname = 'Netscape';
			$ub = "Netscape";
		}
			
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
			
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			}
			else {
				$version= $matches['version'][1];
			}
		}
		else {
			$version= $matches['version'][0];
		}
			
		// check if we have a number
		if ($version==null || $version=="") {
			$version="?";
		}
			
		return array(
				'userAgent' => $u_agent,
				'name'      => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'    => $pattern
		);
	}
	
	function replaceCharsInPhone($phone){
		$phone = str_replace("(", "", $phone);
		$phone = str_replace(")", "", $phone);
		$phone = str_replace(" ", "", $phone);
		$phone = str_replace("-", "", $phone);
		$phone = str_replace("(", "", $phone);
		$phone = str_replace(")", "", $phone);
		$phone = str_replace(" ", "", $phone);
		$phone = str_replace("-", "", $phone);
		return $phone;
	}
	
	/**
	 * get_words_until() Returns a string of delimited text parts up to a certain length
	 * If the "words" are too long to limit, it just slices em up to the limit with an ellipsis "..."
	 *
	 * @param $paragraph - The text you want to Parse
	 * @param $limit - The maximum character length, e.g. 160 chars for SMS
	 * @param string $delimiter - Use ' ' for words and '. ' for sentences (abbreviation bug) :)
	 * @param null $ellipsis - Use '...' or ' (more)' - Still respects character limit
	 *
	 * @return string
	 */
	function get_words_until($paragraph, $limit, $delimiter = ' ', $ellipsis = null){
		$parts = explode($delimiter, $paragraph);
	
		$preview = "";
	
		if ($ellipsis) {
			$limit = $limit - strlen($ellipsis);
		}
	
		foreach ($parts as $part) {
			$to_add = $part . $delimiter;
			if (strlen($preview . trim($to_add)) <= $limit) { // Can the part fit?
				$preview .= $to_add;
				continue;
			}
			if (!strlen($preview)) { // Is preview blank?
				$preview = substr($part, 0, $limit - 3) . '...'; // Forced ellipsis
				break;
			}
		}
	
		return trim($preview) . $ellipsis;
	}
	
	//for accounting print header by amit jain
	public function billingHeader($locationId){
		$location = Classregistry::init('Location');
		$locationData = $location->read(null,$locationId);
		/* $footer="";
		if(!empty($locationData['Location']['address1'])){
			$footer.= $locationData['Location']['address1'].','."\n";
		}
		if(!empty($locationData['Location']['address2'])){
			$footer.= $locationData['Location']['address2'].',';
		}
		if(!empty($locationData['City']['name'])){
			$footer.= $locationData['City']['name'].'-';
		}
		if(!empty($locationData['Location']['zipcode'])){
			$footer.=$locationData['Location']['zipcode'].','."\n";
		}
		if(!empty($locationData['State']['name'])){
			$footer.= $locationData['State']['name'].','."\n";
		}
		if(!empty($locationData['Location']['email'])){
			$footer.= 'Email-'.$locationData['Location']['email'];
		} */
		#pr($footer);exit;
		return $locationData;
		}
		
		
		/*
		 * @autor Pawan Meshram
		 * @type (years or months)
		 * @value (e.g. 10)
		 */
		
		function convertYearsMonthsToDays($value,$type,$returnType='days'){
			if($type != 'dob')
			$startDate = date("Y-m-d",strtotime("-" . $value . " ". $type));
			else $startDate = ($type == 'days')? (int) ++$value:$value;
			$startDate = new DateTime($startDate);
			$endDate = new DateTime(date("Y-m-d"));
			$diff = $startDate->diff($endDate, true);
			return $diff->$returnType;
		}
		/**
	 	* function to get multilevel Group for profit Loss Report
	 	* @param int $parentId --> 0
	 	* @param group list array $accountingGroupList--> From accountinggroup ids;
	 	* @param groupwise ledger data $ledgerArr --> ledger amount with accounting group id;
	 	* @param char $getAccountingGroupName --> group name
	 	* @param filter debit credit sum $groupeExpIncData --> sum of all leders groupwise and ledgerwise
	 	* @param string flag for type data divide in four parts $flagAccountType --> Income,Expense,Indirect Income,Indirect Expense
	 	* @param $recurciveBalParent --> parent_id wise $parent_id
	 	* @param $recurciveBalChild --> child group id wise $key
	 	* @return get array($html,$totalPortionwise);
		* @author  Mahalaxmi Nakade
		*/
		// recursive function to create multilevel menu list, $parentId 0 is the Root
		function multilevelMenu($parentId,$accountingGroupList=array(), $ledgerArr=array(),$getAccountingGroupName=array(),$groupeExpIncData=array(),$flagAccountType=null,$recurciveBalParent,$recurciveBalChild) {			
		  $html = '';       // stores and returns the html code with Menu lists
		  // if parent item with child IDs in accountingGroupList
		  	if(isset($accountingGroupList[$parentId])) {
		  		if($parentId==0){						
						$groupMainCls='class="mainParentClsUl"';						
					}else{
						$groupMainCls='class="parentClsUl"';
					}
		    	$html = '<ul '.$groupMainCls.'>';    // open UL
			    // traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ledgerArr	   
			    foreach ($accountingGroupList[$parentId] as $childId) {
			    	if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){
				    	if(!empty($groupeExpIncData[$childId]['income_debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_credit'];
						}	
					}
					if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){
				    	if(!empty($groupeExpIncData[$childId]['debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['credit'];
						}	
					}
						#debug($getAccountingGroupName[$childId].'-'.$childId.'---'.$recurciveBalParent[$accountingGroupList[$childId][0]].' + '.$recurciveBalParent[$childId].'+ '.$recurciveBalChild[$childId]);
					if(count($accountingGroupList[$childId]) > 1){
							foreach($accountingGroupList[$childId] as $subChild){#debug($recurciveBalParent[$subChild]);
								if(isset($recurciveBalParent[$subChild])){
									$currentGrpBalance = $recurciveBalParent[$subChild];
									break;
								}
							}
							
					}else{
							$currentGrpBalance = $recurciveBalParent[$accountingGroupList[$childId][0]];
					}
					if($recurciveBalParent[$childId] && $recurciveBalChild[$childId]){
						$subGroupBal=$currentGrpBalance + $recurciveBalParent[$childId]+ $recurciveBalChild[$childId];				
					}else if($recurciveBalParent[$childId]){
						$subGroupBal= (int) $currentGrpBalance + $recurciveBalParent[$childId];
					}else{
						$subGroupBal= (int) $currentGrpBalance + $recurciveBalChild[$childId];
					}
					if($subGroupBal==0){
						continue;
					}
					if($parentId==0){
						//$cls='class="collapsed"';
						$groupCls='class="mainParentCls"';
						$totalPortionwise=$totalPortionwise+$subGroupBal;
					}else{
						$groupCls='class="parentCls"';
					}

					$subGroupBalTotal = number_format($subGroupBal, 2);
					
			      	$html .= '<li class="collapsed groupExpandCollapsed">
			      				<div '.$groupCls.' style="float:left; width: 100%;">
									<div class="prntDiv1 parent" >'.$getAccountingGroupName[$childId].'</div>
										<div style="float: right;">'.$subGroupBalTotal.'</div>
								</div>';
								if(!empty($ledgerArr[$childId])){
									$html .= '<ul class="legderUl" style="float:left;overflow:hidden; width: 90%;">'; //max-height: 800px;
								}
						
						          // re-calls the function to find 


						      	foreach($ledgerArr[$childId] as $key=>$ledger){	
						      		if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){				      		
							      		if(!empty($ledger['income_debit'])){
											$totalLedgerAmtArr[$key]=$ledger['income_debit'];
										}else{
											$totalLedgerAmtArr[$key]=$ledger['income_credit'];
										}
									}
									if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){if(!empty($ledger['debit'])){
											$totalLedgerAmtArr[$key]=$ledger['debit'];
										}else{
											$totalLedgerAmtArr[$key]=$ledger['credit'];
										}
									}
									if($totalLedgerAmtArr[$key]==0){
										continue;
									}
									//$groupTotal=$groupTotal+$totalLedgerAmtArr[$key];
									$totalAmtLedgerShowArr[$key] = number_format($totalLedgerAmtArr[$key], 2);
								      // open LI
								      $html .= '<li><div class="subchildCls" style="float:left; width: 100%;">
															<div class="subchldDiv1 subchild" id='.$ledger['acc_id'].'>'. $ledger['acc_name'] .'</div>
																<div style="float: right;">'.$totalAmtLedgerShowArr[$key].'</div>
															</div></li>';								      
						  		}//EOF foreach of ledger $ledgerArr[$childId]
			  		$returnHtml = $this->multilevelMenu( $childId, $accountingGroupList, $ledgerArr, $getAccountingGroupName,$groupeExpIncData,$flagAccountType,$recurciveBalParent,$recurciveBalChild); 
			  		$html .= $returnHtml[0];
			  		if(!empty($ledgerArr[$childId])){
			  			$html .= '</ul>';
			  		}
			  		$html .= '</li>';      // close LI
		      
		    	}
		    $html .= '</ul>';       // close UL
		  	}

		  return array($html,$totalPortionwise);
		} 
		/**
	 	* function to get multilevel Only Group for profit Loss Report
	 	* @param int $parentId --> 0
	 	* @param group list array $accountingGroupList--> From accountinggroup ids;
	 	* @param groupwise ledger data $ledgerArr --> ledger amount with accounting group id;
	 	* @param char $getAccountingGroupName --> group name
	 	* @param filter debit credit sum $groupeExpIncData --> sum of all leders groupwise and ledgerwise
	 	* @param string flag for type data divide in four parts $flagAccountType --> Income,Expense,Indirect Income,Indirect Expense
	 	* @param $recurciveBalParent --> parent_id wise $parent_id
	 	* @param $recurciveBalChild --> child group id wise $key
	 	* @return get array($html,$totalPortionwise);
		* @author  Mahalaxmi Nakade
		*/
		// recursive function to create multilevel menu list, $parentId 0 is the Root
		function multilevelMenuGroup($parentId,$accountingGroupList=array(), $ledgerArr=array(),$getAccountingGroupName=array(),$groupeExpIncData=array(),$flagAccountType=null,$recurciveBalParent,$recurciveBalChild) {			
		  $html = '';       // stores and returns the html code with Menu lists
		  // if parent item with child IDs in accountingGroupList
		  	if(isset($accountingGroupList[$parentId])) {
		    	$html = '<ul>';    // open UL
			    // traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ledgerArr	   
			    foreach ($accountingGroupList[$parentId] as $childId) {
			    	if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){
				    	if(!empty($groupeExpIncData[$childId]['income_debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_credit'];
						}	
					}
					if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){
				    	if(!empty($groupeExpIncData[$childId]['debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['credit'];
						}	
					}
						#debug($getAccountingGroupName[$childId].'-'.$childId.'---'.$recurciveBalParent[$accountingGroupList[$childId][0]].' + '.$recurciveBalParent[$childId].'+ '.$recurciveBalChild[$childId]);
					if(count($accountingGroupList[$childId]) > 1){
							foreach($accountingGroupList[$childId] as $subChild){#debug($recurciveBalParent[$subChild]);
								if(isset($recurciveBalParent[$subChild])){
									$currentGrpBalance = $recurciveBalParent[$subChild];
									break;
								}
							}
							
					}else{
							$currentGrpBalance = $recurciveBalParent[$accountingGroupList[$childId][0]];
					}
					if($recurciveBalParent[$childId] && $recurciveBalChild[$childId]){
						$subGroupBal=$currentGrpBalance + $recurciveBalParent[$childId]+ $recurciveBalChild[$childId];				
					}else if($recurciveBalParent[$childId]){
						$subGroupBal= (int) $currentGrpBalance + $recurciveBalParent[$childId];
					}else{
						$subGroupBal= (int) $currentGrpBalance + $recurciveBalChild[$childId];
					}
					if($subGroupBal==0){
						continue;
					}
					if($parentId==0){
						//$cls='class="collapsed"';
						$groupCls='class="mainParentCls"';
						$totalPortionwise=$totalPortionwise+$subGroupBal;
					}else{
						$groupCls='class="parentCls"';
					}

					$subGroupBalTotal = number_format($subGroupBal, 2);
					
			      $html .= '<li class="collapsed">
			      				<div '.$groupCls.' style="float:left; width: 100%;">
									<div class="prntDiv1 parent" >'.$getAccountingGroupName[$childId].'</div>
										<div style="float: right;">'.$subGroupBalTotal.'</div>
								</div>
								<ul style="float:left;overflow:hidden; width: 90%;">'; //max-height: 800px;
						          // re-calls the function to find 


						      	foreach($ledgerArr[$childId] as $key=>$ledger){	
						      		if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){				      		
							      		if(!empty($ledger['income_debit'])){
											$totalLedgerAmtArr[$key]=$ledger['income_debit'];
										}else{
											$totalLedgerAmtArr[$key]=$ledger['income_credit'];
										}
									}
									if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){if(!empty($ledger['debit'])){
											$totalLedgerAmtArr[$key]=$ledger['debit'];
										}else{
											$totalLedgerAmtArr[$key]=$ledger['credit'];
										}
									}
									if($totalLedgerAmtArr[$key]==0){
										continue;
									}
									//$groupTotal=$groupTotal+$totalLedgerAmtArr[$key];
									$totalAmtLedgerShowArr[$key] = number_format($totalLedgerAmtArr[$key], 2);
								      // open LI
								    /*  $html .= '<li><div class="subchildCls" style="float:left; width: 100%;">
															<div class="subchldDiv1 subchild" id='.$ledger['acc_id'].'>'. $ledger['acc_name'] .'</div>
																<div style="float: right;">'.$totalAmtLedgerShowArr[$key].'</div>
															</div></li>';	*/							      
						  		}//EOF foreach of ledger $ledgerArr[$childId]
			  		$returnHtml = $this->multilevelMenu( $childId, $accountingGroupList, $ledgerArr, $getAccountingGroupName,$groupeExpIncData,$flagAccountType,$recurciveBalParent,$recurciveBalChild); 
			  		#$html .= $returnHtml[0];
			  		$html .= '</ul></li>';      // close LI
		      
		    	}
		    $html .= '</ul>';       // close UL
		  	}

		  return array($html,$totalPortionwise);
		} 

		/**
	 	* function to get multilevel Group for profit Loss Report
	 	* @param int $parentId --> 0
	 	* @param group list array $accountingGroupList--> From accountinggroup ids;
	 	* @param groupwise ledger data $ledgerArr --> ledger amount with accounting group id;
	 	* @param char $getAccountingGroupName --> group name
	 	* @param filter debit credit sum $groupeExpIncData --> sum of all leders groupwise and ledgerwise
	 	* @param string flag for type data divide in four parts $flagAccountType --> Income,Expense,Indirect Income,Indirect Expense
	 	* @param $recurciveBalParent --> parent_id wise $parent_id
	 	* @param $recurciveBalChild --> child group id wise $key
	 	* @return get array($html,$totalPortionwise);
		* @author Mahalaxmi Nakade
		*/
		// recursive function to create multilevel menu list, $parentId 0 is the Root
		function multilevelMenuXls($parentId,$accountingGroupList=array(), $ledgerArr=array(),$getAccountingGroupName=array(),$groupeExpIncData=array(),$flagAccountType=null,$recurciveBalParent,$recurciveBalChild) {			
		  //	$html = '';       // stores and returns the html code with Menu lists
		  	// if parent item with child IDs in accountingGroupList
		  	if(isset($accountingGroupList[$parentId])) {
		  		$s = 0;
		    	//$html = '<ul>';    // open UL
			    // traverses the array with child IDs of current parent, and adds them in LI tags, with their data from $ledgerArr	   
			    foreach ($accountingGroupList[$parentId] as $childId) {
			    	$arr='';
			    	if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){
				    	if(!empty($groupeExpIncData[$childId]['income_debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['income_credit'];
						}	
					}
					if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){
				    	if(!empty($groupeExpIncData[$childId]['debit'])){
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['debit'];
						}else{
							$totalAmtArr[$childId]=$groupeExpIncData[$childId]['credit'];
						}	
					}
						#debug($getAccountingGroupName[$childId].'-'.$childId.'---'.$recurciveBalParent[$accountingGroupList[$childId][0]].' + '.$recurciveBalParent[$childId].'+ '.$recurciveBalChild[$childId]);
					if(count($accountingGroupList[$childId]) > 1){
							foreach($accountingGroupList[$childId] as $subChild){#debug($recurciveBalParent[$subChild]);
								if(isset($recurciveBalParent[$subChild])){
									$currentGrpBalance = $recurciveBalParent[$subChild];
									break;
								}
							}
						}else{
							$currentGrpBalance = $recurciveBalParent[$accountingGroupList[$childId][0]];
						}
					if($recurciveBalParent[$childId] && $recurciveBalChild[$childId]){
						$subGroupBal=$currentGrpBalance + $recurciveBalParent[$childId]+ $recurciveBalChild[$childId];
					}else if($recurciveBalParent[$childId]){
						$subGroupBal= (int) $currentGrpBalance + $recurciveBalParent[$childId];
					}else{
						$subGroupBal= (int) $currentGrpBalance + $recurciveBalChild[$childId];
					}
					if($parentId==0){
						$totalPortionwise=$totalPortionwise+$subGroupBal;
					}
					$subGroupBalTotal = number_format($subGroupBal, 2);
					
					//debug($totalPortionwise)
					$arr[]=$getAccountingGroupName[$childId];
					$arr[]=$subGroupBalTotal;
					
			     /* $html .= '<li class="collapsed">
			      				<div class="parentCls" style="float:left; width: 100%;">
									<div class="prntDiv1 parent" >'.$getAccountingGroupName[$childId].'</div>
										<div style="float: right;">'.$subGroupBalTotal.'</div>
								</div>
								<ul style="float:left;overflow:hidden; width: 97%;">'; //max-height: 800px;
						          // re-calls the function to find */


						      	foreach($ledgerArr[$childId] as $key=>$ledger){	
						      		// $subArr='';
						      		 $s++;
						      		if($flagAccountType==Configure::read('income_label') || $flagAccountType==Configure::read('indirect_income_label')){				      		
							      		if(!empty($ledger['income_debit'])){
											$totalLedgerAmtArr[$key]=$ledger['income_debit'];
										}else{
											$totalLedgerAmtArr[$key]=$ledger['income_credit'];
										}
									}
									if($flagAccountType==Configure::read('expense_label') || $flagAccountType==Configure::read('indirect_expenses_label')){if(!empty($ledger['debit'])){
											$totalLedgerAmtArr[$key]=$ledger['debit'];
										}else{
											$totalLedgerAmtArr[$key]=$ledger['credit'];
										}
									}
									//$groupTotal=$groupTotal+$totalLedgerAmtArr[$key];
									$totalAmtLedgerShowArr[$key] = number_format($totalLedgerAmtArr[$key], 2);
								      // open LI
								   	$subArr[$s][] = $ledger['acc_name'];
								    $subArr[$s][]=$totalAmtLedgerShowArr[$key];							      
						  		}//EOF foreach of ledger $ledgerArr[$childId]
			  		$returnHtml[0] = $this->multilevelMenu( $childId, $accountingGroupList, $ledgerArr, $getAccountingGroupName,$groupeExpIncData,$flagAccountType,$recurciveBalParent,$recurciveBalChild); 
			  		$arr[].= $returnHtml[0];
			  		//$html .= '</ul></li>';      // close LI

			  		 $resetArray = $subArr[$s]; 
					  array_walk($resetArray , 'replace_comma') ;
					  $arr[] = $resetArray ;
		      
		    	}
		    //$html .= '</ul>';       // close UL
		  	}

		  return array($arr,$totalPortionwise);
		} 
		/*
		 * @autor Mahalaxmi 
		 * @type (years or months or Days) 
		 * @value (age)
		 */
		
		function convertYearsMonthsToDaysSeparate($ageValue){			
			$getExploArr=explode(" ",$ageValue);		
			$getExploArr=array_filter($getExploArr);
			$flagYear=false;
			$flagMonth=false;
			$getAge=null;
			foreach($getExploArr as $getExploArrs){
				$getLastStrValue=substr($getExploArrs,-1);	//find last character as D,M,Y				
				$getExactValueArr=explode($getLastStrValue,$getExploArrs);				
				$getExactValueArr=array_filter($getExactValueArr);		
			
				if($getLastStrValue=="Y" && $flagYear=="0"){
					$getAge=$getExactValueArr['0']." Yrs";
					$flagYear=true;					
				}else if($getLastStrValue=="M" && $flagYear=="0" && $flagMonth=="0"){
					$getAge=$getExactValueArr['0']." Months";
					$flagMonth=true;					
				}else if($getLastStrValue=="D" && $flagMonth=="0" && $flagYear=="0"){
					$getAge=$getExactValueArr['0']." Days";					
				}				
			}			
			return $getAge;		//Return Value as prioritywise means we have fill as year,Month,Day then first priority for year.If we have fill as Month Days then return only Month as well as if we have fill Days then return Days value Only.	
		}
		
}