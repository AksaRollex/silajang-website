<template>
    <VForm @submit="submit" id="form-akun" :validation-schema="formSchema">
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold">Foto</label>
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
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">Nama</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="nama"
                autocomplete="off" v-model="user.nama" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="nama" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">Email</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="email"
                autocomplete="off" v-model="user.email" disabled />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="email" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">No. Telepon</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="phone"
                autocomplete="off" v-model="user.phone" disabled />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="phone" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Submit button-->
            <button tabindex="3" type="submit" ref="submitButton" class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">Simpan</span>

                <span class="indicator-progress">
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
            <!--end::Submit button-->
        </div>
        <!--end::Actions-->
    </VForm>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useAuthStore } from '@/stores/auth';
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { blockBtn, unblockBtn } from '@/libs/utils';
import { toast } from 'vue3-toastify';

export default defineComponent({
    setup() {
        const { user, setAuth } = useAuthStore()
        const files = ref<Array<File | String>>(user.photo ? [user.photo] : [])
        const fileTypes = ref(['image/jpeg', 'image/png'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const formSchema = Yup.object().shape({
            nama: Yup.string().required("Nama harus diisi"),
        });

        return {
            user,
            files,
            fileTypes,
            onUpadateFiles,
            formSchema,
            setAuth,
        }
    },
    methods: {
        submit() {
            const data = new FormData(document.getElementById('form-akun') as HTMLFormElement)

            if (this.files.length > 0) {
                data.append('photo', this.files[0].file)
            }

            blockBtn(this.$refs.submitButton as HTMLButtonElement)
            axios.post("/user/account", data).then(res => {
                toast.success(res.data.message)
                this.setAuth(res.data.data)
            }).catch(err => {
                toast.error(err.response.data.message)
            }).finally(() => {
                unblockBtn(this.$refs.submitButton as HTMLButtonElement)
            })
        }
    }
})
</script>
