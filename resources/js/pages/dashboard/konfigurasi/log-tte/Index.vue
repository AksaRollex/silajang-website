<template>
    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Log TTE</h2>
            <!-- <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm" @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button> -->
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-log-tte" url="/konfigurasi/log-tte" :columns="columns"></paginate>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'

import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<any>();

export default defineComponent({
    setup() {
        const paginate = ref<any>(null);
        const selected = ref<string>("");
        const openForm = ref<boolean>(false);

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("titik_permohonan.kode", {
                header: "Kode Sampel",
            }),
            column.accessor("nik", {
                header: "NIK",
            }),
            column.accessor("status", {
                header: "Status",
            }),
            column.accessor("message", {
                header: "Message",
            }),
            column.accessor("ip_address", {
                header: "IP Address",
            }),
            column.accessor("user_agent", {
                header: "User Agent",
            }),
            column.accessor("tanggal_indo", {
                header: "Waktu",
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
