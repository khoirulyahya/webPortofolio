@extends('layouts.admin')

@section('title')
    <title>Minargmnt-Apps | Data Transaction of Sale</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <div id="controller">
        <div class="callout callout-info" v-if="editStatus">
            <h5><i class="fas fa-info"></i> Note:</h5>
            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
        </div>
        <div class="card card-primary no-print">
            <div class="col-md-12">
                <form method="post" autocomplete="off"  @submit="submitForm($event)">
                    @csrf
                    <div class="row">
                            <!-- CHOOSE PRODUCT -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <table class="table table-stripped">
                                <tr>
                                    <th>Produk</th>
                                </tr>
                                <tr>
                                    <td class="p-0">
                                        <select name="product_id" id="product_id" class="form-control" required width="100%">
                                            <option>Select a product</option>
                                            <option v-for="product in productSelect" :value="product.id">@{{ product.name+' ('+product.product_code+')' }}</option>
                                        </select>
                                    </td>
                                </tr>
                                </table>
                            </div>
                        </div>

                        <!-- SHOW DETAIL PRODUCT -->
                        <div class="col-md-9" v-if="product.name">
                            <table class="table table-stripped">
                                <tr>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Produk</th>
                                    <th class="text-center">Unit</th>
                                    <th class="text-center">Harga</th>
                                    <th width="10%">Qty</th>
                                    <th class="text-center" width="5%">Action</th>
                                </tr>
                                <tr>
                                    <td class="text-center">@{{ product.product_code }}</td>
                                    <td class="text-center">@{{ product.name }}</td>
                                    <td class="text-center">@{{ product.unit }}</td>
                                    <td class="text-center text-monospace">Rp. @{{ numberWithSpaces(product.price) }}</td>
                                    <td class="text-center d-flex justify-content-end">
                                        <input hidden type="number" name="price" id="price" :value="product.price" min="1" class="form-control">
                                        <input type="number" name="qty" id="qty" value="1" min="1" class="form-control text-monospace" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-cart-arrow-down"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-8">
                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-12">
                            <h4>
                                <i class="fas fa-globe"></i> AdminLTE, Inc.
                                <small class="float-right">Date: 2/10/2014</small>
                            </h4>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>Admin, Inc.</strong>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            To
                            <address>
                                <strong>John Doe</strong>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Invoice 007612</b><br>
                            <br>
                            <b>Order ID:</b> 4F3S8J<br>
                            <b>Payment Due:</b> 2/22/2014<br>
                            <b>Account:</b> 968-34567
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table id="detailTable" class="table table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Price a unit</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center no-print">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detail in details">
                                        <td>@{{ detail.name }}</td>
                                        <td class="text-center text-monospace">@{{ detail.qty }}</td>
                                        <td class="text-center">@{{ detail.unit }}</td>
                                        <td class="text-center text-monospace">Rp. @{{ numberWithSpaces(detail.price) }}</td>
                                        <td class="text-center text-monospace">Rp. @{{ numberWithSpaces(detail.total) }}</td>
                                        <td class="text-center no-print">
                                            <button class="btn btn-danger btn-sm" @click="deleteData($event,detail.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row justify-content-around">
                        <!-- accepted payments column -->
                        <div class="col-5">
                            <p class="lead">Payment Methods:</p>
                            <img src="{{ asset('assets/dist/img/credit/visa.png') }}" alt="Visa">
                            <img src="{{ asset('assets/dist/img/credit/mastercard.png') }}" alt="Mastercard">
                            <img src="{{ asset('assets/dist/img/credit/american-express.png') }}" alt="American Express">
                            <img src="{{ asset('assets/dist/img/credit/paypal2.png') }}" alt="Paypal">

                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                This features will be add more method payment for our customers and will be released soon.
                        </div>
                        <!-- /.col -->
                        <div class="col-5">
                            <p class="lead">Amount Due 2/22/2014</p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%" class="text-right">Subtotal (Rp)</th>
                                        <td class="font-weight-bold text-monospace">
                                            @{{ numberWithSpaces(total) }}
                                            <input hidden type="number" name="subtotal" id="subtotal" :value="total" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right align-middle">Cash In (Rp)</th>
                                        <td>
                                            <input type="number" name="cashin" id="cashin" class="form-control text-monospace">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-right align-middle">Cash Out (Rp)</th>
                                        <td>
                                            <input type="text" name="cashout" id="cashout" class="form-control font-weight-bold text-monospace" readonly>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <button @click="print()" type="button" class="btn btn-primary float-right"><i class="fas fa-print"></i> Submit
                                Payment
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/JavaScript">
        let actionUrl = '{{ url('transactionSaleDetails') }}';
        let apiUrl = '{{ url('api/transactionsaleDetails   ') }}';

    </script>
    <script type="text/javascript">
        $(function(){
            $('#jml_uang').on("change",function(){
                let total=$('#total').val();
                let jumuang=$('#jml_uang').val();
                let hsl=jumuang.replace(/[^\d]/g,"");
                $('#jml_uang2').val(hsl);
                $('#kembalian').val(hsl-total);
            })

        });
    </script>
    {{--  memanggil file dengan isi variabel dengan method crud  --}}
    <script>
        var controller = new Vue({
            el: '#controller',
            data: {
                productSelect: [],
                details: [],
                sum: 0,
                sam: 0,
                subtotal: 0,
                cashin: 0,
                cashin_convert: {},
                cashout: 0,
                cashout_convert: {},
                actionUrl,
                apiUrl,
                editStatus: true,
                editSelect: true,
                product: {
                    id: '',
                    qty: '',
                    price: '',
                    name: '',
                    photo: ''
                }
            },
            mounted: function () {
                this.selectProduct();
                this.get_productSelect();
            },
            methods: {
                getcash() {
                    $('#cashin').on("input",function(){
                        this.cashin = $('#cashin').val();
                        this.subtotal = $('#subtotal').val();
                        this.cashin_convert = this.cashin.replace(/[^\d]/g,"");
                        this.cashout = this.cashin_convert-this.subtotal;
                        this.cashout_convert = this.cashout.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        console.log(this.cashout_convert);
                        $('#cashout').val(this.cashout_convert);
                    });
                },
                selectProduct() {
                    $('#product_id').select2({
                        theme: 'bootstrap4'
                    }).on('change', () => {
                        //apabila terjadi perubahan nilai yg dipilih maka nilai tersebut
                        //akan disimpan di dalam var product > id
                        this.product.id = $('#product_id').val();
                        this.editStatus = false;
                        if (this.product.id) {
                        //maka akan menjalankan methods getProduct
                        this.getProduct()
                        }
                    });
                },
                numberWithSpaces(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                },
                submitForm(event) {
                    event.preventDefault();
                    const _this = this;
                    var actionUrl = this.actionUrl;
                    axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                        this.editStatus = false;
                        this.product.id = $('#product_id option:first').prop('selected',true).trigger('change');
                        this.get_details();
                    }).catch((err) => {
                        confirm("ID Member not exist!");
                    });
                    //$('#detailTable').append('<tr><td>1</td><td>'+this.details.pop().product.name+'</td><td></td><td></td><td></td></tr>')
                },
                deleteData($event, id) {
                    axios.post(this.actionUrl + '/' + id, { _method: 'DELETE' }).then(response => {
                        this.cashin = $('#cashin').val('');
                        $('#cashout').val('');
                        this.get_details();
                    });
                },
                getProduct() {
                    //fetch ke server menggunakan axios dengan mengirimkan parameter id
                    //dengan url /api/product/{id}
                    axios.get(`/product/${this.product.id}`)
                    .then((response) => {
                        //assign data yang diterima dari server ke var product
                        this.product = response.data;
                    })
                },
                get_productSelect() {
                    const _this = this;
                    $.ajax({
                        url: '/selectProduct',
                        method: 'GET',
                        success: function(data) {
                            _this.productSelect = JSON.parse(data);

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                },
                get_details() {
                    const _this = this;
                    $.ajax({
                        url: '/detailsProduct',
                        method: 'GET',
                        success: function(data) {
                            _this.details = JSON.parse(data);

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                    this.getcash();
                },
                print() {
                    window.addEventListener('load', window.print());
                }
            },
            computed: {
                total() {
                    this.sum = this.details.reduce((a,curr) => a + curr.total, 0);
                        return this.sum;
                }
            }
        });
    </script>
    {{--  script vue select product  --}}
    {{--  <script>
        var dw = new Vue({
            el: '#dw',
            data: {
                product: {
                    id: '',
                    qty: '',
                    price: '',
                    name: '',
                    photo: ''
                }
            },
            watch: {
                //apabila nilai dari product > id berubah maka
                'product.id': function() {
                    //mengecek jika nilai dari product > id ada
                    if (this.product.id) {
                        //maka akan menjalankan methods getProduct
                        this.getProduct()
                    }
                }
            },
            //menggunakan library select2 ketika file ini di-load
            mounted() {
                $('#product_id').select2({
                    theme: 'bootstrap4',
                    width: '100%'
                }).on('change', () => {
                    //apabila terjadi perubahan nilai yg dipilih maka nilai tersebut
                    //akan disimpan di dalam var product > id
                    this.product.id = $('#product_id').val();
                    console.log(this.product.id);
                });
            },
            methods: {
                getProduct() {
                    //fetch ke server menggunakan axios dengan mengirimkan parameter id
                    //dengan url /api/product/{id}
                    axios.get(`/product/${this.product.id}`)
                    .then((response) => {
                        //assign data yang diterima dari server ke var product
                        this.product = response.data
                    })
                }
            }
        })

    </script>  --}}
    {{--  script filter by month  --}}
    <script src="{{ asset('js/data.js') }}"></script>
@endsection
