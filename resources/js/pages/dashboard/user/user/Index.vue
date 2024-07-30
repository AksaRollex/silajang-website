<template>
    <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />
    <Parameter :selected="selected" @close="openParameter = false" v-if="openParameter" @refresh="refresh" />

    <div class="card">
        <div class="card-header align-items-center">
            <h2 class="mb-0">User</h2>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm && !openParameter"
                @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light rounded-bottom-0 active" data-bs-toggle="tab"
                        href="#tab-dinas-internal">Dinas
                        Internal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-light rounded-bottom-0" data-bs-toggle="tab"
                        href="#tab-customer">Customer</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-dinas-internal" role="tabpanel">
                    <paginate ref="paginateDinas" id="table-user-dinas" url="/master/user" :columns="columns"
                        queryKey="table-user-dinas" :payload="{ golongan_id: 2 }"></paginate>
                </div>
                <div class="tab-pane fade" id="tab-customer" role="tabpanel">
                    <paginate ref="paginateCustomer" id="table-user-customer" url="/master/user" :columns="columns"
                        queryKey="table-user-customer" :payload="{ golongan_id: 1 }"></paginate>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'
import { useDelete } from "@/libs/hooks";

import Form from './Form.vue';
import Parameter from './Parameter.vue';

export interface DetailUser {
    instansi: string;
    alamat: string;
    pimpinan: string;
    pj_mutu: string;
    telepon: string;
    fax: string;
    email: string;
    kecamatan_id: number | undefined | null;
    kelurahan_id: number | undefined | null;
    provinsi: any;
    kota: any;
    lat: number;
    long: number;
}

interface Golongan {
    id: number;
    nama: string;
}

export interface User {
    no: number;
    uuid: string;
    nama: string;
    email: string;
    password: string;
    phone: string;
    photo: string;
    permission: Array<string>;
    detail?: DetailUser,
    golongan?: Golongan,
    confirmed: boolean | number;
    role?: {
        name: string;
        full_name: string;
    };
    roles: Array<{
        name: string;
        full_name: string;
    }>;
}

import axios from '@/libs/axios';
import { createColumnHelper } from "@tanstack/vue-table";
import { useMutation } from '@tanstack/vue-query';
import { block, unblock } from '@/libs/utils';
import { toast } from 'vue3-toastify';
const column = createColumnHelper<User>();

export default defineComponent({
    components: {
        Form,
        Parameter
    },
    setup() {
        const paginateDinas = ref<any>(null);
        const paginateCustomer = ref<any>(null);

        const selected = ref<string>("");
        const openForm = ref<boolean>(false);
        const openParameter = ref<boolean>(false);

        const { delete: deleteUser } = useDelete({
            onSuccess: () => {
                paginateDinas.value.refetch()
                paginateCustomer.value.refetch()
            },
        });

        const { mutate: changeConfirm } = useMutation((data: any) => axios.post(`/master/user/${data.uuid}/confirm`, { confirmed: data.confirmed }), {
            onMutate: () => block("#table-user"),
            onSuccess: () => {
                paginateDinas.value.refetch()
                paginateCustomer.value.refetch()
            },
            onSettled: () => unblock("#table-user"),
            onError: (error: any) => toast.error(error.response.data.message)
        });

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("nama", {
                header: "Nama",
            }),
            column.accessor("email", {
                header: "Email",
            }),
            column.accessor("phone", {
                header: "No. Telepon",
            }),
            column.accessor("detail.instansi", {
                header: "Perusahaan",
                cell: cell => cell.getValue() || '-'
            }),
            column.accessor("role.full_name", {
                header: "Jabatan",
            }),
            column.accessor("confirmed", {
                header: "Confirmed",
                cell: cell => h('div', { class: 'form-check form-switch form-check-custom form-check-solid' }, [
                    h('input', {
                        class: 'form-check-input', type: 'checkbox', checked: cell.getValue() == 1,
                        style: {
                            cursor: 'pointer'
                        },
                        onChange: (ev: any) => changeConfirm({ uuid: cell.row.original.uuid, confirmed: ev.target.checked })
                    }),
                    h('label', { class: 'form-check-label' })
                ])
            }),
            column.accessor("golongan.nama", {
                header: "Jenis",
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
                    cell.row.original.roles.map(role => role.name).find(role => ['admin', 'kepala-upt', 'koordinator-teknis', 'koordinator-administrasi', 'analis', 'pengambil-sample'].includes(role)) && h('button', {
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
                    h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deleteUser(`/master/user/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))

                ])
            }),
        ]

        return {
            columns,
            selected,
            openForm,
            openParameter,
            paginateDinas,
            paginateCustomer,
            refresh: () => {
                paginateDinas.value.refetch()
                paginateCustomer.value.refetch()
            },
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
