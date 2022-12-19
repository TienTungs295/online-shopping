<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Chính sách bảo hành</h1>
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
                            <li class="breadcrumb-item active">Chính sách bảo hành</li>
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
                            <p> Quý khách có thể mang sản phẩm trực tiếp đến địa chỉ công ty chúng tôi để được bảo hành
                                và sản phẩm của quý khách phải còn nằm trong thời hạn bảo hành sản phẩm theo chính sách
                                bảo hành của chúng tôi.
                            </p>
                            <p> Khách hàng có thể mang sản phẩm đến địa chỉ sau để bảo hành:
                            </p>
                            <p> Tên đơn vị: Công ty TNHH thương mại và sản xuất NK
                            </p>
                            <p> VPGD: Số 78, Ngõ 166, Đường Trần Duy Hưng, Phường Trung Hoà, Quận Cầu Giấy, TP Hà Nội
                            </p>
                            <p> Điện thoại: 0979945555
                            </p>
                            <p>
                                Khi tiếp nhận sản phẩm nếu còn nằm trong thời hạn bảo hành và điều kiện bảo hành chúng
                                tôi sẽ tiến hành bảo hành hoặc tiến hành đổi trả sản phẩm cho quý khách hàng.
                            </p>
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
    name: "WarrantyPolicy",
    mounted() {
    },
    data() {
        return {}
    },
}
</script>
