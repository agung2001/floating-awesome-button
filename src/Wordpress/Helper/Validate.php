<?php

namespace Fab\Wordpress\Helper;

!defined( 'WPINC ' ) or die;

/**
 * Add extra layer for wordpress functions
 *
 * @package    Fab
 * @subpackage Fab\Wordpress
 */

trait Validate {

    /**
     * Wordpress sanitize script
     * @return mixed    Return sanitized values
     */
    public function sanitize($type, $value, $args = []){
        if($type=='key') return sanitize_key($value);
        elseif($type=='filename') return sanitize_file_name($value);
        elseif($type=='text' || $type=='int') return sanitize_text_field($value);
        elseif($type=='email') return sanitize_email($value);
        elseif($type=='html') {
            $value = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $value);
            return preg_replace('#<style(.*?)>(.*?)</style>#is', '', $value);
        }
    }

    /**
     * Validate $_POST Params
     * @var     array   $_POST      $_POST parameters
     * @var     array   $default    Default value config
     * @return  bool    Validation result
     */
    public function validateParams($params, $default, $validated = true){
        foreach($default as $index => $key){
            if(!isset($params[$key]) && !is_array($key)){ $validated = false; break; }
            if(is_array($key)) $validated = $this->validateParams($params[$index], $key, $validated);
        }
        return $validated;
    }

    /**
     * Sanitize $_POST Params
     * @var     array   Field sanitize params
     * @var     array   $post      $_POST parameters
     * @var     array   $get       $_GET parameters
     * @return  bool    Validation result
     */
    public function sanitizeParams($params, $default, $results = []){
        foreach($default as $key => $type){
            $results[$key] = (isset($params[$key])) ? $params[$key] : '';
            if(is_array($results[$key])) $results[$key] = $this->sanitizeParams($results[$key], $default[$key], []);
            else $results[$key] = $this->sanitize($type, $results[$key]);
        }
        return $results;
    }

}