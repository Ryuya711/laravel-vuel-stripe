import './bootstrap';
import { createApp } from 'vue';

// routerをインポート
import router from './router'; 

// App.vueをインポート
import App from './components/App.vue'; 

// Vue アプリケーションを作成し、ルートコンポーネントとしてApp.vueを使用
const app = createApp(App);

// Vue Routerをアプリケーションに適用
app.use(router);

// アプリケーションをDOM要素にマウント
app.mount('#app');
