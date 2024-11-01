<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_config_role
{
    function __construct()
    {
        $this->config_role();
    }
    function config_role()
    {
        $role = get_role( 'administrator' );
            if( ! $role->has_cap( 'manage_hami' ) ) {
            $role->add_cap( 'manage_hami' );
        }
        //remove_role( 'designer1' );
        add_role( 'designer1', __(
            'اپلیکیشن موبایل حامی' ),
            array(
                'read' => true, // true allows this capability
                'manage_hami'=>true,
                'edit_posts' => true, // Allows user to edit their own posts
                'edit_pages' => true, // Allows user to edit pages
                'edit_others_posts' => true, // Allows user to edit others posts not just their own
                'edit_others_pages' => true,
                'create_posts' => true, // Allows user to create new posts
                'manage_categories' => true, // Allows user to manage post categories
                'publish_posts' => true, // Allows the user to publish, otherwise posts stays in draft mode
                'edit_themes' => false, // false denies this capability. User can’t edit your theme
                'install_plugins' => false, // User cant add new plugins
                'update_plugin' => false, // User can’t update any plugins
                'update_core' => false, // user cant perform core updates
                'upload_files' => true
            )
        );
    }
}