<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\AttributeOption;
use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeOptionRequest;
use App\Http\Requests\AttributeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttributeController extends Controller
{
    use Authorizable;

    public function index(){
        $attributes = Attribute::orderBy('name', 'ASC')->paginate(10);

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create(){
        $types = Attribute::types();
        $booleanOptions = Attribute::booleanOptions();
        $validations = Attribute::validations();

        return view('admin.attributes.form', compact('types','booleanOptions','validations'));
    }

    public function store(AttributeRequest $request){
        $params = $request->all();
        $params['is_required'] = (bool) $params['is_required'];
        $params['is_unique'] = (bool) $params['is_unique'];
        $params['is_configurable'] = (bool) $params['is_configurable'];
        $params['is_filterable'] = (bool) $params['is_filterable'];

        if (Attribute::create($params)) {
            Session::flash('success', 'Attribute has been saved');
        }

        return redirect('admin/attributes');
    }

    public function show($id){
        //
    }

    public function edit($id){
        $types = Attribute::types();
        $booleanOptions = Attribute::booleanOptions();
        $validations = Attribute::validations();

        $attribute = Attribute::findOrFail($id);

        return view('admin.attributes.form', compact('types','booleanOptions','validations','attribute'));
    }

    public function update(AttributeRequest $request, $id){
        $params = $request->all();
        $params['is_required'] = (bool) $params['is_required'];
        $params['is_unique'] = (bool) $params['is_unique'];
        $params['is_configurable'] = (bool) $params['is_configurable'];
        $params['is_filterable'] = (bool) $params['is_filterable'];

        unset($params['code']);
        // unset($params['type']);

        $attribute = Attribute::findOrFail($id);
        if ($attribute->update($params)) {
            Session::flash('success', 'Attribute has been saved');
        }

        return redirect('admin/attributes');
    }

    public function destroy($id){
        $attribute = Attribute::findOrFail($id);

        if ($attribute->delete()) {
            Session::flash('success', 'Attribute has been deleted');
        }

        return redirect('admin/attributes');
    }

    public function options($attributeID){
        if (empty($attributeID)) {
            return redirect('admin/attributes');
        }

        $attribute = Attribute::findOrFail($attributeID);

        return view('admin.attributes.options', compact('attribute'));
    }

    public function store_option(AttributeOptionRequest $request, $attributeID){
        if (empty($attributeID)) {
            return redirect('admin/attributes');
        }

        $params = [
            'attribute_id' => $attributeID,
            'name' => $request->input('name'),
        ];
        if (AttributeOption::create($params)) {
            Session::flash('success', 'option has been saved');
        }

        return redirect('admin/attributes/'. $attributeID .'/options');
    }

    public function edit_option($optionID){
        $option = AttributeOption::findOrFail($optionID);
        $attribute = $option->attribute;

        return view('admin.attributes.options', compact('option','attribute'));
    }

    public function update_option(AttributeOptionRequest $request, $optionID){
        $option = AttributeOption::findOrFail($optionID);
        $params = $request->all();

        if ($option->update($params)) {
            Session::flash('success', 'Option has been updated');
        }

        return redirect('admin/attributes/'. $option->attribute->id .'/options');
    }

    public function remove_option($optionID){
        if (empty($optionID)) {
            return redirect('admin/attributes');
        }

        $option = AttributeOption::findOrFail($optionID);

        if ($option->delete()) {
            Session::flash('success', 'option has been deleted');
        }

        return redirect('admin/attributes/'. $option->attribute->id .'/options');
    }
}
