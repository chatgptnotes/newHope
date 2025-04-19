	<style>
 
 	.lableFont{font-size: 15px; }
  
	.labelf{
		font-size: 14px;
	}
	
	@media print {
	   @page{
	    size: 6.0in 4.0in;
	    size: portrait;
	  }
	  .printBtn{
	  	display: none;
	  }
	}
		body{margin:7px 0 0 0; padding:0;}
		p{margin:0; padding:0;}
		.page-break {
			page-break-before: always;
		}
		.boxBorderBot{border-bottom:1px dashed #3E474A;}
		.boxBorderTop{border-top:1px dashed #3E474A;}
		.boxBorderRight{border-right:1px dashed #3E474A;}
		.boxBorderLeft{border-left:1px dashed #3E474A;}
		.boxBorderBotSolid{border-bottom:1px solid #3E474A;}
		.heading{font-family:Arial, Helvetica, sans-serif; font-size:20px; font-weight:bold; color:#000000; padding:0px 0 0px 0;}
		.headAddress{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#333333;}
		.dlNo, .vatNo{font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#333333;}
		.prescribeDetail{border:1px solid #666666; border-bottom:0px; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#333333;}
		.billTbl{background-color:#333333;}
		.billTbl th{background-color:#ddecc4; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:bold; color:#333333;}
		.billTbl td{background-color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:normal; color:#333333;}
		.billTotal{background-color:#ddecc4; font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold; color:#333333;}
		.billSign{font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#333333;}
		.billFooter{font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold; color:#333333;}
		.blueBtn {
	    background: none repeat scroll 0 0 #6D8A93;
	    border: 0 none;
	    color: #FFFFFF;
	    cursor: pointer;
	    font-family: Arial,Helvetica,sans-serif;
	    font-size: 13px;
	    font-weight: bold;
	    letter-spacing: 0;
	    margin: 5px 12px;
	    overflow: visible;
	    padding: 5px 12px;
	    text-shadow: 1px 1px #025284;
	    text-transform: none;
		text-decoration:none;
	}
	</style>
	<body>
	<!--  <div align="right" id="printBtn"><a class="blueBtn" href="#" onclick="this.style.display='none';window.print();">Print</a></div> -->
	
	<div>
	     <table width='90%'  border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px">
	       <tr>
	         <td width='25%'>&nbsp;</td>
	         <td  width="25%" style="color: red;font-size: 18px;text-align: center;"><u>CASH MEMO</u></td>
	         <td width="25%">&nbsp;</td>
	       </tr>
	       
	        <tr>
	         <td width='25%' class="boxBorderBotSolid">&nbsp;</td>
	         <td colspan="1" class="boxBorderBotSolid"  width="250px" style="font-size: 15px;text-align: center;font-weight: bold;">TIN No. 

09537518372  </td>
	         <td width="348px" class="boxBorderBotSolid" style="font-size: 15px;text-align: right;font-weight: bold;">DL No. 20-175/11.21-

175/11</td> 
	       </tr>
	       
	     </table>      
	   <table  width='91%'  border="0" cellspacing="0" cellpadding="0" style="padding-left: 5px;padding-bottom: 15px">       
	       <tr><td height="25px">&nbsp;</td></tr>
	       <tr>
	         <!-- <td width="58px" height="25px"></td> -->
	         <td width="216px" style="font-size: 15px;text-align: center;font-weight: bold; " class="boxBorderBotSolid"><?php echo $this->Html->image('icons/Roman_logo.png');?></td>
	         <td width="466px" style="font-size: 15px;text-align: left;font-weight: bold; "  valign="bottom" class="boxBorderBotSolid" >117/N/56, Avon Market, kakadeo, Kanpur&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pin-208025 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tel.-0512-6554229 </td>
	       </tr>
	   </table> 
	
	
	
	</div>
	<?php echo $content_for_layout; ?>
	</body>