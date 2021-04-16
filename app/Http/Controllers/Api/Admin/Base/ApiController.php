<?php

namespace App\Http\Controllers\Api\Admin\Base;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiController extends Controller
{
    use AuthorizesRequests;

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
    const RESPONSE_SERVER_ERROR = 3000;  // eg: database connection error
    const RESPONSE_BAD_REQUEST = 3001;  // eg: JSON request body couldn't be parsed
    const RESPONSE_AUTHORISATION_FAILED = 3002;  // User is not authorised to perform the requested action
    const RESPONSE_NOT_FOUND = 3003;  // eg: no route matches the URL; no entity exists with the specified ID
    const RESPONSE_INVALID_SIGNATURE = 3004;  // Invalid/missing HMAC signature
    const RESPONSE_INVALID_RELATIONSHIP = 3005;  // Child entity doesn't belong to parent entity
    const RESPONSE_INVALID_API_VERSION = 3006;  // API version was not specified, or is invalid
    const RESPONSE_INSECURE_CONNECTION = 3007;  // Client is using an HTTP connection instead of HTTPS
    const RESPONSE_CONFLICT = 3008; // conflict || duplicate data
    const RESPONSE_UNKNOWN_ERROR = 3999;  // Any other error

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
     * @param       $data
     * @param array $headers
     *
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
     *
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
     * @param $message
     *
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
     * @param string|null $message
     * @param int $returnCode
     * @param array|null $data An optional associative array of data to be returned
     *
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
