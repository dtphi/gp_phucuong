<?php

namespace App\Http\Common;

final class Tables
{
    public static $layout_routes = DB_PREFIX . 'layout_routes';
    public static $layout_settings = DB_PREFIX . 'layout_settings';

    // model GiaoPhanDanhMuc
    public static $giaophandanhmucs = DB_PREFIX . 'danh_muc_giao_phans';
    public static $giaophandanhmuc_motas = DB_PREFIX . 'danh_muc_giao_phan_mo_tas';
    public static $giaophandanhmuc_lienkets = DB_PREFIX . 'danh_muc_giao_phan_lien_kets';

    // model GiaoPhanTinTuc
    public static $giaophantintucs = DB_PREFIX . 'giao_phan_tin_tucs';
    public static $giaophantintuc_motas = DB_PREFIX . 'giao_phan_tin_tuc_mo_tas';
    public static $giaophantintuc_danhmucs = DB_PREFIX . 'giao_phan_tin_tuc_danh_mucs';

    public static $subscribes = DB_PREFIX . 'subscribes';
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
    public static $personal_access_tokens = DB_PREFIX . 'personal_access_tokens';
    public static $restrict_ips = 'restrict_ips';
    public static $albums = DB_PREFIX . 'albums';
    public static $group_albums = DB_PREFIX . 'group_albums';

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

    public static $moduleSystemCode = 'module_system';
    public static $moduleBannerCode = 'module_banner';
    public static $moduleBannerKeys = [
        'module_banner_on_gois',
        'module_banner_loi_chuas',
        'module_banner_videos',
        'module_banner_audio_podcasts',
        'module_banner_linh_mucs',
        'module_banner_giao_xus',
        'module_banner_thong_baos',
        'module_banner_phung_vus'
    ];

    const PREFIX_ACCESS_NAME = 'allow.';
    const PREFIX_SETTING = 'setting';
    public static $settingAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_SETTING;
    const PREFIX_ALLOW_LINH_MUC = 'linh.muc';
    public static $linhMucAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_LINH_MUC;
    const PREFIX_ALLOW_LINH_MUC_THUYEN_CHUYEN = 'linh.muc.thuyen.chuyen';
    public static $linhMucThuyenChuyenAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_LINH_MUC_THUYEN_CHUYEN;
    const PREFIX_ALLOW_LINH_MUC_VAN_THU = 'linh.muc.van.thu';
    public static $linhMucVanThuAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_LINH_MUC_VAN_THU;
    const PREFIX_ALLOW_LINH_MUC_BANG_CAP = 'linh.muc.bang.cap';
    public static $linhMucBangCapAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_LINH_MUC_BANG_CAP;
    const PREFIX_ALLOW_LINH_MUC_CHUC_THANH = 'linh.muc.chuc.thanh';
    public static $linhMucChucThanhAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_LINH_MUC_CHUC_THANH;
    const PREFIX_ALLOW_GIAO_PHAN = 'giao.phan';
    public static $giaoPhanAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_GIAO_PHAN;
    const PREFIX_ALLOW_GIAO_HAT = 'giao.hat';
    public static $giaoHatAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_GIAO_HAT;
    const PREFIX_ALLOW_GIAO_XU = 'giao.xu';
    public static $giaoXuAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_GIAO_XU;
    const PREFIX_ALLOW_GROUP_ALBUMS = 'album.group';
    public static $groupAlbumsAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_GROUP_ALBUMS;
    const PREFIX_ALLOW_ALBUMS = 'album';
    public static $albumsAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_ALBUMS;
    const PREFIX_ALLOW_GIAO_DIEM = 'giao.diem';
    public static $giaoDiemAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_GIAO_DIEM;
    const PREFIX_ALLOW_LE_CHINH = 'le.chinh';
    public static $leChinhAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_LE_CHINH;
    const PREFIX_ALLOW_THANH = 'thanh';
    public static $thanhAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_THANH;
    const PREFIX_ALLOW_CHUC_VU = 'chuc.vu';
    public static $chucVuAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_CHUC_VU;
    const PREFIX_ALLOW_NEWS_GROUP = 'news.group';
    public static $categoryAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_NEWS_GROUP;
    const PREFIX_ALLOW_TIN_TUC = 'tin.tuc';
    public static $tinTucAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_TIN_TUC;
    const PREFIX_ALLOW_SLIDE_INFO_SPECIAL = 'slide.info.specials';
    public static $slideInfoSpecialAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_SLIDE_INFO_SPECIAL;
    const PREFIX_ALLOW_RESTRICT_IP = 'restrict.ip';
    public static $restrictIpAccessName = self::PREFIX_ACCESS_NAME . self::PREFIX_ALLOW_RESTRICT_IP;

    const RULE_SETTING_CODE = 'system_rule';
    const RULE_SETTING_KEY_DATA = 'system_rule_allow';
    const RULE_ACTION_SELECT = ['list' => false, 'add' => false, 'edit' => false, 'delete' => false];
    const RULE_SELECT = [
        'setting' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'thanh' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'linh_muc_van_thu' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'linh_muc_thuyen_chuyen' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'linh_muc_bang_cap' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'linh_muc_chuc_thanh' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'linh_muc' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'le_chinh' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'chuc_vu' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'giao_phan' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'giao_phan_news_group' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'giao_phan_news' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'giao_hat' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'giao_xu' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'giao_diem' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'giao_phan_co_so' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'cong_doan_tu_si' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'dong' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'news_group' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'tin_tuc' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'slide_info_specials' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'album_group' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
        'album' => ['abilities' => self::RULE_ACTION_SELECT, 'all' => false],
    ];

    const NETWORK_TARGET = ['facebook', 'twitter', 'linkedin', 'reddit'];
}
//dd(serialize(Tables::RULE_SELECT));