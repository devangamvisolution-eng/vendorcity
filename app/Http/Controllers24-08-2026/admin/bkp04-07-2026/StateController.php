<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Admin\State;

use App\Models\Admin\Country;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;


class StateController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        $data['all_state'] = State::orderBy('id','DESC')->get();

        return view('admin.list_state',$data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $data['all_country'] = Country::orderBy('id','DESC')->get();

        return view('admin.add_state',$data);

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $state= new State;

        $state->country_id=$request->country_id;

        $state->state=$request->state;

        

        $state->save();

        return redirect()->route('state.index')->with('success', 'State Added Successfully');

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

    public function edit(State $state)

    {

        $data['all_country'] = Country::orderBy('id','DESC')->get();

        return view('admin.edit_state',compact('state'),$data);

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

        $state = State::find($id);

        $state->country_id     = $request->country_id;

        $state->state     = $request->state;

       

        $state->save();



        return redirect()->route('state.index')->with('success', 'State Updated Successfully');

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

        State::whereIn('id',$delete_id)->delete();

        return redirect()->route('state.index')->with('success','State  Deleted Successfully');

    }

    function xlsupload(Request $request){
        

        ini_set('memory_limit', '-1');

        if ($request->input('action') == 'add_XLS') {

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
                    $state = addslashes($row[1]);
                    $country_id = addslashes($row[2]);
                    $data = [
                        'id' => $id,
                        'state' => $state,
                        'country_id' => $country_id,
                    ];

                    $check = DB::table('states')->where('id',$id)->first();

                    if(empty($check)){
                        DB::table('states')->insert($data);
                    }
                    //echo "<pre>";print_r($check);echo"</pre>";exit;
                   // DB::table('states')->insert($data);
                    //echo "<pre>";print_r($data);echo"</pre>";exit;

                }

            }

            return redirect()->route('state.index')->with('success', 'Your Data File Uploaded Successfully.!!');

        }

        return view('admin.add_xlsstate');
    }

}