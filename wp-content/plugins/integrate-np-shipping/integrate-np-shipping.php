<?php

/**
 * Plugin Name: Integrate NP Shipping
 * Plugin URI: 
 * Description: Integrate Custom Shipping Method of Nova Poshta for WooCommerce
 * Version: 1.0.0
 * Author: Lugano
 * Author URI: http://full-chip.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /lang
 * Text Domain:
 */

if ( ! defined( 'WPINC' ) ) {

    die;

}

/*
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    function WC_Integrate_NP_Shipping_Method() {
        if ( ! class_exists( 'WC_Integrate_NP_Shipping_Method' ) ) {
            class WC_Integrate_NP_Shipping_Method extends WC_Shipping_Method {

                private $productWeight = 0.0;
                private $width = 1;
                private $height = 1;
                private $length = 1;
                private $total = 0;
                private $apiUrl = 'https://api.novaposhta.ua/v2.0/xml/';

                /**
                 * Constructor for shipping class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct() {

                    $this->id                 = 'integrate_np';
                    $this->method_title       = __( 'Novaposhta Shipping', 'integrate_np' );
                    $this->method_description = __( 'Custom Shipping Method for Novaposhta', 'integrate_np' );

                    //Primary init to load list of cities
                    $this->init();

                    //Second load
                    $this->init();

                    $this->enabled = isset( $this->settings['enabled'] ) ? $this->settings['enabled'] : 'yes';
                    $this->title = isset( $this->settings['title'] ) ? $this->settings['title'] : __( 'Novaposhta Shipping', 'integrate_np' );
                }

                /**
                 * Init settings
                 *
                 * @access public
                 * @return void
                 */
                function init() {

                    // Load the settings API
                    $this->init_form_fields();
                    $this->init_settings();

                    // Save settings in admin if we have any defined
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }

                /**
                 * Define settings field for this shipping
                 * @return void
                 */
                function init_form_fields() {

                    $city = array();

                    if (isset($this->settings['api_key'])) {

                        $raw_city = $this->getListOfCity();

                        foreach ($raw_city as $key => $value) {

                            $city[$value['city']] = $value['city'];
                        }

                    }

                    $this->form_fields = array(

                        'enabled' => array(
                            'title' => __( 'Enable', 'integrate_np' ),
                            'type' => 'checkbox',
                            'description' => __( 'Enable this shipping.', 'integrate_np' ),
                            'default' => 'yes'
                        ),

                        'title' => array(
                            'title' => __( 'Title', 'integrate_np' ),
                            'type' => 'text',
                            'description' => __( 'Title to be display on site', 'integrate_np' ),
                            'default' => __( 'Novaposhta Shipping', 'integrate_np' )
                        ),

                        'api_key' => array(
                            'title' => __( 'API key', 'integrate_np' ),
                            'type' => 'string',
                            'description' => __( 'API key for Novaposhta API', 'integrate_np' ),
                            'default' => ''
                        ),

                        'sender_city' => array(
                            'title' => __( 'City of sender', 'integrate_np' ),
                            'type' => 'select',
                            'description' => __( 'City of location of seller', 'integrate_np' ),
                            'default' => '',
                            'options' => $city
                        ),

                    );

                }

                /**
                 * Calculate price of delivery
                 * @input string $address
                 * @input mix $weight
                 * @return int
                 */
                function getQuote($address, $weight)
                {

                    foreach ( $weight as $item_id => $values ) {
                        $_product = $values['data'];
                        $this->productWeight = $this->productWeight + $_product->get_weight() * $values['quantity'];
                        $this->total = $this->total + $_product->get_price() * $values['quantity'];
                    }


                    //Check correctness of weight
                    if ($this->productWeight < 0.1) {

                        $this->productWeight = 0.1;
                    }

                    $cost = 0;

                    if ($weight) {
                        if ($this->settings['api_key'] && $this->settings['sender_city'] && isset($address) && !empty($address)) {
                            $shippingPriceData = array();
                            $warehouseResponse = $this->getDocumentPrice($address);

                            if ($warehouseResponse) {
                                $cost = (string)$warehouseResponse->data->item->Cost;
                            }
                        }
                    }
                    return $cost;
                }

                /**
                 * Make frame for request to get price
                 * @input string $city
                 * @return string | bool
                 */
                private function getDocumentPrice($city)
                {
                    $xml = '<?xml version="1.0" encoding="utf-8" ?>';
                    $xml .= '<file>';
                    $xml .= '<apiKey>' . $this->settings['api_key'] . '</apiKey>';
                    $xml .= '<modelName>InternetDocument</modelName>';
                    $xml .= '<calledMethod>getDocumentPrice</calledMethod>';
                    $xml .= '<methodProperties>';
                    $xml .= '<CitySender>' . $this->getCityRefByName(trim($this->settings['sender_city'])) . '</CitySender>';
                    $xml .= '<CityRecipient>' . $this->getCityRefByName(trim($city)) . '</CityRecipient>';
                    $xml .= '<Weight>' . $this->productWeight . '</Weight>';
                    $xml .= '<Cost>' . $this->total . '</Cost>';
                    $xml .= '<ServiceType>WarehouseWarehouse</ServiceType>';
                    $xml .= '<CargoType>Cargo</CargoType>';
                    $xml .= '</methodProperties>';
                    $xml .= '</file>';

                    $response = $this->getResult($xml);

                    if ($response) {
                        return simplexml_load_string($response);
                    } else {
                        return false;
                    }
                }

                /**
                 * Get list of cities which have Nova Poshta department
                 * @return array
                 */
                public function getListOfCity()
                {
                    $xml = '<?xml version="1.0" encoding="utf-8" ?>';
                    $xml .= '<file>';
                    $xml .= '<apiKey>' . $this->settings['api_key'] . '</apiKey>';
                    $xml .= '<modelName>Address</modelName>';
                    $xml .= '<calledMethod>getCities</calledMethod>';
                    $xml .= '</file>';

                    $response = $this->getResult($xml);

                    $json = array();

                    if ($response) {
                        $xml = simplexml_load_string($response);

                        foreach ($xml->data->item as $city) {
                            if (get_locale() == 'ru_RU') {
                                $json[] = array(
                                    'city' => (string)str_replace(array('"', "'"), '', $city->DescriptionRu),
                                );
                            } else {
                                $json[] = array(
                                    'city' => (string)str_replace(array('"', "'"), '', $city->Description),
                                );
                            }
                        }
                    }
                    return $json;
                }

                /**
                 * Get city by him reference name
                 * @input string $ref
                 * @return string
                 */
                private function getCityNameByRef($ref)
                {
                    $xml = '<?xml version="1.0" encoding="utf-8" ?>';
                    $xml .= '<file>';
                    $xml .= '<apiKey>' . $this->settings['api_key'] . '</apiKey>';
                    $xml .= '<modelName>Address</modelName>';
                    $xml .= '<calledMethod>getCities</calledMethod>';
                    $xml .= '</file>';

                    $response = $this->getResult($xml);

                    if ($response) {
                        $xml = simplexml_load_string($response);

                        foreach ($xml->data->item as $city) {
                            if ($city->Ref == $ref) {
                                if (get_locale() == 'ru_RU') {
                                   return $city->DescriptionRu;
                                } else {
                                    return $city->Description;
                                }
                            }
                        }
                    }
                    return '';
                }

                /**
                 * Get city reference by his name
                 * @input string $name
                 * @return string
                 */
                private function getCityRefByName($name)
                {
                    $xml = '<?xml version="1.0" encoding="utf-8" ?>';
                    $xml .= '<file>';
                    $xml .= '<apiKey>' . $this->settings['api_key'] . '</apiKey>';
                    $xml .= '<modelName>Address</modelName>';
                    $xml .= '<calledMethod>getCities</calledMethod>';
                    $xml .= '</file>';

                    $response = $this->getResult($xml);

                    if ($response) {
                        $xml = simplexml_load_string($response);

                        foreach ($xml->data->item as $city) {
                            if (get_locale() == 'ru_RU') {
                                $cityName = $city->DescriptionRu;
                            } else {
                                $cityName = $city->Description;
                            }
                            if ($cityName == $name) {
                                return $city->Ref;
                            }
                        }
                    }
                    return '';
                }

                /**
                 * Get list of department for certain city
                 * @input string $city
                 * @return array
                 */
                public function getWarehouses($city)
                {
                    $json = array();
                    if (isset($city) && $this->settings['api_key']) {
                        $xml = '<?xml version="1.0" encoding="utf-8" ?>';
                        $xml .= '<file>';
                        $xml .= '<apiKey>' . $this->settings['api_key'] . '</apiKey>';
                        $xml .= '<modelName>Address</modelName>';
                        $xml .= '<calledMethod>getWarehouses</calledMethod>';
                        $xml .= '<methodProperties>';
                        $xml .= '<CityRef>' . $this->getCityRefByName(trim($city)) . '</CityRef>';
                        $xml .= '</methodProperties>';
                        $xml .= '</file>';

                        $response = $this->getResult($xml);

                        if ($response) {
                            $xml = simplexml_load_string($response);

                            foreach ($xml->data->item as $warehouse) {
                                if (get_locale() == 'ru_RU') {
                                    $json[] = array(
                                        'warehouse' => (string)str_replace(array('"', "'"), '', $warehouse->DescriptionRu),
                                        'number' => (string)str_replace(array('"', "'"), '', $warehouse->Number),
                                    );
                                } else {
                                    $json[] = array(
                                        'warehouse' => (string)str_replace(array('"', "'"), '', $warehouse->Description),
                                        'number' => (string)str_replace(array('"', "'"), '', $warehouse->Number),
                                    );
                                }
                            }
                        }
                    }

                    return $json;
                }

                /**
                 * Execute request to Nova Poshta API by using CURL
                 * @input xml $request
                 * @return xml | bool
                 */
                private function getResult($request)
                {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    return $response;
                }

                /**
                 * This function is used to calculate the shipping cost. Within this function we can check for weights, dimensions and other parameters.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */
                public function calculate_shipping( $package = array() ) {

                    $shipping_method = WC()->session->get( 'chosen_shipping_methods' );
                    $weight = $package['contents'];

                    if (isset($package['destination']['city'])) {
                        $city = $package['destination']['city'];
                    } else {
                        $city = '';
                    }


                    if (($shipping_method[0] == 'integrate_np') && (strlen($city) > 2))  {
                        $cost = $this->getQuote($city, $weight);
                    } else {
                        $cost = 0;
                    }

                    if (empty($cost)) {
                       $cost = 0;
                    }

                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => $cost
                    );

                    $this->add_rate( $rate );

                }
            }
        }
    }

    add_action( 'woocommerce_shipping_init', 'WC_Integrate_NP_Shipping_Method' );
    add_action( 'wp_enqueue_scripts', 'integrate_np_init_script' );

    /*
     * Register js - script for possibility choose department on flying
     * @return void
     */
    function integrate_np_init_script() {

        wp_register_script('wp_integrate_np_shipping-script', plugins_url('js/integrate-np-shipping.js', __FILE__), array( 'jquery', 'jquery-ui-dialog' ), '20151204', true );
        wp_enqueue_script('wp_integrate_np_shipping-script');
        wp_enqueue_style( 'wp_integrate_np_shipping-style', plugins_url('css/integrate-np-shipping.css', __FILE__),false,'1.1','all');

        wp_localize_script(
            'wp_integrate_np_shipping-script',
            'dataForIntegrateNPShipping',
            array(
                'ajax'  => admin_url( 'admin-ajax.php' ),
                'security' => wp_create_nonce('wp_integrate_np_shipping-script')
            )
        );
    }

    add_action('wp_ajax_chosen_department', 'integrate_np_chosen_department');
    add_action('wp_ajax_nopriv_chosen_department', 'integrate_np_chosen_department');

    /*
     * Save chosen department inside session
     * @return json
     */
    function integrate_np_chosen_department() {


        check_ajax_referer( 'wp_integrate_np_shipping-script', 'security' );


        if (isset($_POST['department'])) {
            $title = __( 'Has chosen department', 'integrate_np' ). ': ';
            $_SESSION['department'] = sanitize_text_field($_POST['department']);
        } else {
            $title = '';
            $_SESSION['department'] =  __( 'Department has not been chosen', 'integrate_np' );
        }

        echo json_encode( array('status' => 1, 'department' => $title . $_SESSION['department']) );
        die();
    }

    add_action('wp_ajax_list_of_city', 'integrate_np_list_of_city');
    add_action('wp_ajax_nopriv_list_of_city', 'integrate_np_list_of_city');

    /*
     * Get list of city for Ukraine
     * @return json
     */
    function integrate_np_list_of_city() {


        check_ajax_referer( 'wp_integrate_np_shipping-script', 'security' );


        //Create new object of WC_Integrate_NP_Shipping_Method and get list of city that have department
        WC_Integrate_NP_Shipping_Method();

        $city = new WC_Integrate_NP_Shipping_Method();

        if (isset($city->settings['api_key'])) {
            $listcity = $city->getListOfCity();
        }   else {
            $listcity = array();
        }


        echo json_encode( array('status' => 1, 'cities' => $listcity) );
        die();
    }


    add_action('wp_ajax_list_of_department', 'integrate_np_list_of_department');
    add_action('wp_ajax_nopriv_list_of_department', 'integrate_np_list_of_department');

    /*
     * Get list of department for chosen city
     * @return json
     */
    function integrate_np_list_of_department() {


        check_ajax_referer( 'wp_integrate_np_shipping-script', 'security' );

        if (isset($_POST['city']) && strlen($_POST['city']) > 2) {

            $_SESSION['city'] = sanitize_text_field($_POST['city']);

            //Create new object of WC_Integrate_NP_Shipping_Method and get list of warehouses for current city
            WC_Integrate_NP_Shipping_Method();

            $city = new WC_Integrate_NP_Shipping_Method();

            if (isset($city->settings['api_key'])) {
                $listhouses = $city->getWarehouses(sanitize_text_field($_POST['city']));
            } else {
                $listhouses = array();
            }
        } else {
            $_SESSION['city'] = '';
            $listhouses = array();
        }

        echo json_encode( array('status' => 1, 'houses' => $listhouses) );
        die();
    }



    add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

    /*
     * Display field value on the order edit page
     * @input mixed $order
     * @return void
     */
    function my_custom_checkout_field_display_admin_order_meta($order){

        if (isset($_SESSION['department'])) {
            add_post_meta($order->id, '_integrate_np_department', $_SESSION['department'], false);
        }

        echo '<p><strong>'.__('Department of Nova Poshta', 'integrate_np').':</strong>' . get_post_meta($order->id, '_integrate_np_department', true ) . '</p>';

        if (isset($_SESSION['department'])) {
            $_SESSION['department'] = null;
        }

        $_SESSION['city'] = null;
    }

    /*
     * Add new shipping method
     * @input array
     * @return array
     */
    function add_integrate_np_shipping_method( $methods ) {
        $methods['integrate_np_shipping_method'] = 'WC_Integrate_NP_Shipping_Method';
        return $methods;
    }

    add_filter( 'woocommerce_shipping_methods', 'add_integrate_np_shipping_method' );

    /*
     * Validate order after change weight
     * @return void
     */
    function integrate_np_validate_order( $posted )   {

        $packages = WC()->shipping->get_packages();

        $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );

        if( is_array( $chosen_methods ) && in_array( 'integrate_np', $chosen_methods ) ) {

            foreach ( $packages as $i => $package ) {

                if ( $chosen_methods[ $i ] != "integrate_np" ) {

                    continue;

                }
            }
        }
    }

    add_action( 'woocommerce_review_order_before_cart_contents', 'integrate_np_validate_order' , 10 );
    add_action( 'woocommerce_after_checkout_validation', 'integrate_np_validate_order' , 10 );

    /*
     * Start new session for plugin
     * @return void
     */
    function StartIntegrateNPSession() {
        if(!session_id()) {
            session_start();
        }
    }

    add_action('init', 'StartIntegrateNPSession', 1);

    /*
     * Load language for plugin
     * @return void
     */
    function load_my_textdomain(){
        load_plugin_textdomain('integrate_np', false, 'integrate-np-shipping/i18n/language/' );
    }

    // Load language for current locale
    add_action('init', 'load_my_textdomain');

}



