<?php



namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;



class Subscriptiondetails_controller extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {
        $id = Auth::user()->id;
         $currentDate = now(); // Get the current date and time

        $result = DB::table('subscription')
            ->select('*')
            ->where('vendor_id', '=', $id)
            ->where('is_deleted' , '=' ,'0')
            ->orderBy('id', 'desc')
            ->get();

        // Add the "status" column to the result based on the "enddate" and current date
        $result = $result->map(function ($item) use ($currentDate) {
            $item->status = $item->enddate >= $currentDate ? "active" : "inactive";
            return $item;
        });
        $data['all_data']=$result;

        return view('admin.list_subscription_details',$data);

    }

    public function show($id)

    {
        $data['country_data'] = DB::table('countries')->select('*')->orderBy('id','DESC')->get();
        $data['state_data'] = DB::table('states')->select('*')->orderBy('id','DESC')->get();
        $data['allcity'] = DB::table('cities')->select('*')->get();
        $data['allservices'] = DB::table('services')->select('*')->get();
        $data['allsub_services'] = DB::table('subservices')->select('*')->get();

        $result = DB::table('subscription')
            ->select('*')
            ->where('id', '=', $id)
            ->orderBy('id', 'desc')
            ->first();

        $data['all_data']=$result;
        $data['id'] = $id;
        return view('admin.view_subscription_detail',$data);

        //echo "<pre>";print_r($result);echo "</pre>";exit;

    }

    public function vendor_invoice ($id){

        $result = DB::table('subscription')
            ->select('*')
            ->where('id', '=', $id)
            ->orderBy('id', 'desc')
            ->first();

        $data['all_data']=$result;
        return view('admin.view_subscription_invoice',$data);
    }




}