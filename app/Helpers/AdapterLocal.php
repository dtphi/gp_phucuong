<?php

namespace App\Helpers;

use iutbay\yii2\mm\models\Thumb;
use League\Flysystem\Adapter\Local;
use Yii;

/**
 * AdapterLocal
 *
 * @author Phi
 */
class AdapterLocal extends Local
{
    /**
     * Thumb size
     */
    const SIZE_THUMB = 'thumb';

    /**
     * Medium size.
     */
    const SIZE_MEDIUM = 'medium';

    /**
     * Lage size.
     */
    const SIZE_LARGE = 'large';

    /**
     * Full size.
     */
    const SIZE_FULL = 'full';

    /**
     * @var array
     * Image extensions .
     */
    public static $extensions = [
        'jpg'  => 'jpeg',
        'jpeg' => 'jpeg',
        'png'  => 'png',
        'gif'  => 'gif',
        'bmp'  => 'bmp',
    ];

    /**
     * @var array
     * Image size array.
     */
    public static $sizes = [
        self::SIZE_THUMB  => [150, 150],
        self::SIZE_MEDIUM => [300, 300],
        self::SIZE_LARGE  => [600, 600],
    ];

    /**
     * @var string thumbs default size
     */
    public static $thumbsSize = self::SIZE_THUMB;

    /**
     * @inheritdoc
     */
    public function listContents($directory = '', $recursive = false)
    {
        $result   = [];
        $location = $this->applyPathPrefix($directory);

        if (!is_dir($location)) {
            return [];
        }

        $iterator = $recursive ? $this->getRecursiveDirectoryIterator($location) : $this->getDirectoryIterator($location);

        foreach ($iterator as $file) {
            $path = $this->getFilePath($file);

            if (preg_match('#(^|/|\\\\)\.{1,2}$#', $path)) {
                continue;
            }

            $node = $this->normalizeFileInfo($file);
            if ($node['type'] === 'file') {
                $thumb = Yii::createObject([
                    'class' => Thumb::className(),
                    'path'  => self::getThumbSrc($path),
                ]);
                if ($thumb->validate() && $thumb->save()) {
                } else {
                    throw new \yii\web\NotFoundHttpException($path);
                }
            }

            $result[] = $node;
        }

        unset($iterator);

        return array_filter($result);
    }

    /**
     * Get thumb src
     * @param string $path
     * @param string $size
     */
    public static function getThumbSrc($path, $size = null)
    {
        if ($size === null) {
            $size = self::$thumbsSize;
        }

        $regexp = '#^(.*)\.(' . self::getExtensionsRegexp() . ')$#';
        if (preg_match($regexp, $path, $matches) && in_array($size, array_keys(self::$sizes))) {
            $size    = self::$sizes[$size];
            $dstPath = "{$matches[1]}_{$size[0]}x{$size[1]}.{$matches[2]}";

            return $dstPath;
        } else {
            if (in_array($path, config('filesystems.ignores'))) {
                return 'no_image.jpg';
            }
            throw new \yii\base\InvalidParamException();
        }
    }

    /**
     * Get extensions regexp
     * @return string regexp
     */
    public static function getExtensionsRegexp()
    {
        $keys = array_keys(self::$extensions);

        return '(?i)' . join('|', $keys);
    }
}
