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
                                <h3 class="card-label">Nuevo cupón
                            </div>
                        </div>
                        <div class="card-body">
                            
                        <div class="container-fluid">
                            <div class="row" >

                                <div class="col-lg-12 mt-2 mb-2">
                                    <h3 class="text-center">Productos</h3>
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="allProducts">
                                        <label class="form-check-label" for="exampleCheck1">Todos los productos</label>
                                    </div>
                                </div>

                                <div class="col-lg-6" v-if="allProducts == false">
                                    <div class="form-group">
                                        <label for="">Productos disponibles</label>
                                        <input type="text" class="form-control" v-model="productSearch" @keyUp="searchProduct()">

                                        <div class="productBox" v-if="products.length > 0">
                                            <div :class="selectedProducts.includes(product.id) ? 'active-card mb-1' : 'card mb-1'" v-for="product in products" style="cursor:pointer;" @click="addToSelectedProducts(product.id, product)">
                                
                                                <div class="card-body">
                                                    <div class="text-dark text-hover-primary mb-1 font-size-lg">@{{ product.product.name }} - @{{ product.type.name }} - @{{ product.size.name }}Oz - @{{ currencyFormatDE(product.price) }} COP</div>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6" v-if="allProducts == false">

                                    <div class="form-group">
                                        <label for="">Productos seleccionados</label>
                                        

                                        <div class="productBox" v-if="selectedProductsDetail.length > 0">
                                            <div class="d-flex" v-for="product in selectedProductsDetail">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="text-dark text-hover-primary mb-1 font-size-lg">@{{ product.product.name }} - @{{ product.type.name }} - @{{ product.size.name }}Oz - @{{ currencyFormatDE(product.price) }} COP</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            

                            <div class="row">

                                <div class="col-lg-12 mt-2 mb-2">
                                    
                                    <h3 class="text-center">Usuarios</h3>
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="allUsers">
                                        <label class="form-check-label" for="exampleCheck1">Todos los usuarios</label>
                                    </div>
                                </div>

                                <div class="col-lg-6" v-if="allUsers == false">
                                    <div class="form-group">
                                        <label for="">Usuarios disponibles</label>
                                        <input type="text" class="form-control" v-model="userSearch" @keyUp="searchUser()">

                                        <div class="productBox" v-if="users.length > 0">
                                            <div :class="selectedUsers.includes(user.id) ? 'active-card mb-1' : 'card mb-1'" v-for="user in users" style="cursor:pointer;" @click="addToSelectedUsers(user.id, user)">
                                
                                                <div class="card-body">
                                                    <div class="text-dark text-hover-primary mb-1 font-size-lg">@{{ user.name }} - @{{ user.email }}</div>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6" v-if="allUsers == false">

                                    <div class="form-group">
                                        <label for="">Usuarios seleccionados</label>

                                        <div class="productBox" v-if="selectedUsersDetail.length > 0">
                                            <div class="d-flex" v-for="user in selectedUsersDetail">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="text-dark text-hover-primary mb-1 font-size-lg">@{{ user.name }} - @{{ user.email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-12 mt-2 mb-2">
                                        <h3 class="text-center">Tipo de descuento</h3>
                                    </div>
                                    <div class="col-12">

                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline" style="margin-right: 100px;">
                                                <input class="form-check-input" v-model="discountType" type="radio" id="inlineCheckbox1" value="porcentual">
                                                <label class="form-check-label" for="inlineCheckbox1">Porcentual</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" v-model="discountType" type="radio" id="inlineCheckbox2" value="neto">
                                                <label class="form-check-label" for="inlineCheckbox2">Neto</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-12 mt-2 mb-2">
                                        <h3 class="text-center">Descuento total o por producto</h3>
                                    </div>
                                    <div class="col-12">

                                        <div class="d-flex justify-content-center">
                                            <div class="form-check form-check-inline" style="margin-right: 100px;">
                                                <input class="form-check-input" v-model="isDiscountTotal" type="radio" id="inlineCheckboxtotal" value="carrito">
                                                <label class="form-check-label" for="inlineCheckboxtotal">Total del carrito</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" v-model="isDiscountTotal" type="radio" id="inlineCheckboxproducto" value="producto">
                                                <label class="form-check-label" for="inlineCheckboxproducto">Solo a productos seleccionados</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-lg-6">
                                    <div class="col-12 mt-2 mb-2">
                                        <h3 class="text-center">Monto a descontar</h3>
                                    </div>
                                    <div class="col-12">

                                        <div class="form-group">
                                            <label for="">Monto</label>
                                            <div class="d-flex">
                                                <input type="number" :min="1" class="form-control" v-model="discountAmount" @keypress="isNumber($event)">
                                                <span v-if="discountType == 'porcentual'">%</span>
                                                <span v-if="discountType == 'neto'">$</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="col-12 mt-2 mb-2">
                                        <h3 class="text-center">Fecha limite</h3>
                                    </div>
                                    <div class="col-12">

                                        <div class="form-group">
                                            <label for="">fecha</label>
                                            <div class="d-flex">
                                                <input type="date" class="form-control" v-model="endDate">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Cupón</label>
                                        <div class="d-flex">
                                            <input type="text" class="form-control" v-model="couponCode">
                                            <button @click="generateRandomCode()" class="btn btn-primary w-50" >Generar código</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-12">
                                    <p class="text-center">
                                        <button class="btn btn-success" @click="store()">Crear cupón</button>
                                    </p>
                                </div>
                            </div>

                        </div>
                            
                        </div>
                    </div>

                </div>

            </div>


        </div>

    </div>

@endsection

@push("styles")

    <style>
    
        .productBox{

            margin-top: 10px;
            height: 200px;
            overflow-y: auto;

        }

        .active-card{

            background-color: #bdc3c7;

        }
    </style>

@endpush

@push("scripts")

    <script>
        
        const app = new Vue({
            el: '#dev-coupon',
            data(){
                return{
                    productSearch:"",
                    selectedProducts:[],
                    selectedProductsDetail:[],
                    products:[],
                    
                    userSearch:"",
                    users:[],
                    selectedUsers:[],
                    selectedUsersDetail:[],

                    isDiscountTotal:"carrito",
                    discountType:"porcentual",
                    discountAmount:"",
                    endDate:"",

                    allUsers:false,
                    allProducts:false,

                    couponCode:"",
                    
                    showMenu:false,
                    loading:false
                }
            },
            methods:{   

                generateRandomCode(){
                    var result           = '';
                    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    var charactersLength = characters.length;
                    for ( var i = 0; i < 10; i++ ) {
                        result += characters.charAt(Math.floor(Math.random() * 
                    charactersLength));
                    }
                    this.couponCode = result;
                },
                currencyFormatDE(num) {
                    return (
                        num
                        .toFixed(2) // always two decimal digits
                        .replace('.', ',') // replace decimal point character with ,
                        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
                    ) // use . as a 
                },
                searchProduct(){

                    axios.post("{{ url('/admin/top-product/search') }}", {search: this.productSearch}).then(res => {

                        this.products = res.data.products

                    })

                },

                searchUser(){

                    axios.post("{{ url('/admin/user/search') }}", {search: this.userSearch}).then(res => {

                        this.users = res.data.users

                    })

                },
                addToSelectedProducts(id, product){

                    if(this.selectedProducts.includes(id)){

                        this.removeSelectedProducts(id)

                    }else{

                        this.selectedProducts.push(id)
                        this.selectedProductsDetail.push(product)                        

                    }

                },
                removeSelectedProducts(id){

                    this.selectedProducts.forEach((item, index) =>{

                        if(item == id){
                            this.selectedProducts.splice(index, 1)
                        }

                    })

                    this.selectedProductsDetail.forEach((item, index) =>{

                        if(item.id == id){
                            this.selectedProductsDetail.splice(index, 1)
                        }

                    })


                },
                addToSelectedUsers(id, user){

                    if(this.selectedUsers.includes(id)){

                        this.removeSelectedUsers(id)

                    }else{

                        this.selectedUsers.push(id)
                        this.selectedUsersDetail.push(user)                        

                    }

                },
                removeSelectedUsers(id){

                    this.selectedUsers.forEach((item, index) =>{

                        if(item == id){
                            this.selectedUsers.splice(index, 1)
                        }

                    })

                    this.selectedUsersDetail.forEach((item, index) =>{

                        if(item.id == id){
                            this.selectedUsersDetail.splice(index, 1)
                        }

                    })


                },

                store(){

                    if(this.validateCouponInfo()){
                        this.loading = true
                        axios.post("{{ url('/admin/coupon/store') }}", {discountType: this.discountType, discountAmount: this.discountAmount, totalDiscount: this.isDiscountTotal, endDate: this.endDate, allUsers: this.allUsers, allProducts: this.allProducts, couponCode: this.couponCode, products: this.selectedProductsDetail, users: this.selectedUsersDetail})
                        .then(res => {
                            this.loading = false
                            
                            if(res.data.success == true){

                                swal({
                                    "icon": "success",
                                    "text": res.data.msg 
                                }).then(ans => {

                                    window.location.href="{{ url('/admin/coupon/index') }}"

                                })

                            }else{

                                swal({
                                    "icon": "error",
                                    "text": res.data.msg 
                                })

                            }


                        })
                        .catch(err => {
                            this.loading = false
                            $.each(err.response.data.errors, function(key, value){
                                alertify.error(value[0])
                            });
                        })
                    }

                    

                },

                validateCouponInfo(){

                    if(this.allUsers == false && this.selectedUsersDetail.length == 0){
                        
                        alertify.error("Debes seleccionar usuarios")
                        
                        return false
                    }

                    if(this.allProducts == false && this.selectedProductsDetail.length == 0){
                        
                        alertify.error("Debes seleccionar productos")
                        
                        return false
                    }

                    return true

                },

                fetch(page = 1){

                    this.page = page

                    axios.get("{{ url('/admin/size/fetch/') }}"+"/"+page)
                    .then(res => {

                        this.sizes = res.data.sizes
                        this.pages = Math.ceil(res.data.sizesCount / 20)

                    })
                    .catch(err => {
                        $.each(err.response.data.errors, function(key, value){
                            alert(value)
                        });
                    })

                },
                isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                        evt.preventDefault();;
                    } else {
                        return true;
                    }
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