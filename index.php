<?php
get_header(); ?>

<div class="general-page-css">
    <?php

while ( have_posts() ) :
	the_post();
    ?><h1><?php the_title(); ?></h1> 
    <div>
    <?php
    the_content();
endwhile;
?>
</div></div>

<?php

get_footer();