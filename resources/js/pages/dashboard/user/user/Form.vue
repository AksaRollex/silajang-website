<template>
    <VForm id="form-user" class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} User</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-4 d-flex justify-content-center pe-md-10">
                    <div class="fv-row mb-10 w-100">
                        <!--begin::Label-->
                        <label class="form-label fw-bold">Foto</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <file-upload v-bind:files="files" :accepted-file-types="fileTypes" v-on:updatefiles="onUpadateFiles"
                            stylePanelLayout="compact circle" styleButtonRemoveItemPosition="center bottom"
                            styleLoadIndicatorPosition="center bottom" imageCropAspectRatio="1:1"></file-upload>
                        <!--end::Input-->
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="photo" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
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
                            <div v-if="formData.golongan_id == 2" class="fv-row mb-7">
                                <label class="form-label fw-bold text-dark fs-6">NIP</label>
                                <Field class="form-control form-control-lg form-control-solid" type="text" name="nip"
                                    autocomplete="off" v-model="formData.nip" />
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="nip" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div v-if="formData.golongan_id == 2" class="fv-row mb-7">
                                <label class="form-label fw-bold text-dark fs-6">NIK</label>
                                <Field class="form-control form-control-lg form-control-solid" type="text" name="nik"
                                    autocomplete="off" v-model="formData.nik" />
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="nik" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-md-6">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="form-label fw-bold text-dark fs-6 required">Email</label>
                                <Field class="form-control form-control-lg form-control-solid" type="email" name="email"
                                    autocomplete="off" v-model="formData.email" />
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="email" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-md-6">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="form-label fw-bold text-dark fs-6 required">No. Telepon</label>
                                <Field class="form-control form-control-lg form-control-solid" type="text" name="phone"
                                    autocomplete="off" v-model="formData.phone" />
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="phone" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-md-6">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="form-label fw-bold text-dark fs-6 required">Jabatan</label>
                                <Field type="hidden" v-model="formData['role_ids[]']" name="role_ids[]" readonly />
                                <select2 placeholder="Pilih Jabatan" class="form-select-solid" :options="jabatans"
                                    v-model="formData['role_ids[]']" :settings="{ allowClear: true, multiple: true }">
                                </select2>
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="role_ids[]" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-md-6">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <label class="form-label fw-bold text-dark fs-6 required">Tipe</label>
                                <Field type="hidden" v-model="formData.golongan_id" name="golongan_id" readonly />
                                <select2 placeholder="Pilih Tipe" class="form-select-solid" :options="golongans"
                                    v-model="formData.golongan_id">
                                </select2>
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="golongan_id" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-12">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Tanda Tangan</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <file-upload v-bind:files="tandaTangan" :accepted-file-types="fileTypes"
                                    v-on:updatefiles="onUpadateTandaTangan"></file-upload>
                                <!--end::Input-->
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="photo" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="border border-bottom border-gray mt-8 mb-12"></div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Nama Instansi/Perusahaan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="detail[instansi]"
                            autocomplete="off" v-model="formData.detail.instansi" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[instansi]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Pimpinan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="detail[pimpinan]"
                            autocomplete="off" v-model="formData.detail.pimpinan" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[pimpinan]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Email</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="detail[email]"
                            autocomplete="off" v-model="formData.detail.email" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[email]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">No. Telepon</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="detail[telepon]"
                            autocomplete="off" v-model="formData.detail.telepon" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[telepon]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">FAX</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="detail[fax]"
                            autocomplete="off" v-model="formData.detail.fax" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[fax]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Jenis Kegiatan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text"
                            name="detail[jenis_kegiatan]" autocomplete="off" v-model="formData.detail.jenis_kegiatan" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[jenis_kegiatan]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">PJ Mutu</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="detail[pj_mutu]"
                            autocomplete="off" v-model="formData.detail.pj_mutu" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[pj_mutu]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="border border-bottom border-gray mt-8 mb-12"></div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Latitude</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text"
                                    name="detail[lat]" autocomplete="off" v-model="formData.detail.lat" />
                                <!--end::Input-->
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="detail[lat]" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <div class="col-6">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-bold">Longitude</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <Field tabindex="1" class="form-control form-control-lg form-control-solid" type="text"
                                    name="detail[long]" autocomplete="off" v-model="formData.detail.long" />
                                <!--end::Input-->
                                <div class="fv-plugins-message-container">
                                    <div class="fv-help-block">
                                        <ErrorMessage name="detail[long]" />
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Alamat</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="detail[alamat]"
                            autocomplete="off" v-model="formData.detail.alamat" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[alamat]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-bold">Kecamatan</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <Field type="hidden" v-model="formData.detail.kecamatan_id" name="detail[kecamatan_id]" readonly />
                        <select2 placeholder="Pilih Kecamatan" class="form-select-solid" :options="kecamatans"
                            v-model="formData.detail.kecamatan_id" @select="formData.detail.kelurahan_id = undefined">
                        </select2>
                        <!--end::Input-->
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[kecamatan_id]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label fw-bold">Kelurahan</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <Field type="hidden" v-model="formData.detail.kelurahan_id" name="detail[kelurahan_id]" readonly />
                        <select2 placeholder="Pilih Kelurahan" class="form-select-solid"
                            :disabled="!formData.detail?.kecamatan_id" :options="kelurahans"
                            v-model="formData.detail.kelurahan_id">
                        </select2>
                        <!--end::Input-->
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="detail[kelurahan_id]" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div class="border border-bottom border-gray mt-8 mb-12"></div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Password</label>
                        <div v-if="selected" class="text-muted">*) Kosongkan jika tidak diubah</div>
                        <div class="position-relative mb-3">
                            <!--begin::Input-->
                            <Field tabindex="2" class="form-control form-control-lg form-control-solid" type="password"
                                name="password" v-model="formData.password" autocomplete="off" />
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
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Konfirmasi Password</label>
                        <div v-if="selected" class="text-muted">*) Kosongkan jika tidak diubah</div>
                        <div class="position-relative mb-3">
                            <!--begin::Input-->
                            <Field class="form-control form-control-lg form-control-solid" type="password"
                                name="password_confirmation" autocomplete="off" v-model="formData.password_confirmation" />
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
import { computed, defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useJabatan, useKecamatan, useKelurahan } from '@/services';

