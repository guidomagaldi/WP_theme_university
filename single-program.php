<?php

get_header();

while(have_posts()){ 
    the_post(); 
    pageBanner();
    ?>



<div class="container container--narrow page-section">



  <div class="metabox metabox--position-up metabox--with-home-link">
    <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program') ?>"><i
          class="fa fa-home" aria-hidden="true"></i> All Programs</a> <span
        class="metabox__main"><?php the_title()?></span></p>
  </div>




  <div class="generic-content"><?php the_content() ?></div>



  <?php 
  

       
          $relatedProfessors = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby'=> 'title',
            'order' => 'ASC',
            'meta_query'=>array(
              array( 
              'key' => 'related_programs', // name of custom field
							'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
									'compare' => 'LIKE'
              )),
              
           

          )); ?>

  <?php
          
          if($relatedProfessors->have_posts()){ ?>


  <hr class="section-break">
  <h2 class="headline headline--medium"><?php echo get_the_title() ?> Professors</h2>
  <ul class="professor-cards" >
  <?php
          
          while ($relatedProfessors -> have_posts()) {
            $relatedProfessors->the_post(); ?>

  <li class="professor-card__list-item ">
    <a class="professor-card" href="<?php the_permalink()?>">
    <img src="<?php the_post_thumbnail_url('professorLandscape') ?>" alt="" class="professor-card__image">
    <span class="professor-card__name"><?php  ?><?php the_title() ?></span>
    
    
    
  </a>
</li>
  





  <?php } ?>
          </ul>

  <?php } ?>


  <!--------------- Termina y Arranca otro query ------------------>


  <?php
          wp_reset_postdata();
          $today = date('Ymd');
          $homepageEvents = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'events',
            'orderby'=> 'meta_value_num',
            'order' => 'ASC',
            'meta_key'=>'event_date',
            'meta_query'=>array(
              array(
                'key'=>'event_date',
                'compare'=>'>=',
                'value'=> $today,
                'type'=> 'numeric'
              ),
              array( 
              'key' => 'related_programs', // name of custom field
							'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
									'compare' => 'LIKE'
              )),
              
           

          )); ?>

  <?php
          
          if($homepageEvents->have_posts()){ ?>


  <hr class="section-break">
  <h2 class="headline headline--medium">Upcoming <?php echo get_the_title() ?> Events</h2>
  <?php
          while ($homepageEvents -> have_posts()) {
            $homepageEvents->the_post();


            get_template_part('template-parts/content', 'event' );

 } ?>


  <?php } ?>








</div>
<?php }

get_footer();

?>