<?php

if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class TT_Example_List_Table extends WP_List_Table {

	var $data = array();

	function __construct(){
		global $status, $page;

		//Set parent defaults
		parent::__construct( array(
			'singular'  => 'movie',     //singular name of the listed records
			'plural'    => 'movies',    //plural name of the listed records
			'ajax'      => false        //does this table support ajax?
		) );

	}

	function column_default($item, $column_name){
		switch($column_name){
			case 'price':
				return $item[$column_name].' تومان';
			case 'ID':
				return $item[$column_name];
			case 'post_date':
				return jdate('l, j F , Y , H:i:s',$item[$column_name]);
			case 'payment_date':
				return $item[$column_name] ? jdate('l, j F , Y , H:i:s',$item[$column_name]) : 'پرداخت نشده';
			default:
				return print_r($item,true); //Show the whole array for troubleshooting purposes
		}
	}

	function column_title($item){

		//Build row actions
		$actions = array(
			'edit'      => sprintf('<a href="?page=%s&action=%s&sale=%s">ویرایش</a>',$_REQUEST['page'],'edit',$item['ID']),
			'delete'    => sprintf('<a  href="?page=%s&action=%s&sale=%s">حذف</a>',$_REQUEST['page'],'delete',$item['ID']),
		);

		//Return the title contents
		return sprintf('%1$s %2$s',
			/*$1%s*/ $item['title'],
			/*$2%s*/ $this->row_actions($actions)
		);
	}



	function column_user($item){
		$user = get_user_by('ID',$item['user']);
		if(!$user) return 'نا مشخص';
		return '<a href="user-edit.php?user_id='.$user->ID.'">'. $user->user_login.'</a>';
	}

	function get_bulk_actions() {
		$actions = array(
			'delete'    => 'حذف'
		);
		//return $actions;
	}

	public function search_box( $text, $input_id ) {
		if ( empty( $_REQUEST['s'] ) && !$this->has_items() )
			return;

		$input_id = $input_id . '-search-input';

		if ( ! empty( $_REQUEST['orderby'] ) )
			echo '<input type="hidden" name="orderby" value="' . esc_attr( $_REQUEST['orderby'] ) . '" />';
		if ( ! empty( $_REQUEST['order'] ) )
			echo '<input type="hidden" name="order" value="' . esc_attr( $_REQUEST['order'] ) . '" />';
		if ( ! empty( $_REQUEST['post_mime_type'] ) )
			echo '<input type="hidden" name="post_mime_type" value="' . esc_attr( $_REQUEST['post_mime_type'] ) . '" />';
		if ( ! empty( $_REQUEST['detached'] ) )
			echo '<input type="hidden" name="detached" value="' . esc_attr( $_REQUEST['detached'] ) . '" />';
		?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo $text; ?>:</label>
            <input type="search" id="<?php echo esc_attr( $input_id ); ?>" name="s" value="<?php _admin_search_query(); ?>" />
			<?php submit_button( $text, '', '', false, array( 'id' => 'search-submit' ) ); ?>
        </p>
		<?php
	}

	function process_bulk_action() {
		//Detect when a bulk action is being triggered...
		if( 'delete' === $this->current_action() ) {
			if(isset($_POST['delete_submit'])){
				$post_id = $_POST['post_id'];
				wp_delete_post($post_id);
				delete_post_meta($post_id,'gateway');
				delete_post_meta($post_id,'userid');
				delete_post_meta($post_id,'type');
				delete_post_meta($post_id,'price');
				delete_post_meta($post_id,'payed');
				delete_post_meta($post_id,'subscript_id');
				delete_post_meta($post_id,'payment_token');
				delete_post_meta($post_id,'payment_time');
				//wp_redirect(admin_url().'admin.php?page=wp2appir/sale_meta/sale_meta.php');
				?>
                <p>
                    رکورد حذف شد.
                </p>
                <a href="<?= admin_url().'admin.php?page=wp2appir/sale_meta/sale_meta.php' ?>" class="button button-primary" > بازگشت</a>
				<?php
			}
			else{
				$post = get_post($_GET['sale']);
				?>
                <br>
                <p>
                    <strong> عنوان : </strong>
                    <span> <?= $post->post_title;?></span>
                </p>
                <p>
                    <strong> تاریخ ثبت : </strong>
                    <span> <?= jdate('l, j F , Y , H:i:s',$post->post_date);?></span>
                </p>
                <p>
                    <strong> مبلغ سفارش : </strong>
                    <span> <?= (int)get_post_meta($post->ID,'price' , true). 'تومان';?></span>
                </p>
                <p>
                <form method="post">
                    <input type="hidden" name="post_id" value="<?= $post->ID?>">
                    <input name="delete_submit" id="submit" class="button button-primary" value="پاک شود" type="submit">
                </form>
                </p>
				<?php
			}
			exit();
		}
        elseif( 'edit' === $this->current_action() ) {
			if(isset($_POST['edit_submit'])){
				$post_id = $_POST['post_id'];

				if($_POST['meta_payed'] == 'true'){
					update_post_meta($post_id , 'payment_time' , time());
					update_post_meta($post_id , 'payed' , 1);
				}
				else{
					update_post_meta($post_id , 'payed' , 0);
					delete_post_meta($post_id , 'payment_time' );
				}
				?>
                <p>
                    ویرایش به درستی انجام شد.
                </p>
                <a href="<?= admin_url().'admin.php?page=wp2appir/sale_meta/sale_meta.php' ?>" class="button button-primary" > بازگشت</a>
				<?php
			}
			else{
				$post = get_post($_GET['sale']);
				?>
                <br>
                <p>
                    <strong> عنوان : </strong>
                    <span> <?= $post->post_title;?></span>
                </p>
                <p>
                    <strong> تاریخ ثبت : </strong>
                    <span> <?= jdate('l, j F , Y , H:i:s',$post->post_date);?></span>
                </p>
                <p>
                    <strong> مبلغ سفارش : </strong>
                    <span> <?= (int)get_post_meta($post->ID,'price' , true). 'تومان';?></span>
                </p>
                <p>
                    <strong>  سفارش مربوط به : </strong>
                    <span> <?php
						$post_id = (int)get_post_meta($post->ID,'post_id' , true);
						if($post_id){
							echo $post_id;
						}
						else{
							echo 'خرید اشتراکی';
						}
						?></span>
                </p>
                <div>
                    <form method="post">
                        <input type="hidden" name="post_id" value="<?= $post->ID?>">
                        <p>
                            <strong> وضعیت پرداخت : </strong>
                            <select name="meta_payed" >
                                <option value="false" <?= selected(get_post_meta($post->ID , 'payed' , 0) , 0)?> > پرداخت نشده </option>
                                <option value="true" <?= selected(get_post_meta($post->ID , 'payed' , 1) , 1)?>>  پرداخت شده </option>
                            </select>
                        </p>
                        <input name="edit_submit" id="submit" class="button button-primary" value="ویرایش و ثبت" type="submit">
                    </form>
                </div>
				<?php
			}
			exit();
		}
	}

	function get_columns(){
		$columns = array(
			//'num'        => '#', //Render a checkbox instead of text
			'title'     => ' عنوان',
			'user'    => 'کاربر',
			'price'  => 'مبلغ سفارش',
			'post_date'  => 'تاریخ ثبت',
			'payment_date'  => 'تاریخ پرداخت',
		);
		return $columns;
	}

	function get_sortable_columns() {
		$sortable_columns = array(
			'title'     => array('title',false),     //true means it's already sorted
			'user'    => array('user',false),
			'price'  => array('price',false),
			'post_date'  => array('post_date',false),
			'payment_date'  => array('payment_date',false)
		);
		return $sortable_columns;
	}

	function get_data(){
		$args = array(
			's' => isset($_REQUEST['s']) ? $_REQUEST['s'] : '',
			'author' => isset($_REQUEST['uid']) ? $_REQUEST['uid'] : '',
			'post_type'   => 'meta_sale_order',
			'post_status' => array('draft'),
			'posts_per_page' => -1,
		);
		if(isset($_REQUEST['payed']) && $_REQUEST['payed'] != ""){
			$args['meta_query'][] =
				array(
					'key'     => 'payed',
					'value' => $_REQUEST['payed'],
					'compare' => $_REQUEST['payed'] == 'false' ? 'NOT EXISTS': ''
				);
		}
		if(isset($_REQUEST['start_date']) && $_REQUEST['start_date'] != ""){
			$v = explode('/', $_REQUEST['start_date']);
			$x = jalali_to_gregorian($v[0],$v[1],$v[2]);
			$from = $x[0].'-'.$x[1].'-'.$x[2];
			$from = strtotime($from);
			$args['meta_query'][] =
				array(
					'key'     => 'payment_time',
					'value' => $from,
					'compare' =>'>='
				);
		}
		if(isset($_REQUEST['end_date']) && $_REQUEST['end_date'] != ""){
			$v = explode('/', $_REQUEST['end_date']);
			$x = jalali_to_gregorian($v[0],$v[1],$v[2]);
			$to = $x[0].'-'.$x[1].'-'.$x[2];
			$to = strtotime($to);
			$to = $to + (24*60*60);
			$args['meta_query'][] =
				array(
					'key'     => 'payment_time',
					'value' => $to,
					'compare' =>'<'
				);
		}
		if(isset($_REQUEST['price']) && $_REQUEST['price'] != ""){

			$args['meta_query'][] =
				array(
					'key'     => 'price',
					'value' => $_REQUEST['price'],
					'compare' =>'='
				);
		}
		$the_query = get_posts( $args );
		$i = 0;
		$array = array();
		foreach ($the_query as $p){
			$i++;
			$array[] = array(
				'num' => $i,
				'ID' => $p->ID,
				'title' => $p->post_title,
				'user' => $p->post_author,
				'price' => (int)get_post_meta($p->ID,'price',true),
				'post_date' => $p->post_date,
				'payment_date' =>get_post_meta($p->ID,'payment_time',true),
			);
		}
		return $array;
	}

	function prepare_items() {
		global $wpdb; //This is used only if making any database queries

		$per_page = 10;

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array($columns, $hidden, $sortable);

		$this->process_bulk_action();
		$data = $this->get_data();

		function usort_reorder($a,$b){
			$orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'post_date'; //If no sort, default to title
			$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc'; //If no order, default to asc
			$result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
			return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
		}
		usort($data, 'usort_reorder');


		$current_page = $this->get_pagenum();

		$total_items = count($data);

		$data = array_slice($data,(($current_page-1)*$per_page),$per_page);

		$this->items = $data;


		/**
		 * REQUIRED. We also have to register our pagination options & calculations.
		 */
		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
		) );
	}

	function delete_sale_post($post_id){
		echo  $post_id;
		return;
	}
	function edit_sale_post($post_id){
		echo  $post_id;
		return;
	}
}
$ListTable = new TT_Example_List_Table();
$ListTable->prepare_items();

?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<div class="wrap">
    <h2> سفارشات </h2>
    <form id="movies-filter" method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
		<?php $ListTable->search_box('search', 'search_id');?>

		<?php $ListTable->display() ?>
    </form>
</div>

<script>
    jQuery(function(jQuery){

        // multiple select with AJAX search
        jQuery('.js-data-example-ajax').select2({
            ajax: {
                url: ajaxurl, // AJAX URL is predefined in WordPress admin
                dataType: 'json',
                delay: 250, // delay in ms while typing when to perform a AJAX search
                data: function (params) {

                    return {
                        action: 'getusers', // AJAX action for admin-ajax.php
                        q: params.term // search query
                    };
                },
                processResults: function( data ) {
                    //console.log(data);
                    var options = [];
                    if ( data ) {
                        // data is the array of arrays, and each of them contains ID and the Label of the option
                        jQuery.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
                            options.push( { id: text[0], text: text[1]  } );
                        });
                    }
                    return {
                        results: options
                    };
                }
                // cache: true
            },
            minimumInputLength: 3 // the minimum of symbols to input before perform a search
        });
    });

</script>
