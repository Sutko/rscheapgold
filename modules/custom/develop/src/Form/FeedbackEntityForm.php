<?php

namespace Drupal\develop\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Feedback entity edit forms.
 *
 * @ingroup develop
 */
class FeedbackEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\develop\Entity\FeedbackEntity */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;
    unset($form['user_id']);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Feedback entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Feedback entity.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.feedback_entity.canonical', ['feedback_entity' => $entity->id()]);
  }

}
