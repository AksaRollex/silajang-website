<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Kecamatan</h2>
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
                        <label class="form-label fw-bold text-dark fs-6">Kota/Kabupaten</label>
                        <Field type="hidden" v-model="formData.kab_kota_id" name="kab_kota_id" readonly />
                        <select2 placeholder="Pilih Kota/Kabupaten" class="form-select-solid" :options="kabKotas"
                            name="kab_kota_id" v-model="formData.kab_kota_id">
                        </select2>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="kab_kota_id" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Nama</label>
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
import { useKabKota } from '@/services';

interface FormData {
    nama: string,
    kab_kota_id: Number
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
        const formData = ref<FormData>({
            nama: '',
        })

        const formSchema = Yup.object().shape({
            nama: Yup.string().required('Nama tidak boleh kosong'),
            kab_kota_id: Yup.string().required('Kota/Kabupaten tidak boleh kosong'),
        })

        const kabKota = useKabKota()
        const kabKotas = computed(() => kabKota.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))

        return {
            formData,
            formSchema,
            kabKotas
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/master/kecamatan/${this.selected}/edit`)
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

            axios.post(this.selected ? `/master/kecamatan/${this.selected}/update` : '/master/kecamatan/store', this.formData)
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
    }
})
</script>
