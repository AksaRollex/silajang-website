<template>
    <main v-if="user?.role.name === 'customer'">
        <div class="d-flex justify-content-end mb-5">
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tahuns"
                v-model="tahun">
            </select2>
        </div>
        <div class="card mb-10">
            <!--begin::Heading-->
            <div
                class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-200px bg-primary">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column text-white pt-10">
                    <span class="fw-bold fs-2x">Dashboard</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Heading-->

            <!--begin::Body-->
            <div class="card-body mt-n20">
                <!--begin::Stats-->
                <div class="mt-n20 position-relative">
                    <!--begin::Row-->
                    <div class="row g-3 g-lg-6">
                        <!--begin::Col-->
                        <div class="col-sm-6">
                            <!--begin::Items-->
                            <div
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-info border-left-5 border-start">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-profile-user fs-2x text-info">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                            <i class="path4"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-info fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ data.permohonanBaru
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Permohonan Baru</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-sm-6">
                            <!--begin::Items-->
                            <div
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-warning border-left-5 border-start">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-abstract-46 fs-2x text-warning">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-warning fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                        data.permohonanDiproses
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Permohonan Diproses</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-sm-6">
                            <!--begin::Items-->
                            <div
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-success border-left-5 border-start">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-book-square fs-2x text-success">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-success fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                        data.permohonanSelesai
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Permohonan Selesai</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-sm-6">
                            <!--begin::Items-->
                            <div
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-primary border-left-5 border-start">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-wallet fs-2x text-primary">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                            <i class="path4"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-primary fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                        data.permohonanTotal
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Total Permohonan</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Body-->
        </div>

        <!-- <div class="card mb-10">
            <div class="card-header align-items-center">
                <h3 class="mb-0 text-gray-700">Grafik Tren Permohonan</h3>
            </div>
            <div class="card-body">
                <apexchart class="d-none d-md-block" v-if="data.chartPermohonans" type="area" :options="{
                    chart: {
                        id: 'chart-tren-permohonan', zoom: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#5b3eff', '#50cd89', '#ffc700', '#838eff'],
                    xaxis: { categories: data.chartPermohonans.categories }
                }" :series="[
    {
        name: 'Total Permohonan',
        data: data.chartPermohonans.data.total
    },
    {
        name: 'Permohonan Selesai',
        data: data.chartPermohonans.data.selesai
    },
    {
        name: 'Permohonan Diproses',
        data: data.chartPermohonans.data.diproses
    },
    {
        name: 'Permohonan Baru',
        data: data.chartPermohonans.data.baru
    },
]"></apexchart>

                <apexchart class="d-md-none" v-if="data.chartPermohonans" type="area" :options="{
                    chart: {
                        id: 'chart-tren-permohonan', zoom: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#838eff'],
                    xaxis: { categories: data.chartPermohonans.categories }
                }" :series="[
    {
        name: 'Permohonan Baru',
        data: data.chartPermohonans.data.baru
    },
]"></apexchart>
                <apexchart class="d-md-none" v-if="data.chartPermohonans" type="area" :options="{
                    chart: {
                        id: 'chart-tren-permohonan', zoom: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#ffc700'],
                    xaxis: { categories: data.chartPermohonans.categories }
                }" :series="[
    {
        name: 'Permohonan Diproses',
        data: data.chartPermohonans.data.diproses
    },
]"></apexchart>
                <apexchart class="d-md-none" v-if="data.chartPermohonans" type="area" :options="{
                    chart: {
                        id: 'chart-tren-permohonan', zoom: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#50cd89'],
                    xaxis: { categories: data.chartPermohonans.categories }
                }" :series="[
    {
        name: 'Permohonan Selesai',
        data: data.chartPermohonans.data.selesai
    },
]"></apexchart>
                <apexchart class="d-md-none" v-if="data.chartPermohonans" type="area" :options="{
                    chart: {
                        id: 'chart-tren-permohonan', zoom: {
                            enabled: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#5b3eff'],
                    xaxis: { categories: data.chartPermohonans.categories }
                }" :series="[
    {
        name: 'Total Permohonan',
        data: data.chartPermohonans.data.total
    },
]"></apexchart>
            </div>
        </div> -->
    </main>
    <main v-else>
        <div class="d-flex justify-content-end mb-5">
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tahuns"
                v-model="tahun">
            </select2>
        </div>
        <div class="card mb-10">
            <!--begin::Heading-->
            <div
                class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-200px bg-primary">
                <!--begin::Title-->
                <h3 class="card-title align-items-start flex-column text-white pt-10">
                    <span class="fw-bold fs-2x">Dashboard</span>
                </h3>
                <!--end::Title-->
            </div>
            <!--end::Heading-->

            <!--begin::Body-->
            <div class="card-body mt-n20">
                <!--begin::Stats-->
                <div class="mt-n20 position-relative">
                    <!--begin::Row-->
                    <div class="row g-3 g-lg-6">
                        <!--begin::Col-->
                        <div v-if="['admin', 'kepala-upt'].includes(user.role.name)" class="col-sm-6">
                            <!--begin::Items-->
                            <div
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-info border-left-5 border-start">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-profile-user fs-2x text-info">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                            <i class="path4"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-info fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ data.customers
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Customer</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div v-if="['admin', 'kepala-upt', 'koordinator-administrasi'].includes(user.role.name)"
                            class="col-sm-6">
                            <!--begin::Items-->
                            <div
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-primary border-left-5 border-start">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-book-square fs-2x text-primary">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-primary fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ data.allSampels
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Total Permohonan</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div v-if="['admin', 'kepala-upt', 'koordinator-administrasi'].includes(user.role.name)"
                            class="col-sm-6">
                            <!--begin::Items-->
                            <router-link to="/dashboard/administrasi/persetujuan"
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-warning border-left-5 border-start d-block">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-abstract-46 fs-2x text-warning">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-warning fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ data.newSampels
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Persetujuan Permohonan</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </router-link>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div v-if="['admin', 'kepala-upt', 'koordinator-administrasi'].includes(user.role.name)"
                            class="col-sm-6">
                            <!--begin::Items-->
                            <router-link to="/dashboard/verifikasi/analis"
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-danger border-left-5 border-start d-block">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-book-square fs-2x text-danger">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-danger fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{ data.undoneSampels
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Sampel Belum Dianalisa</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </router-link>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div v-if="['admin', 'kepala-upt', 'koordinator-teknis'].includes(user.role.name)" class="col-sm-6">
                            <!--begin::Items-->
                            <router-link to="/dashboard/verifikasi/koordinator-teknis"
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-danger border-left-5 border-start d-block">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-book-square fs-2x text-danger">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-danger fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                        data.unverifSampels
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Dokumen Belum Diverifikasi</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </router-link>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div v-if="['admin', 'kepala-upt', 'koordinator-teknis', 'koordinator-administrasi'].includes(user.role.name)"
                            class="col-sm-6">
                            <!--begin::Items-->
                            <router-link to="/dashboard/pembayaran/global"
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-success border-left-5 border-start d-block">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-30px me-5 mb-8">
                                    <span class="symbol-label">
                                        <i class="ki-duotone ki-wallet fs-2x text-success">
                                            <i class="path1"></i>
                                            <i class="path2"></i>
                                            <i class="path3"></i>
                                            <i class="path4"></i>
                                        </i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Stats-->
                                <div class="m-0">
                                    <!--begin::Number-->
                                    <span class="text-success fw-bolder d-block fs-2qx lh-1 ls-n1 mb-1">{{
                                        currency(data.revenue)
                                    }}</span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Pendapatan</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </router-link>
                            <!--end::Items-->
                        </div>
                        <!--end::Col-->

                        <div class="separator my-10"></div>

                        <div class="col-sm-6">
                            <router-link to="/dashboard/konfigurasi/umpan-balik"
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-left-5 border-start d-block"
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
                                        {{ data.total?.toFixed(2) }}
                                    </span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">IKM Unit Pelayanan</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </router-link>
                        </div>
                        <div class="col-sm-6">
                            <router-link to="/dashboard/konfigurasi/umpan-balik"
                                class="bg-gray-100 bg-opacity-70 rounded-2 px-6 py-5 border-left-5 border-start d-block"
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
                                        {{ data?.jumlah }}
                                    </span>
                                    <!--end::Number-->

                                    <!--begin::Desc-->
                                    <span class="text-gray-500 fw-semibold fs-6">Jumlah Responden</span>
                                    <!--end::Desc-->
                                </div>
                                <!--end::Stats-->
                            </router-link>
                        </div>
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Body-->
        </div>

        <div class="card mb-10">
            <div class="card-header align-items-center">
                <h3 class="mb-0 text-gray-700">Grafik Tren Permohonan</h3>
            </div>
            <div class="card-body">
                <apexchart v-if="data.chartSampels" type="area" :options="{
                    chart: {
                        height: 600,
                        id: 'chart-tren-permohonan', zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: { categories: data.chartSampels.categories }
                }" :series="[
    {
        name: 'Permohonan Sampel',
        data: data.chartSampels.data
    }
]"></apexchart>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-10">
                    <div class="card-header align-items-center">
                        <h3 class="mb-0 text-gray-700">{{ data.chartPeraturans?.data?.length > 1 ?
                            data.chartPeraturans?.data?.length : '' }} Peraturan Paling Banyak Digunakan</h3>
                    </div>
                    <div class="card-body">
                        <apexchart v-if="data.chartPeraturans" type="donut" :options="{
                            chart: {
                                id: 'chart-peraturan', zoom: {
                                    enabled: false
                                }
                            },
                            labels: data.chartPeraturans.categories,
                            legend: {
                                position: 'bottom',
                            },
                        }" :series="data.chartPeraturans.data"></apexchart>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-10">
                    <div class="card-header align-items-center">
                        <h3 class="mb-0 text-gray-700">{{ data.chartParameters?.data?.length > 1 ?
                            data.chartParameters?.data?.length : '' }} Parameter Paling Banyak Digunakan</h3>
                    </div>
                    <div class="card-body">
                        <apexchart v-if="data.chartParameters" type="donut" :options="{
                            chart: {
                                id: 'chart-peraturan', zoom: {
                                    enabled: false
                                }
                            },
                            labels: data.chartParameters.categories,
                            legend: {
                                position: 'bottom'
                            },
                        }" :series="data.chartParameters.data"></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script lang="ts">
import axios from "@/libs/axios";
import { block, unblock, currency } from "@/libs/utils";
import { useAuthStore } from "@/stores/auth";
import { defineComponent, ref } from "vue";

export default defineComponent({
    name: "main-dashboard",
    setup() {
        const { user } = useAuthStore();

        const tahun = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahun.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const data = ref<any>({});

        return {
            tahun,
            tahuns,
            data,
            currency,
            user
        };
    },
    methods: {
        getData(type: 'admin' | 'customer') {
            block(this.$el);

            axios.post('/dashboard/' + type, { tahun: this.tahun }).then(res => {
                this.data = res.data;
            }).finally(() => {
                unblock(this.$el);
            })
        }
    },
    mounted() {
        if (this.user.role?.name === 'customer') {
            this.getData('customer')
        } else {
            this.getData('admin');
        }
    },
    watch: {
        tahun() {
            if (this.user.role?.name === 'customer') {
                this.getData('customer')
            } else {
                this.getData('admin');
            }
        }
    }
});
</script>
