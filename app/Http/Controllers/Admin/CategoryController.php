<?php

namespace App\Http\Controllers\Admin;

use App\Authorizable;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use Authorizable;

    public function index(){
        $this->data['categories'] = Category::orderBy('name', 'ASC')->paginate(10);

        return view('admin.categories.index', $this->data);
    }

    public function create(){
        $categories = Category::orderBy('name', 'asc')->get()->toArray();

        return view('admin.categories.form', compact('categories'));
    }

    public function store(CategoryRequest $request){
        $params['name'] = $request->input('name');
        $params['slug'] = Str::slug($request->input('name'));
        $params['parent_id'] = (int)$request->input('parent_id');

        if (Category::create($params)) {
            Session::flash('success', 'Category has been saved');
        }
        return redirect('admin/categories');
    }

    public function show($id){
        //
    }

    public function edit($id){
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $id)->orderBy('name', 'asc')->get();

        return view('admin.categories.form', compact('category', 'categories'));
    }

    public function update(CategoryRequest $request, $id){
        $params['name'] = $request->input('name');
        $params['slug'] = Str::slug($request->input('name'));
        $params['parent_id'] = (int)$request->input('parent_id');

        $category = Category::findOrFail($id);
        if ($category->update($params)) {
            Session::flash('success', 'Category has been updated.');
        }

        return redirect('admin/categories');
    }

    public function destroy($id){
        $category  = Category::findOrFail($id);

        $child_categories_ids = Category::where('parent_id', $id)->pluck('id');
        Category::destroy($child_categories_ids->toArray());

        if ($category->delete()) {
            Session::flash('success', 'Category has been deleted');
        }

        return redirect('admin/categories');
    }
}
