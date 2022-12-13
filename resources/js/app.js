/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


import App from './components/App';
import Vue from 'vue';
import router from './router';
import VueToastr from "vue-toastr";
import moment from 'moment';
import {BTabs, BTab, BModal, BCarousel, BCarouselSlide, BDropdown, BDropdownItem, BProgress} from 'bootstrap-vue';
import store from './store';
import VueStarRating  from 'vue-star-rating';
import VueCookies from 'vue-cookies'
import VueGallerySlideshow from 'vue-gallery-slideshow';


Vue.component('header-component', require('./components/layouts/HeaderComponent').default);
Vue.component('footer-component', require('./components/layouts/FooterComponent').default);
Vue.component('product-item-component', require('./components/products/ProductItemComponent').default);
Vue.component('product-quick-view-item-component', require('./components/products/ProductQuickViewItemComponent').default);
Vue.component('product-quick-view-modal-component', require('./components/products/ProductQuickViewModalComponent').default);
Vue.component('blog-item-component', require('./components/blogs/BlogItemComponent').default);
Vue.component('loading-component', require('./components/common/LoadingComponent').default);
Vue.component('flash-sale-component', require('./components/products/FlashSaleProductsComponent').default);
Vue.component('tree-menu-component', require('./components/common/TreeMenuComponent').default);
Vue.component('tree-category-component', require('./components/common/TreeCategoryComponent').default);
Vue.component('b-tabs', BTabs);
Vue.component('b-tab', BTab);
Vue.component('b-modal', BModal);
Vue.component('b-carousel', BCarousel);
Vue.component('b-carousel-slide', BCarouselSlide);
Vue.component('b-dropdown', BDropdown);
Vue.component('b-dropdown-item', BDropdownItem);
Vue.component('star-rating', VueStarRating)
Vue.component('b-progress', BProgress)
Vue.component('vue-gallery-slideshow', VueGallerySlideshow)

Vue.use(VueToastr, {
    defaultTimeout: 2000,
    defaultProgressBar: false,
    defaultPosition: "toast-top-right",
    defaultCloseOnHover: true,
    clickClose: true,
    defaultStyle: {"top": "50px"},
});

Vue.use(VueCookies, { expires: '60d'})

Vue.prototype.moment = moment;

Vue.directive('carousel', {
    inserted: function (el) {
        setTimeout(function () {
            $(el).owlCarousel({
                rtl: $('body').prop('dir') === 'rtl',
                dots: $(el).data('dots'),
                loop: $(el).data('loop'),
                items: $(el).data('items'),
                margin: $(el).data('margin'),
                mouseDrag: $(el).data('mouse-drag'),
                touchDrag: $(el).data('touch-drag'),
                autoHeight: $(el).data('autoheight'),
                center: $(el).data('center'),
                nav: $(el).data('nav'),
                rewind: $(el).data('rewind'),
                navText: ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'],
                autoplay: $(el).data('autoplay'),
                animateIn: $(el).data('animate-in'),
                animateOut: $(el).data('animate-out'),
                autoplayTimeout: $(el).data('autoplay-timeout'),
                smartSpeed: $(el).data('smart-speed'),
                responsive: $(el).data('responsive')
            });
        }, 10);
    },
});
Vue.directive('countDown', {
    inserted: function (el) {
        setTimeout(function () {
            let countDown = $(el).find('.countdown_time');
            let endTime = countDown.data('time');
            countDown.countdown(endTime, function (tm) {
                countDown.html(tm.strftime('<div class="countdown_box"><div class="countdown-wrap"><span class="countdown days">%D </span><span class="cd_text">' + countDown.data('days-text') + '</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown hours">%H</span><span class="cd_text">' + countDown.data('hours-text') + '</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown minutes">%M</span><span class="cd_text">' + countDown.data('minutes-text') + '</span></div></div><div class="countdown_box"><div class="countdown-wrap"><span class="countdown seconds">%S</span><span class="cd_text">' + countDown.data('seconds-text') + '</span></div></div>'));
            });
        }, 10);
    },
});

Vue.filter('dateFormat', function (value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
});

Vue.filter('dateTimeFormat', function (value) {
    if (value) {
        return moment(String(value)).format('H:MM DD/MM/YYYY')
    }
});

Vue.filter('commaFormat', function (value) {
    if (value != null) {
        value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        value += ' đ';
        return value;
    }
});


const app = new Vue({
    store,
    el: '#app',
    render: h => h(App),
    router
});

