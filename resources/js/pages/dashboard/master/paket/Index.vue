<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />
    <Parameter :selected="selected" @close="openParameter = false" v-if="openParameter" @refresh="refresh" />

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Paket</h2>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm && !openParameter"
                @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-paket" url="/master/paket" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDelete } from "@/libs/hooks";

import Form from './Form.vue';
import Parameter from './Parameter.vue';

interface Paket {
    no: number,
    nama: string,
    harga: string | Number,
    uuid: string,
}
import { createColumnHelper } from "@tanstack/vue-table";
import { currency } from '@/libs/utils';
const column = createColumnHelper<Paket>();

export default defineComponent({
    components: {
        Form,
        Parameter,
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
            column.accessor("nama", {
                header: "Nama"
            }),
            column.accessor("harga", {
                header: "Harga",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', {
                        class: 'btn btn-sm btn-success d-flex', onClick: () => {
                            selected.value = cell.getValue();
                            openParameter.value = true;
                        }
                    }, [h('i', { class: 'la la-list fs-2' }), ' Parameter']),
                    h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        }
                    }, h('i', { class: 'la la-pencil fs-2' })),
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deletePeraturan(`/master/paket/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))

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
        },
        openParameter(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        },
    }
})
</script>
