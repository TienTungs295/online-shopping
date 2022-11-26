<template>
  <div>
      <!-- START SECTION BREADCRUMB -->
      <div class="breadcrumb_section bg_gray page-title-mini">
          <div class="container"><!-- STRART CONTAINER -->
              <div class="row align-items-center">
                  <div class="col-md-6">
                      <div class="page-title">
                          <h1>Về chúng tôi</h1>
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
                          <li class="breadcrumb-item active">Về chúng tôi</li>
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
                  <div class="row justify-content-center">
                      <div class="col-md-10">
                        <div>
                            <p>
                                Trước tiên, Công ty TNHH Thương mại và Sản xuất NK xin gửi tới Quý khách hàng lời chào trân trọng nhất!
                            </p>
                            <p>
                                Công ty TNHH Thương Mại và Sản xuất NK được thành lập từ năm 2009 với giấy phép kinh doanh số 0103713002.
                                <br>
                                Trong nhiều năm nay Công ty chúng tôi là Đại diện phân phối các sản phẩm đầu cáp, hộp nối cáp, ống co ngót cách điện, sơn cách điện, băng keo cách điện ... của tập đoàn 3M-Mỹ (Ngành hàng thiết bị điện - điện tử) đảm bảo theo tiêu chuẩn ngành điện Việt Nam.
                                <br>
                                Với phương châm sự tín nhiệm của khách hàng là chìa khóa của thành công. Tập thể cán bộ Công ty luôn nỗ lực tạo ra các sản phẩm và dịch vụ tốt nhất cho khách hàng.
                                <br>
                                Mong muốn được phục vụ khách hàng ngày càng chu đáo hơn và để khẳng định vị thế của mình trên thị trường ngành điện. Chúng tôi luôn sẵn sàng tiếp nhận và biết ơn mọi sự đóng góp ý kiến của khách hàng.
                            </p>
                            <p>
                                Trân trọng cảm ơn sự hợp tác của Quý khách hàng!
                            </p>
                        </div>
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
    name: "AboutUs",
    mounted() {
    }
}
</script>
