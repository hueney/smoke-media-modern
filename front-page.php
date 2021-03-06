<?php get_header();

// Make an empty array to store post IDs, avoiding replicate post display
$do_not_replicate = array();

// Don't do anything unless the option is set
if (get_option('campaign_section')) {
  $cat = get_option('campaign_cat');
  $title = get_option('campaign_name');
  get_template_part('campaign-block');
  echo "<section id='campaign-block'>";
  campaign_block($cat, $title, $do_not_replicate);
  echo "</section>";
}

// Display the weather and date
info_bar();

// Display a block of posts
function headlines_section($cat, $title, &$do_not_replicate){
  // Create the WP_query and pass in $cat parameter
  $the_query = new WP_Query( array('cat' => $cat,'post_type' => array('post','live') ) );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts and set it to one
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
    echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <ul class="limited-width headline-block wow fadeIn animated" data-wow-duration="0.3s">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>4) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Display posts, conditional on $counter value
  ?>
  <?php if ($counter<3):
    //Display first two posts like so
  ?>
    <li class="headline-item wow fadeIn animated" data-wow-duration="0.3s">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </li>
  <?php elseif ($counter === 3):
    //The third post, with the opening horizontal container
  ?>
    <ul class="horizontal-list">
      <li class="horizontal-headline-item">
        <?php the_post_thumbnail('medium'); ?>
        <div>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </div>
        <a class="cover" href="<?php the_permalink(); ?>"></a>
      </li>
  <?php else:
    //The fourth/last post, with the closing horizontal container
  ?>
      <li class="horizontal-headline-item">
        <?php the_post_thumbnail('medium'); ?>
        <div>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </div>
        <a class="cover" href="<?php the_permalink(); ?>"></a>
      </li>
    </ul>
  <?php endif; ?>

  <?php
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </ul>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}

// Display a block of posts
function interview_headlines_section($cat, $title, &$do_not_replicate){
  // Create the WP_query and pass in $cat parameter
  $the_query = new WP_Query( array('cat' => $cat ) );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts and set it to one
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
    echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <ul class="headline-block wow fadeIn animated" data-wow-duration="0.3s" id="interviews">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>4) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Display posts, conditional on $counter value
  ?>
    <li class="headline-item">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </li>
  <?php
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </ul>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}


// Display a block of posts
function reviews_headlines_section($cat, $title, &$do_not_replicate){
  // Create the WP_query and pass in $cat parameter
  $the_query = new WP_Query( array('cat' => $cat, 'post_type' => array('post','live'), ) );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts and set it to one
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
    echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <ul class="limited-width headline-block wow fadeIn animted" data-wow-duration="0.3s"  id="reviews">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>5) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Display posts, conditional on $counter value
  ?>
  <?php if ($counter<3):
    //Display first two posts like so
  ?>
    <li class="horizontal-headline-item">
      <?php the_post_thumbnail('medium'); ?>
      <div>
        <h3><?php the_category(); ?> / <?php the_title(); ?></h3>
        <?php smoke_rating_headline($ID); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </li>
  <?php else:
    //The third/fourth post
  ?>
    <li class="horizontal-headline-item">
      <div>
        <h3><?php the_category(); ?> / <?php the_title(); ?></h3>
        <?php smoke_rating_headline($ID); ?>
      </div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </li>
  <?php endif; ?>

  <?php
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </ul>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}

// Display a block of posts
function comment_headlines_section($cat, $title, &$do_not_replicate){
  // Create the WP_query and pass in $cat parameter
  $the_query = new WP_Query( array('cat' => $cat, 'post_type' => array('post','live'), ) );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts and set it to one
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
    echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <ul class="limited-width headline-block wow fadeIn animated" data-wow-duration="0.3s">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>5) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Display posts, conditional on $counter value
  ?>
  <?php if ($counter<2):
    //Display first two posts like so
  ?>
    <li class="headline-item">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </li>
  <?php elseif ($counter === 2 OR $counter === 4):
    //The third post, with the opening horizontal container
  ?>
    <ul class="horizontal-list comment">
      <li class="horizontal-headline-item">
        <div>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </div>
        <a class="cover" href="<?php the_permalink(); ?>"></a>
      </li>
  <?php else:
    //The fourth/last post, with the closing horizontal container
  ?>
      <li class="horizontal-headline-item">
        <div>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </div>
        <a class="cover" href="<?php the_permalink(); ?>"></a>
      </li>
    </ul>
  <?php endif; ?>

  <?php
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </ul>
  <?php
  // What if there are no posts returned?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}

