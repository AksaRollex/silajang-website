<template>
    <div class="card mb-10">
        <div class="card-header align-items-center">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-light-danger btn-icon me-4" @click="$emit('close')">
                    <i class="la la-arrow-left fs-2"></i>
                </button>
                <h2 class="mb-0">{{ formData?.kode }}</h2>
            </div>
            <!-- <button v-if="formData.status >= 4" class="btn btn-sm btn btn-danger" type="button"
                @click="downloadReport(`/report/${formData.uuid}/rdps`)">
                <i class="la la-file-pdf fs-2"></i>
                <span class="d-none d-md-inline">Cetak RDPS</span>
            </button> -->
        </div>
        <div class="card-body pb-10">
            <!--begin::Body-->
            <div class="row row-gap-8">
                <template v-for="param in formData.parameters" :key="param.id">
                    <div v-if="param.is_dapat_diuji" class="col-xl-4 col-md-6">
                        <form class="card" @submit.prevent="fillParameter(param)">
                            <div class="card-header py-0 px-4 min-h-50px align-items-center">
                                <h6 class="card-title mb-0 truncate">
                                    <i v-if="param.pivot.acc_analis" class="la la-check-circle text-primary fs-2 me-2"></i>
                                    {{ param.nama }} {{ param.keterangan ? `(${param.keterangan})` : '' }} <span
                                        class="text-muted ms-2 fs-8">{{
                                            param.jenis_parameter.nama }}</span>
                                </h6>
                                <button type="submit" class="btn btn-light-success btn-icon btn-sm d-none">
                                    <i class="la la-chevron-right"></i>
                                </button>
                            </div>
                            <div class="card-body px-6 py-4 pb-8">
                                <div class="row row-gap-6">
                                    <div class="col-6">
                                        <div class="text-muted">Satuan</div>
                                        <div class="fw-bolder">{{ param.pivot.satuan ?? '-' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted">Baku Mutu</div>
                                        <div class="fw-bolder" v-if="formData.baku_mutu">{{ param.pivot.baku_mutu ?? '-' }}</div>
                                        <div class="fw-bolder" v-else>-</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-muted">MDL</div>
                                        <div class="fw-bolder">{{ param.pivot.mdl ?? '-' }}</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-muted mb-2 required">Hasil Uji</div>
                                        <Field class="form-control form-control-lg form-control-solid" type="text"
                                            @change="fillParameter(param)" autocomplete="off"
                                            v-model="param.pivot.hasil_uji" required placeholder="Hasil Uji" />
                                    </div>
                                    <div class="col-12">
                                        <div class="text-muted mb-2">Keterangan</div>
                                        <Field class="form-control form-control-lg form-control-solid" type="text"
                                            @change="fillParameter(param)" placeholder="Keterangan" autocomplete="off"
                                            v-model="param.pivot.keterangan" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
            <!--end::Body-->
        </div>
    </div>
</template>

<script lang="ts">
import { block, unblock, currency } from '@/libs/utils';
import { computed, defineComponent, ref } from 'vue'
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useAcuanMetode, usePetugasPengambil } from '@/services';
import { useAuthStore } from '@/stores/auth';
import { useDownloadPdf } from '@/libs/hooks';

interface FormData {
    uuid: string;
    kode: string;
    lokasi: string;
    jenis_sampel: {
        nama: string;
    },
    jenis_wadah: {
        nama: string;
    },
    pengambil_id: number;
    pengambil: {
        nama: string;
    },
    nama_pengambil: string;
    tanggal_pengambilan: string;
    acuan_metode_id: number;
    acuan_metode: {
        nama: string;
    },
    south: string;
    east: string;
    keterangan: string;
    status: number;
    peraturan: {
        nama: string;
        nomor: string;
    },
    is_has_subkontrak: boolean | number;
    lab_subkontrak: string;
    baku_mutu: boolean | number;
    hasil_pengujian: boolean | number;
    kesimpulan_permohonan: boolean | number;
    kesimpulan_sampel: boolean | number;
    kondisi_sampel: boolean | number;
    keterangan_kondisi_sampel: boolean | number;
    parameters: [
        {
            uuid: string;
            id: number;
            nama: string;
            harga: number;
            is_dapat_diuji: boolean | number;
            satuan: string;
            jenis_parameter: {
                nama: string;
            },
            pivot: {
                satuan: string;
                harga: number;
                jumlah: number;
                parameter_id: number;
                personel: boolean | number,
                metode: boolean | number,
                peralatan: boolean | number,
                reagen: boolean | number,
                akomodasi: boolean | number,
                beban_kerja: boolean | number,
                mdl: string;
                baku_mutu: string;
                hasil_uji: string;
                keterangan: string;
                acc_analis: boolean | number;
                acc_manager: boolean | number;
                acc_upt: boolean | number;
            }
        }
    ],
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
    setup() {
        const status = ref(0)
        const { user } = useAuthStore();
        const formData = ref<FormData>({} as FormData)

        const { download: downloadReport } = useDownloadPdf();

        return {
            user,
            formData,
            currency,
            status,
            downloadReport
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/verifikasi/analis/${this.selected}`)
                .then(res => {
                    this.formData = res.data.data
                    this.status = res.data.data.status
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
        fillParameter(param) {
            block(this.$el)

            axios.post(`/verifikasi/analis/${this.selected}/fill-parameter`, {
                parameter_uuid: param.uuid,
                hasil_uji: param.pivot.hasil_uji,
                keterangan: param.pivot.keterangan
            })
                .then(res => {
                    const paramIndex = this.formData.parameters.findIndex(p => p.uuid === param.uuid)
                    this.formData.parameters[paramIndex] = res.data.data
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
