<?php

function shoestrap_enabled(){}

function shoestrap_remove_controls($wp_customize){
  $wp_customize->remove_control( 'header_textcolor');
}
add_action( 'customize_register', 'shoestrap_remove_controls' );

function shoestrap_get_brightness($hex) {
  // returns brightness value from 0 to 255
  // strip off any leading #
  $hex = str_replace('#', '', $hex);
  
  $c_r = hexdec(substr($hex, 0, 2));
  $c_g = hexdec(substr($hex, 2, 2));
  $c_b = hexdec(substr($hex, 4, 2));
  
  return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}

function shoestrap_adjust_brightness($hex, $steps) {
  // Steps should be between -255 and 255. Negative = darker, positive = lighter
  $steps = max(-255, min(255, $steps));
  
  // Format the hex color string
  $hex = str_replace('#', '', $hex);
  if (strlen($hex) == 3) {
      $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
  }
  
  // Get decimal values
  $r = hexdec(substr($hex,0,2));
  $g = hexdec(substr($hex,2,2));
  $b = hexdec(substr($hex,4,2));
  
  // Adjust number of steps and keep it inside 0 to 255
  $r = max(0,min(255,$r + $steps));
  $g = max(0,min(255,$g + $steps));  
  $b = max(0,min(255,$b + $steps));
  
  $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
  $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
  $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
  
  return '#'.$r_hex.$g_hex.$b_hex;
}
