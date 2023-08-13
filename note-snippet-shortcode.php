<?php
// phpcs:disable PSR1.Files.SideEffects
/**
 * Plugin Name:     Note Snippet Shortcode by Misterdigital
 * Plugin URI:      https://github.com/eltictacdicta/note-snippet-shortcode.git
 * Description:     Adds a Note Shortcode & popup (with options for the button) to the WYSIWYG
 * Author:          Misterdigital 
 * Author URI:      http://misterdigital.es
 * Text Domain:     note-shortcode
 * Domain Path:     /languages
 * Version:         0.1
 *
 * @package         NoteShortcodeSnippet
 */



class NoteShortcodeSnippet
{
    public function __construct()
    {
        // Call the actions/hooks
        add_action('after_setup_theme', array($this, 'afterSetupThemeSnippet'));
        add_action('init', array($this, 'registerNoteShortcodeSnippet'));
    }

    /**
     * Add a Note to Tinymce, only after theme is setup
     *
     * @return void
     */
    public function afterSetupThemeSnippet()
    {
        add_action('init', function () {
            // Only execute script when user has access rights
            if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
                return;
            }

            // Only execute script when rich editing is enabled
            if (get_user_option('rich_editing') !== 'true') {
                return;
            }

            // Add the JS to the admin screen
            add_filter('mce_external_plugins', function ($plugin_array) {
                $file = plugin_dir_url(__FILE__) . '/resources/assets/js/shortcode-note-snippet.js?01';
                $plugin_array['button-shortcode-snippet'] = $file;
                return $plugin_array;
            });

            

            add_filter('mce_buttons', 'add_custom_button', 10, 2);
                function add_custom_button($mce_buttons, $editor_id) {
                    array_push($mce_buttons, 'button-shortcode-snippet');
                    return $mce_buttons;
                }
            });
    }

    /**
     * Handle the shortcode
     *
     * @return void
     */
    public function registerNoteShortcodeSnippet()
    {
        add_shortcode('button', function ($input) {
            if (!is_admin()) {
                $attr = array(
                    'pregunta' => '',
                    'respuesta' => '',
                    'url' => '#',
                    //'style' => '',
                    //'target' => '',
                    'class' => 'button',
                );

                if (!empty($input['pregunta'])) {
                    $attr['pregunta'] = $input['pregunta'];
                }

                if (!empty($input['url'])) {
                    $attr['url'] = $input['url'];
                }

                if (!empty($input['respuesta'])) {
                    $attr['respuesta'] = $input['respuesta'];
                }

                

                /*if (!empty($input['target'])) {
                    $attr['target'] = $input['target'];
                }*/

                $attr = apply_filters('wpbs_attributes', $attr);

                $html = '<a href="' . $attr['href'] . '" ';
                $html .= 'class="'.$attr['class'].' ' . $attr['size'] . ' '  . $attr['style'] . '" ';
                $html .= (!empty($attr['target'])) ? 'target="'.$attr['target'].'"' : '';
                $html .= '>'. $attr['text'] . '</a>';
                return $html;
            }
        });
    }


        

}

if (!defined('ABSPATH')) {
    exit;  // Exit if accessed directly
}

$mdNoteShortcodeSnippet = new NoteShortcodeSnippet();


add_action( 'wp_head', function () { 
    echo "
    <style>    
    .nota-snippet{     
        font-size:18px;   
        border: medium solid #999;
        line-height: 150%;
        background-color:#EDEDED;
        border-radius: 10px;
        margin:15px;
        padding:10px;
    }



    </style>
"; } );

function mostrar_nota_snippet($atts){
    $p = shortcode_atts( array (
        'pregunta' => '',
        'respuesta' => '',
        'url' => ''
      ), $atts );
    $texto = '<div class="nota-snippet"><b style="line-height: 200%;">'.$p['pregunta'].':</b>
            <br/><p>'.$p['respuesta'].'</p></div>
            <script type="application/ld+json">
            {
                  "@context": "https://schema.org/",
                  "@type": "DefinedTerm",
                  "name":  "'.$p['pregunta'].'",
                  "description": "'.$p['respuesta'].'",
                  "url": "'.$p['url'].'"
            }
            </script>
            ';

    return $texto;
}

add_shortcode('nota_snippet', 'mostrar_nota_snippet');
