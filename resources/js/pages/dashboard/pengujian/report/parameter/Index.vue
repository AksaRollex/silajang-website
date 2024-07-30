<template>
    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Rekap Parameter</h2>
            <div class="d-flex align-items-center gap-4">
                <button type="button" @click="downloadReport" class="btn btn-sm btn-danger" style="white-space: nowrap;">
                    <i class="la la-file-pdf fs-2"></i>
                    Rekap Laporan
                </button>
                <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker>
            </div>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-sampel-permohonan" url="/report/parameter" :columns="columns"
                queryKey="rekap-parameter" :payload="{ start, end }">
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

    <div class="modal fade" tabindex="-1" id="modal-detail">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <span class="fs-2">{{ selected.nama }}</span>
                        <span v-if="selected.keterangan" class="fs-6 ms-2">{{ `(${selected.keterangan})` }}</span>
                        <span v-if="selected.is_akreditasi" class="ms-2 badge badge-success">Akreditasi</span>
                        <span v-else class="ms-2 badge badge-light-warning">Belum Akreditasi</span>
                        <span class="text-muted ms-3 fs-8">{{ selected.jenis_parameter?.nama }}</span>
                    </div>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-auto" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div v-for="(titik, i) in selected.titik_permohonans" :key="titik.id"
                        class="d-flex align-items-center gap-4 mb-10">
                        <span class="fs-4">{{ i + 1 }}.</span>
                        <div>
                            <div class="text-muted">{{ titik.tanggal }}</div>
                            <div class="fs-4 fw-bolder">{{ titik.kode.includes('Belum') ? '(Belum Ditetapkan)' :
                                `(${titik.kode})` }} {{ titik.lokasi }}</div>
                        </div>
                    </div>
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

interface Parameter {
    no: number,
    uuid: string,
    nama: string,
    keterangan: string,
    metode: string,
    harga: string,
    satuan: string,
    mdl: string,
    is_akreditasi: boolean | number,
    jenis_parameter: {
        nama: string,
    },
    titik_permohonans_count: number,
    titik_permohonans: any
}
import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<Parameter>();

import { usePreviewReport } from '@/stores';
import { block, currency, unblock } from '@/libs/utils';
import moment from 'moment';

export default defineComponent({
    setup() {
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");
        const { download: downloadPdf } = useDownloadPdf();

        const paginate = ref<any>(null);

        const selected = ref<Parameter>({} as Parameter);
        const openDetail = ref<boolean>(false);

        const date = ref<any>(`${moment().startOf('month').format('YYYY-MM-DD')} to ${moment().format('YYYY-MM-DD')}`)

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("nama", {
                header: "Nama",
                cell: cell => h('div', [
                    h('span', `${cell.getValue()} ${cell.row.original.keterangan ? `(${cell.row.original.keterangan})` : ''}`),
                    h('span', { class: `ms-2 badge ${cell.row.original.is_akreditasi ? 'badge-success' : 'badge-light-warning'}` }, cell.row.original.is_akreditasi ? 'Akreditasi' : 'Belum Akreditasi'),
                    h('span', { class: 'text-muted ms-3 fs-8' }, cell.row.original.jenis_parameter.nama),
                ])
            }),
            column.accessor("metode", {
                header: "Metode"
            }),
            column.accessor("satuan", {
                header: "Satuan"
            }),
            column.accessor("titik_permohonans_count", {
                header: "Terdapat di..",
                cell: cell => h('div', [
                    h('span', `${cell.getValue() > 0 ? `${cell.getValue()} Titik Permohonan` : ''}`),
                ])
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.row.original;
                            $('#modal-detail').modal('show')
                        }
                    }, h('i', { class: 'la la-angle-double-right fs-2' })),
                ])
            }),
        ]

        const iframeReport = ref<any>(null)

        return {
            columns,
            selected,
            openDetail,
            paginate,
            reportUrl,
            block, unblock,
            previewReport,
            date,
            downloadPdf,
            iframeReport,
            refresh: () => {
                paginate.value.refetch()
            },
        }
    },
    methods: {
        downloadReport() {
            if (this.previewReport) {
                this.block('#modal-report .modal-body')
                this.reportUrl = `/api/v1/report/parameter?token=${localStorage.getItem('auth_token')}&start=${this.start}&end=${this.end}`

                this.iframeReport.contentWindow.location.reload()
                $('#modal-report').modal('show')
            } else {
                this.downloadPdf(`/report/parameter?start=${this.start}&end=${this.end}`)
            }
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
