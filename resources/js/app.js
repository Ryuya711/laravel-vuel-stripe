import './bootstrap';
import axios from 'axios';
import { createApp } from 'vue';

// routerをインポート
import router from './router'; 

// App.vueをインポート
import App from './components/App.vue';

// Axiosの設定
axios.defaults.withCredentials = true;

// Vue アプリケーションを作成し、ルートコンポーネントとしてApp.vueを使用
const app = createApp(App);

// Vue Routerをアプリケーションに適用
app.use(router);

// アプリケーションをDOM要素にマウント
app.mount('#app');
