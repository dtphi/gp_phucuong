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
}
