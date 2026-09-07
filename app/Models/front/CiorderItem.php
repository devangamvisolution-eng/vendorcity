<?php

namespace App\Models\front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CiorderItem extends Model
{
    use HasFactory;

    protected $table = 'ci_order_item';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'user_info_id',
        'salesperson_id',
        'driver_id',
        'cleaner_id',
        'cleaner_price',
        'package_id',
        'package_item_name',
        'package_quantity',
        'package_item_price',
        'service_id',
        'service_name',
        'subservice_id',
        'subservice_name',
        'packagecategory_id',
        'packagecategory_name',
        'page_url',
        'image',
        'discount',
        'discount_type',
        'cdate',
        'product_discount_amount',
        'subservice_booking_percentage',
        'is_return',
        'how_many_cleaners_do_you_need',
        'how_many_hours_should_they_stay',
        'how_often_do_you_need_cleaning',
        'do_you_need_cleaning_material',
        'any_special_instruction',
        'address_type',
        'city',
        'area',
        'building_street_no',
        'apartment_villa_no',
        'location_link',
        'bookingdate',
        'month',
        'bookingyear',
        'end_date',
        'time_slot',
        'which_day_of_the_week_do_you_want_the_service',
        'type_of_painting',
        'selected_type_home',
        'selected_size_home',
        'service_charge_price',
        'color_you_want_painted_price',
        'walls_now_price',
        'you_want_paint_color',
        'your_walls_now_color',
        'describe_painting_service',
        'is_home_furnished',
        'no_of_ceilings',
        'verifybuy_package_id',
        'verifybuy_mobile',
        'verifybuy_location',
        'verifybuy_address',
        'verifybuy_additional_details',
        'verifybuy_where_is_car_parked',
        'verifybuy_vehicle',
        'verifybuy_model',
        'verifybuy_category',
        'verifybuy_others',
        'verifybuy_documents',
        'origin_add',
        'origin_country',
        'origin_state',
        'origin_city',
        'origin_location',
        'origin_zip_post',
        'desti_add',
        'desti_country',
        'desti_state',
        'desti_city',
        'desti_location',
        'desti_zip_post',
        'any_special_instruction',
    ];

    public function scopeOrderId($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    public function scopeServiceId($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeSalesPersonId($query, $serviceId)
    {
        return $query->where('salesperson_id', $serviceId);
    }

    public function scopeMovingService($query)
    {
        return $query->where('service_id', 30);
    }

    public function scopeUserAuth($query)
    {
        return $query->where('service_id', 30);
    }

    protected function fullBookingDate(): Attribute
    {
        return Attribute::make(
            get: function () {
                try {
                    $dateString = trim("{$this->bookingdate} {$this->month} {$this->bookingyear}");
                    return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
                } catch (\Exception $e) {
                    return '';
                }
            },
        );
    }
}
