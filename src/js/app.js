import 'alpinejs';
// import Cookies from 'js-cookie';
import Vue from 'vue';

// Vue Components

import Example from '../vue/Example.vue';

new Vue({
	el: '#app',
	components: {
		Example
	}
});

// Modules

import { exampleModule } from './modules/example';
import { lazyLoadModule } from './modules/lazyLoad';

exampleModule();
lazyLoadModule();