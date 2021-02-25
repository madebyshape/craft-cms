import { createApp, defineAsyncComponent } from 'vue';

const Example = defineAsyncComponent (() => import('../vue/Example.vue'));

const app = createApp({
	delimiters: ['${', '}'],
	components: {
		Example
	}
});

app.mount('#app');