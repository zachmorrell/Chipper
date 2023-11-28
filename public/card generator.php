<!-- Main -->
<section id="main">
    <div class="container">
        <!-- Content -->
        <article class="box post">
            <header>
                <h2>Greetings Card Generator</h2>
                <p>Create a greetings card with your own image. Select the image using browse, then click on the blank white page to add text.</p>
            </header>
            <input type="file" id="imageUpload" accept="image/*">
            <br><br>
            <p>Click on the first card to cycle through default images. Click on the second card to enter your text.</p>
            <canvas id="img_canvas" style="background-color:white;border:solid 2px;margin: 0 auto;width:600px;"></canvas>
            <canvas id="txt_canvas" style="background-color:white;border:solid 2px;margin: 0 auto;width:600px;"></canvas>

            <div class="textInputsContainer">
            <textarea id="txt_input" style="position: absolute; top: 0; left: 0; display: none;"></textarea>
            </div>
            <?php if(isset($_SESSION["username"])){
            echo '<br><br><label for="content_name">Content Name:</label><input type="text" id="content_name" class="textInput" placeholder="Name your creation"><br><br><button id="uploadButton">Upload your meme</button>';
            }
            ?>
        </article>
    </div>
</section>

<?php include 'assets/scripts/card_generator.php'; ?>