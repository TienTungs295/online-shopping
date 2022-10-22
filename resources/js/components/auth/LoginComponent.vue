<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Đăng nhập</h1>
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
                            <li class="breadcrumb-item active">Đăng nhập</li>
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
                                        <h3>Đăng nhập</h3>
                                    </div>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" required="" class="form-control" name="email"
                                                   v-model="email"
                                                   placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" required="" type="password" name="password"
                                                   v-model="password"
                                                   placeholder="Mật khẩu">
                                        </div>
                                        <div class="text-danger" v-if="errors.login != null">
                                            {{ errors.login }}
                                        </div>
                                        <div class="login_footer form-group">
                                            <a href="#">Bạn quên mật khẩu?</a>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-fill-out btn-block rounded-0"
                                                    @click="login(email,password)">Đăng nhập
                                            </button>
                                        </div>
                                    </form>
                                    <div class="form-note text-center">Bạn chưa có tài khoản?
                                        <router-link
                                            :to="{ name: 'register'}">
                                            Đăng ký ngay
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
    name: "Login",
    data() {
        return {
            email: "",
            password: "",
            errors: {}
        };
    },
    computed: {
        ...mapGetters([
            'isLoggedIn'
        ])
    },
    methods: {
        login: function (email, password) {
            AuthService.login({email: email, password: password}).then(response => {
                let data = response || {};
                this.$store.commit("setLoggedIn", true);
                this.$store.commit("setUserProfile", data.user);
                localStorage.setItem('access_token', data.access_token);
                this.$router.push({name: 'home'});
            }).catch(response => {
                this.errors = response.errors || {};
            });
        }
    },
    mounted() {
    }
}
</script>
