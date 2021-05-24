<?php
define('DB_PREFIX', 'pc_');
define('APP_TOOL_MM_FILE_MANAGER_UPLOAD_HELPER_CLASS', 'App\Helpers\UploadLocalFilesystem');
define('APP_TOOL_MM_FILE_MANAGER_PATH', 'Image/NewPicture');
define('APP_TOOL_MM_FILE_MANAGER_THUMB_DIR', '.tmb');
define('APP_TOOL_MM_FILE_MANAGER_THUMB_SIZE', 'thumb');

if (!function_exists('fn_mysql_escape')) {
    function fn_mysql_escape($inp)
    {
        if (is_array($inp)) {
            return array_map(__METHOD__, $inp);
        }

        if (!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),
                array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }

        return $inp;
    }
}
