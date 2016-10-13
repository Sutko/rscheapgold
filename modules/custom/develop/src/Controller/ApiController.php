<?php

namespace Drupal\develop\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\lottery\Entity\PrizeKeys;
use Drupal\lottery\Entity\UsersEmail;
use Drupal\lottery\Libraries\G2Pay;
use Drupal\lottery\Libraries\saMailer;
use Drupal\lottery\Libraries\SARandom;
use Drupal\taxonomy\Entity\Term;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\develop\Libraries\Converter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Cache\CacheBackendInterface;

/**
 * Class ApiController.
 *
 * @package Drupal\develop\Controller
 */
class ApiController extends ControllerBase {

  /**
   * Converted_money.
   *
   * @return string
   *   Return Hello string.
   */
  public function converted_money() {
    $currency = \Drupal::request()->get('currency','USD');
    $type     = (bool)\Drupal::request()->get('type',1);

    /* check currency */
    $converter = new Converter();
    $availacle_currency = $converter->get_available_currency();
    if(!in_array($currency,$availacle_currency)){
      $currency = 'USD';
    }

    $products = $converter->convert($currency,$type);

    return  $this->send_response(['data' => $products]);
  }

  public function get_eligible_to_win(Request $request){
      $price = (float)$request->query->get('price',0);
      $currency = $request->query->get('currency','USD');

      if($currency != 'USD'){
          $converter = new Converter();
          $price = $converter->convert_item_to_usd($currency,$price);
      }
      $from_cache = true;
      $package = \Drupal::cache()->get('packages');
      if(!$package){
          $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
          $ids = $storage->getQuery()
              ->condition('vid', 'packages')
              ->condition('field_enabled', 1)
              ->sort('field_price', 'desc')
              ->execute();
          $package = array_values($storage->loadMultiple($ids));
          \Drupal::cache()->set('packages',$package,CacheBackendInterface::CACHE_PERMANENT);
          $from_cache = false;
      }else {
          $package = $package->data;
      }
      foreach ($package as $key => $pack){
          if((float)$pack->field_price->value > (float)$price){
              unset($package[$key]);
          }
      }

     $package = array_values($package);


      if(!count($package)){
          $message = '';
      } else {

          if(count($package) == 1){
              $message = 'Eligible to win '.str_replace('Package','',$package[0]->name->value).' ticket';
          } else {
              $message = 'Eligible to win '.str_replace('Package','',$package[1]->name->value).' or '.str_replace('Package','',$package[0]->name->value).' ticket';
          }
      }


      return  $this->send_response(['message' => $message, 'from_cache' => $from_cache]);
  }

  public function get_puckage_prices(Request $request){
    $currency= $request->query->get('currency','USD');
    $data = [];

    $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
    $ids = $storage->getQuery()
        ->condition('vid','packages')
        ->sort('weight','asc')
        ->execute();

    $result = $storage->loadMultiple($ids);
    $converter = new Converter();

    foreach($result as $pack){
        $data[] = [
            'id' => $pack->id(),
            'price' =>$converter->convert_item($currency,$pack->field_price->value),
        ];
    }

    return $this->send_response($data);
  }

  public function save_currency(Request $request){
    $converter = new Converter();

    $currency = $request->query->get('currency','USD');
    $sign     = $request->query->get('sign','$');

    $availacle_currency = $converter->get_available_currency();

    if(!in_array($currency,$availacle_currency)){
      $currency = 'USD';
      $sign     = '$';
    }

    $request->getSession()->set('currency_code',$currency);
    $request->getSession()->set('currency_sign',$sign);

    return $this->send_response(['data' => 'success']);
  }

  private function send_response($data){
    $response = new Response();
    $response->setStatusCode(200);
    $response->setContent(json_encode($data));
    $response->headers->add(['Content-Type' =>'application/json']);

    return $response;
  }

  public function payment(Request $request){
    $id = $request->request->get('id',0);
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
        ->condition('type','product')
        ->condition('nid',$id)
        ->execute();
    $product = $storage->load(array_values($ids)[0]);
    if(!$product){
      throw new NotFoundHttpException('Product not Found!');
    }

    $amount = $request->request->get('total',0);
    $qty = $request->request->get('amount',0);
    $currency = $request->request->get('currency','USD');
    $character = $request->request->get('character','Enter your RSN');
    
    

    $ga2pay = new G2Pay(false);

    return $ga2pay->payment($request,$amount,$qty,$currency,$product,$character);
  }

