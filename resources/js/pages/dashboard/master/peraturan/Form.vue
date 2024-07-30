<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Peraturan</h2>
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
                        <label class="form-label fw-bold text-dark fs-6 required">Nama</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="nama"
                            autocomplete="off" v-model="formData.nama" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="nama" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Nomor</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="nomor"
                            autocomplete="off" v-model="formData.nomor" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="nomor" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Tentang</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="tentang"
                            autocomplete="off" v-model="formData.tentang" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="tentang" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-6">
                    <div class="fv-row mb-10 w-100">
                        <!--begin::Label-->
                        <label class="form-label fw-bold">File <span class="text-muted fw-normal">(pdf)</span></label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files" :accepted-file-types="fileTypes"
                            v-on:updatefiles="onUpadateFiles"></file-upload>
                        <!--end::Input-->
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="gambar" />
                            </div>
                        </div>
                    </div>
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
    nama: string,
    nomor: string,
    tentang: string,
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
        const files = ref<Array<File | String>>([])
        const fileTypes = ref(['application/pdf'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const formData = ref<FormData>({
            nama: '',
            nomor: '',
            tentang: '',
        })

        const formSchema = Yup.object().shape({
            nama: Yup.string().required('Nama tidak boleh kosong'),
            nomor: Yup.string().required('Nomor tidak boleh kosong'),
            tentang: Yup.string().required('Tentang tidak boleh kosong'),
        })

        return {
            formData,
            formSchema,
            files,
            fileTypes,
            onUpadateFiles,
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/master/peraturan/${this.selected}/edit`)
                .then(res => {
                    this.formData = res.data.data

                    if (res.data.data.file) {
                        this.files = [res.data.data.file]
                    }
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
        submit() {
            const data = new FormData(document.querySelector('form') as HTMLFormElement)

            if (this.files.length) {
                data.append('file', this.files[0].file)
            }

            block(this.$el)

            axios.post(this.selected ? `/master/peraturan/${this.selected}/update` : '/master/peraturan/store', data)
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
