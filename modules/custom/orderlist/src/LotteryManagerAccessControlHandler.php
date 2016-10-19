<?php

namespace Drupal\orderlist;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Lottery management entity.
 *
 * @see \Drupal\orderlist\Entity\LotteryManager.
 */
class LotteryManagerAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\orderlist\Entity\LotteryManagerInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished lottery management entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published lottery management entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit lottery management entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete lottery management entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add lottery management entities');
  }

}
