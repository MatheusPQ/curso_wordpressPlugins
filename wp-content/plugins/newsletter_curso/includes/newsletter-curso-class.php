<?php

class Newsletter_Curso_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'newsletter_curso_widget', // Base ID
			esc_html__( 'Newsletter Curso', 'ns_domain' ), // Name
			array( 'description' => esc_html__( 'Newsletter Curso', 'ns_domain' ), ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        //Aqui fica o FRONT END do widget, isto é, o que o usuário final verá!

        echo $args['before_widget']; //HTML padrão, vai alinhar o widget, etc
        echo $args['before_title'];

        if(!empty($instance['title'])){
            echo $instance['title'];
        }

        echo $args['after_title'];

        echo '
            <div id="form-msg">

            </div>
            <form id="subscriber-form" method="post" action="'.plugins_url().'/newsletter_curso/includes/newsletter-curso-mailer.php">

                <div class="form-group">
                    <label for="name">
                        Nome:
                    </label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">
                        E-mail:
                    </label>
                    <input type="text" id="email" name="email" class="form-control" required>
                </div>

                <br>

                <input type="hidden" name="recipient" value="'.$instance["recipient"].'">
                <input type="hidden" name="subject" value="'.$instance["subject"].'">
                <input type="submit" class="btn btn-primary" name="subscriber_submit" value="Inscreva-se">
            </form>
            <br>
        ';
        
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {

        $title = !empty($instance['title']) ? $instance['title'] : __('Newsletter Curso', 'ns_domain');
        $recipient = $instance['recipient'];
        $subject = !empty($instance['subject']) ? $instance['subject'] : __('Você tem um novo inscrito!', 'ns_domain');

        ?>

        <p>
            <label for="<?=$this->get_field_id('title'); ?>">

                <?= __('Título'); ?>

            </label>
            <br>
            <input 
                type="text" 
                id="<?=$this->get_field_id('title'); ?>" 
                name="<?=$this->get_field_name('title'); ?>" 
                value="<?= esc_attr($title); ?>"
            >
        </p>

        <p>
            <label for="<?=$this->get_field_id('recipient'); ?>">

                <?= __('Destinatário'); ?>

            </label>
            <br>
            <input 
                type="text" 
                id="<?=$this->get_field_id('recipient'); ?>" 
                name="<?=$this->get_field_name('recipient'); ?>" 
                value="<?= esc_attr($recipient); ?>"
            >
        </p>

        <p>
            <label for="<?=$this->get_field_id('subject'); ?>">

                <?= __('Assunto'); ?>

            </label>
            <br>
            <input 
                type="text" 
                id="<?=$this->get_field_id('subject'); ?>" 
                name="<?=$this->get_field_name('subject'); ?>" 
                value="<?= esc_attr($subject); ?>"
            >
        </p>

        <?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

        $instance = [

            'title' => (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '',
            'recipient' => (!empty($new_instance['recipient'])) ? strip_tags($new_instance['recipient']) : '',
            'subject' => (!empty($new_instance['subject'])) ? strip_tags($new_instance['subject']) : ''

        ];

        //Garante que ao digitar algo nos campos, o que foi digitado ficará salvo no campo ao clicar em 'Salvar', ou ao sair e voltar a tela de widget.
        return $instance;
	}
}