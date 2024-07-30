<template>
    <main>
        <div class="card mb-10">
            <div class="card-header align-items-center gap-4 py-8 py-sm-0">
                <h2 class="mb-0">Umpan Balik</h2>
                <div class="d-flex gap-4">
                    <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun"
                        :options="tahuns" v-model="tahun">
                    </select2>
                    <select2 placeholder="Pilih Bulan" class="form-select-solid mw-200px mw-md-100" name="bulan"
                        :options="bulans" v-model="bulan">
                    </select2>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-4">
                    <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-import">
                        <i class="la la-file-upload fs-2"></i>
                        Import Data
                    </button>
                </div>
                <div class="row row-gap-10">
                    <div class="col-md-6 col-lg-4">
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
                                            {{ data.ikm?.toFixed(2) }}
                                        </span>
                                        <!--end::Number-->

                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-semibold fs-6">IKM Unit Pelayanan</span>
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
                                            {{ data.data?.jumlah }}
                                        </span>
                                        <!--end::Number-->

                                        <!--begin::Desc-->
                                        <span class="text-gray-500 fw-semibold fs-6">Jumlah Responden</span>
                                        <!--end::Desc-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8">
                        <apexchart v-if="data.data" type="line" :options="{
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
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modal-import">
            <form class="modal-dialog modal-dialog-centered" @submit.prevent="importData">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Import Data Umpan Balik</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold text-dark fs-6 required">File Excel</label>
                            <Field class="form-control form-control-lg form-control-solid" type="text" autocomplete="off"
                                v-model="files">
                                <file-upload v-bind:files="files" :accepted-file-types="fileTypes"
                                    v-on:updatefiles="onUpadateFiles"></file-upload>
                            </Field>
                            <div class="fv-help-block">
                                <ErrorMessage name="nama" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger">Import</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header align-items-center gap-4 py-8 py-sm-0">
                <h2 class="mb-0">Umpan Balik</h2>
                <button @click="downloadTemplate('/konfigurasi/umpan-balik/template')" class="btn btn-light-danger btn-sm">
                    <i class="la la-file-download fs-2"></i>
                    Template Import
                </button>
            </div>
            <div class="card-body">
                <paginate ref="paginate" id="table-umpan-balik" url="/konfigurasi/umpan-balik/keterangan"
                    :columns="columns"></paginate>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="modal-edit">
            <form class="modal-dialog modal-dialog-centered" @submit.prevent="saveUmpanBalik" id="form-edit">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit Keterangan Umpan Balik</h3>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold text-dark fs-6 required">Kode</label>
                            <Field class="form-control form-control-lg form-control-solid" type="text" name="kode"
                                autocomplete="off" v-model="formData.kode" disabled />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="kode" />
                                </div>
                            </div>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold text-dark fs-6 required">Keterangan</label>
                            <Field class="form-control form-control-lg form-control-solid" type="text" name="keterangan"
                                autocomplete="off" v-model="formData.keterangan" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="keterangan" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</template>

<script lang="ts">
import axios from '@/libs/axios';
import { useDownloadExcel } from '@/libs/hooks';
import { block, unblock } from '@/libs/utils';
import { defineComponent, ref, h } from 'vue'

interface KeteranganUmpanBalik {
    no: number,
    uuid: string,
    kode: string,
    keterangan: string,
}

interface FormData {
    uuid: string,
    kode: string,
    keterangan: string,
}

import { createColumnHelper } from "@tanstack/vue-table";
import { toast } from 'vue3-toastify';
const column = createColumnHelper<KeteranganUmpanBalik>();

export default defineComponent({
    setup() {
        const files = ref<Array<File | String>>([])
        const fileTypes = ref(['application/xlsx', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const tahun = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahun.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const bulan = ref(new Date().getMonth() + 1);
        const bulans = ref<any[]>([
            { id: 1, text: 'Januari' },
            { id: 2, text: 'Februari' },
            { id: 3, text: 'Maret' },
            { id: 4, text: 'April' },
            { id: 5, text: 'Mei' },
            { id: 6, text: 'Juni' },
            { id: 7, text: 'Juli' },
            { id: 8, text: 'Agustus' },
            { id: 9, text: 'September' },
            { id: 10, text: 'Oktober' },
            { id: 11, text: 'November' },
            { id: 12, text: 'Desember' },
        ]);

        const { download: downloadTemplate } = useDownloadExcel()

        const data = ref<any>({})

        const formData = ref<FormData>({
            uuid: '',
            kode: '',
            keterangan: '',
        } as FormData)
        const columns = [
            column.accessor("kode", {
                header: "Kode",
                cell: cell => cell.getValue().toUpperCase()
            }),
            column.accessor("keterangan", {
                header: "Keterangan",
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            formData.value = cell.row.original;
                            $('#modal-edit').modal('show');
                        }
                    }, h('i', { class: 'la la-pencil fs-2' })),
                ])
            }),
        ]

        const paginate = ref<any>()

        return {
            tahun,
            tahuns,
            bulan,
            bulans,
            downloadTemplate,
            data,
            columns,
            formData,
            files,
            fileTypes,
            onUpadateFiles,
            paginate
        }
    },
    methods: {
        getData() {
            block(this.$el)

            axios.post('/konfigurasi/umpan-balik/summary', {
                tahun: this.tahun,
                bulan: this.bulan
            }).then(res => {
                this.data = res.data
            }).finally(() => {
                unblock(this.$el)
            })
        },
        saveUmpanBalik() {
            block('#modal-edit .modal-content')

            axios.post(`/konfigurasi/umpan-balik/keterangan/${this.formData.uuid}/update`, new FormData(document.querySelector('#form-edit'))).then(() => {
                $('#modal-edit').modal('hide');
                this.paginate?.refetch();
                toast.success('Data berhasil disimpan')

                this.formData = {
                    uuid: '',
                    kode: '',
                    keterangan: '',
                }
            }).catch(err => {
                toast.error(err.response.data.message)
            }).finally(() => {
                unblock('#modal-edit .modal-content')
            })
        },
        importData() {
            if (!this.files[0]) {
                toast.error('File tidak boleh kosong')
            }

            block('#modal-import .modal-content')

            const formData = new FormData()
            formData.append('tahun', this.tahun)
            formData.append('bulan', this.bulan)
            formData.append('file', this.files[0].file as File)

            axios.post('/konfigurasi/umpan-balik/import', formData).then(() => {
                this.files = []
                $('#modal-import').modal('hide');
                this.getData();
                toast.success('Data berhasil diimport')
            }).catch(err => {
                toast.error(err.response.data.message)
            }).finally(() => {
                unblock('#modal-import .modal-content')
            })
        }
    },
    mounted() {
        this.getData()
    },
    computed: {
        chartSeries() {
            return [
                {
                    data: [parseFloat(this.data.data?.u1).toFixed(2) ?? 0, parseFloat(this.data.data?.u2).toFixed(2) ?? 0, parseFloat(this.data.data?.u3).toFixed(2) ?? 0, parseFloat(this.data.data?.u4).toFixed(2) ?? 0, parseFloat(this.data.data?.u5).toFixed(2) ?? 0, parseFloat(this.data.data?.u6).toFixed(2) ?? 0, parseFloat(this.data.data?.u7).toFixed(2) ?? 0, parseFloat(this.data.data?.u8).toFixed(2) ?? 0, parseFloat(this.data.data?.u9).toFixed(2) ?? 0],
                    name: 'NRR Per Unsur',
                    type: 'column',
                }
            ]
        }
    },
    watch: {
        tahun() {
            this.getData()
        },
        bulan() {
            this.getData()
        }
    }
})
</script>
