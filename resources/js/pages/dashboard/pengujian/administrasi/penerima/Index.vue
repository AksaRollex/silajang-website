<template>
    <Detail :selected="selected" @close="openDetail = false" v-if="openDetail" @refresh="refresh" />
    <Revisi :selected="selected" @refresh="refresh" />

    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Menunggu Konfirmasi Petugas</h2>
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahunKonfirmasi"
                :options="tahuns" v-model="tahunKonfirmasi">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateKonfirmasi" id="table-konfirmasi" url="/administrasi/penerima-sample"
                :columns="columnsBelum" queryKey="penerima-sample-0" :payload="{ status: 1, tahun: tahunKonfirmasi }">
            </paginate>
        </div>
    </div>

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Telah Diterima</h2>
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahunSelesai"
                :options="tahuns" v-model="tahunSelesai">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateDiambil" id="table-diambil" url="/administrasi/penerima-sample" :columns="columnsSudah"
                queryKey="penerima-sample-1" :payload="{ status: 2, tahun: tahunSelesai }">
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

import Detail from './Detail.vue';
import Revisi from './Revisi.vue';

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
    text_status: string,
    is_has_subkontrak: boolean,
    nama_pengambil: string,
    tanggal_diterima: string,
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
import { block, unblock } from '@/libs/utils';

const column = createColumnHelper<TitikPermohonan>();

export default defineComponent({
    components: {
        Detail,
        Revisi,
    },
    setup() {
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");

        const paginateKonfirmasi = ref<any>(null);
        const paginateDiambil = ref<any>(null);

        const selected = ref<string | any>("");
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
            column.accessor("kesimpulan_sampel", {
                header: "Status Penerimaan",
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
                header: "Detail Pengambilan/Pengiriman",
                cell: cell => h('div', [
                    h('div', [
                        h('span', cell.row.original.permohonan.is_mandiri ? 'Dikirim pada: ' : 'Diambil pada: '),
                        h('strong', `${cell.getValue() ? moment(cell.getValue()).format('DD MMMM YYYY - HH:mm') : '-'}`)
                    ]),
                    h('div', [
                        h('span', 'Oleh: '),
                        h('strong', `${cell.row.original.pengambil?.nama ?? cell.row.original.nama_pengambil}`)
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
                    h('button', {
                        class: 'btn btn-sm btn-warning', onClick: () => {
                            selected.value = {
                                uuid: cell.getValue(),
                                kode: cell.row.original.kode,
                            }
                        },
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modal-revisi'
                    }, [
                        h('i', { class: 'la la-pencil fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Revisi')
                    ]),
                    cell.row.original.status > 1 ? h('button', {
                        class: 'btn btn-sm btn btn-danger', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/tanda-terima?token=${localStorage.getItem('auth_token')}`
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/tanda-terima`)
                            }
                        }
                    }, [
                        h('i', { class: 'la la-file-pdf fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Cetak Tanda Terima')
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
            column.accessor("text_status", {
                header: "Status",
                cell: cell => h('div', [
                    h('span', { class: 'badge badge-light-primary' }, cell.getValue())
                ])
            }),
            column.accessor("tanggal_diterima", {
                header: "Diterima pada",
                cell: cell => moment(cell.getValue()).format('DD MMMM YYYY - HH:mm')
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openDetail.value = true;
                        },
                    }, h('i', { class: 'la la-eye fs-2' })),
                    cell.row.original.status < 8 && h('button', {
                        class: 'btn btn-sm btn-warning', onClick: () => {
                            selected.value = {
                                uuid: cell.getValue(),
                                kode: cell.row.original.kode,
                            }
                        },
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modal-revisi'
                    }, [
                        h('i', { class: 'la la-pencil fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Revisi')
                    ]),
                    h('button', {
                        class: 'btn btn-sm btn btn-danger', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/tanda-terima?token=${localStorage.getItem('auth_token')}`
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/tanda-terima`)
                            }
                        }
                    }, [
                        h('i', { class: 'la la-file-pdf fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Permohonan Pengujian')
                    ]),
                    h('button', {
                        class: 'btn btn-sm btn btn-danger', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/pengamanan-sampel?token=${localStorage.getItem('auth_token')}`
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/pengamanan-sampel`)
                            }
                        }
                    }, [
                        h('i', { class: 'la la-file-pdf fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Pengamanan Sampel')
                    ]),
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
