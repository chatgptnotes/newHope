
<style>
/*----- Tabs -----*/
.tabs {
	width: 100%;
	display: inline-block;
}

/*----- Tab Links -----*/
/* Clearfix */
.tab-links:after {
	display: block;
	clear: both;
	content: '';
}

.tab-links li {
	margin: 0px 5px;
	float: left;
	list-style: none;
}

.tab-links a {
	padding: 9px 15px;
	display: inline-block;
	border-radius: 3px 3px 0px 0px;
	background: #7FB5DA;
	font-size: 16px;
	font-weight: 600;
	color: #4c4c4c;
	transition: all linear 0.15s;
}

.tab-links a:hover {
	background: #a7cce5;
	text-decoration: none;
}

li.active a, li.active a:hover {
	background: #fff;
	color: #4c4c4c;
}

/*----- Content of Tabs -----*/
.tab-content {
	padding: 15px;
	border-radius: 3px;
	box-shadow: -1px 1px 1px rgba(0, 0, 0, 0.15);
	background: #fff;
}

.tab {
	display: none;
}

.tab.active {
	display: block;
}
</style>

<div class="inner_title">
	<h3>
		<?php echo __('Service Request Search', true); ?>
	</h3>
</div>

<div class="tabs">
	<!-- Navigation header -->
	<ul class="tab-links">
	    	<?php
						
						$count = 1;
						foreach ( $results as $result ) {
							if ($count == 1) {
								$class = "active";
							} else {
								$class = "";
							}
							?>
	        
	        <li class="<?php echo $class; ?>"><a
			href="#tab<?php echo $count;?>">
	        		<?php echo $result['LaboratoryHistopathology']['attribute']; //for displaying the tab or attribute?>	
	        	</a></li>
	   		<?php
							
							$count = $count + 1;
						}
						?> 
	    </ul>
	<!-- Navigation header End -->
 	
 	
 	
	<?php echo $this->Form->create('',array('id'=>'Save-Form'));?>
 	 <div class="tab-content">
        <?php
								
								$count = 1;
								foreach ( $results as $result ) {
									?>
	    	<?php if($count==1) { $class = "active"; } else { $class = "";} ?>
        	<?php $id = $result['LaboratoryHistopathology']['id'];?>
	        <div id="tab<?php echo $count;?>"
			class="tab <?php echo $class; ?>">
	        	<?php echo $this->Form->hidden('LaboratoryHistopathology.laboratory_id',array('id'=>'laboratory_id','type'=>'text','value'=>$this->params->pass[0]));?>
	        	<?php echo $this->Form->textarea('', array('name'=>"data[LaboratoryHistopathology][$id]",'class' => 'ckeditor','value'=>$result['LaboratoryHistopathology']['description']));	?> 
	        </div>
	    	<?php $count = $count+1; } ?>
	 </div>
		 <?php echo $this->Form->end();?>
 </div>


<div class="clr ht5"></div>
<table align="center">
	<tr>
		<td>
			<?php
			echo $this->Html->link ( __ ( 'Save' ), 'javascript:void(0)', array (
					'id' => 'save',
					'escape' => false,
					'class' => 'blueBtn' 
			) ) . "&nbsp";
			echo $this->Html->link ( __ ( 'Preview' ), 'javascript:void(0)', array (
					'escape' => false,
					'class' => 'blueBtn',
					'id' => 'save' 
			) ) . "&nbsp";
			echo $this->Html->link ( __ ( 'Back' ), 'javascript:void(0)', array (
					'id' => 'print',
					'escape' => false,
					'class' => 'blueBtn' 
			) ) . "&nbsp";
			echo $this->Html->link ( __ ( 'Print' ), 'javascript:void(0)', array (
					'escape' => false,
					'class' => 'blueBtn' 
			) ) . "&nbsp";
			echo $this->Html->link ( __ ( 'Download Files' ), 'javascript:void(0)', array (
					'escape' => false,
					'class' => 'blueBtn' 
			) );
			?>	
		</td>
	</tr>
</table>

<div class="clr ht5"></div>




<script>
	jQuery(document).ready(function() {
	    jQuery('.tabs .tab-links a').on('click', function(e)  {
	        var currentAttrValue = jQuery(this).attr('href');
	        
	        // Show/Hide Tabs
	        jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
	 
	        // Change/remove current tab to active
	        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
	        e.preventDefault();
	    });
	});

	$("#save").click(function(){
		$("#Save-Form").submit();
	});
</script>