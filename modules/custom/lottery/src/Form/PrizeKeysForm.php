<?php

namespace Drupal\lottery\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\lottery\Libraries\saMailer;

/**
 * Form controller for Prize keys edit forms.
 *
 * @ingroup lottery
 */
class PrizeKeysForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\lottery\Entity\PrizeKeys */
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

        $emailer = new saMailer();
        $emailer->send_code($entity->get('email_id')->entity->email->value,$entity->code->value);

        drupal_set_message($this->t('Created the %label Prize keys.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Prize keys.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.prize_keys.canonical', ['prize_keys' => $entity->id()]);
  }

}
