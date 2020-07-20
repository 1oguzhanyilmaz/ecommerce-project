<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\OutOfStockException;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use App\ProductInventory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $statuses = Order::STATUSES;

        $orders = Order::orderBy('created_at','DESC');

        $status = $request->input('status');
        if ($status && in_array($status, array_keys($statuses))){
            $orders = $orders->orWhere('status', '=',$status);
        }

        $q = $request->input('q');
        if ($q){
            $orders = $orders->where('code','like','%'.$q.'%')
                        ->orWhere('customer_first_name','like','%'.$q.'%')
                        ->orWhere('customer_last_name','like','%'.$q.'%');
        }

        $startDate = $request->input('start');
        $endDate = $request->input('end');

        if ($startDate && !$endDate) {
            \Session::flash('error', 'Date is required');
            return redirect('admin/orders');
        }

        if (!$startDate && $endDate) {
            \Session::flash('error', 'Date is required');
            return redirect('admin/orders');
        }

        if ($startDate && $endDate) {
            if (strtotime($endDate) < strtotime($startDate)){
                \Session::flash('error', 'The end date should be greater or equal than start date');
                return redirect('admin/orders');
            }

            $orders = $orders->whereRaw("DATE(order_date) >= ?", $startDate)
                        ->whereRaw("DATE(order_date) <= ?", $endDate);
        }

        $orders = $orders->paginate(10);

        return view('admin.orders.index', compact('statuses','orders'));
    }

    public function show($id){
        $order = Order::withTrashed()->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function destroy($id){
        $order = Order::withTrashed()->findOrFail($id);

        if ($order->trashed()){
            $canDestroy = \DB::transaction(
                function () use ($order){
                    OrderItem::where('order_id', $order->id)->delete();
                    $order->shipment->delete();
                    $order->forceDelete();

                    return true;
                }
            );

            if ($canDestroy){
                \Session::flash('success', 'The order has been removed permanently');
            }else{
                \Session::flash('success', 'The order could not be removed permanently');
            }

            return redirect('admin/orders/trashed');
        }else{
            $canDestroy = \DB::transaction(
                function () use ($order){
                    if (!$order->isCancelled()){
                        foreach ($order->orderItems as $item){
                            ProductInventory::increaseStock($item->product_id, $item->qty);
                        }
                    }

                    $order->delete();
                    return true;
                }
            );

            if ($canDestroy){
                \Session::flash('success', 'The order has been removed');
            }else{
                \Session::flash('success', 'The order could not be removed');
            }

            return redirect('admin/orders');
        }
    }

    public function trashed(){
        $orders = Order::onlyTrashed()->orderBy('created_at','DESC')->paginate(10);

        return view('admin.orders.trashed', compact('orders'));
    }

    public function cancel($id){
        $order = Order::where('id', $id)
                ->whereIn('status', [Order::CREATED, Order::CONFIRMED])
                ->firstOrFail();

        return view('admin.orders.cancel', compact('order'));
    }

    public function doCancel(Request $request, $id){
        $request->validate([
            'cancellation_note' => 'required|max:255'
        ]);

        $order = Order::findOrFail($id);

        $cancelOrder = \DB::transaction(
            function () use ($order, $request){
                $params = [
                    'status' => Order::CANCELLED,
                    'cancelled_by' => \Auth::user()->id,
                    'cancelled_at' => now(),
                    'cancellation_note' => $request->input('cancellation_note'),
                ];

                if ($cancelOrder = $order->update($params) && $order->orderItems->count() > 0){
                    foreach ($order->orderItems as $item){
                        ProductInventory::increaseStock($item->product_id, $item->qty);
                    }
                }

                return $cancelOrder;
            }
        );

        ### ==========================
        ### ==========================
        \Session::flash('success', 'The order has been cancelled.');

        return redirect('admin/orders');
    }

    public function doComplete(Request $request, $id){
        $order = Order::findOrFail($id);

        if (!$order->isDelivered()){
            \Session::flash('error','The order cannot be done');
            return redirect('admin/orders');
        }

        $order->status = Order::COMPLETED;
        $order->approved_by =  \Auth::user()->id;
        $order->approved_at = now();

        if ($order->save()){
            \Session::flash('success','The order has been marked as completed!');
            return redirect('admin/orders');
        }
    }

    public function restore($id){
        $order = Order::onlyTrashed()->findOrFail($id);

        $canRestore = \DB::transaction(
            function () use ($order){
                $isOutOfStock = false;

                if (!$order->isCancelled()){
                    foreach ($order->orderItems as $item){
                        try {
                            ProductInventory::reduceStock($item->product_id, $item->qty);
                        }catch (OutOfStockException $e){
                            $isOutOfStock = true;
                            \Session::flash('error', $e->getMessage());
                        }
                    }
                }

                if ($isOutOfStock){
                    return false;
                }else{
                    return $order->restore();
                }
            }
        );

        if ($canRestore){
            \Session::flash('success', 'The order has been restored');
            return redirect('admin/orders');
        }else{
            if (!\Session::has('error')){
                \Session::flash('error', 'The order could not be restored');
            }
            return redirect('admin/orders/trashed');
        }
    }
}
