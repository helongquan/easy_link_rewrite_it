<?php
/*
Plugin Name: easy link rewrite it
Plugin URI: https://github.com/helongquan/easy_link_rewrite_it
Description: 这个是一个非常简单易用的插件，插件用于重写页面，文章链接地址
Version: 1.0
Author: 追梦人
Author URI: https://github.com/helongquan/easy_link_rewrite_it
License: GPLv3

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/


// 在插件激活要执行的函数
function easy_link_rewrite_it_plugin__activate() {
    // 添加你需要执行的操作
}
register_activation_hook( __FILE__, 'easy_link_rewrite_it_plugin__activate' );

// 在插件停用要执行的函数
function easy_link_rewrite_it_plugin_deactivate() {
    
}
register_deactivation_hook( __FILE__, 'easy_link_rewrite_it_plugin_deactivate' );

// 在插件卸载时执行的函数
function easy_link_rewrite_it_plugin_uninstall() {
    // 添加你需要执行的操作
}
register_uninstall_hook( __FILE__, 'easy_link_rewrite_it_plugin_uninstall' );



function elri_custom_page_rewrite_input() {
    global $post;
    $elri_custom_link = get_post_meta($post->ID, '_elri_custom_link', true);
    ?>
    <p style="display:flex;items;align-items: center;">
        <label for="custom-link" style="background: #d9d9d9;display: inline-block;line-height: 30px;padding-left: 15px;padding-right: 15px;color: #000;width:150px;">Link rewriting</label>
        <input type="url" id="custom-link" name="elri_custom_link" value="<?php echo esc_attr($elri_custom_link); ?>" style="width:100%"/>
    </p>
    <?php
}
add_action('edit_form_after_title', 'elri_custom_page_rewrite_input');

// 保存自定义链接
function elri_save_custom_page_rewrite($post_id) {
    if (array_key_exists('elri_custom_link', $_POST)) {
        update_post_meta($post_id, '_elri_custom_link', sanitize_text_field($_POST['elri_custom_link']));
    }
}
add_action('save_post', 'elri_save_custom_page_rewrite');

// 自定义文章链接重定向，如果想要除了文章之外的也要跳转，可以把下面那个'post'删除
function elri_custom_post_redirect() {
	// 
    if (is_singular()) {
        global $post;
        $elri_custom_link = get_post_meta($post->ID, '_elri_custom_link', true);

        if ($elri_custom_link) {
            wp_redirect($elri_custom_link, 301);
            exit;
        }
    }
}
add_action('template_redirect', 'elri_custom_post_redirect');