<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public const CREATED = 'created';
    public const CONFIRMED = 'confirmed';
    public const DELIVERED = 'delivered';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';

    public const ORDERCODE = 'INV';

    public const PAID = 'paid';
    public const UNPAID = 'unpaid';

    public const STATUSES = [
        self::CREATED => 'Created',
        self::CONFIRMED => 'Confirmed',
        self::DELIVERED => 'Delivered',
        self::COMPLETED => 'Completed',
        self::CANCELLED => 'Cancelled',
    ];

    public function isPaid(){ return $this->payment_status == self::PAID; }

    public function isCreated(){ return $this->status == self::CREATED; }

    public function isConfirmed(){ return $this->status == self::CONFIRMED; }

    public function isDelivered(){ return $this->status == self::DELIVERED; }

    public function isCompleted(){ return $this->status == self::COMPLETED; }

    public function isCancelled(){ return $this->status == self::CANCELLED; }

    public function getCustomerFullNameAttribute(){
        return "{$this->customer_first_name} {$this->customer_last_name}";
    }

    public function orderItems(){
        return $this->hasMany('App\OrderItem');
    }

    public function shipment(){
        return $this->hasOne('App\Shipment');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function scopeForUser($query, $user){
        return $query->where('user_id', $user->id);
    }

    public static function generateCode(){
        $dateCode = self::ORDERCODE . '/' . date('Ymd') . '/';
        $orderCode = $dateCode . '00001';

        $lastOrder = self::select([\DB::raw('MAX(orders.code) AS last_code')])
            ->where('code', 'like', $dateCode . '%')
            ->first();

        $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;

        if ($lastOrderCode) {
            $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
            $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);

            $orderCode = $dateCode . $nextOrderNumber;
        }

        if (self::_isOrderCodeExists($orderCode)) {
            return generateOrderCode();
        }

        return $orderCode;
    }

    private static function _isOrderCodeExists($orderCode){
        return Order::where('code', '=', $orderCode)->exists();
    }
}
