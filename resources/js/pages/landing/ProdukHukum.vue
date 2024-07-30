<template>
    <main>
        <header class="py-20 my-20 text-brand text-center">
            <h1 class="fs-6x fw-bolder">{{ $t('produk-hukum.heading') }}</h1>
            <h4 class="fw-normal">{{ $t('produk-hukum.tagline') }}</h4>
            <div class="mx-auto bg-brand py-1 mt-10 d-inline-block w-100px"></div>
        </header>

        <section class="mb-20 container px-5">
            <h2>{{ data?.nama }}</h2>
            <section v-html="data?.deskripsi" class="mb-10"></section>
            <div class="row row-gap-8">
                <div v-for="item in data?.items" :key="item.id" class="col-lg-4 col-md-6">
                    <a :href="item.file" target="_blank"
                        class="border-0 border-brand border-left-5 border-start card fs-2 fw-medium h-100">
                        <div class="card-body d-flex justify-content-between flex-column gap-4 px-8 py-6">
                            <div style="line-height: 1.4;" class="mb-4">{{ item.nama }} {{ item.nomor }}</div>
                            <div v-if="item.file" class="d-flex align-items-center justify-content-between gap-4">
                                <img src="/media/peraturan.png" class="w-40px">
                                <i class="fa fa-chevron-right fs-2"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>
</template>

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
    }
}

.card {
    i {
        transition: 0.2s;
    }

    &:hover {
        i {
            color: #071437;
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
        currentLang() {
            return localStorage.getItem("lang") || "id";
        },
        getData() {
            block(this.$el)

            axios.get(`/konfigurasi/produk-hukum/${this.route.params.slug}`).then(res => {
                this.data = res.data.data
            }).finally(() => {
                unblock(this.$el)
            })
        }
    },
    mounted() {
        this.getData()
    },
    watch: {
        route: {
            handler() {
                this.getData()
            },
            deep: true,
        },
    }
})
</script>
