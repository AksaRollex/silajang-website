<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

    <div v-if="!openForm" class="card">
        <div class="card-header align-items-center gap-8 py-8 py-md-0">
            <h2 class="mb-0">Pembayaran Khusus Non Pengujian</h2>
            <div class="d-flex gap-4 flex-wrap">
                <button @click="massReport" class="btn btn-light-danger btn-sm">
                    <i class="la la-file-pdf fs-2"></i>
                    Laporan
                </button>
                <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm" @click="openForm = true">
                    Buat
                    <i class="la la-plus"></i>
                </button>
                <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun"
                    :options="tahuns" v-model="tahun">
                </select2>
            </div>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-jenis-sampel" url="/pembayaran/non-pengujian" :columns="columns"
                :payload="{ tahun: tahun }"></paginate>
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

import Form from './Form.vue';

interface Payment {
    no: number,
    uuid: string,
    va_number: string,
    nama: string,
    jumlah: number,
    tanggal_exp: string,
    tanggal_exp_indo: string,
    status: string,
    is_expired: boolean,
}
import { createColumnHelper } from "@tanstack/vue-table";
import { block, currency, unblock } from '@/libs/utils';
import { usePreviewReport } from '@/stores';
const column = createColumnHelper<Payment>();

export default defineComponent({
    components: {
        Form,
    },
    setup() {
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");
        const { download: downloadReport } = useDownloadPdf();

        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);

        const { delete: deletePembayaran } = useDelete({
            onSuccess: () => paginate.value.refetch(),
        });

        const tahun = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahun.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

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
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        }
                    }, h('i', { class: 'la la-eye fs-2' })),
                    h('button', { class: 'btn btn-sm btn-danger', onClick: () => deletePembayaran(`/pembayaran/non-pengujian/${cell.getValue()}`) }, [h('i', { class: 'la la-ban fs-2' }), ' Batal'])

                ])
            }),
        ]

        return {
            columns,
            selected,
            openForm,
            paginate,
            tahun,
            tahuns,
            previewReport,
            reportUrl,
            downloadReport,
            block,
            unblock,
            refresh: () => paginate.value.refetch(),
        }
    },
    methods: {
        massReport() {
            if (this.previewReport) {
                block('#modal-report .modal-body')
                this.reportUrl = `/api/v1/report/pembayaran/non-pengujian?tahun=${this.tahun}&token=${localStorage.getItem('auth_token')}`
                $('#modal-report').modal('show')
            } else {
                this.downloadReport(`/report/pembayaran/non-pengujian?tahun=${this.tahun}`)
            }
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
