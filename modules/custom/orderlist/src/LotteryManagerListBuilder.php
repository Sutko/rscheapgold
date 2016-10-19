<?php

namespace Drupal\orderlist;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Lottery management entities.
 *
 * @ingroup orderlist
 */
class LotteryManagerListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Prize keys ID');
    $header['lottery_key'] = $this->t('Key');
    $header['package'] = $this->t('Package');
    $header['nicname'] = $this->t('Nicname');
    $header['name'] = $this->t('Name');
    $header['email'] = $this->t('Email');
    $header['prize'] = $this->t('Prize');
    $header['ip_address'] = $this->t('IP Address');
    $header['transaction_id'] = $this->t('Transaction ID');
    $header['delivered'] = $this->t('Delivered?');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\orderlist\Entity\LotteryManager */
    $row['id'] = $entity->id();
    $row['lottery_key'] = $entity->lottery_key->value;
    $row['package'] = $entity->package->value;
    $row['nicname'] = $entity->nicname->value;
    $row['name'] = $entity->name->value;
    $row['email'] = $entity->email->value;
    $row['prize'] = $entity->prize->value;    
    $row['ip_address'] = $entity->ip_address->value;
    $row['transaction_id'] = $entity->transaction_id->value;
    $row['delivered'] = $entity->delivered->value;
    return $row + parent::buildRow($entity);
  }

}
