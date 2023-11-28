<?php
    require '../config/db_connect.php';
    // Decide on number of showcase maybe 5.
    $showcase_amount = 5;
    // Accumulator to house random showcase content.
    $showcase_content = [];
    // Carousel indicator html accumulator.
    $indicator_html = '<div class="carousel-indicators">';
    //Carousel slide html accumulator.
    $slide_html = '<div class="carousel-inner">';

    // Grab community content from database to display.
    $get_community_content = 'SELECT * FROM images LEFT JOIN users ON images.userID = users.userID';
    $sql_statement = $db->prepare($get_community_content);
    $sql_statement->execute();

    $rows = $sql_statement->fetchAll(PDO::FETCH_ASSOC);
    $rows_count = count($rows);

    // Ensure we have data to prevent errors.
    // Then generate a list for the random community items to be displayed.
    if($rows_count > 0) {
        $index = 0;
        while($index < $showcase_amount) {
        $random_item = rand(0, $rows_count-1);
            if(!in_array($rows[$random_item], $showcase_content)) {
                $showcase_content[] = $rows[$random_item];
                $index+=1; 
            }
        }
    }

    // Populate the indicator and carousel based on $showcase_content.
    foreach ($showcase_content as $_index => $_content) {
        $slide_html .= '';
        if($_index == 0) {
            $indicator_html .= '<button type="button" data-bs-target="#team" data-bs-slide-to="'. $_index .'" class="active"></button>';
            $slide_html .= '<div class="carousel-item active">';
        } else {
            $indicator_html .= '<button type="button" data-bs-target="#team" data-bs-slide-to="'. $_index .'"></button>';
            $slide_html .= '<div class="carousel-item">';
        }
        $slide_html .= '
            <h3 class="text-body" id="border">'. $_content['imageName'] .'</h3>
            <p class="text-body" id="border"><i>'. $_content['username'] .'</i></p>
            <img src="images/user_images/'. $_content['img_name'] .'" alt="'. $_content['imageName'] .'" class="d-block">
        </div>';
    }
    $indicator_html .= '</div>';
    $slide_html .= '</div>';

    // Echos the corresponded, generated, html to the browser.
    echo $indicator_html;
    echo $slide_html

?>