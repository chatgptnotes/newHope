<style>
    @media print {

    #printButton {
        display: none;
    }

    table {
        page-break-inside: auto;
      }
      tr {
        page-break-inside: avoid;
        page-break-after: auto;
      }
      thead {
        display: table-header-group;
      }
      tfoot {
        display: table-footer-group;
      }
}
.TextCenter{text-align: center;}

</style>

<div style="float:right;" id="printButton">
    <?php echo $this->Html->link('Print','#',array('onclick'=>'window.print();','class'=>'blueBtn','escape'=>false));?>
</div>
  
    <!-- Right Part Template -->
    <div align="center" valign="top" class="heading" style="text-decoration:none;">
         TREATMENT SHEET 2- NIV - O2 SETTING
    </div> 
    
    <div>
        <p><b>Intensive Care Services : Patient is in ICU/critical care room/ private Room with critical care services. The patient was on NIV.  <br><br>
        The patient was on nasal oxygen, High flow mask- oxygen.</b>
        </p>
    </div>
    
    <?php if($nivDetails['NivTreatmentSheet']['admission_date']){
                $admissionDate = $this->DateFormat->formatDate2Local($nivDetails['NivTreatmentSheet']['admission_date'],Configure::read('date_format'),true);
            }else{
                $admissionDate = $this->DateFormat->formatDate2Local($nivDetails['Patient']['form_received_on'],Configure::read('date_format'),true);
            } 

            $unserData = unserialize($nivDetails['NivTreatmentSheet']['niv_details']);
          
        ?>
    <table width="100%" border="1" cellspacing="1" cellpadding="3" class="">
        
        <tr>
            <td valign="top"  align="center">
                Patient Name :
            </td>
            <td valign="top">
                <?php 
                    echo $nivDetails['Patient']['lookup_name'];
                ?>
            </td>  
            <td valign="top" align="center">
                Registration Number :
            </td>
            <td valign="top">
                <?php 
                    echo $nivDetails['Patient']['admission_id'];
                ?>
            </td>                           
        </tr>

        <tr>
             <td valign="top" align="center">
                Age/Gender :
            </td>
            <td valign="top">
                <?php 
                    echo $nivDetails['Patient']['age']."/".$nivDetails['Patient']['sex'];
                ?>
            </td>  
            <td valign="top" align="center">
                DOA :
            </td>
            <td valign="top">
                <?php 
                    echo $admissionDate ; 
                ?>
            </td>                           
        </tr>
        <tr>
             <td valign="top" align="center">
                Date of Reporting:
            </td>
            <td valign="top" colspan="3">
                <?php 
                    echo  $this->DateFormat->formatDate2Local($nivDetails['NivTreatmentSheet']['report_date'],Configure::read('date_format'),true);
                ?>
            </td>  
                                   
        </tr>
    </table> 

    <table width="100%" border="1" cellspacing="1" cellpadding="3" class="">     
                <tr>
                    <td><strong><?php echo "Time" ; ?></strong></td>
                    <td class="TextCenter"><strong><?php echo "IPAP" ; ?></strong></td>
                    <td class="TextCenter"><strong><?php echo "EPAP" ; ?></strong></td>
                    <td class="TextCenter"><strong><?php echo "O2 SATURATION" ; ?></strong></td>
                    <td class="TextCenter"><strong><?php echo "O2 IN LITER" ; ?></strong></td>
                    <td class="TextCenter"><strong><?php echo "HIGH FLOW MASK/NASAL" ; ?></strong></td>
                    <td class="TextCenter"><strong><?php echo "DOCTOR SIGN" ; ?></strong></td>
                    <td class="TextCenter"><strong><?php echo "NURSES SIGN" ; ?></strong></td>
                    
                </tr>
                <tr>
                    <td><strong><?php echo "4 AM" ; ?></strong></td>
                    <td class="TextCenter"><?php echo $unserData['4_am']['ipap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_am']['epap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_am']['o2_saturation'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_am']['o2_in_liter'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_am']['high_flow_mask'];?> </td>
                    <td class="TextCenter">&nbsp;</td>
                    <td class="TextCenter">&nbsp;</td>
                    
                </tr>
                <tr>
                    <td><strong><?php echo "8 AM" ; ?></strong></td>
                    <td class="TextCenter"><?php echo $unserData['8_am']['ipap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_am']['epap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_am']['o2_saturation'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_am']['o2_in_liter'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_am']['high_flow_mask'];?> </td>
                    <td class="TextCenter">&nbsp;</td>
                    <td class="TextCenter">&nbsp;</td>
                    
                </tr>
                <tr>
                    <td><strong><?php echo "12 NOON" ; ?></strong></td>
                    <td class="TextCenter"><?php echo $unserData['12_pm']['ipap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_pm']['epap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_pm']['o2_saturation'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_pm']['o2_in_liter'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_pm']['high_flow_mask'];?> </td>
                    <td class="TextCenter">&nbsp;</td>
                    <td class="TextCenter">&nbsp;</td>
                    
                </tr>
                <tr>
                    <td><strong><?php echo "4 PM" ; ?></strong></td>
                    <td class="TextCenter"><?php echo $unserData['4_pm']['ipap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_pm']['epap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_pm']['o2_saturation'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_pm']['o2_in_liter'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['4_pm']['high_flow_mask'];?> </td>
                    <td class="TextCenter">&nbsp;</td>
                    <td class="TextCenter">&nbsp;</td>
                    
                </tr>
                <tr>
                    <td><strong><?php echo "8 PM" ; ?></strong></td>
                    <td class="TextCenter"><?php echo $unserData['8_pm']['ipap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_pm']['epap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_pm']['o2_saturation'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_pm']['o2_in_liter'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['8_pm']['high_flow_mask'];?> </td>
                    <td class="TextCenter">&nbsp;</td>
                    <td class="TextCenter">&nbsp;</td>
                
                </tr>
                <tr>
                    <td><strong><?php echo "12 MID NIGHT" ; ?></strong></td>
                    <td class="TextCenter"><?php echo $unserData['12_am']['ipap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_am']['epap'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_am']['o2_saturation'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_am']['o2_in_liter'];?> </td>
                    <td class="TextCenter"><?php echo $unserData['12_am']['high_flow_mask'];?> </td>
                    <td class="TextCenter">&nbsp;</td>
                    <td class="TextCenter">&nbsp;</td>
                    
                </tr>
            </table>
    <div style="float: right;padding-top: 15px;">Consultant Signature : _____________________________</div>
    <div style="float: right;padding-top: 15px;">Name : _________________________________________</div>
   
<?php //echo $this->element('report_footer');?>
                    