@extends('layouts.admin')

@section('title')
<title>Minargmnt-Apps | Data Product</title>
@endsection

@section('header')
    <div class="col-sm-6 text-white">
        <h4>Product</h4>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active text-white">Product</li>
        </ol>
    </div>
@endsection

@section('css')
<!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-auto mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-md-3">
                            <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Product</a>
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
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" width="30px"><b>No</b></th>
                                <th class="text-center align-middle"><b>Product ID</b></th>
                                <th class="text-center align-middle"><b>Name</b></th>
                                <th class="text-center align-middle"><b>Category</b></th>
                                <th class="text-center align-middle"><b>Qty</b></th>
                                <th class="text-center align-middle"><b>Unit</b></th>
                                <th class="text-center align-middle" width="70px"><b>Buy Price</b></th>
                                <th class="text-center align-middle" width="70px"><b>Member Price</b></th>
                                <th class="text-center align-middle" width="70px"><b>Grosir Price</b></th>
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
                <form method="post" :action="actionUrl" autocomplete="off"  @submit="submitForm($event, data.id)">
                    <div class="modal-header">

                        <h4 class="modal-title" v-if="editSelect">Create New Product</h4>
                        <h4 class="modal-title" v-if="editStatus">Update Data Product</h4>
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
                            <label class="mx-auto">Category</label>
                            <select id="" name="category_id" class="form-control" style="width: 100%;">
                                <option>-- Select Category</option>
                                @foreach ($categories as $category)
                                <option :selected="data.category_id == {{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" name="qty" class="form-control" placeholder="Enter qty stock" required="" :value="data.qty">
                        </div>
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" name="unit" class="form-control" placeholder="Enter unit name" required="" :value="data.unit">
                        </div>
                        <div class="form-group">
                            <label>Price of Buy</label>
                            <input type="number" name="buyPrice" class="form-control" placeholder="Enter price transaction" required="" :value="data.buy_price">
                        </div>
                        <div class="form-group">
                            <label>Price for Member</label>
                            <input type="number" name="memberPrice" class="form-control" placeholder="Enter price transaction" required="" :value="data.member_price">
                        </div>
                        <div class="form-group">
                            <label>Price for Grosir</label>
                            <input type="number" name="retailPrice" class="form-control" placeholder="Enter price transaction" required="" :value="data.retail_price">
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
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/JavaScript" >
        let actionUrl = '{{ url('products') }}';
        let apiUrl = '{{ url('api/products') }}';

        let columns = [
                    {data: 'DT_RowIndex', class: 'text-center', orderable: true},
                    {data: 'product_code', orderable: true},
                    {data: 'name', orderable: true},
                    {data: 'category_name', orderable: true},
                    {data: 'qty', orderable: true},
                    {data: 'unit', orderable: true},
                    {data: 'price_buy', orderable: true, class: 'text-right'},
                    {data: 'price_member', orderable: true, class: 'text-right'},
                    {data: 'price_retail', orderable: true, class: 'text-right'},
                    {data: null, render: function (index, row, data, meta) {
                        return `
                        <a href="#" class="btn btn-warning btn-sm" onclick="controller.editData(event, ${meta.row})">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})">
                            <i class="fas fa-trash"></i>
                        </a>`;
                    }, orderable: false, class: 'text-center'},
                ];
    </script>
    {{--  memanggil file dengan isi variabel dengan method crud  --}}
    <script>
        let controller = new Vue({
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
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                    console.log(event);
                    console.log(row);
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
                    let actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
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
    <script>
        $(function(){
            {{--  $('.select2').select2()  --}}

            $('#select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: "--Select a category",
                allowClear: true
            }).val(null); //NOTICE this select2 still bug, so use ajax in select2 for load data from db
        })
    </script>
@endsection
