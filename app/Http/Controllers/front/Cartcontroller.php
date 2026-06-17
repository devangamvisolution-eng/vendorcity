<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email;
use DB;
use Cart;
use Session;
use Str;
use App\Models\Admin\City;

class Cartcontroller extends Controller
{

    function __construct(Type $var = null)
    {
        $search_city_id = session('search_city_id');

        if (!empty($search_city_id)) {
            Session::put('search_city_id', $search_city_id);
        } else {
            Session::put('search_city_id', 17);
        }

        $CityName = City::where('id', session('search_city_id'))->first();

        if ($CityName) {
            $slug = Str::slug($CityName->name);
            Session::put('search_city_name', $slug);
        } else {
            Session::put('search_city_name', 'dubai');
        }
    }
    public function cart()
    {

        $data['meta_title'] = "Your VendorsCity Cart – Ready to Checkout?";
        $data['meta_keyword'] = "";
        $data['meta_description'] = "Review your selection and complete your booking in seconds. Ready when you are—checkout now!";

        return view('front.cart', $data);
    }


    function add_to_cart()
    {

        $package_id = $_POST['package_id'];
        $qty = $_POST['qty'];

        if ($package_id != '') {

            $package_data = DB::table('packages')->where('id', $package_id)->first();

            if ($package_data->image != '') {
                $image = $package_data->image;
            } else {
                $image = "no-image.png";
            }

            $service_data = DB::table('services')->where('id', $package_data->service_id)->first();
            $subservices_data = DB::table('subservices')->where('id', $package_data->subservice_id)->first();
            //    echo "<pre>";print_r($subservices_data);echo "</pre>";exit;
            $packagecategory_data = DB::table('package_categories')->where('id', $package_data->packagecategory_id)->first();

            if ($package_data->booking_service_per > 0 && $package_data->booking_service_per != '') {
                $servicepercentage = $package_data->booking_service_per;
            } elseif ($subservices_data->servicepercentage > 0 && $subservices_data->servicepercentage != '') {
                $servicepercentage = $subservices_data->servicepercentage;
            } else {
                $servicepercentage = 0;
            }


            // if($subservices_data->servicepercentage > 0 && $subservices_data->servicepercentage != '') {
            //     $servicepercentage = $subservices_data->servicepercentage;
            // }else{
            //     $servicepercentage = 0;
            // }


            //echo "<pre>";print_r($subservices_data);echo "</pre>";exit;

            $price = $package_data->price;

            if ($package_data->discount > 0) {

                if ($package_data->discount_type == 0) {

                    $disc_price_new = $price * $package_data->discount / 100;

                    $disc_price = $price - $disc_price_new;
                } elseif ($package_data->discount_type == 1) {
                    $disc_price = $price - $package_data->discount;
                } else {
                    $disc_price = $price;
                }
            } else {
                $disc_price = 0;
            }

            $cartdiscount = $disc_price;

            //echo "<pre>";print_r($service_data);echo "</pre>";exit;

            Cart::add([
                'id' => $package_data->id,
                'name' => $package_data->name,
                'qty' => $qty,
                'price' => $package_data->price,
                'options' => [
                    'service_id' => $package_data->service_id,
                    'service_name' => $service_data->servicename,
                    'subservice_id' => $package_data->subservice_id,
                    'subservice_name' => $subservices_data->subservicename,
                    'subservice_description' => $subservices_data->description,
                    'packagecategory_id' => $package_data->service_id,
                    'packagecategory_name' => $packagecategory_data->name,
                    'page_url' => $package_data->page_url,
                    'product_discount_amount' => $cartdiscount,
                    'image' => $image,
                    'discount' => $package_data->discount,
                    'discount_type' => $package_data->discount_type,
                    'subservice_booking_percentage' => $servicepercentage,

                ]
            ]);

            echo $cartItems =  Cart::content()->count();
        }
    }


    function add_to_cart_book(Request $request)
    {

        $package_id = $request->input('package_id');
        $qty = $request->input('qty');

        if ($package_id != '') {

            $package_data = DB::table('packages')->where('id', $package_id)->first();

            if ($package_data->image != '') {
                $image = $package_data->image;
            } else {
                $image = "no-image.png";
            }

            $service_data = DB::table('services')->where('id', $package_data->service_id)->first();
            $subservices_data = DB::table('subservices')->where('id', $package_data->subservice_id)->first();
            //    echo "<pre>";print_r($subservices_data);echo "</pre>";exit;
            $packagecategory_data = DB::table('package_categories')->where('id', $package_data->packagecategory_id)->first();

            if ($package_data->booking_service_per > 0 && $package_data->booking_service_per != '') {
                $servicepercentage = $package_data->booking_service_per;
            } elseif ($subservices_data->servicepercentage > 0 && $subservices_data->servicepercentage != '') {
                $servicepercentage = $subservices_data->servicepercentage;
            } else {
                $servicepercentage = 0;
            }


            // if($subservices_data->servicepercentage > 0 && $subservices_data->servicepercentage != '') {
            //     $servicepercentage = $subservices_data->servicepercentage;
            // }else{
            //     $servicepercentage = 0;
            // }


            //echo "<pre>";print_r($subservices_data);echo "</pre>";exit;

            $price = $package_data->price;

            if ($package_data->discount > 0) {

                if ($package_data->discount_type == 0) {

                    $disc_price_new = $price * $package_data->discount / 100;

                    $disc_price = $price - $disc_price_new;
                } elseif ($package_data->discount_type == 1) {
                    $disc_price = $price - $package_data->discount;
                } else {
                    $disc_price = $price;
                }
            } else {
                $disc_price = 0;
            }

            $cartdiscount = $disc_price;

            //echo "<pre>";print_r($service_data);echo "</pre>";exit;

            $cartItem =  Cart::add([
                'id' => $package_data->id,
                'name' => $package_data->name,
                'qty' => $qty,
                'price' => $package_data->price,
                'options' => [
                    'service_id' => $package_data->service_id,
                    'service_name' => $service_data->servicename,
                    'subservice_id' => $package_data->subservice_id,
                    'subservice_name' => $subservices_data->subservicename,
                    'subservice_description' => $subservices_data->description,
                    'packagecategory_id' => $package_data->service_id,
                    'packagecategory_name' => $packagecategory_data->name,
                    'page_url' => $package_data->page_url,
                    'product_discount_amount' => $cartdiscount,
                    'image' => $image,
                    'discount' => $package_data->discount,
                    'discount_type' => $package_data->discount_type,
                    'subservice_booking_percentage' => $servicepercentage,

                ]
            ]);

            $subtotal = 0;
            foreach (Cart::content() as $item) {
                $price = $item->price;
                if ($item->options->discount_type !== null) {
                    if ($item->options->discount_type == 0) {
                        $price -= ($item->price * $item->options->discount) / 100;
                    } elseif ($item->options->discount_type == 1) {
                        $price -= $item->options->discount;
                    }
                }
                $subtotal += $item->qty * round($price);
            }
            // echo "<pre>";print_r(Cart::content());echo"</pre>";exit;

            // echo $cartItems =  Cart::content()->count();
            return response()->json([
                'rowId' => $cartItem->rowId,
                'cartCount' => Cart::content()->count(),
                'name' => $package_data->name,
                'qty' => $qty,
                'price' => $package_data->price,
                'desc_price' => $cartItem->options->product_discount_amount,
                'subtotal' => $subtotal
            ]);
        }
    }


