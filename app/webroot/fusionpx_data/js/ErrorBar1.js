var dataString ='<chart caption="Employee Tenure" xAxisName="Position" yAxisName="Years" halfErrorBar="1" showvalues="0" bgalpha="50" bgcolor="A0CAD5" numdivlines="4"   canvasborderthickness="1" canvasbordercolor="DDDDFF" alternatehgridcolor="CFCFCF" alternatehgridalpha="20" alternatevgridcolor="E2C7CB" divlinealpha="0" bordercolor="3F3F3F" borderalpha="20" canvasborderalpha="50"  outcnvbasefontcolor="3F3F3F"  canvasbgcolor="FFFFFF"  showshadow="1" showplotborder="0" errorbarcolor="000000" errorbarthickness="2" >\n\
  <categories>\n\
    <category label="Pilots"/>\n\
    <category label="Flight Attendants"/>\n\
    <category label="Maintenance Personnel"/>\n\
    <category label="Sales Personnel"/>\n\
    <category label="Reservation and Ticketing Personnel"/>\n\
    <category label="Others"/>\n\
  </categories>\n\
  <dataset>\n\
    <set value="15" color="DE6B6B" errorValue="1.5"/>\n\
    <set value="9" color="A8A8A8" errorValue="1"/>\n\
    <set value="15" color="DACA03" errorValue="1.5"/>\n\
    <set value="20" color="75A733" errorValue="2"/>\n\
    <set value="17" color="0093C7" errorValue="2.5"/>\n\
    <set value="13" color="E4A798" errorValue="1"/>\n\
  </dataset>\n\
  <styles>\n\
    <definition>\n\
      <style name="Font_0" type="font" font="Calibri" size="17" bold="1" Italic="0" underline="0" bgcolor="D0E5EA" bordercolor="D0E5EA" isHTML="0"/>\n\
      <style name="Font_1" type="font" font="Calibri" bold="1" size="15" Italic="0" underline="0" bgcolor="D0E5EA" bordercolor="D0E5EA" isHTML="0"/>\n\
	  <style name="myErrorAnim" type="animation" param="_yScale" start="0" duration="1"/>\n\
    </definition>\n\
    <application>\n\
      <apply toObject="CAPTION" styles="Font_0"/>\n\
      <apply toObject="YAXISNAME" styles="Font_1"/>\n\
      <apply toObject="XAXISNAME" styles="Font_1"/>\n\
	  <apply toObject="ERRORBARS" styles="myErrorAnim"/>\n\
    </application>\n\
  </styles>\n\
</chart>';