<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">Konfigurasi Website</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-8">
                        <label class="form-label fw-bold text-dark fs-6 required">Nama Aplikasi</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="app"
                            autocomplete="off" v-model="formData.app" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="app" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-8">
                        <label class="form-label fw-bold text-dark fs-6 required">Deskripsi</label>
                        <Field class="form-control form-control-lg form-control-solid" type="textarea" name="description"
                            autocomplete="off" v-model="formData.description" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="description" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-8">
                        <label class="form-label fw-bold text-dark fs-6 required">Dinas</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="dinas"
                            autocomplete="off" v-model="formData.dinas" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="dinas" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-8">
                        <label class="form-label fw-bold text-dark fs-6 required">Pemerintahan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="pemerintah"
                            autocomplete="off" v-model="formData.pemerintah" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="pemerintah" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-8">
                        <label class="form-label fw-bold text-dark fs-6 required">Alamat</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="alamat"
                            autocomplete="off" v-model="formData.alamat" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="alamat" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-8">
                        <label class="form-label fw-bold text-dark fs-6 required">Telepon</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="telepon"
                            autocomplete="off" v-model="formData.telepon" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="telepon" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                    <!--begin::Input group-->
                    <div class="fv-row mb-8">
                        <label class="form-label fw-bold text-dark fs-6 required">Email</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="email"
                            autocomplete="off" v-model="formData.email" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="email" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-12 d-md-none">
                    <div class="border border-bottom border-gray mt-8 mb-12"></div>
                </div>

                <div class="col-md-6">
                    <div class="fv-row mb-8">
                        <!--begin::Label-->
                        <label class="form-label fw-bold required">Logo Dalam (Dashboard)</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files.logoDalam" :accepted-file-types="fileTypes" required
                            v-on:updatefiles="file => files.logoDalam = file"></file-upload>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-8">
                        <!--begin::Label-->
                        <label class="form-label fw-bold required">Logo Depan</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files.logoDepan" :accepted-file-types="fileTypes" v-bind:required="true"
                            v-on:updatefiles="file => files.logoDepan = file"></file-upload>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-8">
                        <!--begin::Label-->
                        <label class="form-label fw-bold required">Banner</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files.banner" :accepted-file-types="fileTypes" required
                            v-on:updatefiles="file => files.banner = file"></file-upload>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-8">
                        <!--begin::Label-->
                        <label class="form-label fw-bold required">Background Login</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files.bgAuth" :accepted-file-types="fileTypes" required
                            v-on:updatefiles="file => files.bgAuth = file"></file-upload>
                        <!--end::Input-->
                    </div>

                    <div class="border border-bottom border-gray my-12"></div>

                    <div class="fv-row mb-8">
                        <!--begin::Label-->
                        <label class="form-label fw-bold required">KOP Sertifikat</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files.kopApp" :accepted-file-types="fileTypes" required
                            v-on:updatefiles="file => files.kopApp = file"></file-upload>
                        <!--end::Input-->
                    </div>

                    <div class="fv-row mb-8">
                        <!--begin::Label-->
                        <label class="form-label fw-bold required">KOP SNI</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files.kopSni" :accepted-file-types="fileTypes" required
                            v-on:updatefiles="file => files.kopSni = file"></file-upload>
                        <!--end::Input-->
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
import { useSetting } from '@/services';

interface FormData {
    alamat: string;
    app: string;
    description: string;
    dinas: string;
    email: string;
    logo_dalam: Array<File | string> | string;
    logo_depan: Array<File | string> | string;
    banner: Array<File | string> | string;
    kop_app: Array<File | string> | string;
    kop_sni: Array<File | string> | string;
    pemerintah: string;
    telepon: string;
}

export default defineComponent({
    props: {
        selected: {
            type: String,
            default: null
        },
    },
    setup() {
        const setting = useSetting()
        const formData = ref<FormData>({ ...setting.data?.value })

        const fileTypes = ref(['image/jpeg', 'image/png'])
        const files = ref({
            logoDalam: setting.data?.value?.logo_dalam ? [setting.data.value.logo_dalam] : [],
            logoDepan: setting.data?.value?.logo_depan ? [setting.data.value.logo_depan] : [],
            banner: setting.data?.value?.banner ? [setting.data.value.banner] : [],
            bgAuth: setting.data?.value?.bg_auth ? [setting.data.value.bg_auth] : [],
            kopApp: setting.data?.value?.kop_app ? [setting.data.value.kop_app] : [],
            kopSni: setting.data?.value?.kop_sni ? [setting.data.value.kop_sni] : [],
        })

        const formSchema = Yup.object().shape({
            alamat: Yup.string().required('Alamat wajib diisi'),
            app: Yup.string().required('Nama aplikasi wajib diisi'),
            description: Yup.string().required('Deskripsi wajib diisi'),
            dinas: Yup.string().required('Nama dinas wajib diisi'),
            email: Yup.string().required('Email wajib diisi'),
            pemerintah: Yup.string().required('Nama pemerintah wajib diisi'),
            telepon: Yup.string().required('Telepon wajib diisi'),
        })

        return {
            setting,
            formData,
            formSchema,
            fileTypes,
            files
        }
    },
    methods: {
        submit() {
            const data = new FormData(this.$el)

            data.append('logo_dalam', this.files.logoDalam[0].file)
            data.append('logo_depan', this.files.logoDepan[0].file)
            data.append('banner', this.files.banner[0].file)
            data.append('bg_auth', this.files.bgAuth[0].file)
            data.append('kop_app', this.files.kopApp[0]?.file)
            data.append('kop_sni', this.files.kopSni[0]?.file)

            block(this.$el)
            axios.post("/konfigurasi/setting", data)
                .then((res) => {
                    toast.success(res.data.message)
                    this.setting.refetch()
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        }
    },
    watch: {
        setting: {
            handler(setting) {
                this.formData = setting.data.value

                this.files.logoDalam = setting.data.value.logo_dalam ? [setting.data.value.logo_dalam] : []
                this.files.logoDepan = setting.data.value.logo_depan ? [setting.data.value.logo_depan] : []
                this.files.banner = setting.data.value.banner ? [setting.data.value.banner] : []
                this.files.bgAuth = setting.data.value.bg_auth ? [setting.data.value.bg_auth] : []
                this.files.kopApp = setting.data.value.kop_app ? [setting.data.value.kop_app] : []
                this.files.kopSni = setting.data.value.kop_sni ? [setting.data.value.kop_sni] : []
            },
            deep: true
        }
    }
})
</script>
