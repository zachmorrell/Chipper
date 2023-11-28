<!-- Main -->
<section id="main">
  <div class="container">

    <!-- Content -->
    <article class="box post">
      <a href="index.php?page=populargenerated" class="image featured"><img src="images/band.jpg" alt="Band of memes" width="500" height="500"/></a>
      <header>
        <h2>Popular Generated</h2>
        <p>Popular memes and greetings card generated from chipper and from the public</p>
      </header>
      <p>
          <div id="memeandgreetingscard" class="carousel slide" data-bs-ride="carousel">
            <?php require 'assets/scripts/carousel.php'; ?>
                  
            <!-- Left and right controls/icons -->
            <button class="carousel-control-prev" type="button" data-bs-target="#memeandgreetingscard" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#memeandgreetingscard" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
          </div>
      </p>
    </article>
  </div>
</section>