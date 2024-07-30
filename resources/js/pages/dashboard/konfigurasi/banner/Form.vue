<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Banner</h2>
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
                        <label class="form-label fw-bold text-dark fs-6 required">Banner</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="judul"
                            autocomplete="off" v-model="formData.judul" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="judul" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-12">
                    <div class="fv-row mb-10 w-100 mw-500px">
                        <!--begin::Label-->
                        <label class="form-label fw-bold required">Gambar <span class="text-muted fw-normal">(ratio
                                16:9)</span></label>
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

                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Link</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="link"
                            autocomplete="off" v-model="formData.link" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="link" />
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
    judul: string,
    gambar: string,
    link: string,
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
        const fileTypes = ref(['image/jpeg', 'image/png'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const formData = ref<FormData>({} as FormData)

        const formSchema = Yup.object().shape({
            judul: Yup.string().required('Judul wajib diisi'),
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

            axios.get(`/konfigurasi/banner/${this.selected}/edit`)
                .then(res => {
                    this.formData = res.data.data

                    if (res.data.data.gambar) {
                        this.files = [res.data.data.gambar]
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

            if (!this.files.length) {
                toast.error('Gambar wajib diisi')
                return
            }

            data.append('gambar', this.files[0].file)
            block(this.$el)

            axios.post(this.selected ? `/konfigurasi/banner/${this.selected}/update` : '/konfigurasi/banner/store', data)
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
