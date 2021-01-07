<?php

namespace App\Http\Controllers\Api\Store;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Store\Reorder;
use App\Models\Message;
use App\Models\StorePurchaseHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class PurchaseHistoryController
 *
 * @package App\Http\Controllers\Api\Store
 */
class PurchaseHistoryController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/purchase-history
     */
    public function index(Request $request)
    {
        $data = [
            'page'      => $request['page'] ?: 1,
            'code'      => $request['code'],
            'direction' => 'desc',
        ];

        if (isset($request['search']) && !empty($request['search'])) {
            $data['search'] = $request['search'];
        }

        if (isset($request['month']) && !empty($request['month'])) {
            $data['month'] = $request['month'];
        }

        if (isset($request['direction']) && !empty($request['direction'])) {
            $data['direction'] = $request['direction'];
        }

        $purchaseHistories = StorePurchaseHistory::getHistories($data);

        return Helper::successResponse([ 'histories' => $purchaseHistories ]);
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/purchase-history/show/{id}
     */
    public function show($id = null, Request $request)
    {
        if (!$id) {
            return Helper::errorResponse();
        }

        $purchase = StorePurchaseHistory::getPurchaseById($id, $request['storeCode']);

        if (!isset($purchase)) {
            return Helper::errorResponse();
        }

        return Helper::successResponse([ 'purchase' => $purchase ]);
    }

    /**
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @api GET /v1/store/purchase-history/reorder/{id}
     */
    public function reorder(Request $request)
    {
        if (!$request['purchaseId']) {
            return Helper::errorResponse();
        }

        $purchase = StorePurchaseHistory::getPurchaseById($request['purchaseId'], $request['storeCode']);

        if (!isset($purchase)) {
            return Helper::errorResponse();
        }

        $store = $purchase->store;
        $representative = $store->representative;

        $mailList = [
            $representative->main_email,
            $representative->sub_email1,
            $representative->sub_email2,
            $representative->sub_email3,
            $representative->sub_email4
        ];

        $typeOptions = [
            'lpg'  => 'LPG',
            '13a'  => '13A',
            'none' => '指定なし',
        ];

        $deliveryOptions = [
            'dealer' => '販売店様',
            'nitto'  => '日東',
        ];

        $type = $typeOptions[$request['form']['type']] ?? '';
        $delivery = $deliveryOptions[$request['form']['delivery']] ?? '';

        $data = [
            'store_name'        => $store->name,
            'store_code'        => $store->code,
            'sale_code'         => $representative->employee_number,
            'sale_full_name'    => $representative->full_name,
            'sale_email'        => $representative->main_email,
            'message_url'       => url('/sale-representative/message'),
            'manufacturer_name' => $purchase->manufacturer_name,
            'product_name'      => $purchase->product_name,
            'model'             => $purchase->model,
            'type'              => $type,
            'delivery'          => $delivery,
            'quantity'          => $request['form']['quantity'],
        ];

        foreach ($mailList as $mail) {
            if ($mail) {
                Mail::to($mail)->send(new Reorder($data));
            }
        }

        $messageContent =
        "下記の通りに発注いたします。

        【発注内容】
        メーカー：" . $data['manufacturer_name'] . "
        商品名：" . $data['product_name'] . "
        型式：" . $data['model'] . "
        ガス種：" . $data['type'] . "
        納品場所：" . $data['delivery'] . "
        数量：" . $data['quantity'];

        Message::create([
                            'store_id'    => $store->id,
                            'sender_type' => 1,
                            'sender_id'   => 0,
                            'contents'    => $messageContent,
                            'meta'        => serialize([
                                                           'seen'      => false,
                                                           'reactions' => []
                                                       ])
                        ]);

        return Helper::successResponse();
    }
}
