<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;


class Contact extends Model
{
    use SearchableTrait;
    protected $fillable = [
        'district_id',
        'district_name_en',
        'district_name_np',
        'org_name_en',
        'org_name_np',
        'local_authority_en',
        'local_authority_np',
        'phone_en',
        'phone_np',
    ];

    protected $searchable = [
        'columns' => [
            'local_authority_en' => 9,
            'org_name_en' => 10,
          
        ],
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Backend\ContactCategory', 'contacts_category_pivot', 'contact_id', 'category_id');
    }


}
