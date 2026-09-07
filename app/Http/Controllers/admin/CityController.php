<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\City;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


use PhpOffice\PhpSpreadsheet\IOFactory;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['city_data'] = City::orderBy('id','DESC')->get();

        return view('admin.list_city',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['country_data'] = DB::table('countries')->select('*')->orderBy('id','DESC')->get();
        $data['state_data'] = DB::table('states')->select('*')->orderBy('id','DESC')->get();

        return view('admin.add_city',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = new City;
        $city->country = $request->country;
        $city->state = $request->state;
        $city->name = $request->name;
        $city->city_code = $request->city_code;

        $city->save();

        return redirect()->route('city.index')->with('success','City Added Successfully.');
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
    public function edit(City $city)
    {

        $data['country_data'] = DB::table('countries')->select('*')->orderBy('id','DESC')->get();       
        $data['state_data'] = DB::table('states')->select('*')->where('country_id', $city->country)->orderBy('id','DESC')->get();

        //echo "<pre>";print_r($city->country);echo "</pre>";exit;
        
        return view('admin.edit_city',compact('city'),$data);
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
        $city = City::find($id);
        $city->country = $request->country;
        $city->state = $request->state;
        $city->name = $request->name;
        $city->city_code = $request->city_code;

        $city->save();

        return redirect()->route('city.index')->with('success','City Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_id = $request->selected;
        // echo $delete_id;exit;
        City::whereIn('id',$delete_id)->delete();
        return redirect()->route('city.index')->with('success','City Deleted Successfully');
    }

    function state_show(){
        $country_id = $_POST['country_id'];
        //echo $cat_id;exit;
        $result = DB::table('states')->select('*')->where('country_id','=',$country_id)->get();

        $result_new = $result->toArray();

        $html = "<select id='state' name='state' class='form-control'>";
        $html .= "<option value=''>Select State</option>";
        if($result != '' && count($result) >0)
        {
            for($i=0;$i<count($result);$i++)
            {
                //echo "<pre>";print_r($result[$i]->id);echo "</pre>";exit;
                $html .= "<option value='".$result[$i]->id ."'>".$result[$i]->state ."</option>";
            }
        }
        $html .="</select>";
        //echo "<pre>";print_r($html);echo "</pre>";exit;
        echo $html;
    }

    function bulk_upload_city(Request $request){

        if($request->input('action') == 'add_bulk'){


            $path = $request->file('csv')->getRealPath();

            // $data = Excel::toArray(new class implements WithHeadingRow {
            //     public function headingRow(): int
            //     {
            //         return 1; // Skip the header row in the file
            //     }
            // }, $path);

           $data = Excel::toArray(new class implements WithHeadingRow {
    public function headingRow(): int
    {
        return 1; // Skip the header row in the file
    }
}, $path)[0];

            if (!empty($data)) {

                foreach ($data[0] as $row) {

                   $countries =  DB::table('countries')
                                ->where('country', 'LIKE', $row['country'])
                                ->first();


                    

                    if($countries != ''){
                        $country_id = $countries->id;
                        $data_update_country['country'] = $row['country'];
                        //DB::table('countries')->where('id', $country_id)->update($data_update);
                    }else{
                        //$country_id = 0;
                        $data_update_country['country'] = $row['country'];
                        $country_id = DB::table('countries')->insertGetId($data_update_country);
                    }

                    $states =  DB::table('states')
                                ->where('country_id', $country_id)
                                ->where('state', 'LIKE', $row['state'])
                                ->first();

                    if($states != ''){
                        $states_id = $states->id;
                        $data_update_states['country_id'] = $country_id;
                        $data_update_states['state'] = $row['state'];
                        DB::table('states')->where('id', $states_id)->update($data_update_states);
                    }else{
                        $data_update_states['country_id'] = $country_id;
                        $data_update_states['state'] = $row['state'];
                        $states_id = DB::table('states')->insertGetId($data_update_states);
                    }

                    $cities =  DB::table('cities')
                                ->where('country', $country_id)
                                ->where('state', $states_id)
                                ->where('name', 'LIKE', $row['cities'])
                                ->first();

                    if($cities != ''){
                        $data_update_cities['country'] = $country_id;
                        $data_update_cities['state'] = $states_id;
                        $data_update_cities['name'] = $row['cities'];
                        DB::table('cities')->where('id', $cities->id)->update($data_update_cities);
                    }else{

                        $data_update_cities['country'] = $country_id;
                        $data_update_cities['state'] = $states_id;
                        $data_update_cities['name'] = $row['cities'];
                        $states_id = DB::table('cities')->insertGetId($data_update_cities);

                    }

                    //echo "<pre>";print_r($cities);echo "</pre>";
                }

            }
            //exit;
            return redirect()->route('city.index')->with('success','Data Insert Successfully');
            //$file = $request->file('csv');

            
        }

        return view('admin.bulk_city_upload');
    }

    function xlsupload(Request $request){
        

        ini_set('memory_limit', '-1');

        ini_set('max_execution_time', 9000);

        if ($request->input('action') == 'add_XLS') {

            // $request->validate([
            //     'csv' => 'required|mimes:xls,xlsx,csv',
            // ]);

            $file = $request->file('country');
            $filePath = $file->getRealPath();
            $fileType = $file->getClientOriginalExtension();

            // Load the file
            if ($fileType == 'csv') {
                $reader = IOFactory::createReader('Csv');
            } else {
                $reader = IOFactory::createReader('Xlsx');
            }

            $spreadsheet = $reader->load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (count($rows) > 1) {
                for ($i = 1; $i < count($rows); $i++) {
                    $row = $rows[$i];

                    $id = addslashes($row[0]);
                    $name = addslashes($row[1]);
                    $state  = addslashes($row[2]);
                    $country   = addslashes($row[5]);
                    $data = [
                        'id' => $id,
                        'name' => $name,
                        'state' => $state,
                        'country' => $country,
                    ];

                    $check = DB::table('cities')->where('id',$id)->first();

                    if(empty($check)){
                        DB::table('cities')->insert($data);
                    }

                    //DB::table('countries')->insert($data);
                    //echo "<pre>";print_r($data);echo"</pre>";exit;

                }

            }

            return redirect()->route('city.index')->with('success', 'Your Data File Uploaded Successfully.!!');

            //echo "dgsdg";exit;

        }

        return view('admin.add_xlscity');
    }
}