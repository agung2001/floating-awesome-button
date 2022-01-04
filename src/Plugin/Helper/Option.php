<?php

namespace Fab\Helper;

!defined( 'WPINC ' ) or die;

/**
 * Helper library for Fab plugins
 *
 * @package    Fab
 * @subpackage Fab\Includes
 */

trait Option {

    /** Transform Boolean Value */
    public function transformBooleanValue($data){
        if(is_array($data)){
            foreach($data as $key => &$value){
                if( is_array($value) ){ $value = $this->transformBooleanValue( $value ); }
                else { $value = ($value==='true' || $value==='1') ? 1 : 0; }
            }
        } else { $data = ($data==='true' || $data ==='1') ? 1 : 0; }
        return $data;
    }

}
