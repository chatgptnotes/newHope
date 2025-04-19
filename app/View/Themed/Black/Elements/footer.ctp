<style>


</style>
<div id="main_fooer">

<!--<marquee style="color:white;font-weight:bold;line-height:30px;" bgcolor='blue' scrollamount="5" behavior="scroll">
	<?php echo implode(", ",$result); ?>
</marquee>-->

<!-- for reorder level -->
<?php if (!empty($reorderProductList)){ ?>
<table width="100%" style="color:white;font-weight:bold;line-height:30px;" bgcolor='blue'>
    <tr>
        <td width="12%">
            <?php echo "Reoder Product List : "; ?>
        </td>
        <td>
            <marquee bgcolor='blue' scrollamount="5" behavior="scroll">
                    <?php echo implode(", ",$reorderProductList); ?>
            </marquee>
        </td>
    </tr>
</table> 
<?php } ?>



<!--<div class="footStrp">&nbsp;</div>
<div class="footer" style="float:left; width:100%"> 
<div class="left_div">
 <div class="left_listing">
  <ul>
    <li>Applicable FARS/DFARS Restrictions Apply to Government Use.</li>
    <li>CPT Copyright 2014 American Medical Association. All rights reserved.</li>
    <li>CPT is a registered trademark of the American Medical Association</li>
   </ul>   
     </div>
     <div class="info">
       <p>Fee schedules, relative value units, conversion factors and/or related components are not assigned by the AMA, are not part of CPT, and the AMA is not recommending their use.The AMA does not directly or indirectly practice medicine or dispense medical services. The AMA assumes no liability for data contained or not contained herein.</p>
     </div>
       
</div>
<table align="right" style="clear:right; display:none;">
<div align="right">

<div class="version_div">
<div class="footer_logo">
<div class="footer_text">
  Powered By
</div>
<?php 

 echo $this->Html->link($this->Html->image('Portal_images/DRMHOPE-LOGO1.png',array('title'=>"DrmHope")),'http://www.drmhope.com',array('target'=>'_blank','escape' => false));
	// echo $this->Html->image('Portal_images/DRMHOPE-LOGO1.png',array('title'=>"DrmHope")) ;
?></div>
<div class="version_txt"> Version 1.0</div>
</div>
 <tr>
         
        	<td><a href="http://www.twitter.com/DrMHope" target="_blank"><?php echo $this->Html->image('twitternw.png'); ?></a></td>
          	<td><a href="http://www.facebook.com/drmhopeCLOUD"  target="_blank"><?php echo $this->Html->image('facebooknw.png'); ?></a></td>
            <td><a href="http://www.linkedin.com/company/drmhope" target="_blank"><?php echo $this->Html->image('linkedinnw.png'); ?></a></td>
            <td><a href="http://www.youtube.com/drmhopedemos" target="_blank"> <?php echo $this->Html->image('youtubenw.png'); ?></a></td>
			<td style="display:none;"><?php echo $this->Html->link($this->Html->image("help-btn.png", array("alt" => "DRM Hope Help", "title" => "DRM Hope Help")),array('controller' => 'pages', 'action' => 'manual'),array('escape' => false)); ?></td>	
            <!-- <td><a href="#"><img src="img/orkut-btn.png" alt="Orkut" /></a></td>
           <!-- <td><a href="#"><img src="img/rss-btn.png" alt="RSS" /></a></td>  -->
          <!--  <td><a href="mailto:info@drmhope.com"><?php echo $this->Html->image('emailnw1.png'); ?></a></td>
          
       </tr>
</table>

	</div>
    <div class="footer-shadow" align="center"></div> -->
</div>
<div class="clear"></div>
<div class="inner_title"></div>
</div>
</div>
		<?php   echo $this->element('sql_dump'); ?>
		</td>
		<td width="2%">&nbsp;</td>
	</tr>
	<tr>
	    	<td>&nbsp;</td>
	       <!-- <td class="footStrp">&nbsp;</td>-->
	        <td>&nbsp;</td>
	</tr>
</table>
<div class="clear"></div>

	
      
</body>

<script>
$('li').not(function(){
	if($.trim(this.innerHTML)==""){
		$(this).remove();
	}

});
$('.interIconLink:not(:has(a))').remove();

$(function(){
//	$(".hasDatepicker").inputmask( 'mm/dd/yyyy' ).removeAttr( "readOnly" );
});

</script>
</html>