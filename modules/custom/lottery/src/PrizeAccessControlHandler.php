<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Prize entity.
 *
 * @see \Drupal\lottery\Entity\Prize.
 */
class PrizeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\lottery\PrizeInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished prize entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published prize entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit prize entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete prize entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add prize entities');
  }

}
