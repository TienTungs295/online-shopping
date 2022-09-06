<template>
    <div class="product">
        <div class="product_img style-1">
            <router-link
                :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                <img :src="'/uploads/images/'+item.image" :alt="item.image">
            </router-link>
            <div class="product_action_box">
                <ul class="list_none pr_action_btn">
                    <li class="add-to-cart"><a href="#"><i
                        class="icon-basket-loaded"></i>Thêm vào giỏ </a>
                    </li>
                    <li><a @click="showModal"
                           class="popup-ajax"><i
                        class="icon-magnifier-add"></i></a></li>
                    <li><a @click="addToWithList(item.id)"><i class="icon-heart"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="product_info">
            <h6 class="product_title">
                <router-link
                    :to="{ name: 'productDetail', params: { slug: item.slug,id:item.id }}">
                    {{ item.name }}
                </router-link>
            </h6>
            <div class="product_price">
                <div v-if="item.on_sale">
                    <span class="price">{{ item.sale_price }}</span>
                    <del>{{ item.price }}</del>
                    <div class="on_sale" v-if="item.sale_off != null">
                        <span>{{ item.sale_off }}% Off</span>
                    </div>
                </div>
                <div v-else>
                    <span class="price">{{ item.price }}</span>
                </div>
            </div>
            <div class="rating_wrap">
                <div class="rating">
                    <div class="product_rate" style="width:80%"></div>
                </div>
                <span class="rating_num">(21)</span>
            </div>
            <div class="list_product_action_box dis-none">
                <ul class="list_none pr_action_btn">
                    <li class="add-to-cart"><a href="#"><i
                        class="icon-basket-loaded"></i>Thêm vào giỏ</a></li>
                    <li><a href="shop-quick-view.html" class="popup-ajax"><i
                        class="icon-magnifier-add"></i></a></li>
                    <li><a @click="addToWithList(item.id)"><i class="icon-heart"></i></a></li>
                </ul>
            </div>
        </div>
        <!--        <button id="show-btn" type="button" @click="showModal">Open Modal</button>-->

        <b-modal :ref="'quick-view-modal'+item.id" content-class="rounded-0" size="xl" hide-footer hide-header>
            <div class="d-block">
                <product-quick-view-modal-component v-bind:id="item.id"></product-quick-view-modal-component>
            </div>
        </b-modal>
    </div>
</template>
<script>


import WithListService from "../../services/WithListService";
import {serviceBus} from "../../serviceBus";

export default {
    name: "ProductItem",
    props: ['item'],
    methods: {
        showModal() {
            let ref = 'quick-view-modal' + this.item.id;
            this.$refs[ref].show()
        },
        addToWithList: function (product_id) {
            WithListService.save({product_id: product_id}, true).then(response => {
                serviceBus.$emit('refreshWithListNum');
            }).catch(e => {
            });
        },
    },
    mounted() {
    }
}
</script>
