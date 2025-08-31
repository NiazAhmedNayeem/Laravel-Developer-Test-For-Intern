@extends('backend.layouts.master')
@section('title','Admin | Country')
@section('main-content')

<div class="dashboard__inner">
    <div class="dashboard__inner__item">
        <div class="dashboard__inner__item__flex">
            <div class="dashboard__inner__item__left bodyItemPadding">

                <div class="row g-4 mt-1">
                    <div class="col-lg-12">
                        <div class="dashboard__card bg__white padding-20 radius-10">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="dashboard__card__header__title">All Countries List</h5>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCountryModal">
                                    Add New Country
                                </button>
                            </div>

                            <div class="dashboard__card__inner border_top_1">
                                <div class="dashboard__inventory__table custom_table">
                                    <table class="table" id="countryTable">
                                        <thead>
                                            <tr>
                                                <th>SL NO</th>
                                                <th>Country Name</th>
                                                <th>Status</th>
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
<div class="modal fade" id="addCountryModal" tabindex="-1" aria-labelledby="addCountryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addCountryForm" action="javascript:void(0)">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCountryModalLabel">Add New Country</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="country_name" class="form-label">Country Name</label>
                        <input type="text" name="name" class="form-control" id="country_name" placeholder="Enter country name" required>
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


@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        });

        function loadCountries(){
            $.get("{{ route('backend.country.data') }}", function(countries){
                let rows = '';
                countries.forEach((country,index)=>{
                    rows += `<tr>
                        <td>${index+1}</td>
                        <td>${country.name}</td>
                        <td>${country.status}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary btn-sm edit_btn" data-id="${country.id}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-sm delete delete_item" data-id="${country.id}">Delete</a>
                        </td>
                        </tr>`
                });
                $('#countryTable tbody').html(rows);
            });
        }

        loadCountries();

        $('#addCountryForm').submit(function(e){
            e.preventDefault();
            let name = $('#country_name').val();
            $.post("{{ route('backend.country.store') }}", {name:name})
            .done(function(res){
                $('#addCountryModal').modal('hide');
                $('#addCountryForm')[0].reset();
                loadCountries();
                Swal.fire({
                    icon: 'success',
                    title: 'Added',
                    text: 'Country has been added successfully.',
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



    });

</script>
@endsection
