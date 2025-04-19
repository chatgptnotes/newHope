<style>
    .pay-wrapper{
        box-sizing: border-box; 
        font-family: "trebuchet MS","Lucida sans",Arial;
        font-weight: 300;
    }
    .head{
        font-size: 25px;
        font-weight: bold;
    }
    .styBold{
        font-size: 16px;
        font-weight: bold;
    }
</style>

<?php if(!empty($returnArray)){  ?>
<table width="100%" class="pay-wrapper" style="background-color: #EFF5F7; outline: 1px solid; padding: 25px; margin-top:5px " border="0" cellspacing="0">
    <?php foreach ($returnArray as $key => $val) { ?>
    <tbody>
        <tr>
            <td class="alignLeft head"><?php echo date("F",  strtotime($this->params['pass'][0])).__(' 2016 Payroll'); ?></td>
            <td colspan="2" class="alignRight"><i><?php echo __('Payroll process on ').$this->DateFormat->formatDate2Local($val['SalaryPayroll']['create_time'],Configure::read('date_format'),true); ?></i> 
            <?php echo $this->Html->link(__('Delete Process'),'javascript:void(0);',array('payroll_id'=>$val['SalaryPayroll']['id'],'month'=>$this->params['pass'][0],'class'=>'blueBtn deletePayroll','escape'=>false,'div'=>false,'label'=>false)); ?></td>
        </tr>
        <tr><td class="alignLeft" colspan="3"><i><?php echo __('Cutoff from ').date("d M Y",strtotime($val['SalaryPayroll']['from_date']))." to ".date("d M Y",strtotime($val['SalaryPayroll']['to_date'])); ?></i></td></tr>
        <tr><td class="alignLeft" colspan="3"><hr></td></tr>
        <tr><td class="alignLeft" colspan="3">&nbsp;</td></tr>
        <tr>
            <td class="alignLeft"><?php echo __('Net Payout'); ?></td>
            <td class="alignLeft"><?php echo __('Employees'); ?></td>
        </tr>
        <?php $netPay = ($val[1]['total_earning'] + $val[2]['total_earning']); ?>
        <?php $netDeduction = ($val[1]['total_deduction'] + $val[2]['total_deduction']); ?>
        <?php $netEmployee = ($val[1]['total_employee'] + $val[2]['total_employee']); ?>
        <tr>
            <td class="alignLeft styBold" valign="top"><?php echo $this->Number->currency($netPay); ?></td>
            <td class="alignLeft styBold"><?php echo $netEmployee; ?></td>
        </tr>
        <tr><td class="alignLeft" colspan="3">&nbsp;</td></tr>
        <tr>
            <td class="alignLeft">
                <table width="100%">
                    <tr>
                        <td><?php echo __('Gross Pay'); ?></td>
                        <td><?php echo $this->Number->currency($netPay + $netDeduction); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('Deduction'); ?></td>
                        <td><?php echo $this->Number->currency($netDeduction*-1); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('Works Days'); ?></td>
                        <td><?php echo $this->DateFormat->getNoOfDays($val['SalaryPayroll']['from_date'],$val['SalaryPayroll']['to_date']); ?></td>
                    </tr>
                </table>
            </td>
            <td class="alignLeft" valign="top">
                <table width="100%">
                    <tr>
                        <td><?php echo __('Bank Transfer'); ?></td>
                        <td><?php echo $this->Number->currency($val[1]['total_earning']); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo __('Cash'); ?></td>
                        <td><?php echo $this->Number->currency($val[2]['total_earning']); ?></td>
                    </tr> 
                </table>
            </td> 
            <td></td>
        </tr>
        <tr><td class="alignLeft" colspan="3">&nbsp;</td></tr>
        <tr><td class="alignLeft" colspan="3">&nbsp;</td></tr>
    </tbody>
    <?php } ?>
</table>


<?php } else { ?>
<table width="100%" class="pay-wrapper" style="background-color: #EFF5F7; outline: 1px solid; padding: 25px; margin-top:5px " border="0" cellspacing="0">
    <tr>
        <td colspan="3" class="alignLeft head"><?php echo date("F",  strtotime($this->params['pass'][0])).__(' 2016 Payroll'); ?></td>
    </tr>
    <tr><td class="alignLeft" colspan="3"><hr></td></tr>
    <tr><td class="alignLeft" colspan="3">&nbsp;</td></tr>
    <tr>
        <td colspan="3"> 
            <?php $firstDate = date('Y-m-'.Configure::read('payrollFromDate'), strtotime('-1 month', strtotime($this->params['pass'][0])));
                $lastDate = date('Y-m-'.Configure::read('payrollToDate'), strtotime($this->params['pass'][0])); ?>
            <?php echo $this->Form->create('',array('id'=>'payRollForm')); ?>
            <table>
                <tr>
                    <td>
                        <i><?php echo __("Payroll process from <font style='font-weight:bold;'>").date("d M Y",strtotime($firstDate))."</strong> to <strong>".date("d M Y",strtotime($lastDate))."</strong>"; ?></i>
                    </td>
<!--                    <td style="text-align:right"><?php echo __('From Date : '); ?></td>
                    <td><?php echo $this->Form->input('',array('type'=>'text','name'=>'from_date','class'=>'textBoxExpnd','id'=>'from_date','div'=>false,'label'=>false)); ?></td>
                 
                    <td style="text-align:right"><?php echo __('To Date : '); ?></td>
                    <td><?php echo $this->Form->input('',array('type'=>'text','name'=>'to_date','class'=>'textBoxExpnd datePick','id'=>'to_date','div'=>false,'label'=>false)); ?></td>
                 -->
                    <?php //if(date("Y-m-d",strtotime($lastDate)) < date("Y-m-d")){ ?>
                    <td align="center"><?php echo $this->Form->submit(__('Process Payroll'),array('div'=>false,'label'=>false,'id'=>'processPayroll','class'=>'blueBtn','month'=>$this->params['pass'][0])); ?></td>
                    <?php /*} else {?>
                    <td align="center"><?php echo $this->Html->link(__('Process Payroll'),'javascript:void(0);',array('div'=>false,'label'=>false,'class'=>'grayBtn','id'=>'unProcessPAyroll')); ?></td>
                   <?php  } */?>
                </tr> 
            </table>
            <?php echo $this->Form->end(); ?>
        </td>
    </tr>
</table>
<?php } ?> 

<script>
   
    $("#from_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1990', 
        maxDate: new Date(),
        dateFormat:'dd/mm/yy' 
    }); 
    
    $("#to_date").datepicker({
        showOn: "both",
        buttonImage: "<?php echo $this->Html->url('/img/js_calendar/calendar.gif'); ?>",
        buttonImageOnly: true,
        changeMonth: true,
        changeYear: true,
        yearRange: '1990',
        maxDate: new Date(),
        dateFormat:'dd/mm/yy' 
    }); 
</script>