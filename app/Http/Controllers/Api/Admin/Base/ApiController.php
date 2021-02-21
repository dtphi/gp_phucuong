<?php

namespace App\Http\Controllers\Api\Admin\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Success
    const RESPONSE_OK = 2000;
    const RESPONSE_CREATED = 2001;
    const RESPONSE_UPDATED = 2002;
    const RESPONSE_DELETED = 2003;
    const RESPONSE_IN_PROGRESS = 2004;

    /**
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @var int
     */
    protected $returnCode = self::RESPONSE_OK;

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
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUpdated($message = 'Updated')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->setReturnCode(self::RESPONSE_UPDATED)
            ->respond([
                'message' => $message,
            ]);
    }
}
