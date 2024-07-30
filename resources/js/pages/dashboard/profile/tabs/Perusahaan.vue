<template>
    <VForm id="form-perusahaan" @submit="submit" :validation-schema="formSchema">
        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold">Tanda Tangan</label>
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
            <label class="form-label fw-bold required">Nama Perusahaan/Instansi</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="instansi"
                autocomplete="off" v-model="formData.instansi" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="instansi" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">Alamat</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="alamat"
                autocomplete="off" v-model="formData.alamat" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="alamat" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">Pimpinan</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="pimpinan"
                autocomplete="off" v-model="formData.pimpinan" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="pimpinan" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">PJ Mutu</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="pj_mutu"
                autocomplete="off" v-model="formData.pj_mutu" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="pj_mutu" />
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
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="telepon"
                autocomplete="off" v-model="formData.telepon" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="telepon" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold">FAX</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="fax"
                autocomplete="off" v-model="formData.fax" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="fax" />
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
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="email" name="email"
                autocomplete="off" v-model="formData.email" />
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
            <label class="form-label fw-bold required">Jenis Kegiatan</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="jenis_kegiatan"
                autocomplete="off" v-model="formData.jenis_kegiatan" />
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="jenis_kegiatan" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <div class="row">
            <div class="col-6">
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold required">Latitude</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="lat"
                        autocomplete="off" v-model="formData.lat" />
                    <!--end::Input-->
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">
                            <ErrorMessage name="lat" />
                        </div>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
            <div class="col-6">
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="form-label fw-bold required">Longitude</label>
                    <!--end::Label-->

                    <!--begin::Input-->
                    <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text" name="long"
                        autocomplete="off" v-model="formData.long" />
                    <!--end::Input-->
                    <div class="fv-plugins-message-container">
                        <div class="fv-help-block">
                            <ErrorMessage name="long" />
                        </div>
                    </div>

                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-light-primary mt-4 ms-auto" @click="getLatLong()">Lokasi
                            Saya</button>
                    </div>
                </div>
                <!--end::Input group-->
            </div>
        </div>

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">Kota/Kabupaten</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field type="hidden" v-model="formData.kab_kota_id" name="kab_kota_id" readonly />
            <select2 placeholder="Pilih Kecamatan" class="form-select-solid" :options="kabKotas" name="kab_kota_id"
                v-model="formData.kab_kota_id" @select="formData.kecamatan_id = undefined">
            </select2>
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="kab_kota_id" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">Kecamatan</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field type="hidden" v-model="formData.kecamatan_id" name="kecamatan_id" readonly />
            <select2 placeholder="Pilih Kecamatan" class="form-select-solid" :options="kecamatans" name="kecamatan_id"
                v-model="formData.kecamatan_id" @select="formData.kelurahan_id = undefined">
            </select2>
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="kecamatan_id" />
                </div>
            </div>
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fw-bold required">Kelurahan</label>
            <!--end::Label-->

            <!--begin::Input-->
            <Field type="hidden" v-model="formData.kelurahan_id" name="kelurahan_id" readonly />
            <select2 placeholder="Pilih Kelurahan" class="form-select-solid" :disabled="!formData.kecamatan_id"
                :options="kelurahans" name="kelurahan_id" v-model="formData.kelurahan_id">
            </select2>
            <!--end::Input-->
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="kelurahan_id" />
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
import { defineComponent, computed, ref } from 'vue'
import { useKabKota, useKecamatan, useKelurahan } from '@/services';
import { useAuthStore, type DetailUser } from '@/stores/auth';
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { blockBtn, unblockBtn } from '@/libs/utils';
import { toast } from 'vue3-toastify';

export default defineComponent({
    setup() {
        const { user, setAuth } = useAuthStore();
        const formData = ref<DetailUser>({ ...user.detail } as DetailUser)

        const files = ref<Array<File | String>>(user.detail?.tanda_tangan ? [user.detail?.tanda_tangan] : [])
        const fileTypes = ref(['image/jpeg', 'image/png'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const kabKota = useKabKota()
        const kabKotas = computed(() => kabKota.data.value?.map((prov) => ({
            id: prov.id,
            text: prov.nama
        })))

        const kotaId = computed(() => formData.value.kab_kota_id)
        const kecamatan = useKecamatan(kotaId, undefined, {
            enabled: !!kotaId.value
        })
        const kecamatans = computed(() => kecamatan.data.value?.map((prov) => ({
            id: prov.id,
            text: prov.nama
        })))

        const kecId = computed(() => formData.value.kecamatan_id)
        const kelurahan = useKelurahan(kecId, undefined, {
            enabled: !!kecId.value
        })
        const kelurahans = computed(() => kelurahan.data.value?.map((kelurahan) => ({
            id: kelurahan.id,
            text: kelurahan.nama
        })))

        const formSchema = Yup.object({
            instansi: Yup.string().required('Nama Perusahaan/Instansi harus diisi'),
            alamat: Yup.string().required('Alamat harus diisi'),
            pimpinan: Yup.string().required('Pimpinan harus diisi'),
            pj_mutu: Yup.string().required('PJ Mutu harus diisi'),
            telepon: Yup.string().matches(/^08[0-9]\d{8,11}$/, "No. Telepon tidak valid").required('No. Telepon harus diisi'),
            email: Yup.string().email('Email tidak valid').required('Email harus diisi'),
            jenis_kegiatan: Yup.string().required('Jenis Kegiatan harus diisi'),
            lat: Yup.string().required('Latitude harus diisi'),
            long: Yup.string().required('Longitude harus diisi'),
            kecamatan_id: Yup.string().required('Kecamatan harus diisi'),
            kelurahan_id: Yup.string().required('Kelurahan harus diisi'),
        })

        return {
            formData,
            kabKota,
            kabKotas,
            kecamatan,
            kecamatans,
            kelurahan,
            kelurahans,
            formSchema,
            setAuth,
            files,
            fileTypes,
            onUpadateFiles,
        }
    },
    methods: {
        submit() {
            const data = new FormData(document.getElementById('form-perusahaan') as HTMLFormElement)

            if (this.files.length > 0) {
                data.append('tanda_tangan', this.files[0].file)
            }

            blockBtn(this.$refs.submitButton as HTMLButtonElement)
            axios.post("/user/company", data).then(res => {
                toast.success(res.data.message)
                // this.setAuth(res.data.data)
                window.location.reload()
            }).catch(err => {
                toast.error(err.response.data.message)
            }).finally(() => {
                unblockBtn(this.$refs.submitButton as HTMLButtonElement)
            })
        },
        getLatLong() {
            navigator.geolocation.getCurrentPosition((position) => {
                this.formData.lat = position.coords.latitude
                this.formData.long = position.coords.longitude
            })
        }
    },
    watch: {
        'formData.kab_kota_id': function () {
            this.kecamatan.refetch()
        },
        'formData.kecamatan_id': function () {
            this.kelurahan.refetch()
        }
    }
})
</script>
