<template>
    <Form :selected="selected" @close="openForm = false" @next-parameter="handleNextParameter" v-if="openForm"
        @refresh="refresh" :permohonan="permohonan" />
    <Parameter :selected="selected" @close="openParameter = false" v-if="openParameter" @refresh="refresh" />
    <Pembayaran :selected="selected" @close="openPembayaran = false" v-if="openPembayaran" @refresh="refresh" />
    <Revisi :selected="selected" @go-to-edit="goToEdit" />

    <div v-if="!$refs.paginate?.data?.data?.length" class="alert alert-primary mt-2">
        <h6 class="text-dark mb-0">Silahkan Tambah Titik Lokasi Sampel Pengujian</h6>
        <span class="text-dark fs-8">Anda belum memiliki Titik Lokasi Sampel satu pun.</span>
    </div>

    <div v-if="!openPembayaran" class="card">
        <div class="card-header align-items-center">
            <div class="d-flex align-items-center">
                <router-link v-if="$refs.paginate?.data?.data?.length" to="/dashboard/pengujian/permohonan"
                    class="btn btn-sm btn-light-danger btn-icon me-4">
                    <i class="la la-arrow-left fs-2"></i>
                </router-link>
                <h2 class="mb-0">{{ permohonan?.industri }}: Titik Pengujian</h2>
            </div>
            <div v-if="user.has_tagihan" class="alert alert-warning mt-2">
                <h6 class="text-dark mb-0">Tidak dapat membuat Permohonan Baru</h6>
                <span class="text-dark fs-8">Harap selesaikan tagihan pembayaran Anda terlebih dahulu.</span>
            </div>
            <button type="button" class="btn btn-sm btn-primary ms-auto" v-if="!openForm && !user.has_tagihan"
                @click="openForm = true">
                Tambah
                <i class="la la-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <paginate ref="paginate" id="table-titik" url="/permohonan/titik" :columns="columns"
                :payload="{ permohonan_uuid: permohonanUuid }"></paginate>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-report">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-auto" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <iframe :src="reportUrl" frameborder="0" class="w-100 h-700px" ref="iframeReport"
                        @load="unblock('#modal-report .modal-body')"></iframe>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-umpan-balik">
        <form @submit.prevent="sendUmpanBalik" class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Mohon Berikan Umpan Balik Pelayanan UPT</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-auto" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <ol>
                        <li v-for="umpan in umpanBaliks" :key="umpan.id"
                            class="d-flex gap-4 align-items-center justify-content-between pb-4 mb-4 border-bottom">
                            <h5>{{ umpan.keterangan }}</h5>
                            <star-rating v-model:rating="formRating[umpan.kode]" :max-rating="10" :show-rating="false"
                                :star-size="20"></star-rating>
                        </li>
                    </ol>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script lang="ts">
import StarRating from 'vue-star-rating'

import { defineComponent, h, ref } from 'vue'
import { useDelete, useDownloadPdf } from "@/libs/hooks";
import { useRoute } from 'vue-router';
import moment from 'moment';

import Form from './Form.vue';
import Parameter from './Parameter.vue';
import Revisi from './Revisi.vue';
import Pembayaran from './Pembayaran.vue';

interface TitikPermohonan {
    no: number,
    uuid: string,
    kode: string,
    lokasi: string,
    tanggal_pengambilan: string,
    tanggal_diterima: string,
    tanggal_selesai: string,
    status: number,
    pembayaran: number,
    keterangan_revisi: string,
    kesimpulan_permohonan: number,
    kesimpulan_sampel: number,
    payment?: {
        id: number,
    }
    status_tte: number,
    status_pembayaran: number,
    permohonan: {
        user: {
            golongan_id: number
        }
    }
}
import { createColumnHelper } from "@tanstack/vue-table";
import { usePermohonan, useUmpanBalik } from '@/services';
import { mapStatusPengujian, block, unblock } from '@/libs/utils';
import { usePreviewReport } from '@/stores';
import { useAuthStore } from '@/stores/auth';
import { toast } from 'vue3-toastify';
import axios from '@/libs/axios';
const column = createColumnHelper<TitikPermohonan>();

