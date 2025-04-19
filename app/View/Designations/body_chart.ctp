<?php 
	echo $this->Html->script(array('jquery-1.9.1.js'));
?>
<style>
<!--

html, body { 
    font-size: 12px;
    color:#fff; 
    font-family: arial,helvetica,sans-serif;
}


.whereithurts {
    background: url("../img/whereithurtsbg.gif") repeat-x scroll 0 0 #0e5478;
    color: #000000; 
}
.whereithurts table {
    border-collapse: collapse; 
    width: 96%;
}
.whereithurts table td {
    vertical-align: top;
    font-size:12px;
}
.whereithurts textarea {
    width: 100%;
}
.whereithurts .info table td {
    vertical-align: top;
}
.whereithurts .info table td.radio {
    width: 12px;
}
.whereithurts .info .options, .whereithurts .info textarea {
    display: block;
}
.whereithurts .info div {
    display: none;
}
.whereithurts .wh_container {
    position: relative;
}
-->
</style>
  <body class="en">
	<div class="bgtop">
		<div class="bgbottom">  
			<div > 
				<div class="container"><span class="ELEMENT-en-article-index smartsite-element"><div class="article">
	<div class="articlebody">
		 
	 

		<div class="content">
			 
				<div class="articlesection">
					<a name="interact"></a>
					
<p style=" margin: 0px auto;width:900px;color:#000; ">Click on the area of your body where you feel pain, then complete the
 interactive fields and print it out before your doctor's appointment.</p>

<div class="whereithurts" style="position: relative; text-align: center; width: 900px; margin: 0px auto;" >
	<div  id="wh_diagram" style="float:left;">
	<?php 
		echo $this->Html->image('men.jpg',array('class'=>'diagram' ));  
		echo $this->Html->image('pin.gif',array('style'=>'','id'=>"wh_pin",'style'=>'display:none;'));
	?>
	</div>  
    <div style="width:50%;">
        <table class="info">
            <colgroup>
                <col style="width:50%">
                <col style="width:50%">
            </colgroup>
            <tbody><tr><td>What type of pain do you feel here?</td>
                <td><table id="paintype" class="options">
						<tbody><tr><td class="radio"><input checked="checked" name="paintype" value="Burning" type="radio"></td><td>Burning</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Discomfort" type="radio"></td><td>Discomfort</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Dull" type="radio"></td><td>Dull</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Numb" type="radio"></td><td>Numb</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Sharp" type="radio"></td><td>Sharp</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Shooting" type="radio"></td><td>Shooting</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Stabbing" type="radio"></td><td>Stabbing</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Tender" type="radio"></td><td>Tender</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Throbbing" type="radio"></td><td>Throbbing</td></tr>
	                    <tr><td class="radio"><input name="paintype" value="Tingling" type="radio"></td><td>Tingling</td></tr>
					</tbody></table>
                    <div id="paintypeprint"></div>
                </td>
            </tr>
            <tr><td>How severe is the pain you feel?</td>
                <td><table id="painseverity" class="options">
						<tbody><tr><td class="radio"><input checked="checked" name="painseverity" value="1 - Very mild (I can perform all of my daily activities without problems)" type="radio"></td><td>1 - Very mild (I can perform all of my daily activities without problems)</td></tr>
                        <tr><td class="radio"><input name="painseverity" value="2 - Mild (I usually feel it only when I think about it)" type="radio"></td><td>2 - Mild (I usually feel it only when I think about it)</td></tr>
                        <tr><td class="radio"><input name="painseverity" value="3 - Moderate (I cannot perform some of my daily activities)" type="radio"></td><td>3 - Moderate (I cannot perform some of my daily activities)</td></tr>
                        <tr><td class="radio"><input name="painseverity" value="4 - Severe (I cannot perform most of my daily activities)" type="radio"></td><td>4 - Severe (I cannot perform most of my daily activities)</td></tr>
                        <tr><td class="radio"><input name="painseverity" value="5 - Very Severe (I cannot perform any of my daily activities)" type="radio"></td><td>5 - Very Severe (I cannot perform any of my daily activities)</td></tr>
                        <tr><td class="radio"><input name="painseverity" value="6 - Intense/Relentless (The pain is overwhelming and is all that I feel)" type="radio"></td><td>6 - Intense/Relentless (The pain is overwhelming and is all that I feel)</td></tr>
                    </tbody></table>
                    <div id="painseverityprint"></div>
                </td>
            </tr>
            <tr><td>When did the pain start?</td>
                <td><table id="painstart" class="options">
                        <tbody><tr><td class="radio"><input name="painstart" value="In the last 24 hours" type="radio"></td><td>In the last 24 hours</td></tr>
                        <tr><td class="radio"><input name="painstart" value="1-3 days ago" type="radio"></td><td>1-3 days ago</td></tr>
                        <tr><td class="radio"><input name="painstart" value="3-7 days ago" type="radio"></td><td>3-7 days ago</td></tr>
                        <tr><td class="radio"><input name="painstart" value="Over a week ago" type="radio"></td><td>Over a week ago</td></tr>
                    </tbody></table>
                    <div id="painstartprint"></div>
                </td>
            </tr>
            <tr><td>When is the pain at its worst?</td>
                <td><textarea id="painworst"></textarea>
                	<div id="painworstprint"></div>
                </td>
            </tr>
            <tr><td>When is the pain at its mildest?</td>
                <td><textarea id="painmildest"></textarea>
                	<div id="painmildestprint"></div>
                </td>
            </tr>
            <tr><td>If you know, what caused the pain to begin with?</td>
                <td><textarea id="painbegin"></textarea>
                	<div id="painbeginprint"></div>
                </td>
            </tr>
            <tr><td>What makes the pain worse?</td>
                <td><textarea id="makespainworse"></textarea>
                	<div id="makespainworseprint"></div>
                </td>
            </tr>
            <tr><td>What makes the pain better?</td>
                <td><textarea id="makespainbetter"></textarea>
                	<div id="makespainbetterprint"></div>
                </td>
            </tr>
            <tr><td>Has the pain caused other symptoms? <small>(For example, loss of sleep or appetite, fatigue.)</small></td>
                <td><textarea id="painsymptoms"></textarea>
                	<div id="painsymptomsprint"></div>
                </td>
            </tr>
            <tr><td>What have you tried to alleviate the pain? <small>(For example, compresses or over-the-counter medication.)</small></td>
                <td><textarea id="alleviatepain"></textarea>
                	<div id="alleviatepainprint"></div>
                </td>
            </tr>
        </tbody></table>
        </div> 
    <script type="text/javascript">

    var $j = jQuery.noConflict();
 	var k = 0 ; 
    $j(document).ready(function(){
    	$j("#wh_diagram").click(function(e){  
    		var pin = $j("#wh_pin").clone() ; 
			$j("#wh_diagram").append(pin)	 ;
			var xy = $j("#wh_diagram").offset(); 
			pin.css('display','') ;
			pin.css('position',"absolute"); 
			pin.css('left',(e.pageX - xy.left)-7 + "px");
			pin.css('top',(e.pageY - xy.top)-7 + "px"); 
			pin.attr('id','wh-pin'+k);
			pin.addClass('wh-pin');
			pin.bind("click", function() {  
				$j(this).remove(); 
				return false ;
			}) 
			k++; 
		});
    });
     
    </script>
</div>
<br>
<br> 		</div>
				
			
		</div><br>  