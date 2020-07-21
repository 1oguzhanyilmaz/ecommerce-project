<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderItem;
use App\ProductInventory;
use App\Shipment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders(){
        $orders = Order::forUser(\Auth::user())
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('front.pages.orders', compact('orders'));
    }

    public function orderShow($id){
        $order = Order::forUser(\Auth()->user())->findOrFail($id);

        return view('front.pages.order-show', compact('order'));
    }

    public function checkout(){
        if (\Cart::isEmpty()){
            return redirect()->back()->with('success', 'Cart is empty !');
        }

        \Cart::removeConditionsByType('shipping');
        $this->_updateTax();

        $items = \Cart::getContent();
        $totalWeight = $this->_getTotalWeight() / 100;
        $user = \Auth::user();

        $breadcrumbs = [
            'notNecessary' => 'checkout',
        ];

        return view('front.pages.checkout', compact('items','totalWeight','user','breadcrumbs'));
    }

    public function setShipping(Request $request){
        \Cart::removeConditionsByType('shipping');

        $shippingService = $request->get('shipping_service');
        $destination = $request->get('city_id');

        $shippingOptions = $this->_getShippingCost($destination, $this->_getTotalWeight());

        $selectedShipping = null;
        if ($shippingOptions['results']) {
            foreach ($shippingOptions['results'] as $shippingOption) {
                if (str_replace(' ', '', $shippingOption['service']) == $shippingService) {
                    $selectedShipping = $shippingOption;
                    break;
                }
            }
        }

        $status = null;
        $message = null;
        $data = [];
        if ($selectedShipping) {
            $status = 200;
            $message = 'Success set shipping cost';

            $this->_addShippingCostToCart($selectedShipping['service'], $selectedShipping['cost']);

            $data['total'] = number_format(\Cart::getTotal());
        } else {
            $status = 400;
            $message = 'Failed to set shipping cost';
        }

        $response = [
            'status' => $status,
            'message' => $message
        ];

        if ($data) {
            $response['data'] = $data;
        }

        return $response;
    }

    public function placeOrder(OrderRequest $request){
        $params = $request->all();

        $order = \DB::transaction(function () use ($params) {
            $order = $this->_saveOrder($params);
            $this->_saveOrderItem($order);
            $this->_generateToken($order);
            $this->_saveShipment($order, $params);

            return $order;
        });

        if ($order){
            \Cart::clear();
            $this->_sendEmailOrderReceived($order);
            \Session::flash('success', 'Thank you. Your order has been received!');

            return redirect('orders/received/'.$order->id);
        }

        return redirect('orders/checkout');
    }

    public function received($orderId){
        $order = Order::where('id', $orderId)
            ->where('user_id', \Auth()->user()->id)
            ->firstOrFail();

        return view('front.pages.order-received', compact('order'));
    }

    private function _sendEmailOrderReceived($order){
        // to do
    }

    private function _saveOrder($params){
        // $destination = $request->input('city');
        $destination = 'Test';
        $selectedShipping = $this->_getSelectedShipping($destination, $this->_getTotalWeight(), $params['shipping_service']);
//        $selectedShipping = [
//            'cost' => 10,
//            'courier' => 'Courier 1',
//            'service' => 'shipping-1',
//
//        ];

        $baseTotalPrice = \Cart::getSubTotal();
        $taxAmount = \Cart::getCondition('TAX 10%')->getCalculatedValue(\Cart::getSubTotal());
        $taxPercent = (float)\Cart::getCondition('TAX 10%')->getValue();
        $shippingCost = $selectedShipping['cost']; // 5, 10
        $discountAmount = 0;
        $discountPercent = 0;
        $grandTotal = ($baseTotalPrice + $taxAmount + $shippingCost) - $discountAmount;

        $orderDate = date('Y-m-d H:i:s');
        $paymentDue = (new \DateTime($orderDate))->modify('+7 day')->format('Y-m-d H:i:s');

        $orderParams = [
            'user_id' => \auth()->user()->id,
            // 'code' => Order::generateCode(),
            'code' => uniqid(),
            'status' => Order::CREATED,
            'order_date' => $orderDate,
            'payment_due' => $paymentDue,
            'payment_status' => Order::UNPAID,
            'base_total_price' => $baseTotalPrice,
            'tax_amount' => $taxAmount,
            'tax_percent' => $taxPercent,
            'discount_amount' => $discountAmount,
            'discount_percent' => $discountPercent,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'note' => $params['note'],
            'customer_first_name' => $params['first_name'],
            'customer_last_name' => $params['last_name'],
            'customer_address' => $params['address'],
            'customer_phone' => $params['phone'],
            'customer_email' => $params['email'],
            'shipping_courier' => $selectedShipping['courier'],
            'shipping_service_name' => $selectedShipping['service'],
        ];

        return Order::create($orderParams);
    }

    private function _saveOrderItem($order){
        $cartItems = \Cart::getContent();

        if ($order && $cartItems){
            foreach ($cartItems as $item){
                $itemTaxAmount = 0;
                $itemTaxPercent = 0;
                $itemDiscountAmount = 0;
                $itemDiscountPercent = 0;
                $itemBaseTotal = $item->quantity * $item->price;
                $itemSubTotal = $itemBaseTotal + $itemTaxAmount - $itemDiscountAmount;

                $product = isset($item->associatedModel->parent) ? $item->associatedModel->parent : $item->associatedModel;

                $orderItemParams = [
                    'order_id' => $order->id,
                    'product_id' => $item->associatedModel->id,
                    'qty' => $item->quantity,
                    'base_price' => $item->price,
                    'base_total' => $itemBaseTotal,
                    'tax_amount' => $itemTaxAmount,
                    'tax_percent' => $itemTaxPercent,
                    'discount_amount' => $itemDiscountAmount,
                    'discount_percent' => $itemDiscountPercent,
                    'sub_total' => $itemSubTotal,
                    'sku' => $item->associatedModel->sku,
                    'type' => $product->type,
                    'name' => $item->name,
                    'weight' => $item->associatedModel->weight,
                    'attributes' => json_encode($item->attributes),
                ];

                $orderItem = OrderItem::create($orderItemParams);

                if ($orderItem){
                    ProductInventory::reduceStock($orderItem->product_id, $orderItem->qty);
                }
            }
        }
    }

    private function _generateToken($order){
        $order->payment_token = 'TOKEN';
        $order->payment_url = 'URL';
        $order->save();
    }

    private function _saveShipment($order, $params){
        $shippingFirstName = isset($params['ship_to']) ? $params['shipping_first_name'] : $params['first_name'];
        $shippingLasttName = isset($params['ship_to']) ? $params['shipping_last_name'] : $params['last_name'];
        $shippingAddress = isset($params['ship_to']) ? $params['shipping_address'] : $params['address'];
        $shippingPhone = isset($params['ship_to']) ? $params['shipping_phone'] : $params['phone'];
        $shippingEmail = isset($params['ship_to']) ? $params['shipping_email'] : $params['email'];

        $shipmentParams = [
            'user_id' => \Auth::user()->id,
            'order_id' => $order->id,
            'status' => Shipment::PENDING,
            'total_qty' => \Cart::getTotalQuantity(),
            'total_weight' => $this->_getTotalWeight(),
            'first_name' => $shippingFirstName,
            'last_name' => $shippingLasttName,
            'address' => $shippingAddress,
            'phone' => $shippingPhone,
            'email' => $shippingEmail,
        ];

        Shipment::create($shipmentParams);
    }

    private function _getSelectedShipping($destination, $totalWeight, $shippingService){
        $shippingOptions = $this->_getShippingCost($destination, $totalWeight);

        $selectedShipping = null;
        if ($shippingOptions['results']){
            foreach ($shippingOptions['results'] as $shippingOption){
                if (str_replace(' ', '', $shippingOption['service']) == $shippingService){
                    $selectedShipping = $shippingOption;
                    break;
                }
            }
        }

        return $selectedShipping;
    }

    private function _addShippingCostToCart($serviceName, $cost){
        $condition = new \Darryldecode\Cart\CartCondition(
            [
                'name' => $serviceName,
                'type' => 'shipping',
                'target' => 'total',
                'value' => '+'. $cost,
            ]
        );

        \Cart::condition($condition);
    }

    private function _getShippingCost($destination, $weight){
        $params = [
            'origin' => 'here',
            'destination' => $destination,
            'weight' => $weight,
        ];

        $results = [
            [
                'service' => 'shipping-0',
                'cost' => 5,
                'courier' => 'Courier 0',
            ],
            [
                'service' => 'shipping-1',
                'cost' => 10,
                'courier' => 'Courier 1',
            ]
        ];

        $response = [
            'origin' => $params['origin'],
            'destination' => $destination,
            'weight' => $weight,
            'results' => $results,
        ];

        return $response;
    }

    private function couriers(){
        return [
            'courier-0' => 'Courier 0',
            'courier-1' => 'Courier 1',
            'courier-2' => 'Courier 2',
        ];
    }

    private function _updateTax(){
        \Cart::removeConditionsByType('tax');

        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'TAX 10%',
            'type' => 'tax',
            'target' => 'total',
            'value' => '10%',
        ]);

        \Cart::condition($condition);
    }

    private function _getTotalWeight(){
        if (\Cart::isEmpty()){
            return 0;
        }

        $totalWeight = 0;
        $items = \Cart::getContent();

        foreach ($items as $item){
            $totalWeight += ($item->quantity * $item->associatedModel->weight);
        }

        return $totalWeight;
    }
}
