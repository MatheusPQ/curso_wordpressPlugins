<?php



/*
* plugin name: Newsletter Curso
* Description: Plugin de Newsletter
* Version: 1.0
* Author: Fulano Ciclano
*
*/

if(!defined('ABSPATH')){
    exit;
}

//Carrega os scripts
require_once(plugin_dir_path(__FILE__).'/includes/newsletter-scripts.php');

//Carrega a classe
require_once(plugin_dir_path(__FILE__).'/includes/newsletter-curso-class.php');

//Carrega o mailer
// require_once(plugin_dir_path(__FILE__).'/includes/newsletter-curso-mailer.php');

//Registra o widget
function register_newsletter_curso(){
    register_widget('Newsletter_Curso_Widget');
}

add_action('widgets_init', 'register_newsletter_curso');