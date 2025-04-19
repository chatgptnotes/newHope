<?php	echo $this->Html->css(array( 'jquery.treeview.css')); 
 	  	echo $this->Html->script(array('jquery.min.js?ver=3.3','jquery-ui-1.8.5.custom.min.js?ver=3.3')); 
 		echo $this->Html->script(array('jquery.treeview','jquery.treeview.async.js','jquery.blockUI'));
?>
<table  style="width:100%;height:100%;background:#cccccc;" >
					<tr>
						<td valign="top">
							<ul id="category" class="filetree treeview-famfamfam">
								<?php 
									foreach($categoryData as $key => $value){
								?>
										<li>
											<span class="folder"><?php echo $value['ReviewCategory']['name']; ?></span>
											<ul class="mixed" >
												<?php 
													if(!empty($value['ReviewSubCategory'])){
														foreach($value['ReviewSubCategory'] as $subKey => $subValue) {
													?>
															<li class="hasChildren" id="<?php echo $subValue['id'];?>">
																<span id="<?php echo $subValue['id'];?>" class="sub-cat"><?php echo $subValue['name']; ?></span>
																<span><?php echo $this->Html->image('icons/cross.png',array('title'=>'Remove','alt'=>'Remove','class'=>'remove-sub-category','id'=>$subValue['id']));?></span>
																<ul><li><span class="placeholder">&nbsp;</span></li></ul>
															</li>
													<?php 
														}
													}else{
												?>
												<li>&nbsp;</li>
												<?php } ?>
											</ul>
										 
								<?php  	} 	?> 		
							</ul>
							<span id="addCat" type="main">							 
								<button >Add!</button>
							</span> 		
						</td>		
						<td valign="top">
							<div id="formCategory" style="display:none;">
								<?php 
									echo $this->Form->create('nursings',array('action'=>'category_save','id'=>'category-form','inputDefaults'=>array('label'=>false,'div'=>false)));
									echo $this->Form->input('CategoryType',array('autoComplete'=>'off','type'=>'select','id'=>'category-type' ,
											'options'=>array('main'=>'Main Category','sub'=>'Sub Category','option'=>'Sub Category Options')));
								?>
								<div id="catDiv" style="display:none">
									<?php 	
										echo "Main Category";
										echo $this->Form->input('review_category_id',array('type'=>'select','id'=>'category-main','autoComplete'=>'off',
											'options'=>$mainCategories,'empty'=>'Please Select'));
									?>
								</div>
								<div id="paramsDiv" style="display:none;">
									<?php 	
										echo "Select Type";
										echo $this->Form->input('parameter',array('type'=>'select','id'=>'parameter','autoComplete'=>'off',
											'options'=>array('intake'=>'Intake','output'=>'Output')));
									?>
								</div>
								<div id="subDiv"  style="display:none">
										<?php 	
										echo "Sub Category";
										echo $this->Form->input('review_subcategory_id',array('type'=>'select','id'=>'category-sub',
												'options'=>array($subCategory)));
									?>
								</div> 
								<?php  
									echo "Name" ;
									echo $this->Form->input('name',array('type'=>'text')); 
									//echo $this->Form->input('type',array('type'=>'text','id'=>'catType'));
									
								?> 
								<div id="options-val" style="display:none">
									<a href="#" id="addScnt">Add Option Values</a> 
									<div id="p_scents">
									    <p>
									         
									    </p>
									</div>
								</div> 
							<?php 
								echo $this->Form->submit('Save',array('id'=>'save','class'=>'blueBtn','div'=>false));
								echo $this->Form->button('Cancel',array('type'=>'button','id'=>'cancel','class'=>'grayBtn','div'=>false));
								echo $this->Form->end();
							?>
							</div>	
						</td>				 					
					</tr>
				</table>
				
