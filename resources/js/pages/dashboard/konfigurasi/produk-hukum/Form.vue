<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Produk Hukum</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
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

                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Deskripsi</label>
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

                <div class="col-12">
                    <div class="separator separator-content my-10" style="white-space: nowrap;">Item</div>

                    <template v-for="(item, i) in formData.items" :key="item.id">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <div class="d-flex gap-4 align-items-center mb-2">
                                <button class="btn btn-sm btn-light-danger btn-icon" @click="removeItem(item)">
                                    <i class="la la-times"></i>
                                </button>
                                <label class="form-label fw-bold text-dark fs-6 required">Item</label>
                            </div>
                            <Field class="form-control form-control-lg form-control-solid" type="text"
                                :name="`item[${i}].nama`" autocomplete="off" v-model="item.nama" />
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="nama" />
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <div class="fv-row mb-10 w-100">
                            <!--begin::Input-->
                            <Field class="form-control form-control-lg form-control-solid" type="text"
                                :name="`item[${i}].file`" autocomplete="off" v-model="item.file">
                                <file-upload v-bind:files="item.file" :accepted-file-types="fileTypes"
                                    v-on:updatefiles="(file) => item.file = file"></file-upload>
                            </Field>
                            <!--end::Input-->
                            <div class="fv-plugins-message-container">
                                <div class="fv-help-block">
                                    <ErrorMessage name="file" />
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="d-flex">
                        <button class="btn btn-light-primary btn-sm ms-auto" @click="addItem" type="button">
                            Tambah <i class="la la-plus fs-4"></i>
                        </button>
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
    deskripsi: string,
    items: Array<any>,
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
        const files = ref<Array<File | String>>([])
        const fileTypes = ref(['application/pdf'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const formData = ref<FormData>({
            nama: '',
            deskripsi: '',
            items: [],
        } as FormData)

        const formSchema = Yup.object().shape({
            nama: Yup.string().required('Nama harus diisi'),
            items: Yup.array().min(1, 'Minimal 1 item').of(
                Yup.object().shape({
                    nama: Yup.string().required('Nama harus diisi'),
                    file: Yup.mixed().required('File harus diisi'),
                })
            )
        })

        const editor = ref<any>(window.ClassicEditor)

        const removeImage = (imageSrc) => axios.post('/konfigurasi/produk-hukum/remove-image', { image: imageSrc }).catch(err => {
            toast.error(err.response.data.message)
        })

        const editorConfig = ref<any>({
            simpleUpload: {
                uploadUrl: `${import.meta.env.VITE_APP_API_URL}/konfigurasi/produk-hukum/upload-image`,
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
            files,
            fileTypes,
            onUpadateFiles,
            editor,
            editorConfig,
        }
    },
    methods: {
        addItem() {
            this.formData.items.push({
                id: Date.now(),
                nama: '',
                file: '',
            })
        },
        removeItem(item: any) {
            this.formData.items = this.formData.items.filter((i: any) => i.id !== item.id)
        },
        getEdit() {
            block(this.$el)

            axios.get(`/konfigurasi/produk-hukum/${this.selected}/edit`)
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

            const formData = new FormData()
            formData.append('nama', this.formData.nama)
            formData.append('deskripsi', this.formData.deskripsi ?? '')

            this.formData.items.forEach((item, index) => {
                formData.append(`items[${index}][nama]`, item.nama)
                formData.append(`items[${index}][file]`, item.file[0]?.file)
            })

            axios.post(this.selected ? `/konfigurasi/produk-hukum/${this.selected}/update` : '/konfigurasi/produk-hukum/store', formData)
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
