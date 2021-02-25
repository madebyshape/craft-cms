import { createApp } from 'vue';

import Example from '../vue/Example.vue';

const app = createApp({
	delimiters: ['${', '}'],
	components: {
		Example
	}
});

app.mount('#app');