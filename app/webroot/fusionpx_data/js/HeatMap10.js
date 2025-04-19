var dataString ='<chart Caption="Monthly revenue from different product categories" subCaption="(in million US$)" bgColor="C7E3EF, FFFFFF">\n\
        <rows>\n\
            <row id="Apparels"/>\n\
            <row id="Electronic Goods"/>\n\
            <row id="Household"/>\n\
            <row id="Sports and Fitness"/>\n\
        </rows>\n\
        <columns>\n\
               <column id="Jan" />\n\
               <column id="Feb" />\n\
               <column id="Mar" />\n\
               <column id="Apr" />\n\
               <column id="May" />\n\
               <column id="Jun" />\n\
               <column id="Jul" />\n\
               <column id="Aug" />\n\
               <column id="Sep" />\n\
               <column id="Oct" />\n\
               <column id="Nov" />\n\
               <column id="Dec" />\n\
        </columns>\n\
    <dataset>\n\
		<set rowId="Apparels" columnId="Jan" value="31"/>\n\
		<set rowId="Apparels" columnId="Feb" value="29"/>\n\
		<set rowId="Apparels" columnId="Mar" value="27"/>\n\
		<set rowId="Apparels" columnId="Apr" value="27"/>\n\
		<set rowId="Apparels" columnId="May" value="25"/>\n\
		<set rowId="Apparels" columnId="Jun" value="21"/>\n\
		<set rowId="Apparels" columnId="Jul" value="19"/>\n\
		<set rowId="Apparels" columnId="Aug" value="21"/>\n\
		<set rowId="Apparels" columnId="Sep" value="23"/>\n\
		<set rowId="Apparels" columnId="Oct" value="24"/>\n\
		<set rowId="Apparels" columnId="Nov" value="24"/>\n\
		<set rowId="Apparels" columnId="Dec" value="34"/>\n\
		<set rowId="Electronic Goods" columnId="Jan" value="31"/>\n\
		<set rowId="Electronic Goods" columnId="Feb" value="32"/>\n\
		<set rowId="Electronic Goods" columnId="Mar" value="29"/>\n\
		<set rowId="Electronic Goods" columnId="Apr" value="27"/>\n\
		<set rowId="Electronic Goods" columnId="May" value="35"/>\n\
		<set rowId="Electronic Goods" columnId="Jun" value="36"/>\n\
		<set rowId="Electronic Goods" columnId="Jul" value="36"/>\n\
		<set rowId="Electronic Goods" columnId="Aug" value="38"/>\n\
		<set rowId="Electronic Goods" columnId="Sep" value="35"/>\n\
		<set rowId="Electronic Goods" columnId="Oct" value="34"/>\n\
		<set rowId="Electronic Goods" columnId="Nov" value="36"/>\n\
		<set rowId="Electronic Goods" columnId="Dec" value="42"/>\n\
		<set rowId="Household" columnId="Jan" value="22"/>\n\
		<set rowId="Household" columnId="Feb" value="20"/>\n\
		<set rowId="Household" columnId="Mar" value="29"/>\n\
		<set rowId="Household" columnId="Apr" value="25"/>\n\
		<set rowId="Household" columnId="May" value="25"/>\n\
		<set rowId="Household" columnId="Jun" value="28"/>\n\
		<set rowId="Household" columnId="Jul" value="29"/>\n\
		<set rowId="Household" columnId="Aug" value="37"/>\n\
		<set rowId="Household" columnId="Sep" value="29"/>\n\
		<set rowId="Household" columnId="Oct" value="30"/>\n\
		<set rowId="Household" columnId="Nov" value="26"/>\n\
		<set rowId="Household" columnId="Dec" value="21"/>\n\
		<set rowId="Sports and Fitness" columnId="Jan" value="13"/>\n\
		<set rowId="Sports and Fitness" columnId="Feb" value="10"/>\n\
		<set rowId="Sports and Fitness" columnId="Mar" value="12"/>\n\
		<set rowId="Sports and Fitness" columnId="Apr" value="11"/>\n\
		<set rowId="Sports and Fitness" columnId="May" value="10"/>\n\
		<set rowId="Sports and Fitness" columnId="Jun" value="14"/>\n\
		<set rowId="Sports and Fitness" columnId="Jul" value="19"/>\n\
		<set rowId="Sports and Fitness" columnId="Aug" value="13"/>\n\
		<set rowId="Sports and Fitness" columnId="Sep" value="9"/>\n\
		<set rowId="Sports and Fitness" columnId="Oct" value="5"/>\n\
		<set rowId="Sports and Fitness" columnId="Nov" value="9"/>\n\
		<set rowId="Sports and Fitness" columnId="Dec" value="17"/>\n\
   </dataset>\n\
	<colorRange gradient="0">\n\
        <color minValue="0" maxValue="10" code="C7E3EF" label="Poor"/>\n\
        <color minValue="10" maxValue="25" code="87C8EE" label="Average"/>\n\
        <color minValue="25" maxValue="50" code="4091C9" label="Excellent"/>\n\
     </colorRange>\n\
	<styles>\n\
	    <definition>\n\
	        <style name="TextStyle" type="font" color="0E4985"/>\n\
	        <style name="DataValueStyle" type="font" color="333333" bold="1"/>\n\
	    </definition>\n\
	    <application>\n\
	        <apply toObject="Caption" styles="TextStyle" />\n\
	        <apply toObject="Subcaption" styles="TextStyle" />\n\
	        <apply toObject="DataValues" styles="DataValueStyle" />\n\
	        <apply toObject="Legend" styles="TextStyle" />\n\
	        <apply toObject="DataXLabels" styles="TextStyle" />\n\
	        <apply toObject="DataYLabels" styles="TextStyle" />\n\
	    </application>\n\
	</styles>\n\
</chart>';