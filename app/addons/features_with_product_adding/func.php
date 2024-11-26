<?php

use Tygh\Registry;
use Tygh\Tygh;

defined('BOOTSTRAP') or die('Access denied');

function fn_features_with_product_adding_get_product_features(&$fields, $join, &$condition, $params)
{
    $fields[] = 'pf.is_required';
}

function fn_features_with_product_adding_get_product_feature_data_before_select(
    &$fields,
    $join,
    $condition,
    $feature_id,
    $get_variants,
    $get_variant_images,
    $lang_code
) {
    $fields[] = '?:product_features.is_required';
}

function fn_features_with_product_adding_dispatch_before_display()
{
    if (isset(Tygh::$app['session']['notifications_to_delete']) && is_array(Tygh::$app['session']['notifications_to_delete'])) {
        foreach (Tygh::$app['session']['notifications_to_delete'] as $k => $key) {
            unset(Tygh::$app['session']['notifications'][$key]);
            unset(Tygh::$app['session']['notifications_to_delete'][$k]);
        }
    }
}

function fn_features_with_product_adding_set_notification_pre($type, $title, $message, $message_state, $extra, $init_message)
{
    $expected_message =  __('product_feature_cannot_assigned', [
        '[feature_name]' => 'feature_name',
        '[product_name]' => 'product_name'
    ]);

    preg_match('/(.*)\"feature_name\"(.*)\"product_name\"/', $expected_message, $matches);

    if (strpos($message, $matches[2])) {
        $key = md5($type . $title . $message . $extra);
        Tygh::$app['session']['notifications_to_delete'][] = $key;
    }
}
