<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Tanda Tangan</h2>
            <!-- <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm" @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button> -->
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-pengawetan" url="/konfigurasi/tanda-tangan" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'

import Form from './Form.vue';

interface TandaTangan {
    no: number,
    uuid: string,
    bagian: string,
    user: {
        nama: string,
        nip: string,
        nik: string,
        role: {
            full_name: string,
        }
    }
}
import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<TandaTangan>();

export default defineComponent({
    components: {
        Form,
    },
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("bagian", {
                header: "Dokumen",
            }),
            column.accessor("user", {
                header: "Nama",
                cell: cell => cell.getValue()?.nama
            }),
            column.accessor("user", {
                header: "NIP",
                cell: cell => cell.getValue()?.nip
            }),
            column.accessor("user", {
                header: "NIK",
                cell: cell => cell.getValue()?.nik
            }),
            column.accessor("user", {
                header: "Jabatan",
                cell: cell => cell.getValue()?.role?.full_name
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        }
                    }, h('i', { class: 'la la-pencil fs-2' })),
                    // h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deletePengawetan(`/master/pengawetan/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))
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
