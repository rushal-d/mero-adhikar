@extends('layouts.app')
@section('styles')

@endsection

@section('content')
<section class="padding-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header level">
                            <h3 class="flex">{{$title ?? config('app.name')}}</h3>
                        </div>
                        <div class="card-body">
                            <!-- filter -->
                            <div class="filter">
                                <div class="row form-group">
                                    <div class="col-lg-12">
                                        <div class="add-new mb-3">
                                        <a href="{{route('backend.contact.create')}}" class="btn btn-success">
                                                Add New <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                        
                                    <h3 class="d-md-none text-center btn custom-filter-button">Toggle Filter <i class="custom-filter-caret fas fa-caret-down"></i></h3>
                                    <div class="filter custom-filter-bar do-not-display-filter-bar-for-small-device col-md-12">
                                        {!! Form::open(['route' => 'backend.contact.index', 'method' => 'GET', 'id' => 'department-form']) !!}
                                        <div class="row">
                                            <div class="col-lg-2 form-group">
                                                <label>Distrcit</label>
                                                <div class="form-group">
                                                    {!! Form::select('district_id',$districts, $_GET["district_id"] ?? null, ['class' => 'form-control select','placeholder' => 'Select District']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-2 form-group">
                                                <label>Local Authority (EN)</label>
                                                <div class="form-group">
                                                    {!! Form::select('mun_vdc_en', $local_authorities, $_GET["mun_vdc_en"] ?? null, ['class' => 'form-control select', 'placeholder' => 'Local Authority']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-2 form-group">
                                                <label>Org Name (EN)</label>
                                                <div class="form-group">
                                                    {!! Form::text('org_name_en', $_GET["org_name_en"] ?? null, ['class' => 'form-control', 'placeholder' => 'Org Name']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-2 form-group">
                                                <label>Phone (EN)</label>
                                                <div class="form-group">
                                                    {!! Form::text('phone_en', $_GET["phone_en"] ?? null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-2 form-group">
                                                <label>Category</label>
                                            
                                                <select  class="form-control" name="category_ids[]" multiple id="select-gear-disabled">
                                                    <option value="">select one</option>
                                                    @foreach($categories as $category)
                                                        @if(!$category->isLeaf())
                                                            <optgroup label="{{ $category->title_en }}">
                                                                @foreach($category->children as $node)
                                                                    <option value="{{ $node->id }}"
                                                                        @if(isset($_GET['category_ids']))
                                                                            @if(in_array($node->id, $_GET['category_ids']))
                                                                            selected
                                                                            @endif
                                                                        @endif    
                                                                    >{{ $node->title_en }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-2">
                                                <p class="mt-4">
                                                    <button class="btn custom-btn btn-primary" type="submit">Search
                                                    </button>
                                                    <button class="btn custom-btn btn-danger" type="reset" id="reset">
                                                        Reset
                                                    </button>
                                                </p>
                                            </div><!--  -->
                                        </div>
                                        {!! Form::close() !!}
                                    </div>

                                </div>
                            </div>
                        <!-- filter ends -->
                        <div class="table-responsive">
                                <table class="table table-bordered department-table">
                                    <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>District Name (EN)</th>
                                                <th>District Name (NP)</th>
                                                <th>Local Authority (EN)</th>
                                                 <th>Local Authority (NP)</th>
                                                <th>Org Name (EN)</th>
                                                <th>Phone (EN)</th>
                                                <th>Categories</th>
                                                <th>Action</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($contacts as $contact)
                                        <tr>
                                            <th scope="row">{{ ($contacts->currentpage()-1) * $contacts->perpage() + $loop->index + 1 }}</th>
                                                <td>{{ $contact->district_name_en }}</td>
                                                <td>{{ $contact->district_name_np }}</td>
                                                <td>{{ $contact->local_authority_en }}</td>
                                                 <td>{{ $contact->local_authority_np }}</td>
                                                <td>{{ $contact->org_name_en }}</td>
                                                <td>{{ $contact->phone_en }}</td>
                                                <td>@foreach ($contact->categories as $category) {{ $category->title_en }} {{ !$loop->last ? ', ' : '' }} @endforeach</td>
                                            <td><a href="{{route('backend.contact.edit', $contact->id)}}"
                                                class="btn btn-sm btn-primary">
                                                <i class="far fa-edit" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"></i>
                                            </a>
                                            <a href="{{route('backend.contact.destroy', $contact->id)}}"
                                                data-name="{{$contact->name}}"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">Currently there is no data.
                                            </td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>
                                <div class="text-center">{{$contacts->appends($_GET)->links()}}</div>
                            </div>  
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
                /*$('#reset').click(function () {
                    $('input').val('');
                    $('#department-form').submit();
                });*/
        </script>
</section>

{{-- <script>
        $('.delete').click(function () {
            const id = $(this).data('uuid');
            const _name = $(this).data('name');

            Swal.fire({
                title: 'Are you sure you want to delete ' + department_name + ' department?',
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'DELETE',
                        url: base_url + '/department/' + uuid,
                        data: {
                            _token: '{{csrf_token()}}',
                            uuid: uuid
                        },
                        success: function (data) {
                            Swal.fire(
                                'Deleted!',
                                department_name + ' Department has been deleted.',
                                'success'
                            );
                        }

                    });
                    $(this).parent().parent().remove();
                }
            });
        });
    </script> --}}

@endsection