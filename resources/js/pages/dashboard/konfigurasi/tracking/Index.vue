<template>
    <Detail :selected="selected" @close="openDetail = false" v-if="openDetail" />

    <div v-show="!openDetail" class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Tracking Pengujian</h2>
            <div class="d-flex gap-4">
                <!-- <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker> -->
                <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun"
                    :options="tahuns" v-model="tahun">
                </select2>
                <select2 placeholder="Pilih Bulan" class="form-select-solid mw-200px mw-md-100" name="bulan"
                    :options="bulans" v-model="bulan">
                </select2>
            </div>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-tracking" url="/tracking" :columns="columns" :payload="{ tahun, bulan }">
            </paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'

import Detail from './Detail.vue';

interface TitikPermohonan {
    no: number,
    uuid: string,
    kode: string,
    lokasi: string,
    tanggal_diterima: string,
    tanggal_selesai: string,
    status: number,
    pembayaran: number,
    keterangan_revisi: string,
    payment?: {
        id: number,
    },
    permohonan: {
        is_mandiri: boolean | number,
        user: {
            nama: string,
        }
    },
}
import { createColumnHelper } from "@tanstack/vue-table";
import { mapStatusPengujian } from '@/libs/utils';
import moment from 'moment';
const column = createColumnHelper<TitikPermohonan>();

export default defineComponent({
    components: {
        Detail
    },
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<any>({});
        const openDetail = ref<boolean>(false);

        const date = ref<any>(`${moment().startOf('month').format('YYYY-MM-DD')} to ${moment().format('YYYY-MM-DD')}`)

        const columns = [
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
            column.accessor("tanggal", {
                header: "Tanggal Dibuat",
            }),
            column.accessor("tanggal_diterima", {
                header: "Tanggal Diterima",
            }),
            column.accessor("tanggal_selesai", {
                header: "Tanggal Selesai",
            }),
            column.accessor("status", {
                header: "Status",
                cell: cell => h('div', {
                    class: 'd-flex align-items-center gap-2',
                }, [
                    h('span', {
                        class: `badge badge-light-${cell.getValue() < 0 ? 'warning' : 'info'}`
                    }, mapStatusPengujian(cell.getValue())),
                    cell.getValue() < 0 && h('button', {
                        class: 'btn btn-warning btn-icon btn-sm',
                        onClick: () => {
                            selected.value = {
                                uuid: cell.row.original.uuid,
                                kode: cell.row.original.kode,
                                keterangan_revisi: cell.row.original.keterangan_revisi,
                            }
                        },
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#modal-revisi'
                    }, h('i', { class: 'la la-eye fs-4' }))
                ])
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-primary d-flex', onClick: () => {
                            selected.value = cell.row.original;
                            openDetail.value = true;
                        }
                    }, ['Tracking', h('i', { class: 'la la-angle-double-right fs-2' })]),
                ])
            }),
        ]

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

        return {
            columns,
            selected,
            openDetail,
            paginate,
            date,
            tahun, tahuns,
            bulan, bulans
        }
    },
    watch: {
        openDetail(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
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
