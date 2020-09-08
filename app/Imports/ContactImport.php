<?php

namespace App\Imports;

use App\Models\Backend\Contact;
use App\Models\Backend\ContactCategoryPivot;
use App\Models\Backend\District;
use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ContactImport implements ToModel, WithMultipleSheets
{
    protected $request = null;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        return [
            new ContactImport($this->request)
        ];
    }

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {

        $contact_categories = $this->request->category_ids;

        if (!isset($row[0])) {
            return null;
        }

        if (isset($row[0]) && ($row[0] == 'District' || $row[0] == 'END' || empty($row[0]))) {
            return null;
        }
        $district_name_en = trim($row[0]);
        //get district id
        $district = District::where('district_name', 'LIKE', '%' . $district_name_en . '%')->first();

        $district_id = 0;

        $district_name_np = '';
        if (!empty($district)) {
            $district_id = $district->district_id;
            $district_name_en = $district->district_name;
            $district_name_np = $district->district_name_np;
        }


        $contact = Contact::create([
            'district_id' => $district_id,
            'district_name_en' => $district_name_en,
            'district_name_np' => $district_name_np,
            'org_name_en' => trim($row[4]),
            'org_name_np' => trim($row[5]),
            'local_authority_en' => trim($row[2]),
            'local_authority_np' => trim($row[3]),
            'phone_en' => trim(str_replace(' ', '', $row[6])), // removes all void spaces between string
            'phone_np' => $this->convertToNepali(str_replace(' ', '', $row[6])),
        ]);
        $contact_id = $contact->id;
        //save the category id and contact id
        foreach ($contact_categories as $contact_category) {
            $contact_category_pivot = new ContactCategoryPivot();
            $contact_category_pivot->contact_id = $contact_id;
            $contact_category_pivot->category_id = $contact_category;
            $contact_category_pivot->save();
        }
        return $contact;
    }

    //convert eng num to nepali unicode
    public function englishToNepaliNumber($num)
    {
        $n = '';
        switch ($num) {
            case "0":
                $n = "०";
                break;
            case "1":
                $n = "१";
                break;
            case "2":
                $n = "२";
                break;
            case "3":
                $n = "३";
                break;
            case "4":
                $n = "४";
                break;
            case "5":
                $n = "५";
                break;
            case "6":
                $n = "६";
                break;
            case "7":
                $n = "७";
                break;
            case "8":
                $n = "८";
                break;
            case "9":
                $n = "९";
                break;
            default:
                $n = $num;
                break;
        }
        return $n;
    }

    public function convertToNepali($str)
    {
        $converted_str = '';
        foreach (str_split(trim($str)) as $s) {
            $converted_str .= $this->englishToNepaliNumber($s);
        }
        return $converted_str;
    }


}