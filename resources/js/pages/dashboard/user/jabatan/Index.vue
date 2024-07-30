<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Jabatan</h2>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm && !openParameter"
                @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-jabatan" url="/master/jabatan" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDelete } from "@/libs/hooks";

import Form from './Form.vue';

interface Jabatan {
    no: number,
    name: string,
    full_name: string,
}
import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<Jabatan>();

export default defineComponent({
    components: {
        Form,
    },
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);
        const openParameter = ref<boolean>(false);

        const { delete: deletePeraturan } = useDelete({
            onSuccess: () => paginate.value.refetch(),
        });

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("full_name", {
                header: "Nama"
            }),
            column.accessor("name", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        }
                    }, h('i', { class: 'la la-pencil fs-2' })),
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deletePeraturan(`/master/jabatan/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))

                ])
            }),
        ]

        return {
            columns,
            selected,
            openForm,
            openParameter,
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
