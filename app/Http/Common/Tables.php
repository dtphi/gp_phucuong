<?php

namespace App\Http\Common;

final class Tables
{
    public static $categorys = DB_PREFIX . 'categorys';
    public static $category_to_layouts = DB_PREFIX . 'category_to_layouts';
    public static $category_paths = DB_PREFIX . 'category_paths';
    public static $category_descriptions = DB_PREFIX . 'category_descriptions';

    public static $informations = DB_PREFIX . 'informations';
    public static $information_to_downloads = DB_PREFIX . 'information_to_downloads';
    public static $information_to_categorys = DB_PREFIX . 'information_to_categorys';
    public static $information_relateds = DB_PREFIX . 'information_relateds';
    public static $information_images = DB_PREFIX . 'information_images';
    public static $information_descriptions = DB_PREFIX . 'information_descriptions';
    public static $information_carousel = DB_PREFIX . 'information_corousels';

    public static $settings = DB_PREFIX . 'settings';

    public static $linhmucs = DB_PREFIX . 'linhmucs';
    public static $linhmuc_bangcaps = DB_PREFIX . 'linhmuc_bangcaps';
    public static $linhmuc_vanthus = DB_PREFIX . 'linhmuc_vanthus';
    public static $linhmuc_chucthanhs = DB_PREFIX . 'linhmuc_chucthanhs';
    public static $linhmuc_thuyenchuyens = DB_PREFIX . 'linhmuc_thuyenchuyens';

    public static $giaophans = DB_PREFIX . 'giaophans';
    public static $giaophan_hats = DB_PREFIX . 'giaophan_hats';
    public static $giaophan_hat_xus = DB_PREFIX . 'giaophan_hat_xus';
    public static $giaophan_hat_xu_diems = DB_PREFIX . 'giaophan_hat_xu_diems';
    public static $giaophan_hat_congdoantusis = DB_PREFIX . 'giaophan_hat_congdoantusis';
    public static $giaophan_dongs = DB_PREFIX . 'giaophan_dongs';
    public static $giaophan_cosos = DB_PREFIX . 'giaophan_cosos';
    public static $giaophan_banchuyentrachs = DB_PREFIX . 'giaophan_banchuyentrachs';

    public static $thanhs = DB_PREFIX . 'thanhs';
    public static $chuc_vus = DB_PREFIX . 'chuc_vus';
    public static $co_so_giao_phans = DB_PREFIX . 'co_so_giao_phans';
    public static $dongs = DB_PREFIX . 'dongs';
    public static $ban_chuyen_trachs = DB_PREFIX . 'ban_chuyen_trachs';
    public static $cong_doan_tu_sis = DB_PREFIX . 'cong_doan_tu_sis';
    public static $giao_hats = DB_PREFIX . 'giao_hats';
    public static $giao_xus = DB_PREFIX . 'giao_xus';
    public static $giao_diems = DB_PREFIX . 'giao_diems';

    public static $infoStatus = [
        'Ẩn',
        'Xảy ra'
    ];
    public static $linhMucStatus = [
        'Ẩn',
        'Xảy ra'
    ];
    public static $infoStatusActive = 1;
    public static $infoStatusDisabled = 0;
    public static $tagetLink = [
        '_blank',
        '_self'
    ];

    public static $module_left_info_left_side_bar = 'info-left-side-bar';
    public static $module_left_category_left_side_bar = 'category-left-side-bar';
    public static $module_left_newsletter_register = 'newsletter-register';
    public static $module_left_summary_contact = 'summary-contact';
    public static $module_left_category_sub_left_side_bar = 'category-sub-left-side-bar';

    public static $middle_module_info_carousel = 'info-carousel';
    public static $middle_module_special_banner = 'special-banner';
    public static $module_middle_loi_chua = 'loi-chua';
    public static $module_middle_van_kien = 'van-kien';
    public static $module_middle_tin_giao_phan = 'tin-giao-phan';
    public static $module_middle_tin_giao_hoi = 'tin-giao-hoi';

    public static $module_right_info_fanpage = 'info-fanpage';
    public static $module_right_youtube_hanh_cac_thanh = 'youtube-hanh-cac-thanh';
    public static $module_right_lich_cong_giao = 'lich-cong-giao';
    public static $module_right_thong_bao = 'thong-bao';
    public static $module_right_category_icon_side_bar = 'category-icon-side-bar';
    public static $module_right_sach_noi_iframe = 'sach-noi-iframe';

    public static $module_both_noi_bat = 'noi-bat';
    public static $module_both_page_banner_list = 'page-banner-list';

    public static $moduleContent = [
        'module_left_info_left_side_bar'         => 'info-left-side-bar',
        'module_left_category_left_side_bar'     => 'category-left-side-bar',
        'module_left_newsletter_register'        => 'newsletter-register',
        'module_left_summary_contact'            => 'summary-contact',
        'module_left_category_sub_left_side_bar' => 'category-sub-left-side-bar',

        'middle_module_info_carousel'  => 'info-carousel',
        'middle_module_special_banner' => 'special-banner',
        'module_middle_loi_chua'       => 'loi-chua',
        'module_middle_van_kien'       => 'van-kien',
        'module_middle_tin_giao_phan'  => 'tin-giao-phan',
        'module_middle_tin_giao_hoi'   => 'tin-giao-hoi',

        'module_right_info_fanpage'           => 'info-fanpage',
        'module_right_youtube_hanh_cac_thanh' => 'youtube-hanh-cac-thanh',
        'module_right_lich_cong_giao'         => 'lich-cong-giao',
        'module_right_thong_bao'              => 'thong-bao',
        'module_right_category_icon_side_bar' => 'category-icon-side-bar',
        'module_right_sach_noi_iframe'        => 'sach-noi-iframe',

        'module_both_noi_bat'          => 'noi-bat',
        'module_both_page_banner_list' => 'page-banner-list'
    ];

    public static $chucThanhs = [
        '',
        'Phó Tế',
        'Linh Mục',
        'Giám Mục'
    ];

    public static $trieuDongs = [
        'Tu Triều',
        'Tu Dòng'
    ];
}
