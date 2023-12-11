<template>
    <h1>ハローワールド</h1>
    <div>
        <ul>
            <li v-for="product in products" :key="product.id">{{ product.name }}</li>
        </ul>
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

</style>