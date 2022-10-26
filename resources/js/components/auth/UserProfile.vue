<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Thông tin tài khoản</h1>
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
                            <li class="breadcrumb-item active">Thông tin tài khoản</li>
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
                                    <div class="card-body" v-if="userProfile != null">
                                        <div>
                                            <div class="form-group">
                                                <label for="name">Họ và tên:</label>
                                                <input id="name" type="text" class="form-control"
                                                       :class="{'is-invalid': errors.name}" name="name"
                                                       v-model="userProfile.name">
                                                <div class="invalid-feedback">
                                                    <span v-for="error in errors.name"
                                                          class="d-block">{{ error }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input id="email" type="text" class="form-control" disabled="disabled"
                                                       v-model="userProfile.email" name="email">
                                            </div>

                                            <div class="form-group ">
                                                <label for="phone">Số điện thoại:</label>
                                                <input type="text" class="form-control"
                                                       :class="{'is-invalid': errors.phone_number}" name="phone"
                                                       id="phone"
                                                       v-model="userProfile.phone_number" maxlength="15">
                                                <div class="invalid-feedback">
                                                    <span v-for="error in errors.phone_number"
                                                          class="d-block">{{ error }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <label for="phone">Địa chỉ:</label>
                                                <input type="text" class="form-control"
                                                       :class="{'is-invalid': errors.address}" name="address"
                                                       id="address"
                                                       v-model="userProfile.address" maxlength="350">
                                                <div class="invalid-feedback">
                                                    <span v-for="error in errors.address"
                                                          class="d-block">{{ error }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-fill-out btn-sm rounded-0"
                                                        @click="update()">Cập nhật
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
import {mapGetters} from "vuex";
import AuthService from "../../services/AuthService";

export default {
    name: "UserProfile",
    data() {
        return {
            errors: {},
            isLoading: true
        };
    },
    computed: {
        ...mapGetters([
            'isLoggedIn',
            'userProfile',
        ])
    },
    methods: {
        update: function () {
            this.isLoading = true;
            AuthService.update(this.userProfile, true).then(response => {
                let data = response || {};
                this.$store.commit("setUserProfile", data);
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
        AuthService.userProfile().then(response => {
            let data = response || {};
            this.$store.commit("setUserProfile", data);
            this.isLoading = false;
        }).catch(response => {
            this.isLoading = false;
        });
    }
}
</script>
