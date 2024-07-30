<template>
    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Rekap Data</h2>
            <div>
                <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex gap-10 mb-10">
                <div class="form-group">
                    <label class="form-label">Tipe Pengambilan/Pengiriman</label>
                    <select2 class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tipeMandiris"
                        v-model="isMandiri">
                    </select2>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipe User</label>
                    <select2 class="form-select-solid mw-200px mw-md-100" name="tahun" :options="golongans"
                        v-model="golonganId">
                    </select2>
                </div>
            </div>

            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light rounded-bottom-0 active" data-bs-toggle="tab"
                        href="#tab-sampel-permohonan">Sampel Permohonan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light rounded-bottom-0" data-bs-toggle="tab"
                        href="#tab-total-biaya">Total Biaya</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link btn btn-active-light rounded-bottom-0" data-bs-toggle="tab"
                        href="#tab-metode">Metode</a>
                </li> -->
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-sampel-permohonan" role="tabpanel">
                    <div class="d-flex mb-5">
                        <button class="btn btn-sm btn-danger ms-auto" @click="downloadReport('sampel-permohonan')">
                            <i class="la la-file-pdf fs-2"></i>
                            Cetak
                        </button>
                    </div>

                    <paginate ref="paginate" id="table-sampel-permohonan" url="/report/rekap"
                        :columns="columnsSampelPermohonan" queryKey="sampel-permohonan"
                        :payload="{ start, end, is_mandiri: isMandiri, golongan_id: golonganId }">
                    </paginate>
                </div>
                <div class="tab-pane fade" id="tab-total-biaya" role="tabpanel">
                    <div class="d-flex mb-5">
                        <button class="btn btn-sm btn-danger ms-auto" @click="downloadReport('total-biaya')">
                            <i class="la la-file-pdf fs-2"></i>
                            Cetak
                        </button>
                    </div>

                    <paginate ref="paginate" id="table-total-biaya" url="/report/rekap" :columns="columnsTotalBiaya"
                        queryKey="total-biaya" :payload="{ start, end, is_mandiri: isMandiri, golongan_id: golonganId }">
                    </paginate>
                </div>
                <!-- <div class="tab-pane fade" id="tab-metode" role="tabpanel">
                    <div id="chart-metode" class="mw-500px mb-10">
                        <apexchart v-if="metode.data" type="donut" :options="{
                            chart: {
                                id: 'chart-metode', zoom: {
                                    enabled: false
                                }
                            },
                            labels: metode.categories,
                            legend: {
                                position: 'bottom',
                            },
                        }" :series="metode.data"></apexchart>
                    </div>

                    <div class="d-flex mb-5">
                        <button class="btn btn-sm btn-danger ms-auto" @click="downloadReport('metode')">
                            <i class="la la-file-pdf fs-2"></i>
                            Cetak
                        </button>
                    </div>

                    <paginate ref="paginate" id="table-metode" url="/report/rekap" :columns="columnsMetode"
                        queryKey="metode" :payload="{ tahun: tahun, is_mandiri: isMandiri, golongan_id: golonganId }">
                    </paginate>
                </div> -->
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-report">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-auto" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <iframe :src="reportUrl" frameborder="0" class="w-100 h-700px" ref="iframeReport"
                        @load="unblock('#modal-report .modal-body')"></iframe>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDownloadPdf } from "@/libs/hooks";

interface TitikPermohonan {
    no: number,
    uuid: string,
    kode: string,
    lokasi: string,
    tgl_diterima: string,
    tgl_selesai: string,
    status: number,
    pembayaran: number,
    tanggal_pengambilan: string,
    tanggal_selesai: string,
    text_status: string,
    status_pembayaran: number,
    text_status_pembayaran: string,
    harga: number,
    is_has_subkontrak: boolean,
    nama_pengambil: string,
    tanggal_diterima: string,
    pengambil?: {
        nama: string,
    },
    permohonan: {
        is_mandiri: boolean | number,
        user: {
            nama: string,
        }
    },
    acuan_metode: {
        nama: string,
    }
}
import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<TitikPermohonan>();

import { usePreviewReport } from '@/stores';
import { block, currency, unblock } from '@/libs/utils';
import axios from '@/libs/axios';
import moment from 'moment';

