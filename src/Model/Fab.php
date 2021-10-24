<?php

namespace Fab\Model;

!defined( 'WPINC ' ) or die;

/**
* Initiate plugins
*
* @package    Fab
* @subpackage Fab/Model
*/

use Fab\Wordpress\Hook\Action;

class Fab extends Model {
    
    /** custom post type fab items to display*/
    protected $fab_to_displays = [];
    
    /** global $post */
    protected $post;
    /**
    * constructor
    * @return void
    * @var    object $plugin Plugin configuration
    * @pattern prototype
    */
    public function __construct(\Fab\Plugin $plugin){
        
        parent::__construct($plugin);
        $this->args['public'] = true;
        $this->args['publicly_queryable'] = false;
        $this->args['menu_icon'] = json_decode(FAB_PATH)->plugin_url . '/assets/img/icon.png';
        $this->args['has_archive'] = false;

        
        /** @backend - Save Metabox Setting to postmeta */
        $action = new Action();
        $action->setComponent($this);
        $action->setHook("save_post");
        $action->setCallback('metabox_save_data');
        $action->setMandatory(true);
        $action->setDescription('Save FAB Metabox Data');
        $this->hooks[] = $action;
        
    }  
    
    /**
    * Save metabox data when post is saving
    * @return void
    */
    public function metabox_save_data()
    {
        global $post;
        if( ( !empty( $post ) && $post->post_type !='fab' ) || empty($_POST['post_ID']) ) return;
        
        $post_id = $_POST['post_ID'];
        
        
        if(isset($_POST['fab_setting_field'])){
            $this->save_location_metabox($post_id);
        }
        
        
        $this->save_meta($post_id, 'fab_setting_open_in',1);
        $this->save_meta($post_id, 'fab_setting_link');
        $this->save_meta($post_id, 'fab_setting_key');            
        
        
        if(isset($_POST['fab_setting_icon_class'])){
            //set default icon class
            $icon_class = empty($_POST['fab_setting_icon_class']) ? 'fas fa-circle' : $_POST['fab_setting_icon_class'];
            $this->WP->update_post_meta($post_id, 'fab_setting_icon_class', sanitize_text_field($icon_class));
        }
        if(isset($_POST['fab_setting_type'])){
            $this->WP->update_post_meta($post_id, 'fab_setting_type', sanitize_text_field($_POST['fab_setting_type']));
        }
    }
    
    /**
    * Save metabox Location, by $_POST ['fab_setting_**']
    * @param int $post_id Current Updated Post
    * @return void
    */
    public function save_location_metabox($post_id)
    {
        $data = [];
        //dump duplicate value to prevent same location config
        $duplicate = [];
        foreach($_POST['fab_setting_field'] as $key=>$type){
            $operator = empty($_POST['fab_setting_operator'][$key])?'0':$_POST['fab_setting_operator'][$key];
            $comparator = empty($_POST['fab_setting_comparator'][$key])?'0':$_POST['fab_setting_comparator'][$key];
            $isFieldEmpty = in_array( '0',[ $type, $comparator ] );
            $isDuplicate = in_array($type.$operator.$comparator,$duplicate);
            
            if(  !$isFieldEmpty && !$isDuplicate ){
                $data[]=[
                    'type' => $type,
                    'operator' => $operator,
                    'value' => $comparator
                ];
                $duplicate[] = $type.$operator.$comparator;
            }
        }
        
        if(empty($data)){
            $this->WP->delete_post_meta($post_id, 'fab_location');
        } else {
            $this->WP->update_post_meta($post_id, 'fab_location', json_encode($data));
        }
    }
    
    /**
    * Save meta or delete it if key on $_POST not exists
    * @param int $post_id Current Updated Post
    * @param string $key post_meta key
    * @param mixed $value post_meta value, if not set, will get from $_POST[post_meta_key] value
    * @return void
    */
    public function save_meta($post_id, $key, $value = null)
    {
        
        if(isset($_POST[$key])){
            $value = null === $value ? $_POST[$key]: $value;
            $this->WP->update_post_meta($post_id, $key, sanitize_text_field( $value ));
        }
        else{
            $this->WP->delete_post_meta($post_id, $key);
        }
    }
    
    /**
    * get post meta fab_location
    * @return array  default: [{'type':'post','operator'=>'==',value:'post'}]; 
    * @param int $post_id
    */
    public function get_location($post_id)
    {
        $fab_location = json_decode(
            $this->WP->get_post_meta($post_id, 'fab_location',true),
            true
        );
        if(!empty($fab_location[0]['type'])){
            return $fab_location;
        }
        return  false;
    }
    
    /**
    * get post meta fab_setting_icon_class
    * @param $post_id
    * @return string 'fas fa-circle'
    */
    public function getIconClass($post_id)
    {
        $icon_class = $this->WP->get_post_meta($post_id, 'fab_setting_icon_class',true);
        return empty($icon_class) ? 'fas fa-circle' : $icon_class ;
    }
    
