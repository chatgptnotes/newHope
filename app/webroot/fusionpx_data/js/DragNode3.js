var dataString ='<chart bgcolor="FFFFFF" charttopmargin="0" chartleftmargin="0" chartrightmargin="0" bordercolor="FFFFFF" canvasbordercolor="DFBAAD" xAxisMinValue="0" xAxisMaxValue="100" yAxisMinValue="0" yAxisMaxValue="100" bubbleScale="3" is3D="1" numDivLines="0" showFormBtn="0" >\n\
<dataset plotborderAlpha="0" >\n\
<set x="50" y="90" width="120" height="90" color="FFFFFF" name="Mr. Harry Sawyer, CEO" alpha="100" toolText="CEO" id="CEO" imageNode="1" imageurl="Resources/CEO.jpg" imageAlign="bottom" labelAlign="top" imageHeight="65" imageWidth="108" />\n\
<set x="20" y="70" width="120" height="40" name="Name:Tom McQuin {BR}Age: 54yrs {BR}Designation:CTO" color="62D0FE" id="CTO" />\n\
<set x="51" y="70" width="120" height="40" name="Name:Jim Kerry {BR}Age: 46yrs {BR}Designation:CFO" color="62D0FE" link="n-http://www.fusioncharts.com" id="CFO" />\n\
<set x="80" y="70" width="120" height="40" name="Name:Michelle Saler {BR}Age: 58yrs {BR}Designation:COO" color="62D0FE" link="n-http://www.fusioncharts.com" id="COO" />\n\
<set x="12" y="55" width="50" height="40" name="GM1" color="4EC745" link="n-http://www.fusioncharts.com" id="GM1"/>\n\
<set x="27" y="55" width="50" height="40" name="GM2" color="4EC745" link="n-http://www.fusioncharts.com" id="GM2"/>\n\
<set x="43" y="55" width="50" height="40" name="AM1" color="4EC745" link="n-http://www.fusioncharts.com" id="AM1" />\n\
<set x="59" y="55" width="50" height="40" name="AM2" color="4EC745" link="n-http://www.fusioncharts.com" id="AM2" />\n\
<set x="70" y="55" width="50" height="40" name="FO1" color="4EC745" link="n-http://www.fusioncharts.com" id="FO1" />\n\
<set x="90" y="55" width="50" height="40" name="FO2" color="4EC745" link="n-http://www.fusioncharts.com" id="FO2" />\n\
<set x="6"  y="37" width="60" height="40" name="M1"  color="FDE413" link="n-http://www.fusioncharts.com" id="M1"  />\n\
<set x="20" y="37" width="60" height="40" name="M2"  color="FDE413" link="n-http://www.fusioncharts.com" id="M2"  />\n\
<set x="38" y="37" width="60" height="40" name="AC1" color="FDE413" link="n-http://www.fusioncharts.com" id="AC1" />\n\
<set x="52" y="37" width="60" height="40" name="AC2" color="FDE413" link="n-http://www.fusioncharts.com" id="AC2" />\n\
<set x="9"  y="16" shape="circle"  radius="30" name="Team A"  color="F79471" link="n-http://www.fusioncharts.com" id="TMA"/>\n\
<set x="19" y="8" shape="circle"  radius="30" name="Team B"  color="F79471" link="n-http://www.fusioncharts.com" id="TMB"/>\n\
<set x="29" y="16" shape="circle"  radius="30" name="Team C"  color="F79471" link="n-http://www.fusioncharts.com" id="TMC"/>\n\
<set x="75"  y="30" shape="circle"  radius="30" name="Group A"  color="F79471" link="n-http://www.fusioncharts.com" id="GRPA"/>\n\
<set x="83" y="20" shape="circle"  radius="30"  name="Group B"  color="F79471" link="n-http://www.fusioncharts.com" id="GRPB"/>\n\
<set x="93" y="12" shape="circle"  radius="30"  name="Group C"  color="F79471" link="n-http://www.fusioncharts.com" id="GRPC"/>\n\
</dataset>\n\
<connectors color="83C6E1" stdThickness="8">\n\
	<connector strength="0.45" from="CEO" to="CTO"  arrowAtStart="0" arrowAtEnd="0"/>\n\
	<connector strength="0.45" from="CEO" to="CFO"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.45" from="CEO" to="COO"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.45" from="CFO" to="AM1"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.45" from="CFO" to="AM2"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.45" from="CTO" to="GM1"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.45" from="CTO" to="GM2"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.45" from="COO" to="FO1"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.45" from="COO" to="FO2"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.35" from="GM1" to="M1" color="7ED378"  arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.35" from="GM1" to="M2" color="7ED378" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.35" from="AM1" to="AM2" color="7ED378" arrowAtStart="1" arrowAtEnd="1" />\n\
	<connector strength="0.35" from="AM1" to="AC1" color="7ED378" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.35" from="AM1" to="AC2" color="7ED378" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.35" from="AM2" to="AC1" color="7ED378" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.35" from="AC2" to="AC1" color="7ED378" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.35" from="M2" to="TMA" color="D2C12F" arrowAtStart="0" arrowAtEnd="1" />\n\
	<connector strength="0.35" from="M2" to="TMB" color="D2C12F" arrowAtStart="0" arrowAtEnd="1" />\n\
	<connector strength="0.35" from="M2" to="TMC" color="D2C12F" arrowAtStart="0" arrowAtEnd="1" />\n\
	<connector strength="0.25" Label="Field Accountant" from="FO2" to="AC2" color="E57042" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.25" Label="Mining" from="FO2" to="GRPA" color="D2C12F" arrowAtStart="0" arrowAtEnd="1" />\n\
	<connector strength="0.25" Label="Filtering" from="FO2" to="GRPB" color="D2C12F" arrowAtStart="0" arrowAtEnd="1" />\n\
	<connector strength="0.25" Label="Drying" from="FO2" to="GRPC" color="D2C12F" arrowAtStart="0" arrowAtEnd="1" />\n\
</connectors>\n\
	<styles>\n\
		<definition>\n\
		<style name="myHTMLFont" type="font" isHTML="1" />\n\
	</definition>\n\
	<application>\n\
		<apply toObject="DATALABELS" styles="myHTMLFont" />\n\
		<apply toObject="TOOLTIP" styles="myHTMLFont" />\n\
	</application>\n\
	</styles>\n\
</chart>';