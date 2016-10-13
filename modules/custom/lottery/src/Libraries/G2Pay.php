<?php

namespace Drupal\lottery\Libraries;

use Drupal\Core\Routing\TrustedRedirectResponse;
use Drupal\develop\Libraries\Converter;
use GuzzleHttp\Client;

class G2Pay {

    private  $token_url         = 'https://checkout.pay.g2a.com/index/createQuote';
    private  $sandbox_token_url = 'https://checkout.test.pay.g2a.com/index/createQuote';
    private  $redirect          = 'https://checkout.pay.g2a.com/index/gateway?token=';
    private  $sandbox_redirect  = 'https://checkout.test.pay.g2a.com/index/gateway?token=';
    private  $rest_url          = 'https://pay.g2a.com/rest/transactions/';
    private  $sandbox_rest_url  = 'https://www.test.pay.g2a.com/rest/transactions/';

    private $api_hash               = '9cb7f5d2-13cc-4d74-a7de-ef544c9ce16e';
    private $sandbox_api_hash       = '3bf47295-7860-4de8-8b46-beff2d1761bb';

    private $secret                   = 'n*gWdeRtO80cyC1PV^~c$sH@ljtEj&%K^cqb54HTDH@*T@Nz~FPz$gthDZuwYr3V';
    private $sandbox_secret           = 'te1-oBV+wvMvBDEmxdm=v=?Y9bn5!AImoKaQU!GEoc^zpBZao9QX*P!8-gCtqVTS';

    private $merchant_email = 'lukassiradze@gmail.com';

    private $sandbox;
    private $order;


    public function __construct($sandbox = false){
        $this->sandbox = $sandbox;
        $this->order = random_int(1,999999999);
    }


    public function payment($request,$amount,$qty,$currency,$product,$character){
        $product_url = $request->getUriForPath('/');

        $url_failure = $request->getUriForPath('/payment/error');
        $url_ok = $request->getUriForPath('/payment/success');

        $price = $this->g2apay_round($amount) / (int)$qty;

        $character = "Character name:".$character;

        $params = array(
            'api_hash'    => $this->get_api_hash(),
            'hash'        => $this->g2apay_hash($this->g2apay_round($price)*(int)$qty,$currency),
            'order_id'    => $this->order,
            'amount'      => $this->g2apay_round($price)*(int)$qty,
            'currency'    => $currency,
            'url_failure' => $url_failure,
            'url_ok'      => $url_ok,
            'items'    => [
                [
                'id'     => $product->nid->value,
                'sku'    => $product->nid->value,
                'name'   => $product->title->value." Gold||".$character,
                'price'  => $this->g2apay_round($price),
                'amount' => $this->g2apay_round($price)*(int)$qty,
                'qty'    => $qty,
                'type'   => 'product',
                'url'    => $product_url,
              ]
            ]
        );
        /*dump($params,$this->get_secret(), $this->get_token_url());
        exit();*/
        $result = file_get_contents($this->get_token_url(), false, stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            )
        )));
        $result = $this->g2apay_decode($result);
        $token  = isset($result['token']) ?  $result['token'] : 0;

        return TrustedRedirectResponse::create($this->get_redirect_url().$token);
    }

    public function get_transaction($id){

        $guzzle = new Client(['verify'=>false,'http_errors' => false,'timeout'=>5]);

        $result = $guzzle->get($this->get_rest_url().$id,[
            'headers' => [
                'Authorization' => $this->get_api_hash().';'.$this->get_authorization_hash(),
            ]
        ]);

        if($result->getStatusCode() == 200){
            return $this->g2apay_decode($result->getBody()->getContents());
        }

        return false;
    }

 


    private function get_token_url(){
        return $this->sandbox ? $this->sandbox_token_url : $this->token_url;
    }

    private function get_redirect_url(){
        return $this->sandbox ? $this->sandbox_redirect : $this->redirect;
    }

    private function get_rest_url(){
        return $this->sandbox ? $this->sandbox_rest_url : $this->rest_url;
    }

    private function get_api_hash(){
        return $this->sandbox ? $this->sandbox_api_hash : $this->api_hash;
    }

    private function get_secret(){
        return $this->sandbox ? $this->sandbox_secret : $this->secret;
    }

    private function g2apay_hash($amount, $currency){
        return hash('sha256', $this->order.$this->g2apay_round($amount).$currency.$this->get_secret());
    }

    private function get_authorization_hash(){
        $string = $this->get_api_hash() . $this->merchant_email . $this->get_secret();

        return hash('sha256', $string);
    }

    private function g2apay_decode($data){
        return json_decode($data,1);
    }

    private function g2apay_round($amount)
    {
        return round($amount, 2);
    }

}