    /**
     * Get Hot Key Configuration of current post
     * @param int $post_id Post ID
     */
    public function getHotKey($post_id)
    {
        return $this->WP->get_post_meta($post_id, 'fab_setting_key',true);
    }
    
    /**
    * get post meta fab_setting_type
    * @param $post_id
    * @return string 'widget' or 'link'
    */
    public function getFabType($post_id)
    {
        return $this->WP->get_post_meta($post_id, 'fab_setting_type',true);
    }
    
    
    /**
    * get post meta fab_setting_open_in
    * @param $post_id
    * @return bool
    */
    public function getLinkBehaviour($post_id)
    {
        return $this->WP->get_post_meta($post_id, 'fab_setting_open_in',true);
    }
    
    /**
    * get post meta fab_setting_link
    * @param $post_id
    * @return bool
    */
    public function getLink($post_id)
    {
        return $this->WP->get_post_meta($post_id, 'fab_setting_link',true);
    }
    
    /**
    * Get Registered Widget From CPT Fab
    * @return array [['name'=>'..post title..','id'=>'..post ID..'],[]]
    */
    public function get_fab_widget()
    {
        
        $args = [
            'post_parent'=>0,
            'echo'=>false,
            'nopaging'=>true,
            'post_type' => $this->getName(),
            'post_status' => ['publish'],
            'meta_query' => [
                [
                    'key'     => 'fab_setting_type',
                    'value'   => ['widget','widget_content'],
                    'compare' => 'IN',
                ],
            ],
        ];
        
        
        //empty the result
        $result = [];
        $args_sorted = $this->query_sorted($args); 
        //get fab cpt
        $get_fabs = new \WP_Query( $args_sorted );
        
        if($get_fabs->have_posts()){
            while($get_fabs->have_posts()){
                $get_fabs->the_post();
                $the_post = get_post();
                $result[]=[
                    'name'=>$the_post->post_title,
                    'slug'=>$the_post->post_name,
                    'id'=>$the_post->ID,
                ];
            }
        }
        wp_reset_postdata(  );
        
        
        $args_unsorted = $this->query_unsorted($args); 
        //get fab cpt
        $get_fabs = new \WP_Query( $args_unsorted );
        if($get_fabs->have_posts()){
            while($get_fabs->have_posts()){
                $get_fabs->the_post();
                $the_post = get_post();
                $result[]=[
                    'name'=>$the_post->post_title,
                    'slug'=>$the_post->post_name,
                    'id'=>$the_post->ID,
                ];
            }
        }
        wp_reset_postdata(  );
        
        return $result;
    }
    
    /**
    * Merge WP_Query arguments with sorted post arguments
    * @param array $args WP_Query array arguments
    * @return array WP_Query array arguments
    */
    public function query_sorted(array $args)
    {
        $option = $this->WP->get_option('fab_config')->fab_order;
        
        //prevent Wordpress have_posts when no sorted posts
        $option = empty($option) ? [ 'empty' ] : $option;
        return array_merge($args,[
            'post__in'=>$option,
            'orderby' => 'post__in'
        ]);
        
    }
    
    /**
    * Merge WP_Query arguments with unsorted post arguments
    * @param array $args WP_Query array arguments
    * @return array WP_Query array arguments
    */
    public function query_unsorted(array $args)
    {
        $option = $this->WP->get_option('fab_config')->fab_order;

        //prevent Wordpress have_posts when no sorted posts
        $option = empty($option) ? [ 'empty' ] : $option;
        return array_merge($args,
        [
            'post__not_in'=>$option,
            'orderby' => 'post_date',
            'order'=>'DESC'
            ]
        );
        
    }
    
    
    /**
    * Get all status publised FAB 
    * @param string $type 'sorted|unsorted'
    * @return object \WP_Query
    */
    public function get_published_fab($type = 'sorted')
    {
        
        $args = [
            'post_parent'=>0,
            'echo'=>false,
            'nopaging'=>true,
            'post_type' => $this->getName(),
            'post_status' => ['publish'],
        ];
        if( 'unsorted' == $type ){
            $args = $this->query_unsorted($args);
        }
        else{
            $args = $this->query_sorted($args);
        }
        
        //get fab cpt
        return new \WP_Query( $args );
    }
    
    /**
    * get fab items that need to display on floating button
    * @param        object      $post          global $post
    * @return       string                  'widget' or 'link'
    */
    public function get_fab_to_display($post)
    {
        $this->post = $post;
        
        //empty the result
        $this->fab_to_displays = [];
        
        $get_fabs = $this->get_published_fab();
        if($get_fabs->have_posts()){
            // loop the fab
            while($get_fabs->have_posts())
            {
                $get_fabs->the_post();
                $fab_id = get_the_ID();
                
                
                // get post meta fab_location
                $fab_locations = $this->get_location($fab_id);
                
                //check if there are any setting on fab location
                if( $fab_locations && 0 < count($fab_locations)){
                    $this->match_by_location($fab_locations,$fab_id);
                }
                else{
                    //otherwise display on all type
                    $this->fab_to_displays[] = $this->get_fab_item($fab_id);
                    
                }
            }
        }
        //reset the query
        wp_reset_postdata( );
        
        
        $get_fabs = $this->get_published_fab('unsorted');
        if($get_fabs->have_posts()){
            // loop the fab
            while($get_fabs->have_posts())
            {
                $get_fabs->the_post();
                $fab_id = get_the_ID();
                
                
                // get post meta fab_location
                $fab_locations = $this->get_location($fab_id);
                
                //check if there are any setting on fab location
                if( $fab_locations && 0 < count($fab_locations) ){
                    $this->match_by_location($fab_locations,$fab_id);
                }
                else{
                    //otherwise display on all type
                    $this->fab_to_displays[] = $this->get_fab_item($fab_id);
                    
                }
            }
        }
        //reset the query
        wp_reset_postdata( );
        return $this->fab_to_displays;
    }