<script>
$(document).ready(function(){
	$("#category").treeview({
		toggle: function() {
			//console.log("%s was toggled.", $(this).find(">span").text());
		},
		animated:"slow",
		collapsed: true,
		unique: true,		
		 
	});

	$(".remove-cat").live('click' ,function(){
		$.ajax({
			  beforeSend: function(){
				  loading(); // loading screen
			  },
		      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "delete_category_options", "admin" => false)); ?>"+"/"+$(this).attr('id'),
		      context: document.body,
		      success: function(data){ 
		    	    onCompleteRequest(); //remove loading sreen
		    	  	alert(data); 
		    	  	$(this).closest('li').remove();
			  },
			  error:function(){
					alert("Please try again") ;
					onCompleteRequest(); //remove loading sreen
			  }
		});
	});

	$(".remove-sub-category").click(function(){
		$.ajax({
			  beforeSend: function(){
				  loading(); // loading screen
			  },
		      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "delete_sub_category", "admin" => false)); ?>"+"/"+$(this).attr('id'),
		      context: document.body,
		      success: function(data){ 
		    	    onCompleteRequest(); //remove loading sreen 
		    	  	$(this).parents('li').first().remove();
		    	  	alert(data); 
			  },
			  error:function(){
					alert("Please try again") ;
					onCompleteRequest(); //remove loading sreen
			  }
		});
	});
	
	$(".mixed").treeview({
		toggle: function() {
		//	alert($(this).attr('id')) ;
		},
		url:"<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getChildrens", "admin" => false)); ?>",
		// add some additional, dynamic data and request with POST
		ajax: {
			data: {
				"additional": function() {
					return "yeah: " + new Date;
				},
				'id':$(this).attr('id')
			},
			type: "post"
		},
		collapsed: true,
		unique: true,	
	});

	$("#addCat").click(function(){
		$("#save").removeAttr('disabled');
		$("#formCategory").fadeIn("slow");
		$("#addCat").toggle(); 
		$("#catType").val($(this).attr("type"));
	});

	$("#cancel").click(function(){
		//$("#category-form").reset();
		 
		$(':input','#category-form') 
		 .val('')
		 .removeAttr('checked')
		 .removeAttr('selected'); //reset complete form 
		$("#addCat").toggle();	
		$("#formCategory").toggle();
		$("#catType").val();
	});

	$("#category-main").change(function(){
		//ajax request for main category
		type= $(this).val();		 
		$("#catDiv").fadeIn('slow');
		
		myText = "Intake And Output" ;
		var str = '' ;
		var selectedOpt ='' ;
		 $( "#category-main option:selected" ).each(function() {
			 str  = $( this ).text()  ;
		});
		 
		if(str=='Intake And Output' && $("#category-type").val() != 'option'){
			$("#paramsDiv").fadeIn('slow'); 
		}else{ 
			$("#paramsDiv").fadeOut('fast');
		}
		if($("#category-type").val()=="option"){
			$("#options-val").fadeIn('slow');
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
			      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getCategories", "admin" => false)); ?>"+"/"+$(this).val(),
			      context: document.body,
			      success: function(data){ 
			    	    onCompleteRequest(); //remove loading sreen
			    	  	data= $.parseJSON(data);
					  	if(data !=''){
					  		$("#category-sub option").remove();
					  		$("#save").removeAttr('disabled');
						  	$.each(data, function(val, text) {
							  	if(text)
							    $("#category-sub").append( "<option value='"+val+"'>"+text+"</option>" );
							}); 
					  	}else{  
					  		$("#category-sub option").remove();
					  		$("#save").attr('disabled','disabled');
						  	alert("Data not available");
					  	} 
				  },
				  error:function(){
						alert("Please try again") ;
						onCompleteRequest(); //remove loading sreen
				  }
			});
		}else{
			$("#options-val").fadeOut('slow');
		}
	});

	$("#category-main").change(function(){
		//ajax request for sub category
	});

	$("#category-type").change(function(){
		//ajax request for main category
		type = $(this).val();
		$("#save").removeAttr('disabled'); 
		$("#category-main").val("");
		$("#category-sub").val("");
		if(type=='sub'){
			$("#catDiv").show();
			$("#subDiv").hide();
		}else if(type=='option'){
			$("#subDiv").show();
			$("#catDiv").show();
		}else{
			$("#subDiv").hide();
			$("#catDiv").hide();
		}
	});

	function loading(){
		  
		 $('#formCategory').block({ 
	        message: '<h1><img src="../../theme/Black/img/icons/ajax-loader_dashboard.gif" /> Please wait...</h1>', 
	        css: {            
	            padding: '5px 0px 5px 18px',
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#fffff', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px',               
	            color: '#fff',
	            'text-align':'left' 
	        },
	        overlayCSS: { backgroundColor: '#000000' } 
	    }); 
	}

	function onCompleteRequest(){
		$('#formCategory').unblock(); 
	}

	//add more for options values
	var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
        
        $('#addScnt').live('click', function() {
                $('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="data[nursings][values][]" value="" placeholder="Option Value" /></label> <?php echo $this->Html->image('icons/cross.png',array('alt'=>'Remove','title'=>'Remove','id'=>'remScnt','style'=>'cursor:pointer;')); ?></p>').appendTo(scntDiv);
                i++;
                return false;
        });
        
        $('#remScnt').live('click', function() { 
                if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                }
                return false;
        });
	//EOF options value
});

</script>