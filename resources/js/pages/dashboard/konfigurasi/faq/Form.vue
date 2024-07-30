<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} FAQ</h2>
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
                        <label class="form-label fw-bold text-dark fs-6 required">Pertanyaan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="pertanyaan"
                            autocomplete="off" v-model="formData.pertanyaan" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="pertanyaan" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Jawaban</label>
                        <Field name="jawaban" autocomplete="off" v-model="formData.jawaban">
                            <textarea class="form-control form-control-lg form-control-solid" name="jawaban" rows="5"
                                v-model="formData.jawaban"></textarea>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="jawaban" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="separator separator-content my-10" style="white-space: nowrap;">English</div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Question</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="pertanyaan_en"
                            autocomplete="off" v-model="formData.pertanyaan_en" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="pertanyaan_en" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Answer</label>
                        <Field name="jawaban_en" autocomplete="off" v-model="formData.jawaban_en">
                            <textarea class="form-control form-control-lg form-control-solid" name="jawaban_en" rows="5"
                                v-model="formData.jawaban_en"></textarea>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="jawaban_en" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="separator separator-content my-10"></div>
                <div class="col-12">
                    <div class="fv-row mb-10 w-100 mw-500px">
                        <!--begin::Label-->
                        <label class="form-label fw-bold">Gambar</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files" :accepted-file-types="fileTypes"
                            v-on:updatefiles="onUpadateFiles"></file-upload>
                        <!--end::Input-->
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="photo" />
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
    pertanyaan: string,
    pertanyaan_en: string,
    jawaban: string,
    jawaban_en: string,
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
        const files = ref<Array<File | String>>([])
        const fileTypes = ref(['image/jpeg', 'image/png'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const formData = ref<FormData>({} as FormData)

        const formSchema = Yup.object().shape({
            pertanyaan: Yup.string().required('Pertanyaan harus diisi'),
            pertanyaan_en: Yup.string().required('Pertanyaan harus diisi'),
            jawaban: Yup.string().required('Jawaban harus diisi'),
            jawaban_en: Yup.string().required('Jawaban harus diisi'),
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

            axios.get(`/konfigurasi/faq/${this.selected}/edit`)
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

            if (this.files.length > 0) {
                data.append('gambar', this.files[0].file)
            }

            block(this.$el)

            axios.post(this.selected ? `/konfigurasi/faq/${this.selected}/update` : '/konfigurasi/faq/store', data)
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
