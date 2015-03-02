<?php

/**
 * Implements hook_drush_command().
 */
function vt_drush_command() {

  $items['vt-command-1'] = array(
    'description' => 'Makes some job.',
    'aliases' => array('vtc1'),
  );

  return $items;
}

function drush_vt_command_1() {
  print "It works.";
}