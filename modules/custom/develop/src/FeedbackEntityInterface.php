<?php

namespace Drupal\develop;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Feedback entity entities.
 *
 * @ingroup develop
 */
interface FeedbackEntityInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Feedback entity name.
   *
   * @return string
   *   Name of the Feedback entity.
   */
  public function getName();

  /**
   * Sets the Feedback entity name.
   *
   * @param string $name
   *   The Feedback entity name.
   *
   * @return \Drupal\develop\FeedbackEntityInterface
   *   The called Feedback entity entity.
   */
  public function setName($name);

  /**
   * Gets the Feedback entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Feedback entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Feedback entity creation timestamp.
   *
   * @param int $timestamp
   *   The Feedback entity creation timestamp.
   *
   * @return \Drupal\develop\FeedbackEntityInterface
   *   The called Feedback entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Feedback entity published status indicator.
   *
   * Unpublished Feedback entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Feedback entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Feedback entity.
   *
   * @param bool $published
   *   TRUE to set this Feedback entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\develop\FeedbackEntityInterface
   *   The called Feedback entity entity.
   */
  public function setPublished($published);

}
