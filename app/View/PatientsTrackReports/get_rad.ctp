<?php echo $this->Html->css(array('prettyPhoto.css'));
echo $this->Html->script(array('jquery.prettyPhoto')); ?>
<?php 
				if(!empty($resultRadiology)){?>
<table width="100%" class="formFull formFullBorder">

	<tr style="background-color: grey; height: 10px;">
		<td width=55% style="padding: 5px 0 5px 10px;">Radiology Test Name</td>
		<td width=20% style="padding: 5px 0 5px 10px;">Image Impression</td>
		<td width=25% style="padding: 5px 0 5px 10px;">Action</td>
	</tr>
	<?php 
		foreach($resultRadiology as $key=>$data){
						if($toggle == 0) {
							$objHtml.= "<tr class='row_gray'>";
							$toggle = 1;
						}else{
							$objHtml.= "<tr>";
							$toggle = 0;
						}
						?>
	<td width=30% style="padding: 5px 0 5px 10px;"><?php  echo $data["Radiology"]["name"]?>
	</td>
	<?php if(!empty($data["RadiologyResult"]["img_impression"])){
				if($data["RadiologyResult"]["img_impression"] == 'Positive'){
					$result = 'Within Normal Limits';
				}else{
					$result = 'Abnormal Findings';
				}
		}else{
							$result='Not Published';
						}?>
	<td width=20% style="padding: 5px 0 5px 10px;"><?php echo $result?></td>

	<td width=50% ><?php 
	if($data['RadiologyTestOrder']['id']==$RadiologyResultValues[$key]['RadiologyResult']['radiology_test_order_id']){
								foreach($RadiologyResultValues[$key]['RadiologyReport'] as $filname){
															$b[]='"'.$this->webroot.'uploads/'.'radiology/'.$filname['file_name'].'"';
								}?>
								
								 <a href="#"
		onclick="$.prettyPhoto.open(api_gallery);" return false
		style='text-decoration: none'>&nbsp;&nbsp;<font color="#fff"><?php echo $this->Html->image('pathologyradiologyicons/RADIOLOGY 3 tick.png',array('class'=>"view-large",'title'=>'Radiology Image','alt'=>'Radiology Image'),
				array('escape' => false));?>
		</font>
	</a> <?php 	}else{
					echo $this->Html->image('pathologyradiologyicons/RADIOLOGY 3.png',array('title'=>'Radiology Image','alt'=>'Radiology Image','style'=>'cursor:not-allowed;'), array(), array('escape' => false));
				}?>
		 <?php $b_string=implode(",",$b);?>
	</td>
	</tr>
	<?php }
	?>
</table>
<?php }
?>
<script>
				 function showImage(imgName){
					$.fancybox({
					'width' : '25%',
					'height' : '15%',
					'autoScale' : true,
					'transitionIn' : 'fade',
					'transitionOut' : 'fade',
					'type' : 'iframe',
					'href' : "<?php echo $this->Html->url(array("controller" => "notes", "action" => "showRadImage")); ?>"
					+'/'+imgName,

				});
				}
				 
				</script>
<script type="text/javascript" charset="utf-8">
				var api_gallery = [<?php echo $b_string?>];
	var	api_descriptions=[<?php echo $c_string?>];
	var api_gallery_pt = ["25448564__1338292710__1404393470.jpg"];
</script>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				$("a[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
			</script>
<script type="text/javascript">

			
			(function(){
			  var bsa = document.createElement('script');
			     bsa.type = 'text/javascript';
			     bsa.async = true;
			     //bsa.src = '//s3.buysellads.com/ac/bsa.js';
			  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);


			   $(".view-large").click(function(){
					var items = api_gallery_pt.slice(0); 
					var removedItems = [];
					removedItems.push(items.splice($(this).attr('id') - removedItems.length, 1)[0]);
					items.splice.apply(items, [0, 0].concat(removedItems));
					$.prettyPhoto.open(items,api_descriptions);
					return false ;
				}); 
			});

			$(document).ready(function(){
				$( "#patient-info-acc" ).accordion({
					collapsible: true,
					autoHeight: false,
					clearStyle :true,	 
					navigation: true, 
					active:false
				});
			});
			
</script>
