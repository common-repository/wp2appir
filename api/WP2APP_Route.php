<?php

class WP2APP_Route {

	//The namespace and version for the REST SERVER
        var $my_namespace = 'mr2app/api/v';
	var $my_version   = '1';

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		$namespace = $this->my_namespace . $this->my_version;

		register_rest_route( $namespace, '/post/get'  ,
			array(
				array(
					'methods'         => WP_REST_Server::CREATABLE,
					'callback'        => array( 'WP2APP_Post', 'posts' ),
					'permission_callback'   => array( 'WP2APP_Post', 'post_permission' )
				)
			)
		);
		register_rest_route( $namespace, '/post/like'  ,
			array(
				array(
					'methods'         => WP_REST_Server::CREATABLE,
					'callback'        => array( 'WP2APP_Post', 'like' ),
					'permission_callback'   => array( 'WP2APP_Post', 'post_permission' )
				)
			)
		);
		register_rest_route( $namespace, '/post/visit'  ,
			array(
				array(
					'methods'         => WP_REST_Server::CREATABLE,
					'callback'        => array( 'WP2APP_Post', 'visit' ),
					'permission_callback'   => array( 'WP2APP_Post', 'post_permission' )
				)
			)
		);

	}

}
