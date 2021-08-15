<?php


add_action( 'rest_api_init', 'universityRegisterSearch');

//funcion para hacer una custom rest api
function universityRegisterSearch(){
register_rest_route( 'university/v1', 'search', array(
"methods" => WP_REST_SERVER::READABLE,
'callback' => 'universitySearchResults'

) );
}

function universitySearchResults(){
$professor = new WP_Query (array(
    'post_type' => 'professor',
)
    
);

$professorResults = array();


    while ( $professor->have_posts() ){ 
     $professor->the_post(); 
        array_push($professorResults, get_the_title());
   
         

return $professorResults;
}
 }






