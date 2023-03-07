@extends('layouts.admin')

@section('title')
<title>Minargmnt-Apps | Data Transaction of Sale</title>
@endsection

@section('header')
    <div class="col-sm-6 text-white">
        <h4>Transaction Sale</h4>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active text-white">Transaction</li>
            <li class="breadcrumb-item active text-white">Transaction Sale</li>
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
                                <a href="#" @click="addData()" class="btn btn-sm btn-primary pull-right">Create New Transaction</a>
                            </div>
                            <div class="col-md-4 row justify-content-end">
                                <div class="input-group-prepend col-m">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <div class="input-group col-md-8">
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
                        <table id="datatable" class="table table-striped table-bordered w-auto">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" width="30px"><b>No</b></th>
                                    <th class="text-center align-middle" width="180px"><b>Date Transaction</b></th>
                                    <th class="text-center align-middle"><b>Invoice ID</b></th>
                                    <th class="text-center align-middle"><b>Officer</b></th>
                                    <th class="text-center align-middle"><b>Member ID</b></th>
                                    <th class="text-center align-middle"><b>Item</b></th>
                                    <th class="text-center align-middle" width="50px"><b>Detail</b></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" :action="actionUrl" autocomplete="off" @submit="submitForm($event)">
                        <div class="modal-header bg-primary">

                            <h4 class="modal-title" v-if="editSelect">Create Sale Transaction</h4>
                            <h4 class="modal-title" v-if="editStatus">Detail Transaction Item</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-if="editSelect">
                                @csrf

                                <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                                <div class="form-group">
                                    <label>Cassier</label>
                                    <input readonly type="text" class="form-control" value="{{ $officer_name->name }}">
                                    <input hidden type="text" name="officer_id" id="officer_id" class="form-control" value="{{ auth()->user()->officer_id }}">
                                </div>
                                <div class="form-group">
                                    <label>Member ID</label>
                                    <input type="text" name="member_id" id="member_id" class="form-control" placeholder="Have a member ID? Enter it..">
                                </div>

                            </div>
                            <div v-if="editStatus">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-5 text-center align-middle description-block border-right">
                                            <label><b>Item</b></label>
                                        </div>
                                        <div class="col-3 text-center align-middle description-block border-right">
                                            <label>Price</label>
                                        </div>
                                        <div class="col-2 text-center align-middle description-block border-right">
                                            <label>Qty</label>
                                        </div>
                                        <div class="col-2 text-center align-middle description-block border-right">
                                            <label>Total</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row" v-for="(data,index) in filteredList">
                                        <div class="col-5 text-left description-block border-right">
                                            <label>@{{ data.product_name }}</label>
                                        </div>
                                        <div class="col-3 text-center align-middle description-block border-right">
                                            <label>Rp. @{{ numberWithSpaces(data.price) }}</label>
                                        </div>
                                        <div class="col-2 text-center align-middle description-block border-right">
                                            <label>@{{ data.qty }} @{{ data.unit }}</</label>
                                        </div>
                                        <div class="col-2 text-right align-middle description-block border-right">
                                            <label>Rp. @{{ numberWithSpaces(data.total) }}</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-8 text-right align-middle">
                                            <label>TOTAL BAYAR</label>
                                        </div>
                                        <div class="col-4 text-right align-middle">
                                            <label>Rp. @{{ numberWithSpaces(data.oki) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" v-if="editSelect">Save changes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    <script type="text/JavaScript">
        var actionUrl = '{{ url('transactionSales') }}';
        var apiUrl = '{{ url('api/transactionSales') }}';

        {{--  Menyimpan dan menata data dari api ke dalam variable column  --}}
        var columns = [
                    {data: 'DT_RowIndex', class: 'text-center', orderable: true},
                    {data: 'dateBy_yajra', class: 'text-center', orderable: true},
                    {data: 'invoice_code',class: 'text-center', orderable: true},
                    {data: 'name_officer', orderable: true},
                    {data: 'member_null', orderable: true},
                    {data: 'total_item',class: 'text-center', orderable: true},
                    {data: null, render: function (index, row, data, meta) {
                        return `
                        <a href="#" class="btn btn-primary btn-sm" onclick="controller.editData(event, ${meta.row})">
                            <i class="fa fa-info-circle"></i>
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
                    //window.location = '{{ url('transactionSales') }}'+'/create';
                },
                editData(event, row) {
                    this.data = this.datas[row].details;
                    this.editStatus = true;
                    this.editSelect = false;
                    $('#modal-default').modal();
                    console.log(this.data);
                    function calculateSum(array, property) {
                        const total = array.reduce((accumulator, object) => {
                            return accumulator + object[property];
                        },0);
                        return total;
                    }

                    const arr = this.data;
                    const result1 = calculateSum(arr, 'total');
                    this.data.oki = result1;
                    console.log(this.data.oki);
                },
                numberWithSpaces(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
                        window.location = '{{ url('transactionSales') }}'+'/create';
                    }).catch((err) => {
                        confirm("ID Member not exist!");
                    });
                }
            },
            computed: {
                filteredList() {
                    return this.data;
                }
            }
        });
    </script>
    {{--  script filter by month  --}}
    <script src="{{ asset('js/data.js') }}"></script>
@endsection
