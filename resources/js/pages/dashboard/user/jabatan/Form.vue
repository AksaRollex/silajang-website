<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Jabatan</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Nama</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="full_name"
                            autocomplete="off" v-model="formData.full_name" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="full_name" />
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
    full_name: string,
}

export default defineComponent({
    props: {
        selected: {
            type: String,
            default: null
        },
    },
    emits: ['close', 'refresh'],
    setup(props) {
        const formData = ref<FormData>({
            full_name: '',
        })

        const formSchema = Yup.object().shape({
            full_name: Yup.string().required('Nama tidak boleh kosong'),
        })

        return {
            formData,
            formSchema,
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/master/jabatan/${this.selected}/edit`)
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

            axios.post(this.selected ? `/master/jabatan/${this.selected}/update` : '/master/jabatan/store', this.formData)
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
    }
})
</script>
