<?php
/*
Plugin Name: Media Unzip
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para envio de imagens zipadas
Version: 1.0
Author: Elton Oliveira
Author URI: http://meusite.com.br
Text Domain: media-unzip
License: GPL2
*/

//quando tentar acessar http://localhost/wordpress/wp-content/plugins/meu_twitter/meu_twitter.php
if(!defined('ABSPATH')) header("Location: http://localhost/wordpress");
class Media_unzip {
    private static $instance;

    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', [$this, 'start_media_file_unzip']);

    }

    public function start_media_file_unzip(){
        add_menu_page('Upload Media Zip', 'Upload Media Zip', 'manage_options', 'upload_media_zips', 'Media_unzip::upload_media_zips', '
        dashicons-media-archive', 10);
    }

    //Tipos de imagens permitidas
    public function allowed_file_types( $filetype ){
        $allowed_file_types = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
    
        if(in_array($filetype, $allowed_file_types)){
            return true;
        }

        return false;
    }

    public function upload_media_zips(){

        echo "<h3>". __("Upload de Arquivos Zip", 'media-unzip') ."</h3>";

        if(isset($_FILES['fileToUpload'])){
            //Prepara os arquivos para serem enviados para o servidor

            //Obter o diretório de upload atual
            $dir = "../wp-content/uploads".wp_upload_dir()['subdir'];

            //Usar o PHP para carregar o arquivo zip para o diretório de upload
            //Basename traz o nome do arquivo apenas, sem o caminho completo
            $target_file = $dir.'/'.basename($_FILES['fileToUpload']['name']);

            //Envia o arquivo .zip para o servidor
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$target_file);

            $file_name = basename($_FILES['fileToUpload']['name']);

            //Cria instância de um obj. utilitário zip
            $zip = new ZipArchive();

            //Abre o arquivo zip, que já está no servidor
            $res = $zip->open($target_file);

            if($res == TRUE){
                $zip->extractTo($dir);

                echo "<h3 style='color:#090'>Arquivo $file_name foi descompactado com êxito<br>".wp_upload_dir()['url']."</h3>";

                //Exibir uma mensagem com o numero de arquivos de mídia no arquivo zip

                echo "Tem ".$zip->numFiles." arquivos neste arquivo zip <br>";

                //Configuração para que as imagens apareçam na tela de mídia no painel admin
                //(afinal, não basta extrair os arquivos dentro da pasta /uploads)
                for($i = 0; $i < $zip->numFiles; $i++){
                    //Obter URL do arquivo de mídia
                    $media_file_name = wp_upload_dir()['url'].'/'.$zip->getNameindex($i);

                    //Obter tipo de arq de mídia
                    $filetype = wp_check_filetype(basename($media_file_name), null);
                    $allowed = Media_unzip::allowed_file_types($filetype['type']);

                    if($allowed){
                        //Exibir um link para usuário ver arq de upload
                        echo "<a href='".$media_file_name."' target='_blank'>".$media_file_name."</a>
                            Tipos: ".$filetype['type']."<br>
                        ";

                        //Informações dos anexos que será utilizado pela biblioteca de mídia
                        $attachment = [
                            'guid' => $media_file_name,
                            'post_mime_type' => $filetype['type'],
                            'post_title' => preg_replace('/\.[^.]+$/', '', $zip->getNameIndex($i)),
                            'post_content' => '',
                            'post_status' => 'inherit',
                        ];

                        $attach_id = wp_insert_attachment($attachment, $dir.'/'.$zip->getNameIndex($i));

                        //Metadados para o anexo
                        $attach_data = wp_generate_attachment_metadata($attach_id, $dir.'/'.$zip->getNameIndex($i));

                        wp_update_attachment_metadata($attach_id, $attach_data);
                    } else {
                        echo $zip->getNameIndex($i).' não pode ser enviado, o tipo '.$filetype['type'].' não é permitido <br>';
                    }
                }
            } else {
                echo "<h3 style='color: #f00;'> O arquivo zip não foi descompactado com êxito. </h3>";
            }

            $zip->close();
        }

        echo "<form style='margin-top:20px;' action='/wordpress/wp-admin/admin.php?page=upload_media_zips' method='POST' enctype='multipart/form-data'>
        
        Selecione o arquivo zip <input type='file' name='fileToUpload' id='fileToUpload'>
        <br>
        <input type='submit' value='Upload de arquivo ZIP' name='submit'>
        
        </form>";

    }
}

Media_unzip::getInstance();