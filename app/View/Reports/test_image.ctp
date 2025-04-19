<?php
/*header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=test_result.rtf");*/

ob_clean();
flush();
?>  
<style>
    
    @font-face {
            /*font-family: myFirstFont;
            src: url("<?php echo $this->Html->url('/font/ufonts.com_gulim.ttf')?>") format('truetype');*/
        }

    table tr td{ 
         /*font-family: myFirstFont;*/ 
         font-size: 11px !important;  
        /*font-family:Arial, Helvetica, sans-serif;*/ 
        font-family: MS Gothic, MingLiu, TrebuchetMS;
        /*font-family:verdana, arial, sans-serif;*/
        font-weight:normal ; 
        /*line-height: 9px;*/
    } 
    @media print {
        @page{
            size: 2.0in 8.0in;
            size: portrait;
        }
    }
    
   /* body{
        font-size: 8px; 
        font-family:Arial, Helvetica, sans-serif; font-size:20px;
        font-family: MS-Gothic, MingLiu, TrebuchetMS;
        font-weight:normal; 
    }*/
    .mainHead tr td{
        /*line-height: 9px !important;*/
    } 
</style>
<table width="20%"  border="0" cellspacing="0"  cellpadding="0" class="mainHead"> 
    <tr><td colspan="3" style="padding:0px 25px; margin: 0 auto;"><b>---------------------</b></td></tr>
    <tr><td  align="left" colspan="3">i-STAT EG7+ </td></tr> 
    <tr><td  align="left" colspan="3">&nbsp;</td></tr> 
    <tr><td  colspan="3">Pt:--</td> <td></td> </tr>
    <tr><td  colspan="3">Pt Name:___________________</td>  
    </tr>
    <tr><td colspan="3">&nbsp;</td> </tr>
    <tr><td colspan="3">&nbsp;</td> </tr>
    
    <tr><td colspan="2" align="center">----------------</td><td></td> </tr>
    <tr>
        <td align="left" colspan="3">37.0<sup>0</sup>C</td>
    </tr> 
    <tr>
        <td align="left">pH</td>
        <td align="right"><?php echo $data['Patient']['pH']; ?></td>
        <td align="left"></td>
    </tr>
    <tr>
        <td align="left">PCO2</td>
        <td align="right"><?php echo $data['Patient']['PCO2']; ?></td>
        <td align="left">&nbsp;mmHg</td>
    </tr>
    <tr>
        <td align="left">PO2</td>
        <td align="right"><?php echo $data['Patient']['PO2']; ?></td>
        <td align="left">&nbsp;mmHg</td>
    </tr>
    <tr>
        <td align="left">BEecf</td>
        <td align="right"><?php echo $data['Patient']['BEecf']; ?></td>
        <td align="left">&nbsp;mmo I/L</td>
    </tr>
    <tr>
        <td align="left">HCO3</td>
        <td align="right"><?php echo $data['Patient']['HCO3']; ?></td>
        <td align="left">&nbsp;mmo I/L</td>
    </tr>
    <tr>
        <td align="left">TCO2</td>
        <td align="right"><?php echo $data['Patient']['TCO2']; ?></td>
        <td align="left">&nbsp;mmo I/L</td>
    </tr>
    <tr>
        <td align="left">sO2</td>
        <td align="right"><?php echo $data['Patient']['sO2']; ?></td>
        <td align="left">&nbsp;%</td>
    </tr> 
    <tr><td colspan="2" align="center">----------------</td><td></td> </tr>
    <tr>
        <td align="left">Na</td>
        <td align="right"><?php echo $data['Patient']['Na']; ?></td>
        <td align="left">&nbsp;mmo I/L</td>
    </tr>
    <tr>
        <td align="left">K</td>
        <td align="right"><?php echo $data['Patient']['K']; ?></td>
        <td align="left">&nbsp;mmo I/L</td>
    </tr>
    <tr>
        <td align="left">iCa</td>
        <td align="right"><?php echo $data['Patient']['iCa']; ?></td>
        <td align="left">&nbsp;mmo I/L</td>
    </tr>
    <tr>
        <td align="left">Hct</td>
        <td align="right"><?php echo $data['Patient']['Hct']; ?></td>
        <td align="left">%PCV</td>
    </tr>
    <tr>
        <td align="left">Hb*</td>
        <td align="right"><?php echo $data['Patient']['Hb']; ?></td>
        <td align="left">g/dL</td>
    </tr> 
    <tr>
        <td align="center" colspan="2">*Via Hct</td><td></td></tr>
    <tr>
        <td align="left" colspan="3">CPB: No</td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <?php list($date,$month,$year) =  explode("-",date("d-M-y")); ?>
    <tr><td colspan="3"><?php echo date("H:II")."&nbsp;&nbsp;".$date.''.strtoupper($month).''.$year; ?></td></tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td align="left" colspan="3">Operator ID:</td> 
    </tr>
    <tr><td align="left" colspan="3">Physician:______________</td> </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td align="left" colspan="3">Lot Number: 426W151130236</td>
    </tr>
    <tr>
        <td align="left" colspan="3">Serial: 358440</td>
    </tr>
    <tr>
        <td align="left" colspan="3">Version: JAMS139C</td>
    </tr>
    <tr>
        <td align="left" colspan="3">CLEW: A30</td>
    </tr>
    <tr>
        <td align="left" colspan="3">Custom: 00000000</td>
    </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr><td colspan="2" align="center">----------------</td><td></td> </tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
        <td align="left" colspan="3">Reference Ranges</td>
    </tr> 
    <tr>
        <td colspan="3">
            <table width="100%">
                <tr>
                    <td width="25%" align="left">pH</td>
                    <td width="20%" align="right">7.130</td>
                    <td width="20%" align="right">7.410</td>
                    <td width="5%" align="center"></td>
                    <td width="30%" align="left"></td>
                </tr>  
                <tr>
                    <td align="left">PCO2</td>
                    <td align="right">41.0</td>
                    <td align="right">51.0</td>
                    <td></td>
                    <td align="left">mmHg</td>
                </tr>  
                <tr>
                    <td align="left">PO2</td>
                    <td align="right">80</td>
                    <td align="right">105</td>
                    <td></td>
                    <td align="left">mmHg</td>
                </tr>  
                <tr>
                    <td align="left">BEecf</td>
                    <td align="right">-6</td>
                    <td align="right">3</td>
                    <td></td>
                    <td align="left">mmo l/L</td>
                </tr>  
                <tr>
                    <td align="left">HCO3</td>
                    <td align="right">12.0</td>
                    <td align="right">28.0</td>
                    <td></td>
                    <td align="left">mmo l/L</td>
                </tr>  
                <tr>
                    <td align="left">TCO2</td>
                    <td align="right">18</td>
                    <td align="right">29</td>
                    <td></td>
                    <td align="left">mmo l/L</td>
                </tr>  
                <tr>
                    <td align="left">sO2</td>
                    <td align="right">48</td>
                    <td align="right">98</td>
                    <td></td>
                    <td align="left">%</td>
                </tr>  
                <tr>
                    <td align="left">Na</td>
                    <td align="right">138</td>
                    <td align="right">146</td>
                    <td></td>
                    <td align="left">mmo l/L</td>
                </tr> 
                <tr>
                    <td align="left">K</td>
                    <td align="right">3.5</td>
                    <td align="right">4.9</td>
                    <td></td>
                    <td align="left">mmo l/L</td>
                </tr> 
                <tr>
                    <td align="left">iCa</td>
                    <td align="right">1.12</td>
                    <td align="right">1.32</td>
                    <td></td>
                    <td align="left">mmo l/L</td>
                </tr> 
                <tr>
                    <td align="left">Hct</td>
                    <td align="right">38</td>
                    <td align="right">51</td>
                    <td></td>
                    <td align="left">%PCV</td>
                </tr> 
                <tr>
                    <td align="left">Hb*</td>
                    <td align="right">12.0</td>
                    <td align="right">17.0</td>
                    <td></td>
                    <td align="left">g/dL</td>
                </tr> 
            </table> 
        </td>
    </tr>  
    <tr><td colspan="3">-----------------------------------</td></tr>
</table> 