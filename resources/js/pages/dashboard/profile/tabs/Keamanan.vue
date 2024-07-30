<template>
    <VForm @submit="submit" id="form-akun" :validation-schema="formSchema">
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <label class="form-label fw-bold text-dark fs-6">Password Lama</label>
            <div class="position-relative mb-3">
                <!--begin::Input-->
                <Field class="form-control form-control-lg form-control-solid" type="password" name="old_password"
                    autocomplete="off" v-model="formData.old_password" />
                <!--end::Input-->

                <!--begin::Visibility toggle-->
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
                    <i class="bi bi-eye-slash fs-2" @click="toggleOldPassword"></i>
                </span>
                <!--end::Visibility toggle-->
            </div>
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="old_password" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <label class="form-label fw-bold text-dark fs-6">Password Baru</label>
            <div class="position-relative mb-3">
                <!--begin::Input-->
                <Field class="form-control form-control-lg form-control-solid" type="password" name="password"
                    autocomplete="off" v-model="formData.password" />
                <!--end::Input-->

                <!--begin::Visibility toggle-->
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
                    <i class="bi bi-eye-slash fs-2" @click="togglePassword"></i>
                </span>
                <!--end::Visibility toggle-->
            </div>
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="password" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <label class="form-label fw-bold text-dark fs-6">Konfirmasi Password Baru</label>
            <div class="position-relative mb-3">
                <!--begin::Input-->
                <Field class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation"
                    autocomplete="off" v-model="formData.password_confirmation" />
                <!--end::Input-->

                <!--begin::Visibility toggle-->
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2">
                    <i class="bi bi-eye-slash fs-2" @click="toggleConfirmPassword"></i>
                </span>
                <!--end::Visibility toggle-->
            </div>
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="password_confirmation" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Submit button-->
            <button tabindex="3" type="submit" ref="submitButton" class="btn btn-lg btn-primary w-100 mb-5">
                <span class="indicator-label">Ubah Password</span>

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
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { blockBtn, unblockBtn } from '@/libs/utils';
import { toast } from 'vue3-toastify';

export default defineComponent({
    setup() {
        const formData = ref<any>({})
        const formSchema = Yup.object().shape({
            old_password: Yup.string().required("Password Lama harus diisi"),
            password: Yup.string().required("Password Baru harus diisi").min(12, 'Password minimal terdiri dari 12 karakter'),
            password_confirmation: Yup.string().required("Konfirmasi Password Baru harus diisi").min(12, 'Password minimal terdiri dari 12 karakter'),
        });

        return {
            formData,
            formSchema,
        }
    },
    methods: {
        submit() {
            blockBtn(this.$refs.submitButton as HTMLButtonElement)
            axios.post("/user/security", this.formData).then(res => {
                toast.success(res.data.message)
                this.formData = {}
            }).catch(err => {
                toast.error(err.response.data.message)
            }).finally(() => {
                unblockBtn(this.$refs.submitButton as HTMLButtonElement)
            })
        },
        toggleOldPassword(ev) {
            const type = document.querySelector("[name=old_password]").type;

            if (type === 'password') {
                document.querySelector("[name=old_password]").type = 'text';
                ev.target.classList.add("bi-eye");
                ev.target.classList.remove("bi-eye-slash");
            } else {
                document.querySelector("[name=old_password]").type = 'password';
                ev.target.classList.remove("bi-eye");
                ev.target.classList.add("bi-eye-slash");
            }
        },
        togglePassword(ev) {
            const type = document.querySelector("[name=password]").type;

            if (type === 'password') {
                document.querySelector("[name=password]").type = 'text';
                ev.target.classList.add("bi-eye");
                ev.target.classList.remove("bi-eye-slash");
            } else {
                document.querySelector("[name=password]").type = 'password';
                ev.target.classList.remove("bi-eye");
                ev.target.classList.add("bi-eye-slash");
            }
        },
        toggleConfirmPassword(ev) {
            const type = document.querySelector("[name=password_confirmation]").type;

            if (type === 'password') {
                document.querySelector("[name=password_confirmation]").type = 'text';
                ev.target.classList.add("bi-eye");
                ev.target.classList.remove("bi-eye-slash");
            } else {
                document.querySelector("[name=password_confirmation]").type = 'password';
                ev.target.classList.remove("bi-eye");
                ev.target.classList.add("bi-eye-slash");
            }
        }
    }
})
</script>