  public function payment_success(Request $request){
      $transactionId = $request->get('transaction_id');
      $email         = $request->get('email',false);

      /* check request data */
      if(!$transactionId || !$email){
        throw new NotFoundHttpException();
      }

      $ga2pay = new G2Pay(false);
      $transaction = $ga2pay->get_transaction($transactionId);

      //dump($transaction);

      if(!$transaction){
        throw new NotFoundHttpException("Transactiom not Found!", 1);
      }

      $date_arr = explode("||", $transaction['items'][0]['name']);
      $name_product = $date_arr[0];
      $character = $date_arr[1];
      $real_character_arr = explode(":", $character);
      $character = $real_character_arr[1];
      $qty = $transaction['items'][0]['qty'];
      $qty_for_analityk = $transaction['items'][0]['qty'];
      $qty = $qty."M";
      $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
      $query = $storage->getQuery();
      $ids = $query
          ->condition('vid','transactions')
          ->condition('field_transaction',$transactionId)
          ->execute();

      $use = false;

      if(count($ids)){
          $use = true;
          $payment_db_info = $storage->load(array_values($ids)[0]);
      }

      $sum =  $transaction['amount'];
      $currency = $transaction['currency'];
      $order_id = $transaction['userOrderId'];
      $package_win = false;
      $code = '';
      
      if($currency == 'USD'){
          $payment_sum = $sum;
      } else {
          $converter = new Converter();
          $payment_sum = $converter->convert_item_to_usd($currency,$sum);
      }
      
      if(!$use) {
          /* create user or update his payment sum */
          $storage = \Drupal::entityTypeManager()->getStorage('users_email');
          $query = $storage->getQuery();
          $id = $query
              ->condition('email', $email)
              ->execute();

          if ($id) {
              $user = $storage->load(array_values($id)[0]);
              $user->sum->value = $user->sum->value + $payment_sum;
              $user->save();
          } else {
              UsersEmail::create([
                  'name' => 'Payment Users',
                  'email' => $email,
                  'sum' => $payment_sum
              ])->save();

              $query = $storage->getQuery();
              $id = $query
                  ->condition('email', $email)
                  ->execute();
              $user = $storage->load(array_values($id)[0]);
          }

          /* generate lottery ticket if user has money for it */
          $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
          $ids = $storage->getQuery()
              ->condition('vid', 'packages')
              ->condition('field_enabled', 1)
              ->condition('field_price', $payment_sum, '<=')
              ->sort('field_price', 'desc')
              ->range(0, 2)
              ->execute();

          $package = $storage->loadMultiple($ids);

          if (!$package || !count($package)) {
              $package_win = false;
              $code = false;
          } else {
              $package_win = $this->generate_puckage($package, $payment_sum);
              if ($package_win) {
                  $random = new SARandom();
                  $code = $random->generate_code(20);

                  PrizeKeys::create([
                      'code' => $code,
                      'package_id' => $package_win->tid->value,
                      'email_id' => $user->id->value,
                  ])->save();
                  $package_win = $package_win->name->value;
                  $emailer = new saMailer();
                  //$emailer->send_code($email, $code);
              }
          }
      }

      $emailer = new saMailer();
      $amount = $sum." ".$currency." ".$name_product;
      $package_mail = " [".$package_win."]";
      $emailer->send_text($email, $transactionId,$order_id, $amount,$code,$character, $package_mail);
      $emailer->send_text("delivery@rscheapgold.com", $transactionId,$order_id, $amount,$code,$character, $package_mail);

      /* ---- Begin Google Analytics  ----- */

        $items = array(
        array('sku'=>$order_id,'name'=>$name_product, 'price'=>$sum, 'quantity'=>$qty_for_analityk));

        


      /* ---- End Google Analytics  ----- */    

      $trans_name = $package_win ? $package_win : 'NoNe';
      $trans_name.=' '.$payment_sum;
      $trans_name.=' '.date('Y-m-d H:i');
      $startDate = time();
      $end_date = date('Y-m-d H:i:s', strtotime('+1 day', $startDate));
      if(!$use){
          Term::create([
              'field_transaction' => $transactionId,
              'field_date'        => date('Y-m-d H:i'),
              'field_package'     => $package_win ? $package_win : '',
              'field_cod'         => $code,
              'name'              => $trans_name,
              'field_character'   => $character,
              'field_end_date'    => $end_date,
              'vid'               => 'transactions',
          ])->save();
      } else {
          $package_win = $payment_db_info->field_package->value;
          $code        = $payment_db_info->field_cod->value;

      }
      $data = [
          'transaction_id' => $transactionId,
          'package_win'    => $package_win,
          'transaction'    => $transaction,
          'code'           => $code,
          'order_id'       => $order_id,
          'name_product'   => $name_product,
          'character'      => $character,
          'qty'            => $qty,
      ];

      return [
          '#theme'    => 'payment_success',
          '#data'      => $data
      ];
  }

  private function generate_puckage($package,$payment_sum){
      if(count($package) == 1){
        $res = $this->make_random(50);
        if($res == 1){
            return false;
        } else {
          return array_values($package)[0];
        }
      } else {
          $per = 10;
          $prize_ids = array_keys($package);
          if(in_array(29,$prize_ids) && in_array(30,$prize_ids)){
              $per = 40;
          }
          if(in_array(30,$prize_ids) && in_array(31,$prize_ids)){
              $per = 30;
          }
          if(in_array(31,$prize_ids) && in_array(32,$prize_ids)){
              $per = 20;
          }
          $res = $this->make_random($per);
          return array_values($package)[$res];
      }
  }

  private function make_random($per){
      $random = random_int(1,100);
      if($random <= $per){
          return 0;
      } else {
          return 1;
      }
  }

  public function payment_error(){
    $data = ['status' => 'Error Page!!!'];

    return [
        '#theme'    => 'payment_error',
        '#data'      => $data
    ];
  }

  public function page_not_found(){
    return [
        '#theme'    => 'page_not_found',
    ];
  }

}
