<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Factory;
use App\StoreChain;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 商品一覧を取得
        $products = Product::with(['store_chain','category'])
        ->orderBy('category_id')
        ->get();

        // 商品一覧ビューでそれを表示
        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $factories = Factory::all();
        $store_chains = StoreChain::orderBy('id')
        ->get();
        
        return view('products.create', [
            'store_chains' => $store_chains,
            'categories' => $categories,
            'factories' => $factories,
        ]);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:11',
            'lot' => 'required|max:11',
            'category_id' => 'required',
            'factory_id' => 'required',
            'valid_from' => 'required',
            
        ]);

        Product::create([
            'name' => $request->name,
            'price'=> $request->price,
            'lot' => $request->lot,
            'category_id' => $request->category_id,
            'factory_id' => $request->factory_id,
            'chain_id' => $request->store_chain_id,
            'valid_from'=>$request->valid_from,
            'valid_until'  => $request->valid_until,
        ]);
       // return redirect()->route('stores.index');
       return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
