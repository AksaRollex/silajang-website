<template>
    <Detail :selected="selected" @close="openDetail = false" v-if="openDetail" @refresh="refresh" />

    <div v-if="!openDetail" class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Pembayaran Pengujian</h2>
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
            <paginate ref="paginate" id="table-konfirmasi" url="/pembayaran/pengujian" :columns="columns"
                queryKey="pengujian-0" :payload="{ tahun, bulan }">
            </paginate>
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

import { usePreviewReport } from '@/stores';
import { block, unblock } from '@/libs/utils';

import Detail from './Detail.vue';

interface TitikPermohonan {
    no: number,
    uuid: string,
    kode: string,
    lokasi: string,
    tgl_diterima: string,
    tgl_selesai: string,
    status: number,
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
    payment: {
        id: number,
        is_expired: boolean,
        status: string,
        is_lunas: boolean,
    },
    status_tte_skrd: boolean,
    status_tte_kwitansi: boolean,
}
import { createColumnHelper } from "@tanstack/vue-table";
import { currency } from '@/libs/utils';
const column = createColumnHelper<TitikPermohonan>();

export default defineComponent({
    components: {
        Detail,
    },
    setup() {
        const paginate = ref<any>(null);

        const selected = ref<string | any>("");
        const openDetail = ref<boolean>(false);

        const tahun = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahun.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const bulan = ref(new Date().getMonth() + 1);
        const bulans = ref<any[]>([
            { id: 1, text: "Januari" },
            { id: 2, text: "Februari" },
            { id: 3, text: "Maret" },
            { id: 4, text: "April" },
            { id: 5, text: "Mei" },
            { id: 6, text: "Juni" },
            { id: 7, text: "Juli" },
            { id: 8, text: "Agustus" },
            { id: 9, text: "September" },
            { id: 10, text: "Oktober" },
            { id: 11, text: "November" },
            { id: 12, text: "Desember" },
        ])

        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");
        const { download: downloadReport } = useDownloadPdf();
        const iframeReport = ref<any>(null);

        const columns = [
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
            column.accessor("lokasi", {
                header: "Titik Uji/Lokasi",
            }),
            column.accessor("harga", {
                header: "Harga",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("payment", {
                header: "Status Pembayaran",
                cell: cell => h('div', [
                    cell.row.original.payment?.is_expired ? h('span', { class: `badge badge-light-danger` }, 'Kedaluwarsa') : h('span', { class: `badge badge-light-${cell.getValue()?.status == 'pending' ? 'info' : (cell.getValue()?.status == 'success' ? 'success' : 'danger')}` }, cell.row.original.text_status_pembayaran)
                ])
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
                    h('button', {
                        class: `btn btn-sm ${cell.row.original.payment?.status === 'success' ? 'btn-light-primary' : 'btn-primary'} d-flex`, onClick: () => {
                            selected.value = cell.getValue();
                            openDetail.value = true;
                        }
                    }, [h('i', { class: 'la la-credit-card fs-2' }), cell.row.original.payment?.status === 'success' ? ' Detail' : ' Pembayaran']),
                    (cell.row.original.status >= 9 || cell.row.original.payment?.status === 'success') && h('button', {
                        class: 'btn btn-sm btn-danger d-flex', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/bukti-pembayaran?token=${localStorage.getItem('auth_token')}`

                                iframeReport.value.contentWindow.location.reload()
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/bukti-pembayaran`)
                            }
                        }, style: {
                            whiteSpace: 'nowrap'
                        }
                    }, [h('i', { class: 'la la-file-pdf fs-2' }), ' Bukti']),
                    !!cell.row.original.payment?.id && cell.row.original.payment?.status !== 'success' && h('button', {
                        class: 'btn btn-sm btn-danger d-flex', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/tagihan-pembayaran?token=${localStorage.getItem('auth_token')}`

                                iframeReport.value.contentWindow.location.reload()
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/tagihan-pembayaran`)
                            }
                        }, style: {
                            whiteSpace: 'nowrap'
                        }
                    }, [h('i', { class: 'la la-file-pdf fs-2' }), ' Tagihan']),
                    (cell.row.original.status_tte_skrd == 1 || cell.row.original.status_tte_kwitansi == 1) && h('div', { class: 'dropup' }, [
                        h('button', {
                        class: 'btn btn-sm btn btn-light-danger',
                        'data-bs-toggle': 'dropdown',
                        }, [
                        h('i', { class: 'la la-file-pdf me-0 fs-2' }),
                        h('span', { class: 'd-none d-md-inline me-2' }, 'PDF'),
                        h('i', { class: 'la la-angle-down me-0 fs-2' }),
                        ]),
                        h('div', {
                        class: 'dropdown-menu',
                        }, [
                        cell.row.original.status_tte_skrd == 1 && h('div', { class: 'dropdown-item px-3' }, [
                            h('button', {
                            class: 'btn btn-sm w-100 text-start btn-light-primary', onClick: () => {
                                if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/skrd?token=${localStorage.getItem('auth_token')}`

                                iframeReport.value.contentWindow.location.reload()
                                $('#modal-report').modal('show')
                                } else {
                                downloadReport(`/report/${cell.getValue()}/skrd`)
                                }
                            }
                            }, [
                            h('i', { class: 'la la-file-pdf fs-2' }),
                            h('span', { class: 'd-none d-md-inline' }, 'SKRD')
                            ]),
                        ]),
                        cell.row.original.status_tte_kwitansi == 1 && cell.row.original.payment?.is_lunas == 1 && h('div', { class: 'dropdown-item px-3' }, [
                            h('button', {
                            class: 'btn btn-sm w-100 text-start btn-light-warning', onClick: () => {
                                if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/kwitansi?token=${localStorage.getItem('auth_token')}`

                                iframeReport.value.contentWindow.location.reload()
                                $('#modal-report').modal('show')
                                } else {
                                downloadReport(`/report/${cell.getValue()}/kwitansi`)
                                }
                            }
                            }, [
                            h('i', { class: 'la la-file-pdf fs-2' }),
                            h('span', { class: 'd-none d-md-inline' }, 'Kwitansi')
                            ]),
                        ]),
                    ])
                ])
                ])
            }),
        ]

        return {
            columns,
            selected,
            openDetail,
            paginate,
            tahun,
            tahuns,
            bulan,
            bulans,
            reportUrl,
            block, unblock,
            downloadReport,
            previewReport,
            refresh: () => {
                paginate.value.refetch()
            },
            iframeReport,
        }
    },
    methods: {
        massReport() {
            if (this.previewReport) {
                block('#modal-report .modal-body')
                this.reportUrl = `/api/v1/report/pembayaran/pengujian?tahun=${this.tahun}&token=${localStorage.getItem('auth_token')}`
                $('#modal-report').modal('show')
            } else {
                this.downloadReport(`/report/pembayaran/pengujian?tahun=${this.tahun}`)
            }
        }
    },
    watch: {
        openDetail(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        }
    }
})
</script>
