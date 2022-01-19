<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        $limit = Session::get('limit');

        if(isset($limit)) {
            $products = $limit == 'all' ? $products : Product::orderBy('id', 'desc')->limit($limit)->get();
        }

        return response()->json([
            'status' => 200,
            'products' => $products,
        ]);
    }

    /**
     * Return sorted resource.
     */
    public function sorted(Request $request)
    {
        $products = Product::all();
        $limit = Session::get('limit');

        if($request->order == '') {
            return $this->index();
        }
        else if($request->order == 'asc' || $request->order == 'desc') {
            $products = Product::orderBy($request['orderBy'], $request['order'])->get();
            if(isset($limit) && $limit != 'all') $products = Product::orderBy($request['orderBy'], $request['order'])->limit($limit)->get();
        }

        return response()->json(['status' => 200, 'products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $limit = Session::get('limit');
        $product = new Product([
            'name' => strtolower($request['name']),
            'details' => $request['details'],
            'price' => $request['price'],
        ]);
        $product->save();

        $products = Product::all();
        if(isset($limit)) return $this->index();

        return response()->json(['status' => 200, 'products' => $products]);
    }

    /**
     * Display the specified resource.
     */
    public function show($name)
    {
        $status = 200;
        $products = [];
        $message = 'Product(s) found.';

        if($name == '@all') {
            return $this->index();
        } else {
            $results = Product::where('name','LIKE', "%$name%")->get();
            if(!empty($results)) {
                $products = $results;
                if(count($products) == 0) $message = 'No product(s) found.';
            };
        }


        return response()->json([
            'status' => $status,
            'products' => $products,
            'message' => $message
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(Request $request, $id)
    {
        $item = Product::find($id);
        $item->name = $request['name'];
        $item->details = $request['details'];
        $item->price = $request['price'];
        $item->save();

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return $this->index();
        } else {
            return response()->json(['status' => 404, 'message' => 'Product not found.']);
        }
    }

    public function setLimit($param) {
        Session::put('limit', $param);
        $limit = Session::get('limit');

        if(isset($limit)) return $this->index();
        // return response()->json(['status' => 200, 'message' => "Entries limited to $limit items."]);
    }

    public function getLimit() {
        $limit = Session::get('limit');

        if(isset($limit)) {
            return response()->json(['status' => 200, 'limit' => $limit]);
        } else {
            return response()->json(['status' => 404, 'message' => 'Limit not found.']);
        }
    }
}
