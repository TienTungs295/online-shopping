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
                                                   :class="{'is-invalid': errors.email}"
                                                   placeholder="Email">
                                            <div class="invalid-feedback" v-if="errors.email">
                                                <span v-for="error in errors.email" class="d-block">{{error}}</span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input class="form-control" required="" type="password" name="password"
                                                   v-model="password"
                                                   :class="{'is-invalid': errors.password}"
                                                   placeholder="Mật khẩu">
                                            <div class="invalid-feedback" v-if="errors.password">
                                                <span v-for="error in errors.password" class="d-block">{{error}}</span>
                                            </div>
                                        </div>

                                        <div class="invalid-feedback d-block" v-if="errors.login">
                                            <span v-for="error in errors.login" class="d-block">{{error}}</span>
                                        </div>
                                        <div class="form-group">
                                            <router-link
                                                :to="{ name: 'forgotPassword'}">
                                                Bạn quên mật khẩu?
                                            </router-link>
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
import {serviceBus} from "../../serviceBus";

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
        ]),
        currentRouteName() {
            return this.$route.name;
        }
    },
    methods: {
        login: function (email, password) {
            AuthService.login({email: email, password: password}).then(response => {
                let data = response || {};
                localStorage.setItem('access_token', data.access_token);
                this.$store.commit("setUserProfile", data.user);
                serviceBus.$emit('refreshWithList');
                this.$router.push({name: 'home'});
            }).catch(response => {
                this.errors = response.errors || {};
            });
        }
    },
    created() {
        AuthService.isAuthenticated(false, true).then(response => {
        }).catch(response => {
        });
    },
    mounted() {
    }
}
</script>