    function cart_remove()
    {

        $rowId = $_POST['rowId'];
        Cart::remove($rowId);
        Session::forget('walletdiscount');
        echo Cart::count();
    }
    function cart_remove_book_now()
    {

        $rowId = $_POST['rowId'];
        Cart::remove($rowId);
        Session::forget('walletdiscount');
        echo Cart::count();
    }
    function minus_quantity_cart_remove_book_now()
    {

        $rowId = $_POST['rowid'];

        $item = Cart::get($rowId);

        if ($item) {
            $packageId = $item->id; // Assuming `id` contains the package ID
            Cart::remove($rowId);

            // Prepare the response data
            $response = [
                'status' => 'success',
                'message' => 'Item removed successfully.',
                'package_id' => $packageId,
                'cart_count' => Cart::count()
            ];

            // Return the response as JSON
            echo json_encode($response);
        }
    }

    function update_cart()
    {
        // echo "<pre>";print_r($_POST);echo "</pre>";exit;
        $rowid = $_POST['rowid'];
        $qty = $_POST['qty'];
        $count = $_POST['count'];
        Cart::update($rowid, $count);
        echo Cart::count();
    }
    function update_cart_book_now()
    {
        // Retrieve the POST data
        $rowid = $_POST['rowid'];
        $count = $_POST['count']; // The new quantity to update

        // Update the cart item quantity

        Cart::update($rowid, $count);
        $subtotal = 0;
        foreach (Cart::content() as $items) {
            if ($items->options->discount_type != '') {
                if ($items->options->discount_type == 0) {
                    //percentage
                    $disc_price_new = ($items->price * $items->options->discount) / 100;
                    $disc_price = $items->price - $disc_price_new;
                    $p_price = $disc_price;
                } elseif ($items->options->discount_type == 1) {
                    $disc_price = $items->price - $items->options->discount;
                    $p_price = $disc_price;
                } else {
                    $disc_price = '0';
                    $p_price = $items->price;
                }
            } else {
                $disc_price = '0';
            }

            if ($items->qty >= 1) {
                $subtotal += $items->qty * round($p_price);
            } else {
                $subtotal += round($p_price);
            }
        }
        // echo"<pre>";print_r($subtotal);echo"</pre>";exit;

        // Prepare the response data
        $updatedItem = Cart::get($rowid); // Get the updated cart item details

        echo json_encode([
            'count' => $updatedItem->qty, // Return the updated quantity
            'subtotal' => $subtotal, // Return the updated subtotal for all items
        ]);
    }

