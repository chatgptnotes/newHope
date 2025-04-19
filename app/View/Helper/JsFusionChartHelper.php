<?php 
App::uses('AppHelper', 'View/Helper');

class JsFusionChartHelper extends AppHelper {
    public $helpers = array('Html');

    public function showFusionChart($flashPath, $flashId, $width, $height, $otherfield1=0, $otherfield2=0, $dataToShow, $renderId) {
       
		return  '<script type="text/javascript">
					
                 FusionCharts.setCurrentRenderer("JavaScript"); 
                 var chart = new FusionCharts("'.$flashPath.'", "'.$flashId.'", "'.$width.'", "'.$height.'", "'.$otherfield1.'", "'.$otherfield2.'" );
                     chart.setXMLData( '.$dataToShow.' );
                     chart.setTransparent(true);
                     chart.render("'.$renderId.'");
                 </script>';
    }
}