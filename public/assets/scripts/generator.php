<script>
    const canvas = document.getElementById("canvas");
    canvas.width = 600;
    canvas.height = 600;
    const context = canvas.getContext("2d");

    const image = new Image();
    image.src = "images/banana.png";
    image.onload = redraw_canvas;

    const textInputs = [];
    const textColorInput = document.getElementById("textColor");

    let selectedText = -1;
    let isDragging = false;
    let offsetX, offsetY;

    // Event listener for image selection through browse.
    const imageUpload = document.getElementById("imageUpload");
    imageUpload.addEventListener("change", function (e) {
        const file = e.target.files[0];

        // Checks if the image has an acceptable extension.
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

    // Event listener for adding text
    const addTextButton = document.getElementById("addTextButton");
    addTextButton.addEventListener("click", function () {
        const textInput = document.getElementById("textInput");
        const textColor = textColorInput.value;
        const text = textInput.value;

        // Store text details
        textInputs.push({ text, x: 50, y: 50, color: textColor, width: 0, height: 0 });

        measureTextDimensions(textInputs[textInputs.length - 1]);

        drawTexts();
    });

    // Event listener for removing text
    const removeTextButton = document.getElementById("removeTextButton");
    removeTextButton.addEventListener("click", function () {
        if (selectedText !== -1) {
            textInputs.splice(selectedText, 1);
            selectedText = -1;
            redraw_canvas();
            drawTexts();
        }
    });

    // Event listener for canvas click
    canvas.addEventListener("mousedown", function (e) {
        const mouseX = e.clientX - canvas.getBoundingClientRect().left;
        const mouseY = e.clientY - canvas.getBoundingClientRect().top;

        // Check if any text is clicked
        for (let i = textInputs.length - 1; i >= 0; i--) {
            if (isTextClicked(mouseX, mouseY, textInputs[i])) {
                selectedText = i;
                isDragging = true;
                offsetX = mouseX - textInputs[i].x;
                offsetY = mouseY - textInputs[i].y;
                return;
            }
        }

        // If no text is clicked, clear the selection
        selectedText = -1;
        isDragging = false;
    });

    // Event listener for canvas drag
    canvas.addEventListener("mousemove", function (e) {
        if (isDragging && selectedText !== -1) {
            const mouseX = e.clientX - canvas.getBoundingClientRect().left;
            const mouseY = e.clientY - canvas.getBoundingClientRect().top;

            textInputs[selectedText].x = mouseX - offsetX;
            textInputs[selectedText].y = mouseY - offsetY;

            redraw_canvas();
            drawTexts();
        }
    });

    // Event listener for canvas release
    canvas.addEventListener("mouseup", function () {
        isDragging = false;
    });

    function redraw_canvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
        drawTexts();
    }

    function drawTexts() {
        textInputs.forEach(({ text, x, y, color }) => {
            drawText(text, x, y, color);
        });
    }

    function drawText(text, x, y, color) {
        context.fillStyle = color;
        context.font = "20px Arial";
        context.fillText(text, x, y);
    }

    function measureTextDimensions(textInput) {
        context.font = "20px Arial";
        const metrics = context.measureText(textInput.text);
        textInput.width = metrics.width;
        textInput.height = 20; // Assuming the font size is 20px
    }

    function isTextClicked(mouseX, mouseY, textInput) {
        const clickPaddingX = 5; // Increase this value for larger clickable area in width
        const clickPaddingY = 10; // Increase this value for larger clickable area in height

        return (
            mouseX > textInput.x - clickPaddingX &&
            mouseX < textInput.x + textInput.width + clickPaddingX &&
            mouseY > textInput.y - clickPaddingY &&
            mouseY < textInput.y + textInput.height + clickPaddingY
        );
    }
// Event listener for download button
const uploadButton = document.getElementById("uploadButton");
uploadButton.addEventListener("click", function () {
    const imageData = canvas.toDataURL("image/png");
    const content_name = document.getElementById("content_name").value;
    const is_meme = 1;
    alert("Attempting to upload content.");
    // Send image data to server
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
        // Handle the response as needed
        console.log(response);
    })
    .catch(error => console.error('Error:', error));
});
</script>