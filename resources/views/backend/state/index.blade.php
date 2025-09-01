@extends('backend.layouts.master')
@section('title','Admin | State')
@section('main-content')

<div class="dashboard__inner">
    <div class="dashboard__inner__item">
        <div class="dashboard__inner__item__flex">
            <div class="dashboard__inner__item__left bodyItemPadding">

                <div class="row g-4 mt-1">
                    <div class="col-lg-12">
                        <div class="dashboard__card bg__white padding-20 radius-10">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="dashboard__card__header__title">All States List</h5>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStateModal">
                                  <i class="fa fa-plus"></i>  Add New State
                                </button>
                            </div>

                            <div class="dashboard__card__inner border_top_1">
                                <div class="dashboard__inventory__table custom_table">
                                    <table class="table" id="stateTable">
                                        <thead>
                                            <tr>
                                                <th>SL NO</th>
                                                <th>State Name</th>
                                                <th>Country Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- AJAX rows -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Add Country Modal -->
<div class="modal fade" id="addStateModal" tabindex="-1" aria-labelledby="addStateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addStateForm" action="javascript:void(0)">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addStateModalLabel">Add New State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="country_id" class="form-label">Country Name</label>
                        <select name="country_id" id="country_id" class="form-control" >
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>                    </div>
                    <div class="mb-3">
                        <label for="state_name" class="form-label">State Name</label>
                        <input type="text" name="name" class="form-control" id="state_name" placeholder="Enter State name" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Country Modal -->
<div class="modal fade" id="editStateModal" tabindex="-1" aria-labelledby="editStateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editStateForm" action="javascript:void(0)">
                @csrf
                <input type="hidden" id="edit_state_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStateModalLabel">Edit State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div class="mb-3">
                        <label for="edit_country_id" class="form-label">Select Country</label>
                        <select name="country_id" id="edit_country_id" class="form-control" >
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_state_name" class="form-label">State Name</label>
                        <input type="text" name="name" class="form-control" id="edit_state_name" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });


        //Ajax state table 
        function loadStates(){
            $.get("{{ route('backend.state.data') }}", function(states){
                let rows = '';
                states.forEach((state,index)=>{
                    rows += `<tr>
                        <td>${index+1}</td>
                        <td>${state.name}</td>
                        <td>${state.country ? state.country.name : ''}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm edit_btn" data-id="${state.id}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete delete_item" data-id="${state.id}">Delete</a>
                        </td>
                        </tr>`
                });
                $('#stateTable tbody').html(rows);
            });
        }

        loadStates();



        //Add state with ajax
        $('#addStateForm').submit(function(e){
            e.preventDefault();
            let name = $('#state_name').val();
            let country_id = $('#country_id').val();
            $.post("{{ route('backend.state.store') }}", {name:name, country_id:country_id})
            .done(function(res){
                $('#addStateModal').modal('hide');
                $('#addStateForm')[0].reset();
                loadStates(); // table refresh
                Swal.fire({
                    icon: 'success',
                    title: 'Added',
                    text: 'State has been added successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .fail(function(err){
                let msg = err.responseJSON && err.responseJSON.errors ? Object.values(err.responseJSON.errors).join(', ') : 'Something went wrong';
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: msg
                });
            });
        });



        //Show Edit state modal with ajax
        $(document).on('click', '.edit_btn', function(){
            let id = $(this).data('id');
            $.get(`/state/edit/${id}`, function(res){
                $('#edit_state_id').val(res.id);
                $('#edit_country_id').val(res.country_id);
                $('#edit_state_name').val(res.name);
                $('#editStateModal').modal('show');
            });
        });


        //Update state with ajax
        $('#editStateForm').submit(function(e){
            e.preventDefault();
            let id = $('#edit_state_id').val();
            let name = $('#edit_state_name').val();
            let country_id = $('#edit_country_id').val();
            $.post(`/state/update/${id}`, {name:name, country_id:country_id})
            .done(function(res){
                $('#editStateModal').modal('hide');
                loadStates(); // table refresh
                Swal.fire({
                    icon: 'success',
                    title: 'Update',
                    text: 'State has been updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .fail(function(err){
                let msg = err.responseJSON && err.responseJSON.errors ? Object.values(err.responseJSON.errors).join(', ') : 'Something went wrong';
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: msg
                });
            });
        });
        


        //Delete state with ajax
        $(document).on('click', '.delete_item', function(){
            let id = $(this).data('id');

            // SweetAlert confirm
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // AJAX DELETE request
                    $.ajax({
                        url: `/state/delete/${id}`,
                        type: 'DELETE',
                        success: function(res){
                            loadStates(); // table refresh
                            Swal.fire(
                                'Deleted!',
                                'State has been deleted.',
                                'success'
                            );
                        },
                        error: function(err){
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });
                }
            });
        });


    });

</script>
@endsection
