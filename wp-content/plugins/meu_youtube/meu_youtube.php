<?php
/*
Plugin Name: Meu Youtube
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para exibir botão de inscrição
Version: 1.0
Author: Fulano Ciclano
Author URI: http://meusite.com.br
Text Domain: meu-youtube
License: GPL2
*/

/*

Também é possível adicionar o shortcode no fonte do wordpress! Por exemplo, no arquivo footer.php (antes de wp_footer()):

echo do_shortcode('[youtube canal="nome-do-canal"]');

*/

class Meu_youtube {
  private static $instance;

  public static function getInstance() {
    if (self::$instance == NULL) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {
    add_shortcode('youtube', [$this, 'youtube']);
  }

  public function youtube( $parametros ){
      $a = shortcode_atts(['canal' => ''], $parametros);
      $canal = $a['canal'];

      return '
      <script src="https://apis.google.com/js/platform.js"></script>

      <div class="g-ytsubscribe" data-channel="'.$canal.'" data-layout="default" data-count="default"></div>
      ';
  }
}

Meu_youtube::getInstance();