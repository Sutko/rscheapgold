<?php

namespace Drupal\develop;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Feedback entity entity.
 *
 * @see \Drupal\develop\Entity\FeedbackEntity.
 */
class FeedbackEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\develop\FeedbackEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished feedback entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published feedback entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit feedback entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete feedback entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add feedback entity entities');
  }

}
