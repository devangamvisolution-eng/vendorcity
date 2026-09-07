<?php

namespace App\Models\front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciorder extends Model
{
    use HasFactory;

    protected $table = 'ci_orders';

    protected $primaryKey = 'order_id';

    public $timestamps = false;

    protected $fillable = [
        'format_order_id',
        'user_id',
        'order_number',
        'order_total',
        'shippingcost',
        'vatcharge',
        'front_wallet_amount',
        'order_currency',
        'order_status',
        'cancel_date_time',
        'paymentmode',
        'payment_status',
        'payment_id',
        'currency',
        'created_at',
        'coupan_to_wallet',
        'coupondiscount',
        'coupon_code',
        'list_order_status',
        'vendor_id',
        'service_charge',
        'additional_charge',
        'promo_discount',
        'cleaning_discount_additional',
        'date_charge',
        'time_charge',
        'cleaner_per_hour_charge',
        'material_charge_per_hour',
        'timing_charge',
        'sub_total',
        'cod_charge',
        'service_fee',
        'order_from',
        'moving_date',
        'is_delete',
        'send_notification',
        'cron_mail_send',
        'subservice_code',
        'city_code',
        'order_year',
        'sequence_no',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically set currency when creating a new order
        static::creating(function ($model) {
            $model->order_currency = 'AED';
        });

        // Optional: Ensure it remains AED if updated
        static::updating(function ($model) {
            $model->order_currency = 'AED';
        });
    }

    public function scopeOrderId($query, $id)
    {
        return $query->where('order_id', $id);
    }

    public function scopeUserInfoId($query, $userInfoId)
    {
        return $query->where('user_info_id', $userInfoId);
    }

    public function scopeSubserviceCode($query, $subserviceCode)
    {
        return $query->where('subservice_code', $subserviceCode);
    }

    public function scopeCityCode($query, $cityCode)
    {
        return $query->where('city_code', $cityCode);
    }

    public function scopeOrderYear($query, $orderYear)
    {
        return $query->where('order_year', $orderYear);
    }

    public function getPaymentStatusLabelAttribute()
    {
        return match ($this->payment_status) {
            'Success' => '<span class="badge bg-success">Success</span>',
            'FAILED' => '<span class="badge bg-danger">Failed</span>',
            default   => '<span class="badge bg-warning text-dark">Pending</span>',
        };
    }
}
