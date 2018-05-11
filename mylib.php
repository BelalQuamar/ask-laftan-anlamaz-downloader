<?php

function get_file_link($showtvlink, $before, $after)
{
$fullstring = file_get_contents($showtvlink);
$parsed = get_string_between($fullstring, $before, $after);
$parsed = str_replace('\\', '/', $parsed);
$parsed = str_replace('//', '/', $parsed);
return $parsed; 
}


function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


function RemoveSpaces($url){
     
	  $url = preg_replace('/\s+/', '-', trim($url));
	  $url = str_replace("         ","-",$url);
	  $url = str_replace("        ","-",$url);
	  $url = str_replace("       ","-",$url);
	  $url = str_replace("      ","-",$url);
	  $url = str_replace("     ","-",$url);
	  $url = str_replace("    ","-",$url);
	  $url = str_replace("   ","-",$url);
	  $url = str_replace("  ","-",$url);
	  $url = str_replace(" ","-",$url);
	
     return $url;
     
}

function RemoveUrlSpaces($url){

        $url = preg_replace('/\s+/', '%20', trim($url));  
        $url = str_replace("         ","%20",$url);
        $url = str_replace("        ","%20",$url);
        $url = str_replace("       ","%20",$url);
        $url = str_replace("      ","%20",$url);
        $url = str_replace("     ","%20",$url);
        $url = str_replace("    ","%20",$url);
	    $url = str_replace("   ","%20",$url);
	    $url = str_replace("  ","%20",$url);
	    $url = str_replace(" ","%20",$url);
		
        return $url;
     
}
function DownloadAnything($file, $newfilename = '', $mimetype='', $isremotefile = false){
         
        $formattedhpath = "";
        $filesize = "";

        if(empty($file)){
           die('Please enter file url to download...!');
           exit;
        }
     
         //Removing spaces and replacing with %20 ascii code
         $file = RemoveUrlSpaces($file);
          
          
        if(preg_match("#http://#", $file)){
          $formattedhpath = "url";
        }else{
          $formattedhpath = "filepath";
        }
        
        if($formattedhpath == "url"){

          $file_headers = @get_headers($file);
  
          if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
           die('File is not readable or not found...!');
           exit;
          }
          
        }elseif($formattedhpath == "filepath"){

          if(@is_readable($file)) {
               die('File is not readable or not found...!');
               exit;
          }
        }
        
        
       //Fetching File Size Located in Remote Server
       if($isremotefile && $formattedhpath == "url"){
          
          
          $data = @get_headers($file, true);
          
          if(!empty($data['Content-Length'])){
          $filesize = (int)$data["Content-Length"];
          
          }else{
               
               ///If get_headers fails then try to fetch filesize with curl
               $ch = @curl_init();

               if(!@curl_setopt($ch, CURLOPT_URL, $file)) {
                 @curl_close($ch);
                 @exit;
               }
               
               @curl_setopt($ch, CURLOPT_NOBODY, true);
               @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               @curl_setopt($ch, CURLOPT_HEADER, true);
               @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
               @curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
               @curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
               @curl_exec($ch);
               
               if(!@curl_errno($ch))
               {
                    
                    $http_status = (int)@curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if($http_status >= 200  && $http_status <= 300)
                    $filesize = (int)@curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
               
               }
               @curl_close($ch);
               
          }
          
       }elseif($isremotefile && $formattedhpath == "filepath"){
         
	   die('Error : Need complete URL of remote file...!');
           exit;
		   
       }else{
         
		   if($formattedhpath == "url"){
		   
			   $data = @get_headers($file, true);
			   $filesize = (int)$data["Content-Length"];
			   
		   }elseif($formattedhpath == "filepath"){
		   
		       $filesize = (int)@filesize($file);
			   
		   }
		   
       }
       
       if(empty($newfilename)){
          $newfilename =  @basename($file);
       }else{
          //Replacing any spaces with (-) hypen
          $newfilename = RemoveSpaces($newfilename);
       }
       
       if(empty($mimetype)){
          
       ///Get the extension of the file
       $path_parts = @pathinfo($file);
       $myfileextension = $path_parts["extension"];

        switch($myfileextension)
        {
          
            ///Image Mime Types
            case 'jpg':
            $mimetype = "image/jpg";
            break;
            case 'jpeg':
            $mimetype = "image/jpeg";
            break;
            case 'gif':
            $mimetype = "image/gif";
            break;
            case 'png':
            $mimetype = "image/png";
            break;
            case 'bm':
            $mimetype = "image/bmp";
            break;
            case 'bmp':
            $mimetype = "image/bmp";
            break;
            case 'art':
            $mimetype = "image/x-jg";
            break;
            case 'dwg':
            $mimetype = "image/x-dwg";
            break;
            case 'dxf':
            $mimetype = "image/x-dwg";
            break;
            case 'flo':
            $mimetype = "image/florian";
            break;
            case 'fpx':
            $mimetype = "image/vnd.fpx";
            break;
            case 'g3':
            $mimetype = "image/g3fax";
            break;
            case 'ief':
            $mimetype = "image/ief";
            break;
            case 'jfif':
            $mimetype = "image/pjpeg";
            break;
            case 'jfif-tbnl':
            $mimetype = "image/jpeg";
            break;
            case 'jpe':
            $mimetype = "image/pjpeg";
            break;
            case 'jps':
            $mimetype = "image/x-jps";
            break;
            case 'jut':
            $mimetype = "image/jutvision";
            break;
            case 'mcf':
            $mimetype = "image/vasa";
            break;
            case 'nap':
            $mimetype = "image/naplps";
            break;
            case 'naplps':
            $mimetype = "image/naplps";
            break;
            case 'nif':
            $mimetype = "image/x-niff";
            break;
            case 'niff':
            $mimetype = "image/x-niff";
            break;
            case 'cod':
            $mimetype = "image/cis-cod";
            break;
            case 'ief':
            $mimetype = "image/ief";
            break;
            case 'svg':
            $mimetype = "image/svg+xml";
            break;
            case 'tif':
            $mimetype = "image/tiff";
            break;
            case 'tiff':
            $mimetype = "image/tiff";
            break;
            case 'ras':
            $mimetype = "image/x-cmu-raster";
            break;
            case 'cmx':
            $mimetype = "image/x-cmx";
            break;
            case 'ico':
            $mimetype = "image/x-icon";
            break;
            case 'pnm':
            $mimetype = "image/x-portable-anymap";
            break;
            case 'pbm':
            $mimetype = "image/x-portable-bitmap";
            break;
            case 'pgm':
            $mimetype = "image/x-portable-graymap";
            break;
            case 'ppm':
            $mimetype = "image/x-portable-pixmap";
            break;
            case 'rgb':
            $mimetype = "image/x-rgb";
            break;
            case 'xbm':
            $mimetype = "image/x-xbitmap";
            break;
            case 'xpm':
            $mimetype = "image/x-xpixmap";
            break;
            case 'xwd':
            $mimetype = "image/x-xwindowdump";
            break;
            case 'rgb':
            $mimetype = "image/x-rgb";
            break;
            case 'xbm':
            $mimetype = "image/x-xbitmap";
            break;
            case "wbmp":
            $mimetype = "image/vnd.wap.wbmp";
            break;
          
            //Files MIME Types
            
            case 'css':
            $mimetype = "text/css";
            break;
            case 'htm':
            $mimetype = "text/html";
            break;
            case 'html':
            $mimetype = "text/html";
            break;
            case 'stm':
            $mimetype = "text/html";
            break;
            case 'c':
            $mimetype = "text/plain";
            break;
            case 'h':
            $mimetype = "text/plain";
            break;
            case 'txt':
            $mimetype = "text/plain";
            break;
            case 'rtx':
            $mimetype = "text/richtext";
            break;
            case 'htc':
            $mimetype = "text/x-component";
            break;
            case 'vcf':
            $mimetype = "text/x-vcard";
            break;
           
           
            //Applications MIME Types
            
            case 'doc':
            $mimetype = "application/msword";
            break;
            case 'xls':
            $mimetype = "application/vnd.ms-excel";
            break;
            case 'ppt':
            $mimetype = "application/vnd.ms-powerpoint";
            break;
            case 'pps':
            $mimetype = "application/vnd.ms-powerpoint";
            break;
            case 'pot':
            $mimetype = "application/vnd.ms-powerpoint";
            break;
          
            case "ogg":
            $mimetype = "application/ogg";
            break;
            case "pls":
            $mimetype = "application/pls+xml";
            break;
            case "asf":
            $mimetype = "application/vnd.ms-asf";
            break;
            case "wmlc":
            $mimetype = "application/vnd.wap.wmlc";
            break;
            case 'dot':
            $mimetype = "application/msword";
            break;
            case 'class':
            $mimetype = "application/octet-stream";
            break;
            case 'exe':
            $mimetype = "application/octet-stream";
            break;
            case 'pdf':
            $mimetype = "application/pdf";
            break;
            case 'rtf':
            $mimetype = "application/rtf";
            break;
            case 'xla':
            $mimetype = "application/vnd.ms-excel";
            break;
            case 'xlc':
            $mimetype = "application/vnd.ms-excel";
            break;
            case 'xlm':
            $mimetype = "application/vnd.ms-excel";
            break;
           
            case 'msg':
            $mimetype = "application/vnd.ms-outlook";
            break;
            case 'mpp':
            $mimetype = "application/vnd.ms-project";
            break;
            case 'cdf':
            $mimetype = "application/x-cdf";
            break;
            case 'tgz':
            $mimetype = "application/x-compressed";
            break;
            case 'dir':
            $mimetype = "application/x-director";
            break;
            case 'dvi':
            $mimetype = "application/x-dvi";
            break;
            case 'gz':
            $mimetype = "application/x-gzip";
            break;
            case 'js':
            $mimetype = "application/x-javascript";
            break;
            case 'mdb':
            $mimetype = "application/x-msaccess";
            break;
            case 'dll':
            $mimetype = "application/x-msdownload";
            break;
            case 'wri':
            $mimetype = "application/x-mswrite";
            break;
            case 'cdf':
            $mimetype = "application/x-netcdf";
            break;
            case 'swf':
            $mimetype = "application/x-shockwave-flash";
            break;
            case 'tar':
            $mimetype = "application/x-tar";
            break;
            case 'man':
            $mimetype = "application/x-troff-man";
            break;
            case 'zip':
            $mimetype = "application/zip";
            break;
            case 'xlsx':
            $mimetype = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
            break;
            case 'pptx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
            break;
            case 'docx':
            $mimetype = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
            break;
            case 'xltx':
            $mimetype = "application/vnd.openxmlformats-officedocument.spreadsheetml.template";
            break;
            case 'potx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.template";
            break;
            case 'ppsx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.slideshow";
            break;
            case 'sldx':
            $mimetype = "application/vnd.openxmlformats-officedocument.presentationml.slide";
            break;
          
            ///Audio and Video Files
            
            case 'mp3':
            $mimetype = "audio/mpeg";
            break;
            case 'wav':
            $mimetype = "audio/x-wav";
            break;
            case 'au':
            $mimetype = "audio/basic";
            break;
            case 'snd':
            $mimetype = "audio/basic";
            break;
            case 'm3u':
            $mimetype = "audio/x-mpegurl";
            break;
            case 'ra':
            $mimetype = "audio/x-pn-realaudio";
            break;
            case 'mp2':
            $mimetype = "video/mpeg";
            break;
            case 'mov':
            $mimetype = "video/quicktime";
            break;
            case 'qt':
            $mimetype = "video/quicktime";
            break;
            case 'mp4':
            $mimetype = "video/mp4";
            break;
            case 'm4a':
            $mimetype = "audio/mp4";
            break;
            case 'mp4a':
            $mimetype = "audio/mp4";
            break;
            case 'm4p':
            $mimetype = "audio/mp4";
            break;
            case 'm3a':
            $mimetype = "audio/mpeg";
            break;
            case 'm2a':
            $mimetype = "audio/mpeg";
            break;
            case 'mp2a':
            $mimetype = "audio/mpeg";
            break;
            case 'mp2':
            $mimetype = "audio/mpeg";
            break;
            case 'mpga':
            $mimetype = "audio/mpeg";
            break;
            case '3gp':
            $mimetype = "video/3gpp";
            break;
            case '3g2':
            $mimetype = "video/3gpp2";
            break;
            case 'mp4v':
            $mimetype = "video/mp4";
            break;
            case 'mpg4':
            $mimetype = "video/mp4";
            break;
            case 'm2v':
            $mimetype = "video/mpeg";
            break;
            case 'm1v':
            $mimetype = "video/mpeg";
            break;
            case 'mpe':
            $mimetype = "video/mpeg";
            break;
            case 'avi':
            $mimetype = "video/x-msvideo";
            break;
            case 'midi':
            $mimetype = "audio/midi";
            break;
            case 'mid':
            $mimetype = "audio/mid";
            break;
            case 'amr':
            $mimetype = "audio/amr";
            break;
            
            
            default:
            $mimetype = "application/octet-stream";
        
            
        }
        
        
       }
        
        
          //off output buffering to decrease Server usage
          @ob_end_clean();
        
          if(ini_get('zlib.output_compression')){
            ini_set('zlib.output_compression', 'Off');
          }
        
          header('Content-Description: File Transfer');
          header('Content-Type: '.$mimetype);
          header('Content-Disposition: attachment; filename='.$newfilename.'');
          header('Content-Transfer-Encoding: binary');
          header("Expires: Wed, 07 May 2013 09:09:09 GMT");
	    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	    header('Cache-Control: post-check=0, pre-check=0', false);
	    header('Cache-Control: no-store, no-cache, must-revalidate');
	    header('Pragma: no-cache');
          header('Content-Length: '.$filesize);
        
        
          ///Will Download 1 MB in chunkwise
          $chunk = 1 * (1024 * 1024);
          $nfile = @fopen($file,"rb");
          while(!feof($nfile))
          {
                 
              print(@fread($nfile, $chunk));
              @ob_flush();
              @flush();
          }
          @fclose($filen);
               


}
?>