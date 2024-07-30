<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Parameter</h2>
            <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Keterangan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="keterangan"
                            autocomplete="off" v-model="formData.keterangan" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="keterangan" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-3">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Jenis Parameter</label>
                        <Field type="hidden" v-model="formData.jenis_parameter_id" name="jenis_parameter_id" readonly />
                        <select2 placeholder="Pilih Jenis Parameter" class="form-select-solid" :options="jenisParameters"
                            name="jenis_parameter_id" v-model="formData.jenis_parameter_id">
                        </select2>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="jenis_parameter_id" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-3">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Metode</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="metode"
                            autocomplete="off" v-model="formData.metode" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="metode" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Harga</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="harga"
                            autocomplete="off" v-model="formData.harga"
                            oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="harga" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Pengawetan</label>
                        <Field type="hidden" v-model="formData.pengawetan_ids" name="pengawetan_ids" readonly />
                        <select2 placeholder="Pilih Pengawetan" class="form-select-solid" :options="pengawetans"
                            name="pengawetan_ids" v-model="formData.pengawetan_ids" multiple
                            :settings="{ allowClear: true, multiple: true }">
                        </select2>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="pengawetan_ids" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-2">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Satuan</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="satuan"
                            autocomplete="off" v-model="formData.satuan" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="satuan" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-2">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">MDL</label>
                        <Field class="form-control form-control-lg form-control-solid" type="number" name="mdl"
                            autocomplete="off" v-model="formData.mdl" pattern="^\d+(,\d{1,2})?$" step="any" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="mdl" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="separator my-10"></div>

                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Terakreditasi</label>
                        <vswitch class="form-check-custom form-check-solid" v-model="formData.is_akreditasi"></vswitch>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="is_akreditasi" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Dapat Diuji di Lab</label>
                        <vswitch class="form-check-custom form-check-solid" v-model="formData.is_dapat_diuji"></vswitch>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="is_dapat_diuji" />
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
import { useJenisParameter, usePengawetan } from '@/services';

interface FormData {
    nama: string;
    keterangan: string;
    metode: string;
    satuan: string;
    harga: string;
    mdl: string;
    is_akreditasi: boolean | number;
    pengawetan_ids: Array<string | number>;
    jenis_parameter_id: number | null;
    is_dapat_diuji: boolean | number;
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
        const formData = ref<FormData>({
            nama: '',
            keterangan: '',
            metode: '',
            satuan: '',
            harga: '',
            mdl: '',
            is_akreditasi: false,
            pengawetan_ids: [],
            jenis_parameter_id: null,
            is_dapat_diuji: false,
        } as FormData)

        const formSchema = Yup.object().shape({
            nama: Yup.string().required('Nama harus diisi'),
            metode: Yup.string().required('Metode harus diisi'),
            harga: Yup.string().required('Harga harus diisi'),
            jenis_parameter_id: Yup.number().required('Jenis Parameter harus diisi'),
        })

        const pengawetan = usePengawetan()
        const pengawetans = computed(() => pengawetan.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))

        const jenisParameter = useJenisParameter()
        const jenisParameters = computed(() => jenisParameter.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))

        return {
            formData,
            formSchema,
            pengawetans,
            jenisParameters
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/master/parameter/${this.selected}/edit`)
                .then(res => {
                    this.formData = res.data.data
                    this.formData.harga = res.data.data.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
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

            axios.post(this.selected ? `/master/parameter/${this.selected}/update` : '/master/parameter/store', this.formData)
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
