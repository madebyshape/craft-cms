import Vue from 'vue';

const Example = () => import('../vue/Example.vue');

new Vue({
	el: '#app',
	delimiters: ['${', '}'],
	components: {
		Example
	}
});