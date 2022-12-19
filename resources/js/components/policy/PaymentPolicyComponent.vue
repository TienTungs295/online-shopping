<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Chính sách thanh toán</h1>
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
                            <li class="breadcrumb-item active">Chính sách thanh toán</li>
                        </ol>
                    </div>
                </div>
            </div><!-- END CONTAINER-->
        </div>
        <!-- END SECTION BREADCRUMB -->
        <!-- START MAIN CONTENT -->
        <div class="main_content">
            <!-- START SECTION CONTACT -->
            <div class="section pb_70">
                <div class="container">
                    <div class="row">
                       <div class="col">
                           Khi mua hàng khách hàng có thể thanh toán bằng tiền mặt hoặc chuyển khoản thông qua tài khoản ngân hàng  của công ty
                       </div>
                    </div>
                </div>
            </div>
            <!-- END SECTION CONTACT -->
        </div>
        <!-- END MAIN CONTENT -->
    </div>
</template>

<script>

export default {
    name: "PaymentPolicy",
    mounted() {
    },
    data() {
        return {}
    },
}
</script>
