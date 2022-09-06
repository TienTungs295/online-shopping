<template>
    <div class="row">
        <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
            <div class="product-image">
                <div class="product_img_box style-1">
                    <img v-if="product.image" id="product_img" :src="'/uploads/images/'+product.image"
                         :alt="product.image"
                         :data-zoom-image="'/uploads/images/'+product.image"/>
                </div>
                <div id="pr_item_gallery">
                    <div class="item" v-for="item in product.images">
                        <a href="#" class="product_gallery_item">
                            <img :src="'/uploads/images/'+item.image" :alt="item.image"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="pr_detail">
                <div class="product_description">
                    <h4 class="product_title"><a href="#">{{ product.name }}</a></h4>
                    <div class="product_price">
                        <div v-if="product.on_sale">
                            <span class="price">{{ product.sale_price }}</span>
                            <del>{{ product.price }}</del>
                            <div class="on_sale" v-if="product.sale_off != null">
                                <span>{{ product.sale_off }}% Off</span>
                            </div>
                        </div>
                        <div v-else>
                            <span class="price">{{ product.price }}</span>
                        </div>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:80%"></div>
                        </div>
                        <span class="rating_num">(21)</span>
                    </div>
                    <div class="pr_desc">
                        <p>{{ product.description }}</p>
                    </div>
                </div>
                <hr/>
                <div class="cart_extra">
                    <div>
                        <div class="cart-product-quantity">
                            <div class="quantity">
                                <input type="button" value="-" class="minus">
                                <input type="text" name="quantity" value="1" title="Qty" class="qty"
                                       size="4">
                                <input type="button" value="+" class="plus">
                            </div>
                        </div>
                        <br>
                        <div class="cart_btn mgb-10">
                            <button class="btn btn-fill-out btn-addtocart rounded-0" type="button"><i
                                class="icon-basket-loaded"></i> Thêm vào giỏ
                            </button>
                            <button class="btn btn-fill-line view-cart rounded-0" type="button"><i
                                class="icon-basket-loaded"></i> Mua ngay
                            </button>
                            <a class="add_wishlist" @click="addToWithList(product.id)"><i class="icon-heart"></i></a>
                        </div>
                    </div>
                </div>
                <hr/>
                <ul class="product-meta">
                    <li>Mã sản phẩm: <span>{{ product.sku }}</span></li>
                    <li v-if="product.category">Danh mục: <a href="#">{{ product.category.name }}</a></li>
                </ul>

                <div class="product_share">
                    <span>Chia sẻ:</span>
                    <ul class="social_icons">
                        <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import WithListService from "../../services/WithListService";
import {serviceBus} from "../../serviceBus";

export default {
    name: "ProductQuickViewItem",
    props: ['product'],
    methods: {
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
