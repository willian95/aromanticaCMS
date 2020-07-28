@extends('layouts.login')

@section('content')
    <div class="login_admin " id="dev-login">

        <div class="row">
            <div class="login100-more mask col-md-6"
                style="background-image: url('https://images.unsplash.com/photo-1557827999-c0bb00bbee13?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=755&q=80');">


                <p>Bienvenido a Aromantica CMS</p>
            </div>
            <div class="login100-form validate-form col-md-6">
                <span class="login100-form-title p-b-43">
                    <img class="logo-admin" src="http://imgfz.com/i/0tkLDsf.png" alt="">
                </span>


                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" v-model="email">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Email</span>
                </div>


                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" v-model="password">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Password</span>
                </div>




                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" @click="login()">
                        Entrar
                    </button>
                </div>

            </div>


        </div>

    </div>
@endsection


@push("scripts")

<script type="text/javascript">
const app = new Vue({
    el: '#dev-login',
    data() {
        return {
            email: "",
            password: ""
        }
    },
    methods: {

        login() {

            axios.post("{{ url('/login') }}", {
                    email: this.email,
                    password: this.password
                })
                .then(res => {

                    if (res.data.success == true) {

                        swal({
                            title: "Excelente!",
                            text: res.data.msg,
                            icon: "success"
                        });
                        this.email = ""
                        this.password = ""

                        if (res.data.role_id == 2) {

                            window.location.href = "{{ url('/') }}"


                        } else if (res.data.role_id == 1)
                            window.location.href = "{{ url('/admin/dashboard') }}"

                    } else {
                        alert(res.data.msg)
                    }

                })
                .catch(err => {

                    $.each(err.response.data.errors, function(key, value) {
                        alert(value)
                    })

                })

        }

    },
    created() {


    }
});
</script>

@endpush