<?php 
App::import('Vendor', 'fckeditor');

class FckHelper extends AppHelper { 
               
    /**
    * creates an fckeditor textarea
    * 
    * @param array $namepair - used to build textarea name for views, array('Model', 'fieldname')
    * @param stirng $basepath - base path of project/system
    * @param string $content
    */
    function fckeditor($namepair = array(), $basepath = '', $content = '',$width='',$height=''){
        $editor_name = 'data';
        foreach ($namepair as $name){
            $editor_name .= "[" . $name . "]";
        }

        $oFCKeditor = new FCKeditor($editor_name) ;
        
        if(!empty($width)){
        	$oFCKeditor->Width		= $width ;
        }
        if(!empty($height)){ 
			$oFCKeditor->Height		= $height ;
        }
        $oFCKeditor->BasePath = $basepath . '/js/fckeditor/' ;
        $oFCKeditor->Value = $content ;
        $oFCKeditor->Create() ;            
    }      
}  