<?php
	session_start();
?>
<!DOCTYPE HTML>
<!--
	Dopetrope by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Chipper</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<link rel="stylesheet" href="assets/css/main.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
		<style>
		
			/* MV: 11/5/23
			
			very rough, but got the text to go over the image. below is what I found:
			https://www.bannerbear.com/blog/how-to-overlay-text-on-an-image-in-html-and-css/#:~:text=First%2C%20create%20a%20new%20HTML,the%20head%20and%20body%20sections.&text=In%20the%20body%20section%2C%20create,and%20add%20your%20text%20inside.
			~losing mind~
			*/
			.memeout {
				position: relative;
				display: inline-block;
			}

			.memeout img {
				display: block;
				width: 100%;
				height: auto;
			}

			.topmemetext {
				position: absolute;
				top: 50%; 
				left: 50%; 
				transform: translate(-50%, -50%);   
				color: white; 
				text-align: center;
				-webkit-text-stroke-width: 1px;
				-webkit-text-stroke-color: black;
				font-size: xx-large;
			}
			
			.botmemetext {
				position: absolute;
				bottom: 50%;
				left: 50%;
				transform: translate(-50%, -50%);  
				color: white; 
				text-align: center;	
				-webkit-text-stroke-width: 1px;
				-webkit-text-stroke-color: black;
				font-size: xx-large;
			}
		</style>
		<?php
			$webpageslist = array(["home", "Home"], ["meme generator", "Meme Generator"], ["card generator", "Card Generator"], ["community creations", "Community Creations"], ["about us", "About Us"]);
			if(!isset($_SESSION['username'])) {
				$webpageslist[] = ["login", "Login"];
				$webpageslist[] = ["register", "Register"];
			} else {
				$webpageslist[] = ["assets/scripts/logout", "Log Out"];
			}
		?>
	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">
			<!-- Header -->
			<section id="header">

				<!-- Logo -->
				<h1><a href="index.html">Chipper</a></h1>

				<!-- Nav -->
				<?php
					$html_nav = '<nav id="nav"><ul>';
					$active_page = "";
					if(isset($_GET['page'])) {
						$active_page = $_GET['page'];
					}
					foreach($webpageslist as $index => $nav_item) {
						if($nav_item[0] == $active_page || $active_page == "" && $index == 0) {
							$html_nav .= '<li class="current"><a href="index.php?page='. $nav_item[0] .'">'. $nav_item[1] .'</a></li>';
						} else {
							$html_nav .= '<li><a href="index.php?page='. $nav_item[0] .'">'. $nav_item[1] .'</a></li>';
						}
					}
					$html_nav .= '</ul></nav>';
					echo $html_nav;
				?>

			</section>
			<?php
				if (isset($_GET['page'])) {
					$page = $_GET['page'];
					include(in_webpage_list($page, $webpageslist).'.php');
				} else {
					include("home.php");
				}
			function in_webpage_list($query, $list) {
				foreach($list as $sub_array) {
					if(in_array($query, $sub_array)) {
						return $sub_array[0];
					}					
				}
				return '404';
			}
			?>
			<?php
				include("footer.php");
			?>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
	</body>
</html>