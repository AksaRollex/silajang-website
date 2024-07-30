<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Layanan</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="separator separator-content my-10" style="white-space: nowrap;">Indonesia</div>
                <div class="col-12">
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
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Deskripsi</label>
                        <Field name="deskripsi" autocomplete="off" v-model="formData.deskripsi">
                            <ckeditor :editor="editor" v-model="formData.deskripsi" :config="editorConfig"></ckeditor>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="deskripsi" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="separator separator-content my-10" style="white-space: nowrap;">English</div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Name</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="nama_en"
                            autocomplete="off" v-model="formData.nama_en" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="nama_en" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Description</label>
                        <Field name="deskripsi_en" autocomplete="off" v-model="formData.deskripsi_en">
                            <ckeditor :editor="editor" v-model="formData.deskripsi_en" :config="editorConfig"></ckeditor>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="deskripsi_en" />
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
    nama: string,
    nama_en: string,
    deskripsi: string,
    deskripsi_en: string,
    gambar: string,
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
            nama: Yup.string().required('Nama harus diisi'),
            nama_en: Yup.string().required('Nama harus diisi'),
            deskripsi: Yup.string().required('Deskripsi harus diisi'),
            deskripsi_en: Yup.string().required('Deskripsi harus diisi'),
        })

        const editor = ref<any>(window.ClassicEditor)
        const editorID = ref<any>(null)
        const editorEN = ref<any>(null)

        const removeImage = (imageSrc) => axios.post('/konfigurasi/layanan/remove-image', { image: imageSrc }).catch(err => {
            toast.error(err.response.data.message)
        })

        const editorConfig = ref<any>({
            simpleUpload: {
                uploadUrl: `${import.meta.env.VITE_APP_API_URL}/konfigurasi/layanan/upload-image`,
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
                },
            },
            imageRemoveEvent: {
                callback: removeImage,
            },
        })

        return {
            formData,
            formSchema,
            editor,
            editorID,
            editorEN,
            editorConfig,
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/konfigurasi/layanan/${this.selected}/edit`)
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

            axios.post(this.selected ? `/konfigurasi/layanan/${this.selected}/update` : '/konfigurasi/layanan/store', this.formData)
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
