<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Prize entities.
 *
 * @ingroup lottery
 */
class PrizeListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Prize ID');
    $header['name'] = $this->t('Name');
    $header['gold_value'] = 'Prize Gold';
    $header['package'] = 'Package';
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\lottery\Entity\Prize */
    $row['id'] = $entity->id();
    $row['name'] = $entity->label();
    $row['gold_value'] = $entity->gold_value->value.'M';
    $row['package'] = $entity->get('package_id')->entity ? $entity->get('package_id')->entity->name->value : ' ';
    return $row + parent::buildRow($entity);
  }

  public function getEntityIds() {
    $query = $this->getStorage()->getQuery()
        ->sort($this->entityType->getKey('id'),'desc');

    // Only add the pager if a limit is specified.
    if ($this->limit) {
      $query->pager($this->limit);
    }
    return $query->execute();
  }


}
