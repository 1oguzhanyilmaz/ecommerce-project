<?php

namespace App\Http\Controllers\Admin;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Order;
use App\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    use Authorizable;

    public function index(){
        $shipments = Shipment::leftJoin('orders', 'shipments.order_id', '=', 'orders.id')
                ->whereRaw('orders.deleted_at IS NULL')
                ->orderBy('shipments.created_at', 'DESC')
                ->select('shipments.*')->paginate(10);

        return view('admin.shipments.index', compact('shipments'));
    }

    public function edit($id){
        $shipment = Shipment::findOrFail($id);

        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'track_number' => 'required|max:255'
        ]);

        $shipment = Shipment::findOrFail($id);

        $order = \DB::transaction(
            function () use ($shipment, $request){
                $shipment->track_number = $request->input('track_number');
                $shipment->status = Shipment::SHIPPED;
                $shipment->shipped_at = now();
                $shipment->shipped_by = \Auth()->user()->id;

                if ($shipment->save()){
                    $shipment->order->status = Order::DELIVERED;
                    $shipment->order->save();
                }

                return $shipment->order;
            }
        );

        if ($order){
            // send shipped email
        }

        \Session::flash('success', 'The shipment has been updated.');
        return redirect('admin/orders/'.$order->id);
    }

}
