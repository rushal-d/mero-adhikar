<?php

namespace App\Http\Controllers;

use App\Imports\MunImport;
use App\Models\Backend\District;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DistrictController extends Controller
{
    public function create()
    {

        return view('backend.district-check.form');
    }

    public function result(Request $request)
    {

        $districts = $request->districts;
        $districts = preg_split("/\r\n|\n|\r/", $districts);
        $all_districts = District::distinct('district_name')->pluck('district_name');
        $not_match_district = [];
        foreach ($districts as $district) {
            $term = strtolower(trim($district));
//            dd($all_districts->where('district_name', trim($district))->first());
            if (empty(District::whereRaw('lower(district_name) like (?)', ["{$term}"])->first())) {
                if (isset($not_match_district[$district])) {
                    $not_match_district[$district]++;
                } else {
                    $not_match_district[$district] = 1;
                }

            }
        }
        foreach ($not_match_district as $not_match => $count) {
            echo $not_match . ' ' . $count.'<br>';
        }
        echo '<br><h2>Correct District Names:</h2><hr><table border="1" cellspacing="1" cellpadding="1">';
        foreach ($all_districts as $district){
            echo '<tr><td>' . $district . '</td></tr>';
        }
        echo '</table>';
    }

    public function munResult(Request $request)
    {

        $districts = $request->muns;
        $districts = preg_split("/\r\n|\n|\r/", $districts);
        $all_districts = District::distinct('mun_vdc_en')->pluck('mun_vdc_en');
        $not_match_district = [];
        foreach ($districts as $district) {
            $term = strtolower(trim($district));
            if (empty(District::whereRaw('lower(mun_vdc_en) like (?)', ["%{$term}%"])->first())) {
                if (isset($not_match_district[$district])) {
                    $not_match_district[$district]++;
                } else {
                    $not_match_district[$district] = 1;
                }

            }
        }
        foreach ($not_match_district as $not_match => $count) {
            echo $not_match . ' ' . $count.'<br>';
        }
        echo '<br><h2>Correct MUN Names:</h2><hr><table border="1" cellspacing="1" cellpadding="1">';
        foreach ($all_districts as $district){
            echo '<tr><td>' . $district . '</td></tr>';
        }
        echo '</table>';
    }

    public function matchResult(Request $request)
    {

        $districts = $request->muns;
        $districts = preg_split("/\r\n|\n|\r/", $districts);
        $all_districts = [];
        foreach ($districts as $district) {
            $term = '%'.strtolower(trim($district)).'%';
            $d = District::whereRaw('lower(mun_vdc) like (?)', ["{$term}"])->get();
            if(count($d) == 0){
                $d = District::whereRaw('lower(mun_vdc_en) like (?)', ["{$term}"])->get();
            }
            $all_districts[] = $d;
        }

        echo '<br><h2>MUN Names:</h2><hr><table border="1" cellpadding="10">';
        foreach ($all_districts as $districts){
            foreach ($districts as $district){
                echo '<tr><td>' . $district->mun_vdc. '</td><td>' . $district->district_name. '</td><td>' . trim($district->mun_vdc_en) . '</td></tr>';
            }
        }
        echo '</table>';
    }

    public function munNPToEN(Request $request){
        if($request->has('file')){
            //dd($request->file('file'));
            Excel::import(new MunImport($request), $request->file('file'));
        }
        echo '<form method="POST" enctype="multipart/form-data" action="'.route('munNPToEN').'">
            <input type="hidden" name="_token" value="'.csrf_token().'">
            <input type="file" name="file"><input type="submit"></form>
        ';
    }
}
