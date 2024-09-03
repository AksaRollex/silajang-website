<template>
    <Detail :selected="selected" @close="openDetail = false" v-if="openDetail" @refresh="refresh" />

    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Menunggu Konfirmasi</h2>
            <select2 placeholder="Pilih tahun" class="form-select-solid mw-200px mw-md-100" name="tahunMenunggu"
                :options="tahuns" v-model="tahunMenunggu">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateMenunggu" id="table-menunggu" url="/administrasi/kontrak"
                :columns="columnsMenunggu" queryKey="kontrak-0" :payload="{ kesimpulan_kontrak: 0, tahun: tahunMenunggu }">
            </paginate>
        </div>
    </div>

    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Telah Dikonfirmasi</h2>
            <select2 placeholder="Pilih tahun" class="form-select-solid mw-200px mw-md-100" name="tahunDiterima"
                :options="tahuns" v-model="tahunDiterima">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateDiterima" id="table-diterima" url="/administrasi/kontrak"
                :columns="columnsDiterima" queryKey="kontrak-1" :payload="{ kesimpulan_kontrak: 1, tahun: tahunDiterima }">
            </paginate>
        </div>
    </div>

    <div class="card mb-10">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Konfirmasi Ditolak</h2>
            <select2 placeholder="Pilih tahun" class="form-select-solid mw-200px mw-md-100" name="tahunDitolak"
                :options="tahuns" v-model="tahunDitolak">
            </select2>
        </div>
        <div class="card-body">
            <paginate ref="paginateDiterima" id="table-ditolak" url="/administrasi/kontrak"
                :columns="columnsDitolak" queryKey="kontrak-2" :payload="{ kesimpulan_kontrak: 2, tahun: tahunDitolak }">
            </paginate>
        </div>
    </div>

</template>
<script lang="ts">
import { defineComponent, h, ref } from 'vue';

import Detail from './Detail.vue';

interface Permohonan {
    no: number,
    uuid: string,
    industri: string,
    alamat: string,
    tanggal: string,
    pembayaran: string,
    kesimpulan_kontrak: boolean | number,
}
import { createColumnHelper } from '@tanstack/vue-table';
const column = createColumnHelper<Permohonan>();

export default defineComponent({
    components: {
        Detail,
    },
    setup() {
        const paginateMenunggu = ref<any>(null);
        const paginateDiterima = ref<any>(null);
        const paginateDitolak = ref<any>(null);

        const selected = ref<string>("");
        const openDetail = ref<boolean>(false);

        const tahunMenunggu = ref(new Date().getFullYear());
        const tahunDiterima = ref(new Date().getFullYear());
        const tahunDitolak = ref(new Date().getFullYear());
        const tahuns = ref<any[]>([]);
        for (let i = tahunMenunggu.value; i >= 2022; i--) {
            tahuns.value.push({ id: i, text: i });
        }

        const columnsMenunggu = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("industri", {
                header: "Nama Industri",
            }),
            column.accessor("alamat", {
                header: "Alamat"
            }),
            column.accessor("kesimpulan_kontrak", {
                header: "Status Kontrak",
                cell: cell => {
                    if (cell.getValue() == 1) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-success`
                            }, 'Diterima')
                        ])
                    }
                    if (cell.getValue() == 2) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-danger`
                            }, 'Ditolak')
                        ])
                    }
                    return h('div', {
                        class: 'd-flex align-items-center gap-2',
                    }, [
                        h('span', {
                            class: `badge badge-light-info`
                        }, 'Menunggu')
                    ])
                }
            }),
            column.accessor("tanggal", {
                header: "Tanggal",
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: cell => h('button', {
                    class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                        selected.value = cell.getValue();
                        openDetail.value = true;
                    }
                }, h('i', { class: 'la la-eye gs-2' }))
            })
        ]

        const columnsDiterima = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("industri", {
                header: "Nama Industri",
            }),
            column.accessor("alamat", {
                header: "Alamat"
            }),
            column.accessor("kesimpulan_kontrak", {
                header: "Kesimpulan Kontrak",
                cell: cell => {
                    if (cell.getValue() == 1) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-success`
                            }, 'Diterima')
                        ])
                    }
                    if (cell.getValue() == 2) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-danger`
                            }, 'Ditolak')
                        ])
                    }
                    return h('div', {
                        class: 'd-flex align-items-center gap-2',
                    }, [
                        h('span', {
                            class: `badge badge-light-info`
                        }, 'Menunggu')
                    ])
                }
            }),
            column.accessor("tanggal", {
                header: "Tanggal",
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: cell => h('button', {
                    class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                        selected.value = cell.getValue();
                        openDetail.value = true;
                    }
                }, h('i', { class: 'la la-eye gs-2' }))
            })
        ]

        const columnsDitolak = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("industri", {
                header: "Nama Industri",
            }),
            column.accessor("alamat", {
                header: "Alamat"
            }),
            column.accessor("kesimpulan_kontrak", {
                header: "Kesimpulan Kontrak",
                cell: cell => {
                    if (cell.getValue() == 1) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-success`
                            }, 'Diterima')
                        ])
                    }
                    if (cell.getValue() == 2) {
                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-danger`
                            }, 'Ditolak')
                        ])
                    }
                    return h('div', {
                        class: 'd-flex align-items-center gap-2',
                    }, [
                        h('span', {
                            class: `badge badge-light-info`
                        }, 'Menunggu')
                    ])
                }
            }),
            column.accessor("tanggal", {
                header: "Tanggal",
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: cell => h('button', {
                    class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                        selected.value = cell.getValue();
                        openDetail.value = true;
                    }
                }, h('i', { class: 'la la-eye gs-2' }))
            })
        ]

        return {
            columnsMenunggu,
            columnsDiterima,
            columnsDitolak,
            selected,
            openDetail,
            paginateMenunggu,
            paginateDiterima,
            paginateDitolak,
            tahunMenunggu,
            tahunDiterima,
            tahunDitolak,
            tahuns,
            refresh: () => {
                paginateMenunggu.value.refetch()
                paginateDiterima.value.refetch()
                paginateDitolak.value.refetch()
            }
        }
    },
    watch: {
        openDetail(val) {
            if(!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        }
    }
})
</script>