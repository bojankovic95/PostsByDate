<?php

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
    add_submenu_page("posts-by-date", "Option 1", "Opstion 2", 4, "posts1", "option1");
}

function postsByDate(){
    echo "This is the test page";
}

function posts1(){
    echo "Test subpage";
}