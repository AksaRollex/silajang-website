<template>
    <div class="card">
        <div class="card-header align-items-center">
            <!-- <h2 class="mb-0">Parameter Peraturan</h2> -->
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row row-gap-20">
                <div class="col-md-6">
                    <h6 class="mb-8">Parameter Tersedia:</h6>
                    <paginate ref="paginateParameter" id="table-parameter" url="/master/parameter"
                        :columns="columnsParameter" :payload="{ except: selectedParameter }" :enabled="false">
                    </paginate>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-8">Parameter yang Dipilih:</h6>
                    <paginate ref="paginateSelectedParameter" id="table-peraturan"
                        :url="`/master/peraturan/${selected}/parameter`" :columns="columnsSelectedParameter"></paginate>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'

interface PivotPeraturan {
    uuid: string,
    pivot: {
        cetak_miring: number | boolean,
        baku_mutu?: string,
    }
}

interface Parameter {
    uuid: string,
    nama: string,
    keterangan: string,
    metode: string,
    harga: number,
    satuan: string,
    mdl: string,
    peraturans: Array<PivotPeraturan>
}

import { createColumnHelper } from "@tanstack/vue-table";
import { block, currency, unblock } from '@/libs/utils';
import { useMutation, useQuery } from '@tanstack/vue-query';
import axios from '@/libs/axios';
const column = createColumnHelper<Parameter>();

export default defineComponent({
    props: {
        selected: {
            type: String,
            required: true,
        },
    },
    emits: ['close'],
    setup(props) {
        const paginateParameter = ref<any>(null);
        const paginateSelectedParameter = ref<any>(null);

        const selectedParameter = useQuery({
            queryKey: ['selectedParameter', props.selected],
            queryFn: () => axios.get(`/master/peraturan/${props.selected}/parameter`).then(res => res.data.data),
            cacheTime: 0,
        })

        const { mutate: addParameter } = useMutation((uuid: string) => axios.post(`/master/peraturan/${props.selected}/parameter/store`, { uuid }), {
            onMutate: () => {
                block(paginateParameter.value.$el)
            },
            onSuccess: () => {
                selectedParameter.refetch();
                paginateSelectedParameter.value.refetch();
            },
            onSettled: () => {
                unblock(paginateParameter.value.$el)
            }
        })

        const { mutate: updateParameter } = useMutation((data: any) => axios.post(`/master/peraturan/${props.selected}/parameter/update`, data), {
            onMutate: () => {
                block(paginateSelectedParameter.value.$el)
            },
            onSuccess: () => {
                selectedParameter.refetch();
                paginateSelectedParameter.value.refetch();
            },
            onSettled: () => {
                unblock(paginateSelectedParameter.value.$el)
            }
        })

        const { mutate: removeParameter } = useMutation((uuid: string) => axios.post(`/master/peraturan/${props.selected}/parameter/destroy`, { uuid }), {
            onMutate: () => {
                block(paginateSelectedParameter.value.$el)
            },
            onSuccess: () => {
                selectedParameter.refetch();
                paginateSelectedParameter.value.refetch();
            },
            onSettled: () => {
                unblock(paginateSelectedParameter.value.$el)
            }
        })

        const columnsParameter = [
            column.accessor("nama", {
                header: "Nama",
                cell: cell => `${cell.getValue()} ${cell.row.original.keterangan ? `(${cell.row.original.keterangan})` : ''}`
            }),
            column.accessor("harga", {
                header: "Harga",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    h('button', { class: 'btn btn-sm btn-icon btn-primary', onClick: () => addParameter(cell.getValue()) }, h('i', { class: 'la la-plus fs-2' }))

                ])
            }),
        ]

        const columnsSelectedParameter = [
            column.accessor("nama", {
                header: "Nama",
                cell: cell => `${cell.getValue()} ${cell.row.original.keterangan ? `(${cell.row.original.keterangan})` : ''}`
            }),
            column.accessor("harga", {
                header: "Harga",
                cell: cell => currency(cell.getValue())
            }),
            column.accessor("peraturans", {
                header: "Baku Mutu",
                cell: cell => h('input', {
                    type: 'text',
                    class: 'form-control',
                    value: cell.getValue()[0].pivot.baku_mutu,
                    onChange: (e: any) => updateParameter({ uuid: cell.row.original.uuid, baku_mutu: e.target.value }),
                    style: 'width: 100px'
                })
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    // h('button', { class: 'btn btn-sm btn-icon btn-info', onClick: () => addParameter(cell.getValue()) }, h('i', { class: 'la la-pencil fs-2' })),
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => removeParameter(cell.getValue()) }, h('i', { class: 'la la-trash fs-2' })),
                ])
            }),
        ]

        return {
            columnsParameter,
            columnsSelectedParameter,
            paginateParameter,
            paginateSelectedParameter,
            selectedParameter: selectedParameter.data
        }
    },
})
</script>
