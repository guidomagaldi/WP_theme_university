<?php

get_header();

while(have_posts()){ 
    the_post();
    pageBanner();
    
    ?>


  <div class="container container--narrow page-section">

<?php 
//esta funcion busca el id del parent, si tiene va a ser mayor a 0 y por ende va a ser true
$theParent = (wp_get_post_parent_id($post));
if($theParent){ ?>

<div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent) ?></a> <span class="metabox__main"><?php the_title() ?></span></p>
    </div>

<?php }

?>

 
    <?php
    $hasChildren = get_pages(array(
      'child_of' => get_the_ID()
    ));
    if ($theParent or $hasChildren) { ?>

    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent) ?>"><?php echo get_the_title($theParent) ?></a></h2>
      <ul class="min-list">
        <?php
       if  ( $theParent) {
         $findChildrenOf = $theParent;
       }else {
         $findChildrenOf = get_the_id();
       }

       wp_list_pages(array(
        'title_li'=> '',
        'child_of' => $findChildrenOf ,
        'sort' => 'menu_order'

       ));





        ?>
        
      </ul>
    </div>
    <?php  } ?>

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>


<?php }

get_footer();

?>