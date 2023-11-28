
<style>

textarea {
	background-color: rgba(255,255,255,0.5);
	padding: 10px;
}

#imageContainer {
	position: relative;
	width: 300px;
	height: auto;
}

#overlayImage {
	max-width: 100%;
	height: auto;
	margin: 10px;
}

#textOverlay {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	font-size: 18px;
	color: white;
	background: rgba(0, 0, 0, 0.5);
	padding: 10px;
}
label {
	display: block;
	width: 200px;
	background: #d52349;
	color: #fff;
	padding: 12px;
	cursor: pointer;
	text-align: center;
	font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;  
}
input {
	display: none;
}
</style>
<!-- Main -->
<section id="main">
<div class="container">

	<!-- Content -->
	<article class="box post">
		<a href="index.php?page=cardgenerator" class="image featured"><img src="images/greetingscard2.jpg" alt="" width="500" height="500"/></a>
		<header>
			<h2>Greeting Card Generator</h2>
			<p>Create your own greeting card</p>
		</header>
		<label for="imageInput">Select Card Image</label>
		<input type="file" id="imageInput" name="imageInput" accept="image/*">
		<br>
		<textarea id="overlayText" rows="3" cols="50" placeholder="Enter text to overlay"></textarea>
		<br>
		
		<button id="uploadButton">Render Card Image</button>
		
		<div id="imageContainer">
			<img id="overlayImage" src="" alt="Selected Image">
			<div id="textOverlay"></div>
		</div>
		<div id="save">
			<button type="button" id="sharememe">Share Meme</button>
			<button type="button" data-download="overlayImage">Download Meme</button>
		<div>
		<script src="assets/js/generator.js"></script>
	</article>
</div>
</section>