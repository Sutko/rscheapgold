<?php

namespace Drupal\develop;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Feedback entity entities.
 *
 * @ingroup develop
 */
class FeedbackEntityListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Feedback entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\develop\Entity\FeedbackEntity */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.feedback_entity.edit_form', array(
          'feedback_entity' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

  protected function getEntityIds() {

    $query = $this->getStorage()->getQuery()
        ->sort($this->entityType->getKey('id'),'DESC');

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    $result =  $query->execute();

    return $result;
  }

}
