import 'alpinejs';
import Cookies from 'js-cookie';

document.documentElement.classList.remove('no-js');

// Modules

import { exampleModule } from './modules/example';
import { lazyLoadModule } from './modules/lazyLoad';

// Exports

exampleModule();
lazyLoadModule();

// Global Exports

window.Cookies = Cookies