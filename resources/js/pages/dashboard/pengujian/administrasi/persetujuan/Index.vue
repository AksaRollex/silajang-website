<template>
    <Detail :selected="selected" @close="openDetail = false" v-if="openDetail" @refresh="refresh" />

    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Menunggu Konfirmasi Petugas</h2>
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahunKonfirmasi"
                :options="tahuns" v-model="tahunKonfirmasi">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateKonfirmasi" id="table-konfirmasi" url="/administrasi/pengambil-sample"
                :columns="columnsBelum" queryKey="persetujuan-0" :payload="{ status: 0, tahun: tahunKonfirmasi }">
            </paginate>
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Telah Diambil</h2>
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahunSelesai"
                :options="tahuns" v-model="tahunSelesai">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateDiambil" id="table-diambil" url="/administrasi/pengambil-sample" :columns="columnsSudah"
                queryKey="persetujuan-1" :payload="{ status: 1, tahun: tahunSelesai }">
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
                    <iframe :src="reportUrl" frameborder="0" class="w-100 h-700px"
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
import { useDelete, useDownloadPdf } from "@/libs/hooks";
import moment from 'moment';

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
    pembayaran: number,
    tanggal_pengambilan: string,
    is_has_subkontrak: boolean,
    kesimpulan_permohonan: number,
    kesimpulan_sampel: number,
    pengambil?: {
        nama: string,
    },
    permohonan: {
        is_mandiri: boolean | number,
        user: {
            nama: string,
        }
    }
}
import { createColumnHelper } from "@tanstack/vue-table";
import { usePreviewReport } from '@/stores';
const column = createColumnHelper<TitikPermohonan>();

export default defineComponent({
    components: {
        Detail,
    },
    setup() {
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");

        const paginateKonfirmasi = ref<any>(null);
        const paginateDiambil = ref<any>(null);

        const selected = ref<string>("");
        const openDetail = ref<boolean>(false);

        const tahunKonfirmasi = ref(new Date().getFullYear());
        const tahunSelesai = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahunKonfirmasi.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const { download: downloadReport } = useDownloadPdf();

        const columnsBelum = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("permohonan", {
                header: "Pelanggan",
                cell: cell => cell.getValue().user.nama
            }),
            column.accessor("lokasi", {
                header: "Titik Uji/Lokasi",
            }),
            column.accessor("kesimpulan_permohonan", {
                header: "Status Pengambilan",
                cell: cell => {
                    if (cell.getValue() == 1) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-success`
                            }, 'Diterima')
                        ])
                    }

                    if (cell.getValue() == 2) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-danger`
                            }, 'Ditolak')
                        ])
                    }

                    return h('div', {
                        class: 'd-flex align-items-center gap-2',
                    }, [
                        h('span', {
                            class: `badge badge-light-info`
                        }, 'Menunggu')
                    ])
                }
            }),
            column.accessor("tanggal_pengambilan", {
                header: "Detail Pengambilan",
                cell: cell => h('div', [
                    h('div', [
                        h('span', 'Diambil pada: '),
                        h('strong', `${cell.getValue() ? moment(cell.getValue()).format('DD MMMM YYYY - HH:mm') : '-'}`)
                    ]),
                    h('div', [
                        h('span', 'Oleh: '),
                        h('strong', `${cell.row.original.pengambil?.nama ?? '-'}`)
                    ])
                ])
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openDetail.value = true;
                        }
                    }, h('i', { class: 'la la-eye fs-2' })),
                    cell.row.original.status > 0 ? h('button', {
                        class: 'btn btn-sm btn btn-danger', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/sampling?token=${localStorage.getItem('auth_token')}`
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/sampling`)
                            }
                        }
                    }, [
                        h('i', { class: 'la la-file-pdf fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Cetak Sampling')
                    ]) : null,
                ])
            }),
        ]

        const columnsSudah = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("kode", {
                header: "Kode",
            }),
            column.accessor("permohonan", {
                header: "Pelanggan",
                cell: cell => cell.getValue().user.nama
            }),
            column.accessor("lokasi", {
                header: "Titik Uji/Lokasi",
            }),
            column.accessor("tanggal_pengambilan", {
                header: "Detail Pengambilan",
                cell: cell => h('div', [
                    h('div', [
                        h('span', 'Diambil pada: '),
                        h('strong', `${cell.getValue() ? moment(cell.getValue()).format('DD MMMM YYYY - HH:mm') : '-'}`)
                    ]),
                    h('div', [
                        h('span', 'Oleh: '),
                        h('strong', `${cell.row.original.pengambil?.nama ?? '-'}`)
                    ])
                ])
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openDetail.value = true;
                        }
                    }, h('i', { class: 'la la-eye fs-2' })),
                    h('button', {
                        class: 'btn btn-sm btn btn-danger', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/sampling?token=${localStorage.getItem('auth_token')}`
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/sampling`)
                            }
                        }
                    }, [
                        h('i', { class: 'la la-file-pdf fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Cetak Sampling')
                    ]),
                    h('div', { class: 'dropup' }, [
                        h('button', {
                            class: 'btn btn-sm btn btn-light-danger',
                            'data-bs-toggle': 'dropdown',
                        }, [
                            h('span', { class: 'd-none d-md-inline me-2' }, 'Berita Acara'),
                            h('i', { class: 'la la-angle-down me-0 fs-2' }),
                        ]),
                        h('div', {
                            class: 'dropdown-menu',
                        }, [
                            h('div', {
                                class: 'dropdown-item px-3', onClick: () => {
                                    if (previewReport.value) {
                                        block('#modal-report .modal-body')
                                        reportUrl.value = `/api/v1/report/${cell.getValue()}/berita-acara?token=${localStorage.getItem('auth_token')}`
                                        $('#modal-report').modal('show')
                                    } else {
                                        downloadReport(`/report/${cell.getValue()}/berita-acara`)
                                    }
                                }
                            }, [
                                h('button', { class: 'btn btn-light w-100 text-start btn-sm' }, [
                                    h('i', { class: 'la la-file-pdf fs-2' }),
                                    h('span', 'Berita Acara Pengambilan')
                                ]),
                            ]),
                            h('div', {
                                class: 'dropdown-item px-3', onClick: () => {
                                    if (previewReport.value) {
                                        block('#modal-report .modal-body')
                                        reportUrl.value = `/api/v1/report/${cell.getValue()}/data-pengambilan?token=${localStorage.getItem('auth_token')}`
                                        $('#modal-report').modal('show')
                                    } else {
                                        downloadReport(`/report/${cell.getValue()}/data-pengambilan`)
                                    }
                                }
                            }, [
                                h('button', { class: 'btn btn-light w-100 text-start btn-sm' }, [
                                    h('i', { class: 'la la-file-pdf fs-2' }),
                                    h('span', 'Data Pengambilan')
                                ])
                            ])
                        ])
                    ])
                ])
            }),
        ]

        return {
            columnsBelum,
            columnsSudah,
            selected,
            openDetail,
            paginateKonfirmasi,
            paginateDiambil,
            tahunKonfirmasi,
            tahunSelesai,
            tahuns,
            reportUrl,
            block, unblock,
            refresh: () => {
                paginateKonfirmasi.value.refetch()
                paginateDiambil.value.refetch()
            },
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
