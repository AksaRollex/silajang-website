<template>
    <div class="card mb-10">
      <div class="card-header align-items-center">
        <h2 class="mb-0">Belum Cetak/Revisi</h2>
        <div class="d-flex align-items-center gap-5">
          <!-- <div>
            <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker>
          </div> -->
          <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tahuns"
            v-model="tahun">
          </select2>
        </div>
      </div>
      <div class="card-body">
        <paginate ref="paginateBelum" id="table-belum" url="/administrasi/cetak-lhu" queryKey="table-belum" :columns="columnsBelum"
          :payload="{ 
            status: [-1, 5],
            can_upload: 1,
            // start, 
            // end,
            tahun: tahun,
          }">
        </paginate>
      </div>
    </div>

    <div class="card">
      <div class="card-header align-items-center">
        <h2 class="mb-0">Sudah Dicetak</h2>
        <div class="d-flex align-items-center gap-5">
          <!-- <div>
            <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker>
          </div> -->
          <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahunSudah" :options="tahuns"
            v-model="tahunSudah">
          </select2>
        </div>
      </div>
      <div class="card-body">
        <paginate ref="paginateSudah" id="table-sudah" url="/administrasi/cetak-lhu" queryKey="table-sudah" :columns="columnsSudah"
          :payload="{ 
            status: 5, 
            // start, 
            // end,
            tahun: tahunSudah,
          }">
        </paginate>
      </div>
    </div>
  
    <div class="modal fade" tabindex="-1" id="modal-report">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-auto" data-bs-dismiss="modal" aria-label="Close">
              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
            <!--end::Close-->
          </div>
  
          <div class="modal-body">
            <iframe :src="reportUrl" frameborder="0" class="w-100 h-700px" ref="iframeReport"
              @load="onLoadIframe"></iframe>
          </div>
  
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  
    <div class="modal fade" tabindex="-1" id="modal-upload">
      <form class="modal-dialog modal-dialog-centered" @submit.prevent="sendLhu" id="form-upload">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Upload LHU</h3>
  
            <!--begin::Close-->
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
            <!--end::Close-->
          </div>
  
          <div class="modal-body">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6 required">File</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" autocomplete="off"
                v-model="files">
                <file-upload v-bind:files="files" :accepted-file-types="fileTypes"
                  v-on:updatefiles="onUpadateFiles"></file-upload>
              </Field>
              <div class="fv-help-block">
                <ErrorMessage name="nama" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
          <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Upload & Simpan</button>
          </div>
        </div>
      </form>
    </div>

    <div class="modal fade" tabindex="-1" id="modal-revisi">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Keterangan Revisi</h3>
            <!-- begin::Close -->
            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
              <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
            <!-- end::Close -->
          </div>

          <div class="modal-body fs-4">
            <span> {{ keteranganRevisi }} </span>
          </div>
        </div>
      </div>
    </div>
  
  </template>
  
  <script lang="ts">
  import { computed, defineComponent, h, ref } from 'vue'
  import { useDownloadPdf, useDownloadWord } from "@/libs/hooks";
  
  interface TitikPermohonan {
    no: number,
    uuid: string,
    kode: string,
    lokasi: string,
    tgl_diterima: string,
    tgl_selesai: string,
    status: number,
    pembayaran: number,
    tanggal_pengambilan: string,
    tanggal_selesai: string,
    tanggal_tte: string,
    text_status: string,
    status_pembayaran: number,
    text_status_pembayaran: string,
    harga: number,
    is_has_subkontrak: boolean,
    nama_pengambil: string,
    tanggal_diterima: string,
    sertifikat: number,
    pengambil?: {
      nama: string,
    },
    permohonan: {
      is_mandiri: boolean | number,
      user: {
        nama: string,
      }
    },
    peraturan: {
      id: number,
      nama: string,
    }
  }
  import { createColumnHelper } from "@tanstack/vue-table";
  const column = createColumnHelper<TitikPermohonan>();
  
  import { usePreviewReport } from '@/stores';
  import { block, unblock } from '@/libs/utils';
  import { toast } from 'vue3-toastify';
  import axios from '@/libs/axios';
  import moment from 'moment';
  import { useTandaTangan } from '@/services';
  
  export default defineComponent({
    setup() {
      const files = ref<Array<File | String>>([])
      const fileTypes = ref(['application/pdf']) // 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
      const onUpadateFiles = (newFiles: Array<File | String>) => {
        files.value = newFiles
      }
  
      const { previewReport } = usePreviewReport()
      const reportUrl = ref<string>("");
  
      const paginateBelum = ref<any>(null);
      const paginateSudah = ref<any>(null);
  
      const selected = ref<string | any>("");
      const keteranganRevisi = ref<string | any>("");
      const openDetail = ref<boolean>(false);
  
      // const date = ref<any>(`${moment().startOf('month').format('YYYY-MM-DD')} to ${moment().format('YYYY-MM-DD')}`)
      const tahun = ref(new Date().getFullYear());
      const tahunSudah = ref(new Date().getFullYear());
      const tahuns = ref<any[]>([]);
      for (let i = tahun.value; i >= 2022; i--) {
        tahuns.value.push({ id: i, text: i });
      }
      const bulan = ref(new Date().getMonth() + 1)
      const bulans = ref<any[]>([
        { id: 1, text: "Januari" },
        { id: 2, text: "Februari" },
        { id: 3, text: "Maret" },
        { id: 4, text: "April" },
        { id: 5, text: "Mei" },
        { id: 6, text: "Juni" },
        { id: 7, text: "Juli" },
        { id: 8, text: "Agustus" },
        { id: 9, text: "September" },
        { id: 10, text: "Oktober" },
        { id: 11, text: "November" },
        { id: 12, text: "Desember" },
      ])
  
      const iframeReport = ref<any>(null)
      const { download: downloadReport } = useDownloadPdf({
        onSuccess: () => {
          paginateBelum.value.refetch()
          paginateSudah.value.refetch()
        }
      });
      const { download: downloadReportWord } = useDownloadWord({
        onSuccess: () => {
          paginateBelum.value.refetch()
          paginateSudah.value.refetch()
        }
      });
  
  
      const columnsBelum = [
        column.accessor("no", {
          header: "#"
        }),
        column.accessor("kode", {
          header: "Kode",
          cell: cell => h('div', {
            style: {
              whiteSpace: 'nowrap'
            }
          }, [cell.getValue()])
        }),
        column.accessor("permohonan", {
          header: "Pelanggan",
          cell: cell => cell.getValue().user?.nama
        }),
        column.accessor("lokasi", {
          header: "Titik Uji/Lokasi",
        }),
        column.accessor("text_status", {
          header: "Status",
          cell: cell => h('div', [
            h('span', { class: 'badge badge-light-primary' }, cell.getValue())
          ])
        }),
        column.accessor("tanggal_diterima", {
          header: "Tanggal Diterima",
        }),
        column.accessor("uuid", {
          header: "Aksi",
          cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
            h('div', { class: 'dropup' }, [
              h('button', {
                class: 'btn btn-sm btn btn-light-success',
                'data-bs-toggle': 'dropdown',
              }, [
                h('i', { class: 'la la-file-contract me-0 fs-2' }),
                h('span', { class: 'd-none d-md-inline me-2' }, 'Cetak LHU'),
                h('i', { class: 'la la-angle-down me-0 fs-2' }),
              ]),
              h('div', {
                class: 'dropdown-menu',
              }, [
                h('div', { class: 'dropdown-item px-3' }, [
                  h('button', {
                    class: 'btn btn-sm w-100 text-start btn-danger', onClick: () => {
                      if (previewReport.value) {
                        block('#modal-report .modal-body')
                        reportUrl.value = `/api/v1/report/${cell.getValue()}/cetak-lhu?token=${localStorage.getItem('auth_token')}`
  
                        iframeReport.value.contentWindow.location.reload()
                        $('#modal-report').modal('show')
                      } else {
                        downloadReport(`/report/${cell.getValue()}/lhu`)
                      }
                    }
                  }, [
                    h('i', { class: 'la la-file-pdf fs-2' }),
                    h('span', { class: 'd-none d-md-inline' }, 'PDF')
                  ]),
                ]),
              ])
            ]),
            !cell.row.original.can_upload ? '' : 
            h('button', {
              class: 'btn btn-sm btn-light-primary', onClick: () => {
                selected.value = cell.getValue()
                $('#modal-upload').modal('show')
              }
            }, 
             [
              h('i', { class: 'la la-file-upload fs-2' }),
              h('span', { class: 'd-none d-md-inline' }, 'Upload LHU')
            ]),
            cell.row.original.status == '-1' &&
            h('button', {
              class: 'btn btn-sm btn-light-primary', onClick: () => {
                keteranganRevisi.value = cell.row.original?.keterangan_revisi
                $('#modal-revisi').modal('show')
              }
            },
            [
              h('i', { class: 'la la-pencil fs-2' }),
              h('span', { class: 'd-none d-md-inline' }, 'Revisi')
            ])
          ])
        }),
      ]

      const columnsSudah = [
        column.accessor("no", {
          header: "#"
        }),
        column.accessor("kode", {
          header: "Kode",
          cell: cell => h('div', {
            style: {
              whiteSpace: 'nowrap'
            }
          }, [cell.getValue()])
        }),
        column.accessor("permohonan", {
          header: "Pelanggan",
          cell: cell => cell.getValue().user?.nama
        }),
        column.accessor("lokasi", {
          header: "Titik Uji/Lokasi",
        }),
        column.accessor("text_status", {
          header: "Status",
          cell: cell => h('div', [
            h('span', { class: 'badge badge-light-primary' }, cell.getValue())
          ])
        }),
        column.accessor("tanggal_diterima", {
          header: "Tanggal Diterima",
        }),
        column.accessor("uuid", {
          header: "Aksi",
          cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
            h('div', { class: 'dropup' }, [
              h('button', {
                class: 'btn btn-sm btn btn-light-danger', onClick: () => {
                    if (previewReport.value) {
                        block('#modal-report .modal-body')
                        reportUrl.value = `/api/v1/report/${cell.getValue()}/preview-lhu?token=${localStorage.getItem('auth_token')}`
                        $('#modal-report').modal('show')
                    } else {
                        downloadReport(`/report/${cell.getValue()}/preview-lhu`)
                    }
                }
              }, [
                  h('i', { class: 'la la-file-pdf fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Preview LHU')
              ]),
            ])
          ])
        }),
      ]
  
      const formTte = ref<any>({})
  
      return {
        columnsBelum,
        columnsSudah,
        selected,
        openDetail,
        paginateBelum,
        paginateSudah,
        tahun,
        tahuns,
        tahunSudah,
        bulan,
        bulans,
        reportUrl,
        block, unblock,
        keteranganRevisi,
        iframeReport,
        refresh: () => {
          paginateBelum.value?.refetch()
          paginateSudah.value?.refetch()
        },
        // date,
        files,
        fileTypes,
        onUpadateFiles,
        formTte,
        previewReport,
        downloadReport
      }
    },
    watch: {
      openDetail(val) {
        if (!val) {
          this.selected = "";
        }
        window.scrollTo(0, 0);
      }
    },
    methods: {
      sendLhu() {
        if (!this.files[0]) {
          toast.error('File tidak boleh kosong')
        }
  
        block('#modal-upload .modal-content')
  
        const formData = new FormData()
        formData.append('file', this.files[0].file as File)
  
        axios.post(`/administrasi/${this.selected}/upload`, formData).then(() => {
          $('#modal-upload').modal('hide');
          this.paginateBelum?.refetch();
          toast.success('Data berhasil disimpan')
  
          this.selected = ""
          this.files = []
        }).catch(err => {
          toast.error(err.response.data.message)
        }).finally(() => {
          unblock('#modal-upload .modal-content')
        })
      },
      sendTteLhu() {
        $('#modal-tte').modal('hide')
  
        if (this.previewReport) {
          block('#modal-report .modal-body')
          this.reportUrl = `/api/v1/report/${this.selected}/lhu/tte?token=${localStorage.getItem('auth_token')}&tanda_tangan_id=${this.formTte.tanda_tangan_id}&passphrase=${btoa(this.formTte.passphrase)}&tipe=${this.formTte.tipe}`
  
          this.iframeReport.contentWindow.location.reload()
          $('#modal-report').modal('show')
        } else {
          this.downloadReport(`/report/${this.selected}/lhu/tte?tanda_tangan_id=${this.formTte.tanda_tangan_id}&passphrase=${btoa(this.formTte.passphrase)}&tipe=${this.formTte.tipe}`)
        }
      },
      onLoadIframe() {
        this.unblock('#modal-report .modal-body')
        this.refresh()
      }
    },
    // computed: {
    //   start() {
    //     return this.date.split(' to ')[0]
    //   },
    //   end() {
    //     return this.date.split(' to ')[1]
    //   }
    // },
    // // mounted() {
    // //     window.addEventListener('message', function (event) {
    // //         console.log("Message received from the child: " + event.data); // Message received from child
    // //     });
    // // }
  })
  </script>
  