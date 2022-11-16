<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Thay đổi mật khẩu</h1>
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
                            <li class="breadcrumb-item active">Thay đổi mật khẩu</li>
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
                                                <label for="old_password">Mật khẩu hiện tại:</label>
                                                <input id="old_password" type="password" class="form-control"
                                                       :class="{'is-invalid': errors.old_password}" name="old_password"
                                                       v-model="user.old_password">
                                                <div class="invalid-feedback">
                                                    <span v-for="error in errors.old_password"
                                                          class="d-block">{{ error }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">Mật khẩu mới:</label>
                                                <input id="new_password" type="password" class="form-control"
                                                       :class="{'is-invalid': errors.new_password}" name="new_password"
                                                       v-model="user.new_password">
                                                <div class="invalid-feedback">
                                                    <span v-for="error in errors.new_password"
                                                          class="d-block">{{ error }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm_new_password">Xác nhận mật khẩu mới:</label>
                                                <input id="confirm_new_password" type="password" class="form-control"
                                                       :class="{'is-invalid': errors.confirm_new_password}"
                                                       name="confirm_new_password"
                                                       v-model="user.confirm_new_password">
                                                <div class="invalid-feedback">
                                                    <span v-for="error in errors.confirm_new_password"
                                                          class="d-block">{{ error }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-fill-out btn-sm rounded-0"
                                                        @click="changePass()">Cập nhật
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
    name: "ChangePass",
    data() {
        return {
            errors: {},
            isLoading: false,
            user: {}
        };
    },
    methods: {
        changePass: function () {
            this.isLoading = true;
            AuthService.changePass(this.user, true).then(response => {
                this.errors = {};
                this.isLoading = false;
            }).catch(response => {
                this.errors = response.errors || {};
                this.isLoading = false;
            });
        },
    },
    created() {
        AuthService.isAuthenticated(true).then(response => {
        }).catch(response => {
        });
    },
    mounted() {
    }
}
</script>
