<?php

namespace Drupal\develop\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'FeedbackBlock' block.
 *
 * @Block(
 *  id = "feedback_block",
 *  admin_label = @Translation("Feedback block"),
 * )
 */
class FeedbackBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\develop\Form\FeedbackForm');
    $build = [];
    $build['feedback_block'] = [
        '#cache' => ['max-age' => 0],
    ];
    $form['#attached']['library'][] = 'develop/feedback_js';
    $form['#prefix'] = '<div class="header">'.$this->t('leave your opinion about us').'</div>';
    $form['#markup'] = '<div id="message_emty_feedback">Please enter text</div>';
    return $form;
  }

}
