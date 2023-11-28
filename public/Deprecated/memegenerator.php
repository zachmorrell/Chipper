<!-- Main -->
<section id="main">
    <div class="container">
        <!-- Content -->
        <article class="box post">
            <header>
				<h2>Meme Generator</h2>
				<p>Create and Build your own memes</p>
			</header>
            <input type="file" id="imageUpload" accept="image/*">
            <canvas id="canvas"></canvas>
            
            <div class="textInputsContainer">
                <input type="text" class="textInput" placeholder="Enter text">
                <button class="addTextButton">Add Text</button>
                <button class="removeTextButton">Remove Text</button>
            </div>
            
            <br>
            <label for="textColor">Text Color: </label> 
            <input type="color" id="textColor" value="#000000">

            <button id="moveLeftButton">Move Left</button>
            <button id="moveRightButton">Move Right</button>
            <button id="moveUpButton">Move Up</button>
            <button id="moveDownButton">Move Down</button>
            <br><br>
            <button id="downloadButton">Download Image</button>
            <button id="uploadButton">Upload your meme</button>
        </article>
    </div>
</section>

<script>
    
    const canvas = document.getElementById("canvas");
canvas.width = 600;
canvas.height = 600;
const context = canvas.getContext("2d");

const image = new Image();
image.src = "images/banana.png";
image.onload = redraw_canvas;

// Event listener for image selection through browse.
const imageUpload = document.getElementById("imageUpload");
imageUpload.addEventListener("change", function (e) {
    const file = e.target.files[0];

    // Checks if image has an acceptable extension.
    if (file && /\.(jpe?g|png|gif)$/i.test(file.name)) {
        const reader = new FileReader();

        reader.onload = function (event) {
            image.src = event.target.result;
            image.onload = redraw_canvas;
        };

        reader.readAsDataURL(file);
    } else {
        alert("Please upload a valid JPG, PNG, or GIF file.");
        imageUpload.value = null;
    }
});

function redraw_canvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    context.drawImage(image, 0, 0, canvas.width, canvas.height);
}
    /*document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");
        const textInputsContainer = document.querySelector(".textInputsContainer");
        const moveLeftButton = document.getElementById("moveLeftButton");
        const moveRightButton = document.getElementById("moveRightButton");
        const moveUpButton = document.getElementById("moveUpButton");
        const moveDownButton = document.getElementById("moveDownButton");
        const downloadButton = document.getElementById("downloadButton");
        const textColorInput = document.getElementById("textColor");
        const uploadedImage = new Image();
        let textPosition = null;

        // Set the default image URL
        const defaultImageURL = "images/banana.png";

        // Function to add text to the canvas
        function addText(text, position, color) {
            context.font = "44px Calibri";
            context.fillStyle = color || "black";

            context.fillText(text, position.x, position.y);
        }

        // Function to update the canvas with text
        function updateCanvas() {
            context.clearRect(0, 0, canvas.width, canvas.height);

            context.drawImage(uploadedImage, 0, 0, uploadedImage.width, uploadedImage.height);

            if (textPosition) {
                addText(textPosition.text, textPosition, textColorInput.value);
            }
        }

        // Event listener for Add Text button
        textInputsContainer.addEventListener("click", function (e) {
            if (e.target.classList.contains("addTextButton")) {
                const textInput = textInputsContainer.querySelector(".textInput");
                const text = textInput.value.trim();

                if (text !== "") {
                    textPosition = { x: 20, y: 20, text: text };
                    updateCanvas();
                }
            }

            if (e.target.classList.contains("removeTextButton")) {
                textPosition = null;
                updateCanvas();
            }
        });

        // Event listeners for Move buttons
        moveLeftButton.addEventListener("click", function () {
            if (textPosition) {
                textPosition.x -= 10;
                updateCanvas();
            }
        });

        moveRightButton.addEventListener("click", function () {
            if (textPosition) {
                textPosition.x += 10;
                updateCanvas();
            }
        });

        moveUpButton.addEventListener("click", function () {
            if (textPosition) {
                textPosition.y -= 10;
                updateCanvas();
            }
        });

        moveDownButton.addEventListener("click", function () {
            if (textPosition) {
                textPosition.y += 10;
                updateCanvas();
            }
        });

        // Event listener for Download button
        downloadButton.addEventListener("click", function () { 
            const downloadLink = document.createElement("a");
            const canvasDataUrl = canvas.toDataURL("image/png");
            downloadLink.href = canvasDataUrl;
            downloadLink.download = "canvas_image.png";
            downloadLink.click();
        });

        // Set the default image source and load it
        uploadedImage.src = defaultImageURL;
        uploadedImage.onload = function () {
            canvas.width = uploadedImage.width;
            canvas.height = uploadedImage.height;
            updateCanvas();
        };

        // Event listener for image upload
        imageUpload.addEventListener("change", function (e) {
            const file = e.target.files[0];

            // Check if the file is an image and has an allowed extension
            if (file && /\.(jpe?g|png|gif)$/i.test(file.name)) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    const img = new Image();
                    img.src = event.target.result;

                    img.onload = function () {
                        canvas.width = img.width;
                        canvas.height = img.height;
                        uploadedImage.src = event.target.result;
                        updateCanvas();
                    };
                };

                reader.readAsDataURL(file);
            } else {
                alert("Please upload a valid JPG, PNG, or GIF file.");
                imageUpload.value = null;
            }
        });
    });*/
