<?php
class Insurance extends AppModel {

	public $name = 'Insurance';
	public $useTable = false;
	public $specific = true;
	
	 function __construct($id = false, $table = null, $ds = null) {
        $session = new cakeSession();
		$this->db_name =  $session->read('db_name');
        parent::__construct($id, $table, $ds);
    }  
    
    public function generateClaimHeader($postData,$loopData,$groupControlNumber) {
    	
    	$claimHeader=Configure::read('edi_segments_header');
    	    	
    	foreach ($claimHeader as $key => $value) {
    		
    		for($i=0;$i<$value;$i++)
    		{
    			$headerdata[$key][]=$postData[$key][$i];
    			
    		}

    	}
    	//************************Check for Batch***************************
    	if(!empty($headerdata["ISA"]['0'])){
    		$ISA="ISA*".implode("*",$headerdata["ISA"]); 		
    	}
    	//*******************************************************************
    	$GS="GS*".implode("*",$headerdata["GS"]);
    	$ST="ST*".implode("*",$headerdata["ST"]);
    	$BHT="BHT*".implode("*",$headerdata["BHT"]);
    	$REF="REF*".implode("*",$headerdata["REF"]);
    	if(!empty($ISA) && !empty($GS)){
    	$headerData=$ISA."~".$GS."~".$ST."~".$BHT."~";
    	}
    	else{
    		$headerData=$GS."~".$ST."~".$BHT."~";
    	}
    	
    	
    	
    	$loopSeg=$this->generateLoop($loopData,"1000A");//1000A (Submitter) Loop
    	$loopSeg.=$this->generateLoop($loopData,"1000B"); //1000B (Receiver) loop
    	$loopSeg.=$this->generateLoop($loopData,"2000A");
    	$loopSeg.=$this->generateLoop($loopData,"2010AA"); //2010AA (Billing Provider) loop
    	$loopSeg.=$this->generateLoop($loopData,"2000B"); 
    	$loopSeg.=$this->generateLoop($loopData,"2010BA"); //2010BA (Insured Patient) Loop
    	$loopSeg.=$this->generateLoop($loopData,"2010BB");//2010BB (Primary Payer) Loop
    	$loopSeg.=$this->generateLoop($loopData,"2000C");
    	$loopSeg.=$this->generateLoop($loopData,"2010CA"); //2010CA (Patient - Dependent) Loop
    	$loopSeg.=$this->generateLoop($loopData,"2300");   //2300 (Claim Level) Loop
    	$loopSeg.=$this->generateLoop($loopData,"2310C");   //SERVICE FACILITY LOCATION 2310C
    	$loopSeg.=$this->generateLoop($loopData,"2400"); 
    	//create array of loop segment to count no. of segment in EDI message
    	$headerSegCountArr=explode("~",rtrim($headerData,"~"));
    	$loopSegCountArr=explode("~",rtrim($loopSeg,"~"));
    	$segment_counter=count($loopSegCountArr)+(count($headerSegCountArr)-1);
    	//End
    	$GE1="1";
    	$loopSeg.="SE*".$segment_counter."*".$headerdata["ST"]["1"]."~";  //Required segment
    	$loopSeg.="GE*".$GE1."*".$groupControlNumber."~";  //Required segment
    	
    	$loopSeg.=$this->generateLoop($loopData,"footer"); //footer loop required loop
    	
    	$final837Data=$headerData.$loopSeg;
    	//debug($final837Data);
    	if(!empty($final837Data)){
    	return $final837Data;
    	}
    	else{
    		return false;
    	}
    	
    	}
    	
 function generateLoop($loopData,$loopValue)
    {
    	$loopsegment="";
      
    	if($loopValue=='2400')
    	{
    		
            foreach ($loopData[$loopValue] as $key => $value) 
            {
            	            	
            	foreach($loopData[$loopValue][$key] as $x=>$subdata){
            		if(!empty($subdata))
            		   $loopsegment.=$x."*".implode("*",$subdata)."~";
            		
            	}
           
            }
            
    	}
    	else
    	{
    		foreach ($loopData[$loopValue] as $key => $value)
    		{
    			   if(!empty($value))
    				$loopsegment.=substr($key,0,3)."*".implode("*",$value)."~";
    		}
    		
    	}
    	 
    	return $loopsegment;
    
    	
    }
    
