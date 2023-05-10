<?php

const product_top = [
    'login_url'    => '/admin/products/create', //
    'ch_name'      => 'descriptions[zh_cn][name]', //中文名称
    'en_name'      => 'descriptions[en][name]', //英文名称
    'sku'          => 'skus[0][sku]', //sku
    'price'        => 'skus[0][price]', //价格
    'origin_price' => 'skus[0][origin_price]', //原价
    'cost_price'   => 'skus[0][cost_price]', //成本价
    'quantity'     => 'skus[0][quantity]', //数量
    'Enable'       => '#active-1',
    'Disable'      => '#active-0',
    'save_btn'     => '#content > div.page-title-box.py-1.d-flex.align-items-center.justify-content-between > div > button', //保存
];
const product_assert = [
    'Disable_text' => '.text-danger', //商品禁用后显示的文本class
];
