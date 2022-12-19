<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Chính sách đổi trả</h1>
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
                            <li class="breadcrumb-item active">Chính sách đổi trả</li>
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
                            <h6>
                                1. Điều kiện đổi trả
                            </h6>
                            <div>
                                Quý Khách hàng cần kiểm tra tình trạng hàng hóa và có thể đổi hàng/ trả lại hàng ngay tại thời điểm giao/nhận hàng trong những trường hợp sau:
                            </div>
                            <ul>
                                <li>
                                    - Hàng không đúng chủng loại, mẫu mã trong đơn hàng đã đặt hoặc như trên website tại thời điểm đặt hàng.
                                </li>
                                <li>
                                    - Không đủ số lượng, không đủ bộ như trong đơn hàng.
                                </li>
                                <li>
                                    - Tình trạng bên ngoài bị ảnh hưởng như rách bao bì, bong tróc, bể vỡ…
                                </li>
                            </ul>
                            <p>
                                Khách hàng có trách nhiệm trình giấy tờ liên quan chứng minh sự thiếu sót trên để hoàn thành việc hoàn trả/đổi trả hàng hóa.
                            </p>
                            <h6>2. Quy định về thời gian thông báo và gửi sản phẩm đổi trả</h6>
                            <ul>
                                <li>
                                    - Thời gian thông báo đổi trả: trong vòng 48h kể từ khi nhận sản phẩm đối với trường hợp sản phẩm thiếu phụ kiện, quà tặng hoặc bể vỡ.
                                </li>
                                <li>
                                    - Thời gian gửi chuyển trả sản phẩm: trong vòng 14 ngày kể từ khi nhận sản phẩm.
                                </li>
                                <li>
                                    - Địa điểm đổi trả sản phẩm: Khách hàng có thể mang hàng trực tiếp đến văn phòng/ cửa hàng của chúng tôi hoặc chuyển qua đường bưu điện.
                                </li>
                            </ul>
                            Trong trường hợp Quý Khách hàng có ý kiến đóng góp/khiếu nại liên quan đến chất lượng sản phẩm, Quý Khách hàng vui lòng liên hệ đường dây chăm sóc khách hàng của chúng tôi.
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
    name: "ReturnPolicy",
    mounted() {
    },
    data() {
        return {}
    },
}
</script>
