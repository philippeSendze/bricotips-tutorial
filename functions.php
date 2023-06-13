<?php 

// Action qui permet de charger des scripts dans notre thème

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles() 
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style(
        'theme-style', 
        get_stylesheet_directory_uri() . '/css/theme.css', 
        array(), 
        filemtime(get_stylesheet_directory() . '/css/theme.css') 
    );
    wp_enqueue_style(
        'image-titre-widget', 
        get_stylesheet_directory_uri() . '/css/widgets/image-titre-widget.css', 
        array(), 
        filemtime(get_stylesheet_directory() . '/css/widgets/image-titre-widget.css') 
    );
    wp_enqueue_style(
        'bloc-lien-image-widget', 
        get_stylesheet_directory_uri() . '/css/widgets/bloc-lien-image-widget.css', 
        array(), 
        filemtime(get_stylesheet_directory() . '/css/widgets/bloc-lien-image-widget.css') 
    );
    wp_enqueue_style(
        'banniere-titre-shortcode', 
        get_stylesheet_directory_uri() . '/css/shortcodes/banniere-titre.css', 
        array(), 
        filemtime(get_stylesheet_directory() . '/css/shortcodes/banniere-titre.css') 
    );
}

/* CHARGEMENT DES WIDGETS */

// On crée une class Widget Image_Titre_Widget dans un fichier à part pour pas surcharger le functions.php
require_once(__DIR__ . '/widgets/ImageTitreWidget.php');
require_once(__DIR__ . '/widgets/BlocLienImageWidget.php');

function register_widgets()
{
    //On enregistre le widget avec la classe Image_Titre_Widget
    register_widget('Image_Titre_Widget');

    register_widget('Bloc_Lien_Image_Widget');
}
//On demande à wordpress de charger des widget selon la fonction register_widgets()
add_action('widgets_init', 'register_widgets');

/* SHORTCODES */

add_shortcode('banniere-titre', 'banniere_titre_func');

function banniere_titre_func($atts)
{
    //Je récupère les attributs mis sur le shortcode
    $atts = shortcode_atts(array(
        'src' => '',
        'titre' => 'Titre'
    ), $atts, 'banniere-titre');

    //Je commence à récupérer le flux d'information
    ob_start();

    if ($atts['src'] != "") {
        ?>

        <div class="banniere-titre" style="background-image: url(<?= $atts['src'] ?>)">
            <h2 class="titre"><?= $atts['titre'] ?></h2>
        </div>

        <?php
    }

    //Je stocke dans la fonction $output et j'arrête de récupérer le flux d'information
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}