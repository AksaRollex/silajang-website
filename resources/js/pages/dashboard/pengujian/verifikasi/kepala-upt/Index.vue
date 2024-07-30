<template>
    <div v-if="!openDetail" class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Menunggu Verifikasi</h2>
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahunKonfirmasi"
                :options="tahuns" v-model="tahunKonfirmasi">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateKonfirmasi" id="table-konfirmasi" url="/verifikasi/kepala-upt" :columns="columnsBelum"
                queryKey="kepala-upt-0" :payload="{ status: 7, tahun: tahunKonfirmasi }">
            </paginate>
        </div>
    </div>

    <div v-if="!openDetail" class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Telah Diverifikasi/Disahkan</h2>
            <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahunSelesai"
                :options="tahuns" v-model="tahunSelesai">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateSah" id="table-diambil" url="/verifikasi/kepala-upt" :columns="columnsSudah"
                queryKey="kepala-upt-1" :payload="{ status: 8, tahun: tahunSelesai }">
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
import { useDelete, useDownloadPdf, useSwalConfirm } from "@/libs/hooks";
import moment from 'moment';

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
    pengambil?: {
        nama: string,
    },
    permohonan: {
        is_mandiri: boolean | number,
        user: {
            nama: string,
        }
    },
    peraturan: {
        id: number,
        nama: string,
    }
}
import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<TitikPermohonan>();

import { usePreviewReport } from '@/stores';
import { block, unblock } from '@/libs/utils';

export default defineComponent({
    setup() {
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");

        const paginateKonfirmasi = ref<any>(null);
        const paginateSah = ref<any>(null);

        const selected = ref<string | any>("");
        const openDetail = ref<boolean>(false);

        const tahunKonfirmasi = ref(new Date().getFullYear());
        const tahunSelesai = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahunKonfirmasi.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const { download: downloadReport } = useDownloadPdf();
        const { confirm: verifikasiLhu } = useSwalConfirm({
            title: 'Apakah Anda Yakin ingin Memverifikasi LHU ini?',
            confirmButtonText: 'Ya, Verifikasi',
        }, {
            onSuccess: () => {
                paginateKonfirmasi.value.refetch()
                paginateSah.value.refetch()
            }
        });
        const { confirm: rollbackLhu } = useSwalConfirm({
            title: 'Apakah Anda Yakin ingin Membatalkan Verifikasi LHU ini?',
            confirmButtonText: 'Ya, Batalkan Verifikasi',
        }, {
            onSuccess: () => {
                paginateKonfirmasi.value.refetch()
                paginateSah.value.refetch()
            }
        });

        const columnsBelum = [
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
            column.accessor("peraturan", {
                header: "Peraturan",
                cell: cell => cell.getValue()?.nama ?? '-'
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
                    h('button', {
                        class: 'btn btn-sm btn-success',
                        onClick: () => verifikasiLhu(`/verifikasi/kepala-upt/${cell.getValue()}/verify`, 'POST'),
                        style: {
                            whiteSpace: 'nowrap'
                        }
                    }, [h('i', { class: 'la la-check-double fs-2' }), 'Verifikasi']),
                    h('button', {
                        class: 'btn btn-sm btn btn-danger', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/preview-lhu?token=${localStorage.getItem('auth_token')}`
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/preview-lhu`)
                            }
                        }
                    }, [
                        h('i', { class: 'la la-file-pdf fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Preview LHU')
                    ]),
                ])
            }),
        ]

        const columnsSudah = [
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
            column.accessor("peraturan", {
                header: "Peraturan",
                cell: cell => cell.getValue()?.nama ?? '-'
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
                    h('button', {
                        class: 'btn btn-sm btn btn-danger', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/preview-lhu?token=${localStorage.getItem('auth_token')}`
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/preview-lhu`)
                            }
                        }
                    }, [
                        h('i', { class: 'la la-file-pdf fs-2' }),
                        h('span', { class: 'd-none d-md-inline' }, 'Preview LHU')
                    ]),
                    cell.row.original.status < 9 && h('button', {
                        class: 'btn btn-sm btn-light-warning',
                        onClick: () => rollbackLhu(`/verifikasi/kepala-upt/${cell.getValue()}/rollback`, 'POST'),
                        style: {
                            whiteSpace: 'nowrap'
                        }
                    }, [h('i', { class: 'la la-refresh fs-2' }), 'Rollback']),
                ])
            }),
        ]

        return {
            columnsBelum,
            columnsSudah,
            selected,
            openDetail,
            paginateKonfirmasi,
            paginateSah,
            tahunKonfirmasi,
            tahunSelesai,
            tahuns,
            reportUrl,
            block, unblock,
            refresh: () => {
                paginateKonfirmasi.value.refetch()
                paginateSah.value.refetch()
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
