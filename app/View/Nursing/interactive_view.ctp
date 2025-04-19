<?php echo $this->Html->script(array('jquery.treeview','jquery.fancybox-1.3.4','jquery.blockUI','inline_msg.js','jquery.contextMenu','jquery.scrollTo.min'));
	  echo $this->Html->css(array('jquery.treeview.css','jquery.fancybox-1.3.4.css','jquery.contextMenu'));   
	   
?> 
<style>
	.row20px tr td {
	    border-bottom: 1px solid #DDDDDD;
	    border-left-color: #FFFFFF;
	    border-left-width: 0;
	    border-right: 1px solid #DDDDDD;
	    border-style: solid;
	    border-top-color: #FFFFFF ;
	    border-top-width: 0 ;
	    border-color:#4C5E64 ; 
	    color:none;
	    font-size: 12px;
	}
	select {
    color: white !important;
     background: -moz-linear-gradient(center top , #252C2F, #252C2F) repeat scroll 0 0 rgba(0, 0, 0, 0) !important;
   }
	.container{
	    /*height: 19px;*/
	    width:50px;
	}
	
	.tree-menu{
		background:#252C2F;
		color:#fff;
		min-width:200px;
	}
	
	.obj{
		overflow-x:scroll; 
		min-height:260px;
		background:#252C2F;
		max-width:1177px;
		max-height:700px;
		
	}
	
	.parent-obj1{
		min-height:260px;
		background:#252C2F;
		max-width:1177px;
		max-height:700px;
		overflow-x:scroll; 
	}
	
	.sub-cat{
		cursor:pointer;
	}
	
	.gray-container{
		background: #252C2F; 
		color: #fff; 
		text-align: center;
		padding:2px;
	}
	
	.treesubmenu{
		background:#a1b6bd;
		color:#fff;
		min-width:200px;
	}
	
	.time-area{
		width:50px;
	}
	
	
	
	#time-slot a {
		
	}
	 
	 #loginBox {
	    position:absolute;
	    top:34px;
	    right:0;
	    /*display:none;*/
	    height:0px;
	    z-index:29;
	    overflow:hidden;
	    background : #cccccc;
	    width:200px;
	}
	#loginBox ul{list-style:none;color:black;cursor:pointer;}
	#loginBox ul li:hover {background:#99CCFF; border:1px solid #00FFFF;}
	.two_img img{float:inherit;} 
	.excel-format{margin-bottom:10px;border-right: 1px solid #000000;}
	.treeview ul {  background-color: #252c2f;   margin-top: 0px; }
	.hasSelect{padding:0px;width:51px;}
	.custom-li{padding:0px;}
	/*.border{ border-style:none;}
	.size50{ border-style:none !important;  width: 50px;text-align:center;}*/
	.size50{ width: 50px;}
	.cell-color{color:#FF00FF ;}
	.custom-li{padding:0px;}
	.filetree li{padding: 0 0 0 16px;}
	.save-data{background-color: #CCCCCC;opacity: 0.5;}
	.save-data-enable{background-color: none;opacity: 1}
	.to-save-td{
		 
		border-bottom: 1px solid #DDDDDD !important;
	    border-left-color: #FFFFFF !important;
	    border-left-width: 0;
	    border-right: 1px solid #DDDDDD !important;
	    border-style: solid;
	    border-top-color: #FFFFFF !important;
	    border-top-width: 0 ;
	    border-color: #9e787e !important; 
	} 
	
	div:focus{
		border-style: solid;
		 border-color: #9ecaed !important;
    	 box-shadow: 0 0 10px #9ecaed; 
	}
	 
</style>
<?php 
function clean($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>
<div class="patient_info">
	<?php echo $this->element('patient_information');?>
</div> 
<?php if($flags != 'initialAssessment'){?>
<!-- <div class="clr" align="right" style="margin-bottom:10px;"><?php $backBtnUrl =  array('controller'=>'PatientsTrackReports','action'=>'sbar',$patient_id);
echo $this->Html->link(__('Back to Clinical Summry'),$backBtnUrl,array('class'=>'blueBtn','div'=>false));?></div> -->
<?php }?>
<?php echo $this->Form->hidden('form_received_on',array('id'=>'form_received_on','value'=>$this->General->minDate($patient['Patient']['form_received_on']))); 
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="treeDivArea">
	<tbody>
		<tr>
			<td valign="top" class="tree-menu">
				<table>
					<tr>
						<td>
							<ul id="browser" class="filetree treeview-famfamfam">
								<?php 
									$o= 0;
									foreach($categoryData as $key => $value){
										if($o==0) $classOpen = 'open' ;
										else $classOpen ='' ;
								?>
										<li class="<?php echo $classOpen ;?>">
											<span class="folder main-cat" id="<?php echo $value['ReviewCategory']['id'];?>"><?php echo $value['ReviewCategory']['name']; ?></span>
											<ul>
												<?php 
													if(!empty($value['ReviewSubCategory'])){
														foreach($value['ReviewSubCategory'] as $subKey => $subValue) {
													?>
															<li><span name="<?php echo clean($subValue['name']); ?>" id="<?php echo $subValue['review_category_id'];?>" class="sub-cat"><?php echo $subValue['name']; ?></span>
													<?php 
														}
													}else{
												?>
												<li>&nbsp;</li>
												<?php } ?>
											</ul>
										</li>
								<?php  	$o++; } 	?> 		
							</ul>							 
							<!--  <button id="add">Add!</button>  -->
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" style="width:80%;">
				 
				<div class="obj" id="excelArea">
					<!-- Excel layout -->
			    </div>
			 </td>
		</tr>
    </tbody>
</table>
<div style="margin-top:50px;"><!-- To scroll contains of div due to overlapping it wont work --></div>
<!-- For commetn box -->
<div id="flag-comment-div" style="display:none;" >
	<div id="flag-comment" class="flag-area"
		style="height: 200px; width: 350px; background-color: rgb(204, 204, 204); text-align: center; padding: 10px; border-radius: 6px;">
		<span style="float: right;"> <?php 
		echo $this->Html->link($this->Html->image('icons/cross.png',array("title"=>"Remove","style"=>"cursor: pointer;" ,"alt"=>"Remove")),
							"#close",array("onclick"=>"onCompleteRequest();",'escape'=>false));
				?>
		</span>
		<p style="color: #000; font-weight: bold;">Comment</p>
		
		<?php  
			echo $this->Form->input('flag_comment_text',array( 'div'=>false,'label'=>false,'type'=>'textarea','div'=>false,'class'=>"textBoxExpnd flag-text",'id'=>'flag_comment_text'));
		?>
		<div class="clr">&nbsp;</div>
		<?php  	echo $this->Html->link('Save','#',array('style'=>'padding-top:5px;','class'=>'blueBtn','div'=>false,'label'=>false, 'div'=>false,'id'=>'save-flag-comment'));
		?>
		 
	</div>
</div>	


<input id="flag-comment-div-temp" type="hidden">

<script>

	var lastid = '' ; //maintain previous clicke checkbox			
	weight = '';
	height = '';								
	function editable()
	{
		var divid = document.getElementById('name');
		divid.innerHTML = '';
	}
    
	$(document).ready(function(){  

		 //BOF scrolling
		/*function goToByScroll(id){		   
		      // Scroll
		      alert($("#"+id).offset().top);
		    $('#excelArea').animate({  scrollTop: $("#"+id).offset().top},'slow');
		}*/

		$(".sub-cat").click(function(e) { 
		    //Prevent a page reload when a link is pressed
		   // e.preventDefault(); 
		    // Call the scroll function
		    //goToByScroll($(this).attr('name')); 
		      
		    $('#excelArea').scrollTo('#'+$(this).attr('name'),{duration:'slow',offsetTop:$('#excelArea').offset().top});       
		});

		
		$.fn.scrollTo = function( target, options, callback ){
			  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
			  var settings = $.extend({
			    scrollTarget  : target,
			    offsetTop     : 50, //Y- axis of scrolling element
			    duration      : 500,
			    easing        : 'swing'
			  }, options);
			  return this.each(function(){
			    var scrollPane = $(this);
			    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
			    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop); 
			    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
			      if (typeof callback == 'function') { callback.call(this); }
			    });
			  });
			}

		
		//EOF scrolling
		
		//on load call all the values at once 
		$.ajax({
			  beforeSend: function(){
				  loading(); // loading screen
			  },
		      url: "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getExcelLayout",$patient_id, "admin" => false)); ?>",
		      context: document.body,
		      success: function(data){ 
		    	  onCompleteRequest(); //remove loading sreen
		    	  $("#excelArea").html(data).fadeIn('slow'); 
			  }
		});

		
		$("#browser").treeview({
			toggle: function() {
				//console.log("%s was toggled.", $(this).find(">span").text());
			},
			animated:"slow",
			collapsed: true,
			unique: true,
			
		});
		/*$("#add").click(function() {
			var branches = $("<li><span class='folder'>New Sublist</span><ul>" + 
				"<li><span class='file'>Item1</span></li>" + 
				"<li><span class='file'>Item2</span></li></ul></li>").appendTo("#browser");
			$("#browser").treeview({
				add: branches
			});
		}); */	 
		$(".main-cat").click(function(){
			current_html  = $(this).html();
			  
			if(current_html.trim().toLowerCase()=='intake and output'){
				calling_url = "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getExcelLayoutForIO",$patient_id, "admin" => false)); ?>" ;
			}else{
				calling_url = "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "getExcelLayout",$patient_id, "admin" => false)); ?>" ;
			}
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
			      url: calling_url+"/"+$(this).attr('id'),
			      context: document.body,
			      success: function(data){ 
			    	  onCompleteRequest(); //remove loading sreen
			    	  $("#excelArea").html(data).fadeIn('slow');
				  },
				  error:function(){
						alert('Please try again');
						onCompleteRequest(); //remove loading sreen
					  }
			});
		});
		
		$('#add').click(function(){ 
			$.fancybox({ 
				'width':1000,
				'height':800,
			    'autoScale': true, 
			    'href': "<?php echo $this->Html->url(array("controller" => "nursings", "action" => "add_categories")); ?>",
			    'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	true,
				'onStart'		:   function(){
											loading();
									},
				'onComplete'    :   function(){
										onCompleteRequest();
									},
				'type':'iframe'
				 
		    }); 
		});

		function loading(){
			  
			 $('#main-grid').block({ 
		        message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>', 
		        css: {            
		            padding: '5px 0px 5px 18px',
		            border: 'none', 
		            padding: '15px', 
		            backgroundColor: '#000000', 
		            '-webkit-border-radius': '10px', 
		            '-moz-border-radius': '10px',               
		            color: '#fff',
		            'text-align':'left' 
		        },
		        overlayCSS: { backgroundColor: '#000000' } 
		    }); 
		}

		function onCompleteRequest(){
			$('#main-grid').unblock(); 
			return false ;
		}
		var matched, browser;

		jQuery.uaMatch = function( ua ) {
		    ua = ua.toLowerCase();

		    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
		        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
		        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
		        /(msie) ([\w.]+)/.exec( ua ) ||
		        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
		        [];

		    return {
		        browser: match[ 1 ] || "",
		        version: match[ 2 ] || "0"
		    };
		};

		matched = jQuery.uaMatch( navigator.userAgent );
		browser = {};

		if ( matched.browser ) {
		    browser[ matched.browser ] = true;
		    browser.version = matched.version;
		}

		// Chrome is Webkit, but Webkit is also Safari.
		if ( browser.chrome ) {
		    browser.webkit = true;
		} else if ( browser.webkit ) {
		    browser.safari = true;
		}

		jQuery.browser = browser;


		
	});
	var global_items = {
			"flag": {name: "Flag", icon: "flag"},
			"Unflag": {name: "Unflag", icon: "flag"},
			"flagComment": {name: "Flag With Comment", icon: "flag"},
		    "edit": {
		        name: "Modify",
		        icon: "edit"
		    },
		    "result": {
		        name: "View Result Details",
		        icon: "view"
		    }, 
		    "delete": {
		        name: "UnChart",
		        icon: "delete"
		    },
		    "sep1": "---------",
		    "quit": {
		        name: "Quit",
		        icon: "quit"
		    }};
    var flagCommentID = ''; 
    var flagCellClass = '' ;
    var unchartID = '';
	$(function(){ 
	    $.contextMenu({
	        selector: '.context-menu-one', 
	        callback: function(key, options) {
	            if(key=='flag'){
	            	url = "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "saveReviewAttribute","admin" => false)); ?>" ;
		            $(this).prepend('<?php echo $this->Html->image('icons/flag.png',array('title'=>'flag','class'=>'flag',))?>');
		            
					$.ajax({
						  beforeSend: function(){
							  //loading(); // loading screen
						  },
						  type:'post',
						  data:"id="+$(this).attr('detail-id')+"&field=flag&fieldValue=1",
					      url: url,
					      context: document.body,
					      success: function(data){  
					    	  //nothing to display 
						  },
						  error:function(){							   
								alert("Please try again") ; 
						  }
					}); 
		        }else  if(key=='Unflag'){
	            	url = "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "saveReviewAttribute","admin" => false)); ?>" ;
		            
		            $(this).children(".flag").remove();
					$.ajax({
						  beforeSend: function(){
							  //loading(); // loading screen
						  },
						  type:'post',
						  data:"id="+$(this).attr('detail-id')+"&field=flag&fieldValue=0",
					      url: url,
					      context: document.body,
					      success: function(data){  
					    	  //nothing to display 
						  },
						  error:function(){							   
								alert("Please try again") ; 
						  }
					}); 
		        }else if(key=='delete'){
		        	   option_id =$(this).attr('detail-id'); 
					   unchartID  = $(this).addClass('in-error'+option_id) ; 
					   $.fancybox({ 
							'width' :800,
							'height':600,
						    'autoScale': true, 
						    'href': "<?php echo $this->Html->url(array("controller" => "nursings", "action" => "unchart_result")); ?>/"+option_id,
						    'transitionIn'	:	'elastic',
							'transitionOut'	:	'elastic',
							'speedIn'		:	600, 
							'speedOut'		:	200, 
							'overlayShow'	:	true,
							'onStart'		:   function(){ loading(); },
							'onComplete'    :   function(){ onCompleteRequest();},
						 
							 
					    }); 
			   }else if(key=='flagComment'){
					html1 = $("#flag-comment-div").html() ; 
					$("#flag-comment-div").html(""); //empty container
					$("#flag-comment-div-temp").val(html1); 
					flagCommentID = $(this).attr('detail-id') ;
					flagCellClass = $(this).attr('class').split(' ')[1] ;
					$(this).addClass('temp-flag-comment-class') ;
					
					$('#main-grid').block({ 
						        message: html1, 
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
						        overlayCSS: { backgroundColor: '#cccccc' } 
						    }); 
			   }else if(key=='edit'){ 
					$(this).css('display','block'); 
					$(this).attr('contenteditable',true);
					$(this).addClass('to-save').addClass('modify'+$(this).attr('detail-id')); //add class modify+option to update its new detail id after db insert
					classes = $(this).attr('class');
					$(this).focus();
					timeslot = classes.split(" "); 
					$("#timeslot").val(timeslot[1]);
				 
					//$("."+id).not(".sub-cat-option").addClass('to-save'); 
					$(".save-data").attr('id','save-data') ;
					$(".save-data").removeClass('save-data').addClass('save-data-enable'); 
			   }else if(key=='result'){
				
				   option_id =$(this).prop('id').split("-")[2];
				   classes = $(this).prop('class').split(" ")[1] ;
				   date= classes.split("_")[0];
				   hourslot = classes.split("_")[1];
				    
				   $.fancybox({ 
						'width' :800,
						'height':600,
					    'autoScale': true, 
					    'href': "<?php echo $this->Html->url(array("controller" => "nursings", "action" => "view_result_details",$patient_id)); ?>/"+option_id+"/"+date+"/"+hourslot,
					    'transitionIn'	:	'elastic',
						'transitionOut'	:	'elastic',
						'speedIn'		:	600, 
						'speedOut'		:	200, 
						'overlayShow'	:	true,
						'onStart'		:   function(){ loading(); },
						'onComplete'    :   function(){ onCompleteRequest(); 	},
						'type'          : 'iframe'
						 
				    }); 
			   }
	        },
	        build: function($trigger, e) {
	            // this callback is executed every time the menu is to be shown
	            // its results are destroyed every time the menu is hidden
	            // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
	               
	            var hasFlag = $trigger.find('img').map(function(){
		            	if($(this).hasClass('flag') != '')
                       		return $(this).hasClass('flag');
		            	else
			            	return '' ;                	     
                }).get(); 

	        	 
	            // Deep copy
	            var tempItems = jQuery.extend(true, {}, global_items); 
	            
                $.each( tempItems, function( key, value ) {                      
                    if((hasFlag !='') && (key == 'flag')){
                    	delete tempItems[key] ;  //remove flag option as it is already flagged 
                    }else if(hasFlag == '' && hasFlag !='false' && (key == 'Unflag')){
                    	delete tempItems[key] ;  //remove unflag option
                    }
                });
                
	            return {	                
	                items: tempItems // assign revised options to contextmenu
	            };
	        }
	         
	    });
	    
	    $('.context-menu-one').on('click', function(e){
	        console.log('clicked', this);
	    })
	});

	$(function(){ 

	
		//restrict enter key
		$(document).on('keypress','.to-save',function(evt){		 	 
			 
			var evt = (evt) ? evt : ((event) ? event : null);
			var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
			if ((evt.keyCode == 13))  {  return false;} 
		}); 
		//EOF enter key
		//document.onkeypress = stopRKey; 
		
		$(document).on('click','#save-data',function(){
			 
			subCategory = $("#subCategory").val(); 
			var reviewValues = ""; 
			var items=[] ;
			var args = ''; 
			$('.to-save').each(function(i, obj) {
				current_id =  $(this).attr("id");				 
				splitted_id = current_id.split("-"); 
				if($(this).hasClass("hasSelect")){
					data = $(this).val(); 
				}else{
					data = $(this).html() ;
				} 
				data = data.trim();
				data = data.replace(/(\r\n|\n|\r|\t|&nbsp;)/gm,"");
				if((data != '') &&  (data != 0)) { 
					var item={  
							   id:splitted_id[2].trim(),
				               sub_id: splitted_id[0].trim(),  
				               values:data   
				           };  
				    //Push item object into items array  
				    items.push(item);  
					$(this).removeClass('cell-color'); 
					eleCount   = $(this).attr('detail-id') ;  //collect classs to edit its detail-id for view result
					 
					if($(this).hasClass('modify'+eleCount)){
						args = 'modify=1&' ;
					}else{
						args = 'modify=0&' ;
					}

					 
			    }
				$(this).removeClass('to-save') ;  
				$(this).attr('contenteditable',false);
			});	
		 
			if($("#layout").val()=='actual'){
				args += "format=actual&timeslot="+$("#timeslot").val()+"&categoryid="+subCategory+"&values="+JSON.stringify(items) ;
			}else if($("#backcharting").val()=='yes') {
				args += "backcharting=yes&timeslot="+$("#timeslot").val()+"&categoryid="+subCategory+"&values="+JSON.stringify(items,true);
			}else{
				args += "timeslot="+$("#timeslot").val()+"&categoryid="+subCategory+"&values="+JSON.stringify(items,true);
			}		 

			if($("#layout").val() == "io"){
				url = "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "saveReviewData",$patient_id,"io","admin" => false)); ?>"+"/"+$(this).val() ;
			}else{
				url = "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "saveReviewData",$patient_id,"admin" => false)); ?>"+"/"+$(this).val() ;
			}
			
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen 
				  },
				  type:'post',
				  data:args,
			      url: url, 
			      success: function(data){  
				      //Reset all elements
			    	  	var className = $(this).attr('class');  
						$('.dataCheck').prop('checked', false).hide();
						$(".hasSelect").prop('disabled',true) ;
						//$(".empty-select").css('display','none')	; //all dropdowns
						$(".save-data-enable").addClass('save-data').removeClass('save-data-enable');  
						$(".save-data").attr('id','');   
						//$('.modify'+eleCount).attr('detail-id',data.trim());
						 $("#excelArea").html(data).fadeIn("slow");
					 //EOF reset
					 //for load testing 
					 
					  
					  onCompleteRequest(); //remove loading sreen
					  inlineMsg("icon-div","Record Added Successfully",5);
				  },
				  error:function(){ 
						alert("Please try again") ;
						onCompleteRequest(); //remove loading sreen
				  }
			});
		}); //EOF save function

		function loading(){
			  
			 $('#main-grid').block({ 
				 message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>', 
		        css: {            
		            padding: '5px 0px 5px 18px',
		            border: 'none', 
		            padding: '15px', 
		            backgroundColor: '#000000', 
		            '-webkit-border-radius': '10px', 
		            '-moz-border-radius': '10px',               
		            color: '#fff',
		            'text-align':'left' 
		        },
		        overlayCSS: { backgroundColor: '#000000' } 
		    }); 
		}

		function onCompleteRequest(){
			$('#main-grid').unblock(); 
		}
		
		$(document).on('click','#refresh-data',function(){  
			$.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
				  type:'post', 
			      url: $("#current-url").val(), 
			      success: function(data){ 
			    	  onCompleteRequest(); //remove loading sreen
			    	  $("#excelArea").html(data).fadeIn("slow");
				  },
				  error:function(){  
						alert("Please try again") ;
						onCompleteRequest(); //remove loading sreen
				  }
			});
		});
	 
		//BOF conditional row
		$(document).on('change','.hasSelect',function(){   
			//BOF onfly total
			score_total = $(this).attr('score_total') ;
			if(typeof score_total != "undefined" ){ 
			 	unique_class = $(this).attr('class').split(" ")[1] ; 
				//var inputs = $('option:selected',"."+unique_class);
			    inputs = $("."+unique_class+"[score_total]") ;
			    var total = 0 ;
			    inputs.each(function(){ 
			        //alert($(this).attr('score_total')) ;
			        var score = $('option:selected', this).attr('score'); 
			         
					//total
					prevVal = parseInt(score,10) ;
					if(isNaN(prevVal)==false && score_total==$(this).attr('score_total')){
						total = parseInt(score,10)+total ;
					} 
					$("."+score_total+"."+unique_class).html(total) ; 
					lastClass  = unique_class ; 
			    }); 
			}
			//EOF on flly total
			
			name = $(this).attr('name') ;
			selectedVal = $(this).val();
			if(selectedVal.indexOf("^") < 0)  { 
				if(selectedVal=='' && name != '') {
					$("."+name).fadeOut('slow');
				}
				return ;
			} 
			
			splittedVal = selectedVal.split("^");
			if(splittedVal[1]=='show'){
				$("."+name).fadeIn('slow');
			}else{
				$("."+name).fadeOut('slow');
			}
			
		});
		//EOF conditional row
		 
		//BMI calc
		$(document).on('blur','.bmiEle',function(){
			//BOF onfly total
			 	 
			score_total = $(this).attr('score_total') ;
			if(typeof score_total != "undefined" ){ 
			 
			 	unique_class = $(this).attr('class').split(" ")[1] ; 
				//var inputs = $('option:selected',"."+unique_class);
			    inputs = $("."+unique_class+"[score_total]") ;
			    var total = 0 ;
			    if($(this).attr('bmi')=='weight'){
			    	weight = $(this).html() ;// weight
			    	weight = weight.replace(/(\r\n|\n|\r|\t|&nbsp;)/gm,"");
				}
			    if($(this).attr('bmi')=='height'){
			    	height = $(this).html() ;// weight
			    	height = height.replace(/(\r\n|\n|\r|\t|&nbsp;)/gm,"")/100;
			    	height = height*height ; //converting cm to meter
				} 
				if(weight != '' && height != '') 
			    	BMI = weight/height ; 
				else
					BMI = 0 ;
				 
			    $("."+score_total+'.'+unique_class).html(parseFloat(BMI).toFixed(2)) ; 
			}
			//EOF on flly total
		})
		//EOF BMI calc
		

		//double click 
		$(document).on('dblclick','.doubleClick',function() {
			weight = '';
			height = '';
			id = $(this).attr('id');  
				if(lastid != ''){ 
					$("."+lastid).not("#check_"+lastid).attr('contenteditable',false); // remove contenteditable property already added 
					$(".empty-select").css('display','none'); //hide all select boxes 
					$("."+lastid).removeClass('to-save')	; //remove already added class    
					//highlight selected column 
				 	$("."+lastid).closest( "td" ).removeClass( "to-save-td" ); 
					$('input:checkbox').hide() ;
					$(".hasSelect").attr('disabled',true).removeClass('to-save');
				} 
				
				$(".empty-select").removeClass('to-save');
				$(".save-data").attr('id','save-data') ;
				$(".save-data").removeClass('save-data').addClass('save-data-enable');  
				 
				$("."+id).css('display','block');
				$("select."+id).prop('disabled',false); //for dropdown disabled true
				$("#check_"+id).prop('checked',true); //current checkbox
				$("#back-date-check").prop('checked',true); //for backdated entries in actual layout
				$("."+id).not(".hasSelect,.dataCheck,.sub-cat-option ").attr('contenteditable',true);
				$("."+id).not(".sub-cat-option").addClass('to-save');
 
			 	//highlight selected column 
			 	$( ".to-save" ).closest( "td" ).addClass( "to-save-td" );
			 	
				$("#timeslot").val(id);  
				lastid = id; 
		});



		$(document).on('dblclick','.doubleClickOnChild',function() {
				weight = '';
				height = '';
				id = $(this).attr('id');  
				if(lastid != ''){ 
					$("."+lastid).not("#check_"+lastid).attr('contenteditable',false); // remove contenteditable property already added 
					$(".empty-select").css('display','none'); //hide all select boxes 
					$("."+lastid).removeClass('to-save')	; //remove already added class    
					//highlight selected column 
				 	$("."+lastid).closest( "td" ).removeClass( "to-save-td" ); 
					$('input:checkbox').hide() ;
					$(".hasSelect").attr('disabled',true).removeClass('to-save');
				} 
				
				$(".empty-select").removeClass('to-save');
				$(".save-data").attr('id','save-data') ;
				$(".save-data").removeClass('save-data').addClass('save-data-enable');  
				 
				$("."+id).css('display','block');
				$("select."+id).prop('disabled',false); //for dropdown disabled true
				$("#check_"+id).prop('checked',true); //current checkbox
				$("#back-date-check").prop('checked',true); //for backdated entries in actual layout
				$("."+id).not(".hasSelect,.dataCheck,.sub-cat-option ").attr('contenteditable',true);
				$("."+id).not(".sub-cat-option").addClass('to-save');
				$(".check_"+id).prop('checked',true); //current checkbox
				$(".check_"+id).css('display','block');
			 	//highlight selected column 
			 	$( ".to-save" ).closest( "td" ).addClass( "to-save-td" );
			 	
				$("#timeslot").val(id);  
				lastid = id; 
		});

		
		$(document).on('click','.dataCheck',function() {
			var className = $(this).attr('class').split(" ")[0];  
			 alert(className);
			$(this).prop('checked', false).hide();
			$(".hasSelect").prop('disabled',true) ;
			$(".empty-select").css('display','none')	; //all dropdowns
			$(".save-data-enable").addClass('save-data').removeClass('save-data-enable');  
			$(".save-data").attr('id','');
			$("."+className).not("#check_"+className).attr('contenteditable',false);	
			$("."+className).removeClass('to-save');	
			$("."+className).closest( "td" ).removeClass( "to-save-td" ); 
		});
		//EOF double click

		 $(document).on('click',"#save-flag-comment",function(){
			 url = "<?php echo $this->Html->url(array("controller" => 'nursings', "action" => "saveReviewAttribute","admin" => false)); ?>" ;
			
			 $.ajax({
				  beforeSend: function(){
					  loading(); // loading screen
				  },
				  type:'post',
				  data:"id="+flagCommentID+"&field=flag_comment&fieldValue="+$('#flag_comment_text').val(),//fields separated by *
			      url: url,
			      context: document.body,
			      success: function(data){  
			    	  //nothing to display  
			    	  $('#flag-comment-div').html($('#flag-comment-div-temp').val());
			    	  $('#flag-comment-div-temp').val("");	
			    	  var hasFlag = $('.temp-flag-comment-class').find('img').map(function(){
			            	if($(this).hasClass('flag') != '')
	                       		return $(this).hasClass('flag');
			            	else
				            	return '' ;                	     
	                  }).get(); 
		              
		              if(hasFlag=='')
			    	  $('.temp-flag-comment-class').prepend('<?php echo $this->Html->image('icons/flag.png',array('title'=>'flag','class'=>'flag',))?>');	
			    	  
			    	  $('.'+flagCellClass).removeClass('temp-flag-comment-class');	    	  
			    	  onCompleteRequest(); 
				  },
				  error:function(){							   
						alert("Please try again") ; 
				  }
			}); 
	     }); 


	     
	});

	function loading(){
		  
		 $('#main-grid').block({ 
			 message: '<h1><?php echo $this->Html->image('icons/ajax-loader_dashboard.gif');?> Please wait...</h1>', 
	        css: {            
	            padding: '5px 0px 5px 18px',
	            border: 'none', 
	            padding: '15px', 
	            backgroundColor: '#000000', 
	            '-webkit-border-radius': '10px', 
	            '-moz-border-radius': '10px',               
	            color: '#fff',
	            'text-align':'left' 
	        },
	        overlayCSS: { backgroundColor: '#000000' } 
	    }); 
	}

	function onCompleteRequest(){
		$('#main-grid').unblock(); 
	}


	 
	</script>
	 
	
	
			

