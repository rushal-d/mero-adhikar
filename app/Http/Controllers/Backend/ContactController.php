<?php

namespace App\Http\Controllers\Backend;

use App\Imports\ContactImport;
use App\Models\Backend\Contact;
use App\Models\Backend\District;
use App\Models\Backend\ContactCategory;
use App\Models\Backend\ContactCategoryPivot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        // $contacts = Contact::orderBy('district_id', 'asc')
        // ->paginate(15);
        $categories = ContactCategory::all()->toHierarchy();
        $contacts = Contact::select();
        $districts = District::pluck('district_name','district_id');
        $local_authorities = District::pluck('mun_vdc_en','mun_vdc_en');

        if(!empty($request->district_id))
        {
            $contacts = $contacts->where('district_id', $request->district_id);
        }

        if(!empty($request->phone_en))
        {
            $contacts = $contacts->where('phone_en', $request->phone_en);
        }       

        if(!empty($request->org_name_en))
        {
            $contacts = $contacts->where('org_name_en', $request->org_name_en);
        }

        if(!empty($request->mun_vdc_en))
        {
          
            $contacts = $contacts->where('local_authority_en','like','%'. $request->mun_vdc_en. '%');
        }

        if ($request->has('category_ids') && !empty($request->category_ids)) {
            $ids = $request->category_ids;
            $ids = array_filter($ids);
            if(count($ids)>0)
            {
                    $contacts->whereHas('categories', function ($query) use ($ids) {
                    $query->whereIn('category_id', $ids);
            });
            }

           
        }
        $contacts = $contacts->latest()
        ->paginate(20);
        return view('backend.contact.index', compact('districts', 'contacts', 'categories', 'local_authorities'));
    }

    public function create()
    {

        // $contact = ContactCategoryPivot::pluck('category_id', 'id');
        $data['districts'] = District::pluck('district_name','district_id');

        $data['local_authorities'] = District::pluck('mun_vdc_en','id');

        $data['categories'] = ContactCategory::all()->toHierarchy();
        return view('backend.contact.create', $data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'org_name_en' => 'required',
            'district_id' => 'required',
            'phone_en' => 'required'
        ]);
        

        //Insert
        $contact = new Contact;
        $district=District::where('district_id',$request->district_id)->first();
            $contact->district_name_en = $district->district_name;
            $contact->district_name_np = $district->district_name_np;
            $contact->district_id = $district->district_id;
        
            $local_authority = District::find($request->localauth_id);
            if(!empty($local_authority))
            {
                $contact->local_authority_en = $local_authority->mun_vdc_en;
                $contact->local_authority_np = $local_authority->mun_vdc;
            }
        
        $contact->org_name_en = $request->input('org_name_en');
        $contact->org_name_np = $request->input('org_name_np');
        $contact->phone_en = $request->input('phone_en');
        $contact->save();
        // $contact->org_name_en = $request->input('category_ids[]');
        foreach($request->category_ids as $category_id)
         {
             $contactcategorypivot = new ContactCategoryPivot();
                $contactcategorypivot->contact_id = $contact->id;
                $contactcategorypivot->category_id = $category_id;
                $contactcategorypivot->save();
         }   

          
        return redirect()->route('backend.contact.create');


        // Excel::import(new ContactImport($request), $request->file('file'));
        // return redirect()->route('backend.contact.index');
        //dd($request->file('file'));
        //return view('backend.contact.index');
    }

    public function show($id)
    {
        //
    }





    public function destroy($id){
        ContactCategoryPivot::where('contact_id', $id)->delete();
        Contact::find($id)->delete();
        return redirect()->back();
    }

    public function edit($id){

        $data['contacts'] = Contact::find($id);
        $data['local_authorities'] = District::pluck('mun_vdc_en','id');

        $data['select_local_authority'] = District::where('mun_vdc_en', $data['contacts']->local_authority_en)->first();

        $data['districts'] = District::pluck('district_name','district_id');

        $data['categories'] = ContactCategory::all()->toHierarchy();

        
        return view('backend.contact.edit', $data);
    }

    public function update(Request $request, $id){

        $this->validate($request, [
            'org_name_en' => 'required',
            'district_id' => 'required',
            'phone_en' => 'required'
        ]);

        $contact = Contact::find($id);
   
        $district=District::where('district_id',$request->district_id)->first();
            $contact->district_name_en = $district->district_name;
            $contact->district_name_np = $district->district_name_np;
            $contact->district_id = $district->district_id;
        
      
            $local_authority = District::find($request->localauth_id);
      
            if(!empty($local_authority))
            {
               
                $contact->local_authority_en = $local_authority->mun_vdc_en;
                $contact->local_authority_np = $local_authority->mun_vdc;
               
            }

        $contact->org_name_en = $request->input('org_name_en');
        $contact->org_name_np = $request->input('org_name_np');
        $contact->phone_en = $request->input('phone_en');
        $contact->save();
        // $contact->org_name_en = $request->input('category_ids[]');
        ContactCategoryPivot::where('contact_id', $id)->delete();
        foreach($request->category_ids as $category_id)
         {
             $contactcategorypivot = new ContactCategoryPivot();
                $contactcategorypivot->contact_id = $contact->id;

                $contactcategorypivot->category_id = $category_id;
                $contactcategorypivot->save();
         }   

          
        return redirect()->route('backend.contact.index');
    }

    /**** API METHODS FROM HERE ON
     * @return \Illuminate\Http\JsonResponse
     */
    public function allContacts()
    {
        /* $all_categories = ContactCategory::get();
         $categories = ContactCategory::where('term_id', null)->get();
         foreach ($categories as $category) {
             $category->term_id = $all_categories->where('id', $category->parent_id)->first()->term_id;
             $category->save();
         }*/
        $all_contacts = ContactCategory::with(['contacts'])->where('parent_id','<>',null)->get();
        return response()->json(['org' => $all_contacts]);

    }

    /** Get All Contact Categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactCategories(){
        $contact_categories = ContactCategory::where('parent_id', '<>', null)->get();
        return response()->json(['org' => $contact_categories]);
    }

    /** Get Contacts by contact category id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContactsByCategory(Request $request)
    {
        $all_contacts = Contact::whereHas('categories', function($query) use ($request){
            $query->where('category_id', $request->id);
        })->get();
        $contacts = ContactCategory::find($request->id);
        $contacts->contacts = $all_contacts;
        return response()->json(['org' => $contacts]);

    }
}
