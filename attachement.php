<?php

    require('config.php');
    
    
    $attachement=DOL_DATA_ROOT.GETPOST('attachement');
    $mime = GETPOST('mime');
    
    $checksum = md5($attachement.'/'.$mime.'/'.filesize($attachement));
    
    $filename=basename($attachement);
    
    if($checksum === GETPOST('checksum') ) {
        
        header("Content-Type: application/force-download; name=\"" . $filename . "\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".filesize($attachement));
        header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
        header("Expires: 0");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        readfile($attachement);
        exit(); 
        
    }