// Display a block of posts
function promoted_headlines_section($title, &$do_not_replicate){
  // Create the WP_query and pass in $cat parameter
  $the_query = new WP_Query( array('meta_key'		=> 'smoke_promoted', 'meta_value'	=> 'on', 'post_type' => array('post','live'), ) );
  if ( $the_query->have_posts() ) :
  // Create a counter variable to track number of posts and set it to one
  $counter = 1;
  // If title parameter is set, display the string as a <h2>
  if($title){
    echo "<h2 class='section-title limited-width'>" . $title . "</h2>";
  }
  // Output a container <section> element
  ?>
    <ul class="limited-width headline-block wow fadeIn animated" data-wow-duration="0.3s">
  <?php
  // Start the loop
  while ( $the_query->have_posts() ) : $the_query->the_post();
  // Save post ID as var
  $ID = get_the_ID();
  // If current post ID exists in array, skip post and continue with loop
  if (in_array($ID, $do_not_replicate)) { continue; };
  // Stop looping after fourth post
  if ($counter>4) { break; };
  // Save current post ID to array
  array_push($do_not_replicate, $ID);
  // Display posts, conditional on $counter value
  ?>
  <?php if ($counter<3):
    //Display first two posts like so
  ?>
    <li class="headline-item">
      <?php the_post_thumbnail('large'); ?>
      <h3><?php the_title(); ?></h3>
      <?php the_category(); ?>
      <div class="grad"></div>
      <a class="cover" href="<?php the_permalink(); ?>"></a>
    </li>
  <?php elseif ($counter === 3):
    //The third post, with the opening horizontal container
  ?>
    <ul class="horizontal-list">
      <li class="horizontal-headline-item">
        <?php the_post_thumbnail('medium'); ?>
        <div>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </div>
        <a class="cover" href="<?php the_permalink(); ?>"></a>
      </li>
  <?php else:
    //The fourth/last post, with the closing horizontal container
  ?>
      <li class="horizontal-headline-item">
        <?php the_post_thumbnail('medium'); ?>
        <div>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </div>
        <a class="cover" href="<?php the_permalink(); ?>"></a>
      </li>
    </ul>
  <?php endif; ?>

  <?php
  // Increase the counter with every post to keep an accurate count
  $counter++;
  // Finish looping
  endwhile;
  // Clean up after WP_Query
  wp_reset_postdata();
  // Close the container element
  ?>
    </ul>
  <?php
  // What if there are no posts $ =ed?
  else :
  ?>
  	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
  <?php endif;
}


// Retrieve the categories saved in the admin menus, if they exist, else, save the section name as a string
if (get_option('news_block')) {
  $news = get_option('news_block');
} else {
  $news = 'news';
}
if (get_option('comment_block')) {
  $comment = get_option('comment_block');
} else {
  $comment = 'comment';
}
if (get_option('interviews_block')) {
  $interviews = get_option('interviews_block');
} else {
  $interviews = 'interviews';
}
if (get_option('interviews_block')) {
  $reviews = get_option('reviews_block');
} else {
  $reviews = 'reviews';
}
if (get_option('features_block')) {
  $features = get_option('features_block');
} else {
  $features = 'features';
}
if (get_option('sports_block')) {
  $sports = get_option('sports_block');
} else {
  $sports = 'sport';
}

// Call the functions and populate the homepage
promoted_headlines_section(0, $do_not_replicate);
headlines_section($news, 'News', $do_not_replicate);
get_template_part('youtube/youtube-section');
comment_headlines_section($comment, 'Comment', $do_not_replicate);
// Output a flexbox container to place interviews and reviews side by side on larger screens
echo '<section id="interviews-reviews" class="limited-width"><aside>';
  interview_headlines_section($interviews, 'Interviews', $do_not_replicate);
echo '</aside><aside>';
  reviews_headlines_section($reviews, 'Reviews', $do_not_replicate);
echo '</aside></section>';
headlines_section($features, 'Features', $do_not_replicate);
headlines_section($sports, 'Sport', $do_not_replicate);

get_footer();
