<?php $rowArr[] = array("Sr.No","Product Name","Current Stock","Purchase Price","Maximum Order Limit","Reorder Level"); ?>
<?php if(!empty($results)){ 
        $count=0;  foreach($results as $product){ 
            $displayArr = array();
            $displayArr[] = ++$count;
            $displayArr[] = $product['PharmacyItem']['name'];
            $displayArr[] = $product['0']['total_Stock'];
            $displayArr[] = $product['PharmacyItem']['maximum'];
            $displayArr[] = $product['PharmacyItem']['reorder_level']; 
            $rowArr[] = $displayArr;
        }   
    } 
    
    
    function outputCSV($data,$file_name = 'file.csv') {
       # output headers so that the file is downloaded rather than displayed
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=$file_name");
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");
    
        # Start the ouput
        $output = fopen("php://output", "w");
        
         # Then loop through the rows
        foreach ($data as $row) {
            # Add the rows to the body
            fputcsv($output, $row); // here you can change delimiter/enclosure
        }
        # Close the stream off
        fclose($output);
    } 
        $filaname = "Pharmacy - $heading - ".$this->DateFormat->formatDate2Local(date('Y-m-d'),Configure::read('date_format'),false).".csv" ; 
        outputCSV($rowArr,$filaname); 
        exit;  
?>


