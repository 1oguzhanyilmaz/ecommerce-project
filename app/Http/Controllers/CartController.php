<?php

namespace App\Http\Controllers;

use App\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
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
}
