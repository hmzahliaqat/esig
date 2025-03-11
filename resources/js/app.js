import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// Import PrimeVue and PrimeIcons
import PrimeVue from "primevue/config";
import "primeicons/primeicons.css"; // This is required for the icons
import Button from "primevue/button"; // Example component, you can import others as needed
import InputText from "primevue/inputtext"; // Example of another component (InputText)
import ToastService from "primevue/toastservice"; // Example: Toast service for notifications

// Optionally, import a theme
import "primeicons/primeicons.css";
import Aura from "@primeuix/themes/aura";

// Import Pinia
import { createPinia } from "pinia";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Use Pinia for state management
        app.use(createPinia()) // Add Pinia to the app

            // Use PrimeVue and the desired components
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,
                    options: {
                        prefix: "p",
                        darkModeSelector: "system",
                        cssLayer: false,
                    },
                },
            })
            .use(ToastService) // Register Toast service globally
            .component("Button", Button) // Register Button globally
            .component("InputText", InputText) // Register InputText globally

            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
