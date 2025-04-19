<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style>
.panel_resizable {
	border: 2px solid #f28c38;
	margin: 0;
	overflow: hidden !important;
}
 
.violetBtn {
    border-bottom: 1px solid white !important;
    list-style: outside none none;
    margin: 0 !important;
    padding-top: 5px !important;
    width: 133px;
}
 
ul{ 
	margin:0px;padding:0px !important;
}

h3{ 
	padding:0px;
	margin: 0px;
}

 
#tab_css > ul > li.active > a::after, #tab_css > ul > li:hover > a::after, #tab_css > ul > li > a:hover::after {
    background: #ac47ed !important;
}

#tab_css {
    border-bottom: 3px solid #ac47ed !important;
} 
</style>
</head>  
<body>
<?php 
	echo $this->Html->css('tab_menu') ; 
	?>
		<table width="100%" border="0">
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Photo</h3>
						</legend> 
						<table width="100%" border="0">
							<tr>
								<td width="100%" valign="top">
									<div style="float: none !important;" id="tab_css"> 
										<ul  > 
											<li class="active" > <a href="#">Intra Op Photo</a></li>
											<li  ><a href="#">On Bed Photo</a></li>
											<li  ><a href="#">On Discharge Photo</a></li>
											<li  ><a href="#">Clinical Photo</a></li>
											<li  ><a href="#">Discharge On Bed Photo</a></li>
											<li  ><a href="#">Scar Photo</a></li>
										</ul>
									</div> 
									<table width="100%" border="0" class="table_format">
										<thead>
											<tr>
												<th>Sub Category</th>
												<th>Browse Photo</th>
												<th>Description</th>
												<th>Action</th>
											</tr>
										</thead> 
										<tr>
											<?php 
												echo $this->Form->create('doc',array('id'=>'upload_rgjay','inputDefaults'=>array('label'=>false,'div'=>false)));
											?>
											<td valign="top"> 
												<?php 
													$subsubarray = array('Incision','Identification of Surgery Parts','Critical Steps in Surgery','Suture line') ;
													echo $this->Form->input('sub-sub-cat',array('options'=>$subsubarray));
												?>
										 	</td>
										 	<td><?php echo $this->Form->input('browse',array('type'=>'file'))?></td>
										 	<td><?php echo $this->Form->input('description',array('type'=>'text' ,'class'=>'textBoxExpnd'))?></td>
										 	<td><?php echo $this->Form->image('saveRec',array('style'=>'border:0px !important;background:none !important;','alt'=>'Upload Record','class'=>'uploadForm','src'=>'../img/icons/saveBig.png')) ;?></td>
										 	 
										</tr> 
									</table>
								</td> 
							</tr>
						</table> 
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Investigation</h3>
						</legend> 
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>ID Proof</h3>
						</legend> 
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<fieldset style="width: 95%; height: 200%;" class="panel_resizable"
						id="panel_resizable_1_0">
						<legend style="color: #0099CC">
							<h3>Notes</h3>
						</legend> 
					</fieldset>
				</td>
		</table>
	</form>

<script>
$(".row").click(function(){
    var currentID = $(this).attr('id').split("_")[1]; 
    var div = document.getElementById("section_"+currentID);   
    if (div.style.display !== 'none') { 
        $("#row_"+currentID).addClass('active'); 
    }  else {
        $(".row").removeClass('active'); 
        $(".section").hide();
        $("#row_"+currentID).addClass('active'); 
    }
    $("#section_"+currentID).fadeToggle('slow');  
});

//upload image and save other details.
 $(document).ready(function (e) {
	$("#upload_rgjay").on('submit',(function(e) {
		e.preventDefault(); 
		//var form = $('#upload_rgjay').serialize();  
		//var form = $('form')[0]; // You need to use standart javascript object here
		var formData = new FormData(this);

		 
		$.ajax({
        	url: "<?php echo $this->Html->url(array('controller'=>"patientDocuments",'action'=>'docup'))?>",
			type: "POST",
			data:  formData,
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
				$("#targetLayer").html(data);
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
}); 
</script>