export default defineComponent({
    components: {
        Form,
        Parameter,
        Revisi,
        Pembayaran,
        StarRating
    },
    setup() {
        const route = useRoute();
        const permohonanUuid = route.params.uuid;
        const { data: permohonan = {} } = usePermohonan(permohonanUuid, { cacheTime: 0 })
        const { user, verifyAuth } = useAuthStore()

        const { data: umpanBaliks } = useUmpanBalik()
        const formRating = ref<any>({})

        const paginate = ref<any>(null);
        const selected = ref<string | any>("");
        const openForm = ref<boolean>(false);
        const openParameter = ref<boolean>(false);
        const openPembayaran = ref<boolean>(false);

        const { delete: deletePermohonan } = useDelete({
            onSuccess: () => paginate.value.refetch(),
        });

        const onReport = ref<any>()
        const { previewReport } = usePreviewReport()
        const reportUrl = ref<string>("");
        const { download: downloadReport } = useDownloadPdf();
        const iframeReport = ref<any>(null);

        const hasUmpanBalik = ref<Boolean>(false)

        const columns = [
            column.accessor("no", {
                header: "#"
            }),
            column.accessor("kode", {
                header: "Kode",
            }),
            column.accessor("lokasi", {
                header: "Titik Uji/Lokasi",
            }),
            column.accessor("tanggal_pengambilan", {
                header: "Diambil pada",
                cell: cell => cell.getValue() ? moment(cell.getValue()).format('DD MMMM YYYY - HH:mm') : '-'
            }),
            column.accessor("tanggal_diterima", {
                header: "Diterima pada",
                cell: cell => cell.getValue() ? moment(cell.getValue()).format('DD MMMM YYYY - HH:mm') : '-'
            }),
            column.accessor("tanggal_selesai_uji", {
                header: "Selesai pada",
                cell: cell => cell.getValue() ? moment(cell.getValue()).format('DD MMMM YYYY - HH:mm') : '-'
            }),

            column.accessor("status", {
                header: "Status",
                cell: cell => {
                    function statusPengambilan() {
                        if (cell.row.original.kesimpulan_permohonan == 1) {
                            return h('div', {
                                class: 'd-flex align-items-center gap-2',
                            }, [
                                h('span', {
                                    class: `badge badge-light-success`
                                }, 'Diterima')
                            ])
                        }

                        if (cell.row.original.kesimpulan_permohonan == 2) {
                            return h('div', {
                                class: 'd-flex align-items-center gap-2',
                            }, [
                                h('span', {
                                    class: `badge badge-light-danger`
                                }, 'Ditolak')
                            ])
                        }

                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-info`
                            }, 'Menunggu')
                        ])
                    }

                    function statusPenerimaan() {
                        if (cell.row.original.kesimpulan_sampel == 1) {
                            return h('div', {
                                class: 'd-flex align-items-center gap-2',
                            }, [
                                h('span', {
                                    class: `badge badge-light-success`
                                }, 'Diterima')
                            ])
                        }

                        if (cell.row.original.kesimpulan_sampel == 2) {
                            return h('div', {
                                class: 'd-flex align-items-center gap-2',
                            }, [
                                h('span', {
                                    class: `badge badge-light-danger`
                                }, 'Ditolak')
                            ])
                        }

                        return h('div', {
                            class: 'd-flex align-items-center gap-2',
                        }, [
                            h('span', {
                                class: `badge badge-light-info`
                            }, 'Menunggu')
                        ])
                    }

                    return h('div', {
                        class: 'd-flex align-items-center gap-2',
                    }, [
                        cell.row.original.parameters.length ? h('div', [
                            h('div', { class: 'mb-2', style: 'white-space: nowrap' }, [
                                h('span', { class: 'fw-light' }, 'Pengambilan: '),
                                h('span', {
                                    class: `badge badge-light-${cell.getValue() < 0 ? 'warning' : 'info'}`
                                }, statusPengambilan())
                            ]),
                            h('div', { class: 'mb-2', style: 'white-space: nowrap' }, [
                                h('span', { class: 'fw-light' }, 'Penerimaan: '),
                                h('span', {
                                    class: `badge badge-light-${cell.getValue() < 0 ? 'warning' : 'info'}`
                                }, statusPenerimaan())
                            ]),
                            h('div', { class: 'mb-2', style: 'white-space: nowrap' }, [
                                h('span', { class: 'fw-light' }, 'Pengujian: '),
                                h('span', {
                                    class: `badge badge-light-${cell.getValue() < 0 ? 'warning' : 'info'}`
                                }, mapStatusPengujian(cell.getValue()))
                            ]),
                        ]) : h('span', {
                            class: `badge badge-light-dark`
                        }, 'Parameter Belum Diisi'),

                        cell.getValue() < 0 && h('button', {
                            class: 'btn btn-warning btn-icon btn-sm',
                            onClick: () => {
                                selected.value = {
                                    uuid: cell.row.original.uuid,
                                    kode: cell.row.original.kode,
                                    keterangan_revisi: cell.row.original.keterangan_revisi,
                                }
                            },
                            'data-bs-toggle': 'modal',
                            'data-bs-target': '#modal-revisi'
                        }, h('i', { class: 'la la-eye fs-4' }))
                    ])
                }
            }),
            column.accessor("uuid", {
                header: "Aksi",
                cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
                    cell.row.original.status_tte == 1 && (cell.row.original.status_pembayaran == 1 || cell.row.original.permohonan?.user?.golongan_id == 2) && h('button', {
                        class: 'btn btn-sm btn-success d-flex', onClick: () => {
                            if (previewReport.value) {
                                block('#modal-report .modal-body')
                                reportUrl.value = `/api/v1/report/${cell.getValue()}/lhu?token=${localStorage.getItem('auth_token')}`

                                iframeReport.value.contentWindow.location.reload()
                                $('#modal-report').modal('show')
                            } else {
                                downloadReport(`/report/${cell.getValue()}/lhu`)
                            }
                        }
                    }, [h('i', { class: 'la la-file-pdf fs-2' }), ' Sertifikat LHU']),
                    h('div', { class: 'dropup' }, [
                        h('button', {
                            class: 'btn btn-sm btn btn-danger',
                            'data-bs-toggle': 'dropdown',
                            style: {
                                whiteSpace: 'nowrap'
                            }
                        }, [
                            h('i', { class: 'la la-file-pdf me-0 fs-2' }),
                            h('span', { class: 'd-none d-md-inline me-2' }, 'Report'),
                        ]),
                        h('div', {
                            class: 'dropdown-menu',
                        }, [
                            cell.row.original.status >= 2 && h('div', {
                                class: 'dropdown-item px-3', onClick: () => {
                                    if (previewReport.value) {
                                        block('#modal-report .modal-body')
                                        reportUrl.value = `/api/v1/report/${cell.getValue()}/tanda-terima?token=${localStorage.getItem('auth_token')}`

                                        iframeReport.value.contentWindow.location.reload()
                                        $('#modal-report').modal('show')
                                    } else {
                                        downloadReport(`/report/${cell.getValue()}/tanda-terima`)
                                    }
                                }
                            }, [
                                h('button', { class: 'btn btn-light w-100 text-start btn-sm' }, [
                                    h('i', { class: 'la la-file-pdf fs-2' }),
                                    h('span', 'Permohonan Pengujian')
                                ]),
                            ]),
                            !cell.row.original.permohonan.is_mandiri && h('div', {
                                class: 'dropdown-item px-3', onClick: () => {
                                    if (previewReport.value) {
                                        block('#modal-report .modal-body')
                                        reportUrl.value = `/api/v1/report/${cell.getValue()}/berita-acara?token=${localStorage.getItem('auth_token')}`

                                        iframeReport.value.contentWindow.location.reload()
                                        $('#modal-report').modal('show')
                                    } else {
                                        downloadReport(`/report/${cell.getValue()}/berita-acara`)
                                    }
                                }
                            }, [
                                h('button', { class: 'btn btn-light w-100 text-start btn-sm' }, [
                                    h('i', { class: 'la la-file-pdf fs-2' }),
                                    h('span', 'Berita Acara Pengambilan')
                                ]),
                            ]),
                        ])
                    ]),
                    cell.row.original.status <= 7 && h('button', {
                        class: 'btn btn-sm btn-success d-flex', onClick: () => {
                            selected.value = cell.getValue();
                            openParameter.value = true;
                        }
                    }, [h('i', { class: 'la la-list fs-2' }), ' Parameter']),
                    cell.row.original.status < 7 && h('button', {
                        class: 'btn btn-sm btn-icon btn-info', onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        }
                    }, h('i', { class: 'la la-pencil fs-2' })),
                    cell.row.original.status <= 2 && h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deletePermohonan(`/permohonan/titik/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))
                ])
            }),
        ]

        return {
            verifyAuth,
            columns,
            selected,
            openForm,
            openParameter,
            openPembayaran,
            paginate,
            refresh: () => paginate.value.refetch(),
            permohonan,
            permohonanUuid,
            reportUrl,
            unblock,
            iframeReport,
            user,
            umpanBaliks,
            formRating,
            previewReport,
            downloadReport,
            onReport,
            hasUmpanBalik
        }
    },
    watch: {
        openForm(val) {
            if (!val) {
                this.selected = "";
            }
            window.scrollTo(0, 0);
        }
    },
    methods: {
        handleNextParameter(selected) {
            this.selected = selected;
            this.openParameter = true;
        },
        sendUmpanBalik() {
            const vm = this
            block("#modal-umpan-balik form")

            axios.post('/konfigurasi/umpan-balik/send', this.formRating)
                .then(async (res) => {
                    vm.verifyAuth()
                    $('#modal-umpan-balik').modal('hide')
                    vm.hasUmpanBalik = true

                    if (vm.previewReport) {
                        block('#modal-report .modal-body')
                        vm.reportUrl = `/api/v1/report/${vm.onReport}/lhu?token=${localStorage.getItem('auth_token')}`

                        vm.iframeReport.contentWindow.location.reload()
                        $('#modal-report').modal('show')
                    } else {
                        vm.downloadReport(`/report/${vm.onReport}/lhu`)
                    }
                    toast.success('Umpan Balik Berhasil Dikirim')
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock("#modal-umpan-balik form")
                })
        },
        goToEdit(selected) {
            $('#modal-revisi').modal('hide');

            const vm = this
            setTimeout(() => {
                vm.selected = selected;
                vm.openForm = true;
            }, 100);
        }
    }
})
</script>
