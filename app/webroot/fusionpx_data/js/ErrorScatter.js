var dataString ='<chart  caption="Blood Pressure" xAxisName="Time" showValues="0" divLineAlpha="100" numVDivLines="4" vDivLineAlpha="0" showAlternateVGridColor="1" alternateVGridAlpha="7"  legendBgColor="1B1B1B" canvasBgColor="1B1B1B" bgColor="1B1B1B" baseFontColor="ffffff" toolTipBgColor="1B1B1B" showAlternateHGridColor="0" divLineIsDashed="1" divLineColor="#fff" halfVerticalErrorBar="0" verticalErrorBarColor="#fff"  >\n\
  <categories>\n\
    <category label="07" x="0" />\n\
    <category label="08" x="20" />\n\
    <category label="09" x="40" />\n\
    <category label="10" x="60" />\n\
    <category label="11" x="80" />\n\
    <category label="12" x="100" />\n\
  </categories>\n\
  <dataset seriesName="Blood Pressure" color="ffffff" anchorRadius="3" anchorsides="13" anchorBgColor="#0000FF" anchorBorderThickness="2" >\n\
    <set y="11" x="10" errorValue="11.78"/>\n\
    <set y="9" x="35" errorValue="12.81"/>\n\
    <set y="4" x="50" errorValue="14.68"/>\n\
    <set y="13" x="70" errorValue="13.86"/>\n\
    <set y="14" x="55" errorValue="16.79"/>\n\
    <set y="3" x="65" errorValue="12.87"/>\n\
    <set y="17" x="85" errorValue="13.7"/>\n\
    <set y="15" x="15" errorValue="23.82"/>\n\
  </dataset>\n\
  <styles>\n\
    <definition>\n\
		<style name="myAnchorAnim" type="animation" param="_y" start="0" duration="2"/>\n\
		<style name="myErrorAnim" type="animation" param="_yScale" start="0" duration="3" />\n\
	</definition>\n\
	<application>\n\
		<apply toObject="ANCHORS" styles="myAnchorAnim"/>\n\
		<apply toObject="ERRORBARS" styles="myErrorAnim"/>\n\
	</application>\n\
  </styles>\n\
</chart>';