    function checkout_promo_codecheck()
    {

        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $coupan = $_POST['promo_code'];

        $select_coupan = DB::table('coupans')
            ->where('startdate', '<=', now()->toDateString())
            ->where('enddate', '>=', now()->toDateString())
            ->where('coupan_code', $coupan)
            ->where('is_active', 0)
            ->first();

        $userid = Session::get('user')['userid'];

        $already_applied_promo = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->where('user_id', $userid)
            ->first();

        $cart_data = Cart::content();

        // echo"<pre>";print_r($cart_data);echo"</pre>";exit;
        if ($select_coupan != "") {
            if ($already_applied_promo == "") {


                if (session('coupan_data.coupancode') !=  $coupan) {


                    $numberofcoupon = DB::table('ci_orders')
                        ->where('coupon_code', $coupan)
                        ->count();
                    // echo"<pre>";print_r($numberofcoupon);echo"</pre>";exit;

                    if ($select_coupan->no_of_coupons > $numberofcoupon) {

                        $numberofcoupon_user = DB::table('ci_orders')
                            ->where('coupon_code', $coupan)
                            ->count();
                        if ($select_coupan->no_of_coupons_user > $numberofcoupon_user) {



                            $servicecheck = false;
                            $subservicecheck = false;
                            $minimum = 0;
                            $in_service_array = explode(",", $select_coupan->service_id);
                            $in_subservice_array = explode(",", $select_coupan->subservice_id);

                            // echo "<pre>";print_r($in_subservice_array);echo"</pre>";exit;
                            if (count($cart_data) > 0) {

                                //echo "heresss";exit;

                                foreach ($cart_data as $items) {

                                    // echo "<pre>";print_r($items->options->subservice_id);echo"</pre>";exit;
                                    // $options =  unserialize($items->options);

                                    if (in_array($items->options->service_id, $in_service_array)) {
                                        $servicecheck = true;
                                    }
                                    if (in_array($items->options->subservice_id, $in_subservice_array)) {
                                        $subservicecheck = true;
                                    }

                                    $subtotal = $items->price * $items->qty;

                                    if ($select_coupan->is_discounted == 0 && $items->options['product_discount_amount'] == 0) {
                                        $minimum  += $subtotal;
                                    } else if ($select_coupan->is_discounted == 1) {

                                        $minimum  += $subtotal;
                                    } else {
                                        $minimum  += $subtotal;
                                    }
                                    // echo"<pre>";print_r($minimum);echo"</pre>";exit;
                                }
                            }

                            if ($select_coupan->coupanvalue == 0) {

                                $coupon_discounted = round(($minimum * $select_coupan->discount) / 100);
                            }

                            if ($select_coupan->coupanvalue == 1) {

                                $coupon_discounted = $select_coupan->discount;
                            }

                            if ($select_coupan->service_id == "" || $select_coupan->service_id == 0 || $servicecheck == true && $subservicecheck == true) {



                                if ($minimum >= $select_coupan->minimum_order) {

                                    //    echo"here";exit;
                                    if ($minimum >= $coupon_discounted) {


                                        $coupan_data = array(

                                            'coupanname'  => $select_coupan->coupan_name,

                                            'coupancode'  => $select_coupan->coupan_code,

                                            'discount'  => $select_coupan->discount,

                                            'coupanvalue'  => $select_coupan->coupanvalue,

                                            'coupan_apply_wallet'  => $select_coupan->coupan_apply_wallet,

                                            'coupan_service'  => $select_coupan->service_id,

                                            'coupan_subservice'  => $select_coupan->subservice_id,

                                            'minimum_order'  => $select_coupan->minimum_order,

                                            'is_discounted'  => $select_coupan->is_discounted,

                                            'sub_total'  => $minimum,

                                            'amount'  => $coupon_discounted,

                                            'service' => $items->options->service_id,

                                            'sub_service' => $items->options->subservice_id,

                                        );
                                        // session()->forget('coupan_data');
                                        session(['coupan_data' => $coupan_data]);
                                        echo 'success';
                                    } else {
                                        echo 'grater';
                                    }
                                } else {
                                    echo $select_coupan->minimum_order;
                                }
                            } else {
                                echo 'invalid';
                            }
                        } else {
                            echo "invalid";
                        }
                    } else {
                        echo "invalid_user_count";
                    }
                } else {
                    echo "Already";
                }
            } else {
                echo "invalid_date";
            }
        } else {
            echo 'invalid';
        }
        // echo"<pre>";print_r($cart_data);echo"</pre>";exit;
    }
    function promo_codecheck()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $coupan = $_POST['promo'];

        $select_coupan = DB::table('coupans')
            ->where('startdate', '<=', now()->toDateString())
            ->where('enddate', '>=', now()->toDateString())
            ->where('coupan_code', $coupan)
            ->where('is_active', 0)
            ->first();

        $userid = Session::get('user')['userid'];

        $already_applied_promo = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->where('user_id', $userid)
            ->first();

        $cart_data = Cart::content();

