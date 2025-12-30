import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

// FORCE EAGER LOAD + DEBUG
const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });

createInertiaApp({
    resolve: (name) => {
        const path = `./Pages/${name}.vue`;
        console.log('%c[Inertia] Resolving:', 'color: cyan; font-weight: bold', name);
        console.log('%c[Inertia] Looking for:', 'color: yellow', path);
        console.log('%c[Inertia] All pages:', 'color: lime', Object.keys(pages));

        if (!pages[path]) {
            throw new Error(`Page ${path} not found! Available: ${Object.keys(pages).join(', ')}`);
        }

        const page = pages[path];
        return typeof page === 'function' ? page() : page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});