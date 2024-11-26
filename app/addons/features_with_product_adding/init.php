<?php

defined('BOOTSTRAP') or die('Access denied');

fn_register_hooks(
    'get_product_features',
    'get_product_feature_data_before_select',
    'set_notification_pre',
    'dispatch_before_display'
);
