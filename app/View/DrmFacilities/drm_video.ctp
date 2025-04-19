<style>
	#myVideo {
		float:left;
		width:1024px;
		height:480px;
		margin:10px;    
		border:1px solid silver;
	}
    ul {
        list-style-type: none;
        padding-left: 15px;
    }
    .gray{
        color: white;
        padding-bottom: 8px;
        font-style: italic;
        font-style: bold;

    }
    .gray:hover{
        background:#3C4852;
        cursor: pointer;
    }
</style>
<div class="inner_title">
		<h3>
			<?php echo __('Our Facilities'); ?>
		</h3>
</div>
<div id="mainContainer" style="text-align:center;margin:5px;">
	<video id="myVideo" controls autoplay ><!-- autoplay -->
        <source src="http://grochtdreis.de/fuer-jsfiddle/video/sintel_trailer-480.mp4" id="mp4Source" type="video/mp4">
</video>
</div>
<div style="background:#293741;width:10%;float:right;margin-top:15px;height:500px;overflow:auto;border:1px solid;margin-right: 80px;">
 <img src="../img/icons/dvd.png" style="padding-left: 5px;padding-top: 2px;" />
    <div style="background:red;padding-top:15px;padding-bottom:5px;text-align:center;color:white;">
        &nbsp;
            <b>Now Playing</b></div> 
    <ul id="playlist" width='100%'>
    	<li class="gray" movieurl="../vedio/Sonu Nigam - Tu Video - Kismat.mp4" moviesposter="../img/Speciality/cardiology.jpg">
            <img src="../img/icons/playDisabled.png" />&nbsp;
                Video One
    	</li>
    	<li class="gray" movieurl="../vedio/Sonu Nigam - Tu Video - Kismat.mp4">
            <img src="../img/icons/playDisabled.png" />&nbsp;
                Video Two
        </li>          
    	
    </ul>  
</div>
<script type='text/javascript'>
$(function() {
    $("#playlist li").on("click", function() {
        $("#myVideo").attr({
            "src": $(this).attr("movieurl"),
            "poster": "",
            "autoplay": "autoplay"
        })
    })
    $("#videoarea").attr({
        "src": $("#playlist li").eq(0).attr("movieurl"),
        "poster": $("#playlist li").eq(0).attr("moviesposter")
    })
});

   var count=0;
   var player=document.getElementById('myVideo');
   var mp4Vid = document.getElementById('mp4Source');
   player.addEventListener('ended',myHandler,false);
   var nxt = [];
   nxt[1]="../vedio/Sonu Nigam - Tu Video - Kismat.mp4";
   nxt[2]="../vedio/Sinbad The Sailor [Full Song] Rock On!!.mp4";
   function myHandler(e)
   {

      if(!e) 
      {
         e = window.event; 
      }
      count++;
      $(mp4Vid).attr('src',nxt[count]);
      player.load();
      player.play();
   }

</script>

