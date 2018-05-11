<?php 
if($_SERVER["REQUEST_METHOD"] == "POST") { 
include('mylib.php');
$episodecode =  $_POST['episode'];
$quality =  $_POST['quality'];
$cdn =  $_POST['cdn'];
$part =  $_POST['part'];
$episodelist = array('23629','23759','23907','24131','24267','24378','24472','24587','24803','24970','25244','25438','25639','25844','26068','26242','26492','26656','26823','26990','27150','27317','27474','27636','27909','28072','28230','28518','28926','29430','29895');
$showtvlink = 'http://www.showtv.com.tr/dizi/tum_bolumler/ask-laftan-anlamaz-sezon-1-bolum-1-parca-'.$part.'-izle/'.$episodelist[$episodecode];
$before = '"name":"'.$quality.'","file":"';
$after = '","type":"video\/mp4"';
$parsedname = "Ask Laftan Anlamaz Season 1 Episode ".($episodecode+1)." Part ".$part."-".$quality."p .mp4";
$parsed = get_file_link($showtvlink,$before, $after);
if ($cdn == 2)
str_replace('vmcdn.ciner.com.tr', 'ciner.mncdn.net', $parsed);
DownloadAnything($parsed, $parsedname, '', false);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Belal Quamar-Aşk Laftan Anlamaz</title>
  <link rel="icon" href="http://s2.dmcdn.net/lfC7x/240x240-DGK.jpg" type="image/x-icon">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <style>
 body, html {
    height: 100%;
}

.bg { 
    /* The image used */
    background-image: url("http://im.showtv.com.tr/2016/06/30/ver1467380744/1261042_1920x1080.jpg");

    /* Full height */
    height: 100%; 

    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.blink{
		font-size: 40px;
		color: rgb (256, 0, 0);
		
		animation: blink 1s infinite;
	 }
	 
	 @keyframes blink{
		0%{opacity: 1;}
		75%{opacity: 1;}
		76%{ opacity: 0;}
		100%{opacity: 0;}
	 }
	 
	 
</style>
</head>
</body>
<div class="bg">
<div class="container">
  <div class="col-sm-12">
<form action="" method="post" enctype="multipart/form-data" onsubmit="if(document.getElementById('agree').checked) { return true; } else { alert('Please indicate that you have read and agree to the Terms and Conditions and Privacy Policy'); return false; }">
<center>
<font color="red"><h3 class="blink">You can now download all parts of an episode</h3>
</font>
<font color="white"><h3>Ask Laftan Anlamaz Downloader<br> You can use this downloader to download episodes of Ask Laftan Anlamaz direct from show tv cdn <br>Choose options below and start</h3></font>
</center>
 <br>
 </div>
 <div class="col-sm-4"></div>
 <div class="col-sm-3">
 <div class="form-group">
 <label for="sel1">Select Episode:</label>
 
 <select name="episode" id="sel1" class="form-control">
 <?php for($episoden = 0;$episoden < 31;$episoden++) 
	echo '<option value="'.$episoden.'">Episode '.($episoden+1).'</option>'; ?>
  </select>
  
   <br>
 <label for="sel2">Select Part of the Episode:</label>
  <select name="part" id="sel4" class="form-control">
  <?php for($x=1;$x<9;$x++){?>
  <option value="<?php echo $x; ?>">Part <?php echo $x; ?></option>
  <?php } ?>
  </select>
  
  
 <br>
 <label for="sel2">Select Quality:</label>
  <select name="quality" id="sel2" class="form-control">
  <option value="1080">1080p</option>
  <option value="720">720p</option>
  <option value="360">360p</option>
  <option value="240">240p</option>
  </select>
 <br>
<label for="sel3">Select CDN Server:</label>
  <select name="cdn" id="sel3" class="form-control">
  <option value="1">vmcdn.ciner.com.tr</option>
  <option value="2">ciner.mncdn.net</option>
  </select>
 <br>
 

	<input  type="submit"  name="submit" class="btn btn-info" value="Download" />  
	
</div>	
        </form>
	</div></div>
	*None of the files downloaded from this page are hosted on this  server.<br>
	*These all files come from the cdn servers of show tv which were obtained after web scrapping their website.<br>
	*All courtesy to show tv for video content.<br>
	*For this code http://belalquamar.com <br>
	*You can also download this code below and host it yourself or study and modify 
<form method="get" action="asklaftananlamaz.zip">
   <button class="btn btn-info" type="submit">Download this code!</button>
</form>
	</div>	
	
	</body>
	</html>
	