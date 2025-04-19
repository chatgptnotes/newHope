<style>
    .block{ 
        outline: 1px solid;
        -moz-outline-radius:10px;
        -webkit-outline-radius:10px;
        outline-radius:10px;
        padding: 5px;
    } 
    .monthTd:hover{
        background-color: white !important;
        color: black !important;
        cursor: pointer;
    } 
    .row_title td.setActive {
        background-color: white !important;
        color: black !important; 
    }
    label{
        float:none;
        margin-right: 0px;
        padding-top: opx;
        width: none;
    } 
</style>
 <?php  echo $this->Html->script(array('jquery.blockUI')); ?>
<div class="inner_title">
    <?php echo $this->element('navigation_menu',array('pageAction'=>'HR')); ?>
<h3>&nbsp; <?php echo __('Payroll Revision', true); ?></h3>
<span>
<?php
 echo $this->Html->link(__('Back', true),array('controller' => 'users', 'action' => 'menu', 'admin' => true, '?' => array('type'=>'master')), array('escape' => false,'class'=>'blueBtn'));
?>
</span>
</div>  

<div id="payRollDetail"></div>
<?php if(!empty($results)){ ?>
<table class="table_format" cellspacing="1">
    <caption><?php echo __('Payroll List'); ?></caption>
    <tr class="row_title">
        <td><?php echo __('Sr.No'); ?></td>
        <td><?php echo __('Cutoff'); ?></td> 
        <td><?php echo __('Total Employee'); ?></td>
        <td><?php echo __('Total Earning'); ?></td>
        <td><?php echo __('Total Deduction'); ?></td>
        <td><?php echo __('Process By'); ?></td>
        <td><?php echo __('Process On'); ?></td>
        <td><?php echo __('Action'); ?></td>
    </tr>
    <?php foreach ($results as $key => $val){ ?>
    <tr>
        <td><?php echo ++$key; ?></td>
        <td><?php echo $this->DateFormat->formatDate2Local($val['SalaryPayroll']['from_date'],Configure::read('date_format'),false)." to ".$this->DateFormat->formatDate2Local($val['SalaryPayroll']['to_date'],Configure::read('date_format'),false); ?></td>
        <td><?php echo $val['0']['total_employee']; ?></td>
        <td><?php echo $this->Number->currency($val['0']['total_earning']); ?></td>
        <td><?php echo $this->Number->currency($val['0']['total_deduction']); ?></td>
        <td><?php echo $val['0']['full_name']; ?></td>
        <td><?php echo $this->DateFormat->formatDate2Local($val['SalaryPayroll']['create_time'],Configure::read('date_format'),true); ?></td>
        <td align="center"><?php echo $this->Html->link($this->Html->image('icons/view-icon.png', array('title' => __('View', true), 'alt' => __('View', true),'style'=>'float:none')),array('action'=>'viewPayroll',$val['SalaryPayroll']['id']),array('escape'=>false,'div'=>false,'label'=>false,'alt'=>'View','title'=>'View')); ?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
