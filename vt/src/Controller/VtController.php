<?php

/**
 * @file
 * Contains \Drupal\vt\Controller\VtController.
 */

namespace Drupal\vt\Controller;

use Drupal\book\BookExport;
use Drupal\book\BookManagerInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller routines for book routes.
 */
class VtController extends ControllerBase {

  /**
   * The book manager.
   *
   * @var \Drupal\book\BookManagerInterface
   */
  protected $bookManager;

  /**
   * The book export service.
   *
   * @var \Drupal\book\BookExport
   */
  protected $bookExport;

  /**
   * Constructs a BookController object.
   *
   * @param \Drupal\book\BookManagerInterface $bookManager
   *   The book manager.
   * @param \Drupal\book\BookExport $bookExport
   *   The book export service.
   */
  public function __construct() {
    
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    );
  }


  /**
   * 
   * @return type
   */
  public function filterRender() {
    $output = [];
    $output[] = [
      '#required' => TRUE,
      '#title' => 'Text',
      '#type' => 'textfield',
      '#format' => NULL,
      '#default_value' => 'test value',
    ];
    $output[] = [
      '#type' => 'text_format',
      '#cache' => FALSE,
      '#required' => TRUE,
      '#title' => 'Text',
      '#base_type' => 'textfield',
      '#format' => NULL,
      '#default_value' => 'test value',
    ];
    
    
    $output[] = [
      '#title' => 'Body',
      '#description' => '',
      '#field_parents' => [],
      '#required' => FALSE,
      '#delta' => 0,
      '#weight' => 0,
      '#type' => 'text_format',
      '#default_value' => '',
      '#rows' => 9,
      '#placeholder' => '',
      '#attributes' => [
        'class' => ['text-full'],
      ],
      '#format' => '',
      '#base_type' => 'textarea',
    ];
    
    return $output;
  }


}
