<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller

{

    public function Index(){
        $skip_category_0 = Category::skip(0)->first();
        $skip_product_0 = Product::where('is_active',1)->where('category_id',$skip_category_0->id)->orderBy('id','DESC')->limit(5)->get();

        $skip_category_2 = Category::skip(2)->first();
        $skip_product_2 = Product::where('is_active',1)->where('category_id',$skip_category_2->id)->orderBy('id','DESC')->limit(5)->get();

        $skip_category_7 = Category::skip(3)->first();
        $skip_product_7 = Product::where('is_active',1)->where('category_id',$skip_category_7->id)->orderBy('id','DESC')->limit(5)->get();

        $hot_deals = Product::where('hot_deals',1)->where('discount_price','!=',NULL)->orderBy('id','DESC')->limit(3)->get();

        $special_offer = Product::where('special_offer',1)->orderBy('id','DESC')->limit(3)->get();

        $new = Product::where('is_active',1)->orderBy('id','DESC')->limit(3)->get();

        $special_deals = Product::where('special_deals',1)->orderBy('id','DESC')->limit(3)->get();

        SEOMeta::setTitle('Home Page');
        SEOMeta::setTitle('vecce | high fashion store');
        SEOMeta::setDescription('vecce | high fashion store 2023');
        SEOMeta::setCanonical('https://www.vecce.cf');

        OpenGraph::setDescription('vecce | high fashion store 2023');
        OpenGraph::setTitle('vecce | high fashion store');
        OpenGraph::setUrl('https://www.vecce.store');
        OpenGraph::addProperty('type', 'articles');

        TwitterCard::setTitle('vecce | high fashion store');
        TwitterCard::setSite('@vecce');



        return view('frontend.index',compact('skip_category_0','skip_product_0','skip_category_2','skip_product_2','skip_category_7','skip_product_7','hot_deals','special_offer','new','special_deals'));

    } // End Method





    public function ProductDetails($id,$slug){

        $product = Product::findOrFail($id);
        $color = $product->product_color;
        $product_color = explode(",", $color);

        $size = $product->product_size;
        $product_size = explode(",", $size);

        SEOMeta::setTitle($product->product_name);
        SEOMeta::setDescription($product->product_detail);
        SEOMeta::addMeta('article:published_time', $product->create_date, 'property');
        SEOMeta::addMeta('article:section', $product->category, 'property');
        SEOMeta::addKeyword(['key1', 'key2', 'key3']);

        OpenGraph::setDescription($product->product_detail);
        OpenGraph::setTitle($product->product_name);
        OpenGraph::setUrl($product->slug);
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'tr-TR');
        OpenGraph::addProperty('locale:alternate', ['en-us']);

        OpenGraph::addImage($product->cover->url);
        OpenGraph::addImage($product->image->url, ['height' => 300, 'width' => 300]);
        OpenGraph::addImage(assets('frontend/assets/logos.svg')); //change image dimensions
        OpenGraph::addImage(assets('frontend/assets/logos.svg'), ['height' => 300, 'width' => 300]);




//    $product_color = Product::select("product_color")->where(['id' => $id])->get();
//     $product_size = Product::select("product_size")->where(['id' => $id])->groupBy("product_size")->get();


//        $product_color = $product->product_color;
//        $product_color['key'] = $product->product_color;
//        $multiColor = $product->product_color;
//
//        $product_size = $product->product_size;
//        $product_size['key'] = $product->product_size;
//        $multiSize = $product->product_size;

        $alt_image = $product->alt_image;

        $alt_image['key'] = $product->image;

        $product->alt_image = $alt_image;

        $multiImage = $product->alt_image;


        $cat_id = $product->category_id;
        $relatedProduct = Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();

//        $relatedProduct = Cache::remember(self::PRODUCT_CACHE_KEY . $id, self::CACHE_TIME, function () use ($id) {
//            $product = Product::findOrFail($id);
//            $cat_id = $product->category_id;
//            return Product::where('category_id',$cat_id)->where('id','!=',$id)->orderBy('id','DESC')->limit(4)->get();
//
//        });

        return view('frontend.product.product_details',compact('product','alt_image','product_color','product_size','multiImage','relatedProduct'));


    } // End Method




    public function CatWiseProduct(Request $request,$id,$slug){
        $products = Product::where('is_active',1)->where('category_id',$id)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name','ASC')->get();

        $breadcat = Category::where('id',$id)->first();

        $newProduct = Product::orderBy('id','DESC')->limit(3)->get();

        return view('frontend.product.category_view',compact('products','categories','breadcat','newProduct'));

    }// End Method

    public function SubCatWiseProduct(Request $request,$id,$slug){
        $products = Product::where('is_active',1)->where('subcategory_id',$id)->orderBy('id','DESC')->get();
        $categories = Category::orderBy('category_name','ASC')->get();

        $breadsubcat = SubCategory::where('id',$id)->first();
        $breadsubcats = Category::where('id',$id)->first();

        $newProduct = Product::orderBy('id','DESC')->limit(3)->get();

        return view('frontend.product.subcategory_view',compact('products','categories','breadsubcat','breadsubcats','newProduct'));

    }// End Method

    public function ProductViewAjax($id){

        $product = Product::with('category','subcategory')->findOrFail($id);
        $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);


//        $alt_image = $product->alt_image;
//        $alt_image['key'] = $product->image;
//        $product->alt_image = $alt_image;
//        $multiImage = $product->alt_image;


        return response()->json(array(

            'product' => $product,
            'color' => $product_color,
            'size' => $product_size,


        ));

    }// End Method


    public function ProductSearch(Request $request){

        $request->validate(['search' => "required"]);

        $item = $request->search;
        $categories = Category::orderBy('category_name','ASC')->get();
        $products = Product::where('product_name','LIKE',"%$item%")->get();
        $newProduct = Product::orderBy('id','DESC')->limit(3)->get();
        return view('frontend.product.search',compact('products','item','categories','newProduct'));

    }// End Method


    public function SearchProduct(Request $request){

        $request->validate(['search' => "required"]);

        $item = $request->search;
        $products = Product::where('product_name','LIKE',"%$item%")->select('product_name','slug','image','selling_price','id')->limit(6)->get();

        return view('frontend.product.search_product',compact('products'));

    }// End Method

}
