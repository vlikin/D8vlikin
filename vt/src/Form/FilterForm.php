<?php
/**
 * @file
 * Contains \Drupal\example\Form\StyleguideForm.
 */

namespace Drupal\vt\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the Fake form.
 */
class FilterForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'vt_filter_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form[] = [
      '#type' => 'textfield',
      '#title' => 'Kyky',
    ];
    $form[] = [
      '#required' => TRUE,
      '#title' => 'Text',
      '#type' => 'textfield',
      '#format' => NULL,
      '#default_value' => 'test value',
    ];
    $form[] = [
      '#type' => 'text_format',
      '#cache' => FALSE,
      '#required' => TRUE,
      '#title' => 'Text',
      '#base_type' => 'textfield',
      '#format' => NULL,
      '#default_value' => 'test value',
    ];
    $form[] = [
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

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
?>