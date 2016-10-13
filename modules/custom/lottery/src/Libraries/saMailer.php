<?php

namespace Drupal\lottery\Libraries;

class saMailer {

    public function send_code($email, $code){


        $mailManager = \Drupal::service('plugin.manager.mail');

        $module = 'lottery';
        $key = 'send_code';
        $to = $email;

        $params['message'] = "Code: ".$code;

        $langcode = 'en';
        $send = true;
        $result = $mailManager->mail($module, $transactionId,$key, $to, $langcode, $params, NULL, $send);

        if ($result['result'] !== true) {
            $message = t('There was a problem sending your email notification to @email ', array('@email' => $to));
            drupal_set_message($message, 'error');
            \Drupal::logger('lottery')->error($message);
            return;
        }

        $message = t('An email notification has been sent to @email', array('@email' => $to));
        drupal_set_message($message);
        \Drupal::logger('lottery')->notice($message);
    }

    public function send_text($email, $transactionId,$order_id, $amount,$lottery_ticket,$character, $package_mail){


        $mailManager = \Drupal::service('plugin.manager.mail');

        $module = 'lottery';
        $key = 'send_success_pay';
        $to = $email;
        if(empty($lottery_ticket)){
        $params['message'] = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Title</title>
    <img  src='http://rscheapgold.com/sites/default/files/logo_03.png' alt='success icon'>
    <div style='background: #f5f5f5; padding-bottom: 80px;' class='paymentErrorPage paymentSuccessPage'>
        <div class='corner-top'></div>
        <br>
        <h1 style='text-align: center; font-size: 50px; color: rgb(17, 17, 17); font-family: Roboto Condensed, sans-serif; font-stretch: extra-condensed; text-transform: uppercase;'>Success</h1>
            <p class='notFoundPageHeader_text' style='vertical-align:middle; text-align: center; text-transform: uppercase; font-family: Open Sans Semibold, sans-serif; font-size: 13px; color: #d2a721; margin-bottom: 30px;'>Your payment was successful</p>
        <br>
            <div class='paymentSuccessPage_info paymentSuccessInfo' style=' background: #fff; max-width: 700px; width: 100%; margin: 0 auto; padding: 0;'>

                <img  src='http://rscheapgold.com/sites/default/files/payment-success-icon.png' style='padding: 40px 0px 10px 0px; margin: 0 auto;
                display: block;' alt='success icon'>
                <h1  style='text-align: center; text-transform: uppercase; font-family: Roboto Condensed, sans-serif; font-stretch: extra-condensed; color: #111111;'>Thank you for <br> your purchase</h1>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>

                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Your order ID: </b><b style='display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$order_id."</b>
                    </div>
                </div>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>
                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Your transaction ID: </b><b style='display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$transactionId."</b>
                    </div>
                </div>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>
                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Amount: </b><b style= 'display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$amount."</b>
                    </div>
                </div>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>
                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Character name: </b><b style='display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$character."</b>
                    </div>
                </div>
                <br>
                <div class='corner-bottom'></div>
                <a style='padding: 30px 0px 70px 0px; margin: 0 auto; color: #222; font-family: Open Sans, sans-serif;  text-align: center; display: block;' href='http://rscheapgold.com/'>Go to Home Page</a>
            </div>
    </div>
            <div style='background: #f5f5f5;'>
            </div>
            </div>
    </div>
</head>
<body>

</body>
</html>
";
    }else{
        $params['message'] = "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Title</title>
    <img  src='http://rscheapgold.com/sites/default/files/logo_03.png' alt='success icon'>
    <div style='background: #f5f5f5; padding-bottom: 80px;' class='paymentErrorPage paymentSuccessPage'>
        <div class='corner-top'></div>
        <br>
        <h1 style='text-align: center; font-size: 50px; color: rgb(17, 17, 17); font-family: Roboto Condensed, sans-serif; font-stretch: extra-condensed; text-transform: uppercase;'>Success</h1>
            <p class='notFoundPageHeader_text' style='vertical-align:middle; text-align: center; text-transform: uppercase; font-family: Open Sans Semibold, sans-serif; font-size: 13px; color: #d2a721; margin-bottom: 30px;'>Your payment was successful</p>
        <br>
            <div class='paymentSuccessPage_info paymentSuccessInfo' style=' background: #fff; max-width: 700px; width: 100%; margin: 0 auto; padding: 0;'>

                <img  src='http://rscheapgold.com/sites/default/files/payment-success-icon.png' style='padding: 40px 0px 10px 0px; margin: 0 auto;
                display: block;' alt='success icon'>
                <h1  style='text-align: center; text-transform: uppercase; font-family: Roboto Condensed, sans-serif; font-stretch: extra-condensed; color: #111111;'>Thank you for <br> your purchase</h1>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>

                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Your order ID: </b><b style='display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$order_id."</b>
                    </div>
                </div>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>
                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Your transaction ID: </b><b style='display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$transactionId."</b>
                    </div>
                </div>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>
                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Amount: </b><b style= 'display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$amount."</b>
                    </div>
                </div>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>
                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Character name: </b><b style='display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$character."</b>
                    </div>
                </div>
                <br>
                <div class='paymentSuccessInfo__block' style='display: block; width: 100%;'>
                    <div class='paymentSuccessInfo__label' style='font-size: 15px; font-family: Open Sans, sans-serif;'>
                        <b style='display: inline-block; width: 50%; margin-right: -4px; text-align: right;'>Lottery ticket: </b><b style='display: inline-block; width: 50%; margin-right: -4px; color: #93938a;'>".$lottery_ticket.$package_mail."</b>
                        <br>
                        <p style='text-align: center; font-size: 10px; color: #93938a;'>
                        <b> [Lottery code is valid for 24 hours]</b></p>
                    </div>

                        </div>
                <div class='corner-bottom'></div>
                <a style='padding: 30px 0px 70px 0px; margin: 0 auto; color: #222; font-family: Open Sans, sans-serif;  text-align: center; display: block;' href='http://rscheapgold.com/'>Go to Home Page</a>
            </div>
    </div>
            <div style='background: #f5f5f5;'>
            </div>
            </div>
    </div>
</head>
<body>

</body>
</html>
";
    }
        $langcode = 'en';
        $send = true;
        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);

        if ($result['result'] !== true) {
            $message = t('There was a problem sending your email notification to @email ', array('@email' => $to));
            drupal_set_message($message, 'error');
            \Drupal::logger('lottery')->error($message);
            return;
        }

        $message = t('An email notification has been sent to @email', array('@email' => $to));
        drupal_set_message($message);
        \Drupal::logger('lottery')->notice($message);
    }


}