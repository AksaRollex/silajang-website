import './bootstrap'

import { createApp } from "vue";
import { createPinia } from "pinia";
import { Tooltip } from "bootstrap";
import App from "./App.vue";

/*
TIP: To get started with clean router change path to @/router/clean.ts.
 */
import router from "./router";
import ElementPlus from "element-plus";
import i18n from "@/core/plugins/i18n";

//imports for app initialization
import ApiService from "@/core/services/ApiService";
import { initApexCharts } from "@/core/plugins/apexcharts";
import { initInlineSvg } from "@/core/plugins/inline-svg";
import { initVeeValidate } from "@/core/plugins/vee-validate";
import { initKtIcon } from "@/core/plugins/keenthemes";

import { useThemeStore } from "@/stores/theme";
import { VueQueryPlugin, QueryClient } from "@tanstack/vue-query";
import Vue3Toasity, { type ToastContainerOptions } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { vue3Debounce } from 'vue-debounce'

import CKEditor from "@ckeditor/ckeditor5-vue";
import "ckeditor5-custom-build/build/ckeditor";


const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            refetchOnWindowFocus: false,
            refetchOnmount: false,
            retry: false,
            staleTime: 1000 * 60 * 60 * 1,
            networkMode: "always",
            onError: (err: any) => {
                if (err.response) {
                    if (err.response.status === 401) {
                        window.location.href = "/auth/sign-in"
                    }
                }
            },
        },
        mutations: {
            networkMode: "always",
            onError: (err: any) => {
                if (err.response) {
                    if (err.response.status === 401) {
                        window.location.href = "/auth/sign-in"
                    }
                }
            }
        },
    },
});


const app = createApp(App);

import DatePicker from "@/components/DatePicker.vue";
import FileUpload from "@/components/FileUpload.vue";
import VOtpInput from "vue3-otp-input";
import Select2 from '@/components/Select2.vue';
import Paginate from '@/components/Paginate.vue';
import Switch from '@/components/Switch.vue';

import VueSplide from '@splidejs/vue-splide';
import '@splidejs/vue-splide/css';

app.use(createPinia());
app.use(router);
app.use(ElementPlus);
app.use(VueQueryPlugin, {
    queryClient,
});
app.use(Vue3Toasity, {
    newestOnTop: true,
    pauseOnFocusLoss: false,
    pauseOnHover: false,
    theme: useThemeStore().mode === "system" ? "dark" : useThemeStore().mode
} as ToastContainerOptions);
app.directive('debounce', vue3Debounce({ lock: true }))

app.component("date-picker", DatePicker);
app.component("file-upload", FileUpload);
app.component('v-otp-input', VOtpInput);
app.component('select2', Select2);
app.component('paginate', Paginate);
app.component('vswitch', Switch);

import { Form as VForm, Field, ErrorMessage } from 'vee-validate';

app.component('VForm', VForm);
app.component('Field', Field);
app.component('ErrorMessage', ErrorMessage);
app.use(VueSplide);
app.use(CKEditor);

ApiService.init(app);
initApexCharts(app);
initInlineSvg(app);
initKtIcon(app);
initVeeValidate();

app.use(i18n);

app.directive("tooltip", (el) => {
    new Tooltip(el);
});

app.mount("#app");

$(function () {
    var cssRule = "display:block;width:200px;border-radius: 3px 0 0 3px;padding:3px 15px;background:#108bc3;color:#FFF;font-size: 30px;font-family:Arial, Helvetica, sans-seriffont-weight: bold;";
    var cssRule2 = "display:block;border-radius: 0 3px 3px 0;padding:3px 15px;background:#fff;color:#666;font-size: 30px;font-family:Arial, Helvetica, sans-serif;";
    console.log("%cMCFLYON" + "%cSystem, Apps & Website Development", cssRule, cssRule2);
    var cssRule = "border-radius: 3px 0 0 3px;padding:3px 15px;background:#35495e;color:#fff;font-size: 12px;font-weight: bold;";
    var cssRule2 = "border-radius:0px;padding:3px 0px;background:#35495e;color:#FF5722;padding-left:0px;font-size: 12px;font-weight: bold;";
    var cssRule3 = "border-radius: 0 3px 3px 0;padding:3px 15px;background:#35495e;color:#108bc3;font-size: 12px;font-weight: bold;";
    console.log("%cThis System Development by Mcflyon Teknologi Indonesia visit" + "%c@" + "%chttps://www.mcflyon.co.id", cssRule, cssRule2, cssRule3);
});
