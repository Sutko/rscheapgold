<?php

namespace Drupal\orderlist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\lottery\Entity\PrizeKeys;
use Drupal\orderlist\Entity\DefaultEntity;

/**
 * Class DefaultController.
 *
 * @package Drupal\orderlist\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Order_data.
   *
   * @return string
   *   Return Hello string.
   */
  public function order_data() {

     $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

   
        \Drupal::logger('orderlist')->notice($_POST['provisionAmount']);

        \Drupal::logger('orderlist')->notice('deleted',$_POST);

        $amount = $_POST['amount']." ".$_POST['currency'];
    
    DefaultEntity::create([
                      'date' => $_POST['orderCreatedAt'],
                      'order_id' => $_POST['userOrderId'],
                      'transaction_id' => $_POST['transactionId'],
                      'ip_address' => $ipaddress,
                      'customer' => 'sutko94@gmail.com',
                      'amount' => $amount,
                      'fee' => $_POST['provisionAmount'],
                      'character_name' => "tr",
                      'payment_method' => 'Paypal',
                      'payment_status' =>  $_POST['status'],
                  ])->save(); 

    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: order_data')
    ];
  }

}
