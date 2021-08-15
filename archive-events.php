<?php

get_header();

pageBanner(array(
  'title' => 'All Events',
  'subtitle' => "See what's going on in our world"
));

 ?>
  <div class="container container--narrow page-section">

  
  <?php 


          //aca haria un loop sobre archives sin tener que hacer un custom query
        //   $homepageEvents = new WP_Query(array(
        //     'posts_per_page' => 2,
        //     'post_type' => 'events'

        //   ));

          while ( have_posts()) {
            the_post(); 
            get_template_part('template-parts/content', 'event' );
          
          }
           
           echo paginate_links();

           ?>

            <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events'); ?>">Check out our past events archive</a> </p>

</div>
<?php 

get_footer();

?>




