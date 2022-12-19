<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Điều khoản dịch vụ</h1>
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
                            <li class="breadcrumb-item active">Điều khoản dịch vụ</li>
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
                                1. Giới thiệu
                            </h6>

                            Chào mừng quý khách hàng đến với website chúng tôi.
                            <br>

                            Khi quý khách hàng truy cập vào trang website của chúng tôi có nghĩa là quý khách đồng ý với các điều khoản này. Trang web có quyền thay đổi, chỉnh sửa, thêm hoặc lược bỏ bất kỳ phần nào trong Điều khoản mua bán hàng hóa này, vào bất cứ lúc nào. Các thay đổi có hiệu lực ngay khi được đăng trên trang web mà không cần thông báo trước. Và khi quý khách tiếp tục sử dụng trang web, sau khi các thay đổi về Điều khoản này được đăng tải, có nghĩa là quý khách chấp nhận với những thay đổi đó.
                            <br>
                            <p>
                                Quý khách hàng vui lòng kiểm tra thường xuyên để cập nhật những thay đổi của chúng tôi.
                            </p>

                            <h6>
                                2. Hướng dẫn sử dụng website
                            </h6>
                            <p>
                                Khi vào web của chúng tôi, khách hàng phải đảm bảo đủ 18 tuổi, hoặc truy cập dưới sự giám sát của cha mẹ hay người giám hộ hợp pháp. Khách hàng đảm bảo có đầy đủ hành vi dân sự để thực hiện các giao dịch mua bán hàng hóa theo quy định hiện hành của pháp luật Việt Nam.
                            </p>
                            <h6>
                                3. Thanh toán an toàn và tiện lợi
                            </h6>

                            Người mua có thể tham khảo các phương thức thanh toán sau đây và lựa chọn áp dụng phương thức phù hợp:
                            <br>

                            Cách 1: Thanh toán trực tiếp (người mua nhận hàng tại địa chỉ người bán)
                            <br>
                            Cách 2: Thanh toán sau (COD – giao hàng và thu tiền tận nơi)
                            <br>
                            Cách 3: Thanh toán online, chuyển khoản
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
    name: "TermsOfService",
    mounted() {
    },
    data() {
        return {}
    },
}
</script>
