@extends('layouts.admin')

@section('title')
<title>Minargmnt-Apps | Data Category</title>
@endsection

@section('header')
    <div class="col-sm-6 text-white">
        <h4>Category</h4>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active text-white">Data Master</li>
            <li class="breadcrumb-item active text-white">Category</li>
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
                    <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Category</a>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table table-striped table-bordered w-auto">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" width="30px"><b>No</b></th>
                                <th class="text-center align-middle" width="160px"><b>Category ID</b></th>
                                <th class="text-center align-middle"><b>Name</b></th>
                                <th class="text-center align-middle" width="150px"><b>Action</b></th>
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

                        <h4 class="modal-title" v-if="editSelect">Create New Category</h4>
                        <h4 class="modal-title" v-if="editStatus">Update Data Category</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="Enter category" name="name" :value="data.name" required="">
                        </div>
                        <div class="row form-group">
                            <div class="col-4">
                                <input hidden type="text" name="category_code" :value="data.category_code" class="form-control">
                            </div>
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
        var actionUrl = '{{ url('categories') }}';
        var apiUrl = '{{ url('api/categories') }}';

        {{--  Menyimpan dan menata data dari api ke dalam variable column  --}}
        var columns = [
            {data: 'DT_RowIndex', class: 'text-center', orderable: true},
            {data: 'category_code', orderable: true},
            {data: 'name', orderable: true},
            {data: null, render: function (index, row, data, meta) {
                return `
                <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
                    <i class="fas fa-edit"></i>Edit
                </a>
                <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
                    <i class="fas fa-trash"></i>Delete
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
                                columns: [0, 1, 2]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [0, 1, 2]
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: [0, 1, 2]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2]
                            }
                        }],
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
@endsection
