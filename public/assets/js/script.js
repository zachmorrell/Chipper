
const imageFileInput = document.getElementById("imageFileInput");
const canvas = document.getElementById("meme");
const topTextInput = document.getElementById("topTextInput");
const bottomTextInput = document.getElementById("bottomTextInput");

let image;

//imageFileInput.onchange = function() {
  //image.src = URL.createObjectURL(imageFileInput.files[0]);
//}

imageFileInput.addEventListener("change", (e) => {
  console.log("imageFileInput: change event triggered.");
  const imageUrl = URL.createObjectURL(e.target.files[0]);

  image = new Image();  
  image.src = imageUrl;

  image.addEventListener("load", () => {
    console.log("imageinput: change event triggered.");
    updateMemeCanvas(canvas, image, topTextInput.value, bottomTextInput.value);
    });
});

topTextInput.addEventListener("change", () => {
  console.log("toptextinput: change event triggered.");
  updateMemeCanvas(canvas, image, topTextInput.value, bottomTextInput.value);
});

bottomTextInput.addEventListener("change", () => {
  console.log("bottomtextinput: change event triggered.");
  updateMemeCanvas(canvas, image, topTextInput.value, bottomTextInput.value);
});

function updateMemeCanvas(canvas, imageFileInput, topText, bottomText) {
  const ctx = canvas.getContext("2d");
  const width = "200";
  const height = "200";
  const fontSize = Math.floor(width / 10);
  const yOffset = height / 25;

  // Update canvas background
  canvas.width = width;
  canvas.height = height;
  //ctx.drawImage(imageFileInput, 0, 0);

  // Prepare text
  ctx.strokeStyle = "black";
  ctx.lineWidth = Math.floor(fontSize / 4);
  ctx.fillStyle = "white";
  ctx.textAlign = "center";
  ctx.lineJoin = "round";
  ctx.font = `${fontSize}px sans-serif`;

  // Add top text
  ctx.textBaseline = "top";
  ctx.strokeText(topText, width / 2, yOffset);
  ctx.fillText(topText, width / 2, yOffset);

  // Add bottom text
  ctx.textBaseline = "bottom";
  ctx.strokeText(bottomText, width / 2, height - yOffset);
  ctx.fillText(bottomText, width / 2, height - yOffset);
}

function downloadImage() {
// Grab the canvas element
let canvas = document.getElementById("canvas");

/* Create a PNG image of the pixels drawn on the canvas using the toDataURL method. PNG is the preferred format since it is supported by all browsers
*/
var dataURL = canvas.toDataURL("image/png");

// Create a dummy link text
var a = document.createElement('a');
// Set the link to the image so that when clicked, the image begins downloading
a.href = dataURL;
// Specify the image filename
a.download = 'canvas-download.jpeg';
// Click on the link to set off download
a.click();
}
let download = document.getElementById('downloadBtn');
download.addEventListener('click', downloadImage);