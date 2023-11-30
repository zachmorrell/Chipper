<script>
    const img_canvas = document.getElementById("img_canvas");
    const txt_canvas = document.getElementById("txt_canvas");
    img_canvas.width = img_canvas.height = txt_canvas.width = txt_canvas.height = 600;
    const img_context = img_canvas.getContext("2d");
    const txt_context = txt_canvas.getContext("2d");

    txt_canvas.style.backgroundColor = 'white';

    const provided_templates = [['Anniversary','anniversary.png'],['Birthday', 'birthday.png'],['Christmas','christmas.png'],['Congrats','congrats.png'],['Easter','easter.png'],['Happy Holidays','holidays1.png'],['Happy Holidays 2','holiday2.png'],['New Years', 'new_years.png'],['Sorry','sorry.png'],['Thank You','thanks.png']];

    const image = new Image();
    var image_index = 0;
    image.src = "images/greetings/" + provided_templates[image_index][1];
    image.onload = redraw_img_canvas;

    // Event listener for image selection through browse.
    const imageUpload = document.getElementById("imageUpload");
    imageUpload.addEventListener("change", function (e) {
        const file = e.target.files[0];

        // Checks if the image has an acceptable extension.
        if (file && /\.(jpe?g|png|gif)$/i.test(file.name)) {
            const reader = new FileReader();

            reader.onload = function (event) {
                image.src = event.target.result;
                image.onload = redraw_img_canvas;
            };

            reader.readAsDataURL(file);
        } else {
            alert("Please upload a valid JPG, PNG, or GIF file.");
            imageUpload.value = null;
        }
    });

    function redraw_img_canvas() {
        img_context.clearRect(0, 0, img_canvas.width, img_canvas.height);
        img_context.drawImage(image, 0, 0, img_canvas.width, img_canvas.height);
    }

    // Text Canvas
    const canvas = document.getElementById('txt_canvas');
    const textInput = document.getElementById('txt_input');
    textInput.style.display = 'none'; // Hide the textarea by default

    img_canvas.addEventListener('click', function (event) {
        image.src = "images/greetings/" + provided_templates[get_next_index()][1];
        image.onload = redraw_image_canvas;
    });
    function get_next_index() {
    if (image_index + 1 >= provided_templates.length) {
        image_index = 0;
    } else {
        image_index += 1;
    }
    return image_index;
}

    txt_canvas.addEventListener('click', function (event) {
        textInput.style.display = 'block';
        textInput.style.top = (event.clientY + window.scrollY) + 'px';
        textInput.style.left = (event.clientX + window.scrollX) + 'px';
        textInput.focus();
    });

    textInput.addEventListener('input', function () {
        // Clear the canvas and redraw the image
        txt_context.clearRect(0, 0, txt_canvas.width, txt_canvas.height);
        redraw_img_canvas();

        // Wrap the text and draw it on the canvas
        txt_context.font = '16px Arial';
        wrapText(txt_context, textInput.value, 100, 116, txt_canvas.width - 200, 20);
    });

    textInput.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.keyCode === 13) {
            // Move to the next line when Enter is pressed
            textInput.value += '\n';
            event.preventDefault();
        }
    });

    textInput.addEventListener('blur', function () {
        textInput.style.display = 'none';
        textInput.value = '';
    });

    const upload_button = document.getElementById('uploadButton');
    upload_button.addEventListener('click', function() {
        alert("Trying to save content.");
        combine_and_save_canvas();
    });

// Function to wrap text within the specified width
function wrapText(context, text, x, y, maxWidth, lineHeight) {
    const lines = text.split('\n');
    
    lines.forEach((line, lineIndex) => {
        const words = line.split(' ');
        let currentLine = '';

        words.forEach((word, index) => {
            const testLine = currentLine + word + ' ';
            const metrics = context.measureText(testLine);
            const testWidth = metrics.width;

            if (testWidth > maxWidth) {
                context.fillText(currentLine.trim(), x, y);
                y += lineHeight;
                currentLine = word + ' ';
            } else {
                currentLine = testLine;
            }

            // Check if this is the last word, and if so, add it to a new line
            if (index === words.length - 1) {
                context.fillText(currentLine.trim(), x, y);
            }
        });

        // Check if this is the last line, and if so, add it to a new line
        if (lineIndex < lines.length - 1) {
            y += lineHeight;
        }
    });
}

// Function to combine the two canvases and save as an image.
function combine_and_save_canvas() {
    alert("combine and save activated.");

    const content_name = document.getElementById('content_name').value;
    const is_meme = 0;
    alert("variables set");

    var combined_canvas = document.createElement('canvas');
    var combined_context = combined_canvas.getContext('2d');

    combined_canvas.width = img_canvas.width * 2;
    combined_canvas.height = Math.max(img_canvas.height, txt_canvas.height);

    // Set background color for the combined canvas
    combined_context.fillStyle = 'white';
    combined_context.fillRect(0, 0, combined_canvas.width, combined_canvas.height);
    alert("fill style");

    // Draw the image canvas
    combined_context.drawImage(img_canvas, 0, 0);
    alert("img canvas drawn");

    // Draw the text canvas
    combined_context.drawImage(txt_canvas, img_canvas.width, 0);
    alert("txt canvas drawn");

    const imageData = combined_canvas.toDataURL("image/png");
        fetch('assets/scripts/upload.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'image=' + encodeURIComponent(imageData.replace(/^data:image\/(png|jpeg);base64,/, '')) +
                '&content_name=' + encodeURIComponent(content_name) +
                '&is_meme=' + encodeURIComponent(is_meme),
        })
            .then(response => {
                console.log(response);
            })
            .catch(error => console.error('Error:', error));
}
</script>