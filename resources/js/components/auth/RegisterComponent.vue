<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Đăng ký</h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item">
                                <router-link
                                    :to="{ name: 'home'}">
                                    Trang chủ
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">Đăng ký</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content">

            <!-- START LOGIN SECTION -->
            <div class="login_register_wrap section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-6 col-md-10">
                            <div class="login_wrap">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h3>Đăng ký tài khoản</h3>
                                    </div>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" required class="form-control "
                                                   :class="{'is-invalid': errors.name}" name="name"
                                                   placeholder="Họ & tên của bạn" v-model="name">
                                            <div class="invalid-feedback">
                                                <span v-for="error in errors.name" class="d-block">{{ error }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required class="form-control"
                                                   :class="{'is-invalid': errors.email}" name="email"
                                                   placeholder="Địa chỉ email của bạn" v-model="email">
                                            <div class="invalid-feedback">
                                                <span v-for="error in errors.email" class="d-block">{{ error }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" :class="{'is-invalid': errors.password}"
                                                   required type="password" name="password"
                                                   placeholder="Mật khẩu" v-model="password">
                                            <div class="invalid-feedback">
                                                <span v-for="error in errors.password"
                                                      class="d-block">{{ error }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" :class="{'is-invalid': errors.confirm_password}"
                                                   required type="password" name="password"
                                                   placeholder="Xác nhận mật khẩu của bạn" v-model="confirm_password">
                                            <div class="invalid-feedback">
                                                <span v-for="error in errors.confirm_password"
                                                      class="d-block">{{ error }}</span>
                                            </div>
                                        </div>
                                        <!--                                        <div class="login_footer form-group">-->
                                        <!--                                            <div class="chek-form">-->
                                        <!--                                                <div class="custome-checkbox">-->
                                        <!--                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">-->
                                        <!--                                                    <label class="form-check-label" for="exampleCheckbox2"><span>I agree to terms &amp; Policy.</span></label>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <div class="form-group">
                                            <button type="button" class="btn btn-fill-out btn-block rounded-0"
                                                    name="register"
                                                    @click="register(name,email,password,confirm_password)">Đăng ký
                                            </button>
                                        </div>
                                    </form>
                                    <!--                                    <div class="different_login">-->
                                    <!--                                        <span> or</span>-->
                                    <!--                                    </div>-->
                                    <!--                                    <ul class="btn-login list_none text-center">-->
                                    <!--                                        <li><a href="#" class="btn btn-facebook"><i class="ion-social-facebook"></i>Facebook</a></li>-->
                                    <!--                                        <li><a href="#" class="btn btn-google"><i class="ion-social-googleplus"></i>Google</a></li>-->
                                    <!--                                    </ul>-->
                                    <div class="form-note text-center">Bạn đã có tài khoản?
                                        <router-link
                                            :to="{ name: 'login'}">
                                            Đăng nhập
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END LOGIN SECTION -->

        </div>
        <!-- END MAIN CONTENT -->
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import AuthService from "../../services/AuthService";

export default {
    name: "Register",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            confirm_password: "",
            errors: {}
        };
    },
    computed: {
        ...mapGetters([
            'isLoggedIn'
        ])
    },
    methods: {
        register: function (name, email, password, confirm_password) {
            let object = {name: name, email: email, password: password, confirm_password: confirm_password}
            AuthService.register(object, true).then(response => {
                this.$router.push({name: 'login'});
            }).catch(response => {
                this.errors = response.errors || {};
            });
        },
    },
    mounted() {
    }
}
</script>
