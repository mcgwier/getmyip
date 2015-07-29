<?php

// variables
$xfwd     = mm_strip($_SERVER["HTTP_X_FORWARDED_FOR"]);
$address  = mm_strip($_SERVER["REMOTE_ADDR"]);
$port     = mm_strip($_SERVER["REMOTE_PORT"]);
$method   = mm_strip($_SERVER["REQUEST_METHOD"]);
$protocol = mm_strip($_SERVER["SERVER_PROTOCOL"]);
$agent    = mm_strip($_SERVER["HTTP_USER_AGENT"]);

if ($xfwd !== '') {
	$IP = $xfwd;
	$proxy = $address;
	$host = @gethostbyaddr($xfwd);
} else {
	$IP = $address;
	$host = @gethostbyaddr($address);
}

// sanitizes
function mm_strip($string) {
	$string = trim($string);
	$string = strip_tags($string);
	$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	$string = str_replace("\n", "", $string);
	$string = trim($string);
	return $string;
}
?>
<!DOCTYPE html>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Jason Mcgwier">
	<title>What's my IP?</title>
	<style type="text/css">
		* { margin:0; padding:0; }
		body { background:#ededed; color:#777; margin-top:50px; }
		.tools { margin:25px auto; width:960px; }
		.tools p {
			margin-left:20px; color:#c7c7c7; font-family: Georgia,serif;
			}
		#ip-lookup {
			border:1px solid #ededed;
			background: #fff;
			}
		#tools p { font-size:77px; }
		#more p  { font-size:24px; }
		#more-info p { font-size:18px; }
		#more-info ul { margin:20px 0 35px 50px; font-size:18px; color:#bbb;list-style-type: none;}
		#more-info li { margin:10px 0; line-height:25px; font-family:Helvetica, Arial; }
		h1 {
			font: 124px/1 Helvetica, Arial; text-align:center; margin:50px 0; color:#00CD96;
			}
		h1 a:link { color:#efefef; }
		a:link,a:visited {
			color:#bbb; text-decoration:none; outline:0 none;
			}
		a:hover,a:active { color:#999; text-decoration:underline; outline:0 none; }
		li span {
			font:16px/1 Monaco,"Panic Sans","Lucida Console","Courier New",Courier,monospace,sans-serif; color:#888;
			}
	</style>
	<body>
		<a href="https://github.com/mcgwier/getmyip/"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/52760788cde945287fbb584134c4cbc2bc36f904/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f77686974655f6666666666662e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_white_ffffff.png"></a>
		<div id="tools" class="tools">
			<p>Your IP:</p>
		</div>
		<div id="ip-lookup" class="tools">
			<h1><?php echo $IP; ?></h1>
		</div>
		<div id="more" class="tools">
			<p><a id="more-link" title="More information" href="javascript:toggle();">More info</a></p>
		</div>
		<div id="more-info" class="tools">
			<ul>
			<?php
				echo '<li><strong>Remote Port:</strong> <span>'.$port.'</span></li>';
				echo '<li><strong>Request Method:</strong> <span>'.$method.'</span></li>';
				echo '<li><strong>Server Protocol:</strong> <span>'.$protocol.'</span></li>';
				echo '<li><strong>Server Host:</strong> <span>'.$host.'</span></li>';
				echo '<li><strong>User Agent:</strong> <span>'.$agent.'</span></li>';
				if ($proxy) echo '<li><strong>Proxy: <span>'.($proxy) ? $proxy : ''.'</span></li>';

				$time_start = microtime(true);
				usleep(100);
				$time_end = microtime(true);
				$time = $time_end - $time_start;
			?>
			</ul>
			<p><small>It took <?php echo $time; ?> seconds to share this info.</small></p>
		</div>
		<script type="text/javascript">
			function hideStuff(){
				if (document.getElementById){
					var x = document.getElementById('more-info');
					x.style.display="none";
				}
			}
			function toggle(){
				if (document.getElementById){
					var x = document.getElementById('more-info');
					var y = document.getElementById('more-link');
					if (x.style.display == "none"){
						x.style.display = "";
						y.innerHTML = "Less info";
					} else {
						x.style.display = "none";
						y.innerHTML = "More info";
					}
				}
			}
			window.onload = hideStuff;
		</script>
	</body>
</html>
