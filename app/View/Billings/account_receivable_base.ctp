<?php 
echo $this->Html->script(array('/fusioncharts/fusioncharts', 'expand','/js/jquery-ui-1.8.16'));
?>
 <?php
      //We have included ../Includes/FusionCharts.php, which contains functions
      //to help us easily embed the charts.
      
      ?>
      <HTML>
         <HEAD>
        <TITLE> FusionCharts XT - Array Example using Single Series Column 3D Chart</TITLE>
       
     </HEAD>
     <BODY>
     <?php
         //In this example, we plot a single series chart from data contained
   //in an array. The array will have two columns - first one for data label
   //and the next one for data values.
   //Let's store the sales data for six products in our array). We also store
   //the name of products. 
         //Store Name of Products
         $arrData[0][1] = "Product A";
         $arrData[1][1] = "Product B";
         $arrData[2][1] = "Product C";
         $arrData[3][1] = "Product D";
         $arrData[4][1] = "Product E";
         $arrData[5][1] = "Product F";
         //Store sales data
         $arrData[0][2] = 567500;
         $arrData[1][2] = 815300;
         $arrData[2][2] = 556800;
         $arrData[3][2] = 734500;
         $arrData[4][2] = 676800;
         $arrData[5][2] = 648500;
         
         $strCategories .= '<categories>';
         foreach ($arrData as $arSubData)
         $strCategories .= '<category label="' . $arSubData[1] . '" />';
         $strCategories .= '</categories>';
         //Now, we need to convert this data into XML. We convert using string concatenation.
         //Initialize <chart> element
         $strXML = '<chart caption="Sales by Product" xAxisName="Name" yAxisName="sales" numberPrefix="$" formatNumberScale="0">';
         //Convert data to XML and append
         
         $strXML .= $strCategories;
         
         
         
         $strXML .= '<dataset>';
         foreach ($arrData as $arSubData)
         $strXML .= '<set label="' . $arSubData[1] . '" value="' . $arSubData[2] . '" />';
         //Close <chart> element
         $strXML .= '</dataset>';
         $strXML .= '</chart>';
         //Create the chart - Column 3D Chart with data contained in strXML
         
         ?>
         <script>
			var xmlString = '<?php echo $strXML; ?>';alert(xmlString);
         </script>
         <div id="multiaxischartdiv1" align="center">
									<?php echo $this->JsFusionChart->showFusionChart("fusionx_charts/StackedColumn2DLine.swf", "multiaxisChartId1", "145%", "250", "0", "0", "xmlString", "multiaxischartdiv1"); ?>
								</div>
  </BODY>
</HTML>

