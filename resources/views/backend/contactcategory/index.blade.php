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
                                        <a href="{{route('backend.contactcategory.create')}}" class="btn btn-success">
                                                Add New <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                        
                                    <h3 class="d-md-none text-center btn custom-filter-button">Toggle Filter <i class="custom-filter-caret fas fa-caret-down"></i></h3>
                                    <div class="filter custom-filter-bar do-not-display-filter-bar-for-small-device col-md-12">
                                        {!! Form::open(['route' => 'backend.contactcategory.index', 'method' => 'GET', 'id' => 'department-form']) !!}
                                        <div class="row">
                                            <div class="col-lg-3 form-group">
                                                <label>Name</label>
                                                {!! Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search']) !!}
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
                                        <th scope="col">S.No.</th>
                                        <th scope="col">Title (EN)</th>
                                        <th scope="col">Title (NP)</th>
                                        <th scope="col">Parent</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($contactcategories as $contactcategory)

                                        <tr>
                                            <th scope="row">{{ ($contactcategories->currentpage()-1) * $contactcategories->perpage() + $loop->index + 1 }}</th>
                                            <td>{{$contactcategory->title_en}}</td>
                                            <td>{{$contactcategory->title_np }}</td>
                                            <td>{{ $contactcategory->parentcontactcategory->title_en ?? '' }}</td>
                                            <td>
                                                <a href="{{route('backend.contactcategory.show', $contactcategory->id)}}"
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="far fa-eye" data-toggle="tooltip" data-placement="top"
                                                       title="View"></i>
                                                </a>
                                                <a href="{{route('backend.contactcategory.edit', $contactcategory->id)}}"
                                                   class="btn btn-sm btn-primary">
                                                    <i class="far fa-edit" data-toggle="tooltip" data-placement="top"
                                                       title="Edit"></i>
                                                </a>
                                                <a href="{{route('backend.contactcategory.destroy', $contactcategory->id)}}"
                                                   data-name="{{$contactcategory->name}}"
                                                   class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash" data-toggle="tooltip"
                                                       data-placement="top" title="Delete"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">Currently there is no data
                                            </td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>
                                <div class="text-center">{{$contactcategories->links()}}</div>
                            </div>  
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
                $('#reset').click(function () {
                    $('input').val('');
                    $('#department-form').submit();
                });
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