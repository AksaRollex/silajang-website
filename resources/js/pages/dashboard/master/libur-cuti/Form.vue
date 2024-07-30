<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Libur Cuti</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Tanggal</label>
                        <Field type="hidden" readonly name="tanggal" autocomplete="off" v-model="formData.tanggal" />
                        <date-picker v-model="formData.tanggal"></date-picker>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="tanggal" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-8">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Keterangan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="keterangan"
                            autocomplete="off" v-model="formData.keterangan" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="keterangan" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <button type="submit" class="btn btn-primary btn-sm ms-auto">
                Simpan
            </button>
        </div>
    </VForm>
</template>

<script lang="ts">
import { block, unblock } from '@/libs/utils';
import { defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';

interface FormData {
    tanggal: string;
    keterangan: string;
}

export default defineComponent({
    props: {
        selected: {
            type: String,
            default: null
        },
    },
    emits: ['close', 'refresh'],
    setup() {
        const formData = ref<FormData>({} as FormData)

        const formSchema = Yup.object().shape({
            tanggal: Yup.string().required('Tanggal harus diisi'),
            keterangan: Yup.string().required('Keterangan harus diisi'),
        })

        return {
            formData,
            formSchema,
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/master/libur-cuti/${this.selected}/edit`)
                .then(res => {
                    this.formData = res.data.data
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
        submit() {
            block(this.$el)

            axios.post(this.selected ? `/master/libur-cuti/${this.selected}/update` : '/master/libur-cuti/store', this.formData)
                .then(() => {
                    this.$emit('close')
                    this.$emit('refresh')
                    toast.success('Data berhasil disimpan')
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        }
    },
    mounted() {
        if (this.selected) {
            this.getEdit()
        }
    },
    watch: {
        selected() {
            if (this.selected) {
                this.getEdit()
            }
        }
    }
})
</script>
