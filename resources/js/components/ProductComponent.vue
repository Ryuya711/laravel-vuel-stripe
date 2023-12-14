<template>
    <h1>商品リスト</h1>
    <div>
        <table>
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>説明</th>
                    <th>値段</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.price }}</td>
                    <td><button><router-link :to="`/products/${product.id}`" >詳細</router-link></button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: []
        };
    },
    created() {
        axios.get('/api/products')
            .then(response => {
                this.products = response.data;
            })
            .catch(error => {
                console.error(error);
            });
    }
}
</script>

<style scoped>
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}
</style>
