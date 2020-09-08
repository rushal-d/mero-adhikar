@extends('layouts.app')
@section('styles')

@endsection

@section('content')

<section class="padding-block">
    <div class="container-fluid">
        {{ Form::open(['route' => ['backend.contactcategory.update', 'id' => $category->id], 'method'=>'PATCH']) }}
            <div class="row">
                    <div class="col-lg-8"><!-- first column -->
                        <div class="card custom-card create-wrapper">
                            <div class="card-header">
                                <h3>Edit Category</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact-form">
                                    <div class="row"><!-- main row open-->
                                        <!-- opening of one field -->
                                        {!! Form::label('title_en', 'Title En: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('title_en', $category->title_en, ['class' => 'form-control', 'data-validation' => 'required']) !!}
                                        </div>
                                        {!! Form::label('title_np', 'Title Np: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('title_np', $category->title_np, ['class' => 'form-control', 'data-validation' => 'required']) !!}
                                        </div>
                                        {!! Form::label('category', 'Category: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::select('parent_id',$categories,  $category->parent_id, ['class' => 'form-control']) !!}
                                        </div>
                                        {!! Form::label('term_id', 'Term ID: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('term_id', $category->term_id, ['class' => 'form-control', 'data-validation' => 'required']) !!}
                                        </div>
                                    </div>
                
                                    <p class="text-right">
                                        <button class="btn custom-btn btn-success" type="submit">Update</button>
                                        <a href="{{route('backend.contactcategory.index')}}" class="btn custom-btn btn-clear" type="submit">Cancel</a>
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