export interface DetailUser {
    instansi: string;
    alamat: string;
    pimpinan: string;
    pj_mutu: string;
    telepon: string;
    fax: string;
    email: string;
    kecamatan_id: number | undefined | null;
    kelurahan_id: number | undefined | null;
    lat: number;
    long: number;
    jenis_kegiatan: string;
}

export interface FormData {
    nama: string;
    nip: string;
    email: string;
    password?: string;
    password_confirmation?: string;
    phone: string;
    photo?: string;
    golongan_id?: number | undefined | null;
    golongan?: {
        uuid: string;
        nama: string;
    },
    detail?: DetailUser;
    role_id?: number | undefined | null;
    'role_ids[]'?: Array<number>;
    role?: {
        name: string;
        full_name: string;
    };
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
        const fileTypes = ref(['image/jpeg', 'image/png'])
        const onUpadateFiles = (newFiles: Array<File | String>) => {
            files.value = newFiles
        }

        const tandaTangan = ref<Array<File | String>>([])
        const onUpadateTandaTangan = (newFiles: Array<File | String>) => {
            tandaTangan.value = newFiles
        }

        const jabatan = useJabatan()
        const jabatans = computed(() => jabatan.data.value?.map(item => ({
            id: item.id,
            text: item.full_name
        })))

        const golongans = ref<Array<any>>([{
            id: 1,
            text: 'Customer'
        }, {
            id: 2,
            text: 'Dinas Internal'
        }])

        const formData = ref<FormData>({
            nama: '',
            nip: '',
            email: '',
            phone: '',
            photo: '',
            golongan_id: undefined,
            detail: {
                instansi: '',
                alamat: '',
                pimpinan: '',
                pj_mutu: '',
                telepon: '',
                fax: '',
                email: '',
                kecamatan_id: null,
                kelurahan_id: null,
                lat: 0,
                long: 0,
                jenis_kegiatan: ''
            }
        })

