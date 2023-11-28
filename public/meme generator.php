<!-- Main -->
<section id="main">
    <div class="container">
        <!-- Content -->
        <article class="box post">
            <header>
                <h2>Meme Generator</h2>
                <p>Create and Build your own memes.
                <br>Browse and upload a template image that is 600px by 600px. Choose the text color, enter custom text, then click 'add text'.  Click and drag to move the text or click the 'remove text' button to remove the text.
                </p>
            </header>
            <input type="file" id="imageUpload" accept="image/*">

            <div class="textInputsContainer">
            <label for="textColor">Text Color: </label>
            <input type="color" id="textColor" value="#000000">
            <br>
            <input type="text" id="textInput" class="textInput" placeholder="Enter text for your meme.">
            <br>
            <button id="addTextButton" class="addTextButton">Add Text</button>
            <button id="removeTextButton" class="removeTextButton">Remove Text</button>
            <br><br><canvas id="canvas"></canvas>
            </div>
            <?php if(isset($_SESSION["username"])){
            echo '<br><br><label for="content_name">Content Name:</label><input type="text" id="content_name" class="textInput" placeholder="Name your creation"><br><br><button id="uploadButton">Upload your meme</button>';
            }
            ?>
        </article>
    </div>
</section>

<?php include 'assets/scripts/generator.php'; ?>