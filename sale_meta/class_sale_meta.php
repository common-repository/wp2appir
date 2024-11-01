<?php
/**
 * Created by mr2app.
 * User: hani
 * Date: 1/16/18
 * Time: 11:52 PM
 */

class class_sale_meta_wp2app {

    function __construct(){
        add_action( 'init', array( $this , 'mr2app_custom_sale_meta_regular_url' ));
        add_filter( 'query_vars', array( $this , 'mr2app_custom_sale_meta_query_vars' ));
        add_action( 'parse_request', array( $this , 'mr2app_custom_sale_meta_parse_request' ));
    }

    function mr2app_custom_sale_meta_regular_url(){
        add_rewrite_rule('^mr2app/meta_sale_setting$', 'index.php?meta_sale_setting=$matches[1]', 'top');
        add_rewrite_rule('^mr2app/meta_sale_pay$', 'index.php?meta_sale_pay=$matches[1]', 'top');
        add_rewrite_rule('^mr2app/meta_sale_uinfo$', 'index.php?meta_sale_uinfo=$matches[1]', 'top');
        add_rewrite_rule('^mr2app/returnzarinpal$', 'index.php?returnzarinpal=$matches[1]', 'top');
        add_rewrite_rule('^success_payment$', 'index.php?success_payment=$matches[1]', 'top');
        flush_rewrite_rules();
    }

    function mr2app_custom_sale_meta_query_vars($query_vars) {
        $query_vars[] = 'meta_sale_setting';
        $query_vars[] = 'meta_sale_pay';
        $query_vars[] = 'returnzarinpal';
        $query_vars[] = 'success_payment';
        $query_vars[] = 'meta_sale_uinfo';
        return $query_vars;
    }

    function mr2app_custom_sale_meta_parse_request(&$wp){
        if ( array_key_exists( 'meta_sale_setting', $wp->query_vars ) ) {
            $this->meta_sale_setting();
            exit();
        }
        if ( array_key_exists( 'meta_sale_pay', $wp->query_vars ) ) {
            $this->meta_sale_pay();
            exit();
        }
        if ( array_key_exists( 'returnzarinpal', $wp->query_vars ) ) {
            $this->returnzarinpal();
            exit();
        }
        if ( array_key_exists( 'success_payment', $wp->query_vars ) ) {
            $this->success_payment();
            exit();
        }
        if ( array_key_exists( 'meta_sale_uinfo', $wp->query_vars ) ) {
            $this->meta_sale_uinfo();
            exit();
        }
        return;
    }

    public function meta_sale_setting(){

        header('Content-Type: application/json; charset=utf-8');
        $array['vip_plans'] = get_option('mr2app_wp2app_sale_meta_plans');
        $array['payments_methods'] = get_option('mr2app_wp2app_sale_meta_gateway');
        wp_send_json_success( $array);
    }

    public function meta_sale_uinfo(){
        header('Content-Type: application/json; charset=utf-8');
        if (!array_key_exists('in', $_POST)) {
            $result = array(
                'msg' => 'ورودی اشتباه می باشد.'
            );
            wp_send_json_error($result);
            return;
        }
        $in = $_POST['in'];
        $slashless = stripcslashes($in);
        $url_json = urldecode($slashless);
        $json = json_decode($url_json);
        $username = $json->username;
        if(!$user = $this->check_username($username)){
            $result = array(
                'msg' => 'نام کاربری نامعتبر می باشد.'
            );
            wp_send_json_error($result);
        }
        $result = array();
        $vip_time = get_user_meta($user,'_vip_time',true);
        $time = 0;
        if($vip_time < time()) $time = 0;
        else{
            $time = (int)$vip_time - time();
            $time = (int)($time / (24*60*60));
        }
        $result['vip_time'] = $time;
        $args = array(
            'post_type'   => 'meta_sale_order',
            'author' => $user,
            'post_status' => 'draft',
            'posts_per_page' => -1,
        );
        $the_query = get_posts( $args );
        $orders = array();
        foreach ($the_query as $p){
            if((int)get_post_meta($p->ID,'payed' , true) == 0) continue;
            $name = "";
            $meta_key = "";
            if(get_post_meta($p->ID,'post_id' , true)){
                $post = get_post(get_post_meta($p->ID,'post_id' , true));
                if($post){
                    $name = $post->post_title;
                    $meta_key = get_post_meta($p->ID,'meta_key' , true);
                }
                else{
                    $name = "نام معلوم";
                }
            }
            else{
                $name = "فروش اشتراکی";
            }
            $orders[] = array(
                'gateway' => get_post_meta($p->ID,'gateway' , true),
                'userid' => get_post_meta($p->ID,'userid' , true),
                'type' => get_post_meta($p->ID,'type' , true),
                'post_id' => get_post_meta($p->ID,'post_id' , true),
                'meta_key' => $meta_key,
                'title' => $name,
                'subscript_id' => get_post_meta($p->ID,'subscript_id' , true),
                'payment_token' => get_post_meta($p->ID,'payment_token' , true),
                'payment_time' => get_post_meta($p->ID,'payment_time' , true),
                'payed' => (int)get_post_meta($p->ID,'payed' , true),
                'price' => (int)get_post_meta($p->ID,'price' , true),
                'description' => $p->post_title,
            );
        }
        $result['orders'] = $orders;
        wp_send_json_success($result);
    }

