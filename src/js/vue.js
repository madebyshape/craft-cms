import { createApp, defineAsyncComponent } from 'vue';

const Example = defineAsyncComponent (() => import(/* webpackChunkName: "Example" */'../vue/Example.vue'));

const app = createApp({
	delimiters: ['${', '}'],
	components: {
		Example
	}
});

app.mount('#app');