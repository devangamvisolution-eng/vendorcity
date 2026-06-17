<?php

namespace App\Models\front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CiShippingAddress extends Model
{
    use HasFactory;

    protected $table = 'ci_shipping_address';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'order_id',
        'first_name',
        'last_name',
        'company',
        'address1',
        'address2',
        'city',
        'post_code',
        'country',
        'state',
        'phone_number',
        'email_address',
        'bill_first_name',
        'bill_last_name',
        'bill_company',
        'bill_address1',
        'bill_address2',
        'bill_city',
        'bill_post_code',
        'bill_country',
        'bill_state',
        'bill_phone_number',
        'bill_email_address',
        'additional_message',
        'payment_method',
        'zipcode',
        'emirate',
        'area',
    ];

    public function scopeOrderId($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    public function scopeUserId($query, $userId)
    {
        return $query->where('order_id', $userId);
    }
}
