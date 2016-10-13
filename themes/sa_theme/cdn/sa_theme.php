<?php
/**
 * @file
 * Bootstrap sub-theme.
 *
 * Place your custom PHP code in this file.
 */
use \Symfony\Component\HttpFoundation\Response;

 function sa_theme_preprocess_html(&$variables) {
   $path = \Drupal::service('path.current')->getPath();

   $path_args = explode('/', $path);
   if (isset($path_args[1]) && isset($path_args[2]) && ($path_args[1] == 'node') && (is_numeric($path_args[2]))) {
     $variables['attributes']['class'][] = 'page-node-' . $path_args[2];
   }
        $status = 
     $response = new Response();
     $status_code = $response->getStatusCode();
     dump($status_code);
     exit();

   if(preg_match('@HTTP/1\.[01]\x20+404@', $headers)) {
        $variables['attributes']['class'][] = 'error-404,';
   }
 }

 function sa_theme_preprocess_page_title(&$variables){

  $variables['title'] = "www";

 }
