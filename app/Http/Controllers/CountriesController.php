<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use DataTables;

class CountriesController extends Controller
{
    
    public function index(){
        return view('countries.list');
    }

    // Save Data
    public function addCountry(Request $request){
        $validator = \Validator::make($request->all(),[
            'country_name'  => 'required|unique:countries',
            'capital_city'  => 'required',
        ]);

        if (!$validator->passes()) {
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $country = new Country();
            $country->country_name  = $request->country_name;
            $country->capital_city  = $request->capital_city;

            $query = $country->save();

            if (!$query) {
                return response()->json(['code'=>0,'msg'=>'cannot save data!']);
            }else{
                return response()->json(['code'=>1,'msg'=>'Saving data complete!']);
            }
        }
    }

    // Get Data
    public function getCountriesList(){
        $countries = Country::all();

        return DataTables::of($countries)
                            ->addIndexColumn()
                            ->addColumn('action',function($row){
                                return '<div class="btn-group">
                                            <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editCountryBtn">Update</button>
                                            <button class="btn btn-sm btn-warning" data-id="'.$row['id'].'" id="deleteCountryBtn">Delete</button>
                                        </div>';
                            })
                            ->make(true);
    }

    // Get Country Details
    public function getCountryDetails(Request $request){
        $country_id     = $request->country_id;
        $CountryDetails = Country::find($country_id);

        return response()->json(['details' => $CountryDetails]);    
    }

    //Update Country
    public function updateCountry(Request $request){
        $country_id = $request->cid;

        $validator  = \Validator::make($request->all(),[
            'country_name'  => 'required|unique:countries,country_name,'.$country_id, //??????????????????????????????????????????
            'capital_city'  => 'required'
        ]);

        if (!$validator->passes()) {
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            
            $country = Country::find($country_id);
            $country->country_name  = $request->country_name;
            $country->capital_city  = $request->capital_city;

            $query  = $country->save();

            if (!$query) {
                return response()->json(['code'=>0,'msg'=>'Cannot Update Country']);
            }
            else{
                return response()->json(['code'=>1,'msg'=>'Update Success']);
            }
        }
        return response()->json(['msg' => 'Success']);
    }

    //Delete Country
    public function deleteCountry(Request $request){

        $country_id = $request->country_id;
        $query = Country::findOrFail($country_id)->delete();

        if ($query) {
            return response()->json(['code'=>1,'msg'=>'Delete success']);
        }else{
            return response()->json(['code'=>0,'msg'=>'Cannot delete']);
        }
    }

}
