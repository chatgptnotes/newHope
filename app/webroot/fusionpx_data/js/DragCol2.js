var dataString ='<chart palette="1" caption="Revenue / Profit Simulation Chart" subcaption="Drag the top edge of columns to simulate revenue and profit." showvalues="0" xAxisName="Quarter" yAxisName="Dollars" formAction="DataHandler.html" numberPrefix="$" formatNumberScale="1">\n\
<categories>\n\
<category name="Quarter 1"/>\n\
<category name="Quarter 2"/>\n\
<category name="Quarter 3"/>\n\
<category name="Quarter 4"/>\n\
</categories>\n\
<dataset id="R" seriesName="Revenue" allowNegativeDrag="0">\n\
<set id="R1" value="3554800"/>\n\
<set id="R2" value="3014800"/>\n\
<set id="R3" value="2737200"/>\n\
<set id="R4" value="3540700"/>\n\
</dataset>\n\
<dataset id="P" seriesName="Profit">\n\
<set id="P1" value="870000"/>\n\
<set id="P2" value="-419400"/>\n\
<set id="P3" value="452600"/>\n\
<set id="P4" value="717300" allowNegativeDrag="0"/>\n\
</dataset>\n\
<trendlines>\n\
<line startValue="2800000" endValue="3500000" color="009900" displayValue="Target" isTrendZone="1" alpha="10" valueOnRight="1"/>\n\
</trendlines>\n\
<styles>\n\
<definition>\n\
<style name="myCaptionFont" type="font" font="Arial" size="14" bold="1"/>\n\
<style name="mySubCaptionFont" type="font" font="Arial" size="10" bold="0"/>\n\
</definition>\n\
<application>\n\
<apply toObject="Caption" styles="myCaptionFont"/>\n\
<apply toObject="SubCaption" styles="mySubCaptionFont"/>\n\
</application>\n\
</styles>\n\
</chart>';