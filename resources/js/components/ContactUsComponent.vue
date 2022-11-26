<template>
  <div>
      <!-- START SECTION BREADCRUMB -->
      <div class="breadcrumb_section bg_gray page-title-mini">
          <div class="container"><!-- STRART CONTAINER -->
              <div class="row align-items-center">
                  <div class="col-md-6">
                      <div class="page-title">
                          <h1>Liên hệ</h1>
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
                          <li class="breadcrumb-item active">Liên hệ</li>
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
                      <div class="col-xl-4 col-md-6">
                          <div class="contact_wrap contact_style3">
                              <div class="contact_icon">
                                  <i class="linearicons-map2"></i>
                              </div>
                              <div class="contact_text">
                                  <span>Địa chỉ</span>
                                  <p>Số 77, tổ 17 thị trấn Đông Anh, Huyện Đông Anh, TP. Hà Nội</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-4 col-md-6">
                          <div class="contact_wrap contact_style3">
                              <div class="contact_icon">
                                  <i class="linearicons-envelope-open"></i>
                              </div>
                              <div class="contact_text">
                                  <span>Email</span>
                                  <a href="mailto:kinhdoanh.nk3m@gmail.com">kinhdoanh.nk3m@gmail.com</a>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-4 col-md-6">
                          <div class="contact_wrap contact_style3">
                              <div class="contact_icon">
                                  <i class="linearicons-tablet2"></i>
                              </div>
                              <div class="contact_text">
                                  <span>Điện thoại</span>
                                  <p>0979945555</p>
                              </div>
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
    name: "ContactUs",
    mounted() {
    }
}
</script>
