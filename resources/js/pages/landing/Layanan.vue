<template>
    <main class="container">
        <header class="py-20 my-20 text-brand text-center">
            <h1 class="fs-6x fw-bolder">
                {{ currentLang() === 'id' ? data?.nama : data?.nama_en }}
            </h1>
            <div class="mx-auto bg-brand py-1 mt-10 d-inline-block w-100px"></div>
        </header>

        <section class="mb-20" id="description">
            <article v-if="currentLang() === 'id'" style="white-space: pre-line" v-html="data?.deskripsi"></article>
            <article v-if="currentLang() === 'en'" style="white-space: pre-line" v-html="data?.deskripsi_en"></article>
        </section>
    </main>
</template>

<style>
section article figure {
    margin: 0;
    padding: 0;
    text-align: center;
}

section article img {
    max-width: 100%;
    height: auto;
}
</style>

<style lang="scss" scoped>
header {
    position: relative;
    overflow: hidden;

    >* {
        position: relative;
        z-index: 1;
    }

    &::before {
        content: '';
        position: absolute;
        width: 75%;
        aspect-ratio: 1;
        border-radius: 50%;
        background-color: #f3f4f6;
        bottom: 0;
        left: 50%;
        transform: translate(-50%, 75%);
        z-index: 0;

        @media (max-width: 768px) {
            width: 100%;
            transform: translate(-50%, 50%);
        }
    }
}
</style>

<script lang="ts">
import axios from '@/libs/axios'
import { block, unblock } from '@/libs/utils'
import { defineComponent, ref } from 'vue'
import { useRoute } from 'vue-router'

export default defineComponent({
    setup() {
        const route = useRoute()
        const data = ref<any>({})

        return {
            route,
            data,
        }
    },
    methods: {
        getData() {
            block(this.$el)

            axios.get(`/konfigurasi/layanan/${this.route.params.slug}`).then(res => {
                this.data = res.data.data
            }).finally(() => {
                unblock(this.$el)
            })
        },
        currentLang() {
            return localStorage.getItem("lang") || "id";
        },
        mapImageToLightbox() {
            const images = document.querySelectorAll('section#description article img')
            images.forEach((image: any) => {
                var a = document.createElement("a");
                a.setAttribute("data-fslightbox", "gallery");
                a.setAttribute("href", image.src);
                a.style.cursor = "zoom-in"

                // Wrap image with anchor tag
                image.parentNode.insertBefore(a, image);
                a.appendChild(image);
            })

            refreshFsLightbox() // from window
        }
    },
    mounted() {
        this.getData()
        this.mapImageToLightbox()
    },
    watch: {
        route: {
            handler() {
                this.getData()
            },
            deep: true,
        },
        data() {
            this.$nextTick(() => {
                this.mapImageToLightbox()
            })
        },
    },
})
</script>
