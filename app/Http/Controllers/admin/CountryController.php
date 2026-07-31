<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Country;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['country_data']=Country::orderBy('id','desc')->get();
        return view('admin.list_country',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['continent_data'] = DB::table('continents')->select('*')->orderBy('id','DESC')->get();
        return view('admin.add_country',$data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country= new Country;
        $country->country=$request->country;
        $country->continent_id=$request->continent_id;
        $country->country_code=$request->country_code;
        
        $country->save();
        return redirect()->route('country.index')->with('success','Country Added Successfully');
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
    public function edit(Country $country)
    {
        $data['continent_data'] = DB::table('continents')->select('*')->orderBy('id','DESC')->get();
       return view('admin.edit_country',compact('country'),$data);
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
        $country = Country::find($id);
        $country->country     = $request->country;
        $country->continent_id=$request->continent_id;
        $country->country_code=$request->country_code;
       
        $country->save();
        return redirect()->route('country.index')->with('success', 'Country Updated Successfully');
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
      
        Country::whereIn('id',$delete_id)->delete();
        return redirect()->route('country.index')->with('success','Country Deleted Successfully');
    }
    function xlsupload(Request $request){
        
        ini_set('memory_limit', '-1');
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
                    $data = [
                        'id' => $id,
                        'country' => $name,
                    ];
                    DB::table('countries')->insert($data);
                    //echo "<pre>";print_r($data);echo"</pre>";exit;
                }
            }
            return redirect()->route('country.index')->with('success', 'Your Data File Uploaded Successfully.!!');
            //echo "dgsdg";exit;
        }
        return view('admin.add_xlscountry');
    }
}