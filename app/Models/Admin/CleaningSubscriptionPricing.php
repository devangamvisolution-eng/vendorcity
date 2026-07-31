<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleaningSubscriptionPricing extends Model
{
    use HasFactory;
    protected $guarded = [];
protected $table = 'cleaning_subscription_pricing';

    

    public function duration()
    {
        return $this->belongsTo(CleaningSubscriptionDuration::class, 'duration_id');
    }

    public function frequency()
    {
        return $this->belongsTo(CleaningSubscriptionFrequency::class, 'frequency_id');
    }

    public function package()
    {
        return $this->belongsTo(CleaningSubscriptionPackage::class, 'package_id');
    }
}
