<?php
/**
 * The base api controller.
 */

namespace App\Http\Controllers\Api\Admin\Base;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\File;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Image;
use Storage;

class ApiController extends Controller
{
    use AuthorizesRequests;

    /**
     * @var string
     *
     * Default no image.
     */
    public static $thumImgNo = '/images/no-photo.jpg';

    /**
     * @var int
     *
     * Thumb size default .
     */
    public static $thumSize = 40;

    /**
     * @var string
     */
    public static $tmbThumbDir = '.tmb';

    /**
     * @var string
     *
     * Drive file default.
     */
    public static $disk = 'public';

    /**
     * @var string
     */
    public $appName = 'gp-phu-cuong';

    // Success
    const RESPONSE_OK = 2000;
    const RESPONSE_CREATED = 2001;
    const RESPONSE_UPDATED = 2002;
    const RESPONSE_DELETED = 2003;
    const RESPONSE_IN_PROGRESS = 2004;

    // Unexpected error (bug)

    // eg: database connection error
    const RESPONSE_SERVER_ERROR = 5000;

    // eg: JSON request body couldn't be parsed
    const RESPONSE_BAD_REQUEST = 5001;

    // User is not authorised to perform the requested action
    const RESPONSE_AUTHORISATION_FAILED = 5002;

    // eg: no route matches the URL; no entity exists with the specified ID
    const RESPONSE_NOT_FOUND = 5003;

    // Invalid/missing HMAC signature
    const RESPONSE_INVALID_SIGNATURE = 5004;

    // Child entity doesn't belong to parent entity
    const RESPONSE_INVALID_RELATIONSHIP = 5005;

    // API version was not specified, or is invalid
    const RESPONSE_INVALID_API_VERSION = 5006;

    // Client is using an HTTP connection instead of HTTPS
    const RESPONSE_INSECURE_CONNECTION = 5007;

    // conflict || duplicate data
    const RESPONSE_CONFLICT = 5008;

    // Any other error
    const RESPONSE_UNKNOWN_ERROR = 5999;

    /**
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @var int
     */
    protected $returnCode = self::RESPONSE_OK;

    /**
     * @var int
     */
    protected $limit = 5;

    /**
     * @var string
     */
    public static $perPageText = 'perPage';

    /**
     * @var null
     */
    protected $resource = null;

    /**
     * @author: dtphi .
     * ApiController constructor.
     * @param array $middleware
     */
    public function __construct($middleware = [])
    {
        parent::__construct($middleware);
    }

    /**
     * @param $imgOrigin
     * @param int $thumbSize
     * @param int $thumbHeight
     * @param bool $force
     * @return mixed
     */
    public function getThumbnail($imgOrigin, $thumbSize = 0, $thumbHeight = 0, $force = false)
    {
        $imgThumUrl = '';
        if ($thumbSize <= 0) {
            $thumbSize = self::$thumSize;
        }

        $staticThumImg = rawurldecode(trim($imgOrigin, '/'));
        if (!file_exists(public_path('/' . $staticThumImg))) {
            $staticThumImg = trim(self::$thumImgNo, '/');
        }

        if ($force) {
            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        }

        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        } else {
            $thumbDir = self::$tmbThumbDir . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize);
        }
    }

    /**
     * @param $staticThumImg
     * @param int $thumbSize
     * @param int $thumbHeight
     * @return mixed
     */
    public function forceThumbnail($staticThumImg, $thumbSize = 200, $thumbHeight = 0)
    {
        $fileResize = new File(public_path($staticThumImg));
        $extension  = $fileResize->extension();
        $thumbDir   = self::$tmbThumbDir . '/' . $staticThumImg;
        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            $resize   = Image::make($fileResize)->resize($thumbSize, $thumbHeight)->encode($extension);
        } else {
            $resize = Image::make($fileResize)->resize($thumbSize, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($extension);
        }

        Storage::disk(self::$disk)->put($thumbDir, $resize->__toString());

        return Storage::url($thumbDir);
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @author : dtphi .
     * @return null
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return mixed
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @param mixed $returnCode
     *
     * @return $this
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    private function respond($data, $headers = [])
    {
        $data['code'] = $this->getReturnCode();

        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @param $newId
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($message, $newId)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)
            ->setReturnCode(self::RESPONSE_CREATED)
            ->respond([
                'result' => [
                    'message' => $message,
                    'id'      => $newId,
                ],
            ]);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondDeleted($message = 'Deleted')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->setReturnCode(self::RESPONSE_DELETED)
            ->respond([
                'message' => $message,
            ]);
    }

    /**
     * @param string $message
     * @param int $returnCode
     * @param array|null $data | An optional associative array of data to be returned
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondBadRequest(
        $message = 'Invalid request',
        $returnCode = self::RESPONSE_BAD_REQUEST,
        array $data = null
    ) {
        return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)
            ->setReturnCode($returnCode)
            ->respondWithError($message, $data);
    }

    /**
     * @author : dtphi .
     * @param null $resource
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUpdated($resource = null, $message = 'Updated')
    {
        $this->resource = $resource;

        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->setReturnCode(self::RESPONSE_UPDATED)
            ->respond([
                'message' => $message,
            ]);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithData($data)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->setReturnCode(self::RESPONSE_OK)
            ->respond([
                'data' => $data,
            ]);
    }

    /**
     * @author : dtphi .
     * @param $data
     * @return mixed
     */
    public function respondWithCollectionPagination($data)
    {
        return $data;
    }

    /**
     * @param string $message
     * @param array|null $data An optional associative array of data to be returned
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message, array $data = null)
    {
        if ($this->getReturnCode() === self::RESPONSE_OK) {
            // this really should not happen as the
            // return code should be set when responding
            $this->setReturnCode(self::RESPONSE_SERVER_ERROR);
        }

        $payload = [
            'message'     => $message,
            'status_code' => $this->getStatusCode(),
        ];

        if (is_array($data)) {
            $payload = array_merge($payload, $data);
        }

        return $this->respond([
            'error' => $payload,
        ]);
    }

    /**
     * @author: dtphi .
     * @return int
     */
    protected function _getPerPage()
    {
        return (int)request()->query(self::$perPageText, $this->limit);
    }

    /**
     * @author : dtphi .
     * @param LengthAwarePaginator $paginator
     * @return array
     */
    protected function _getTextPagination(LengthAwarePaginator $paginator)
    {
        $data = [];

        if ($paginator instanceof LengthAwarePaginator && $paginator->count()) {
            $data = $paginator->toArray();

            unset($data['data']);
        }

        return $data;
    }
}
