@extends('layouts.admin')

@section('title')
<title>Minargmnt-Apps | Data Supplier</title>
@endsection

@section('header')
    <div class="col-sm-6 text-white">
        <h4>Supplier</h4>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active text-white">Data Master</li>
            <li class="breadcrumb-item active text-white">Supplier</li>
        </ol>
    </div>
@endsection

@section('css')
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-auto mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-md-3">
                            <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Supplier</a>
                        </div>
                        <div class="col-md-4 row justify-content-end">
                            <div class="input-group-prepend col-m">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <div class="input-group col-md-6">
                                <select class="form-control" name="date_start">
                                    <option value="reset">Filter by Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered w-auto, 3, 4, 5">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" width="30px"><b>No</b></th>
                                <th class="text-center align-middle"><b>Supplier ID</b></th>
                                <th class="text-center align-middle"><b>Name</b></th>
                                <th class="text-center align-middle"><b>Address</b></th>
                                <th class="text-center align-middle"><b>Phone Number</b></th>
                                <th class="text-center align-middle"><b>Email</b></th>
                                <th class="text-center align-middle" width="70px"><b>Action</b></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event, data.id)">
                    <div class="modal-header">

                        <h4 class="modal-title" v-if="editSelect">Create New Supplier</h4>
                        <h4 class="modal-title" v-if="editStatus">Update Data Supplier</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name" :value="data.name" required="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" :value="data.email" required="">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="number" name="phone_number" class="form-control" placeholder="Enter phone number" :value="data.phone_number" required="">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Enter address" :value="data.address" required="">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script type="text/JavaScript" >
        var actionUrl = '{{ url('suppliers') }}';
        var apiUrl = '{{ url('api/suppliers') }}';

        var columns = [
                {data: 'DT_RowIndex', class: 'text-center', orderable: true},
                {data: 'supplier_code', orderable: true},
                {data: 'name', orderable: true},
                {data: 'address', orderable: true},
                {data: 'phone_number', orderable: true},
                {data: 'email', orderable: true},
                {data: null, render: function (index, row, data, meta) {
                    return `
                    <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
                        <i class="fas fa-trash"></i>
                    </a>`;
                }, orderable: false, class: 'text-center'},
            ]
    </script>
    {{--  memanggil file dengan isi variabel dengan method crud  --}}
    <script>
        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [],
                data: {},
                actionUrl,
                apiUrl,
                editStatus: false,
                editSelect: false,
            },
            mounted: function () {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        dom: 'lBfrtip',
                        ordering: true,
                        info: true,
                        autoWidth: false,
                        responsive: true,
                        buttons: [
                        {
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5]
                            }
                        },
                        'colvis'],
                        lengthChange: true,
                        searching: true,
                        lengthMenu: [[ 10, 25, 50, -1], [10, 25, 50, "All"] ],
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET',
                        },
                        columns: columns
                    }).on('xhr', function () {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {};
                    this.editStatus = false;
                    this.editSelect = true;
                    $('#modal-default').modal();
                },
                editData(event, row) {
                    this.data = this.datas[row];
                    this.editStatus = true;
                    this.editSelect = false;
                    $('#modal-default').modal();
                },
                deleteData(event, id) {
                    if (confirm("Are you sure ?")) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.actionUrl + '/' + id, { _method: 'DELETE' }).then(response => {
                            alert('Data has been removed');
                        });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
                    axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        _this.table.ajax.reload();
                    });
                }
            }
        });
    </script>
    {{--  script filter by month  --}}
    <script src="{{ asset('js/data.js') }}"></script>
@endsection
