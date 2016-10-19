<?php

namespace Drupal\orderlist;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Order List entities.
 *
 * @ingroup orderlist
 */
class DefaultEntityListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['date'] = $this->t('Date');
    $header['order_id'] = $this->t('Order ID');
    $header['transaction_id'] = $this->t('Transaction ID');
    $header['ip_address'] = $this->t('IP Address');
    $header['customer'] = $this->t('Customer');
    $header['amount'] = $this->t('Amount');
    $header['fee'] = $this->t('Fee');
    $header['character_name'] = $this->t('Character Name');
    $header['payment_method'] = $this->t('Payment Method');
    $header['payment_status'] = $this->t('Payment Status');
    $header['agent'] = $this->t('Agent');
    $header['delivered'] = $this->t('Delivered?');
    $header['profit'] = $this->t('Profit');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\orderlist\Entity\DefaultEntity */
    $row['date'] = $entity->date->value;
    $row['order_id'] = $entity->order_id->value;
    $row['transaction_id'] = $entity->transaction_id->value;
    $row['ip_address'] = $entity->ip_address->value;
    $row['customer'] = $entity->customer->value;
    $row['amount'] = $entity->amount->value;
    $row['fee'] = $entity->fee->value;
    $row['character_name'] = $entity->character_name->value;
    $row['payment_method'] = $entity->payment_method->value;
    $row['payment_status'] = $entity->payment_status->value;
    $row['agent'] = $entity->agent->value;
    $row['delivered'] = $entity->delivered->value;
    $row['profit'] = $entity->profit->value;
    
    return $row + parent::buildRow($entity);
  }

}
