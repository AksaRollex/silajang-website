<template>
    <div class="card mb-10" :validation-schema="formSchema">
        <div class="card-header align-items-center">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-light-danger btn-icon me-4" @click="$emit('close')">
                    <i class="la la-arrow-left fs-2"></i>
                </button>
                <h2 class="mb-0">Detail Kontrak Permohonan</h2>
            </div>
        </div>
        <div class="card-body p-4 p-md-8">
            <div class="row row-gap-8 row-gap-md-0">
                <div class="col-md-4">
                    <div class="card card-xl-stretch mb-md-8">
                        <!-- begin::Header -->
                        <div class="card-header py-0 min-h-50px">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="text-muted mt-1 fw-semibold fs-7">Informasi Pemohon</span>
                            </h3>
                        </div>
                        <!-- end::Header -->

                        <!-- begin::Body -->
                        <div class="card-body pt-5">
                            <!-- begin::Item -->
                            <div class="d-flex align-items-center mb-7">
                                <!-- begin::Symbol -->
                                <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                    <span class="symbol-label bg-light-success">
                                        <i class="la la-user fs-2x text-success"></i>
                                    </span>
                                </div>
                                <!-- end::Symbol -->

                                <!-- begin::Text -->
                                <div class="d-flex flex-column">
                                    <span class="text-muted">Customer</span>
                                    <div class="text-dark text-hover-primary fs-6 fw-bold">
                                        {{ formData.user?.nama }}
                                    </div>
                                </div>
                                <!-- end::Text -->
                            </div>
                            <!-- end::Item -->

                            <!-- begin::Item -->
                            <div class="d-flex align-items-center mb-7">
                                <!-- begin::Symbol -->
                                <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                    <span class="symbol-label bg-light-success">
                                        <i class="la la-building fs-2x text-success"></i>
                                    </span>
                                </div>
                                <!-- end::Symbol -->

                                <!-- begin::Text -->
                                <div class="d-flex flex-column">
                                    <span class="text-muted">Instansi</span>
                                    <div class="text-dark text-hover-primary fs-6 fw-bold">
                                        {{ formData.user?.detail?.instansi }}
                                    </div>
                                </div>
                                <!-- end::Text -->
                            </div>
                            <!-- end::Item -->

                            <!-- begin::Item -->
                            <div class="d-flex align-items-center mb-7">
                                <!-- begin::Symbol -->
                                <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                    <span class="symbol-label bg-light-success">
                                        <i class="la la-map-marked fs-2x text-success"></i>
                                    </span>
                                </div>
                                <!-- end::Symbol -->
                                
                                <!-- begin::Text -->
                                <div class="d-flex flex-column">
                                    <span class="text-muted">Alamat</span>
                                    <div class="text-dark text-hover-primary fs-6 fw-bold">
                                        {{ formData.user?.detail?.alamat }}
                                    </div>
                                </div>
                                <!-- end::Text -->
                            </div>
                            <!-- end::Item -->
                            
                            <!-- begin::Item -->
                            <div class="d-flex align-items-center mb-7">
                                <!-- begin::Symbol -->
                                <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                    <span class="symbol-label bg-light-success">
                                        <i class="la la-phone fs-2x text-success"></i>
                                    </span>
                                </div>
                                <!-- end::Symbol -->
                                
                                <!-- begin::Text -->
                                <div class="d-flex flex-column">
                                    <span class="text-muted">No. Telepon/WhatsApp</span>
                                    <div class="text-dark text-hover-primary fs-6 fw-bold">
                                        {{ formData.user?.phone }}
                                    </div>
                                </div>
                                <!-- end::Text -->
                            </div>
                            <!-- end::Item -->
                        </div>
                        <!-- end::Body -->
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-xl-stretch mb-md-10">
                        <!-- begin::Header -->
                        <div class="card-header py-0 min-h-50px">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="text-muted mt-1 fw-semibold fs-7">Detail Permohonan</span>
                            </h3>
                        </div>
                        <!-- end::Header -->

                        <!-- begin::Body -->
                        <div class="card-body pt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- begin::Item -->
                                    <div class="d-flex align-items-center mb-7">
                                        <!-- begin::Symbol -->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-industry fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!-- end::Symbol -->

                                        <!-- begin::Text -->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Industri</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ formData.industri }}
                                            </div>
                                        </div>
                                        <!-- end::Text -->
                                    </div>
                                    <!-- end::Item -->
                                    <!-- begin::Item -->
                                    <div class="d-flex align-items-center mb-7">
                                        <!-- begin::Symbol -->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-map-marked fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!-- end::Symbol -->

                                        <!-- begin::Text -->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Alamat</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ formData.alamat }}
                                            </div>
                                        </div>
                                        <!-- end::Text -->
                                    </div>
                                    <!-- end::Item -->
                                    <!-- begin::Item -->
                                    <div class="d-flex align-items-center mb-7">
                                        <!-- begin::Symbol -->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-scroll fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!-- end::Symbol -->

                                        <!-- begin::Text -->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Jenis Kegiatan Industri</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ formData.kegiatan }}
                                            </div>
                                        </div>
                                        <!-- end::Text -->
                                    </div>
                                    <!-- end::Item -->
                                </div>
                                <div class="col-md-6">
                                    <!-- begin::Item -->
                                    <div class="d-flex align-items-center mb-7">
                                        <!-- begin::Symbol -->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-credit-card fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!-- end::Symbol -->

                                        <!-- begin::Text -->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Jenis Pembayaran</span>
                                            <div class="fs-6 fw-bold">
                                                <span class="badge badge-primary">
                                                    {{ formData.pembayaran }}
                                                </span>
                                            </div>
                                        </div>
                                        <!-- end::Text -->
                                    </div>
                                    <!-- end::Item -->
                                    <!-- begin::Item -->
                                    <div class="d-flex align-items-center mb-7">
                                        <!-- begin::Symbol -->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-calendar fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!-- end::Symbol -->

                                        <!-- begin::Text -->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Tanggal Permohonan</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ formData.tanggal }}
                                            </div>
                                        </div>
                                        <!-- end::Text -->
                                    </div>
                                    <!-- end::Item -->
                                </div>
                            </div>
                        </div>
                        <!-- end::Body -->
                    </div>
                    <div class="card card-xl-stretch mb-md-8">
                        <!-- begin::Header -->
                        <div class="card-header py-0 min-h-50px">
                            <div class="card-title align-items-center flex-column">
                                <span class="text-muted mt-1 fw-semibold fs-7">Detail Kontrak</span>
                            </div>
                        </div>
                        <!-- end::Header -->

                        <!-- begin::Body -->
                        <div class="card-body pt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <button class="symbol-label bg-light-dark" @click="downloadFile()">
                                                <i class="la la-download fs-2x text-dark"></i>
                                            </button>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Dokumen Permohonan</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold" style="cursor: pointer;" @click="downloadFile()">Download</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clock fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Masa Kontrak</span>
                                            <div class="fs-6 fw-bold">
                                                <span class="badge badge-primary">
                                                    {{ formattedBulan }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-scroll fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Perihal</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ formData.kontrak?.perihal }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-file-text fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Nomor Surat</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ formData.kontrak?.nomor_surat }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-7">
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-calendar fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-muted">Tanggal Permohonan</span>
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ formData.kontrak?.tanggal }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fv-row mb-10">
                                        <label class="form-label fs-6">Kesimpulan Kontrak</label>
                                        <div class="d-flex align-items-center gap-4">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="0"
                                                    name="kesimpulan_kontrak" id="status-menunggu"
                                                    v-model="formData.kesimpulan_kontrak" @change="change()" />
                                                <label class="form-check-label" for="status-menunggu">
                                                    Menunggu
                                                </label>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="1"
                                                    name="kesimpulan_kontrak" id="status-diterima"
                                                    v-model="formData.kesimpulan_kontrak" @change="change()" />
                                                <label class="form-check-label" for="status-diterima">
                                                    Diterima
                                                </label>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="2"
                                                    name="kesimpulan_kontrak" id="status-ditolak"
                                                    v-model="formData.kesimpulan_kontrak" @change="change()" />
                                                <label class="form-check-label" for="status-ditolak">
                                                    Ditolak
                                                </label>
                                            </div>
                                        </div>
                                        <div class="fv-plugins-message-container">
                                            <div class="fv-help-block">
                                                <ErrorMessage name="kesimpulan_kontrak" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                            </div>
                        </div>
                        <!-- end::Body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts">