    public function meta_sale_pay(){

        header('Content-Type: application/json; charset=utf-8');
        if (!array_key_exists('in', $_POST)) {
            $result = array(
                'msg' => 'ورودی اشتباه می باشد.'
            );
            wp_send_json_error($result);
            return;
        }
        if(isset($_GET['in'])){
	        $in = $_GET['in'];
        }
        else{
	        $in = $_POST['in'];
        }
        $slashless = stripcslashes($in);
        $url_json = urldecode($slashless);
        $json = json_decode($url_json);
        $gateway = $json->gateway ;
        $username = $json->username;
        $type = $json->type; // single or subscript;
        $post_id = $json->post; //empty if type is subscript
        $meta_key = $json->meta_key; //empty if type is subscript
        $subscript_id = $json->subscript_id; // can empty ...
        $this->validate($json);

        $title = "";
        $user = get_user_by('login' , $username);
        $user_id = $user->ID;
        if($type == 'single'){
            $title = "ثبت سفارش - فروش تکی";
        }
        elseif($type == 'subscript'){
            $title = "ثبت سفارش - فروش اشتراکی";
        }
        $array = array(
            'post_author'    => $user_id,
            'post_title'    => $title,
            'post_type'     => 'meta_sale_order',
        );
        $post = wp_insert_post( $array );
        if($post){
            add_post_meta($post,'gateway',$gateway);
            add_post_meta($post,'userid',$user_id);
            add_post_meta($post,'type',$type);
            add_post_meta($post,'post_id',$post_id);
            add_post_meta($post,'meta_key',$meta_key);
            add_post_meta($post,'subscript_id',$subscript_id);
            $this->pay($post,$gateway);
        }
        else{
            echo 0;
        }
        //wp_send_json_success();
        return;
    }

    public function pay($post_id , $gateway){
        if($gateway == 'zarinpal'){
            $this->payzarinpal($post_id);
        }

        return $this->error_pay();
    }

    public function error_pay(){
        ?>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <div class="container" dir="rtl">
            <div class="row text-center">
                <div class="col-sm-6 col-sm-offset-3">
                    <br><br> <h2 style="color:#ad0e24"> پرداخت ناموفق بود.</h2>
                    <p style="font-size:20px;color:#5C5C5C;">
                        متاسفانه مشکلی در پرداخت به وجود آمده است ، لطفا مجدد تلاش کنید.
                    </p>
                    <!--					<button  class="btn btn-success">     بازگشت به اپلیکیشن     </button>-->
                    <br><br>
                </div>

            </div>
        </div>
        <?php

        return;
    }

