<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\OrderItem;
use App\Product;
use App\ProductInventory;
use App\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct(){
        parent::__construct();
    }

    public function home(){
        $products = Product::all();

        return view('front.pages.home', compact('products'));
    }

    public function products(){
        $products = Product::active()->paginate(6);

        // filter product here

        // url => value
        $breadcrumbs = [
            'products' => 'products',
        ];

        return view('front.pages.product-list', compact('products','breadcrumbs'));
    }

    public function productDetails($slug){
        $product = Product::active()->where('slug', $slug)->firstOrFail();
        if (!$product){
            return redirect()->route('products');
        }

        // check if product is configurable and send attributes
        $attributes = [
            'color' => [
                'black',
                'white',
            ],
            'size' => [
                'S',
                'M',
                'L',
            ]
        ];

        $breadcrumbs = [
            'products' => 'products',
            'notNecessary' => $product->name,
        ];

        return view('front.pages.product-details', compact('product','attributes','breadcrumbs'));
    }

    public function categoryProducts($slug){
        $category = Category::where('slug', $slug)->first();
        $products = $category->products;

        $breadcrumbs = [
            'products' => 'products',
            'notNecessary' => $category->name,
        ];

        return view('front.pages.product-list', compact('products','breadcrumbs'));
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Add to Cart
    public function addToCart(Request $request){
        $product = Product::findOrFail($request->input('product_id'));
        $slug = $product->slug;

        // check if the product is simple or configurable

        // check if the product is already added to the cart

        $attributes = [
            'size' => 'L',
            'color' => 'blue'
        ];

        $itemQuantity = $this->_getItemQuantity(md5($product->id)) + $request->input('qty');
        if ($this->_checkProductInventory($product, $itemQuantity)) {
            dd($product->name . ' Out of Stock');
        }

        $item = [
            'id' => md5($product->id),
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->input('qty'),
            'attributes' => $attributes,
            'associatedModel' => $product,
        ];

        \Cart::add($item);
        \Session::flash('success', $product->name .' has been added to cart');

        return response()->json([
            'qty' => $request->input('qty'),
        ]);
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Cart ###
    public function cart(){
        $items = \Cart::getContent();

        $breadcrumbs = [
            'notNecessary' => 'cart',
        ];

        return view('front.pages.cart', compact('items','breadcrumbs'));
    }

    public function removeItem($itemId){
        \Cart::remove($itemId);

        if (\Cart::isEmpty()) {
            return redirect('/');
        }
        return redirect()->back()->with('success', 'Item removed from cart successfully.');
    }

    public function clearCart(){
        \Cart::clear();

        return redirect('/cart');
    }

    public function updateCart(Request $request){
        $qty = $request->input('qty');
        $cartId = $request->input('id');

        $cartItem = $this->_getCartItem($cartId);
        if ($this->_checkProductInventory($cartItem->associatedModel, $qty)) {
            dd($cartItem->associatedModel->name . ' Out of Stock');
        }

        if ($qty > 0){
            \Cart::update($cartId, [
                'quantity' => [
                    'relative' => false,
                    'value' => $qty,
                ],
            ]);
        }else{
            \Cart::remove($cartId);
        }

        \Session::flash('success', 'The cart has been updated');

        return response()->json([
            'qty' => $qty,
        ]);
    }

    private function _getItemQuantity($itemId){
        $items = \Cart::getContent();
        $itemQuantity = 0;
        if ($items){
            foreach ($items as $item){
                if ($item->id == $itemId){
                    $itemQuantity = $item->quantity;
                    break;
                }
            }
        }

        return $itemQuantity;
    }

    private function _checkProductInventory($product, $itemQuantity){
        if ($itemQuantity > $product->productInventory->qty){
            return true;
        }
    }

    private function _getCartItem($cartId){
        $items = \Cart::getContent();

        return $items[$cartId];
    }
    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Checkout & Payment
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
    #############################################################################################
    #############################################################################################
    #############################################################################################
    ### Profile
    public function profile(Request $request){

        if ($request->isMethod('post')){
            auth()->user()->userDetail->update($request->all());

            \Session::flash('success', 'The information has been successfully updated.');
            return redirect()->back();
        }

        $user = auth()->user();

        $breadcrumbs = [
            'notNecessary' => 'profile',
        ];

        return view('front.pages.user-profile', compact('user','breadcrumbs'));
    }

    #############################################################################################
    #############################################################################################
    #############################################################################################
}
