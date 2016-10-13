<?php

namespace Drupal\lottery;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Users email entities.
 *
 * @ingroup lottery
 */
interface UsersEmailInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Users email name.
   *
   * @return string
   *   Name of the Users email.
   */
  public function getName();

  /**
   * Sets the Users email name.
   *
   * @param string $name
   *   The Users email name.
   *
   * @return \Drupal\lottery\UsersEmailInterface
   *   The called Users email entity.
   */
  public function setName($name);

  /**
   * Gets the Users email creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Users email.
   */
  public function getCreatedTime();

  /**
   * Sets the Users email creation timestamp.
   *
   * @param int $timestamp
   *   The Users email creation timestamp.
   *
   * @return \Drupal\lottery\UsersEmailInterface
   *   The called Users email entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Users email published status indicator.
   *
   * Unpublished Users email are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Users email is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Users email.
   *
   * @param bool $published
   *   TRUE to set this Users email to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\lottery\UsersEmailInterface
   *   The called Users email entity.
   */
  public function setPublished($published);

}
