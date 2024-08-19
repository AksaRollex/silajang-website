<template>
    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Registrasi Sampel</h2>
            <div class="d-flex align-items-center gap-5">
                <button type="button" class="btn btn-light-danger btn-sm"
                    @click="download(`/report/registrasi-sampel?tahun=${tahun}&bulan=${bulan}`)">
                    <i class="la la-file-excel fs-4"></i>
                    Report Excel
                </button>
                <!-- <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker> -->
                <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tahuns"
                  v-model="tahun">
                </select2>
                <select2 placeholder="Pilih Bulan" class="form-select-solid mw-200px mw-md-100" name="bulan" :options="bulans"
                  v-model="bulan">
                </select2>
            </div>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-sampel-permohonan" url="/report/registrasi-sampel"
                :columns="columnsSampelPermohonan" queryKey="sampel-permohonan" :payload="{ 
                    // start,
                    // end,
                    tahun,
                    bulan }">
            </paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDownloadExcel, useDownloadPdf } from "@/libs/hooks";

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
import { options } from 'dropzone';

export default defineComponent({
    setup() {
        const iframeReport = ref<any>(null);
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");
        const { download: downloadPdf } = useDownloadPdf();

        const paginate = ref<any>(null);

        const selected = ref<string | any>("");
        const openDetail = ref<boolean>(false);

        // const date = ref<any>(`${moment().startOf('month').format('YYYY-MM-DD')} to ${moment().format('YYYY-MM-DD')}`)

        const tahun = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahun.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const bulan = ref(new Date().getMonth() + 1)
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

        const columnsSampelPermohonan = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("tanggal_diterima", {
                header: "Tanggal Masuk",
            }),
            column.accessor("tanggal_selesai", {
                header: "Tanggal Selesai",
            }),
            column.accessor("permohonan", {
                header: "Pelanggan",
                cell: cell => cell.getValue().user.nama
            }),
            column.accessor("permohonan", {
                header: "Alamat",
                cell: cell => cell.getValue().user.detail.alamat
            }),
            column.accessor("permohonan", {
                header: "Lokasi",
                cell: cell => cell.getValue().alamat
            }),
            column.accessor("lokasi", {
                header: "Titik Sampling",
            }),
        ]

        const { download } = useDownloadExcel()

        return {
            iframeReport,
            downloadPdf,
            previewReport,
            columnsSampelPermohonan,
            selected,
            openDetail,
            paginate,
            tahun,
            tahuns,
            bulan,
            bulans,
            reportUrl,
            block, unblock,
            // date,
            download,
            refresh: () => {
                paginate.value.refetch()
            },
        }
    },
    methods: {
        downloadReport(mode) {

        }
    },
    watch: {
        openDetail(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        },
    },
    // computed: {
    //     start() {
    //         return this.date.split(' to ')[0]
    //     },
    //     end() {
    //         return this.date.split(' to ')[1]
    //     }
    // }
})
</script>
