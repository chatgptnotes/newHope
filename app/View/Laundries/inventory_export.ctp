<?php
    /**
     * Export all member records in .xls format
     * with the help of the xlsHelper
     */

	//input the export file name
	
	
	$xls->setHeader('LaundryItem_'.date('Y_m_d'));
	
    $xls->addXmlHeader();
    $xls->setWorkSheetName('LaundryItem');
    
    //1st row for columns name
    $xls->openRow();
    $xls->writeString('id');
    $xls->writeString('item_code');
    $xls->writeString('name');
    //$xls->writeString('NumberField4');
    $xls->closeRow();
    
    //rows for data
    foreach ($models as $model):
    	$xls->openRow();
	    $xls->writeNumber($model['LaundryItem']['id']);
	    $xls->writeString($model['LaundryItem']['item_code']);
	    $xls->writeString($model['LaundryItem']['name']);
	    //$xls->writeNumber($model['Model']['number_field_4']);
	    $xls->closeRow();
    endforeach;
   
    $xls->addXmlFooter();
    exit();
?> 