        const formSchema = Yup.object().shape({
            nama: Yup.string().required('Nama harus diisi'),
            email: Yup.string().email('Email tidak valid').required('Email harus diisi'),
            phone: Yup.string().matches(/^08[0-9]\d{8,11}$/, "No. Telepon tidak valid").required('No. HP harus diisi'),
            golongan_id: Yup.number().required('Golongan harus diisi'),
            // role_id: Yup.number().required('Role harus diisi'),
            'role_ids[]': Yup.array().test({
                name: 'required',
                message: 'Jabatan harus diisi',
                test: (value: any) => {
                    return value?.length > 0
                }
            }),
            ...(!props.selected ? {
                password: Yup.string().required('Password harus diisi'),
                password_confirmation: Yup.string().required('Konfirmasi Password harus diisi').oneOf([Yup.ref('password')], 'Konfirmasi Password tidak sesuai'),
            } : {
                password: Yup.string(),
                password_confirmation: Yup.string().oneOf([Yup.ref('password')], 'Konfirmasi Password tidak sesuai'),
            })
        })

        const kecamatan = useKecamatan()
        const kecamatans = computed(() => kecamatan.data.value?.map((prov) => ({
            id: prov.id,
            text: prov.nama
        })))

        const kecId = computed(() => formData.value.detail?.kecamatan_id)
        const kelurahan = useKelurahan(kecId, undefined, {
            enabled: !!kecId.value
        })
        const kelurahans = computed(() => kelurahan.data.value?.map((kelurahan) => ({
            id: kelurahan.id,
            text: kelurahan.nama
        })))

        return {
            formData,
            formSchema,
            files,
            fileTypes,
            onUpadateFiles,
            tandaTangan,
            onUpadateTandaTangan,
            jabatans,
            golongans,
            kecamatans,
            kelurahan,
            kelurahans,
        }
    },
    methods: {
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
        },
        getEdit() {
            block(this.$el)

            axios.get(`/master/user/${this.selected}/edit`)
                .then(res => {
                    this.formData = res.data.data
                    this.formData['role_ids[]'] = res.data.data.role_ids

                    if (res.data.data.photo) {
                        this.files = [res.data.data.photo]
                    }

                    if (res.data.data.detail?.tanda_tangan) {
                        this.tandaTangan = [res.data.data.detail.tanda_tangan]
                    }

                    if (!res.data.data.detail) {
                        this.formData.detail = {
                            instansi: '',
                            alamat: '',
                            pimpinan: '',
                            pj_mutu: '',
                            telepon: '',
                            fax: '',
                            email: '',
                            kecamatan_id: null,
                            kelurahan_id: null,
                            lat: 0,
                            long: 0,
                            jenis_kegiatan: ''
                        }

                        navigator.geolocation.getCurrentPosition((position) => {
                            this.formData.detail.lat = position.coords.latitude
                            this.formData.detail.long = position.coords.longitude
                        })
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
            const data = new FormData(document.getElementById('form-user') as HTMLFormElement)

            if (this.files.length > 0) {
                data.append('photo', this.files[0].file)
            }

            if (this.tandaTangan.length > 0) {
                data.append('tanda_tangan', this.tandaTangan[0].file)
            }

            block(this.$el)
            axios.post(this.selected ? `/master/user/${this.selected}/update` : '/master/user/store', data)
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
        },
        'formData.detail?.kecamatan_id': function (val) {
            this.kelurahan.refetch()
        },
        'formData.role_ids[]': function (val) {
            if (val.find(item => ['1', '2', '3', '4', '5', '6'].includes(item))) {
                this.formData.golongan_id = 2
            } else if (val.includes('7')) {
                this.formData.golongan_id = 1
            } else if (!val.length) {
                this.formData.golongan_id = null
            }
        }
    }
})
</script>
