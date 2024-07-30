<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">FAQ</h2>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm" @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-faq" url="/konfigurasi/faq" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDelete } from "@/libs/hooks";

import Form from './Form.vue';

interface FAQ {
    no: number,
    uuid: string,
    pertanyaan: string,
    jawaban: string,
    gambar: string,
}
import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<FAQ>();

export default defineComponent({
    components: {
        Form,
    },
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);

        const { delete: deleteJenis } = useDelete({
            onSuccess: () => paginate.value.refetch(),
        });

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("pertanyaan", {
                header: "Pertanyaan",
            }),
            column.accessor("jawaban", {
                header: "Jawaban",
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
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deleteJenis(`/konfigurasi/faq/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))

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
