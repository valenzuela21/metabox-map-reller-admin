<?php
namespace App;

class AdminMetabox{

    public function __construct()
    {

        add_action( 'add_meta_boxes', [$this,'quizbook_agregar_metaboxes'] );
        add_action('admin_enqueue_scripts', [$this,'style_script_metabox_admin'], 10, 1);
    }

    public function style_script_metabox_admin(){
        wp_enqueue_style('style_css_admin_metabox', plugins_url('./../assets/css/adminmetabox.css', __FILE__) );
        wp_enqueue_style('material_icons_vuetify', 'https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css' );
        wp_enqueue_style('material_mincss_vuetify', plugins_url('./../assets/css/viutify.css', __FILE__) );
    }

    public function quizbook_agregar_metaboxes(){
        /* Postype type product, post, page or personalized*/
        /* Position metabox of Type String: normal, side or avanced */

        add_meta_box( 'quizbook_meta_box', 'Ubicación de Tenderos', [$this, 'content_metabox_admin'], array('product_telollevo'), 'normal', 'high', null );
    }

    public function content_metabox_admin(){
        wp_enqueue_script( 'baseplugin-adminmetabox' );

        if(!empty($_GET['post'])){
             echo "<div id='vue-metaboxes-app'></div>";
        }else{
             echo "<p>".__('Publica el contenido para poder ingresar los tenderos.', 'baseplugin')."</p>";
        }


    }



}


