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
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input id="email" type="email" class="form-control"
                                                       v-model="email">
                                            </div>
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-fill-out btn-sm rounded-0"
                                                        @click="resetPass()">Đặt lại mật khẩu
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
            message: ""
        };
    },
    methods: {
        resetPass: function () {
            this.isLoading = true;
            AuthService.resetPass(this.email).then(response => {
                this.message = response.message || "";
                this.isLoading = false;
            }).catch(response => {
                this.errors = response.errors || {};
                this.isLoading = false;
            });
        },
    },
}
</script>
