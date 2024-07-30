<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Jasa Pengambilan</h2>
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
                        <label class="form-label fw-bold text-dark fs-6 required">Wilayah</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="wilayah"
                            autocomplete="off" v-model="formData.wilayah" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="wilayah" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Harga</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="harga"
                            autocomplete="off" v-model="formData.harga"
                            oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="harga" />
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
import { block, currency, unblock } from '@/libs/utils';
import { defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';

interface FormData {
    wilayah: string;
    harga: string;
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
            wilayah: Yup.string().required('Wilayah harus diisi'),
            harga: Yup.string().required('Harga harus diisi'),
        })

        return {
            formData,
            formSchema,
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/master/jasa-pengambilan/${this.selected}/edit`)
                .then(res => {
                    this.formData = res.data.data
                    this.formData.harga = res.data.data.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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

            axios.post(this.selected ? `/master/jasa-pengambilan/${this.selected}/update` : '/master/jasa-pengambilan/store', this.formData)
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
