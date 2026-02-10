<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeliveryController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::all();
        return view('admin.deliveries', compact('deliveries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state' => 'required|unique:deliveries,state',
            'fee' => 'required|numeric|min:0',
        ]);

        Delivery::create($request->all());
        Alert::success('Success', 'Delivery fee added successfully!');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);
        $request->validate([
            'state' => 'required|unique:deliveries,state,' . $id,
            'fee' => 'required|numeric|min:0',
        ]);

        $delivery->update($request->all());
        Alert::success('Success', 'Delivery fee updated!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Delivery::findOrFail($id)->delete();
        Alert::success('Success', 'Delivery fee deleted!');
        return redirect()->back();
    }
}

