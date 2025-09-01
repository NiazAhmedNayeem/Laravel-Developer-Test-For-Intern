@extends('backend.layouts.master')
@section('title','Admin | City')
@section('main-content')

<div class="dashboard__inner">
    <div class="dashboard__inner__item">
        <div class="dashboard__inner__item__flex">
            <div class="dashboard__inner__item__left bodyItemPadding">

                <div class="row g-4 mt-1">
                    <div class="col-lg-12">
                        <div class="dashboard__card bg__white padding-20 radius-10">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="dashboard__card__header__title">All Cities List</h5>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCityModal">
                                    <i class="fa fa-plus"></i> Add New City
                                </button>
                            </div>

                            <div class="dashboard__card__inner border_top_1">
                                <div class="dashboard__inventory__table custom_table">
                                    <table class="table" id="cityTable">
                                        <thead>
                                            <tr>
                                                <th>SL NO</th>
                                                <th>City Name</th>
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
<div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addCityForm" action="javascript:void(0)">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCityModalLabel">Add New City</h5>
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
                        </select>                    
                    </div>
                    <div class="mb-3">
                        <label for="state_id" class="form-label">State Name</label>
                        <select name="state_id" id="state_id" class="form-control" >
                            <option value="">-- Select State --</option>
                        </select>                    
                    </div>
                    <div class="mb-3">
                        <label for="city_name" class="form-label">City Name</label>
                        <input type="text" name="name" class="form-control" id="city_name" placeholder="Enter City name">
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
<div class="modal fade" id="editCityModal" tabindex="-1" aria-labelledby="editCityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCityForm" action="javascript:void(0)">
                @csrf
                <input type="hidden" id="edit_city_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCityModalLabel">Edit State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_country_id" class="form-label">Select Country</label>
                        <select name="country_id" id="edit_country_id" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_state_id" class="form-label">Select State</label>
                        <select name="state_id" id="edit_state_id" class="form-control">
                            <option value="">- Select State -</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_city_name" class="form-label">City Name</label>
                        <input type="text" name="name" class="form-control" id="edit_city_name">
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

        //Ajax City table 
        function loadCities(){
            $.get("{{ route('backend.city.data') }}", function(cities){
                let rows = '';
                cities.forEach((city,index)=>{
                    rows += `<tr>
                        <td>${index+1}</td>
                        <td>${city.name}</td>
                        <td>${city.state ? city.state.name : ''}</td>
                        <td>${city.country ? city.country.name : ''}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm edit_btn" data-id="${city.id}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete delete_item" data-id="${city.id}">Delete</a>
                        </td>
                        </tr>`
                });
                $('#cityTable tbody').html(rows);
            });
        }

        loadCities();

        //Add City with ajax
        $('#addCityForm').submit(function(e){
            e.preventDefault();
            let name = $('#city_name').val();
            let state_id = $('#state_id').val();
            let country_id = $('#country_id').val();
            $.post("{{ route('backend.city.store') }}", {name:name, state_id:state_id, country_id:country_id})
            .done(function(res){
                $('#addCityModal').modal('hide');
                $('#addCityForm')[0].reset();
                loadCities(); // table refresh
                Swal.fire({
                    icon: 'success',
                    title: 'Added',
                    text: 'City has been added successfully.',
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

        //Show Edit City modal with ajax
        $(document).on('click', '.edit_btn', function(){
            let id = $(this).data('id');

            $.get(`/city/edit/${id}`, function(res){
                // console.log(res);
                
                $('#edit_city_id').val(res.id);
                $('#edit_city_name').val(res.name);
                $('#edit_country_id').val(res.country_id);

                // first load states under this country
                $.get('/get-states/' + res.country_id, function(states){
                    $('#edit_state_id').empty().append('<option value="">- Select State -</option>');
                    $.each(states, function(key, state){
                        let selected = (state.id == res.state_id) ? 'selected' : '';
                        $('#edit_state_id').append('<option value="'+state.id+'" '+selected+'>'+state.name+'</option>');
                    });
                });

                $('#editCityModal').modal('show');
            });
        });

        //Update city with ajax
        $('#editCityForm').submit(function(e){
            e.preventDefault();
            let id = $('#edit_city_id').val();
            let name = $('#edit_city_name').val();
            let state_id = $('#edit_state_id').val();
            let country_id = $('#edit_country_id').val();
            $.post(`/city/update/${id}`, {name:name, state_id:state_id, country_id:country_id})
            .done(function(res){
                $('#editCityModal').modal('hide');
                loadCities(); // table refresh
                Swal.fire({
                    icon: 'success',
                    title: 'Update',
                    text: 'City has been updated successfully.',
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
        
        //Delete city with ajax
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
                        url: `/city/delete/${id}`,
                        type: 'DELETE',
                        success: function(res){
                            loadCities(); // table refresh
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

        //get states under country (add and edit)
        $(document).on('change', '#country_id, #edit_country_id', function(){
            let country_id = $(this).val();
            let set_states = (this.id === 'country_id') ? '#state_id' : '#edit_state_id';
            if(country_id){
                $.get('/get-states/'+country_id, function(data){
                    $(set_states).empty().append('<option value="">- Select State -</option>');
                    $.each(data, function(key, state){
                        $(set_states).append('<option value="'+state.id+'">'+state.name+'</option>')
                    });
                });
            }else{
                $(set_states).empty().append('<option value="">- Select State -</option>');
            }
        });


    });

</script>
@endsection
