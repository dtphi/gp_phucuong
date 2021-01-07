<?php

namespace App\Models;

use App\Helpers\Constants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StorePurchaseHistory
 *
 * @package App\Models
 */
class StorePurchaseHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_purchase_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_code',
        'store_name',
        'order_date',
        'manufacturer_name',
        'model',
        'product_name',
        'unit_price',
        'quantity'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'purchase_date' => 'date'
    ];

    /**
     * Get the store that owns the purchase.
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_code', 'code');
    }

    /**
     * Get all purchase histories.
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function getHistories(array $data)
    {
        $query = self::select();

        if (isset($data['search'])) {
            $query->where(function($query) use ($data) {
                $query->where('manufacturer_name', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('product_name', 'LIKE', '%' . $data['search'] . '%')
                      ->orWhere('model', 'LIKE', '%' . $data['search'] . '%');
            });
        }

        if (isset($data['month'])) {
            $startDate = Carbon::create($data['month'])->startOfMonth()->startOfDay();
            $endDate = Carbon::create($data['month'])->endOfMonth()->endOfDay();

            $query->whereBetween('order_date', [$startDate, $endDate]);
        }

        $query->whereNull('deleted_at')
            ->where('store_code', $data['code'])
            ->orderBy('order_date', $data['direction']);

        $total   = $query->count();
        $models  = $query->offset(Constants::PURCHASE_HISTORY_PER_PAGE * ($data['page'] - 1))
                         ->limit(Constants::PURCHASE_HISTORY_PER_PAGE)
                         ->get()
                         ->toArray();

        foreach ($models as &$model) {
            $model = self::formatPurchase($model);
        }

        return [
            'total' => $total,
            'data'  => $models
        ];
    }

    /**
     * Get purchase by id.
     *
     * @param int  $id
     * @param bool $includeDeleted
     *
     * @return mixed
     */
    public static function getPurchaseById(int $id, string $storeCode, bool $includeDeleted = false)
    {
        $query = self::where('id', $id)->where('store_code', $storeCode);

        if (!$includeDeleted) {
            $query->whereNull('deleted_at');
        }
        return self::formatPurchase($query->first());
    }

    public static function formatPurchase($data) {
        if (!$data) {
            return $data;
        }

        if ($data instanceof StorePurchaseHistory) {
            $data->order_date = Carbon::parse($data->order_date)->format('Y年m月d日');

            if (is_numeric($data->unit_price)) {
                $data->unit_price = '¥' . number_format($data->unit_price, 0, '.', ',');
            }
        } else {
            $data['order_date'] = Carbon::parse($data['order_date'])->format('Y年m月d日');

            if (is_numeric($data['unit_price'])) {
                $data['unit_price'] = '¥' . number_format($data['unit_price'], 0, '.', ',');
            }
        }

        return $data;
    }
}
