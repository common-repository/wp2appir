<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class wp2appir_ajax_insert
{
    function __construct()
    {
        add_action( 'wp_ajax_insert_setting_plash', array($this , 'insert_setting_plash') );
        add_action( 'wp_ajax_insert_setting_primery', array($this ,'insert_setting_primery') );
        add_action( 'wp_ajax_backup_data', array($this , 'backup_data') );
        add_action( 'wp_ajax_get_amar', array($this , 'get_amar') );
    }
    function insert_setting_plash(){

        do_action( 'myplugin_after_form_settings' );
        //$time = sanitize_text_field($_REQUEST['sptime']) ;
        $url = sanitize_text_field($_REQUEST['spurl']) ;
        global $wpdb;
        $table_name = $wpdb->prefix . 'hami_set';
//        $r = $wpdb->update( $table_name,
//            array( 'value' => $time),
//            array( 'name' => 'NUM_SPLASHT' ) );
        $re = $wpdb->update( $table_name,
            array( 'value' => $url),
            array( 'name' => 'TXT_SPLASHPL' ) );
        //if($r)  echo 1;
        if($re) echo 11;
    }
    function insert_setting_primery()
    {
        do_action( 'myplugin_after_form_settings' );
        $_REQUEST['TXT_MNRIC'] = str_replace("\"","",$_REQUEST['TXT_MNRIC']);
        $_REQUEST['TXT_MNLIC'] = str_replace("\"","",$_REQUEST['TXT_MNLIC']);
        $_REQUEST['TXT_MNRIC'] = str_replace("\\","",$_REQUEST['TXT_MNRIC']);
        $_REQUEST['TXT_MNLIC'] = str_replace("\\","",$_REQUEST['TXT_MNLIC']);
        $_REQUEST['NUM_SRCHIC'] = str_replace("\"","",$_REQUEST['NUM_SRCHIC']);
        $_REQUEST['NUM_SRCHIC'] = str_replace("\\","",$_REQUEST['NUM_SRCHIC']);
        global $wpdb;
        global $wpdb;
        $table_name = $wpdb->prefix . 'hami_set';
        $result = $wpdb->get_results("select * from $table_name where name IN 
									('NUM_LVT','TXT_ACTT'
									,'CLR_MBG','CLR_ACTBG','CLR_ACTTX','CLR_LISTHBG','CLR_LISTHTX','CLR_LISTSBG','CLR_LISTFBG','CLR_LISTFTX','CLR_LISTSTX',
									'NUM_MNRTYPE','TXT_MNRTI',
									'NUM_MNLTYPE','TXT_MNLTI',
									'TXT_MNRIC','TXT_MNLIC',
									'NUM_SRCHP','NUM_SRCHIC','CLR_SRCHIC' ,
									'NUM_MNFTYPE' , 'TXT_MNFTI' )");
        foreach($result as $r){
            if(!empty($_REQUEST[$r->name]))
            {
                $r = $wpdb->update( $table_name,
                    array( 'value' => sanitize_text_field($_REQUEST[$r->name]) ),
                    array( 'name' => $r->name ) );
            }
        }
    }
    function backup_data(){
        echo backup_info();
    }
    function get_amar()
    {
        $str = $_REQUEST['str'] ;
        if($str!="4")
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'hami_appstatic';
            $sql_device = "SELECT SUBSTRING(apst_unifo,POSITION('imei' IN apst_unifo),POSITION('appid' IN apst_unifo)-POSITION('imei' IN apst_unifo)) as imei FROM $table_name WHERE  apst_time BETWEEN DATE_SUB(NOW(), INTERVAL 1 $str) AND now() group by imei";
            $device = $wpdb->get_results($sql_device);
            $count_device = 0 ;
            foreach($device as $a)
            {
                $count_device++;
            }
            $sql_all = "SELECT count(*) as count_all FROM $table_name WHERE  apst_time BETWEEN DATE_SUB(NOW(), INTERVAL 1 $str) AND now()";
            $all = $wpdb->get_results($sql_all);
            foreach($all as $a)
            {
                $count_all = $a->count_all;
            }
            $sql_ip = "SELECT apst_ip FROM $table_name WHERE  apst_time BETWEEN DATE_SUB(NOW(), INTERVAL 1 $str) AND now()  group by apst_ip";
            $ip = $wpdb->get_results($sql_ip);
            $count_ip = 0;
            foreach($ip as $a)
            {
                $count_ip++;
            }
            echo $count_all;
            echo "_".$count_device."_".$count_ip;
        }else{
            global $wpdb;
            $table_name = $wpdb->prefix . 'hami_appstatic';
            $sql_device = "SELECT SUBSTRING(apst_unifo,POSITION('imei' IN apst_unifo),POSITION('appid' IN apst_unifo)-POSITION('imei' IN apst_unifo)) as imei FROM $table_name group by imei";
            $device = $wpdb->get_results($sql_device);
            $count_device = 0 ;
            foreach($device as $a)
            {
                $count_device++;
            }
            $sql_all = "SELECT count(*) as count_all FROM $table_name";
            $all = $wpdb->get_results($sql_all);
            foreach($all as $a)
            {
                $count_all = $a->count_all;
            }
            $sql_ip = "SELECT apst_ip FROM $table_name  group by apst_ip";
            $ip = $wpdb->get_results($sql_ip);
            $count_ip = 0;
            foreach($ip as $a)
            {
                $count_ip++;
            }
            echo $count_all;
            echo "_".$count_device."_".$count_ip;
        }
    }
}