export default defineComponent({
    setup() {
        const iframeReport = ref<any>(null);
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");
        const { download: downloadPdf } = useDownloadPdf();

        const paginate = ref<any>(null);

        const selected = ref<string | any>("");
        const openDetail = ref<boolean>(false);

        const date = ref<any>(`${moment().startOf('month').format('YYYY-MM-DD')} to ${moment().format('YYYY-MM-DD')}`)
        const tahun = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahun.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const isMandiri = ref<any>('-');
        const tipeMandiris = ref<any[]>([
            { id: '-', text: 'Semua' },
            { id: 0, text: 'Diambil Petugas' },
            { id: 1, text: 'Dikirim Mandiri' },
        ]);

        const golonganId = ref<any>('-');
        const golongans = ref<any[]>([
            { id: '-', text: 'Semua' },
            { id: 1, text: 'Customer' },
            { id: 2, text: 'Dinas Internal' },
        ]);

        const columnsSampelPermohonan = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("kode", {
                header: "Kode",
                cell: cell => h('div', {
                    style: {
                        whiteSpace: 'nowrap'
                    }
                }, [cell.getValue()])
            }),
            column.accessor("permohonan", {
                header: "Pelanggan",
                cell: cell => cell.getValue().user.nama
            }),
            column.accessor("lokasi", {
                header: "Titik Uji/Lokasi",
            }),
            column.accessor("text_status", {
                header: "Status",
                cell: cell => h('div', [
                    h('span', { class: 'badge badge-light-primary' }, cell.getValue())
                ])
            }),
            column.accessor("tanggal_diterima", {
                header: "Tanggal Diterima",
            }),
            column.accessor("tanggal_selesai", {
                header: "Tanggal Selesai",
            }),
        ]

        const columnsTotalBiaya = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("kode", {
                header: "Kode",
                cell: cell => h('div', {
                    style: {
                        whiteSpace: 'nowrap'
                    }
                }, [cell.getValue()])
            }),
            column.accessor("permohonan", {
                header: "Pelanggan",
                cell: cell => cell.getValue().user.nama
            }),
            column.accessor("lokasi", {
                header: "Titik Uji/Lokasi",
            }),
            column.accessor("text_status", {
                header: "Status",
                cell: cell => h('div', [
                    h('span', { class: 'badge badge-light-primary' }, cell.getValue())
                ])
            }),
            column.accessor("harga", {
                header: "Harga",
                cell: cell => cell.row.original.permohonan.user.golongan_id == 1 ? currency(cell.getValue()) : '-'
            }),
            column.accessor("permohonan", {
                header: "Jasa Pengambilan",
                cell: cell => (cell.getValue().jasa_pengambilan?.harga && cell.row.original.permohonan.user.golongan_id == 1) ? currency(cell.getValue().jasa_pengambilan?.harga) : '-'
            }),
            column.accessor("harga", {
                header: "Total Biaya",
                cell: cell => cell.row.original.permohonan.user.golongan_id == 1 ? currency(cell.getValue() + (cell.row.original.permohonan.jasa_pengambilan?.harga || 0)) : '-'
            }),
        ]

        const columnsMetode = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("kode", {
                header: "Kode",
                cell: cell => h('div', {
                    style: {
                        whiteSpace: 'nowrap'
                    }
                }, [cell.getValue()])
            }),
            column.accessor("permohonan", {
                header: "Pelanggan",
                cell: cell => cell.getValue().user.nama
            }),
            column.accessor("lokasi", {
                header: "Titik Uji/Lokasi",
            }),
            column.accessor("text_status", {
                header: "Status",
                cell: cell => h('div', [
                    h('span', { class: 'badge badge-light-primary' }, cell.getValue())
                ])
            }),
            column.accessor("acuan_metode", {
                header: "Metode",
                cell: cell => cell.getValue().nama
            }),
        ]

        const metode = ref<any>({});

        return {
            iframeReport,
            downloadPdf,
            previewReport,
            metode,
            columnsSampelPermohonan,
            columnsTotalBiaya,
            columnsMetode,
            selected,
            openDetail,
            paginate,
            tahun,
            tahuns,
            reportUrl,
            block, unblock,
            isMandiri,
            tipeMandiris,
            golonganId,
            golongans,
            date,
            refresh: () => {
                paginate.value.refetch()
            },
        }
    },
    methods: {
        getMetode() {
            block("#chart-metode");

            axios.post("/report/rekap/metode", { start: this.start, end: this.end, golongan_id: this.golonganId, is_mandiri: this.isMandiri }).then(res => {
                this.metode = res.data;

                unblock("#chart-metode");
            })
        },
        downloadReport(mode) {
            if (this.previewReport) {
                this.block('#modal-report .modal-body')
                this.reportUrl = `/api/v1/report/rekap?token=${localStorage.getItem('auth_token')}&start=${this.start}&end=${this.end}&is_mandiri=${this.isMandiri}&golongan_id=${this.golonganId}&mode=${mode}`

                this.iframeReport.contentWindow.location.reload()
                $('#modal-report').modal('show')
            } else {
                this.downloadPdf(`/report/rekap?start=${this.start}&end=${this.end}&is_mandiri=${this.isMandiri}&golongan_id=${this.golonganId}&mode=${mode}`)
            }
        }
    },
    mounted() {
        this.getMetode();
    },
    watch: {
        openDetail(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        },
        tahun() {
            this.getMetode();
        },
        golonganId() {
            this.getMetode();
        },
        isMandiri() {
            this.getMetode();
        }
    },
    computed: {
        start() {
            return this.date.split(' to ')[0]
        },
        end() {
            return this.date.split(' to ')[1]
        }
    }
})
</script>
