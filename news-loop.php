<?php
/**
Template Name: 
 */
get_header();
?>
<style type="text/css">
<!--
#news .news{width: 116px; float: left; margin: 35px 30px 0 0;}

#news .center{text-align: center; margin: 0px 0 15px;; padding: 0px;}

#news .center img{box-shadow: 0px 2px 2px #d2d2d2; -moz-box-shadow: 0px 2px 2px #d2d2d2; -webkit-box-shadow: 0px 2px 2px #d2d2d2; border: 3px solid #fff;}

#news .news-title{font-size: 14px; font-weight: 700; text-align: center; margin: 3px 0 0; padding: 0px;}

#news .company{font-size: 12px; font-style: italic; text-align: center; margin: 0px; padding: 0px;}

#news .tooltip {background: #111; color: #fff; width: 200px; padding: 20px; margin: 0 5px 20px;}
-->
</style>

<div id="main-col">
<?php
suffusion_page_navigation();
suffusion_before_begin_content();
?>
	<div id="content">
<?php
global $post;
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$original_post = $post;
		do_action('suffusion_before_post', $post->ID, 'blog', 1);
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<?php suffusion_after_begin_post(); ?>
<div class="entry-container fix">
	<div class="entry fix">
    <!-- -->
    
    	<div class="centered-content-wrapper fix">
			<div class="centered-content">
    
				
				

<div id="newss">
<div class="wrap">
<?php
$args = array( 'post_type' => 'new', 'posts_per_page' => 6 );
$loop = new WP_Query( $args );
if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
$data = get_post_meta( $loop->post->ID, 'new', true );
$user_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($loop->post->ID), 'new-thumb');
?>    
    <div class="news">
        <p class="center"><img class="frame" src="<?php echo $user_image_url[0] ?>" title="<?php echo get_the_content(); ?>" alt="<?php echo get_the_title(); ?>" /></p>
        <p class="news-title"><?php echo get_the_title(); ?></p>
        <p class="company"><?php echo $data[ 'position' ]; ?></p>
    </div>
<?php
endwhile; 
endif; ?>

</div>
</div>
                
                
                
                
			</div>
		</div>
<?php 
//$selected_value = simple_fields_get_post_value(get_the_id(), "Color of box", true);

if( class_exists("simple_fields") ):

/*	$field_group_values = simple_fields_fieldgroup("campo_fila");
	//print_r($field_group_values);
	 if(is_array($field_group_values) ) : 
		foreach ($colors as $value) {
			echo "$value <br>";
		}
		echo  "<h3 class=\"subheader\"><i>".$field_group_values["slug_subtitulo"]."</i></h3>";
	  endif;
	*/  
	  $repeatable_field_values = simple_fields_values("fila_contenido,fila_color");
		foreach ($repeatable_field_values as $values) {
			echo '<div class="centered-content-wrapper fix" style="background-color:#'. $values["fila_color"]. '"><div class="centered-content">';
			echo "\n<!-- fila --!><p>&nbsp;</p>\n\n" . $values["fila_contenido"] . "\n<p>&nbsp;</p>\n<!-- @end fila --!>\n\n" ;
			echo "</div></div>\n\n";
		}
  
endif;

if(is_page("guide-catalogue-draft")):
$meta = get_post_meta( get_the_ID(), "filafondo" ); 
if( get_post_meta(get_the_ID(), 'filafondo', true) ) :    
 echo '<div class="centered-content-wrapper fix" style="height:400px;
 background: url('. $meta[0] . ') -100px -200px repeat;">';
 echo "\n<!-- fila --!><p>&nbsp;</p>\n\n<!-- @end fila --!>\n\n" ;
 echo '</div>';
endif; 
endif;
?>
    
    
    
    
    <!-- -->
    </div>

<?php
	// Due to the inclusion of Ad Hoc Widgets the global variable $post might have got changed. We will reset it to the original value.
	$post = $original_post;
	suffusion_after_content();
?>
</div><!-- .entry-container -->
<?php
suffusion_before_end_post();
comments_template();
?>

		</article><!--/post -->

<?php
		do_action('suffusion_after_post', $post->ID, 'blog', 1);
	}
} 
?>
	</div>
</div>
<script type="text/javascript">// <![CDATA[
    $("#accordion").accordion();
				
				$("div.accordion").accordion({
				heightStyle: "content",
				collapsible: true,
    active: false
					})
				
				$(".current-menu-item a.current").css("color","green");
// Scroll
$('.scrollTo').on('click', function(event) {
    var target = $(this).attr('href');
    if( $(target).length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $(target).offset().top
        }, 500);
    }
});

// news
jQuery(document).ready(function(){
     
    jQuery("#news img[title]").tooltip({
 
       // tweak the position
       offset: [0, 0],
     
       // use the "slide" effect
       effect: 'slide'
     
    // add dynamic plugin with optional configuration for bottom edge
    }).dynamic({ bottom: { direction: 'down', bounce: true } });
     
});
// ]]></script>

<?php get_footer(); ?>
