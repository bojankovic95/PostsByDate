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

add_action("admin_menu", "addMenu");

function addMenu(){
    add_menu_page("Posts By Date", "Posts By Date", 4, "posts-by-date", "postsByDate");
}

function postsByDate(){
    if(isset($_POST['submit'])){
        $category = $_POST['category'];
        $dateStart = $_POST['dateStart'];
        $number = $_POST['number'];
    }
    
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

            <input type="submit" name="submit" value="Save">
        </form>
    <?php
}
