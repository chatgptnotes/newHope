<style>#report1{ font-weight: bold;}
.links {
		padding: 5px !important;
	}
	</style>
<?php 
$selectedAction = $this->params->action;
$$selectedAction = 'report1' ;
?>
<div class=" nav_link" ><!-- style="padding-bottom: 219px;" -->
     <div class="links" id="<?php echo $current_stock ;?>">
    	 <?php    
	        echo $this->Html->link('Current Stock',array('controller'=>'Reports','action'=>'current_stock'),
			array('escape'=>false,'class'=>$current_stock)) ;
		?>
     </div>
    
    <div class="links" id="<?php echo $stock_register ;?>">
    	 <?php    
	        echo $this->Html->link('Stock Register',array('controller'=>'Reports','action'=>'stock_register'),
			array('escape'=>false,'class'=>$stock_register)) ;
		?>
     </div>
     
     <div class="links" id="<?php echo $daily_sales_collection ;?>">
       <?php    
	        echo $this->Html->link('Daily Sales Collection',array('controller'=>'Reports','action'=>'daily_sales_collection'),
			array('escape'=>false,'class'=>$daily_sales_collection)) ;
		?>
     </div>
      <div class="links" id="<?php echo $non_movable_stock ;?>">
       <?php    
	        echo $this->Html->link('Non Movable Stock',array('controller'=>'Reports','action'=>'non_movable_stock'),
			array('escape'=>false,'class'=>$non_movable_stock)) ;
		?>
     </div>
      <div class="links" id="<?php echo $department_request ;?>">
       <?php    
	        echo $this->Html->link('Department Request',array('controller'=>'Reports','action'=>'department_request'),
			array('escape'=>false,'class'=>$department_request)) ;
		?>
     </div>
       <div class="links" id="<?php echo $indent_cost_report ;?>">
       <?php    
	        echo $this->Html->link('Indent Cost Report',array('controller'=>'Reports','action'=>'indent_cost_report'),
			array('escape'=>false,'class'=>$indent_cost_report)) ;
		?>
     </div>
  	  <div class="links" id="<?php echo $drug_sale_report ;?>">
       <?php    
	        echo $this->Html->link('Drug Sale Report',array('controller'=>'Reports','action'=>'drug_sale_report'),
			array('escape'=>false,'class'=>$drug_sale_report)) ;
		?>
     </div>
       <div class="links" id="<?php echo $purchase_analysis ;?>">
       <?php    
	        echo $this->Html->link('Purchase Analysis',array('controller'=>'Reports','action'=>'purchase_analysis'),
			array('escape'=>false,'class'=>$purchase_analysis)) ;
		?>
     </div>
     <div class="links" id="<?php echo $expiry_date ;?>">
       <?php    
	        echo $this->Html->link('Expiry Date Report',array('controller'=>'Reports','action'=>'expiry_date'),
			array('escape'=>false,'class'=>$expiry_date)) ;
		?>
     </div>
     <div class="links" id="<?php echo $expensive_product_report ;?>">
       <?php    
	        echo $this->Html->link('Expensive Products',array('controller'=>'Reports','action'=>'expensive_product_report'),
			array('escape'=>false,'class'=>$expensive_product_report)) ;
		?>
     </div> 
     <div class="links" id="<?php echo $openingClosingStock ;?>">
       <?php    
	        echo $this->Html->link('Opening Closing Stock',array('controller'=>'Reports','action'=>'openingClosingStock'),
			array('escape'=>false,'class'=>$openingClosingStock)) ;
		?>
     </div> 
    
    
 </div>