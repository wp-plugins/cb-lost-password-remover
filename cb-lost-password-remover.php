<?php
/*
 * Plugin Name: CB Lost Password Remover
 * Description: Removes the ability for non admin users to reset/lost password remover/ their passwords option.
 * Version: 1.1
 * Author: Md Abul Bashar
 * Author URI: http://www.codingbank.com
 */
class Password_Reset_Removed
{

  function __construct() 
  {
    add_filter( 'show_password_fields', array( $this, 'disable' ) );
    add_filter( 'allow_password_reset', array( $this, 'disable' ) );
    add_filter( 'gettext',              array( $this, 'remove' ) );
  }

  function disable() 
  {
    if ( is_admin() ) {
      $userdata = wp_get_current_user();
      $user = new WP_User($userdata->ID);
      if ( !empty( $user->roles ) && is_array( $user->roles ) && $user->roles[0] == 'administrator' )
        return true;
    }
    return false;
  }

  function remove($text) 
  {
    return str_replace( array('Lost your password?', 'Lost your password'), '', trim($text, '?') ); 
  }
}

$pass_reset_removed = new Password_Reset_Removed();
?>