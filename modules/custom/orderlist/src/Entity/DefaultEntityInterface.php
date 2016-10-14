<?php

namespace Drupal\orderlist\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Order List entities.
 *
 * @ingroup orderlist
 */
interface DefaultEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Order List name.
   *
   * @return string
   *   Name of the Order List.
   */
  public function getName();

  /**
   * Sets the Order List name.
   *
   * @param string $name
   *   The Order List name.
   *
   * @return \Drupal\orderlist\Entity\DefaultEntityInterface
   *   The called Order List entity.
   */
  public function setName($name);

  /**
   * Gets the Order List creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Order List.
   */
  public function getCreatedTime();

  /**
   * Sets the Order List creation timestamp.
   *
   * @param int $timestamp
   *   The Order List creation timestamp.
   *
   * @return \Drupal\orderlist\Entity\DefaultEntityInterface
   *   The called Order List entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Order List published status indicator.
   *
   * Unpublished Order List are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Order List is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Order List.
   *
   * @param bool $published
   *   TRUE to set this Order List to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\orderlist\Entity\DefaultEntityInterface
   *   The called Order List entity.
   */
  public function setPublished($published);

}
