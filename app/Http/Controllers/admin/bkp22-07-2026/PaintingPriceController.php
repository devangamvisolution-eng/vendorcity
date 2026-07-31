<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PaintingPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        /* For Apartment */
        $data['painting_price_data'] = DB::table('painting_prices')->where('types_of_tab','apartment')->where('flags_of_tab','=',null)->get();  
        $data['getColorWantWallsPainted'] = DB::table('painting_prices')->where('types_of_tab','apartment')->where('flags_of_tab',1)->get();  
        $data['getHomeFurnishPainted'] = DB::table('painting_prices')->where('types_of_tab','apartment')->where('flags_of_tab',3)->get();  

        /* For Villa */
        $data['villaPainting_price_data'] = DB::table('painting_prices')->where('types_of_tab','villa')->where('flags_of_tab','=',null)->get();

        $data['getVillaColorWantWallsPainted'] = DB::table('painting_prices')->where('types_of_tab','villa')->where('flags_of_tab',2)->get();  

        $data['getVillaHomeFurnishedPainted'] = DB::table('painting_prices')->where('types_of_tab','villa')->where('flags_of_tab',4)->get();  
        return view('admin.edit_painting_price',$data);
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
       //echo "<pre>";print_r($request->all());echo "</pre>";exit;
        /* For Apartment */ 
        if (count($request['size_of_home_id']) > 0 && $request['size_of_home_id'] != '') {

            for ($i = 0; $i < count($request['size_of_home_id']); $i++) {
    
                if($request['size_of_home_id'][$i] != ''){
    
                    $content['size_of_home_id'] = $request['size_of_home_id'][$i];    
                    $content['size_of_home'] = $request['size_of_home'][$i];    
                    $content['types_of_tab_apartment'] = $request['types_of_tab_apartment'][$i];    
                    $content['price'] = $request['price'][$i]; 
                    $content['subservice_id'] = 47; 

                    $apartmentPaintingPrice = DB::table('painting_prices')
                                                ->where('id',$content['size_of_home_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->where('types_of_tab',$content['types_of_tab_apartment'])
                                                ->first();

                    if(isset($apartmentPaintingPrice) && !empty($apartmentPaintingPrice)){
                        $content['id'] = $apartmentPaintingPrice->id; 
                        $this->update_painting_prices($content);
                    }
                }                    
            }
    
        }

        /* For Apartment Color Price */ 
        if (count($request['apartment_color_id']) > 0 && $request['apartment_color_id'] != '') {

            for ($i = 0; $i < count($request['apartment_color_id']); $i++) {
    
                if($request['apartment_color_id'][$i] != ''){
    
                    $content['apartment_color_id'] = $request['apartment_color_id'][$i];    
                    $content['apartment_colors'] = $request['apartment_colors'][$i];    
                    $content['types_of_tab_color_apartment'] = $request['types_of_tab_color_apartment'][$i];    
                    $content['colors_of_apartment'] = $request['colors_of_apartment'][$i];    
                    $content['apartment_color_price'] = $request['apartment_color_price'][$i]; 
                    $content['subservice_id'] = 47; 

                    $apartmentPaintingPrice = DB::table('painting_prices')
                                                ->where('id',$content['apartment_color_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->where('types_of_tab',$content['types_of_tab_color_apartment'])
                                                ->first();

                    if(isset($apartmentPaintingPrice) && !empty($apartmentPaintingPrice)){
                        $content['id'] = $apartmentPaintingPrice->id; 
                        $this->update_apartment_painting_color_prices($content);
                    }
                }                    
            }
    
        }

         /* For Apartment Home Furnish Price */ 
         if (count($request['apartment_furnished_id']) > 0 && $request['apartment_furnished_id'] != '') {

            for ($i = 0; $i < count($request['apartment_furnished_id']); $i++) {
    
                if($request['apartment_furnished_id'][$i] != ''){
                    
                    $content['subservice_id'] = 47; 
                    $content['apartment_furnished_id'] = $request['apartment_furnished_id'][$i];  
                    $content['apartment_home_furnish'] = $request['apartment_home_furnish'][$i];   
                    $content['apartment_home_furnish_price'] = $request['apartment_home_furnish_price'][$i];   
                    $content['types_of_tab_apart_furnished'] = $request['types_of_tab_apart_furnished'][$i];    
                    $content['apartment_furnished_flg'] = $request['apartment_furnished_flg'][$i];    
                
                    $apartPaintingHomeFurnishPrice = DB::table('painting_prices')
                                                ->where('id',$content['apartment_furnished_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->where('types_of_tab',$content['types_of_tab_apart_furnished'])
                                                ->first();

                    if(isset($apartPaintingHomeFurnishPrice) && !empty($apartPaintingHomeFurnishPrice)){
                        $content['id'] = $apartPaintingHomeFurnishPrice->id; 
                        $this->update_apartment_painting_home_furnish_prices($content);
                    }
                }                    
            }
    
        }


        /* For Villa */ 
        if (count($request['villa_home_size_id']) > 0 && $request['villa_home_size_id'] != '') {

            for ($i = 0; $i < count($request['villa_home_size_id']); $i++) {
    
                if($request['villa_home_size_id'][$i] != ''){
    
                    $content['villa_home_size_id'] = $request['villa_home_size_id'][$i];    
                    $content['villa_home_size'] = $request['villa_home_size'][$i];    
                    $content['type_of_tab_villa'] = $request['type_of_tab_villa'][$i];    
                    $content['villa_price'] = $request['villa_price'][$i]; 
                    $content['subservice_id'] = 47; 

                    $apartmentPaintingPrice = DB::table('painting_prices')
                                                ->where('id',$content['villa_home_size_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->where('types_of_tab',$content['type_of_tab_villa'])
                                                ->first();

                    if(isset($apartmentPaintingPrice) && !empty($apartmentPaintingPrice)){
                        $content['id'] = $apartmentPaintingPrice->id; 
                        $this->update_villa_painting_prices($content);
                    }
                }                    
            }
        }

        /* For Villa Color Price Update*/
        if (count($request['villa_color_id']) > 0 && $request['villa_color_id'] != '') {

            for ($i = 0; $i < count($request['villa_color_id']); $i++) {
    
                if($request['villa_color_id'][$i] != ''){
                    
                    $content['subservice_id'] = 47;
                    $content['villa_colors'] = $request['villa_colors'][$i];    // size_of_home
                    $content['villa_color_price'] = $request['villa_color_price'][$i];
                    $content['types_of_tab_villa_color'] = $request['types_of_tab_villa_color'][$i];   // types_of_tab
                    $content['colors_of_villa'] = $request['colors_of_villa'][$i];  // flags_of_tab <- Table Field
                    $content['villa_color_id'] = $request['villa_color_id'][$i];    // Table Main ID

                    $apartmentPaintingColorPrice = DB::table('painting_prices')
                                                ->where('id',$content['villa_color_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->where('types_of_tab',$content['types_of_tab_villa_color'])
                                                ->first();

                    if(isset($apartmentPaintingColorPrice) && !empty($apartmentPaintingColorPrice)){
                        $content['id'] = $apartmentPaintingColorPrice->id; 
                        $this->update_villa_painting_color_prices($content);
                    }
                }                    
            }
        }

        /* For Villa Color Home Furnished Update*/
        if (count($request['villa_furnished_id']) > 0 && $request['villa_furnished_id'] != '') {

            for ($i = 0; $i < count($request['villa_furnished_id']); $i++) {
    
                if($request['villa_furnished_id'][$i] != ''){
                    
                    $content['subservice_id'] = 47;
                    $content['villa_home_furnish'] = $request['villa_home_furnish'][$i];    // size_of_home
                    $content['villa_home_furnish_price'] = $request['villa_home_furnish_price'][$i]; // Price
                    $content['types_of_villa_furnished'] = $request['types_of_villa_furnished'][$i];   // types_of_tab
                    $content['villa_furnished_flg'] = $request['villa_furnished_flg'][$i];  // flags_of_tab <- Table Field
                    $content['villa_furnished_id'] = $request['villa_furnished_id'][$i];    // Table Main ID

                    $villaHomeFurnishedPaintinPrice = DB::table('painting_prices')
                                                ->where('id',$content['villa_furnished_id'])
                                                ->where('subservice_id',$content['subservice_id'])
                                                ->where('types_of_tab',$content['types_of_villa_furnished'])
                                                ->first();

                    if(isset($villaHomeFurnishedPaintinPrice) && !empty($villaHomeFurnishedPaintinPrice)){
                        $content['id'] = $villaHomeFurnishedPaintinPrice->id; 
                        $this->update_villa_painting_homeFurnished_prices($content);
                    }
                }                    
            }
        }

        return redirect()->route('painting-price.edit',$id)->with('success', 'Painting Price  Update Successfully');
    }

    function update_painting_prices($content){
        $data['subservice_id'] = $content['subservice_id'];
        $data['size_of_home'] = $content['size_of_home'];    
        $data['price'] = $content['price'];    
        $data['types_of_tab'] = $content['types_of_tab_apartment']; 
        DB::table('painting_prices')->where('id', $content['id'])->where('types_of_tab', 'apartment')->update($data);
    }
    function update_apartment_painting_color_prices($content){
        $data['subservice_id'] = $content['subservice_id'];
        $data['size_of_home'] = $content['apartment_colors'];    
        $data['flags_of_tab'] = $content['colors_of_apartment'];    
        $data['price'] = $content['apartment_color_price'];    
        $data['types_of_tab'] = $content['types_of_tab_color_apartment']; 
        DB::table('painting_prices')->where('id', $content['id'])->where('types_of_tab', 'apartment')->update($data);
    }
    function update_apartment_painting_home_furnish_prices($content){
        $data['subservice_id'] = $content['subservice_id'];
        $data['size_of_home'] = $content['apartment_home_furnish'];    
        $data['flags_of_tab'] = $content['apartment_furnished_flg'];    
        $data['price'] = $content['apartment_home_furnish_price'];    
        $data['types_of_tab'] = $content['types_of_tab_apart_furnished']; 
        DB::table('painting_prices')->where('id', $content['id'])->where('types_of_tab', 'apartment')->update($data);
    }

    function update_villa_painting_prices($content){
         $data['subservice_id'] = $content['subservice_id'];
         $data['size_of_home'] = $content['villa_home_size'];    
         $data['price'] = $content['villa_price'];    
         $data['types_of_tab'] = $content['type_of_tab_villa']; 
         DB::table('painting_prices')->where('id', $content['id'])->where('types_of_tab', 'villa')->update($data);
    }

    function update_villa_painting_color_prices($content){
        // echo"<pre>";print_r($content);echo"</pre>";exit;
         $data['subservice_id']         = $content['subservice_id'];
         $data['size_of_home']          = $content['villa_colors'];    
         $data['price']                 = $content['villa_color_price'];    
         $data['types_of_tab']          = $content['types_of_tab_villa_color']; 
         $data['flags_of_tab']   = $content['colors_of_villa']; 
         DB::table('painting_prices')->where('id', $content['id'])->where('types_of_tab', 'villa')->update($data);
    }

    function update_villa_painting_homeFurnished_prices($content){
         $data['subservice_id']         = $content['subservice_id'];
         $data['size_of_home']          = $content['villa_home_furnish'];    
         $data['price']                 = $content['villa_home_furnish_price'];    
         $data['types_of_tab']          = $content['types_of_villa_furnished']; 
         $data['flags_of_tab']   = $content['villa_furnished_flg']; 
         DB::table('painting_prices')->where('id', $content['id'])->where('types_of_tab', 'villa')->update($data);
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