    function generateResponseMessage($messageData=null,$messageCount=null,$messageType=null)
    {
    	$claimError= ClassRegistry::init('ClaimError');
    	
    	if($messageType=='999')
    	{
    	//find that 999 contains A or R
    	$ak9=explode("AK9",$messageData["errors"][$messageCount-1]);
    	$ak9=explode("|",$ak9[1]);
    	$ik5=explode("IK5",$messageData["errors"][$messageCount-1]);
    	$ik5=explode("|",$ik5[1]);
    	
       //find other data
       
    	$otherMessage=explode("|",$messageData["otherdata"]["0"]);
    	$group_control_number=$otherMessage["29"];
    	$file_type_format=$otherMessage["31"];
    	$identifier_id=$otherMessage["32"];
    	$datereceived=$otherMessage["9"];
    	$timereceived=$otherMessage["10"];
    	$responseAck=$ak9["1"];

    	if($ak9["1"]=="A" && $ik5["1"]=="A")// for accepted response message
    	{	
    		
    	}
    	else //for rejected message
    	{
    		
    		foreach($messageData["errors"] as $errorData){
    			$responseMessage=explode("|",$errorData);
    			debug($responseMessage);
    			
    			if(!empty($responseMessage["9"]))
    				$CTX=$responseMessage["9"];
    			else
    				$CTX=$responseMessage["5"];
    				
    				
    			$responseMessageFinal["data"][]=$responseMessage["1"].",".rtrim($responseMessage["4"],"IK4").",".$CTX;
    			
    			    			
    		}
    		$SerResponseData = serialize($responseMessageFinal["data"]);
    	}
    		
    			
    	}
    	else if($messageType=='277')
    	{
    		debug($messageData);
    	foreach($messageData as $errorData){
    		
    			$responseMessage=explode("|",$errorData);
    			//debug($responseMessage);
    			if($responseMessage["0"]=="TRN")
    			{
    				$responseMessageFinal["data"]["TRN"]=rtrim(($responseMessage["1"].",".$responseMessage["2"].",".$responseMessage["3"]),",");
    			}
    			if($responseMessage["0"]=="STC")
    			{
    				$responseMessageFinal["data"]["STC"]=rtrim(($responseMessage["1"].",".$responseMessage["2"].",".$responseMessage["3"].",".$responseMessage["4"]),",");
    			}
    			if($responseMessage["0"]=="DTP")
    			{
    				$responseMessageFinal["data"]["DTP"]=rtrim(($responseMessage["1"].",".$responseMessage["2"].",".$responseMessage["3"]),",");
    			}
    			   						   			
    			    			
    		}
    		$ResponseData = array("TRN"=>$responseMessageFinal["data"]["TRN"],"STC"=>$responseMessageFinal["data"]["STC"],"DTP"=>$responseMessageFinal["data"]["DTP"]);
    		//debug($ResponseData);
    		$SerResponseData = serialize($ResponseData);
    		//debug($SerResponseData);
    	}
    	else 
    	{
    		
    	}
    	
    	//save response data in claim_errors table
    	$data["ClaimError"]["group_control_number"]=$group_control_number;
    	$data["ClaimError"]["patient_id"]=ltrim($identifier_id,"0");
    	$data["ClaimError"]["claim_response_data"]=$SerResponseData;
    	$data["ClaimError"]["date_received"]=$datereceived;
    	$data["ClaimError"]["time_received"]=$timereceived;
    	$data["ClaimError"]["incorporate_message_type"]=$messageType;
    	$data["ClaimError"]["create_time"]=date("Y-m-d H:i:s");
    	$data["ClaimError"]["modified_time"]=date("Y-m-d H:i:s");
    	$data["ClaimError"]["response_acknowledgment"]=$responseAck;
    	$claimError->save($data);
    	return true;
    
    }

    
    
 
    
    
}
?>