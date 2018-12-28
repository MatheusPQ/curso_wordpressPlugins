<?php

//Tem um padrão.. dar uma olhada na documentação 'Widgets API'
class Meu_widget extends WP_Widget {

    public function __construct(){
        parent::WP_Widget(false, $name = "Visite as redes sociais");
    }

    public function widget($args, $instance){

        extract($args);
        $title          = apply_filters('widget_title', $instance['title']);
        $urlFacebook    = $instance['urlFacebook']; 
        $urlTwitter     = $instance['urlTwitter']; 
        $urlInstagram   = $instance['urlInstagram'];
        $urlYoutube     = $instance['urlYoutube'];

        // Alinha nosso plugin no mesmo bloco dos outros widgets
        echo $before_widget;

            if($title){
                echo $before_widget.$title.$after_widget;
                
                echo '<a href="'.$urlFacebook.'" target="_blank"> 
                        <img src="'.plugin_dir_url(__FILE__).'images/facebook.png" alt="Facebook" width="50px"/>
                    </a>';

                echo '<a href="'.$urlTwitter.'" target="_blank">
                        <img src="'.plugin_dir_url(__FILE__).'images/twitter.png" alt="Twitter" width="50px"/>
                    </a>';
            
                echo '<a href="'.$urlInstagram.'" target="_blank">
                        <img src="'.plugin_dir_url(__FILE__).'images/instagram.png" alt="Instagram" width="50px"/>
                    </a>';
        
                echo '<a href="'.$urlYoutube.'" target="_blank">
                        <img src="'.plugin_dir_url(__FILE__).'images/youtube.png" alt="Youtube" width="50px"/>
                    </a>';
            }

        echo $after_widget;
        // =====================

    }

    public function update($new_instance, $old_instance){
        
        $instance = $old_instance;
        //strip tags remove as tags html
        $instance['title']          = wp_strip_all_tags($new_instance['title']);
        $instance['urlFacebook']    = wp_strip_all_tags($new_instance['urlFacebook']);
        $instance['urlTwitter']     = wp_strip_all_tags($new_instance['urlTwitter']);
        $instance['urlInstagram']   = wp_strip_all_tags($new_instance['urlInstagram']);
        $instance['urlYoutube']     = wp_strip_all_tags($new_instance['urlYoutube']);

        return $instance;

    }

    public function form($instance){

        $title = esc_attr($instance['title']);

        $urlFacebook    = esc_attr($instance['urlFacebook']); 
        $urlTwitter     = esc_attr($instance['urlTwitter']); 
        $urlInstagram   = esc_attr($instance['urlInstagram']);
        $urlYoutube     = esc_attr($instance['urlYoutube']);

        ?>

        <!-- USANDO '< ? php' -->
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"> <?php echo __('Título') ?> </label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('urlFacebook'); ?>"> <?php echo __('Facebook') ?> </label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('urlFacebook'); ?>" name="<?php echo $this->get_field_name('urlFacebook'); ?>" value="<?php echo $urlFacebook ?>">
        </p>

        <!-- USANDO '< ? =' não precisa do 'echo'-->
        <p>
            <label for="<?= $this->get_field_id('urlTwitter'); ?>"> <?= _e('Twitter') ?> </label>
            <input type="text" class="widefat" id="<?= $this->get_field_id('urlTwitter'); ?>" name="<?= $this->get_field_name('urlTwitter'); ?>" value="<?= $urlTwitter ?>">
        </p>

        <p>
            <label for="<?= $this->get_field_id('urlInstagram'); ?>"> <?= _e('Instagram') ?> </label>
            <input type="text" class="widefat" id="<?= $this->get_field_id('urlInstagram'); ?>" name="<?= $this->get_field_name('urlInstagram'); ?>" value="<?= $urlInstagram ?>">
        </p>

        <p>
            <label for="<?= $this->get_field_id('urlYoutube'); ?>"> <?= _e('Youtube') ?> </label>
            <input type="text" class="widefat" id="<?= $this->get_field_id('urlYoutube'); ?>" name="<?= $this->get_field_name('urlYoutube'); ?>" value="<?= $urlYoutube ?>">
        </p>

        <?php

    }

}

?>