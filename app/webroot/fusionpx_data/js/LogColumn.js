var dataString='<chart palette="2" caption="Sales Comparison" showValues="0" formatNumberScale="1" anchorRadius="2" numberPrefix="$" decimals="2" showMinorDivLineValues="1" yAxisValuesStep="3" numMinorDivLines="2">\n\
<categories>\n\
<category label="Jan"/>\n\
<category label="Feb"/>\n\
<category label="Mar"/>\n\
<category label="Apr"/>\n\
<category label="May"/>\n\
<category label="Jun"/>\n\
</categories>\n\
<dataset seriesName="Current Year" color="A66EDD" anchorBorderColor="A66EDD" anchorRadius="4">\n\
<set value="1127654"/>\n\
<set value="1226234"/>\n\
<set value="1299456"/>\n\
<set value="1311565"/>\n\
<set value="1324454"/>\n\
<set value="1357654"/>\n\
</dataset>\n\
<dataset seriesName="Previous Year" color="F6BD0F" anchorBorderColor="F6BD0F" anchorRadius="4">\n\
<set value="907654"/>\n\
<set value="1126234"/>\n\
<set value="1299456"/>\n\
<set value="1511565"/>\n\
<set value="1724454"/>\n\
<set value="1157654"/>\n\
</dataset>\n\
<styles>\n\
<definition>\n\
<style name="MyXScaleAnim" type="ANIMATION" duration="0.7" start="0" param="_xScale"/>\n\
<style name="MyYScaleAnim" type="ANIMATION" duration="0.7" start="0" param="_yscale"/>\n\
<style name="MyAlphaAnim" type="ANIMATION" duration="0.7" start="0" param="_alpha"/>\n\
</definition>\n\
<application>\n\
<apply toObject="DIVLINES" styles="MyXScaleAnim,MyAlphaAnim"/>\n\
</application>\n\
</styles>\n\
</chart>';