import 'alpinejs';
import Vue from 'vue';
import Cookies from 'js-cookie';

// Modules

import { exampleModule } from './modules/example';
import { lazyLoadModule } from './modules/lazyLoad';

exampleModule();
lazyLoadModule();

// Vue

import Example from '../vue/Example.vue';

new Vue({
	el: '#app',
	components: {
		Example
	}
});