    public function payzarinpal($post_id ){

        $info = $this->get_info($post_id);
        if(!$info){
            return false;
        }
        $payment = get_option('mr2app_wp2app_sale_meta_gateway');

        $merchant_code = $payment['zarinpal']['merchant_code'];
        if(!$merchant_code){
            return false;
        }
        $MerchantID = $merchant_code ; //';  //Required
        $Amount = $info['price'] ; //Amount will be based on Toman  - Required
        $Description = $info['description'];  // Required
        $Email = $info['email']; // Optional
        $Mobile = $info['mobile']; // Optional
        $CallbackURL = get_option('siteurl').'/mr2app/returnzarinpal/?post_id='.$post_id;  // Required
        // URL also Can be https://ir.zarinpal.com/pg/services/WebGate/wsdl
        $client = new \SoapClient('https://de.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));
        $result = $client->PaymentRequest(
            array(
                'MerchantID'    => $MerchantID,
                'Amount'    => $Amount,
                'Description'   => $Description,
                'Email'     => $Email,
                'Mobile'    => $Mobile,
                'CallbackURL'   => $CallbackURL
            )
        );
        //Redirect to URL You can do it also by creating a form
        if($result->Status == 100)
        {
            add_post_meta($post_id , 'price' , $Amount);
            Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
            exit();
        } else {
            return -1;
        }
    }

    public function returnzarinpal(){
        if (!array_key_exists('post_id', $_GET)) {
            return $this->error_pay();
        }
        $post_id = $_GET['post_id'];
        $info = $this->get_info($post_id);
        $payment = get_option('mr2app_wp2app_sale_meta_gateway');

        $MerchantID = $payment['zarinpal']['merchant_code'];
        $Amount = $info['price']; //Amount will be based on Toman
        $Authority = $_GET['Authority'];

        if($_GET['Status'] == 'OK'){
            // URL also Can be https://ir.zarinpal.com/pg/services/WebGate/wsdl
            $client = new \SoapClient('https://de.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));
            $result = $client->PaymentVerification(
                array(
                    'MerchantID'     => $MerchantID,
                    'Authority'      => $Authority,
                    'Amount'     => $Amount
                )
            );
            if($result->Status == 100){//$result->Status == 100){
                $result->RefID;
                add_post_meta($post_id , 'payment_token' , $result->RefID);
                update_post_meta($post_id , 'price' , $Amount);
                add_post_meta($post_id , 'payment_time' , time());
                add_post_meta($post_id , 'payed' , 1);
                $user_id = get_post_meta($post_id , 'userid' , true);
                $my_inviter = get_user_meta($user_id , 'my_inviter' , true);
                if(!empty($my_inviter) && !is_null($my_inviter)){
                    $marketer = get_users(array('meta_key' => 'inviter_code', 'meta_value' => $my_inviter));
                    if($marketer){
                        //$marketer->ID,$user_id,time(),0
                        global $wpdb;
                        $table_name = $wpdb->prefix . "wp2app_commission";
                        $r = $wpdb->query( $wpdb->prepare("INSERT INTO $table_name 
		                    ( marketer_id , user_id , f_time , payed ) 
		                    VALUES ( %d, %d, %d, %d )", $marketer->ID,$user_id,time(),0) );
                    }
                }
                if($time = $this->calc_subscript($post_id)){
                    update_user_meta($user_id , '_vip_time' , $time);
                }
                wp_redirect(get_option('siteurl').'/success_payment?post_id='.$post_id);
            }
        }
        return $this->error_pay();
    }

    public function calc_subscript($post_id){
        $type = get_post_meta($post_id , 'type' , true);
        if($type == 'subscript'){
            $sub_id = get_post_meta($post_id , 'subscript_id' , true);
            $plans = get_option('mr2app_wp2app_sale_meta_plans');
            foreach ($plans as $key){
                if($key['uniqid'] == $sub_id){
                    $user_id = get_post_meta($post_id , 'userid' , true);
                    $t = get_user_meta($user_id , '_vip_time' ,true);
                    if($t){
                        if($t > time()){
                            return ($t + (int) $key['time'] * (24*60*60));
                        }
                    }
                    return (strtotime("tomorrow") + (int) $key['time'] * (24*60*60) - 1);
                }
            }
        }
        return 0;
    }

    public function success_payment(){
        //echo 'success_payment'.$_GET['post_id'];
        $order = get_post($_GET['post_id']);
        if(!$order){
            $this->error_pay();
            exit();
        }
        $peygiri = get_post_meta($order->ID,'payment_token' , true);
        $price = get_post_meta($order->ID,'price' , true);
        ?>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <div class="container" dir="rtl">
            <div class="row text-center">
                <div class="col-sm-6 col-sm-offset-3">
                    <br><br> <h2 style="color:#0fad00"> پرداخت با موفقیت انجام شد.</h2>
                    <h3> </h3>
                    <p style="font-size:20px;color:#5C5C5C;">
                        پرداخت شما با شماره پیگیری
                        <strong> <?= $peygiri;?></strong>
                        با مبلغ
                        <strong> <?= $price;?></strong>
                        با موفقیت انجام شد.
                    </p>
                    <br><br>
                </div>

            </div>
        </div>
        <?php
        exit();
    }

    public function get_info($post_id){
        $post = get_post($post_id);

        if($post){
            $info = array();
            $price = $this->get_price($post_id);
            if($price){
                $info['price'] = $this->get_price($post_id);
                $info['description'] = $this->get_description($post_id);;
                $info['email'] = $this->get_email($post_id);;
                $info['mobile'] = $this->get_mobile($post_id);;
                return $info;
            }
        }
        return false;
    }

    public function get_price($post_id){
        $type = get_post_meta($post_id , 'type' , true);
        if($type == 'subscript'){
            $sub_id = get_post_meta($post_id , 'subscript_id' , true);
            $plans = get_option('mr2app_wp2app_sale_meta_plans');
            foreach ($plans as $key){
                if($key['uniqid'] == $sub_id){
                    return $key['price'];
                }
            }
            return 0;
        }
        elseif($type == 'single'){
            $option = get_post_meta(get_post_meta($post_id , 'post_id' ,true) , 'mr2app_post_option' , true);
            $meta_key = get_post_meta($post_id , 'meta_key' , true);
            $meta_sale = $option['meta_sale'][$meta_key];
            return $meta_sale['price'];
        }
        return 0;
    }

    public function get_description($post_id){
        return 'description';
    }
    public function get_email($post_id){
        return 'email';
    }
    public function get_mobile($post_id){
        return 'mobile';
    }
    public function validate($in){
        $gateway = $in->gateway;
        $username = $in->username;
        $type = $in->type; // single or subscript;
        $post_id = $in->post; //empty if type is subscript
        $meta_key = $in->meta_key; //empty if type is subscript
        $subscript_id = $in->subscript_id; // can empty ...
        if(!$this->check_gateway($gateway)){
            $result = array(
                'msg' => 'درگاه ارسالی در سیستم وجود ندارد.',
                'gateway' => $gateway,

            );
            wp_send_json_error($result);
        }
        if(!$this->check_username($username)){
            $result = array(
                'msg' => 'نام کاربری نامعتبر می باشد.'
            );
            wp_send_json_error($result);
        }
        if(!$this->check_type($type)){
            $result = array(
                'msg' => 'نوع سفارش را انتخاب کنید.'
            );
            wp_send_json_error($result);
        }
        if(!$this->check_post($post_id,$type,$meta_key)){
            $result = array(
                'msg' => 'پست نامعتبر می باشد.'
            );
            wp_send_json_error($result);
        }

        if(!$this->check_subscript($subscript_id , $type)){
            $result = array(
                'msg' => 'پکیج نامعتبر می باشد نامعتبر می باشد.'
            );
            wp_send_json_error($result);
        }
    }

    public function check_gateway($gateway){
        $gates = get_option('mr2app_wp2app_sale_meta_gateway');
        foreach ($gates as $key => $val){
            if($key == $gateway) return 1;
        }
        return 0;
    }

    public function check_username($username){
        $user = get_user_by('login' , $username);
        if($user) {
            return $user->ID;
        }
        return 0;
    }

    public function check_type($type){

        if($type == "") {
            return 0;
        }
        elseif( $type == "single" || $type == "subscript" ) return 1;

        return 0;
    }

    public function check_post($post_id ,$type , $meta_key){
        if($type == 'single'){
            $post = get_post($post_id);
            if($post){
                if($meta_key != ""){
                    $meta = get_post_meta($post->ID , $meta_key , true);
                    if($meta){
                        return 1;
                    }
                }
                $result = array(
                    'msg' => 'زمینه دلخواه نامعتبر می باشد.'
                );
                wp_send_json_error($result);
            }
            return 0;
        }
        return 1;
    }

    public function check_subscript($subscript_id , $type){

        $plans  = get_option("mr2app_wp2app_sale_meta_plans");
        if($type == 'subscript'){
            foreach ($plans as $key){
                if($key['uniqid'] == $subscript_id){
                    return 1;
                }
            }
            return 0;
        }
        return 1;
    }
}