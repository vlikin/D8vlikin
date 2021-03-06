<?php
/**
 * @file
 * Contains \Drupal\book\BookSettingsForm.
 */

namespace Drupal\vltest1;

use Drupal\system\SystemConfigFormBase;

/**
 * Configure book settings for this site.
 */
class TestForm extends SystemConfigFormBase {

  /**
   * Implements \Drupal\Core\Form\FormInterface::getFormID().
   */
  public function getFormID() {
    return 'vltest1_admin_settings';
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::buildForm().
   */
  public function buildForm(array $form, array &$form_state) {
    $types = node_type_get_names();
    $config = $this->configFactory->get('vltest1.settings');
    $form['book_allowed_types'] = array(
      '#type' => 'checkboxes',
      '#title' => t('Content types allowed in book outlines'),
      '#default_value' => $config->get('allowed_types'),
      '#options' => $types,
      '#description' => t('Users with the %outline-perm permission can add all content types.', array('%outline-perm' => t('Administer book outlines'))),
      '#required' => TRUE,
    );
    $form['book_child_type'] = array(
      '#type' => 'radios',
      '#title' => t('Content type for child pages'),
      '#default_value' => $config->get('child_type'),
      '#options' => $types,
      '#required' => TRUE,
    );
    $form['array_filter'] = array('#type' => 'value', '#value' => TRUE);

    return parent::buildForm($form, $form_state);
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::validateForm().
   */
  public function validateForm(array &$form, array &$form_state) {
    $child_type = $form_state['values']['book_child_type'];
    if (empty($form_state['values']['book_allowed_types'][$child_type])) {
      form_set_error('book_child_type', t('The content type for the %add-child link must be one of those selected as an allowed book outline type.', array('%add-child' => t('Add child page'))));
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::submitForm().
   */
  public function submitForm(array &$form, array &$form_state) {
    $allowed_types = array_filter($form_state['values']['book_allowed_types']);
    // We need to save the allowed types in an array ordered by machine_name so
    // that we can save them in the correct order if node type changes.
    // @see book_node_type_update().
    sort($allowed_types);
    $this->configFactory->get('vltest1.settings')
    // Remove unchecked types.
      ->set('allowed_types', $allowed_types)
      ->set('child_type', $form_state['values']['book_child_type'])
      ->save();

    parent::submitForm($form, $form_state);
  }
}