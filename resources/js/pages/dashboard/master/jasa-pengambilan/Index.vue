<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Jasa Pengambilan</h2>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm" @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-jasa-pengambilan" url="/master/jasa-pengambilan" :columns="columns">
            </paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDelete } from "@/libs/hooks";

import Form from './Form.vue';

interface JasaPengambilan {
    no: number,
    uuid: string,
    wilayah: string,
    harga: number,
}
import { createColumnHelper } from "@tanstack/vue-table";
import { currency } from '@/libs/utils';
const column = createColumnHelper<JasaPengambilan>();

export default defineComponent({
    components: {
        Form,
    },
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);

        const { delete: deletePengawetan } = useDelete({
            onSuccess: () => paginate.value.refetch(),
        });

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("wilayah", {
                header: "Wilayah",
            }),
            column.accessor("harga", {
                header: "Harga",
                cell: cell => currency(cell.getValue())
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
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deletePengawetan(`/master/jasa-pengambilan/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))

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
