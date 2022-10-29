import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import Notifications from '@kyvg/vue3-notification'
import { createPinia } from 'pinia'
import vSelect from 'vue-select'

import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import AuthenticatedPrint from '@/Layouts/Print.vue';
import Guest from '@/Layouts/Guest.vue';


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'
const pinia = createPinia()

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.then((module) => {
            if (name.startsWith('Auth') || name.startsWith('Welcome')) {
                module.default.layout = module.default.layout || Guest;
            }else if(name.startsWith('Print')){
                module.default.layout = module.default.layout || AuthenticatedPrint;
            }else{
                module.default.layout = module.default.layout || AuthenticatedLayout;
            }
        });
        return page;
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Notifications)
            .use(pinia)
            .component('v-select', vSelect)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#581c87', showSpinner: true });
