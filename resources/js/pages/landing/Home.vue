<template>
    <main>
        <Splide :options="{ rewind: true, autoplay: true }">
            <SplideSlide v-for="banner in banners" :key="banner.uuid">
                <img v-if="!banner.link" :src="banner.gambar" :alt="banner.judul" class="banner-img">
                <a v-else :href="banner.link" target="_blank">
                    <img :src="banner.gambar" :alt="banner.judul" class="banner-img">
                </a>
            </SplideSlide>
        </Splide>

        <section class="py-20">
            <div class="d-flex flex-column mb-10">
                <h1 class="text-center fs-2x">{{ $t('beranda.umpan-balik') }}</h1>
                <div class="mx-auto bg-dark h-4px mt-5 d-inline-block w-100px"></div>
            </div>
            <div class="container-md mw-600px">
                <div class="row row-gap-8">
                    <div class="col-sm-6">
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-left-5 border-start"
                            style="border-left-color: #378EA6 !important;">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-medal-star fs-2x" style="color: #378EA6">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Stats-->
                            <div class="m-0">
                                <!--begin::Number-->
                                <span class="fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1" style="color: #378EA6;">
                                    {{ umpanBalik.ikm?.toFixed(2) }}
                                </span>
                                <!--end::Number-->

                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-6">{{ $t('beranda.ikm') }}</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Stats-->
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-left-5 border-start"
                            style="border-left-color: #378EA6 !important;">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-30px me-5 mb-8">
                                <span class="symbol-label">
                                    <i class="ki-duotone ki-tablet-text-down fs-2x" style="color: #378EA6;">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                            </div>
                            <!--end::Symbol-->

                            <!--begin::Stats-->
                            <div class="m-0">
                                <!--begin::Number-->
                                <span class="fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1" style="color: #378EA6;">
                                    {{ umpanBalik.data?.jumlah }}
                                </span>
                                <!--end::Number-->

                                <!--begin::Desc-->
                                <span class="text-gray-500 fw-semibold fs-6">{{ $t('beranda.responden') }}</span>
                                <!--end::Desc-->
                            </div>
                            <!--end::Stats-->
                        </div>
                    </div>

                    <div class="col-12 mt-10">
                        <apexchart v-if="umpanBalik.data" type="line" :options="{
                            chart: {
                                id: 'chart-umpan-balik', zoom: {
                                    enabled: false
                                }
                            },
                            xaxis: {
                                categories: ['U1', 'U2', 'U3', 'U4', 'U5', 'U6', 'U7', 'U8', 'U9']
                            },
                            legend: {
                                position: 'bottom'
                            },
                            dataLabels: {
                                enabled: true,
                                enabledOnSeries: [0, 1]
                            },
                            colors: ['#378EA6', '#ffc700']
                        }" :series="chartSeries"></apexchart>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <table border="0">
                            <tr v-for="keterangan in umpanBalik.keterangan" :key="keterangan.id">
                                <td class="text-end">
                                    <strong>{{ keterangan.kode.toUpperCase() }}</strong>
                                </td>
                                <td>:</td>
                                <td>{{ keterangan.keterangan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<style lang="scss" scoped>
.banner-img {
    width: 100%;
    object-fit: cover;
    aspect-ratio: 16/9;
}
</style>

<script lang="ts">
import axios from "@/libs/axios";
import { block, unblock } from "@/libs/utils";
import { useBanner, useSetting } from "@/services";
import { useAuthStore } from "@/stores/auth";
import { defineComponent, ref } from "vue";

export default defineComponent({
    name: "home",
    setup() {
        const navbar = ref<HTMLElement | null>(null);
        const { user = {}, isAuthenticated } = useAuthStore();
        const { data: setting = {} } = useSetting();

        const { data: banners = [] } = useBanner();

        const umpanBalik = ref<any>({});

        return {
            navbar,
            user,
            isAuthenticated,
            setting,
            banners,
            umpanBalik,
        };
    },
    methods: {
        getUmpanBalik() {
            block(this.$el)

            axios.post('/konfigurasi/umpan-balik/show', {
                tahun: new Date().getFullYear(),
                bulan: new Date().getMonth() + 1,
            }).then(res => {
                this.umpanBalik = res.data
            }).finally(() => {
                unblock(this.$el)
            })
        },
    },
    computed: {
        chartSeries() {
            return [
                {
                    data: [parseFloat(this.umpanBalik.data?.u1).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u2).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u3).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u4).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u5).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u6).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u7).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u8).toFixed(2) ?? 0, parseFloat(this.umpanBalik.data?.u9).toFixed(2) ?? 0],
                    name: 'NRR Per Unsur',
                    type: 'column',
                },
            ]
        }
    },
    mounted() {
        this.getUmpanBalik()
    },
});
</script>