import { block, unblock } from '@/libs/utils';
import { defineComponent, ref, computed } from 'vue';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useAuthStore } from '@/stores/auth';

interface FormData {
    no: number,
    uuid: string,
    industri: string,
    kegiatan: string,
    alamat: string,
    pembayaran: string,
    tanggal: string,
    user: {
        nama: string,
        phone: string,
        detail: {
            instansi: string,
            alamat: string,
        }
    }
    kontrak: {
        nomor_surat: string,
        dokumen_permohonan: string,
        perihal: string,
        tanggal_surat: string,
        bulan: Array<string | number>,
    }
    kesimpulan_kontrak: boolean | number,
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
        const { user } = useAuthStore();
        const formData = ref<FormData>({} as FormData);

        const bulans = ref<any[]>([
            { id: 1, name: 'Januari' },
            { id: 2, name: 'Februari' },
            { id: 3, name: 'Maret' },
            { id: 4, name: 'April' },
            { id: 5, name: 'Mei' },
            { id: 6, name: 'Juni' },
            { id: 7, name: 'Juli' },
            { id: 8, name: 'Agustus' },
            { id: 9, name: 'September' },
            { id: 10, name: 'Oktober' },
            { id: 11, name: 'November' },
            { id: 12, name: 'Desember' },
        ])

        const formattedBulan = computed(() => {
            return formData.value.kontrak?.bulan
                .map((bulanId) => bulans.value.find((b) => b.id === parseInt(bulanId))?.name)
                .filter(Boolean)
                .join(', ');
        });

        return {
            user,
            formData,
            bulans,
            formattedBulan
        }
    },
    methods: {
        getEdit() {
            block(this.$el)

            axios.get(`/administrasi/kontrak/${this.selected}`)
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
        change() {
            block (this.$el)

            axios.post(`/administrasi/kontrak/${this.selected}/update`, { ...this.formData })
            .then((res) => {
                // this.$emit('refresh')
            })
            .catch(err => {
                toast.error(err.response.data.message)
            })
            .finally(() => {
                unblock(this.$el)
            })
        },
        downloadFile() {
            if (this.formData.kontrak.dokumen_permohonan) {
                const fileUrl = `/storage/${this.formData.kontrak.dokumen_permohonan}`;
                const fileName = 'Dokumen Permohonan';
                const fileExtension = fileUrl.split('.').pop();
                
                const link = document.createElement('a');
                link.href = fileUrl;
                link.download = `${fileName}.${fileExtension}`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // window.open(`/storage/${this.formData.kontrak.dokumen_permohonan}`);
            } else {
                toast.error('Dokumen Permohonan tidak ditemukan')
            }
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