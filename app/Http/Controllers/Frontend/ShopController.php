<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function ShopPage(){

        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slugs = explode(',',$_GET['category']);
            $catIds = Category::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            $products = $products->whereIn('category_id',$catIds)->get();
        }else{
            $products = Product::where('is_active',1)->orderBy('id','DESC')->get();
        }


//
//      if(request()->sort == 'low_high'){
//            $products = $products->sortBy('selling_price');
//
//        }elseif(request()->sort == 'high_low'){
//            $products = $products->sortByDesc('selling_price');
//      }



        // Price Range

        if(!empty($_GET['price'])){
            $price = explode('-',$_GET['price']);
            $products = $products->whereBetween('selling_price',$price);
        }


        $categories = Category::orderBy('category_name','ASC')->get();
//        $brands = Brand::orderBy('brand_name','ASC')->get();
        $newProduct = Product::orderBy('id','DESC')->limit(3)->get();

//        $products = Product::paginate(5);


        return view('frontend.product.shop_page',compact('products','categories','newProduct'));

    } // End Method


    public function ShopFilter(Request $request){

        $data = $request->all();

        /// Filter For Category

        $catUrl = "";
        if (!empty($data['category'])) {
            foreach($data['category'] as $category){
                if (empty($catUrl)) {
                    $catUrl .= '&category='.$category;
                }else{
                    $catUrl .= ','.$category;
                }
            }
        }


//        /// Filter For Brand
//
//        $brandUrl = "";
//        if (!empty($data['brand'])) {
//            foreach($data['brand'] as $brand){
//                if (empty($brandUrl)) {
//                    $brandUrl .= '&brand='.$brand;
//                }else{
//                    $brandUrl .= ','.$brand;
//                }
//            }
//        }

        /// Filter For Price Range

        $priceRangeUrl = "";
        if (!empty($data['price_range'])) {
            $priceRangeUrl .= '&price='.$data['price_range'];
        }



        return redirect()->route('shop.page',$catUrl.$priceRangeUrl);

    }// End Method

}