    /**
    * get fab items that need to display on order setting
    * @return       array      ['ids'=>[2,3,4],'items'=>[...fab_items...]]
    */
    public function get_fab_to_order()
    {
        //empty the result
        $this->fab_to_order = [];
        $ids = [];
        $get_fabs = $this->get_published_fab();
        if($get_fabs->have_posts()){
            // loop the fab
            while($get_fabs->have_posts())
            {
                $get_fabs->the_post();
                $fab_id = get_the_ID();
                $ids[] = $fab_id;
                $this->fab_to_order[] = $this->get_fab_item($fab_id);
                
            }
        }
        //reset the query
        wp_reset_postdata( );
        
        
        $get_fabs = $this->get_published_fab('unsorted');
        if($get_fabs->have_posts()){
            // loop the fab
            while($get_fabs->have_posts())
            {
                $get_fabs->the_post();
                $fab_id = get_the_ID();
                $ids[] = $fab_id;
                $this->fab_to_order[] = $this->get_fab_item($fab_id);
                
            }
        }
        //reset the query
        wp_reset_postdata( );
        
        return [
            'ids' => $ids,
            'items' => $this->fab_to_order
        ];
    }
    
    /** Match current displayed post by locations setting on cpt fab items
    * @param array $fab_locations post_meta 'fab_locations'
    * @param int $fab_id FAB post_id 
    * @return void
    */
    public function match_by_location(array $fab_locations, $fab_id)
    {
        
        //loop all fab locations
        foreach($fab_locations as $fab_location){
            // example content of $fab_location [{'type':'post','operator'=>'==',value:'post'}]
            if('post_type' == $fab_location['type']){
                
                // if matched by post_type, then break
                if($this->match_based_post_type( $fab_location['operator'], $fab_location['value'] , $fab_id)){
                    break;
                };
            }
            // example content of $fab_location {'type':'post','operator'=>'==',value:'post'}
            elseif('page' ==  $fab_location['type']){
                // if matched by page id, then break
                if($this->match_based_page( $fab_location['operator'],$fab_location['value'],  $fab_id)){
                    break;
                };
            }
        }
    }
    
    /** Match locations setting when current displayed content are page
    * @param string $operator '==' or '!='
    * @param int $page_id seting that saved on meta fab_locations
    * @param int $fab_id current fab id that need to display
    * @return bool
    */
    public function match_based_page( $operator, $page_id, $fab_id)
    {
        
        
        if( '==' == $operator && $this->post->ID  == $page_id){
            // push matched item to the result 
            $this->fab_to_displays[] = $this->get_fab_item($fab_id);
            return true;
        }
        else if( '!=' == $operator && $this->post->ID != $page_id){
            // push matched item to the result 
            $this->fab_to_displays[] = $this->get_fab_item($fab_id);
            return true;
        }
        return false;
    }
    
    /** Match locations setting when current displayed content type are matches
    * @param string $operator '==' or '!='
    * @param int $post_type 'post','docs','page', etc
    * @param int $fab_id current fab id that need to display
    * @return bool
    */
    public function match_based_post_type($operator,$post_type, $fab_id)
    {
        
        if( '==' == $operator && $this->post->post_type  == $post_type){
            $this->fab_to_displays[] = $this->get_fab_item($fab_id);
            return true;
            
        }
        else if('!=' == $operator && $this->post->post_type  != $post_type){
            $this->fab_to_displays[] = $this->get_fab_item($fab_id);
            return true;
        }
        return false;
    }
    /** format fab item to send to view
    * @param int $id current fab id that need to display
    * @return array [ 'icon_class'=>'','type'=>'','id'=>'',]
    */
    public function get_fab_item($id)
    {
        return [
            'icon_class'=>$this->getIconClass($id),
            'type'=>$this->getFabType($id),
            'link'=>$this->getLink($id),
            'hotkey'=>$this->getHotKey($id),
            'new_window'=>$this->getLinkBehaviour($id),
            'slug'=> get_post_field('post_name',$id),
            'id'=>$id
        ];
    }
    
    /**
    * Get Setting Type for metabox setting and Order setting
    * @return array
    */
    public function getSettingType()
    {
        return [
            'modal'=>'Modal',
            'link'=>'Link',
            'widget'=>'Widget',
            'widget_content'=>'Content + Widget',
        ];
    }
}

