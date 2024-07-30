<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Permohonan</h2>
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
                        <label class="form-label fw-bold text-dark fs-6 required">Nama Industri</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="industri"
                            autocomplete="off" v-model="formData.industri" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="industri" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Kegiatan Industri</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="kegiatan"
                            autocomplete="off" v-model="formData.kegiatan" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="kegiatan" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Alamat Industri</label>
                        <Field name="alamat" autocomplete="off" v-model="formData.alamat">
                            <textarea class="form-control form-control-lg form-control-solid" name="alamat" rows="3"
                                v-model="formData.alamat"></textarea>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="alamat" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
            </div>

            <div v-if="!$props.selected" class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Cara Pengambilan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="radio" name="is_mandiri"
                            autocomplete="off" v-model="formData.is_mandiri">
                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="is_mandiri" value="1" id="kirim_mandiri"
                                v-model="formData.is_mandiri" />
                            <label
                                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                for="kirim_mandiri">
                                <i class="ki-duotone ki-delivery-3  fs-1 me-4">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                </i>

                                <span class="d-block fw-semibold text-start">
                                    <span class="text-dark fw-bold d-block fs-3">Kirim Mandiri</span>
                                    <span class="text-muted fw-semibold fs-6">
                                        Kirim Sample Uji Anda Ke Laboratorium Dinas.
                                    </span>
                                </span>
                            </label>
                            <!--end::Option-->
                        </Field>
                        <Field class="form-control form-control-lg form-control-solid" type="radio" name="is_mandiri"
                            autocomplete="off" v-model="formData.is_mandiri">
                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="is_mandiri" value="0" id="ambil_petugas"
                                v-model="formData.is_mandiri" />
                            <label
                                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                for="ambil_petugas">
                                <i class="ki-duotone ki-truck fs-1 me-4">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                </i>

                                <span class="d-block fw-semibold text-start">
                                    <span class="text-dark fw-bold d-block fs-3">Ambil Petugas</span>
                                    <span class="text-muted fw-semibold fs-6">
                                        Petugas Akan Menghubungi Anda Untuk Konfirmasi Lokasi Pengambilan.
                                    </span>
                                </span>
                            </label>
                            <!--end::Option-->
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="is_mandiri" />
                            </div>
                        </div>
                    </div>

                    <!--begin::Input group-->
                    <div v-if="formData.is_mandiri == 0" class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Wilayah Pengambilan</label>
                        <Field v-model="formData.jasa_pengambilan_id" name="jasa_pengambilan_id">
                            <select2 placeholder="Pilih Wilayah Pengambilan" class="form-select-solid"
                                name="jasa_pengambilan_id" :options="jasaPengambilans"
                                v-model="formData.jasa_pengambilan_id">
                            </select2>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="jasa_pengambilan_id" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Opsi Pembayaran</label>
                        <!-- <Field class="form-control form-control-lg form-control-solid" type="radio" name="pembayaran"
                            autocomplete="off" v-model="formData.pembayaran">
                            <input type="radio" class="btn-check" name="pembayaran" value="tunai" id="cash"
                                v-model="formData.pembayaran" />
                            <label
                                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                for="cash">
                                <i class="ki-duotone ki-dollar fs-1 me-4">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                </i>

                                <span class="d-block fw-semibold text-start">
                                    <span class="text-dark fw-bold d-block fs-3">Cash <span
                                            class="fw-normal fs-6">(Tunai)</span></span>
                                    <span class="text-muted fw-semibold fs-6">
                                        Bayar Dimuka atau Ketika Sertifikat Sudah Jadi
                                    </span>
                                </span>
                            </label>
                        </Field> -->
                        <Field class="form-control form-control-lg form-control-solid" type="radio" name="pembayaran"
                            autocomplete="off" v-model="formData.pembayaran">
                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="pembayaran" value="transfer" id="transfer"
                                v-model="formData.pembayaran" />
                            <label
                                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                for="transfer">
                                <i class="ki-duotone ki-two-credit-cart fs-1 me-4">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                    <i class="path3"></i>
                                    <i class="path4"></i>
                                    <i class="path5"></i>
                                </i>

                                <span class="d-block fw-semibold text-start">
                                    <span class="text-dark fw-bold d-block fs-3">Transfer <span class="fw-normal fs-6">(non
                                            Tunai)</span></span>
                                    <span class="text-muted fw-semibold fs-6">
                                        Transfer Virtual Account Bank Jatim, Untuk Nomor VA Akan di Infomasikan oleh
                                        Bendahara UPT
                                    </span>
                                </span>
                            </label>
                            <!--end::Option-->
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="pembayaran" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="border border-bottom border-gray mt-8 mb-12"></div>

            <div class="row">
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Keterangan</label>
                        <Field name="keterangan" autocomplete="off" v-model="formData.keterangan">
                            <textarea class="form-control form-control-lg form-control-solid" name="keterangan" rows="3"
                                v-model="formData.keterangan"></textarea>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="keterangan" />
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
import { block, currency, unblock } from '@/libs/utils';
import { computed, defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useJasaPengambilan } from '@/services';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

interface FormData {
    industri: string;
    keterangan: string;
    kegiatan: string;
    alamat: string;
    pembayaran: string;
    is_mandiri: boolean | number;
    jasa_pengambilan_id?: number;
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
        const { user } = useAuthStore()
        const formData = ref<FormData>({
            pembayaran: 'transfer'
        } as FormData)
        const router = useRouter()

        const formSchema = Yup.object().shape({
            industri: Yup.string().required('Nama Industri harus diisi'),
            kegiatan: Yup.string().required('Kegiatan Industri harus diisi'),
            alamat: Yup.string().required('Alamat Industri harus diisi'),
            ...(!props.selected && {
                pembayaran: Yup.string().required('Harap pilih Opsi Pembayaran'),
                is_mandiri: Yup.string().required('Harap pilih Cara Pengambilan'),
                jasa_pengambilan_id: Yup.string().when('is_mandiri', function (is_mandiri: any) {
                    return is_mandiri == 0 ? Yup.string().required('Wilayah Pengambilan harus diisi') : Yup.string()
                }),
            })
        })

        const jasaPengambilan = useJasaPengambilan()
        const jasaPengambilans = computed(() => jasaPengambilan.data.value?.map(item => ({
            id: item.id,
            text: `${item.wilayah} - ${currency(item.harga)}`
        })))

        return {
            user,
            formData,
            formSchema,
            jasaPengambilans,
            router
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/permohonan/${this.selected}/edit`)
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

            axios.post(this.selected ? `/permohonan/${this.selected}/update` : '/permohonan/store', this.formData)
                .then((res) => {
                    toast.success('Data berhasil disimpan')

                    if (this.$props.selected) {
                        this.$emit('close')
                        this.$emit('refresh')
                    } else {
                        this.router.push(`/dashboard/pengujian/permohonan/${res.data.data.uuid}`)
                    }
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
        this.formData.industri = this.user.detail?.instansi ?? ''
        this.formData.kegiatan = this.user.detail?.jenis_kegiatan ?? ''
        this.formData.alamat = this.user.detail?.alamat ?? ''

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
        'formData.is_mandiri': function (val: any) {
            if (val == 1) {
                this.formData.jasa_pengambilan_id = undefined
            }
        }
    }
})
</script>
