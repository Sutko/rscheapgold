<?php

namespace Drupal\orderlist\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Lottery management edit forms.
 *
 * @ingroup orderlist
 */
class LotteryManagerForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\orderlist\Entity\LotteryManager */
    $form = parent::buildForm($form, $form_state);
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
        drupal_set_message($this->t('Created the %label Lottery management.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Lottery management.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.lottery_manager.canonical', ['lottery_manager' => $entity->id()]);
  }

}
