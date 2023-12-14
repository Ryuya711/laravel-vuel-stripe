<template>
    <div class="cart-container">
        <h1>カート</h1>
        <div v-if="cartItems.length" class="cart-items">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>商品名</th>
                        <th>数量</th>
                        <th>価格</th>
                        <th>小計</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in cartItems" :key="item.product_id">
                        <td>{{ item.name }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>￥{{ item.price.toLocaleString() }}</td>
                        <td>￥{{ (item.price * item.quantity).toLocaleString() }}</td>
                        <td><button @click="removeItem(item.id)">削除</button></td>
                    </tr>
                </tbody>
            </table>
            <div class="total-price">
                合計金額: ￥{{ totalPrice.toLocaleString() }}
            </div>
            <button @click="checkout" class="checkout-button">購入する</button>
        </div>
        <div v-else class="empty-cart">
            <p>カートに商品が入っていません。</p>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

export default {
    data() {
        return {
            cartItems: [],
            totalPrice: 0
        };
    },
    created() {
        this.fetchCartItems();
    },
    methods: {
        fetchCartItems() {
            axios.get('/api/cart')
                .then(response => {
                    this.cartItems = response.data.line_items;
                    this.totalPrice = response.data.total_price
                })
                .catch(error => {
                    console.error('カートデータの取得に失敗しました:', error);
                });
        },
        removeItem(itemId) {
            axios.delete(`/api/line-items/${itemId}`)
            .then(() => {
                this.fetchCartItems(); // カートのアイテムを再取得
            })
            .catch(error => {
                console.error('削除に失敗しました')
            })
        },
        checkout() {
            axios.get('/api/cart/checkout')
                .then(response => {
                // Stripeの公開可能キーを設定
                const stripe = Stripe(response.data.publicKey);

                // Stripeのチェックアウトページにリダイレクト
                stripe.redirectToCheckout({
                    sessionId: response.data.sessionId
                }).then(function (result) {
                    // エラー処理
                    console.error(result.error.message);
                });
            })
            .catch(error => {
                console.error('チェックアウトに失敗しました:', error);
            });
        }              
    }
};
</script>


<style scoped>
.cart-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.cart-items {
    margin-top: 20px;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.cart-table thead {
    background-color: #f8f8f8;
}

.cart-table th, .cart-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.cart-table th {
    font-weight: bold;
}

.total-price {
    font-size: 1.2em;
    font-weight: bold;
    text-align: right;
}

.empty-cart {
    text-align: center;
    margin-top: 20px;
}

.checkout-button {
    background-color: #4CAF50; /* 緑色 */
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
}
</style>
