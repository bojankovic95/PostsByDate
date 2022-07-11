<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
Plugin Name: Posts By Date
PLugin URI: 
Description: 
Author: Bojan Jankovic
Autor URI:
Version: 1.0
*/

global $wp_query;
session_start();

add_action('wp_enqueue_scripts','posts_by_date_init');

function posts_by_date_init() {
    wp_enqueue_script( 'posts-by-date', plugins_url( '/js/posts-by-date.js', __FILE__ ));
}


add_action("admin_menu", "addMenuPosts");

function addMenuPosts(){
    add_menu_page("Posts By Date", "Posts By Date", 4, "posts-by-date", "postsByDate");
}

function postsByDate(){
    $check_cat = file_get_contents('category.php');
    $check_date = file_get_contents('date.php');
    $check_number = file_get_contents('number.php');

    if(!$check_cat){
        file_put_contents('category.php', '');
    }
    if(!$check_date){
        file_put_contents('date.php', '');
    }
    if(!$check_number){
        file_put_contents('number.php', '');
    }

    if(isset($_POST['submit'])){
        $category = $_POST['category'];
        $dateStart = $_POST['dateStart'];
        $number = $_POST['number'];

        file_put_contents('category.php', $category);
        file_put_contents('date.php', $dateStart);
        file_put_contents('number.php', $number);

    }

    $_SESSION['cat'] = file_get_contents('category.php');
    $_SESSION['date'] = file_get_contents('date.php');
    $_SESSION['number'] = file_get_contents('number.php');

    $cats = get_categories();
    ?>
        <form method="post">
        <label for="category">Choose a category:</label> <br>
            <select id="category" name="category">
            <option value="unset" selected disabled>-- Choose a Category --</option>
            <?php
            foreach ($cats as $c){
                ?> <option value="<?php echo $c->slug; ?>"><?php echo $c->name; ?></option> <?php
            } ?>
            </select> <br><br>
            <label for="dateStart">Choose start date:</label><br>
            <input type="date" name="dateStart"><br><br>
            <label for="number">Set number of posts to display:</label><br>
            <input type="number" name="number" value="5"><br><br>

            <?php echo 'Currently chosen options are: <br>' . 'Category: ' . $_SESSION['cat'] . ' <br> ' . 'Start Date: ' .  $_SESSION['date'] . '<br>' . 'Number Limit: ' . $_SESSION['number']; ?> 
            <br><br>
            <input type="submit" name="submit" value="Save">
        </form>
    <?php
}


function showPosts( $atts = ' ' ){
    $cat = $_SESSION['cat'];
    $date = $_SESSION['date'];
    $number = $_SESSION['number'];

    $number ? $number : 5;
    $date ? $date : '1980-1-1';

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $number,
            'tax_query' => array( 
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    =>  $cat,
                )),
            'date_query' => array(
                array(
                    'after'     => $date,
                    'inclusive' => true,
                ),
            )
        );

        $the_query = new WP_Query( $args ); 
        $counter = 0;
        if ( $the_query->have_posts() ) : ?>

            <ol id="wrapper"> <?php
                while ( $the_query->have_posts() ) : $the_query->the_post();
                     ?> <li>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <p><?php the_excerpt(); ?></p>
                            <p><?php the_date(); ?></p>
                        </li> <?php
                    $counter++;
                endwhile; ?>
            </ol> <?php
            wp_reset_postdata();

        endif;

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'tax_query' => array( 
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    =>  $cat,
                )),
        );
        $num_of_all_posts = count(get_posts($args));

        if($num_of_all_posts > $counter){
            ?> <button id="load-more">Load More</button> <?php
        }
        
}
add_shortcode("show_posts", "showPosts");

?>


