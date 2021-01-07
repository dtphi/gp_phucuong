<?php

namespace App\Models;

use App\Helpers\Constants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Message
 *
 * @package App\Models
 */
class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id',
        'sender_type',
        'sender_id',
        'contents',
        'file',
        'meta',
        'reply',
        'can_join',
        'sent_at'
    ];

    /**
     * Get all messages by store id.
     *
     * @param array $data
     *
     * @return array
     */
    public static function getMessages(array $data)
    {
        $query = self::select();

        if ($data['sender_type'] == 2) {
            $query->where('sender_type', 1);
        } else {
            $query->where('sender_type', '!=', 1);
        }
        return $query->whereIn('store_id', $data['store_id'])->whereNull('deleted_at')->get()->toArray();
    }

    /**
     * Get all messages by store id.
     *
     * @param $storeId
     * @param $page
     *
     * @return mixed
     */
    public static function getMessagesByStoreId($storeId, $page)
    {
        return self::select([
                                'messages.id',
                                'messages.store_id',
                                'messages.sender_type',
                                'messages.sender_id',
                                'messages.contents',
                                'messages.file',
                                'messages.meta',
                                'messages.reply',
                                'messages.sent_at',
                                'messages.created_at',
                                'messages.updated_at',
                                'messages.deleted_at',
                                'stores.name',
                                DB::raw('CONCAT(sales_representatives.last_name, "　", sales_representatives.first_name) AS full_name'),
                                DB::raw('CONCAT(sales_representatives.last_name_kana, "　", sales_representatives.first_name_kana) AS full_name_kana')
                            ])
                   ->join('stores', 'messages.store_id', '=', 'stores.id')
                   ->leftJoin('sales_representatives', 'messages.sender_id', '=', 'sales_representatives.id')
                   ->where('messages.store_id', $storeId)
                   ->orderByDesc('messages.created_at')
                   ->offset(Constants::MESSAGES_PER_PAGE * ($page - 1))
                   ->limit(Constants::MESSAGES_PER_PAGE)
                   ->get()
                   ->toArray();
    }

    /**
     * Get last message by store id.
     *
     * @param int  $storeId
     * @param bool $showInRoomList
     *
     * @return mixed
     */
    public static function getLastMessageByStoreId(int $storeId, bool $showInRoomList = false)
    {
        $query = self::where('store_id', $storeId);

        if ($showInRoomList) {
            $query->where('sender_type', '!=', 3);
        }
        return $query->orderByDesc('created_at')->first();
    }

    /**
     * Get all sender id by store id
     *
     * @param int $storeId
     * @param int $exceptRepresentativeId
     *
     * @return mixed
     */
    public static function getRepresentativesIdsByStoreId(int $storeId, int $exceptRepresentativeId = 0)
    {
        $where = [
            [ 'store_id', $storeId ],
            [ 'sender_type', 2 ]
        ];

        if ($exceptRepresentativeId != 0) {
            $where[] = [ 'sender_id', '!=', $exceptRepresentativeId ];
        }
        return self::where($where)->pluck('sender_id');
    }

    /**
     * Get info for send email by id.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function getInfoForSendEmailById($id)
    {
        return self::select([
                                'messages.sender_type',
                                'messages.contents',
                                'messages.file',
                                'stores.code',
                                'stores.name',
                                'sales_representatives.employee_number',
                                DB::raw('CONCAT(sales_representatives.last_name, "　", sales_representatives.first_name) AS full_name'),
                                'sales_representatives.main_email'
                            ])
                   ->join('stores', 'messages.store_id', '=', 'stores.id')
                   ->join('sales_representatives', 'stores.sale_rep_id', '=', 'sales_representatives.id')
                   ->where('messages.id', $id)
                   ->first();
    }

    /**
     * Create new message.
     *
     * @param array $request
     */
    public static function createMessage(array $request)
    {
        $now = Carbon::now();
        $data = [
            'store_id'    => $request['store_id'],
            'sender_type' => $request['sender_type'],
            'sender_id'   => $request['sender_id'],
            'contents'    => $request['contents'],
            'file'        => isset($request['file']) ? serialize($request['file']) : null,
            'meta'        => serialize($request['meta']),
            'reply'       => isset($request['reply']) ? serialize($request['reply']) : null,
            'sent_at'     => $now,
            'created_at'  => $now,
            'updated_at'  => $now
        ];
        self::insert($data);
    }

    /**
     * Update message.
     *
     * @param array $request
     */
    public static function updateMessage(array $request)
    {
        $now = Carbon::now();
        $data = [
            'contents'   => $request['contents'],
            'file'       => isset($request['file']) ? serialize($request['file']) : null,
            'sent_at'    => $now,
            'updated_at' => $now
        ];
        self::where('id', $request['id'])->update($data);
    }

    /**
     * Delete message.
     *
     * @param int $id
     */
    public static function deleteMessage(int $id)
    {
        self::where('id', $id)->update([ 'deleted_at' => Carbon::now() ]);
    }

    /**
     * Reject join to system by sale representative id.
     *
     * @param int $representativeId
     */
    public static function rejectJoinByRepresentativeId(int $representativeId)
    {
        $where = [
            [ 'sender_type', 2 ],
            [ 'sender_id', $representativeId ]
        ];
        $data = [
            'can_join'   => 0,
            'updated_at' => Carbon::now()
        ];
        self::where($where)->update($data);
    }

    /**
     * Reject join to system by store id.
     *
     * @param int $storeId
     */
    public static function rejectJoinByStoreId(int $storeId)
    {
        $data = [
            'can_join'   => 0,
            'updated_at' => Carbon::now()
        ];
        self::where('store_id', $storeId)->update($data);
    }
}
