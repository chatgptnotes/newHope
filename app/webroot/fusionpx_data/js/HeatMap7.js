var dataString ='<chart Caption="Rating of ice cream flavors by brands" bgColor="ED73AC, F7BFC8" bgAngle="315" baseFontColor="333333" showValues="1">\n\
        <rows>\n\
            <row id="Chocolate"/>\n\
            <row id="Vanilla"/>\n\
            <row id="Strawberry"/>\n\
            <row id="Butter Pecan"/>\n\
            <row id="Pistachio"/>\n\
        </rows>\n\
        <columns>\n\
               <column id="Baskin-Robbins" />\n\
               <column id="Blue Bunny" />\n\
               <column id="Turkey Hill" />\n\
               <column id="Carvel" />\n\
               <column id="Breyers" />\n\
        </columns>\n\
    <dataset>\n\
		<set rowId="Chocolate" columnId="Baskin-Robbins" showValue="0" value="3"/>\n\
		<set rowId="Chocolate" columnId="Blue Bunny" showValue="0" value="4"/>\n\
		<set rowId="Chocolate" columnId="Turkey Hill" value="5" displayValue="OUR PICK!!!"/>\n\
		<set rowId="Chocolate" columnId="Carvel" showValue="0" value="4"/>\n\
		<set rowId="Chocolate" columnId="Breyers" showValue="0" value="3"/>\n\
		<set rowId="Vanilla" columnId="Baskin-Robbins" showValue="0" value="3"/>\n\
		<set rowId="Vanilla" columnId="Blue Bunny" showValue="0" value="3"/>\n\
		<set rowId="Vanilla" columnId="Turkey Hill" showValue="0" value="2"/>\n\
		<set rowId="Vanilla" columnId="Carvel" showValue="0" value="2"/>\n\
		<set rowId="Vanilla" columnId="Breyers" showValue="0" value="4"/>\n\
		<set rowId="Strawberry" columnId="Baskin-Robbins" showValue="0" value="4"/>\n\
		<set rowId="Strawberry" columnId="Blue Bunny" showValue="0" value="3"/>\n\
		<set rowId="Strawberry" columnId="Turkey Hill" showValue="0" value="3"/>\n\
		<set rowId="Strawberry" columnId="Carvel" showValue="0" value="4"/>\n\
		<set rowId="Strawberry" columnId="Breyers" showValue="0" value="4"/>\n\
		<set rowId="Butter Pecan" columnId="Baskin-Robbins" showValue="0" value="2"/>\n\
		<set rowId="Butter Pecan" columnId="Blue Bunny" showValue="0" value="3"/>\n\
		<set rowId="Butter Pecan" columnId="Turkey Hill" showValue="0" value="3"/>\n\
		<set rowId="Butter Pecan" columnId="Carvel" showValue="0" value="4"/>\n\
		<set rowId="Butter Pecan" columnId="Breyers" showValue="0" value="3"/>\n\
		<set rowId="Pistachio" columnId="Baskin-Robbins" showValue="0" value="3"/>\n\
		<set rowId="Pistachio" columnId="Blue Bunny" showValue="0" value="4"/>\n\
		<set rowId="Pistachio" columnId="Turkey Hill" showValue="0" value="3"/>\n\
		<set rowId="Pistachio" columnId="Carvel" showValue="0" value="3"/>\n\
		<set rowId="Pistachio" columnId="Breyers" showValue="0" value="2"/>\n\
   </dataset>\n\
	<colorRange gradient="0">\n\
        <color minValue="0" maxValue="3" code="C3D9EE" label="Nothing great"/>\n\
        <color minValue="3" maxValue="4" code="FBF59D" label="Ok, can try"/>\n\
        <color minValue="4" maxValue="5" code="C8DC6B" label="Yummy, must have"/>\n\
     </colorRange>\n\
	<styles>\n\
	    <definition>\n\
	        <style name="DataValueStyle" type="font" color="FFFFFF" bold="1" size="12"/>\n\
	        <style name="CaptionStyle" type="font" color="CE0355" bold="1"/>\n\
	    </definition>\n\
	    <application>\n\
	        <apply toObject="DataValues" styles="DataValueStyle" />\n\
	        <apply toObject="Caption" styles="CaptionStyle" />\n\
	    </application>\n\
	</styles>\n\
</chart>';