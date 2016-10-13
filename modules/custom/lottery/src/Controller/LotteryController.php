<?php

namespace Drupal\lottery\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LotteryController.
 *
 * @package Drupal\lottery\Controller
 */
class LotteryController extends ControllerBase {

  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index(Request $request) {
    $code = $request->request->get('code',false);
    $data = [];
    $storage = \Drupal::entityTypeManager()->getStorage('prize_keys');
    $id = $storage->getQuery()
        ->condition('status',0)
        ->condition('code',$code)
        ->range(0,1)
        ->execute();

    if(!count($id)){
      $data = [
        'error' => true,
        'message' => $this->t('The code is invalid')
      ];
    } else {

      $storage_t = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
          $ids_t = $storage_t->getQuery()
              ->condition('vid', 'transactions')
              ->condition('field_cod', $code)
              ->range(0, 1)
              ->execute();

          $package = $storage_t->loadMultiple($ids_t);

          $test = array_values($package)[0];

          $date = date_create($test->field_end_date->value);
          $date_t = date('Y-m-d H:i:s');
          $date_end = date_format($date,"Y-m-d H:i:s");
          
          if($date_t > $date_end){
            
            $data = [
              'error' => true,
              'message' => $this->t('Sorry, but this Lottery Code has expired')
            ];

          }else{
      
      $prize_key = $storage->load(array_values($id)[0]);
      $package_id = $prize_key->package_id->entity->id();
      $storage = \Drupal::entityTypeManager()->getStorage('prize');

      $ids = $storage->getQuery()
          ->condition('package_id',$package_id)
          ->sort('gold_value','asc')
          ->execute();
      $prizes = $storage->loadMultiple($ids);

      $win = $this->generate_prize($prizes);

      $prize_key->status->value = 1;
      $prize_key->prize_id[0]->target_id = $win['id'];
      $prize_key->save();

      $data = [
        'error' => false,
        'message' => $this->t('You have won '.$win['name'].' equal to '.$win['amount']),
        'image'   => $win['image']
      ];  
          }
    }
    return $this->send_response($data,200);
  }

  private function generate_prize($prizes){

      $total = 0;
      $array_result = [];
      $const = 10000;

      foreach($prizes as $key => $item){
          $total++;
          $array_result[] = [
            'id' => $item->id(),
            'name' => $item->name->value,
            'image' => $item->image->entity->url(),
            'amount' => $item->gold_value->value.'M',
            'min' => $total,
            'max' => $total+(int)($const/$item->gold_value->value),
          ];
        $total+= (int)($const/$item->gold_value->value);
      }

      $random = mt_rand(1, $total);
      $result = false;
      foreach ($array_result as $item) {
          if ($random >= $item['min'] && $random <= $item['max']) {
              $result = $item;
              break;
          }
      }

      return $result;
  }

  private function send_response($data,$code){
    $response = new Response();
    $response->setStatusCode($code);
    $response->setContent(json_encode($data));
    $response->headers->add(['Content-Type' =>'application/json']);

    return $response;
  }

}
