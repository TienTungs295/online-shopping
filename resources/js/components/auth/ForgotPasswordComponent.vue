<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Quên mật khẩu</h1>
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
                            <li class="breadcrumb-item active">Quên mật khẩu</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->

        <!-- START MAIN CONTENT -->
        <div class="main_content position-relative">
            <loading-component v-bind:loading="isLoading"
                               v-bind:center="true"></loading-component>
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="dashboard_content">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <div class="mgb-20">
                                                Bạn quên mật khẩu của mình? Đừng lo lắng! Hãy cung cấp cho chúng tôi
                                                email bạn sử dụng để đăng ký tài khoản trên website 3M Nhập khẩu. Chúng
                                                tôi sẽ gửi
                                                cho bạn một liên kết để đặt lại mật khẩu của bạn qua email đó.
                                            </div>
                                            <div class="mgb-20 alert alert-success"
                                                 style="display: table;font-size: 14px"
                                                 v-if="emailSended">
                                                <i class="fa fa-check-circle"
                                                   style="font-size: 30px;display: table-cell"
                                                   aria-hidden="true"></i>
                                                <div style="display:table-cell;" class="pdl-20">
                                                    Chúng tôi đã gửi một email có lên kết để đặt lại mật khẩu của bạn.
                                                    Có thể mất từ 1 đến 2 phút để hoàn thành. Hãy kiểm tra hộp thư đến
                                                    của bạn <span class="fw-bold">{{ emailSended }}</span>.
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input id="email" type="email" class="form-control"
                                                       :class="{'is-invalid': errors.email}"
                                                       placeholder="Email của bạn"
                                                       v-model="email">
                                                <div class="invalid-feedback">
                                                    <span v-for="error in errors.email"
                                                          class="d-block">{{ error }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-fill-out btn-sm rounded-0"
                                                        @click="resetPass()">Gửi email cho tôi
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT -->
    </div>
</template>

<script>
import AuthService from "../../services/AuthService";

export default {
    name: "ChangePassWithToken",
    data() {
        return {
            errors: {},
            isLoading: false,
            email: "",
            emailSended: ""
        };
    },
    methods: {
        resetPass: function () {
            this.isLoading = true;
            AuthService.resetPass(this.email).then(response => {
                this.emailSended = response.email;
                this.email = "";
                this.errors = {};
                this.isLoading = false;
            }).catch(response => {
                this.isSuccessful = false;
                this.errors = response.errors || {};
                this.isLoading = false;
            });
        },
    },
}
</script>
