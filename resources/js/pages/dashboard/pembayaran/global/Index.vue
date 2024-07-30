<template>
    <div class="card">
        <div class="card-header align-items-center gap-8 py-8 py-md-0">
            <h2 class="mb-0">VA Pembayaran</h2>
            <div class="d-flex gap-4 flex-wrap">
                <button @click="downloadReport(`/pembayaran/global/report?tahun=${tahun}&status=${status}`)"
                    class="btn btn-light-danger btn-sm">
                    <i class="la la-file-excel fs-2"></i>
                    Laporan
                </button>
                <select2 placeholder="Pilih Status" class="form-select-solid mw-200px mw-md-100" name="status"
                    :options="statuses" v-model="status">
                </select2>
                <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun"
                    :options="tahuns" v-model="tahun">
                </select2>
            </div>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-va-pembayaran" url="/pembayaran/global" :columns="columns"
                :payload="{ tahun, status }"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDownloadExcel } from "@/libs/hooks";

interface Payment {
    no: number,
    uuid: string,
    va_number: string,
    nama: string,
    jumlah: number,
    tanggal_exp: string,
    tanggal_exp_indo: string,
    tanggal_dibuat: string,
    status: string,
    is_expired: boolean,
}
import { createColumnHelper } from "@tanstack/vue-table";
import { block, currency, unblock } from '@/libs/utils';
import { usePreviewReport } from '@/stores';
const column = createColumnHelper<Payment>();

export default defineComponent({
    setup() {
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");
        const { download: downloadReport } = useDownloadExcel();

        const paginate = ref<any>(null);

        const tahun = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahun.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const status = ref('-');
        const statuses = ref<any[]>([
            { id: '-', text: 'Semua' },
            { id: 'pending', text: 'Pending' },
            { id: 'success', text: 'Sukses' },
            { id: 'failed', text: 'Gagal' },
        ]);

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("va_number", {
                header: "Virtual Account",
            }),
            column.accessor("nama", {
                header: "Nama",
            }),
            column.accessor("jumlah", {
                header: "Jumlah Nominal",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("tanggal_dibuat", {
                header: "Dibuat Pada",
            }),
            column.accessor("tanggal_exp_indo", {
                header: "Tanggal Kedaluwarsa",
                cell: cell => h('div', {
                    class: 'd-flex gap-2 flex-column align-items-start'
                }, [cell.getValue(), cell.row.original.is_expired ? h('span', { class: 'badge badge-light-warning' }, 'Kedaluwarsa') : null])
            }),
            column.accessor("status", {
                header: "Status",
                cell: cell => h('span', { class: `badge badge-light-${cell.getValue() == 'pending' ? 'info' : (cell.getValue() == 'success' ? 'success' : 'danger')}` }, cell.getValue())
            }),
        ]

        return {
            columns,
            paginate,
            tahun,
            tahuns,
            status,
            statuses,
            previewReport,
            reportUrl,
            downloadReport,
            block,
            unblock,
            refresh: () => paginate.value.refetch(),
        }
    },
    watch: {
        openForm(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        }
    }
})
</script>
