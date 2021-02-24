<?php
namespace App\Helpers;

use creocoder\flysystem\LocalFilesystem;

/**
 * UploadLocalFilesystem
 *
 * @author Phi
 */
class UploadLocalFilesystem extends LocalFilesystem
{
    /**
     * @return Local
     */
    protected function prepareAdapter()
    {
        return new AdapterLocal($this->path);
    }
}
