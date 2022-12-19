<template>
    <div>
        <!-- START SECTION BREADCRUMB -->
        <div class="breadcrumb_section bg_gray page-title-mini">
            <div class="container"><!-- STRART CONTAINER -->
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-title">
                            <h1>Chính sách vận chuyển</h1>
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
                            <li class="breadcrumb-item active">Chính sách vận chuyển</li>
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
                           <p>
                               Thông thường sau khi nhận được thông tin đặt hàng chúng tôi sẽ xử lý đơn hàng trong vòng 24h và phản hồi lại thông tin cho khách hàng về việc thanh toán và giao nhận. Thời gian giao hàng thường trong khoảng từ 3-5 ngày kể từ ngày chốt đơn hàng hoặc theo thỏa thuận với khách khi đặt hàng. Tuy nhiên, cũng có trường hợp việc giao hàng kéo dài hơn nhưng chỉ xảy ra trong những tình huống bất khả kháng như sau:
                           </p>
                           <ul class="pdb-10">
                               <li>+ Nhân viên công ty sẽ liên lạc với khách hàng qua điện thoại không được nên không thể giao hàng.</li>
                               <li>+ Địa chỉ giao hàng bạn cung cấp không chính xác hoặc khó tìm.</li>
                               <li>+ Số lượng đơn hàng của công ty tăng đột biến khiến việc xử lý đơn hàng bị chậm.</li>
                               <li>+ Đối tác cung cấp cho công ty chậm hơn dự kiến khiến việc giao hàng bị chậm lại hoặc đối tác vận chuyển giao hàng bị chậm chỉ vận chuyển phân phối cho đại lý hoặc khách hàng có nhu cầu lớn, lâu dài.</li>
                           </ul>
                           <p>
                               Vì thế công ty đa phần sẽ hỗ trợ chi phí vận chuyển như một cách chăm sóc đại lý cua mình. Đối với khách lẻ nếu có nhu cầu sử dụng lớn vui lòng liên hệ trực tiếp để thỏa thuận hợp đồng cũng như phí vận chuyển.
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
    name: "ShippingPolicy",
    mounted() {
    },
    data() {
        return {}
    },
}
</script>
