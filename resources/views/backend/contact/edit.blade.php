@extends('layouts.app')
@section('styles')

@endsection

@section('content')

<section class="padding-block">
    <div class="container-fluid">
        {{ Form::open(['route' => ['backend.contact.update', 'id' => $contacts->id], 'method'=>'PATCH']) }}
            <div class="row">
                    <div class="col-lg-8"><!-- first column -->
                        <div class="card custom-card create-wrapper">
                            <div class="card-header">
                                <h3>Edit Contact</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact-form">
                                    <div class="row"><!-- main row open-->
                                        <!-- opening of one field -->
                                        {!! Form::label('district', 'District (EN): <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::select('district_id',$districts, $contacts->district_id, ['class' => 'form-control', 'data-validation' => 'required']) !!}
                                        </div>
                                        {!! Form::label('org_name_en', 'Org Name (EN): <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('org_name_en', $contacts->org_name_en, ['class' => 'form-control']) !!}
                                        </div>
                                        {!! Form::label('org_name_np', 'Org Name (NP): <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('org_name_np', $contacts->org_name_np, ['class' => 'form-control']) !!}
                                        </div>
                                        {!! Form::label('localauth_en', 'Local Auth (EN): <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::select('localauth_id', $local_authorities,  $select_local_authority->id ?? null, ['class' => 'form-control select', 'placeholder' => 'Local Authority']) !!}
                                        </div>
                                        {{-- {!! Form::label('localauth_np', 'Local Auth (NP): <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('localauth_np', $contacts->local_authority_np, ['class' => 'form-control', 'data-validation' => 'required']) !!}
                                        </div> --}}
                                        {!! Form::label('phone_en', 'Phone (EN): <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('phone_en', $contacts->phone_en, ['class' => 'form-control', 'data-validation' => 'required']) !!}
                                        </div>
                                        {!! Form::label('category', 'Category: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            <select name="category_ids[]" id="select-gear-disabled" class="demo-default" multiple required>
                                                    @foreach($categories as $category)
                                                        @if(!$category->isLeaf())
                                                            <optgroup label="{{ $category->title_en }}">
                                                                @foreach($category->children as $node)
                                                                    <option value="{{ $node->id }}" 
                                                                        @if($contacts->categories->where('id', $node->id)->count()>0)
                                                                            selected
                                                                        @endif
                                                                        >{{ $node->title_en }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endif
                                                    @endforeach
                                            </select>
                                            
                                        </div>
                                    </div>
                
                                    <p class="text-right">
                                        <button class="btn custom-btn btn-success" type="submit">Update</button>
                                        <a href="{{route('backend.contact.index')}}" class="btn custom-btn btn-clear" type="submit">Cancel</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                
                    </div>
        {!! Form::close() !!}
    </div>
</section>


{{-- // <script>
// function duplicateName(element){
// var name = $(element).val();

// $.ajax({
//  type: "POST",
//  data: {
//      name_ajax: name,
//      _token: "{{csrf_token()}}"
// },
//  url: '{{route("check-name")}}',
//  success:function(response){
//      if(response.exists == 'true'){
//         $('#name_error').html("Already Exists");
//         // alert('true');
//         // console.log('success');
//      }else{
//         $('#name_error').html("Name available");
//         //  alert('false');
//      }
//  },
//  error:function(error){
    
//  }    
// });
// }
// </script> --}}

@endsection