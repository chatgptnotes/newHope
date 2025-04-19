<style>
.a{
 color:palevioletred;
text-align: center;

}

</style>
<table width="100%">
	<tr>
		<td class="a"><h2>Today's Message </h2></td>
	</tr>
	  <?php   foreach ($message as $key => $prev) { 
	  		$todaydate=$prev['CeoMessage']['msg_date'];	
			if($date==$todaydate){  ?>
			
			 <tr>
				<td><b><?php echo strip_tags($prev['CeoMessage']['message']);?></b></td>	
				
			</tr>

		<?php } } ?>
</table>

<?php if($date!=$todaydate) { ?>
<script type="text/javascript">
	$(document).ready(function(){ 
		parent.$.fancybox.close();
	});
</script>
<?php } ?>