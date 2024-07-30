<template>
    <div class="card mb-10">
        <div class="card-header align-items-center">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-light-danger btn-icon me-4" @click="$emit('close')">
                    <i class="la la-arrow-left fs-2"></i>
                </button>
                <h2 class="mb-0">{{ formData?.kode }}</h2>
            </div>
        </div>
        <div class="card-body pb-10">
            <template v-if="!formData.payment">
                <div class="row">
                    <div class="col-xl-3 col-sm-6">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold text-dark fs-6">Harga</label>
                            <div class="fs-4">
                                <strong>{{ currency(formData.harga) }}</strong>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="form-label fw-bold text-dark fs-6">Atas Nama</label>
                            <div class="fs-4">
                                <strong>{{ formData.permohonan?.user?.nama }}</strong>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>

                <div class="separator my-10"></div>

                <div class="alert alert-primary p-5 text-center">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h4 class="mb-1 text-dark">VA Pembayaran Belum Dibuat</h4>
                        <!--end::Title-->

                        <!--begin::Content-->
                        <span>Silahkan klik Tombol Di Bawah untuk Membuat VA Pembayaran</span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
            </template>
            <template v-else>
                <div class="row row-gap-8">
                    <div class="col-12" v-if="formData.payment?.status === 'success'">
                        <div class="bg-success text-white py-1 rounded-1 text-center">Pembayaran berhasil dilakukan</div>
                    </div>
                    <div class="col-12" v-else-if="formData.payment?.is_expired === false">
                        <div class="bg-primary text-white py-1 rounded-1 text-center">Lakukan pembayaran sebelum: <strong>{{
                            countdownExp }}</strong>
                        </div>
                    </div>
                    <div class="col-12" v-else>
                        <div class="bg-danger text-white py-1 rounded-1 text-center">VA Pembayaran telah kedaluwarsa</div>
                    </div>
                    <div class="col-md-6">
                        <div :class="`card ${formData.payment?.is_expired ? 'opacity-25' : ''}`"
                            :style="`cursor: ${formData.payment?.is_expired ? 'not-allowed' : 'default'}`">
                            <div class="card-header align-items-center min-h-50px">
                                <h5 class="mb-0">Virtual Account</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex bg-light rounded-2 p-4 gap-8 align-items-center flex-wrap">
                                    <img src="/media/bank-jatim.png" class="w-75px">
                                    <strong class="fs-1 text-primary">{{ formData.payment?.va_number }}</strong>
                                    <button class="btn text-success p-0 ms-auto" :disabled="formData.payment?.is_expired"
                                        @click="copyString(formData.payment?.va_number)">Salin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div :class="`card ${formData.payment?.is_expired ? 'opacity-25' : ''}`"
                            :style="`cursor: ${formData.payment?.is_expired ? 'not-allowed' : 'default'}`">
                            <div class="card-header align-items-center min-h-50px">
                                <h5 class="mb-0">Nominal Pembayaran</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex bg-light rounded-2 p-4 gap-8 align-items-center">
                                    <strong class="fs-1 text-primary">{{ currency(formData.payment?.jumlah) }}</strong>
                                    <button class="btn text-success p-0 ms-auto" :disabled="formData.payment?.is_expired"
                                        @click="copyString(formData.payment?.jumlah)">Salin</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div v-if="formData.payment?.status !== 'success'" class="card-footer d-flex justify-content-end gap-4">
            <button type="button" class="btn btn-sm btn-primary" @click="generate()"
                v-if="(formData.status == 8 && !formData.payment) || formData.payment?.is_expired">
                Buat VA Pembayaran
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import axios from '@/libs/axios';
import { block, unblock, currency, copyString } from '@/libs/utils';
import { defineComponent, ref } from 'vue'
import { toast } from 'vue3-toastify';
import moment from 'moment';
import { useSwalConfirm } from '@/libs/hooks';

interface FormData {
    uuid: string;
    kode: string;
    lokasi: string;
    harga: number;
    status: number;
    status_pembayaran: number;
    text_status_pembayaran: string;
    permohonan: {
        industri: string;
        keterangan: string;
        kegiatan: string;
        alamat: string;
        pembayaran: string;
        is_mandiri: boolean | number;
        jasa_pengambilan_id?: number;
        jasa_pengambilan?: {
            wilayah: string;
            harga: number;
        },
        user: {
            nama: string;
            phone: string;
            detail: {
                instansi: string;
                alamat: string;
            }
        }
    };
    payment: {
        va_number: string;
        tanggal_exp: string;
        jumlah: number;
        berita1: string;
        berita2: string;
        berita3: string;
        berita4: string;
        berita5: string;
        status: string;
        is_expired: boolean;
    }
}

export default defineComponent({
    props: {
        selected: {
            type: String,
            default: null
        },
    },
    emits: ['close', 'refresh'],
    setup(props, ctx) {
        const formData = ref<FormData>({} as FormData)
        const dateExp = ref<any>(null)
        const dateExpInterval = ref<any>(null)
        const now = ref(moment())

        const { confirm: cancelPembayaran } = useSwalConfirm({
            title: 'Batalkan Pembayaran?',
            text: 'Apakah anda yakin ingin membatalkan pembayaran ini?',
            confirmButtonText: 'Ya, Batalkan',
        }, {
            onSuccess: () => {
                ctx.emit('close')
            }
        });

        return {
            formData,
            cancelPembayaran,
            currency,
            copyString,
            dateExp,
            dateExpInterval,
            moment,
            now,
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/pembayaran/pengujian/${this.selected}`)
                .then(res => {
                    this.formData = res.data.data

                    if (this.formData.payment) {
                        this.dateExp = this.formData.payment.tanggal_exp

                        clearInterval(this.dateExpInterval)
                        this.dateExpInterval = setInterval(() => {
                            this.dateExp = moment(this.dateExp).subtract(1, 'seconds').format('YYYY-MM-DD HH:mm:ss')

                            if (this.countdownExp == '00:00:00') {
                                clearInterval(this.dateExpInterval)
                            }
                        }, 1000)
                    }
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
        generate() {
            block(this.$el)

            axios.post(`/pembayaran/pengujian/${this.selected}`)
                .then(res => {
                    toast.success(res.data.message)
                    this.getEdit()
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
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
    mounted() {
        if (this.selected) {
            this.getEdit()
        }
    },

})
</script>
