<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Parameter</h2>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm" @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-parameter" url="/master/parameter" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDelete } from "@/libs/hooks";

import Form from './Form.vue';

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
}
import { createColumnHelper } from "@tanstack/vue-table";
import { currency } from '@/libs/utils';
const column = createColumnHelper<Parameter>();

export default defineComponent({
    components: {
        Form,
    },
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);

        const { delete: deleteParameter } = useDelete({
            onSuccess: () => paginate.value.refetch(),
        });

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
            column.accessor("harga", {
                header: "Harga",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("mdl", {
                header: "MDL"
            }),
            // column.accessor("jenis_parameter.nama", {
            //     header: "Jenis Parameter"
            // }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        }
                    }, h('i', { class: 'la la-pencil fs-2' })),
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deleteParameter(`/master/parameter/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))

                ])
            }),
        ]

        return {
            columns,
            selected,
            openForm,
            paginate,
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
