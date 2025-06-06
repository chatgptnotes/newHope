var dataString ='<chart bgcolor="FFFFFF" charttopmargin="0" chartleftmargin="0" chartrightmargin="0" bordercolor="FFFFFF" canvasbordercolor="8D8D8F" xAxisMinValue="0" xAxisMaxValue="100" yAxisMinValue="0" yAxisMaxValue="100" is3D="1" showFormBtn="0" viewMode="1" allowDrag="0" showformbtn="0" >\n\
<dataset plotBorderAlpha="0" allowDrag="0" showformbtn="0" >\n\
<set x="13" y="72" width="110" height="90" name="Desktop" color="FE3233" id="pc1" imageNode="1" imageurl="Resources/desktop.png" labelAlign="top" imageAlign="middle" alpha="0"  imageWidth="107" imageHeight="67" toolText="Name: PC1 &lt;BR&gt;IP: 202.11.32.123 &lt;BR&gt;Owner: Harry Mac"  allowDrag="1"/>\n\
<set x="13" y="27" width="108" height="90" name="Laptop" color="33C1FE" id="pc2" imageNode="1" imageurl="Resources/laptop.png" labelAlign="top" alpha="0"  imageAlign="middle" imageWidth="98" imageHeight="67" toolText="Name: PC2 &lt;BR&gt;IP: 202.11.32.124 &lt;BR&gt;Owner: Jim Terry" allowDrag="1"/>\n\
<set x="24" y="50" radius="34" shape="circle" name="Internet" color="33C1FE" id="internet" allowDrag="1"/>\n\
<set x="49" y="50" width="106" height="64" name="Firewall" color="33C1FE" id="firewall" imageNode="1" imageurl="Resources/firewall.png" labelAlign="middle" alpha="0" imageWidth="106" imageHeight="64" toolText="Name: Firewall &lt;BR&gt;IP: 202.110.00.00 &lt;BR&gt;Owner: Group Network" allowDrag="1"/>\n\
<set x="49" y="74" width="60" height="96" name="Branch Head Office" color="33C1FE" id="BO3"  imageNode="1" imageurl="Resources/server.png" labelAlign="top" alpha="0"  imageWidth="57" imageHeight="70" imageAlign="bottom" allowDrag="1"/>\n\
<set x="39" y="90" width="70" height="86" name="Branch Office 1" color="33C1FE" id="BO1" imageNode="1" imageurl="Resources/terminal.png" alpha="0"  imageWidth="64" imageHeight="65" imageAlign="bottom" labelAlign="top"/>\n\
<set x="59" y="90" width="70" height="86" name="Branch Office 2" color="33C1FE" id="BO2" imageNode="1" imageurl="Resources/terminal.png" alpha="0" imageWidth="64" imageHeight="65" imageAlign="bottom" labelAlign="top"/>\n\
<set x="49" y="89" width="50" height="40" name="Branch Network" color="33C1FE" id="null" alpha="0" />\n\
<set x="49" y="30" width="60" height="86" name="Head Office" color="33C1FE" id="PHO"  imageNode="1" imageurl="Resources/server.png" alpha="0"  imageWidth="57" imageHeight="70" imageAlign="bottom" labelAlign="top" allowDrag="1"/>\n\
<set x="39" y="20" width="70" height="86" name="Branch Office 1" color="33C1FE" id="PN1" imageNode="1" imageurl="Resources/terminal.png" alpha="0"  imageWidth="64" imageHeight="65" imageAlign="bottom" labelAlign="top"/>\n\
<set x="59" y="20" width="80" height="94" name="Branch Office 2" color="33C1FE" id="PN2" imageNode="1" imageurl="Resources/exchange_server.png" alpha="0" imageWidth="79" imageHeight="80" imageAlign="bottom" labelAlign="top"/>\n\
<set x="49" y="8" width="60" height="86" name="Head Office" color="33C1FE" id="PN3"  imageNode="1" imageurl="Resources/server.png" alpha="0"  imageWidth="64" imageHeight="65" imageAlign="top" labelAlign="bottom"/>\n\
<set x="49" y="18" width="55" height="46" name="Perimeter Network" color="33C1FE" id="null3" alpha="0" />\n\
<set x="69" y="60" width="60" height="86" name="Head Office" color="33C1FE" id="CNS"  imageNode="1" imageurl="Resources/server.png" alpha="0"  imageWidth="57" imageHeight="70" imageAlign="bottom" labelAlign="top" allowDrag="1"/>\n\
<set x="83" y="70" width="70" height="86" name="Branch Office 1" color="33C1FE" id="CN1" imageNode="1" imageurl="Resources/terminal.png" alpha="0"  imageWidth="64" imageHeight="65" imageAlign="bottom" labelAlign="top" allowDrag="1"/>\n\
<set x="93" y="60" width="80" height="96" name="Exchange Server" color="33C1FE" id="CN2" imageNode="1" imageurl="Resources/exchange_server.png" alpha="0" imageWidth="79" imageHeight="80" imageAlign="bottom" labelAlign="top" allowDrag="1"/>\n\
<set x="83" y="30" width="70" height="94" name="CRM Server" color="33C1FE" id="CN3"  imageNode="1" imageurl="Resources/server.png" alpha="0"  imageWidth="57" imageHeight="69" imageAlign="top" labelAlign="bottom" allowDrag="1"/>\n\
<set x="69" y="40" width="70" height="90" name="Catalogue Server" color="33C1FE" id="CN4"  imageNode="1" imageurl="Resources/04.png" alpha="0"  imageWidth="65" imageHeight="72" imageAlign="top" labelAlign="bottom" allowDrag="1"/>\n\
<set x="93" y="40" width="60" height="90" name="2003 Server" color="33C1FE" id="CN5"  imageNode="1" imageurl="Resources/05.png" alpha="0"  imageWidth="56" imageHeight="68" imageAlign="top" labelAlign="bottom" allowDrag="1"/>\n\
<set x="82" y="50" width="55" height="46" name="Corporate Network" color="33C1FE" id="null2" alpha="0" />\n\
</dataset>\n\
<connectors color="FF0000" stdThickness="5">\n\
	<connector strength="1" from="pc1" label ="10/100Mbps" to="internet" color="BBBB00" arrowAtStart="0" arrowAtEnd="0"/>\n\
	<connector strength="1" from="pc2" to="internet" label ="10/100Mbps"  color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="1" label="T1 Line" from="internet" to="firewall" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="1" from="BO3" to="firewall" label="Secured" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="BO3" to="BO1" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="BO3" to="BO2" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="1" from="PHO" to="firewall" label="Secured" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="CN1" to="CN2" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="CN5" to="CN2" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="CN5" to="CN3" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="CN4" to="CN3" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="CN4" to="CNS" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
	<connector strength="0.8" from="CN1" to="CNS" color="BBBB00" arrowAtStart="0" arrowAtEnd="0" />\n\
</connectors>\n\
<vTrendlines>\n\
	<line startValue="0" endValue="30" color="CB191D" alpha="10" displayValue="External Network" isTrendZone="1"/>\n\
	<line startValue="30" endValue="70" color="17B546" alpha="15" displayValue="Middleware" isTrendZone="1"/>\n\
	<line startValue="70" endValue="100" color="5875CD" alpha="20" displayValue="Internal Network" isTrendZone="1"/>\n\
</vTrendlines>\n\
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