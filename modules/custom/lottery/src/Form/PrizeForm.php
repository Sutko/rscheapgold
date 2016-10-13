<?php

namespace Drupal\lottery\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Prize edit forms.
 *
 * @ingroup lottery
 */
class PrizeForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\lottery\Entity\Prize */
    $form = parent::buildForm($form, $form_state);
    unset($form['user_id']);
    $entity = $this->entity;

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
        drupal_set_message($this->t('Created the %label Prize.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Prize.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.prize.canonical', ['prize' => $entity->id()]);
  }

}
