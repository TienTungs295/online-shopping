<template>
    <div class="overflow-hidden">
        <b-modal :ref="'contact'" centered content-class="rounded-0" hide-footer hide-header>
            <div class="d-block">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s3 text-center">
                                    <h4>Đăng ký nhận thông tin!</h4>
                                </div>
                                <p>Đăng ký nhận bản tin để nhận thông tin cập nhật về sản phẩm mới.</p>
                            </div>
                            <div class="form-group text-left">
                                <input name="email" type="email" class="form-control"
                                       :class="{'is-invalid': errors.email}" v-model="contact.email"
                                       placeholder="Nhập email">
                                <div class="invalid-feedback" v-if="errors.email">
                                    <span v-for="error in errors.email" class="d-block">{{ error }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-fill-out btn-block rounded-0"
                                        @click="saveContact()">Đăng ký
                                </button>
                            </div>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox"
                                           @click="doNotShowAgain()"
                                           id="exampleCheckbox3" :value="notShow">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Không hiển thị lại thông báo này!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </b-modal>
        <header-component></header-component>
        <router-view :key="$route.fullPath"></router-view>
        <footer-component></footer-component>
    </div>
</template>
<script>
import AuthService from "../services/AuthService";
import ContactService from "../services/ContactService";

export default {
    name: "App",
    data() {
        return {
            contact: {},
            errors: {},
            notShow: false
        }
    },
    methods: {
        checkTokenExpire: function () {
            setInterval(function () {
                AuthService.userProfile().then(response => {
                }).catch(response => {

                });
            }, 300000);
        },
        showContactModal() {
            let ref = 'contact';
            this.$refs[ref].show()
        },
        hideContactModal() {
            let ref = 'contact';
            this.$refs[ref].hide()
        },
        saveContact() {
            if (this.contact.email == null || this.contact.email == undefined || this.contact.email.trim() == "") {
                return;
            }
            ContactService.save(this.contact, true).then(response => {
                this.errors = {};
                this.contact = {};
                this.hideContactModal();
            }).catch(response => {
                this.errors = response.errors || {};
            });
        },
        doNotShowAgain() {
            this.notShow = !this.notShow;
            this.$cookies.set("do_not_show_popup_again", this.notShow);
        }
    },
    mounted() {
        AuthService.userProfile().then(response => {
            let data = response || {};
            this.$store.commit("setUserProfile", data);
        }).catch(response => {
        });
        this.checkTokenExpire();
        console.log(this.$cookies.get("do_not_show_popup_again"));
        if (!this.$cookies.get("do_not_show_popup_again")) {
            this.showContactModal();
        }
    }
}
</script>
