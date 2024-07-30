<template>
    <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <div class="d-flex align-items-center">
                <button v-if="formData.va_number" type="button" class="btn btn-sm btn-light-danger btn-icon me-4"
                    @click="$emit('close')">
                    <i class="la la-arrow-left fs-2"></i>
                </button>
                <h2 class="mb-0">{{ selected ? 'Detail' : 'Buat' }} VA Pembayaran</h2>
            </div>
            <button v-if="!formData.va_number" type="button" class="btn btn-sm btn-light-danger ms-auto"
                @click="$emit('close')">
                Batal
                <i class="la la-times-circle p-0"></i>
            </button>
        </div>
        <div class="card-body">
            <div v-if="formData.va_number" class="row row-gap-8 mb-20">
                <div class="col-12" v-if="formData.is_expired === false">
                    <div class="bg-primary text-white py-1 rounded-1 text-center">Lakukan pembayaran sebelum: <strong>{{
                        countdownExp }}</strong>
                    </div>
                </div>
                <div class="col-12" v-else>
                    <div class="bg-danger text-white py-1 rounded-1 text-center">VA Pembayaran telah kedaluwarsa</div>
                </div>
                <div class="col-md-6">
                    <div :class="`card ${formData.is_expired ? 'opacity-25' : ''}`"
                        :style="`cursor: ${formData.is_expired ? 'not-allowed' : 'default'}`">
                        <div class="card-header align-items-center min-h-50px">
                            <h5 class="mb-0">Virtual Account</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex bg-light rounded-2 p-4 gap-8 align-items-center flex-wrap">
                                <img src="/media/bank-jatim.png" class="w-75px">
                                <strong class="fs-1 text-primary">{{ formData.va_number }}</strong>
                                <button class="btn text-success p-0 ms-auto" :disabled="formData.is_expired"
                                    @click="copyString(formData.va_number)">Salin</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div :class="`card ${formData.is_expired ? 'opacity-25' : ''}`"
                        :style="`cursor: ${formData.is_expired ? 'not-allowed' : 'default'}`">
                        <div class="card-header align-items-center min-h-50px">
                            <h5 class="mb-0">Nominal Pembayaran</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex bg-light rounded-2 p-4 gap-8 align-items-center">
                                <strong class="fs-1 text-primary">{{ currency(formData.jumlah) }}</strong>
                                <button class="btn text-success p-0 ms-auto" :disabled="formData.is_expired"
                                    @click="copyString(formData.jumlah)">Salin</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Kode Retribusi</label>
                        <Field type="hidden" v-model="formData.kode_retribusi_id" name="kode_retribusi_id" readonly />
                        <select2 placeholder="Pilih Kode Retribusi" class="form-select-solid" :options="kodeRetribusis"
                            name="kode_retribusi_id" v-model="formData.kode_retribusi_id">
                        </select2>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="kode_retribusi_id" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-5">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Atas Nama</label>
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
                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Jumlah Nominal</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="jumlah"
                            autocomplete="off" v-model="formData.jumlah"
                            oninput="this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.')" />
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="jumlah" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-md-4">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6 required">Tanggal Kedaluwarsa</label>
                        <Field v-model="formData.tanggal_exp" name="tanggal_exp">
                            <date-picker v-model="formData.tanggal_exp" name="tanggal_exp"></date-picker>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="tanggal_exp" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="separator my-10"></div>

                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Berita 1 (Satu)</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="berita1"
                            autocomplete="off" v-model="formData.berita1" />
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Berita 2 (Dua)</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="berita2"
                            autocomplete="off" v-model="formData.berita2" />
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Berita 3 (Tiga)</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="berita3"
                            autocomplete="off" v-model="formData.berita3" />
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Berita 4 (Empat)</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="berita4"
                            autocomplete="off" v-model="formData.berita4" />
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="col-12">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Berita 5 (Lima)</label>
                        <Field class="form-control form-control-lg form-control-solid" type="text" name="berita5"
                            autocomplete="off" v-model="formData.berita5" />
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <button type="submit" v-if="!formData.va_number" class="btn btn-primary btn-sm ms-auto">
                Simpan
            </button>
        </div>
    </VForm>
</template>

<script lang="ts">
import { block, unblock, currency, copyString } from '@/libs/utils';
import { computed, defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useKodeRetribusi } from '@/services';
import moment from 'moment';


interface FormData {
    va_number: string;
    nama: string;
    jumlah: string;
    tanggal_exp: string;
    kode_retribusi_id: string;
    is_expired: boolean;
    berita1: string;
    berita2: string;
    berita3: string;
    berita4: string;
    berita5: string;
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
        const formData = ref<FormData>({} as FormData)

        const formSchema = Yup.object().shape({
            nama: Yup.string().required('Atas Nama harus diisi'),
            jumlah: Yup.string().required('Jumlah harus diisi'),
            tanggal_exp: Yup.string().required('Tanggal Exp harus diisi'),
            kode_retribusi_id: Yup.string().required('Kode Retribusi harus diisi'),
        })

        const kodeRetribusi = useKodeRetribusi()
        const kodeRetribusis = computed(() => kodeRetribusi.data.value?.map(item => ({
            id: item.id,
            text: item.nama
        })))

        const dateExp = ref<any>(null)
        const dateExpInterval = ref<any>(null)
        const now = ref(moment())

        return {
            formData,
            formSchema,
            kodeRetribusis,
            currency,
            copyString,
            dateExp,
            dateExpInterval,
            moment,
            now,
        }
    },
    methods: {
        getEdit(uuid?: string) {
            block(this.$el)

            axios.get(`/pembayaran/non-pengujian/${uuid ?? this.selected}/edit`)
                .then(res => {
                    this.formData = res.data.data

                    this.dateExp = this.formData.tanggal_exp

                    clearInterval(this.dateExpInterval)
                    this.dateExpInterval = setInterval(() => {
                        this.dateExp = moment(this.dateExp).subtract(1, 'seconds').format('YYYY-MM-DD HH:mm:ss')

                        if (this.countdownExp == '00:00:00') {
                            clearInterval(this.dateExpInterval)
                        }
                    }, 1000)

                    window.scrollTo(0, 0);
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
        submit() {
            if (this.formData.va_number) return

            block(this.$el)

            axios.post('/pembayaran/non-pengujian/store', this.formData)
                .then((res) => {
                    this.getEdit(res.data.data.uuid)
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
    computed: {
        countdownExp() {
            const exp = moment(this.dateExp)

            let days: any = exp.diff(this.now, 'days')
            if (days < 10) days = `0${days}`

            let hours: any = exp.diff(this.now, 'hours') - (days * 24)
            if (hours < 10) hours = `0${hours}`

            let minutes: any = exp.diff(this.now, 'minutes') - (days * 24 * 60) - (hours * 60)
            if (minutes < 10) minutes = `0${minutes}`

            let seconds: any = exp.diff(this.now, 'seconds') - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minutes * 60)
            if (seconds < 10) seconds = `0${seconds}`

            return `${days}H : ${hours}J : ${minutes}M : ${seconds}D`
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
