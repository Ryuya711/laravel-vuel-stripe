<template>
    <div class="product-detail" v-if="product">
        <h1 class="product-title">商品詳細</h1>
        <img :src="product.image" alt="商品画像" class="product-image" />
        <div class="product-info">
            <h2>{{ product.name }}</h2>
            <p>{{ product.description }}</p>
            <p class="product-price">価格: {{ product.price }}</p>
            <div class="quantity-selector">
                <label for="quantity">数量:</label>
                <input type="number" id="quantity" min="1" v-model.number="quantity">
            </div>
            <button @click="addToCart">カートに追加する</button>
        </div>
    </div>
    <div v-else>
        <p>商品情報を読み込み中...</p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            product: null,
            quantity: 1
        };
    },
    created() {
        axios.get(`/api/products/${this.$route.params.productId}`)
            .then(response => {
                this.product = response.data;
            })
            .catch(error => {
                console.error('商品の取得に失敗しました:', error);
                // エラー処理をここに記述
            });
    },
    methods: {
        addToCart() {
            axios.post('/api/line-items', {
                product_id: this.product.id,
                quantity: this.quantity
            }).then(response => {
                this.$router.push('/cart');
            }).catch(error => {
                // エラー処理
            });
        }
    }
}
</script>

<style scoped>
.product-detail {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.product-title {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.product-info {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
}

.product-info h2 {
    color: #444;
    margin-bottom: 10px;
}

.product-price {
    color: #888;
    font-weight: bold;
}

.product-image {
    display: block;
    max-width: 100%;
    height: auto;
    margin: 0 auto 20px;
    border-radius: 8px;
}

.quantity-selector {
    margin: 10px 0;
    display: flex;
    align-items: center;
}

.quantity-selector label {
    margin-right: 10px;
}

.quantity-selector input {
    width: 60px;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button {
    background-color: #444c55;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #101011;
}
</style>
