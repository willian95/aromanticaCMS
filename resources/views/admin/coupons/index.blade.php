@extends("layouts.admin")

@section("content")
    
    <div id="dev-coupon">
        <div class="elipse" v-if="loading == true">
            <img class="logo-f" src="{{ asset('assets/img/logoLoader.png') }}" alt="">
        </div>
        <div class="content d-flex flex-column flex-column-fluid mt-3" id="kt_content" v-cloak>
            <div class="d-flex flex-column-fluid">

                <div class="container">
                
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">Cupones
                            </div>
                            <div class="card-toolbar">
                                
                                <!--end::Dropdown-->
                                <div class="dropdown dropdown-inline mr-2">
                                    {{--<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click="toggleMenu()">
                                        <span class="svg-icon svg-icon-md">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
                                                    <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                        Exportar
                                    </button>--}}
                                    <!--begin::Dropdown Menu-->
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" id="menu">
                                        <!--begin::Navigation-->
                                        <ul class="navi flex-column navi-hover py-2">
                                            <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Elige una opción:</li>
                                            
                                            <li class="navi-item">
                                                <a href="{{ url('/admin/size/excel') }}" target="_blank" class="navi-link">
                                                    <span class="navi-icon">
                                                        <i class="la la-file-excel-o"></i>
                                                    </span>
                                                    <span class="navi-text">Excel</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="{{ url('/admin/size/csv') }}" class="navi-link">
                                                    <span class="navi-icon">
                                                        <i class="la la-file-text-o"></i>
                                                    </span>
                                                    <span class="navi-text">CSV</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="{{ url('/admin/size/pdf') }}" target="_blank" class="navi-link">
                                                    <span class="navi-icon">
                                                        <i class="la la-file-pdf-o"></i>
                                                    </span>
                                                    <span class="navi-text">PDF</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!--end::Navigation-->
                                    </div>
                                    <!--end::Dropdown Menu-->
                                </div>
                                <!--begin::Button-->
                                <a href="{{ url('/admin/coupon/create') }}" class="btn btn-primary">
                                    Nuevo cupón
                                </a>
                                <!--end::Button-->
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-bordered table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Monto de descuento</th>
                                        <th>Tipo de descuento</th>
                                        <th>Fecha limite</th>
                                        <th>¿Descuento por producto o por carrito?</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="coupon in coupons">
                                        <td>@{{ coupon.coupon_code }}</td>
                                        <td>@{{ coupon.discount_amount }}</td>
                                        <td>@{{ coupon.discount_type }}</td>
                                        <td>@{{ coupon.end_date }}</td>
                                        <td>@{{ coupon.total_discount }}</td>
                                        <td>
                                        
                                            <button class="btn btn-danger" title="Eliminar" @click="erase(coupon.id)" >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn btn-success" title="Ver usuarios de este cupón" @click="setUsers(coupon)" data-toggle="modal" data-target="#users">
                                                <i class="far fa-user"></i>
                                            </button>
                                            <button class="btn btn-info" title="Ver productos de este cupón" @click="setProducts(coupon)" data-toggle="modal" data-target="#products">
                                                <i class="fas fa-bong"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="kt_datatable_info" role="status" aria-live="polite">Mostrando página @{{ currentPage }} de @{{ totalPages }}</div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_full_numbers" id="kt_datatable_paginate">
                                        <ul class="pagination">
                                            
                                            <li class="paginate_button page-item active" v-for="(page, index) in totalPages">
                                                <a style="cursor: pointer" aria-controls="kt_datatable" tabindex="0" :class="page != currentPage ? linkClass : activeLinkClass":key="index" @click="fetch(page)">@{{ page }}</a>
                                            </li>
                                            
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--end: Datatable-->
                        </div>
                    </div>

                </div>

            </div>


        </div>

    </div>

@endsection

@push("styles")
    
    <style>
        .active-link{
            background-color: #2ecc71 !important;
        }
    </style>

@endpush


@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-coupon',
            data(){
                return{

                    loading:false,
                    coupons:[],
                    currentPage:"",
                    totalPages:"",
                    linkClass:"page-link",
                    activeLinkClass:"page-link active-link",
                    users:[],
                    products:[],
                    allUsers:false,
                    allProducts:false
                }
            },
            methods:{   

                currencyFormatDE(num) {
                    return (
                        num
                        .toFixed(2) // always two decimal digits
                        .replace('.', ',') // replace decimal point character with ,
                        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                    ) // use . as a separator
                },
                
                create(){
                    this.action = "create"
                    this.name = ""
                    this.ml = ""
                    this.sizeId = ""
                },
                setUsers(coupon){
                    

                    if(coupon.all_users == 1){

                        this.allUsers = coupon.all_users

                    }else{
                        this.allUsers = 0
                        this.users = coupon.coupon_users

                    }

                },
                setProducts(coupon){
                    
                    if(coupon.all_products == 1){

                        this.allProducts = coupon.all_products

                    }else{
                        this.allProducts = 0
                        this.products = coupon.coupon_products

                    }

                },
                async fetch(link = ""){

                    this.loading = true
                    let res = await axios.get(link == "" ? "{{ url('admin/coupon/fetch') }}" : "{{ url('admin/coupon/fetch') }}"+"?page="+link)

                    this.loading = false
                    this.coupons = res.data.coupons.data
                    this.currentPage = res.data.coupons.current_page
                    this.totalPages = res.data.coupons.last_page


                },
                erase(id){

                    swal({
                        title: "¿Estás seguro?",
                        text: "Eliminarás este cupón!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.loading = true
                            axios.post("{{ url('/admin/coupon/delete/') }}", {id: id}).then(res => {
                                this.loading = false
                                if(res.data.success == true){
                                    swal({
                                        title: "Genial!",
                                        text: "Cupón eliminado!",
                                        icon: "success"
                                    });
                                    this.fetch()
                                }else{

                                    alert(res.data.msg)

                                }

                            }).catch(err => {
                                this.loading = false
                                $.each(err.response.data.errors, function(key, value){
                                    alert(value)
                                });
                            })

                        }
                    });

                },
                toggleMenu(){

                    if(this.showMenu == false){
                        $("#menu").addClass("show")
                        this.showMenu = true
                    }else{
                        $("#menu").removeClass("show")
                        this.showMenu = false
                    }

                }


            },
            mounted(){
                
                this.fetch()

            }

        })
    
    </script>

@endpush