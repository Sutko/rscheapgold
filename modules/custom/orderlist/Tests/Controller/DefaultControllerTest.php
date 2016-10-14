<?php

namespace Drupal\orderlist\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the orderlist module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "orderlist DefaultController's controller functionality",
      'description' => 'Test Unit for module orderlist and controller DefaultController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests orderlist functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module orderlist.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
