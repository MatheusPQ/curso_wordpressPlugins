<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'curso_wordpress');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'root');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'q>h4-e8E*49KmjO;9;QQ-L6~V;GJhi9y<A{8F>_*wx&.)<R:4T*yAU}F|Q((?1K4');
define('SECURE_AUTH_KEY',  'K@<D@?~;T,!O8AL&KsAv4OOMs>Ph/Z,=[Dtn{g1,w0#<4V&#fEIUEbjoIq*QJc^%');
define('LOGGED_IN_KEY',    '4e=3s0hv);]!abTrhE&Mu|*.;_fXnt{ -H$.c!%$[6Qh+4rFrYL@n)ZL`yL33k@#');
define('NONCE_KEY',        '+yQ:Li%@H6W<H*=cdKqQ0~SS/C:]fa B!CU%[1h!{b8IAo&ml/mVudp3ZHjPXP.@');
define('AUTH_SALT',        'cbfHe?;5QKGS>&hGnsyZX%*z8Ng kNCGAN;//vOu<jRf7xOr3;sPa;Zp!MGGdktJ');
define('SECURE_AUTH_SALT', 'L;bw`:.k.5`<Qx=Bw`?TEB(/`6:l<g}g1_`JAotlp2l;bD.3C3WZ{r1*if|^}uNY');
define('LOGGED_IN_SALT',   'AK2!K=U)*YF[H`PmAu0v[dMre{1LJ9I1>4]Ph:%/s(~Q[ft.lsqm@|K(yKE*w$Fr');
define('NONCE_SALT',       'U,f*gq0|7J^.<z/|6UFMStV|t?#Lz+JFaBxxWwj;GHE(KmtNtp=JQvcp#ps,&B7M');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
