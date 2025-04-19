<html>
<head>
<?php echo $this->Html->css(array('jquery.treeview.css',));?>
<style>
	 .body{
	 	background:#fff ;
	 }
	  
	#fancybox-outer{
		background:none;
	}
	
	.row20px tr td {
	    border-bottom: 1px solid #DDDDDD;
	    border-left-color: #FFFFFF !important;
	    border-left-width: 0 !important;
	    border-right: 1px solid #DDDDDD;
	    border-style: solid;
	    border-top-color: #FFFFFF !important;
	    border-top-width: 0 !important;
	  /*  padding-top: 2px !important; */
	    color:none;
	    font-size: 12px;
	}
	
	.container{
		color: #000000;
	    height: 19px;
	   
	    width:50px;
	}
	
	.tree-menu{
		background:#cccccc;
		color:#000000;
		min-width:200px;
	}
	
	.obj{
		overflow-x:scroll;
		
		min-height:260px;
		background:#ffffff;
		max-width:1177px;
	}
	
	.sub-cat{
		cursor:pointer;
	}
	
	.gray-container{
		background: #cccccc; 
		color: #000; 
		text-align: center;
		padding:2px;
	}
	
	.treesubmenu{
		background:#88ADAD;
		color:#000000;
		min-width:200px;
	}
	
	.time-area{
		width:50px;
	}
	
</style>
</head>
<body>
<?php
	echo $this->Html->script(array('jquery-1.9.1.js'));
	echo $this->Html->script(array('jquery.treeview','jquery.blockUI'));
	
	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	 
?> 

<?php echo $this->Form->create('nursings',array('url'=>array('action'=>"save_customization",$patient_id) ,'inputDefault'=>array('div'=>false,'label'=>false))); //ajax submission?>
	<table>
		<tr>
			<td>
				<div id="treecontrol">
					<a title="Collapse the entire tree below" href="#"> Collapse All</a>
					<a title="Expand the entire tree below" href="#"> Expand All</a>
				</div>
			</td>
			<td><?php echo $this->Form->submit();?></td>
		</tr>
	</table>
	<ul id="tree" class="filetree treeview">
		
		<?php  foreach($data as $key => $value){ ?>
		<li>
			<table>
				<tr>
					<td style="width:316px;">
						<span class="folder main-cat" id="<?php echo $value['ReviewSubCategory']['id'];?>"><?php echo $value['ReviewSubCategory']['name']; ?></span>
					</td>
					<td>
							<?php
								$className = clean(strtolower($value['ReviewSubCategory']['name']))."_".$value['ReviewSubCategory']['id'] ;
								
								if($customiztionData[$className]==0 && $customiztionData[$className] != ''){
									$checked = '' ;
								}else{ 
									$checked = 'checked' ;
								}
							 	echo $this->Form->input($className,
									array('class'=>"group-check",'id'=>$className,'autocomplete'=>'off',
										'checked'=>$checked,'type'=>'checkbox','label'=>false,'div'=>false,'error'=>false))?>
					</td>
				</tr>
			</table> 
			<ul>
				<?php 
				if(!empty($value['ReviewSubCategoriesOption'])){
					foreach($value['ReviewSubCategoriesOption'] as $subKey => $subValue) { ?>
					<li>
						<table>
							<tr>
								<td style="width:300px">
									<span id="<?php echo $subValue['id'];?>" class="sub-cat"><?php echo $subValue['name']; ?></span>
								</td>
								<td>
									<?php 
										$optionName  = strtolower(clean($subValue['name'])."_".$subValue['id']) ; 
										
										if($customiztionData[$optionName]==0 && $customiztionData[$optionName] != ''){
											$checkedOption = '' ;
										}else{
											$checkedOption = 'checked' ;
										}
										
										echo $this->Form->input($optionName,
											array('class'=>$className,'checked'=>$checkedOption,'autocomplete'=>'off',
											'type'=>'checkbox','label'=>false,'div'=>false,'error'=>false))?>
								</td>
							</tr>
						</table>
					 <?php }
			}else{ ?>
				<li>&nbsp;</li>
				<?php } ?>
			</ul>
		</li>
		<?php } ?>
	
	</ul><?php $this->Form->end(); ?>
<script> 
	$(document).ready(function(){ 
		
		$("#tree").treeview({
			toggle: function() {
				//console.log("%s was toggled.", $(this).find(">span").text());
			}, 
			control: "#treecontrol", 
		});

		$(".group-check").change(function(){
			status = $(this).is(":checked")
			id=$(this).attr('id');
			 
			if(status == "false" ){ 
				//checked
				$("."+id).each(function( index ) { 
					$(this).attr('checked',false);
				});
			}else{ 
				//not checked
				
				$("."+id).each(function( index ) {  
					$( this ).prop( 'checked', true )
				});
			}
		}); 
	});
</script>
</body>
</html>

