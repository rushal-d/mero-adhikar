<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\ContactCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactCategoryController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->search;
        $contactcategories = ContactCategory::search($searchTerm)->orderBy('created_at', 'desc')
        ->paginate(50);
        return view('backend.contactcategory.index')->with('contactcategories', $contactcategories);
    }

    public function create()
    {
        $categories = ContactCategory::all();
        return view('backend.contactcategory.create', compact('categories'));
        // return view('contactcategory.create');
    }

    public function store(Request $request)
    {

        $contactCategory = new ContactCategory();
        $contactCategory->title_en = $request->title_en;
        $contactCategory->title_np = $request->title_np;
        $contactCategory->parent_id = $request->parent_id;
        if (!empty($request->term_id)) {
            $contactCategory->term_id = $request->term_id;
        } else {
            $parent_category = ContactCategory::find($request->parent_id);
            if (!empty($parent_category)) {
                $contactCategory->term_id = $parent_category->term_id;
            }
        }

        $contactCategory->save();
        return redirect()->route('backend.contactcategory.create');
    }

    public function show($id)
    {
        $category = ContactCategory::find($id);

        return view('backend.contactcategory.show')->with('category', $category);
    }

    public function edit($id)
    {
        $categories = ContactCategory::pluck('title_en', 'id');

        $category = ContactCategory::find($id);

        return view('backend.contactcategory.edit', ['categories' => $categories, 'category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title_en' => 'required',
            'title_np' => 'required',
            'parent_id' => 'required',
            'term_id' => 'required'
        ]);

        //Insert
        $category = ContactCategory::find($id);
        $category->title_en = $request->input('title_en');
        $category->title_np = $request->input('title_np');
        $category->parent_id = $request->input('parent_id');
        $category->term_id = $request->input('term_id');

        $category->save();

        return redirect('/contactcategory');
    }

    public function destroy($id)
    {
        $contactcategory = ContactCategory::find($id);

        $contactcategory->delete();

        return redirect('/contactcategory');
    }
}
