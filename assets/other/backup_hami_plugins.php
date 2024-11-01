<?php
function backup_info(){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$tables =  array( $prefix.'hami_appost' , $prefix.'hami_set' , $prefix.'hami_appstatic' , $prefix.'hami_mainpage' , $prefix.'hami_slider' );
	$upload_dir = wp_upload_dir();
	$file_path = $upload_dir['basedir'] . '/backups/database.txt';
	//--------------------- backup from database hami ----------------------------------------
	if(!is_dir($upload_dir['basedir'].'/backups')){
		mkdir($upload_dir['basedir'].'/backups');
	}
	$file = fopen($file_path, 'w') or die("Unable to open file!");
	$t1 = $prefix.'hami_appost';
	$t2 = $prefix.'hami_set';
	$t3 = $prefix.'hami_appstatic';
	$t4 = $prefix.'hami_mainpage';
	$t5 = $prefix.'hami_slider';
	fwrite($file, 'DROP TABLE IF EXISTS '.$t1.';' . PHP_EOL);
	fwrite($file, 'DROP TABLE IF EXISTS '.$t2.';' . PHP_EOL);
	fwrite($file, 'DROP TABLE IF EXISTS '.$t3.';' . PHP_EOL);
	fwrite($file, 'DROP TABLE IF EXISTS '.$t4.';' . PHP_EOL);
	fwrite($file, 'DROP TABLE IF EXISTS '.$t5.';' . PHP_EOL);
	foreach ($tables as $table_name)
	{
		
	    $schema = $wpdb->get_row('SHOW CREATE TABLE ' . $table_name, ARRAY_A);
	    fwrite($file, $schema['Create Table'] . ';' . PHP_EOL);
	    $rows = $wpdb->get_results('SELECT * FROM ' . $table_name, ARRAY_A);
	    if( $rows )
	    {
	        fwrite($file, 'INSERT INTO ' . $table_name . ' VALUES ');
	        $total_rows = count($rows);
	        $counter = 1;
	        foreach ($rows as $row => $fields)
	        {
	            $line = '';
	            foreach ($fields as $key => $value)
	            {
	                $value = addslashes($value);
	                $line .= '"' . $value . '",';
	            }
	            $line = '(' . rtrim($line, ',') . ')';
	            if ($counter != $total_rows)
	            {
	                $line .= ',' . PHP_EOL;
	            }
	            fwrite($file, $line);
	            $counter++;
	        }
	        fwrite($file, '; ' . PHP_EOL);
	    }
	}
	fclose($file);
	$homepage = file_get_contents($file_path);
	if($homepage != ""){
		echo 1;
	}else{
		echo 0;
	}
}