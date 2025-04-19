<?php   $basicPay = $salaryDetails['Earning']['Basic']['day_amount'];
        $totalWorkingDays = $attendanceDetail['worksDetail']['total_working_days'];
        $totalHeWorksDays = $attendanceDetail['worksDetail']['total_works_days'];
        $totalLateMoreThan15Min = $attendanceDetail['worksDetail']['total_late'];
        
        if(count($totalLateMoreThan15Min)>=2){
            //deduct grace leave of two days
            $totalLate = count($totalLateMoreThan15Min) - 2;
            if($totalLate > 0){
                $totalLateDay = $totalLate/4;   //deduct 1/4th per day 
            }
        }
        
        $paidHoliday = count($holidays);
        $casualLeave = $totalWorkingDays - ($totalHeWorksDays + $totalLeaveTaken + $paidHoliday); 
        $totalDays = ($totalHeWorksDays + $paidHoliday + $totalLeaveTaken) - $totalLateDay;
        $perDayCost = $basicPay / $totalWorkingDays ; 
        $calculatedBasic = round(($totalDays * $perDayCost),2); 
?>

<div align="center">
    <h2>
        <?php echo __("LIFESPRING HOSPITALS PRIVATE LTD"); ?>
    </h2>
</div>
<div>
    <h4>
        <?php echo __("Payslip for the month of ").date("F-Y",strtotime($salaryStatementData['SalaryStatement']['to_date']));?>
    </h4>
</div>
<hr>
<table align="center" width="100%" class="" border="0" cellspacing="5" cellpadding="2"> 
    <tr>
        <td align="left" width="20%"><?php echo __("Emp Code"); ?></td>
        <td align="left" width="20%"><?php echo ": "; ?></td>
        <td align="left" width="20%"></td> 
        <td align="left" width="20%"></td>
    </tr>
    <tr>
        <td align="left"><?php echo __("Name"); ?></td>
        <td align="left"><?php echo ": ". $salaryStatementData['0']['full_name']; ?></td>
        <td align="left"><?php echo __("Designation"); ?></td> 
        <td align="left"><?php echo ": ".$salaryStatementData['Role']['name']; ?></td>
    </tr>
    <tr>
        <td align="left"><?php echo __("Branch"); ?></td>
        <td align="left"><?php echo ": ".$salaryStatementData['Location']['name'];  ?></td>
        <td align="left"><?php echo __("Total Days"); ?></td> 
        <td align="left"><?php echo ": ".$this->DateFormat->getNoOfDays($salaryStatementData['SalaryStatement']['from_date'],$salaryStatementData['SalaryStatement']['to_date']); ?></td>
    </tr> 
    <tr>
        <td align="left"><?php echo __("PFAccNo"); ?></td>
        <td align="left"><?php echo ": ";  ?></td>
        <td align="left"><?php echo __("Paid Days"); ?></td> 
        <td align="left"><?php echo ": ".($salaryStatementData['SalaryStatement']['total_shifts'] + $salaryStatementData['SalaryStatement']['total_leaves']); ?></td>
    </tr> 
</table>

<hr>

<table align="center" width="100%" class="" border="0" cellspacing="5" cellpadding="2">
    <tr style="font-weight:bold;">
        <td align="left" width="20%"><?php echo __("Earnings"); ?></td>
        <td align="right" width="20%"><?php echo __("Amount"); ?></td>
        <td  width="10%"></td>
        <td align="left" width="20%"><?php echo __("Deductions"); ?></td> 
        <td align="right" width="20%"><?php echo __("Amount"); ?></td>
        <td  width="10%"></td>
    </tr> 
    <tr>
        <td colspan="2" valign="top">
            <table width="100%">
<!--                <tr>
                    <td align="left"><?php echo __('Basic Pay'); ?></td>
                    <td align="right"><?php $totalEarning += $calculatedBasic; echo number_format($calculatedBasic,2); ?></td>
                </tr>-->
                <?php foreach($results['1'] as $key => $val) {  ?> 
                <tr>
                    <td align="left"><?php echo $val['EarningDeduction']['name']; ?></td>
                    <td align="right"><?php $totalEarning += $val['SalaryStatementDetail']['amount']; echo number_format($val['SalaryStatementDetail']['amount'],2); ?></td> 
                </tr>
                <?php 
                } ?>
            </table>
        </td> 
        <td></td>
        <td colspan="2" valign="top">
            <table width="100%">
                <?php foreach($results['2'] as $key => $val) { ?> 
                <tr> 
                    <td align="left"><?php echo $val['EarningDeduction']['name']; ?></td> 
                    <td align="right"><?php $deduction = $val['SalaryStatementDetail']['amount'];
                            $totalDeduction += $deduction; echo number_format($deduction,2); ?></td>
                </tr>
                <?php } ?>
            </table>
        </td> 
        <td></td>
    </tr> 

    <tr style="font-weight:bold;">
        <td align="left"><?php echo __('Gross Earning'); ?></td>
        <td align="right"><?php echo number_format($totalEarning,2); ?></td>
        <td></td>
        <td align="left"><?php echo __('Gross Deduction'); ?></td>
        <td align="right"><?php echo number_format($totalDeduction,2); ?></td>
        <td></td>
    </tr>

    <tr>
        <td align="left"><?php echo __('Net Amount'); ?></td>
        <td align="right"><b><?php echo number_format(($totalEarning - $totalDeduction),2); ?></b></td>
        <td colspan="4"></td> 
    </tr>
    <tr>
        <td align="left" colspan="6"><?php echo __('Net Pay in words : ').$this->RupeesToWords->no_to_words(round($totalEarning - $totalDeduction)); ?></td> 
    </tr>
</table>  

<hr>

<table align="right" style="margin-right:5%" width="40%">
    
    <tr style="font-weight:bold;">
        <td></td>
        <?php foreach($leaveData['Opening'] as $key => $val){ ?>
        <td style="text-align: right"><?php echo $key; ?></td> 
        <?php } ?>
    </tr>
    <?php foreach($leaveData as $key => $val){ ?>
    <tr>
        <td style="text-align: right"><?php echo $key; ?></td>
        <?php foreach($val as $sKey => $sVal){ ?>
            <td style="text-align: right"><?php echo !empty($sVal) ? $sVal : '0'; ?></td>
        <?php } ?>
    </tr>
    <?php } ?> 
</table>

<div style="clear:both; padding-top:30px;">
    <?php echo __("This is Computer generated payslip and does not require signature"); ?>
</div>