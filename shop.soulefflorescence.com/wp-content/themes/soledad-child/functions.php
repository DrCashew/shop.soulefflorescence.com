<?php
/*
 Soledad child theme functions and definitions
*/
function penci_soledad_child_scripts() {
    wp_enqueue_style( 'penci-soledad-parent-style', get_template_directory_uri(). '/style.css' );
	if ( is_rtl() ) {
		wp_enqueue_style( 'penci-soledad-rtl-style', get_template_directory_uri(). '/rtl.css' );
	}
  wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/main-child.js', array( 'jquery' ), '1.1', true );
}
add_action( 'wp_enqueue_scripts', 'penci_soledad_child_scripts', 100 );

/*
 * All custom functions go here
 */


 add_action( 'woocommerce_before_shop_loop_item_title', 'add_on_hover_shop_loop_image' ) ;

 function add_on_hover_shop_loop_image() {

     $image_id = wc_get_product()->get_gallery_image_ids()[0] ;

     if ( $image_id ) {

         echo wp_get_attachment_image( $image_id,  array('600', '600') ) ;

     } else {  //assuming not all products have galleries set

         echo wp_get_attachment_image( wc_get_product()->get_image_id(),  array('600', '600') ) ;

     }

 }

// Woocommerce checkout labels

 add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
 function custom_override_checkout_fields($fields)
  {
  unset($fields['billing']['billing_address_2']);
  $fields['billing']['billing_company']['placeholder'] = 'Business Name';
  $fields['billing']['billing_company']['label'] = 'Business Name';
  $fields['billing']['billing_first_name']['placeholder'] = 'First Name';
  $fields['shipping']['shipping_first_name']['placeholder'] = 'First Name';
  $fields['shipping']['shipping_last_name']['placeholder'] = 'Last Name';
  $fields['shipping']['shipping_company']['placeholder'] = 'Company Name';
  $fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
  $fields['billing']['billing_address_1']['placeholder'] = 'House number and street';
  $fields['billing']['billing_postcode']['placeholder'] = 'Postal Code/Zip';
  $fields['billing']['billing_city']['placeholder'] = 'City';
  $fields['billing']['billing_email']['placeholder'] = 'Email Address ';
  $fields['billing']['billing_phone']['placeholder'] = 'Phone ';
  return $fields;
  }


  /**
   * @snippet       Move / ReOrder Fields @ Checkout Page, WooCommerce version 3.0+
   * @how-to        Get CustomizeWoo.com FREE
   * @sourcecode    https://businessbloomer.com/?p=19571
   * @author        Rodolfo Melogli
   * @compatible    Woo 3.5.3
   * @donate $9     https://businessbloomer.com/bloomer-armada/
   */



  remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
  add_action( 'woocommerce_before_order_notes', 'woocommerce_order_review', 21 );

  /**
   * @snippet       Move Order Notes @ WooCommerce Checkout
   * @how-to        Get CustomizeWoo.com FREE
   * @author        Rodolfo Melogli
   * @compatible    WooCommerce 3.9
   * @donate $9     https://businessbloomer.com/bloomer-armada/
   */
    // 1. Hide default notes
    add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
    // 2. Create new billing field
    add_filter( 'woocommerce_checkout_fields' , 'bbloomer_custom_order_notes' );
    function bbloomer_custom_order_notes( $fields ) {
       $fields['billing']['new_order_notes'] = array(
          'type' => 'textarea',
          'label' => 'New Order Notes',
          'placeholder' => 'Order notes',
          'class' => array('form-row-wide'),
          'clear' => true,
          'priority' => 999,
       );
       return $fields;
    }
    // 3. Save to existing order notes

    add_action( 'woocommerce_checkout_update_order_meta', 'bbloomer_custom_field_value_to_order_notes', 10, 2 );

    function bbloomer_custom_field_value_to_order_notes( $order_id, $data ) {
       if ( ! is_object( $order_id ) ) {
          $order = wc_get_order( $order_id );
       }
       $order->set_customer_note( isset( $data['new_order_notes'] ) ? $data['new_order_notes'] : '' );
       wc_create_order_note( $order_id, $data['new_order_notes'], true, true );
       $order->save();
    }

    /**
     * @snippet       Move / ReOrder Fields @ Checkout Page, WooCommerce version 3.0+
     * @how-to        Get CustomizeWoo.com FREE
     * @sourcecode    https://businessbloomer.com/?p=19571
     * @author        Rodolfo Melogli
     * @compatible    Woo 3.5.3
     * @donate $9     https://businessbloomer.com/bloomer-armada/
     */

    add_filter( 'woocommerce_default_address_fields', 'bbloomer_reorder_checkout_fields' );

    function bbloomer_reorder_checkout_fields( $fields ) {

       // default priorities:
       // 'first_name' - 10
       // 'last_name' - 20
       // 'company' - 30
       // 'country' - 40
       // 'address_1' - 50
       // 'address_2' - 60
       // 'city' - 70
       // 'state' - 80
       // 'postcode' - 90

      // e.g. move 'company' above 'first_name':
      // just assign priority less than 10
      $fields['first_name']['priority'] = 10;
      $fields['last_name']['priority'] = 20;
      $fields['email']['priority'] = 30;
      $fields['billing_phone']['priority'] = 40;
      $fields['address_1']['priority'] = 50;
      $fields['city']['priority'] = 60;
      $fields['billing_postcode']['priority'] = 70;
      $fields['country']['priority'] = 80;

      return $fields;
    }

    add_filter( 'woocommerce_checkout_fields', 'bbloomer_remove_woo_checkout_fields' );

    function bbloomer_remove_woo_checkout_fields( $fields ) {
      // remove billing fields
      // unset($fields['billing']['billing_first_name']);
      // unset($fields['billing']['billing_last_name']);
      unset($fields['billing']['billing_company']);
      // unset($fields['billing']['billing_address_1']);
      unset($fields['billing']['billing_address_2']);
      // unset($fields['billing']['billing_city']);
      // unset($fields['billing']['billing_postcode']);
      // unset($fields['billing']['billing_country']);
      // unset($fields['billing']['billing_state']);
      // unset($fields['billing']['billing_phone']);
      // unset($fields['billing']['billing_email']);

      // remove shipping fields
      // unset($fields['shipping']['shipping_first_name']);
      // unset($fields['shipping']['shipping_last_name']);
      unset($fields['shipping']['shipping_company']);
      // unset($fields['shipping']['shipping_address_1']);
      unset($fields['shipping']['shipping_address_2']);
      // unset($fields['shipping']['shipping_city']);
      // unset($fields['shipping']['shipping_postcode']);
      // unset($fields['shipping']['shipping_country']);
      // unset($fields['shipping']['shipping_state']);
        return $fields;
    }
