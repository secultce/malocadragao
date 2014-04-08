<?php

function get_theme_default_options() {

    // Coloquei aqui o nome e o valor padrão de cada opção que você criar

    return array(
        'social_networks' => array(
            'facebook' => 'http://facebook.com/viradacultura',
            'twitter' => 'http://twitter.com/viradacultural',
            'googleplus' => 'http://googleplus.com/viradacultural',
        )
    );
}

function theme_options_menu() {

    // Por padrão criamos uma página exclusiva para as opções desse site
    // Mas se quiser você pode colocar ela embaixo de aparencia, opções, ou o q vc quiser. O modelo para todos os casos estão comentados abaixo

    $topLevelMenuLabel = 'viradacultural';
    $page_title = 'Opções';
    $menu_title = 'Opções';

    /* Top level menu */
    add_submenu_page('theme_options', $page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    add_menu_page($topLevelMenuLabel, $topLevelMenuLabel, 'manage_options', 'theme_options', 'theme_options_page_callback_function');

    /* Menu embaixo de um menu existente */
    //add_dashboard_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_posts_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugin_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_media_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_links_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_pages_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_comments_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_plugins_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_users_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_management_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_options_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
    //add_theme_page($page_title, $menu_title, 'manage_options', 'theme_options', 'theme_options_page_callback_function');
}

function theme_options_validate_callback_function($input) {

    // Se necessário, faça aqui alguma validação ao salvar seu formulário
    return $input;
}

function theme_options_page_callback_function() {

    // Crie o formulário. Abaixo você vai ver exemplos de campos de texto, textarea e checkbox. Crie quantos você quiser
    ?>
    <div class="wrap span-20">
        <h2><?php echo __('Theme Options', 'viradacultural'); ?></h2>

        <form action="options.php" method="post" class="clear prepend-top">
    <?php settings_fields('theme_options_options'); ?>
    <?php $options = wp_parse_args(get_option('theme_options'), get_theme_default_options()); ?>

            <div class="span-20 ">

                <h3>Redes Sociais</h3>
                <p>Insira os links (com http) para as páginas da Virada nas Redes Sociais</p>
                <div class="span-6 last">


                    <label for="facebook"><strong><?php _e("Facebook", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="facebook" class="text" name="theme_options[social_networks][facebook]" value="<?php echo htmlspecialchars($options['social_networks']['facebook']); ?>" style="width: 80%"/>
                    <br/><br/>
                    <label for="twitter"><strong><?php _e("Twitter", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="twitter" class="text" name="theme_options[social_networks][twitter]" value="<?php echo htmlspecialchars($options['social_networks']['facebook']); ?>" style="width: 80%"/>
                    <br/><br/>
                    <label for="googleplus"><strong><?php _e("Google +", "viradacultural"); ?></strong></label><br/>
                    <input type="text" id="googleplus" class="text" name="theme_options[social_networks][googleplus]" value="<?php echo htmlspecialchars($options['social_networks']['googleplus']); ?>" style="width: 80%"/>
                    <br/><br/>


                </div>
                
                <h3>PDF da Programação</h3>
                <p>Coloque o link (com http) para o arquivo PDF da Programação que estará disponível para download a partir da página da Programação</p>
                <p>Para fazer upload de um arquivo, visite a seção <a href="<?php echo admin_url('media-new.php'); ?>">Mídia</a> aqui no admin.</p>
                <div class="span-6 last">


                    <label for="pdf-programacao"><strong>Link para PDF da programação</strong></label><br/>
                    <input type="text" id="pdf-programacao" class="text" name="theme_options[pdf-programacao]" value="<?php echo htmlspecialchars($options['pdf-programacao']); ?>" style="width: 80%"/>
                    

                </div>
                
                
            </div>

            <p class="textright clear prepend-top">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'viradacultural'); ?>" />
            </p>
        </form>
    </div>

<?php } 

function get_theme_option($option_name) {
    $option = wp_parse_args(
            get_option('theme_options'), get_theme_default_options()
    );
    return isset($option[$option_name]) ? $option[$option_name] : false;
}

add_action('admin_init', 'theme_options_init');
add_action('admin_menu', 'theme_options_menu');

function theme_options_init() {
    register_setting('theme_options_options', 'theme_options', 'theme_options_validate_callback_function');
}