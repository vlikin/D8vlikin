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
class LanguageForm extends SystemConfigFormBase {

  /**
   * Implements \Drupal\Core\Form\FormInterface::getFormID().
   */
  public function getFormID() {
    return 'vltest1_language';
  }

  /**
   * Implements \Drupal\Core\Form\FormInterface::buildForm().
   */
  public function buildForm(array $form, array &$form_state) {
    drupal_static_reset('language_list');
    $languages = language_list();
    $default = language_default();
    dpm($languages);
    dpm($default);
    $form['languages'] = array(
      '#languages' => $languages,
      '#language_default' => $default,
      '#type' => 'table',
      '#header' => array(
        t('Name'),
        t('Weight'),
        t('Operations'),
      ),
      '#tabledrag' => array(
        array('order', 'sibling', 'language-order-weight'),
      ),
    );
    
    foreach ($languages as $langcode => $language) {
      $form['languages'][$langcode]['#attributes']['class'][] = 'draggable';
      $form['languages'][$langcode]['name'] = array(
        '#markup' => check_plain($language->name),
      );
      $form['languages'][$langcode]['weight'] = array(
        '#type' => 'weight',
        '#title' => t('Weight for @title', array('@title' => $language->name)),
        '#title_display' => 'invisible',
        '#default_value' => $language->weight,
        '#attributes' => array(
          'class' => array('language-order-weight'),
        ),
        '#delta' => 30,
      );
      $links = array();
      $links['edit'] = array(
        'title' => t('edit'),
        'href' => 'admin/config/regional/language/edit/' . $langcode,
      );
      if ($langcode != $default->langcode) {
        $links['delete'] = array(
          'title' => t('delete'),
          'href' => 'admin/config/regional/language/delete/' . $langcode,
        );
      }
      $form['languages'][$langcode]['operations'] = array(
        '#type' => 'operations',
        '#links' => $links,
        '#weight' => 100,
      );
    }

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