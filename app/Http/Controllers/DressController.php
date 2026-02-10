<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dress;
use App\Models\Cart;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;


class DressController extends Controller
{
   public function create_dress(Request $request) {

   $variantData = [];

// Only process variants if they exist
if ($request->filled('color_name') && is_array($request->variant_size)) {

    $variantSizeKeys = array_keys($request->variant_size);

    foreach ($request->color_name as $index => $color) {

        if (empty($color)) {
            continue;
        }

        if (!isset($variantSizeKeys[$index])) {
            continue;
        }

        $blockId = $variantSizeKeys[$index];

        $sizes = $request->variant_size[$blockId] ?? [];
        $stocks = $request->variant_stock[$blockId] ?? [];

        foreach ($sizes as $key => $size) {
            if (empty($size)) {
                continue;
            }

            $variantData[$color][$size] = (int) ($stocks[$key] ?? 0);
        }
    }
}

        $dress = new Dress();
        $dress->name = $request->name;
        $dress->brand = $request->brand ?: 'Unknown Brand';
        $dress->category_id = $request->category_id;

           $dress->variants = json_encode($variantData);
        $dress->price = $request->price;
        $dress->material = $request->material;
        $dress->description = $request->description ?: 'No description provided';


        // Handle multiple image uploads
      if ($request->hasFile('image1')) {
    $img1 = uniqid().'_1.'.$request->file('image1')->getClientOriginalExtension();
    $request->file('image1')->move(public_path('uploads/dress_pic'), $img1);
    $dress->image1 = $img1;
}

if ($request->hasFile('image2')) {
    $img2 = uniqid().'_2.'.$request->file('image2')->getClientOriginalExtension();
    $request->file('image2')->move(public_path('uploads/dress_pic'), $img2);
    $dress->image2 = $img2;
}

        $dress->save();
        Alert::success('Success', 'Item Added Successfully');
        return redirect()->back();
    }

   public function update_dress(Request $request, $id)
{
    $dress = Dress::findOrFail($id);

    // Process variants just like in create
    $variantData = [];

    foreach ($request->color_name as $index => $color) {

        $blockId = array_keys($request->variant_size)[$index];

        $sizes = $request->variant_size[$blockId];
        $stocks = $request->variant_stock[$blockId];

        foreach ($sizes as $key => $size) {
            $variantData[$color][$size] = (int)$stocks[$key];
        }
    }

    // update fields
    $dress->name = $request->name;
    $dress->brand = $request->brand;
    $dress->category_id = $request->category_id;
    $dress->price = $request->price;
    $dress->material = $request->material;
    $dress->description = $request->description;

    // important: correct variants update
    $dress->variants = json_encode($variantData);

    // Image updates
    if ($request->hasFile('image1')) {
        $img1 = uniqid().'_1.'.$request->file('image1')->getClientOriginalExtension();
        $request->file('image1')->move(public_path('uploads/dress_pic'), $img1);
        $dress->image1 = $img1;
    }

    if ($request->hasFile('image2')) {
        $img2 = uniqid().'_2.'.$request->file('image2')->getClientOriginalExtension();
        $request->file('image2')->move(public_path('uploads/dress_pic'), $img2);
        $dress->image2 = $img2;
    }

    $dress->save();

    Alert::success('Success', 'Item Updated Successfully');
    return redirect()->route('manage_dress');
}


    // Other existing methods remain the same
    public function manage_dress(){
        $dresses = Dress::all();
        return view('admin.manage_dress', compact('dresses'));
    }

    public function view_dress($id){
        $dress = Dress::find($id);
        return view('admin.view_dress', compact('dress'));
    }

    public function delete_dress($id){
        $dress = Dress::find($id);
        $dress->delete();
        Alert::success('Success', 'Dress Deleted Successfully');
        return redirect()->back();
    }

    public function edit_dress($id){
    $dress = Dress::find($id);
    $categories = Category::all(); // fetch all categories from DB
    return view('admin.edit_dress', compact('dress', 'categories'));
}


    public function women(){
        $dresses = Dress::all();
        return view('indexes.assymetry_wears', compact('dresses'));
    }

    public function api_show($id){
        return Dress::find($id);
    }

    public function add_dress() {
    $categories = Category::all();
    return view('admin.add_dress', compact('categories'));
}


public function getDress($id)
{
    $dress = Dress::findOrFail($id);
    $variants = json_decode($dress->variants, true);

    // Get cart quantities for this product
    $cartItems = Cart::where('product_id', $id)
        ->where(function($q){
            $q->where('user_id', Auth::id())
              ->orWhere('session_id', session()->getId());
        })
        ->get();

    foreach ($variants as $color => $sizes) {
        foreach ($sizes as $size => $stock) {
            $inCart = $cartItems->where('color', $color)
                                ->where('size', $size)
                                ->sum('quantity');
            $variants[$color][$size] = max(0, $stock - $inCart);
        }
    }

    $dress->variants = $variants;

    return response()->json($dress);
}
public function show($id)
{
    $dress = Dress::findOrFail($id);
    $variants = $dress->variants; // Assuming JSON column

    // Get current user's cart items
    $cart = session()->get('cart', []); // or Auth::user()->cart
    $cartQuantities = [];

    foreach ($cart as $item) {
        if ($item['dress_id'] == $dress->id) {
            $cartQuantities[$item['color']][$item['size']] = $item['quantity'];
        }
    }

    return response()->json([
        'id' => $dress->id,
        'name' => $dress->name,
        'brand' => $dress->brand,
        'material' => $dress->material,
        'description' => $dress->description,
        'image1' => $dress->image1,
        'image2' => $dress->image2,
        'variants' => $variants,
        'cartQuantities' => $cartQuantities
    ]);
}


public function search(Request $request)
{
    $search = $request->input('query');

    $dresses = Dress::where('name', 'LIKE', "%{$search}%")
        ->orWhere('brand', 'LIKE', "%{$search}%")
        ->orWhere('description', 'LIKE', "%{$search}%")
        ->orWhereHas('category', function($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        })
        ->orWhere('variants', 'LIKE', "%{$search}%")
        ->get();

    return view('search-results', compact('dresses', 'search'));
}

public function viewProduct($id)
{
    $dress = Dress::findOrFail($id);
    $dress->variants = json_decode($dress->variants, true); // decode for Blade view

    return view('dress-details', compact('dress'));
}




public function subcategory($id)
{
    // Get all dresses in this subcategory
    $dresses = Dress::where('category_id', $id)->get();

    // Get subcategory info if you need its name
    $subcategory = Category::findOrFail($id);

    return view('subcategory_products', compact('dresses', 'subcategory'));
}





}