</script>





<!-- 

Added Prior code for comparison if we want to add back or look at prior functionality. We still need major work on memegenerator

</?php
if (isset($_POST["submit"])) {

    // Check image using getimagesize function and get size
    // if a valid number is got then uploaded file is an image
    if (isset($_FILES["image"])) {
        // directory name to store the uploaded image files
        // this should have sufficient read/write/execute permissions
        // if not already exists, please create it in the root of the
        // project folder
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size and throw error if it is greater than
    // the predefined value, here it is 500000
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check for uploaded file formats and allow only 
    // jpg, png, jpeg and gif
    // If you want to allow more formats, declare it here
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
 Main 
<section id="main">
					<div class="container">

						 Content
							<article class="box post">
								<a href="#" class="image featured"><img src="images/banana.png" alt="" width="500" height="500"></a>
								<header>
									<h2>Meme Generator</h2>
									<p>Create and Build your own memes</p>
								</header>
								<div class="meme-generator">
								<form action="" method="post" enctype="multipart/form-data">
								<div class="row">
									<label>Select an Image</label>
									<input type="file" name="image" required id="image">
                                    <label>Top Text</label>
                                     I changed the names of the text so I could test out the text
                                    <input type="text" name="toptext" required>
                                    <label>Bottom Text</label>
                                    <input type="text" name="bottomtext" required>
									<input type="submit" name="submit" value="Upload" id="update">
								</div>
							</form>
							<div class="memeout"><?php if (isset($_FILES["image"]) && $uploadOk == 1) : ?>
								<img style="position:relative;right:100px;width:150%;" src="<?php echo $targetFile; ?>" alt="Uploaded Image">
                                
							<?php endif; ?>
                            
                             MV: 11/5/23
                            
                            testing out the text using what I found on Stackflow while I was trying to work through how to
                            work with the text:
                            https://stackoverflow.com/questions/9046353/display-entered-text-with-echo-after-input-php

                            MV: 11/5/23

                            added more div and classes for index
                            <div class="topmemetext"> </?php if(isset($_POST["submit"])) {
                                echo htmlspecialchars($_POST["bottomtext"]);
                                }
                            ?>
                            <div class="botmemetext"></?php if(isset($_POST["submit"])) {
                                echo htmlspecialchars($_POST["toptext"]);
                                }
                            ?>
                            </div>
                            </div>
                            </div>
                            
								</div>
							</article>

					</div>
				</section>

-->
