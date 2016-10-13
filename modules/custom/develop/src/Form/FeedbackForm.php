<?php

namespace Drupal\develop\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\develop\Entity\FeedbackEntity;

/**
 * Class FeedbackForm.
 *
 * @package Drupal\develop\Form
 */
class FeedbackForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'feedback_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = array(
      '#type'   => 'textfield',
      '#title'  => $this->t('Your name'),
      '#placeholder' => $this->t('Your name'),
      '#maxlength' => 64,
      '#size' => 64,
    );
    $form['text'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Text'),
      '#placeholder' => $this->t('Text'),
    );
    $form['post_feedback'] = array(
      '#type' => 'submit',
      '#value' => $this->t(''),
      '#ajax' => [
        'callback' => array($this, 'feedback_callback'),
        'event' => 'click',
        ],
      );

    $form['feedback_submit'] = array(
      '#markup' => '<div id="submit_feedback">Post Feedback</div>',
      );

    $form['message_feedback'] = array(
      '#markup' => '<div id="message_feedback">Thank you for your Feedback</div>',
      );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $name = trim($form_state->getValue('name'));
    $text = trim($form_state->getValue('text'));

    /* Validate name */
    if(!$name){
      $form_state->setErrorByName('name','The Name field is required');
    }
    if (strlen($name) < 3) {
        $form_state->setErrorByName('name', $this->t('The Name is too short. Please enter a full Name.'));
    }

    /* Validate Text */
    if(!$text){
      $form_state->setErrorByName('text','The Text field is required');
    }
    if (strlen($text) < 3) {
      $form_state->setErrorByName('text', $this->t('The Text is too short. Please enter a full Text.'));
    }
  }



  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = trim($form_state->getValue('name'));
    $text = trim($form_state->getValue('text'));

    $feedback = FeedbackEntity::create([
      'name' => $name,
      'text' => $text,
    ]);
    $feedback->save();
    
  }

  public function feedback_callback(array &$form, FormStateInterface $form_state){

    $status_messages = array('#type' => 'status_messages');
    $text = \Drupal::service('renderer')->render($status_messages);
    return $text;

  }

}
