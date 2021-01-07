<?php

namespace App\Http\Controllers\Api\Message;

use App\Helpers\Constants;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Jobs\Representative\SendEmailNotifyNewMessage as RepresentativeSendEmailNotifyNewMessage;
use App\Jobs\Representative\SendSubEmailNotifyMessage;
use App\Jobs\Store\SendEmailNotifyNewMessage as StoreSendEmailNotifyNewMessage;
use App\Models\Message;
use App\Models\Representative;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Class MessageController
 *
 * @package App\Http\Controllers\Api\Message
 */
class MessageController extends Controller
{
    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/messages/get-employee/{id}
     */
    public function getEmployee($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $representative = Representative::getRepresentativeById($id);

        if (!isset($representative)) {
            return Helper::errorResponse();
        }
        return Helper::successResponse([ 'employee' => $representative->toArray() ]);
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @api GET /v1/{role}/messages/get-store/{id}
     */
    public function getStore($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        $store = Store::getStoreById($id);

        if (!isset($store)) {
            return Helper::errorResponse();
        }
        $users = [
            [
                '_id'      => 'store-' . $id,
                'id'       => $id,
                'username' => $store->name
            ]
        ];
        $lastMessage = [
            'content' => '',
            'saved'   => false,
            'deleted' => false,
            'sentAt'  => 0
        ];
        $senderIds = Message::getRepresentativesIdsByStoreId($id);
        $representatives = [];

        if (!empty($senderIds)) {
            foreach ($senderIds as $senderId) {
                $representative = Representative::getRepresentativeById($senderId, true);

                if (isset($representative)) {
                    $users[] = [
                        '_id'      => 'sale-' . $representative->id,
                        'id'       => $representative->id,
                        'username' => $this->__getSenderName(2, '', $representative->full_name)
                    ];
                    $representatives[] = $representative->toArray();
                }
            }
        }
        $message = Message::getLastMessageByStoreId($id);

        if (isset($message)) {
            $sale = array_reduce($representatives, function($accumulator, $sale) use ($message) {
                if ($sale['id'] == $message->sender_id) {
                    $accumulator = $sale;
                }
                return $accumulator;
            }, []);
            $lastMessage = $this->__convertMessage($message->toArray(), $store->name, !empty($sale) ? $sale['full_name'] : '');
        }
        $room = [
            'storeId'     => $id,
            'roomId'      => Carbon::now()->getTimestamp(),
            'roomName'    => $store->name,
            'lastMessage' => $lastMessage,
            'users'       => $users
        ];
        return Helper::successResponse([ 'store' => $room ]);
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @api GET /v1/representative/messages/get-stores/{id}
     */
    public function getStores($id = null)
    {
        if (!$id || $id != $this->guard('representatives')->id()) {
            return Helper::errorResponse();
        }
        $representative = Representative::getRepresentativeById($id);

        if (!isset($representative)) {
            return Helper::errorResponse();
        }
        $rooms = [];
        $dealers = Store::getDealers($id);

        foreach ($dealers as $index => $dealer) {
            $users = [
                [
                    '_id'      => 'store-' . $dealer['id'],
                    'id'       => $dealer['id'],
                    'username' => $dealer['name']
                ],
                [
                    '_id'      => 'sale-' . $id,
                    'id'       => $id,
                    'username' => $this->__getSenderName(2, '', $representative->full_name)
                ]
            ];
            $lastMessage = [
                'content' => '',
                'saved'   => false,
                'deleted' => false,
                'sentAt'  => 0
            ];
            $senderIds = Message::getRepresentativesIdsByStoreId($dealer['id'], $id);
            $representatives = [ $representative->toArray() ];

            if (!empty($senderIds)) {
                foreach ($senderIds as $senderId) {
                    $sale = Representative::getRepresentativeById($senderId, true);

                    if (isset($sale)) {
                        $users[] = [
                            '_id'      => 'sale-' . $sale->id,
                            'id'       => $sale->id,
                            'username' => $this->__getSenderName(2, '', $sale->full_name)
                        ];
                        $representatives[] = $sale->toArray();
                    }
                }
            }
            $message = Message::getLastMessageByStoreId($dealer['id'], true);

            if (isset($message)) {
                $sale = array_reduce($representatives, function($accumulator, $sale) use ($message) {
                    if ($sale['id'] == $message->sender_id) {
                        $accumulator = $sale;
                    }
                    return $accumulator;
                }, []);
                $lastMessage = $this->__convertMessage($message->toArray(), $dealer['name'], !empty($sale) ? $sale['full_name'] : '');
            }
            $data = [
                'sender_type' => 2,
                'store_id'    => [ $dealer['id'] ]
            ];
            $messages = Message::getMessages($data);
            $unread = 0;

            foreach ($messages as $message) {
                $meta = unserialize($message['meta']);

                if (!$meta['seen']) {
                    $unread++;
                }
            }
            $rooms[] = [
                'storeId'     => $dealer['id'],
                'roomId'      => Carbon::now()->getTimestamp() + $index,
                'roomName'    => $dealer['name'],
                'lastMessage' => $lastMessage,
                'users'       => $users,
                'unreadCount' => $unread,
                'store'       => $dealer
            ];
        }
        usort($rooms, function($room1, $room2) {
            return $room2['lastMessage']['sentAt'] <=> $room1['lastMessage']['sentAt'];
        });

        return Helper::successResponse([ 'stores' => $rooms ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @api GET /v1/{role}/messages/get-message
     */
    public function getMessage(Request $request)
    {
        if (isset($request['id'])) {
            $message = Message::find($request['id']);
        } else {
            $message = Message::getLastMessageByStoreId($request['storeId']);
        }
        $store = Store::getStoreById($request['storeId']);
        $representative = Representative::getRepresentativeById($store->sale_rep_id);

        return Helper::successResponse([ 'message' => $this->__convertMessage($message->toArray(), $store->name, $representative->full_name) ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @api GET /v1/{role}/messages/get-messages
     */
    public function getMessages(Request $request)
    {
        $messages = Message::getMessagesByStoreId($request['id'], $request['page']);
        $messagesConverted = [];
        $totalMessages = count($messages);
        $viewer = isset($request['viewer']) ? $request['viewer'] : 'user';

        for ($idx = 0; $idx < $totalMessages; $idx++) {
            $showUsername = true;
            $message = $messages[$idx];
            $representativeName = '';

            if ($idx + 1 < $totalMessages) {
                $nextMessage = $messages[$idx + 1];

                if ($message['sender_type'] == 1 && $nextMessage['sender_type'] == 1) {
                    $showUsername = false;
                } else if ($message['sender_type'] == 2 && $nextMessage['sender_type'] == 2) {
                    if ($message['sender_id'] == $nextMessage['sender_id']) {
                        $showUsername = false;
                    }
                }
            }
            if ($message['sender_type'] == 2) {
                $representativeName = $message['full_name'];
            }
            $message['show_username'] = $showUsername;
            $messageConverted = $this->__convertMessage($message, $message['name'], $representativeName, $viewer);
            $messagesConverted[] = $messageConverted;
        }
        return Helper::successResponse([ 'messages' => $messagesConverted ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/{role}/messages/count-unread
     */
    public function countUnread(Request $request)
    {
        $data = [
            'sender_type' => $request['senderType']
        ];

        if ($request['senderType'] == 2) {
            $stores = Store::getDealers($request['representativeId']);

            $data['store_id'] = array_values(array_column($stores, 'id'));
        } else {
            $data['store_id'] = [ $request['storeId'] ];
        }
        $messages = Message::getMessages($data);
        $unread = 0;

        foreach ($messages as $message) {
            $meta = unserialize($message['meta']);

            if (!$meta['seen']) {
                $unread++;
            }
        }
        return Helper::successResponse([ 'unread' => $unread ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api PUT /v1/{role}/messages/mark-seen
     */
    public function markSeen(Request $request)
    {
        $message = Message::where('id', $request['id'])->lockForUpdate()->first();

        $meta = unserialize($message->meta);
        $meta['seen'] = true;
        $message->update([ 'meta' => serialize($meta) ]);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @api POST /v1/{role}/messages/send-message
     */
    public function sendMessage(Request $request)
    {
        $request['data'] = json_decode($request['data']);
        $data = [
            'store_id'    => $request['data']->storeId,
            'sender_type' => $request['data']->senderType,
            'sender_id'   => $request['data']->senderType == 2 ? $request['data']->senderId : 0,
            'contents'    => $request['data']->content,
            'meta'        => [
                'seen'      => false,
                'reactions' => []
            ]
        ];
        $uploadPath = Constants::UPLOAD_FOLDER . $request['data']->storeId;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->storeAs($uploadPath, $request['data']->fileName, 'public');
            $parts = pathinfo($filePath);

            $data['file'] = [
                'isFile' => true,
                'name'   => $parts['basename'],
                'url'    => $filePath
            ];
        }
        if (isset($request['images'])) {
            $data['file'] = [];

            foreach ($request['images'] as $image) {
                $img = Image::make($image->path());

                if ($img->height() > 800) {
                    $encode = $img->resize(null, 800, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode();
                    $imagePath = $uploadPath . '/' . Str::random(40) . '.' .$image->getClientOriginalExtension();
                    Storage::disk('public')->put($imagePath, $encode);
                } else {
                    $imagePath = $image->store($uploadPath, 'public');
                }
                $parts = pathinfo($imagePath);

                $data['file'][] = [
                    'name' => $parts['basename'],
                    'url'  => $imagePath
                ];
            }
        }
        if (isset($request['data']->replyMessage)) {
            $data['reply'] = json_decode(json_encode($request['data']->replyMessage), true);
        }
        Message::createMessage($data);

        $store = Store::getStoreById($request['data']->storeId);
        $representative = Representative::getRepresentativeById($store->sale_rep_id);
        $email = [
            'code'            => $store->code,
            'name'            => $store->name,
            'employee_number' => $representative->employee_number,
            'full_name'       => $representative->full_name,
            'main_email'      => $representative->main_email,
            'url'             => $request['data']->senderType == 1 ? url('/sale-representative/message') : url('/store/message')
        ];
        StoreSendEmailNotifyNewMessage::dispatchIf($request['data']->senderType == 2, $store, $email);
        RepresentativeSendEmailNotifyNewMessage::dispatchIf($request['data']->senderType == 1, $representative, $email);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @api POST /v1/{role}/messages/edit-message
     */
    public function editMessage(Request $request)
    {
        $request['data'] = json_decode($request['data']);
        $data = [
            'id'       => $request['data']->id,
            'contents' => $request['data']->content
        ];
        $uploadPath = Constants::UPLOAD_FOLDER . $request['data']->storeId;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->storeAs($uploadPath, $request['data']->fileName, 'public');
            $parts = pathinfo($filePath);

            $data['file'] = [
                'isFile' => true,
                'name'   => $parts['basename'],
                'url'    => $filePath
            ];
        }
        if (isset($request['images'])) {
            $data['file'] = [];

            foreach ($request['images'] as $image) {
                $img = Image::make($image->path());

                if ($img->height() > 800) {
                    $encode = $img->resize(null, 800, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode();
                    $imagePath = $uploadPath . '/' . Str::random(40) . '.' .$image->getClientOriginalExtension();
                    Storage::disk('public')->put($imagePath, $encode);
                } else {
                    $imagePath = $image->store($uploadPath, 'public');
                }
                $parts = pathinfo($imagePath);

                $data['file'][] = [
                    'name' => $parts['basename'],
                    'url'  => $imagePath
                ];
            }
        }
        Message::updateMessage($data);

        return Helper::successResponse();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api POST /v1/representative/messages/send-to-sub-emails
     */
    public function sendToSubEmails(Request $request)
    {
        $info = Message::getInfoForSendEmailById($request['id']);

        if ($info) {
            $file = $info->file ? unserialize($info->file) : null;
            $email = [
                'code'            => $info->code,
                'name'            => $info->name,
                'employee_number' => $info->employee_number,
                'full_name'       => $info->full_name,
                'main_email'      => $info->main_email,
                'contents'        => $info->contents,
                'sender_type'     => $info->sender_type,
                'url'             => url('/sale-representative/message')
            ];
            if ($file) {
                if (isset($file['isFile'])) {
                    $email['file'] = $file['name'];
                } else {
                    $email['images'] = true;
                }
            }
            SendSubEmailNotifyMessage::dispatch($request['subEmails'], $email);
        }
        return Helper::successResponse();
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api DELETE /v1/{role}/messages/delete-message/{id}
     */
    public function deleteMessage($id = null)
    {
        if (!$id) {
            return Helper::errorResponse();
        }
        Message::deleteMessage($id);

        return Helper::successResponse();
    }

    /**
     * @param array $message
     *
     * @return string
     */
    private function __getSenderId(array $message)
    {
        switch ($message['sender_type']) {
            case 1:
                return 'store-' . $message['store_id'];
            case 2:
                return 'sale-' . $message['sender_id'];
            default:
                return 'system-0';
        }
    }

    /**
     * Get sender name by sender type
     *
     * @param int    $senderType
     * @param string $storeName
     * @param string $representativeName
     *
     * @return string
     */
    private function __getSenderName(int $senderType, string $storeName, string $representativeName)
    {
        switch ($senderType) {
            case 1:
                return $storeName;
            case 2:
                return $representativeName;
            default:
                return 'システム';
        }
    }

    /**
     * Convert message
     *
     * @param array  $message
     * @param string $storeName
     * @param string $representativeName
     * @param string $viewer
     *
     * @return array
     * @throws \Exception
     */
    private function __convertMessage(array $message, string $storeName, string $representativeName = '', string $viewer = 'user')
    {
        $meta = unserialize($message['meta']);
        $file = null;
        $images = [];
        $reply = null;

        if ($message['file']) {
            $temp = unserialize($message['file']);

            if (isset($temp['isFile'])) {
                $file = [
                    'name' => $temp['name'],
                    'url'  => str_replace('\\', '/', Storage::url($temp['url']))
                ];
            } else {
                foreach ($temp as $image) {
                    $images[] = [
                        'name' => $image['name'],
                        'url'  => str_replace('\\', '/', Storage::url($image['url']))
                    ];
                }
            }
        }
        if ($message['reply']) {
            $reply = unserialize($message['reply']);
        }
        $sendAt = date('Y/m/j', strtotime($message['sent_at']));
        $today = date('Y/m/j');
        $format = $sendAt == $today ? 'G:i' : 'Y年m月j日 G:i';
        $timestamp = date($format, strtotime($message['sent_at']));

        if ($format === 'G:i') {
            $timestamp = 'Today, ' . $timestamp;
        }
        $sendAt = new \DateTime($message['sent_at']);
        $createdAt = new \DateTime($message['created_at']);
        $interval = $createdAt->diff($sendAt);

        return [
            'id'           => $message['id'],
            'content'      => $message['contents'],
            'sender_id'    => $this->__getSenderId($message),
            'sender_type'  => $message['sender_type'],
            'username'     => $this->__getSenderName($message['sender_type'], $storeName, $representativeName),
            'showUsername' => isset($message['show_username']) ? $message['show_username'] : true,
            'timestamp'    => $timestamp,
            'date'         => date('Y年m月j日', strtotime($message['sent_at'])),
            'saved'        => true,
            'seen'         => $viewer != 'admin' ? $meta['seen'] : false,
            'file'         => $file,
            'images'       => $images,
            'replyMessage' => $reply,
            'edited'       => $interval->i != 0,
            'deleted'      => $message['deleted_at'] != null,
            'sentAt'       => $message['sent_at'],
            'createdAt'    => strtotime($message['created_at']) + rand(),
            'updatedAt'    => strtotime($message['updated_at']) + rand(),
            'deletedAt'    => ($message['deleted_at'] != null ? strtotime($message['deleted_at']) : 0) + rand()
        ];
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @param string $name
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    private function guard(string $name)
    {
        return Auth::guard($name);
    }
}
