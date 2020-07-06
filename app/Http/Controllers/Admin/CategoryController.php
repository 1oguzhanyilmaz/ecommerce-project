<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $this->data['categories'] = Category::orderBy('name', 'ASC')->paginate(1);

        return view('admin.categories.index', $this->data);
    }

    public function create()
    {
        return view('admin.categories.form', $this->data);
    }

    public function store(CategoryRequest $request)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);
        $params['parent_id'] = 0;

        if (Category::create($params)) {
            Session::flash('success', 'Category has been saved');
        }
        return redirect('admin/categories');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->data['category'] = $category;
        return view('admin.categories.form', $this->data);
    }

    public function update(CategoryRequest $request, $id)
    {
        $params = $request->except('_token');
        $params['slug'] = Str::slug($params['name']);

        $category = Category::findOrFail($id);
        if ($category->update($params)) {
            Session::flash('success', 'Category has been updated.');
        }

        return redirect('admin/categories');
    }

    public function destroy($id)
    {
        $category  = Category::findOrFail($id);

        if ($category->delete()) {
            Session::flash('success', 'Category has been deleted');
        }

        return redirect('admin/categories');
    }
}