        // echo"<pre>";print_r($select_coupan);echo"</pre>";exit;
        if ($select_coupan != "") {
            if ($already_applied_promo == "") {


                if (session('coupan_data.coupancode') !=  $coupan) {


                    $numberofcoupon = DB::table('ci_orders')
                        ->where('coupon_code', $coupan)
                        ->count();
                    // echo"<pre>";print_r($numberofcoupon);echo"</pre>";exit;

                    if ($select_coupan->no_of_coupons > $numberofcoupon) {

                        $numberofcoupon_user = DB::table('ci_orders')
                            ->where('coupon_code', $coupan)
                            ->count();
                        if ($select_coupan->no_of_coupons_user > $numberofcoupon_user) {



                            $servicecheck = false;
                            $subservicecheck = false;
                            $minimum = 0;
                            $in_service_array = explode(",", $select_coupan->service_id);
                            $in_subservice_array = explode(",", $select_coupan->subservice_id);

                            // echo "<pre>";print_r($in_subservice_array);echo"</pre>";exit;
                            if (count($cart_data) > 0) {

                                //echo "heresss";exit;

                                foreach ($cart_data as $items) {

                                    // echo "<pre>";print_r($items->options->service_id);echo"</pre>";exit;
                                    // $options =  unserialize($items->options);

                                    if (in_array($items->options->service_id, $in_service_array)) {
                                        $servicecheck = true;
                                    }
                                    if (in_array($items->options->subservice_id, $in_subservice_array)) {
                                        $subservicecheck = true;
                                    }

                                    $subtotal = $items->price * $items->qty;

                                    if ($select_coupan->is_discounted == 0 && $items->options['product_discount_amount'] == 0) {
                                        $minimum  += $subtotal;
                                    } else if ($select_coupan->is_discounted == 1) {

                                        $minimum  += $subtotal;
                                    } else {
                                        $minimum  += $subtotal;
                                    }
                                    // echo"<pre>";print_r($minimum);echo"</pre>";exit;
                                }
                            }

                            if ($select_coupan->coupanvalue == 0) {

                                $coupon_discounted = round(($minimum * $select_coupan->discount) / 100);
                            }

                            if ($select_coupan->coupanvalue == 1) {

                                $coupon_discounted = $select_coupan->discount;
                            }

                            if ($select_coupan->service_id == "" || $select_coupan->service_id == 0 || $servicecheck == true && $subservicecheck == true) {



                                if ($minimum >= $select_coupan->minimum_order) {

                                    //    echo"here";exit;
                                    if ($minimum >= $coupon_discounted) {


                                        $coupan_data = array(

                                            'coupanname'  => $select_coupan->coupan_name,

                                            'coupancode'  => $select_coupan->coupan_code,

                                            'discount'  => $select_coupan->discount,

                                            'coupanvalue'  => $select_coupan->coupanvalue,

                                            'coupan_apply_wallet'  => $select_coupan->coupan_apply_wallet,

                                            'coupan_service'  => $select_coupan->service_id,

                                            'coupan_subservice'  => $select_coupan->subservice_id,

                                            'minimum_order'  => $select_coupan->minimum_order,

                                            'is_discounted'  => $select_coupan->is_discounted,

                                            'sub_total'  => $minimum,

                                            'amount'  => $coupon_discounted,

                                            'service' => $items->options->service_id,

                                            'sub_service' => $items->options->subservice_id,

                                        );
                                        // session()->forget('coupan_data');
                                        session(['coupan_data' => $coupan_data]);
                                        echo 'success';
                                    } else {
                                        echo 'grater';
                                    }
                                } else {
                                    echo $select_coupan->minimum_order;
                                }
                            } else {
                                echo 'invalid';
                            }
                        } else {
                            echo "invalid";
                        }
                    } else {
                        echo "invalid_user_count";
                    }
                } else {
                    echo "Already";
                }
            } else {
                echo "invalid_date";
            }
        } else {
            echo 'invalid';
        }
    }


    function lat_summary_promo_codecheck()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $coupan = $_POST['promo'];


        $select_coupan = DB::table('coupans')
            ->where('startdate', '<=', now()->toDateString())
            ->where('enddate', '>=', now()->toDateString())
            ->where('coupan_code', $coupan)
            ->where('is_active', 0)
            ->first();

        $userid = Session::get('user')['userid'];

        $cart_data = Cart::content();

        // echo"<pre>";print_r($select_coupan);echo"</pre>";exit;
        $already_applied_promo = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->where('user_id', $userid)
            ->first();
        if ($select_coupan != "") {
            if ($already_applied_promo == "") {


                if (session('coupan_data.coupancode') !=  $coupan) {


                    $numberofcoupon = DB::table('ci_orders')
                        ->where('coupon_code', $coupan)
                        ->count();
                    // echo"<pre>";print_r($numberofcoupon);echo"</pre>";exit;

                    if ($select_coupan->no_of_coupons > $numberofcoupon) {



                        $numberofcoupon_user = DB::table('ci_orders')
                            ->where('coupon_code', $coupan)
                            ->count();
                        if ($select_coupan->no_of_coupons_user > $numberofcoupon_user) {



                            $servicecheck = false;
                            $subservicecheck = false;
                            $minimum = 0;
                            $in_service_array = explode(",", $select_coupan->service_id);
                            $in_subservice_array = explode(",", $select_coupan->subservice_id);

                            // echo "<pre>";print_r($in_subservice_array);echo"</pre>";exit;
                            if (count($cart_data) > 0) {

                                //echo "heresss";exit;

                                foreach ($cart_data as $items) {

                                    // echo "<pre>";print_r($items->options->service_id);echo"</pre>";exit;
                                    // $options =  unserialize($items->options);

                                    if (in_array($items->options->service_id, $in_service_array)) {
                                        $servicecheck = true;
                                    }
                                    if (in_array($items->options->subservice_id, $in_subservice_array)) {
                                        $subservicecheck = true;
                                    }

                                    $subtotal = $items->price * $items->qty;

                                    // echo"<pre>";print_r($subtotal);echo"</pre>";exit;

                                    if ($select_coupan->is_discounted == 0 && $items->options['product_discount_amount'] == 0) {
                                        $minimum  += $subtotal;
                                    } else if ($select_coupan->is_discounted == 1) {

                                        $minimum  += $subtotal;
                                    } else {
                                        $minimum  += $subtotal;
                                    }
                                    // echo"<pre>";print_r($minimum);echo"</pre>";exit;
                                }
                            }

                            if ($select_coupan->coupanvalue == 0) {

                                $coupon_discounted = round(($minimum * $select_coupan->discount) / 100);
                                // echo"<pre>";print_r($coupon_discounted);echo"</pre>";exit;
                            }

                            if ($select_coupan->coupanvalue == 1) {

                                $coupon_discounted = $select_coupan->discount;
                            }

                            if ($select_coupan->service_id == "" || $select_coupan->service_id == 0 || $servicecheck == true && $subservicecheck == true) {



                                if ($minimum >= $select_coupan->minimum_order) {

                                    //    echo"here";exit;
                                    if ($minimum >= $coupon_discounted) {


                                        $coupan_data = array(

                                            'coupanname'  => $select_coupan->coupan_name,

                                            'coupancode'  => $select_coupan->coupan_code,

                                            'discount'  => $select_coupan->discount,

                                            'coupanvalue'  => $select_coupan->coupanvalue,

                                            'coupan_apply_wallet'  => $select_coupan->coupan_apply_wallet,

                                            'coupan_service'  => $select_coupan->service_id,

                                            'coupan_subservice'  => $select_coupan->subservice_id,

                                            'minimum_order'  => $select_coupan->minimum_order,

                                            'is_discounted'  => $select_coupan->is_discounted,

                                            'sub_total'  => $minimum,

                                            'amount'  => $coupon_discounted,

                                            'service' => $items->options->service_id,

                                            'sub_service' => $items->options->subservice_id,

                                        );

                                        session()->forget('coupan_data');
                                        session(['coupan_data' => $coupan_data]);
                                        echo 'success';
                                    } else {
                                        echo 'grater';
                                    }
                                } else {
                                    echo $select_coupan->minimum_order;
                                }
                            } else {
                                echo 'invalid';
                            }
                        } else {
                            echo "invalid";
                        }
                    } else {
                        echo "invalid_user_count";
                    }
                } else {
                    echo "Already";
                }
            } else {
                echo "invalid_date";
            }
        } else {
            echo "invalid";
        }
    }

    function promo_codecheck_home_cleaning()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $coupan = $_POST['promo'];
        $subtotal = $_POST['sub_total'];
        $service_id = $_POST['service'];
        $subservice_id = $_POST['sub_service'];

        $select_coupan = DB::table('coupans')
            ->where('startdate', '<=', now()->toDateString())
            ->where('enddate', '>=', now()->toDateString())
            ->where('coupan_code', $coupan)
            ->where('is_active', 0)
            ->first();

        $userid = Session::get('user')['userid'];

        // echo"<pre>";print_r($select_coupan);echo"</pre>";exit;

        $already_applied_promo = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->where('user_id', $userid)
            ->first();
        if ($select_coupan != "") {
            // echo"in";exit;
            if ($already_applied_promo == "") {
                //    echo"out";exit;

                if (session('coupan_data.coupancode') !=  $coupan) {


                    $numberofcoupon = DB::table('ci_orders')
                        ->where('coupon_code', $coupan)
                        ->count();
                    // echo"<pre>";print_r($numberofcoupon);echo"</pre>";exit;

                    if ($select_coupan->no_of_coupons > $numberofcoupon) {



                        $numberofcoupon_user = DB::table('ci_orders')
                            ->where('coupon_code', $coupan)
                            ->count();
                        if ($select_coupan->no_of_coupons_user > $numberofcoupon_user) {



                            $servicecheck = false;
                            $subservicecheck = false;
                            $minimum = 0;
                            $in_service_array = explode(",", $select_coupan->service_id);
                            $in_subservice_array = explode(",", $select_coupan->subservice_id);

                            // echo "<pre>";print_r($in_subservice_array);echo"</pre>";exit;
                            if ($subtotal > 0) {

                                //echo "heresss";exit;

                                if (in_array($service_id, $in_service_array)) {
                                    $servicecheck = true;
                                }
                                if (in_array($subservice_id, $in_subservice_array)) {
                                    $subservicecheck = true;
                                }

                                if ($select_coupan->is_discounted == 0) {
                                    $minimum  += $subtotal;
                                } else if ($select_coupan->is_discounted == 1) {
                                    $minimum  += $subtotal;
                                } else {
                                    $minimum  += $subtotal;
                                }
                                //echo"<pre>";print_r($minimum);echo"</pre>";exit;
                            }

                            if ($select_coupan->coupanvalue == 0) {

                                $coupon_discounted = round(($minimum * $select_coupan->discount) / 100);
                                // echo"<pre>";print_r($coupon_discounted  );echo"</pre>";exit;
                            }

                            if ($select_coupan->coupanvalue == 1) {

                                $coupon_discounted = $select_coupan->discount;
                                // echo"<pre>";print_r($coupon_discounted  );echo"</pre>";exit;
                            }

                            if ($select_coupan->service_id == "" || $select_coupan->service_id == 0 || $servicecheck == true && $subservicecheck == true) {

                                // echo"<pre>";print_r($select_coupan->minimum_order);echo"</pre>";exit;

                                if ($minimum >= $select_coupan->minimum_order) {

                                    //    echo"here";exit;
                                    if ($minimum >= $coupon_discounted) {


                                        $coupan_data = array(

                                            'coupanname'  => $select_coupan->coupan_name,

                                            'coupancode'  => $select_coupan->coupan_code,

                                            'discount'  => $select_coupan->discount,

                                            'coupanvalue'  => $select_coupan->coupanvalue,

                                            'coupan_apply_wallet'  => $select_coupan->coupan_apply_wallet,

                                            'coupan_service'  => $select_coupan->service_id,

                                            'coupan_subservice'  => $select_coupan->subservice_id,

                                            'minimum_order'  => $select_coupan->minimum_order,

                                            'is_discounted'  => $select_coupan->is_discounted,

                                            'sub_total'  => $minimum,

                                            'amount'  => $coupon_discounted,

                                            'service' => $service_id,

                                            'sub_service' => $subservice_id,

                                        );

                                        session(['coupan_data' => $coupan_data]);

                                        echo 'success';
                                    } else {
                                        echo 'grater';
                                    }
                                } else {
                                    echo $select_coupan->minimum_order;
                                }
                            } else {
                                echo 'invalid';
                            }
                        } else {
                            echo "invalid";
                        }
                    } else {
                        echo "invalid_user_count";
                    }
                } else {
                    echo "Already";
                }
            } else {
                echo "invalid_date";
            }
        } else {
            echo 'invalid';
        }
    }


    function lat_summary_home_cleaning_promo_codecheck()
    {
        // echo"<pre>";print_r($_POST);echo"</pre>";exit;
        $coupan = $_POST['promo'];
        $subtotal = $_POST['sub_total'];
        $service_fee = $_POST['service_fee'];
        $service_id = $_POST['service'];
        $subservice_id = $_POST['sub_service'];

        $subtotal = $subtotal + $service_fee;

        // alert($subtotal);
        // echo"<pre>";print_r($subtotal);echo"</pre>";exit;

        $select_coupan = DB::table('coupans')
            ->where('startdate', '<=', now()->toDateString())
            ->where('enddate', '>=', now()->toDateString())
            ->where('coupan_code', $coupan)
            ->where('is_active', 0)
            ->first();

        // echo"<pre>";print_r($select_coupan);echo"</pre>";exit;
        $userid = Session::get('user')['userid'];

        // echo"<pre>";print_r($select_coupan);echo"</pre>";exit;

        $already_applied_promo = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->where('user_id', $userid)
            ->first();
        if ($select_coupan != "") {
            if ($already_applied_promo == "") {


                if (session('coupan_data.coupancode') !=  $coupan) {


                    $numberofcoupon = DB::table('ci_orders')
                        ->where('coupon_code', $coupan)
                        ->count();
                    // echo"<pre>";print_r($numberofcoupon);echo"</pre>";exit;

                    if ($select_coupan->no_of_coupons > $numberofcoupon) {

                        $numberofcoupon_user = DB::table('ci_orders')
                            ->where('coupon_code', $coupan)
                            ->count();

                        if ($select_coupan->no_of_coupons_user > $numberofcoupon_user) {

                            $servicecheck = false;
                            $subservicecheck = false;
                            $minimum = 0;
                            $in_service_array = explode(",", $select_coupan->service_id);
                            $in_subservice_array = explode(",", $select_coupan->subservice_id);

                            // echo "<pre>";print_r($in_subservice_array);echo"</pre>";exit;
                            if ($subtotal > 0) {

                                if (in_array($service_id, $in_service_array)) {
                                    $servicecheck = true;
                                }
                                if (in_array($subservice_id, $in_subservice_array)) {
                                    $subservicecheck = true;
                                }

                                if ($select_coupan->is_discounted == 0) {
                                    $minimum  += $subtotal;
                                } else if ($select_coupan->is_discounted == 1) {

                                    $minimum  += $subtotal;
                                } else {
                                    $minimum  += $subtotal;
                                }
                            }

                            if ($select_coupan->coupanvalue == 0) {

                                $coupon_discounted = round(($minimum * $select_coupan->discount) / 100);
                                // echo"<pre>";print_r($coupon_discounted);echo"</pre>";exit;
                            }

                            if ($select_coupan->coupanvalue == 1) {

                                $coupon_discounted = $select_coupan->discount;
                            }

                            if ($select_coupan->service_id == "" || $select_coupan->service_id == 0 || $servicecheck == true && $subservicecheck == true) {



                                if ($minimum >= $select_coupan->minimum_order) {

                                    //    echo"here";exit;
                                    if ($minimum >= $coupon_discounted) {


                                        $coupan_data = array(

                                            'coupanname'  => $select_coupan->coupan_name,

                                            'coupancode'  => $select_coupan->coupan_code,

                                            'discount'  => $select_coupan->discount,

                                            'coupanvalue'  => $select_coupan->coupanvalue,

                                            'coupan_apply_wallet'  => $select_coupan->coupan_apply_wallet,

                                            'coupan_service'  => $select_coupan->service_id,

                                            'coupan_subservice'  => $select_coupan->subservice_id,

                                            'minimum_order'  => $select_coupan->minimum_order,

                                            'is_discounted'  => $select_coupan->is_discounted,

                                            'sub_total'  => $minimum,

                                            'amount'  => $coupon_discounted,

                                            'service' => $service_id,

                                            'sub_service' => $subservice_id,

                                        );

                                        session()->forget('coupan_data');
                                        session(['coupan_data' => $coupan_data]);
                                        // echo"<pre>";print_r($coupan_data);echo"</pre>";exit;
                                        echo 'success';
                                    } else {
                                        echo 'grater';
                                    }
                                } else {
                                    echo $select_coupan->minimum_order;
                                }
                            } else {
                                echo 'invalid';
                            }
                        } else {
                            echo "invalid";
                        }
                    } else {
                        echo "invalid_user_count";
                    }
                } else {
                    echo "Already";
                }
            } else {
                echo "invalid_date";
            }
        } else {
            echo 'invalid';
        }
    }



    function remove_coupon()
    {

        Session::forget('coupan_data');

        echo "0";
    }

    function checkout_remove_coupon()
    {

        Session::forget('coupan_data');

        echo "0";
    }

    function last_summary_remove_coupon()
    {

        Session::forget('coupan_data');

        echo "0";
    }
    function home_cleaning_remove_coupon()
    {

        Session::forget('coupan_data');

        echo "0";
    }
    function last_summary_home_cleaning_remove_coupon()
    {

        Session::forget('coupan_data');

        echo "0";
    }

    function package_cart()
    {
        $cart = Session::get('package_cart', []);
        return response()->json($cart);
    }

    // Store cart in session
    public function package_cart_store(Request $request)
    {
        $cart = $request->cart ?? []; // Expecting JSON object
        $cart = array_filter($cart);
        //echo "<pre>";print_r($cart);echo"</pre>";exit;
        //Session::put('package_cart', $cart);
        $sessionCart = [];
        foreach ($cart as $id => $item) {

            $product = [
                'id'    => $id,
                'name'  => $item['name'],
                'qty'   => $item['qty'],
                'price' => $item['price'],
                'service' => $item['service'],
                'subservice_id' => $item['subservice_id'],
                'type'  => $item['type'],  // store type
                'options' => []
            ];

            if ($item['type'] === 'package') {
                $package_data = DB::table('packages')->where('id', $id)->first();
                $packagecategory_data = DB::table('package_categories')->where('id', $package_data->packagecategory_id)->first();

                $packagecategory_id = $packagecategory_data->id;
                $packagecategory_name = $packagecategory_data->name;
            } elseif ($item['type'] === 'addons') {
                $package_data = DB::table('addons')->where('id', $id)->first();
                $packagecategory_id = "";
                $packagecategory_name = "";
            }

            $service_data = DB::table('services')->where('id', $item['service'])->first();
            $subservices_data = DB::table('subservices')->where('id', $item['subservice_id'])->first();

            $product['options'] = [
                'service_id'                 => $service_data->id,
                'service_name'               => $service_data->servicename ?? '',
                'subservice_id'              => $subservices_data->id,
                'subservice_name'            => $subservices_data->subservicename ?? '',
                'packagecategory_id'         => $packagecategory_id ?? '',
                'packagecategory_name'       => $packagecategory_name ?? '',
                'product_discount_amount'    => $package_data->discount,
                'image'                      => $package_data->image,
                'discount'                   => $package_data->discount,
                'discount_type'              => $package_data->discount_type,
            ];

            $sessionCart[$id] = $product;
        }

        if (count($sessionCart) == 0) {
            Session::forget('coupan_data');
        }
        session(['package_cart' => $sessionCart]);
        return response()->json(['success' => true]);
    }
    function package_promo_check(Request $request)
    {

        $cart_data = Session::get('package_cart', []);

        //echo"<pre>";print_r($cart_data);echo"</pre>";exit;

        $coupan = $request->promo_code;
        $userid = Session::get('user')['userid'];

        $query = DB::table('coupans')
            ->where('startdate', '<=', now()->toDateString())
            ->where('enddate', '>=', now()->toDateString())
            ->where('coupan_code', $coupan)
            ->where('is_active', 0);

        // Show SQL + bindings
        //dd($query->toSql(), $query->getBindings());

        // Now run query
        $select_coupan = $query->first();
        //echo"<pre>";print_r($select_coupan);echo"</pre>";exit;

        $already_applied_promo = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->where('user_id', $userid)
            ->first();

        $numberofcoupon = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->count();

        $numberofcoupon_user = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->count();

        if ($select_coupan != "") {

            if ($already_applied_promo == "") {

                if (session('coupan_data.coupancode') !=  $coupan) {

                    if ($select_coupan->no_of_coupons > $numberofcoupon) {

                        if ($select_coupan->no_of_coupons_user > $numberofcoupon_user) {

                            $servicecheck = false;
                            $subservicecheck = false;
                            $minimum = 0;
                            $in_service_array = explode(",", $select_coupan->service_id);
                            $in_subservice_array = explode(",", $select_coupan->subservice_id);
                            //
                            if (count($cart_data) > 0) {

                                foreach ($cart_data as $items) {

                                    // echo "<pre>";print_r($items['options']['service_id']);echo"</pre>";exit;

                                    if (in_array($items['options']['service_id'], $in_service_array)) {
                                        $servicecheck = true;
                                    }
                                    if (in_array($items['options']['subservice_id'], $in_subservice_array)) {
                                        $subservicecheck = true;
                                    }

                                    $subtotal = $items['price'] * $items['qty'];

                                    if ($select_coupan->is_discounted == 0 && $items['options']['product_discount_amount'] == 0) {
                                        $minimum  += $subtotal;
                                    } else if ($select_coupan->is_discounted == 1) {

                                        $minimum  += $subtotal;
                                    } else {
                                        $minimum  += $subtotal;
                                    }
                                }
                            }
                            if ($select_coupan->coupanvalue == 0) {

                                $coupon_discounted = ($minimum * $select_coupan->discount) / 100;
                            }
                            if ($select_coupan->coupanvalue == 1) {

                                $coupon_discounted = $select_coupan->discount;
                            }

                            if ($select_coupan->service_id == "" || $select_coupan->service_id == 0 || $servicecheck == true && $subservicecheck == true) {

                                if ($minimum >= $select_coupan->minimum_order) {

                                    if ($minimum >= $coupon_discounted) {

                                        $coupan_data = array(

                                            'coupanname'  => $select_coupan->coupan_name,

                                            'coupancode'  => $select_coupan->coupan_code,

                                            'discount'  => $select_coupan->discount,

                                            'coupanvalue'  => $select_coupan->coupanvalue,

                                            'coupan_apply_wallet'  => $select_coupan->coupan_apply_wallet,

                                            'coupan_service'  => $select_coupan->service_id,

                                            'coupan_subservice'  => $select_coupan->subservice_id,

                                            'minimum_order'  => $select_coupan->minimum_order,

                                            'is_discounted'  => $select_coupan->is_discounted,

                                            'sub_total'  => $minimum,

                                            'amount'  => $coupon_discounted,

                                            'service' => $items['options']['service_id'],

                                            'sub_service' => $items['options']['subservice_id'],

                                        );
                                        // session()->forget('coupan_data');
                                        session(['coupan_data' => $coupan_data]);
                                        echo 'success';
                                    } else {
                                        echo 'grater';
                                    }
                                } else {
                                    echo $select_coupan->minimum_order;
                                }
                            } else {
                                echo 'invalid';
                            }
                        } else {
                            echo "invalid";
                        }
                    } else {
                        echo "invalid_user_count";
                    }
                } else {
                    echo "Already Used";
                }
            } else {
                echo "Already";
            }
        } else {
            echo "invalid";
        }
        //echo"<pre>";print_r($request->all());echo"</pre>";exit;
    }

    public function getCouponData(Request $request)
    {
        $coupan_data = session('coupan_data', null); // get coupon from session

        //echo"<pre>";print_r($coupan_data);echo"</pre>";exit;
        return response()->json($coupan_data);
    }

    public function homecleaning_getCouponData(Request $request)
    {
        $coupan_data = session('coupan_data', null); // get coupon from session

        //echo"<pre>";print_r($coupan_data);echo"</pre>";exit;
        return response()->json($coupan_data);
    }

    function package_remove_coupon()
    {

        Session::forget('coupan_data');

        echo "0";
    }

    function homecleaning_remove_coupon()
    {

        Session::forget('coupan_data');

        echo "0";
    }

    public function homecleaningaddons_store(Request $request)
    {

        //echo"<pre>";print_r($request->all());echo"</pre>";exit;
        $addons = $request->addons ?? [];
        $service_id = $request->service_id;
        $subservice_id = $request->subservice_id;

        $cleaned = [];

        foreach ($addons as $id => $item) {
            if (
                is_array($item) &&
                isset($item['qty']) &&
                $item['qty'] > 0
            ) {
                $addons_data = DB::table('addons')->where('id', $id)->first();

                $service_data = DB::table('services')->where('id', $service_id)->first();
                $subservices_data = DB::table('subservices')->where('id', $subservice_id)->first();

                $cleaned[$id] = [
                    'name'  => $item['name'],
                    'price' => $item['price'],
                    'qty'   => (int) $item['qty'],
                    'service' => $service_id,
                    'subservice_id' => $subservice_id,
                    'options' => [
                        'addon_id'                   => $addons_data->id,
                        'service_id'                 => $service_id,
                        'service_name'               => $service_data->servicename ?? '',
                        'subservice_id'              => $subservice_id,
                        'subservice_name'            => $subservices_data->subservicename ?? '',
                        'product_discount_amount'    => $addons_data->discount,
                        'image'                      => $addons_data->image,
                        'discount'                   => $addons_data->discount,
                        'discount_type'              => $addons_data->discount_type,
                    ],
                ];
            }
        }

        session(['addons_cart' => $cleaned]);
        //session()->flush('addons_cart');

        return response()->json(['status' => true]);
    }

    public function homecleaningaddons_get()
    {
        return response()->json(session('addons_cart', []));
    }

    function home_promo_check(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());
        // exit;

        // session()->forget('coupan_data');

        $coupan = $request->promo_code;
        $subtotal = $request->sub_total;
        $service_id = $request->service;
        $subservice_id = $request->sub_service;

        $select_coupan = DB::table('coupans')
            ->where('startdate', '<=', now()->toDateString())
            ->where('enddate', '>=', now()->toDateString())
            ->where('coupan_code', $coupan)
            ->where('is_active', 0)
            ->first();

        $userid = Session::get('user')['userid'] ?? '0';

        $already_applied_promo = DB::table('ci_orders')
            ->where('coupon_code', $coupan)
            ->where('user_id', $userid)
            ->first();



        if ($select_coupan != "") {
            if ($already_applied_promo == "") {
                if (session('coupan_data.coupancode') !=  $coupan) {
                    $numberofcoupon = DB::table('ci_orders')
                        ->where('coupon_code', $coupan)
                        ->count();
                    if ($select_coupan->no_of_coupons > $numberofcoupon) {

                        $numberofcoupon_user = DB::table('ci_orders')
                            ->where('coupon_code', $coupan)
                            ->count();
                        if ($select_coupan->no_of_coupons_user > $numberofcoupon_user) {
                            $servicecheck = false;
                            $subservicecheck = false;
                            $minimum = 0;
                            $in_service_array = explode(",", $select_coupan->service_id);
                            $in_subservice_array = explode(",", $select_coupan->subservice_id);

                            if ($subtotal > 0) {

                                //echo "heresss";exit;

                                if (in_array($service_id, $in_service_array)) {
                                    $servicecheck = true;
                                }
                                if (in_array($subservice_id, $in_subservice_array)) {
                                    $subservicecheck = true;
                                }

                                if ($select_coupan->is_discounted == 0) {
                                    $minimum  += $subtotal;
                                } else if ($select_coupan->is_discounted == 1) {
                                    $minimum  += $subtotal;
                                } else {
                                    $minimum  += $subtotal;
                                }
                                //echo"<pre>";print_r($minimum);echo"</pre>";exit;
                            }

                            if ($select_coupan->coupanvalue == 0) {

                                $coupon_discounted = round(($minimum * $select_coupan->discount) / 100);
                                // echo"<pre>";print_r($coupon_discounted  );echo"</pre>";exit;
                            }

                            if ($select_coupan->coupanvalue == 1) {

                                $coupon_discounted = $select_coupan->discount;
                                // echo"<pre>";print_r($coupon_discounted  );echo"</pre>";exit;
                            }

                            //echo"<pre>";print_r($select_coupan  );echo"</pre>";exit;

                            if ($select_coupan->service_id == "" || $select_coupan->service_id == 0 || $servicecheck == true && $subservicecheck == true) {

                                if ($minimum >= $select_coupan->minimum_order) {

                                    //echo $minimum."---".$coupon_discounted;exit;

                                    if ($minimum >= $coupon_discounted) {

                                        $coupan_data = array(

                                            'coupanname'  => $select_coupan->coupan_name,

                                            'coupancode'  => $select_coupan->coupan_code,

                                            'discount'  => $select_coupan->discount,

                                            'coupanvalue'  => $select_coupan->coupanvalue,

                                            'coupan_apply_wallet'  => $select_coupan->coupan_apply_wallet,

                                            'coupan_service'  => $select_coupan->service_id,

                                            'coupan_subservice'  => $select_coupan->subservice_id,

                                            'minimum_order'  => $select_coupan->minimum_order,

                                            'is_discounted'  => $select_coupan->is_discounted,

                                            'sub_total'  => $minimum,

                                            'amount'  => $coupon_discounted,

                                            'service' => $service_id,

                                            'sub_service' => $subservice_id,

                                        );

                                        session(['coupan_data' => $coupan_data]);

                                        echo 'success';
                                    } else {
                                        echo 'grater';
                                    }
                                } else {
                                    echo $select_coupan->minimum_order;
                                }
                            } else {
                                echo 'invalid';
                            }
                        } else {
                            echo "invalid";
                        }
                    } else {
                        echo "invalid_user_count";
                    }
                } else {
                    echo "Already Used";
                }
            } else {
                echo "Already";
            }
        } else {
            echo 'invalid';
        }

        //echo "<pre>";print_r($request->all());echo"</pre>";exit;

    }
}
