<?php

namespace Drupal\develop\Libraries;

use CurrencyConverter\CurrencyConverter;
use CurrencyConverter\Cache\Adapter\FileSystem;

class Converter {

    public $converter;

    public function __construct(){
        $this->converter = new CurrencyConverter();
        $cacheAdapter = new FileSystem(drupal_get_path('module','develop'). '/cache/');
        $cacheAdapter->setCacheTimeout(\DateInterval::createFromDateString('20 minutes'));
        $this->converter->setCacheAdapter($cacheAdapter);
    }

    public function convert($currency,$type){
        /* get products */
        $storage = \Drupal::entityTypeManager()->getStorage('node');
        $query = $storage->getQuery();
        $ids = $query
            ->Condition('type','product')
            ->range(0,2)
            ->execute();
        $result = $nodes = $storage->loadMultiple($ids);
        $products = [];

        foreach($result as $item){
            if($type){
                $products[] = [
                    'nid'         => $item->nid->value,
                    'price'       => $item->field_price->value
                ];
            } else {
                $products[] = [
                    'nid'         => $item->nid->value,
                    'price'       => $item->field_sell_price->value
                ];
            }
        }

        /* convert to selected currency */
        if($currency != 'USD'){

            foreach($products as $key => $item){
                $products[$key]['price'] = floor($this->converter->convert('USD',$currency,$item['price'])*100)/100;
            }
        }

        return $products;
    }

    public function convert_item($currency,$price){

        if($currency != 'USD'){
            $price = floor($this->converter->convert('USD',$currency,$price)*100)/100;
        }
        return $price;
    }

    public function convert_item_to_usd($currency,$price){
        $price = floor($this->converter->convert($currency,'USD',$price)*100)/100;
        return $price;
    }

    public function get_available_currency(){
        $availacle_currency = [];

        $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
        $query = $storage->getQuery();
        $ids = $query
            ->Condition('vid','available')
            ->execute();
        $result = $nodes = $storage->loadMultiple($ids);

        foreach($result as $item){
            $availacle_currency[] = $item->field_code->value;
        }
        return $availacle_currency;
    }

    public function get_available_currency_menu(){
        $availacle_currency = [];

        $storage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
        $query = $storage->getQuery();
        $ids = $query
            ->Condition('vid','available')
            ->sort('weight','asc')
            ->execute();
        $result = $nodes = $storage->loadMultiple($ids);
        foreach($result as $item){
            $availacle_currency[] = [
                'code' => $item->field_code->value,
                'name' => $item->name->value,
                'sign' => $item->field_currency_sign->value
            ];
        }

        return $availacle_currency;
    }
}