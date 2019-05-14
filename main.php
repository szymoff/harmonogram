<?php
/*
Plugin Name: Accordions for Harmonogram
Description: Wtyczka umożliwiająca dodawanie zagnieżdzonych accordionów.
Version: 1.6
Author: Szymon Kaluga
Author URI: http://skaluga.pl/
*/

function add_my_stylesheet() 
{
    wp_enqueue_style( 'myCSS', plugins_url( 'harmonogram.css', __FILE__ ) );
    wp_enqueue_script( 'myJS', plugins_url( 'harmonogram.js', __FILE__ ) , array( 'jquery' ) );
}add_action('wp_enqueue_scripts', 'add_my_stylesheet'); 

add_action( 'vc_before_init', 'your_name_integrateWithVC' );
function your_name_integrateWithVC() {
 vc_map( array(
  "name" => __( "Harmonogram", "my-text-domain" ),
  "base" => "harmongram",
  "class" => "harmonogram accordion",
  "category" => __( "Content", "my-text-domain"),
//   'admin_enqueue_js' => array('harmonogram.js'),
//   'admin_enqueue_css' => array('harmonogram.css'),
  "params" => array(
    array(
    "type" => "textfield",
    "holder" => "span",
    "class" => "",
    "heading" => __( "Title", "my-text-domain" ),
    "param_name" => "title",
    "value" => __( "Default Title", "my-text-domain" ),
    "description" => __( "Title of accordion.", "my-text-domain" )
    ),
    array(
        "type" => "textfield",
        "class" => "",
        "heading" => __( "Set Hour", "my-text-domain" ),
        "param_name" => "hour",
        "value" => '8:20 - 9:00', //Default Red color
        "description" => __( "Choose text color", "my-text-domain" )
    ),
    array(
      "type" => "checkbox",
      "heading" => __( "Visible title?", "my-text-domain" ),
      "param_name" => "is_visible",
      "description" => __( "If You want to open this accordion set 'Yes'", "my-text-domain" )
  ),
    array(
      "type" => "textfield",
      "class" => "",
      "heading" => __( "Subtitle", "my-text-domain" ),
      "param_name" => "subtitle",
      "value" => 'Subtitle', //Default Red color
      "description" => __( "Set Subtitle", "my-text-domain" )
  ),
    array(
      "type" => "checkbox",
      "heading" => __( "Open this accordion?", "my-text-domain" ),
      "param_name" => "is_open",
      "description" => __( "If You want to open this accordion set 'Yes'", "my-text-domain" )
  ),
    array(
        "type" => "textarea_html",
        "holder" => "div",
        "class" => "",
        "heading" => __( "Content", "my-text-domain" ),
        "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
        "value" => __( "<p>I am test text block. Click edit button to change this text.</p>", "my-text-domain" ),
        "description" => __( "Enter your content.", "my-text-domain" )
    )
  )
 ) );
}

// [bartag title="title-value"]
add_shortcode( 'harmongram', 'harmongramfunc' );
function harmongramfunc( $atts, $content = null ) {
 extract( shortcode_atts( array(
  'title' => 'Title',
  'hour' => '8',
  'is_open' => 'false',
  'subtitle' => 'Subtitle',
  'is_visible' => 'false'
 ), $atts ) );
  
 $content = wpb_js_remove_wpautop($content, true); 
 ob_start();
 $open = ($is_open == 'false') ?  "" : "class='open open-selected'";
 $angle = ($is_open == 'false') ? "class='fa fa-angle-down'" : "class='fa fa-angle-up'";
 $visibility = ($is_visible == 'false') ? "class='hide'" : "class='subtitle'";
 // PRINT OUTPUT
 $wiget_output = "<!-- Accordion Menu [Start] --><div class='accordion-menu'><ul><li>";
 $wiget_output .= "<a ". $open . "><span class='hour'>{$hour}</span><span class='acc-title'>{$title}<i ". $angle ."></i></span><div ". $visibility ." >{$subtitle}</div></a>";
 $wiget_output .= "<div class='content'>{$content}</div>";
 $wiget_output .= "</li></ul></div><!-- Accordion Menu [End] -->";
 ob_get_clean();
 return $wiget_output;
}
include_once('updater.php');
if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
  $config = array(
    'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
    'proper_folder_name' => 'harmonogram', // this is the name of the folder your plugin lives in
    'api_url' => 'https://api.github.com/repos/szymoff/harmonogram', // the GitHub API url of your GitHub repo
    'raw_url' => 'https://raw.github.com/szymoff/harmonogram/master', // the GitHub raw url of your GitHub repo
    'github_url' => 'https://github.com/szymoff/harmonogram', // the GitHub url of your GitHub repo
    'zip_url' => 'https://github.com/szymoff/harmonogram/zipball/master', // the zip url of the GitHub repo
    'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
    'requires' => '4.5', // which version of WordPress does your plugin require?
    'tested' => '4.9', // which version of WordPress is your plugin tested up to?
    'readme' => 'README.md', // which file to use as the readme for the version number
    'access_token' => '', // Access private repositories by authorizing under Appearance > GitHub Updates when this example plugin is installed
  );
  new WP_GitHub_Updater($config);
}
?>