<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_register_style( 'bootstrap', WP2APPIR_CSS_URL.'bootstrap.css'  );
wp_enqueue_style('bootstrap');
wp_register_style( 'font-awesome', WP2APPIR_CSS_URL.'font-awesome.css'  );
wp_enqueue_style('font-awesome');
wp_register_style( 'wp2app_fonts', 'http://wp2app.ir/downloads/plugin-asset/wp2app_fonts.css'  );
wp_enqueue_style('wp2app_fonts');
?>
<?php // Get RSS Feed(s)
include_once( ABSPATH . WPINC . '/feed.php' );
// Get a SimplePie feed object from the specified feed source.
$rss = fetch_feed( 'http://www.wp2app.ir/feed?cat=23/' );
if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
	// Figure out how many total items there are, but limit it to 5.
	$maxitems = $rss->get_item_quantity( 5 );
	// Build an array of all the items, starting with element 0 (first element).
	$rss_items = $rss->get_items( 0, $maxitems );
endif;
//--------------------------------------------------------------------------------
$rss_new = fetch_feed( 'http://www.wp2app.ir/feed?cat=3/' );
if ( ! is_wp_error( $rss_new ) ) : // Checks that the object is created correctly
	// Figure out how many total items there are, but limit it to 5.
	$maxitems_new = $rss_new->get_item_quantity( 5 );
	// Build an array of all the items, starting with element 0 (first element).
	$rss_new_items = $rss_new->get_items( 0, $maxitems_new );
endif;
?>
<div class="col-lg-12" style="margin: 30px auto;padding-right:50px;">
    <div class="col-lg pull-right" style="margin-left:30px;">
        <a href="http://wp2app.ir/faq/" target="_BLANK" title="سوالات متداول">
            <img src= "<?php echo plugins_url(plugin_basename(dirname(__FILE__))).'/../assets/img/faq.png'?>">
        </a>
    </div>
    <div class="col-lg-2 pull-right" >
        <a href="http://wp2app.ir/faq/" target="_BLANK" title="سوالات متداول">
            سوالات متداول
        </a>
    </div>
    <div class="col-lg pull-right" style="margin-left:30px;">
        <a href="http://wp2app.ir/%D9%BE%D8%B4%D8%AA%DB%8C%D8%A8%D8%A7%D9%86%DB%8C/" target="_BLANK" title="پشتیبانی">
            <img src= "<?php echo plugins_url(plugin_basename(dirname(__FILE__))).'/../assets/img/support.png'?>">
        </a>
    </div>
    <div class="col-lg-2 pull-right" >
        <a href="http://wp2app.ir/%D9%BE%D8%B4%D8%AA%DB%8C%D8%A8%D8%A7%D9%86%DB%8C/" target="_BLANK" title="پشتیبانی">
            پشتیبانی
        </a>
    </div>
</div>
<div class="col-lg-12">
    <div class="col-lg-5 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                آموزش
            </div>
            <div class="panel-body">
				<?php
				echo "<ul>\n";

				if ( !isset($items) )
					$items = 15;

				foreach ( $rss_new->get_items(0, $items) as $item ) {
					$publisher = '';
					$site_link = '';
					$link = '';
					$content = '';
					$date = '';
					$link = esc_url( strip_tags( $item->get_link() ) );
					$title = esc_html( $item->get_title() );
					$content = $item->get_content();
					$content = wp_html_excerpt($content, 250) . ' ...';

					echo "<li><a target='_blank' class='rsswidget' href='$link'>$title</a>\n<div class='rssSummary'>$content</div>\n";
					echo "اپلیکیشن ساز سایت های وردپرس برای اولین با در ایران <a href='http://www.wp2app.ir' target='_blank'>وردپرس 2 اپ</a>";
				}

				echo "</ul>\n";
				?>
            </div>
        </div>
    </div>
    <div class="col-lg-5 pull-right">
        <div class="panel panel-default">
            <div class="panel-heading">
                اخبار
            </div>
            <div class="panel-body">
				<?php
				echo "<ul>\n";

				if ( !isset($items) )
					$items = 15;

				foreach ( $rss->get_items(0, $items) as $item ) {
					$publisher = '';
					$site_link = '';
					$link = '';
					$content = '';
					$date = '';
					$link = esc_url( strip_tags( $item->get_link() ) );
					$title = esc_html( $item->get_title() );
					$content = $item->get_content();
					$content = wp_html_excerpt($content, 250) . ' ...';

					echo "<li><a target='_blank' class='rsswidget' href='$link'>$title</a>\n<div class='rssSummary'>$content</div>\n";
					echo "اپلیکیشن ساز سایت های وردپرس برای اولین با در ایران <a href='http://www.wp2app.ir' target='_blank'>وردپرس 2 اپ</a>";
				}

				echo "</ul>\n";
				?>
            </div>
        </div>
    </div>
</div>