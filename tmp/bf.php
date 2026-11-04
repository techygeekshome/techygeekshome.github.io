<?php
$base = 'https://raw.githubusercontent.com/techygeekshome/techygeekshome.github.io/main/tmp/';
$content = file_get_contents($base.'content.html');
if (!$content) { echo "NO CONTENT\n"; exit(1); }
$existing = get_page_by_path('black-friday-2026-tech-deals', OBJECT, 'post');
if ($existing) { echo "EXISTS ".$existing->ID."\n"; exit; }
$cats = array();
foreach (array('hardware','reviews','guides','tech') as $s) { $t = get_category_by_slug($s); if ($t) { $cats[] = $t->term_id; break; } }
$admin = get_user_by('login','tghadmin');
$id = wp_insert_post(array(
 'post_title' => 'Black Friday 2026: The Tech Worth Buying If the Price Drops',
 'post_name' => 'black-friday-2026-tech-deals',
 'post_content' => $content,
 'post_status' => 'publish',
 'post_author' => $admin ? $admin->ID : 1,
 'post_category' => $cats,
 'tags_input' => array('Black Friday','Amazon deals','buying guide','SSD','mesh WiFi'),
), true);
if (is_wp_error($id)) { echo "ERR ".$id->get_error_message()."\n"; exit(1); }
require_once ABSPATH.'wp-admin/includes/media.php'; require_once ABSPATH.'wp-admin/includes/file.php'; require_once ABSPATH.'wp-admin/includes/image.php';
$f = media_sideload_image($base.'black-friday-2026-tech-deals.jpg', $id, 'Black Friday 2026: The Tech Worth Buying', 'id');
$o = media_sideload_image($base.'black-friday-2026-tech-deals-og.jpg', $id, 'Black Friday 2026: The Tech Worth Buying', 'id');
if (!is_wp_error($f)) set_post_thumbnail($id, $f);
update_post_meta($id, 'rank_math_focus_keyword', 'black friday tech deals 2026');
update_post_meta($id, 'rank_math_description', 'Black Friday 2026 is on 27 November. The SSDs, mesh Wi-Fi, desk kit and PC parts we would actually buy if the price drops, with live Amazon links.');
if (!is_wp_error($o)) { update_post_meta($id,'rank_math_facebook_image', wp_get_attachment_url($o)); update_post_meta($id,'rank_math_facebook_image_id',$o); update_post_meta($id,'rank_math_twitter_use_facebook','on'); }
echo "OK ".$id." ".get_permalink($id)." feat=".(is_wp_error($f)?'ERR':$f)." og=".(is_wp_error($o)?'ERR':$o)." cats=".implode(',',$cats)."\n";
