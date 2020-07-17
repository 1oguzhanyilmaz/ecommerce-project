<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\AttributeOption;
use App\Authorizable;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductAttributeValue;
use App\ProductImage;
use App\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use Authorizable;

    public function __construct(){
        parent::__construct();

        $this->data['currentAdminMenu'] = 'catalog';
        $this->data['currentAdminSubMenu'] = 'product';

        $this->data['statuses'] = Product::statuses();
        $this->data['types'] = Product::types();
    }

    public function index(){
        $products = Product::orderBy('name', 'ASC')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(){
        $categories = Category::orderBy('name', 'ASC')->get()->toArray();
        $configurableAttributes = $this->getConfigurableAttributes();
        $types = Product::types();
        $categoryIDs = [];

        return view('admin.products.form', compact('types','categories','categoryIDs','configurableAttributes'));
    }

    public function store(ProductRequest $request){
        $product = new Product();
        $product->user_id = Auth::user()->id;
        $product->sku = $request->input('sku');
        $product->type = $request->input('type');
        $product->name = $request->input('name');
        $product->slug = Str::slug($request->input('name'));
        $product->save();

        $categoryIds = !is_null($request->input('category_ids')) ?  $request->input('category_ids') : [];
        $product->categories()->sync($categoryIds);

        if ($request->input('type') == 'configurable') {
            $this->generateProductVariants($product, $request->all());
        }

        if ($product) {
            Session::flash('success', 'Product has been saved');
        } else {
            Session::flash('error', 'Product could not be saved');
        }

        return redirect('admin/products/'. $product->id .'/edit/');
    }

    public function show($id){
        //
    }

    public function edit($id){
        if (empty($id)) {
            return redirect('admin/products/create');
        }

        $product = Product::findOrFail($id);
        $product->qty = isset($product->productInventory)
                            ? $product->productInventory->qty
                            : null;

        $categories = Category::orderBy('name', 'ASC')->get()->toArray();
        $productID = $product->id;
        $categoryIDs =  $product->categories->pluck('id')->toArray();

        $configurableAttributes = $this->getConfigurableAttributes();
        $types = Product::types();
        $statuses = Product::statuses();

        return view('admin.products.form', compact('product','categories','productID','categoryIDs','configurableAttributes','types','statuses'));
    }

    public function update(ProductRequest $request, $id){
        $product = Product::findOrFail($id);
        $product->type = $request->input('type');
        $product->name = $request->input('name');
        $product->slug = Str::slug($request->input('name'));
        $product->price = $request->input('price');
        $product->weight = $request->input('weight');
        $product->width = $request->input('width');
        $product->height = $request->input('height');
        $product->length = $request->input('length');
        $product->short_description = $request->input('short_description');
        $product->description = $request->input('description');
        $product->status = $request->input('status');
        $product->save();


        $categoryIds = !is_null($request->input('category_ids')) ?  $request->input('category_ids') : [];
        $product->categories()->sync($categoryIds);

        if ($request->input('type') == 'configurable') {
            $this->updateProductVariants($request->all());

        } else {
            ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $request->input('qty')]);
        }

        if ($product) {
            Session::flash('success', 'Product has been saved');
        } else {
            Session::flash('error', 'Product could not be saved');
        }

        return redirect('admin/products');
    }

    public function destroy($id){
        $product  = Product::findOrFail($id);

        if ($product->delete()) {
            Session::flash('success', 'Product has been deleted');
        }

        return redirect('admin/products');
    }

    ##############################################################################
    ####################################################
    ### Product Attribute Operations ###
    private function generateProductVariants($product, $params){
        $configurableAttributes = $this->getConfigurableAttributes();

        $variantAttributes = [];
        foreach ($configurableAttributes as $attribute) {
            $variantAttributes[$attribute->code] = $params[$attribute->code];
        }

        $variants = $this->generateAttributeCombinations($variantAttributes);

        if ($variants) {
            foreach ($variants as $variant) {
                $variantParams = [
                    'parent_id' => $product->id,
                    'user_id' => Auth::user()->id,
                    'sku' => $product->sku . '-' .implode('-', array_values($variant)),
                    'type' => 'simple',
                    'name' => $product->name . $this->convertVariantAsName($variant),
                ];

                $variantParams['slug'] = Str::slug($variantParams['name']);

                $newProductVariant = Product::create($variantParams);

                $categoryIds = !is_null($params['category_ids']) ?  $params['category_ids'] : [];

                $newProductVariant->categories()->sync($categoryIds);

                $this->saveProductAttributeValues($newProductVariant, $variant, $product->id);
            }
        }
    }

    private function getConfigurableAttributes(){
        return Attribute::where('is_configurable', true)->get();
    }

    private function generateAttributeCombinations($arrays){
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    private function convertVariantAsName($variant){
        $variantName = '';

        foreach (array_keys($variant) as $key => $code) {
            $attributeOptionID = $variant[$code];
            $attributeOption = AttributeOption::find($attributeOptionID);

            if ($attributeOption) {
                $variantName .= ' - ' . $attributeOption->name;
            }
        }

        return $variantName;
    }

    private function saveProductAttributeValues($product, $variant, $parentProductID){
        foreach (array_values($variant) as $attributeOptionID) {
            $attributeOption = AttributeOption::find($attributeOptionID);

            $attributeValueParams = [
                'parent_product_id' => $parentProductID,
                'product_id' => $product->id,
                'attribute_id' => $attributeOption->attribute_id,
                'text_value' => $attributeOption->name,
            ];

            ProductAttributeValue::create($attributeValueParams);
        }
    }

    private function updateProductVariants($params){
        if ($params['variants']) {
            foreach ($params['variants'] as $productParams) {
                $product = Product::find($productParams['id']);
                $productParams_2 = $productParams;
                unset($productParams_2['qty']);
                $product->update($productParams_2);

                $product->status = $params['status'];
                $product->save();

                ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $productParams['qty']]);
            }
        }
    }

    ##############################################################################
    #############################################################
    ### Image Operations ###
    public function images($id){
        if (empty($id)) {
            return redirect('admin/products/create');
        }

        $product = Product::findOrFail($id);
        $this->data['productID'] = $product->id;
        $productID = $product->id;
        $productImages = $product->productImages;

        return view('admin.products.images', compact('productID','productImages'));
    }

    public function add_image($id){
        if (empty($id)) {
            return redirect('admin/products');
        }

        $product = Product::findOrFail($id);
        $productID = $product->id;

        return view('admin.products.image_form', compact('product','productID'));
    }

    public function upload_image(ProductImageRequest $request, $id){
        $product = Product::findOrFail($id);

        if ($request->has('image')) {
            $image = $request->file('image');
            $name = $product->slug . '_' . time();
            $fileName = $name . '.' . $image->getClientOriginalExtension();

            $folder = '/uploads/images';
            $filePath = $image->storeAs($folder, $fileName, 'public');

            $params = [
                'product_id' => $product->id,
                'path' => $filePath,
            ];

            if (ProductImage::create($params)) {
                Session::flash('success', 'Image has been uploaded');
            } else {
                Session::flash('error', 'Image could not be uploaded');
            }

            return redirect('admin/products/' . $id . '/images');
        }
    }

    public function remove_image($id){
        $image = ProductImage::findOrFail($id);

        if ($image->delete()) {
            Session::flash('success', 'Image has been deleted');
        }

        return redirect('admin/products/' . $image->product->id . '/images');
    }
}
