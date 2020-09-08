@extends('layouts.app')
@section('styles')

@endsection

@section('content')
<section class="padding-block">
    <div class="container-fluid">
        {{ Form::open(['route' => 'backend.contactcategory.store']) }}
            <div class="row">
                    <div class="col-lg-8"><!-- first column -->
                        <div class="card custom-card create-wrapper">
                            <div class="card-header">
                                <h3>Create Category</h3>
                            </div>
                            <div class="card-body">
                                <div class="contact-form">
                                    <div class="row"><!-- main row open-->
                                        <!-- opening of one field -->
                                        {!! Form::label('title', 'Title: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('title_en', null, ['class' => 'form-control', 'data-validation' => 'required', 'placeholder' => 'English Name']) !!}
                                        </div>
                                        {!! Form::label('title_np', 'Title: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('title_np', null, ['class' => 'form-control', 'data-validation' => 'required', 'placeholder' => 'Nepali Name']) !!}
                                        </div>
                                        {!! Form::label('title_np', 'Title: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                        <select name="parent_id" class="form-control">
                                            @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->title_en }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                        {!! Form::label('term_id', 'Term ID: <span class="required-field"> *</span>', ['class' => 'col-xs-2 col-md-2'], false); !!}
                                        <div class="col-xs-10 col-md-10 form-group">
                                            {!! Form::text('term_id', null, ['class' => 'form-control', 'data-validation' => 'required', 'placeholder' => 'Enter Term ID']) !!}
                                        </div>
                                    </div>
                                    <p class="text-right">
                                        <button class="btn custom-btn btn-success" type="submit">Create</button>
                                    <a href="{{route('backend.contactcategory.index')}}" class="btn custom-btn btn-clear" type="submit">Cancel</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        {!! Form::close() !!}
    </div>
</section>

@endsection