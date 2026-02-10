<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryImage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::with(['subcategories', 'images'])->get();
        return view('admin.category', compact('categories'));
    }

    /**
     * Show form to create category or subcategory
     */
    public function create()
    {
        $mainCategories = Category::whereNull('parent_id')->get();
        return view('admin.create', compact('mainCategories'));
    }

    /**
     * Store new category or subcategory
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        $category = Category::create([
            'name'      => $request->name,
            'slug'      => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'status'    => 1,
        ]);

        // Only subcategories can have images
        $this->uploadImage($request, $category);

        Alert::success('Success', 'Category created successfully!');
        return redirect()->route('admin.categories');
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $category = Category::with('images')->findOrFail($id);
        $mainCategories = Category::whereNull('parent_id')
                                  ->where('id', '!=', $id)
                                  ->get();
        return view('admin.edit', compact('category', 'mainCategories'));
    }

    /**
     * Update category or subcategory
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $this->validateRequest($request, $id);

        $category->update([
            'name'      => $request->name,
            'slug'      => Str::slug($request->name),
            'parent_id' => $request->parent_id,
        ]);

        // Only subcategories can have images
        $this->uploadImage($request, $category);

        Alert::success('Success', 'Category updated successfully!');
        return redirect()->route('admin.categories');
    }

    /**
     * Delete category along with images
     */
    public function destroy($id)
    {
        $category = Category::with('images')->findOrFail($id);

        foreach ($category->images as $image) {
            $this->deleteFile($image->filename);
            $image->delete();
        }

        $category->delete();

        Alert::success('Success', 'Category deleted successfully!');
        return redirect()->route('admin.categories');
    }

    /**
     * Delete a single image
     */
    public function deleteImage($id)
    {
        $image = CategoryImage::findOrFail($id);
        $this->deleteFile($image->filename);
        $image->delete();

        Alert::success('Deleted', 'Image deleted successfully!');
        return back();
    }

    /**
     * Show category page with subcategories and images
     */
    public function show($slug)
    {
        $category = Category::with(['subcategories', 'images'])
                            ->where('slug', $slug)
                            ->firstOrFail();

        $view = 'categories.' . $category->slug;

        return view()->exists($view)
            ? view($view, compact('category'))
            : view('categories.default', compact('category'));
    }

    /**
     * -----------------------
     * HELPER METHODS
     * -----------------------
     */

    /**
     * Validate request
     */
    protected function validateRequest(Request $request, $id = null)
    {
        $request->validate([
            'name'      => 'required|unique:categories,name,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }

    /**
     * Upload single image only for subcategories
     */
    protected function uploadImage(Request $request, Category $category)
    {
        if ($category->parent_id === null || !$request->hasFile('image')) {
            return; // main categories cannot have images
        }

        // Delete old image if exists
        if ($category->images()->exists()) {
            $oldImage = $category->images()->first();
            $this->deleteFile($oldImage->filename);
            $oldImage->delete();
        }

        // Upload new image
        $image = $request->file('image');
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/category'), $filename);

        $category->images()->create([
            'filename' => $filename
        ]);
    }

    /**
     * Delete image file from server
     */
    protected function deleteFile($filename)
    {
        $path = public_path('uploads/category/' . $filename);
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
