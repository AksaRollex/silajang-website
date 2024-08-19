<template>
  <div class="card">
    <div class="card-header align-items-center">
      <h2 class="mb-0">Laporan Hasil Pengujian</h2>
      <div class="d-flex align-items-center gap-5">
        <!-- <div>
          <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker>
        </div> -->
        <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tahuns"
          v-model="tahun">
        </select2>
        <select2 placeholder="Pilih Bulan" class="form-select-solid mw-200px mw-md-100" name="bulan" :options="bulans"
          v-model="bulan">
        </select2>
      </div>
    </div>
    <div class="card-body">
      <paginate ref="paginate" id="table-lhu" url="/report" :columns="columns" queryKey="lhu"
        :payload="{ 
          status: [9, 10, 11], 
          // start, 
          // end,
          tahun,
          bulan }">
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

  <div class="modal fade" tabindex="-1" id="modal-tte">
    <form class="modal-dialog modal-dialog-centered" @submit.prevent="sendTteLhu" id="form-tte">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Ajukan TTE LHU ({{ formTte.tipe }})</h3>

          <!--begin::Close-->
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
          </div>
          <!--end::Close-->
        </div>

        <div class="modal-body">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Tanda Tangan</label>
            <Field type="hidden" v-model="formTte.tanda_tangan_id" name="tanda_tangan_id" readonly />
            <select2 placeholder="Pilih Tipe" class="form-select-solid" :options="ttds"
              v-model="formTte.tanda_tangan_id">
            </select2>
            <div class="fv-help-block">
              <ErrorMessage name="nama" />
            </div>
          </div>

          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Passphrase</label>
            <Field class="form-control form-control-lg form-control-solid" type="password" name="passphrase"
              autocomplete="off" v-model="formTte.passphrase" />
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="passphrase" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="la la-file-signature fs-2"></i>
            Kirim
          </button>
        </div>
      </div>
    </form>
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
    const fileTypes = ref(['application/pdf'])
    const onUpadateFiles = (newFiles: Array<File | String>) => {
      files.value = newFiles
    }

    const { previewReport } = usePreviewReport()
    const reportUrl = ref<string>("");

    const paginate = ref<any>(null);

    const selected = ref<string | any>("");
    const openDetail = ref<boolean>(false);

    // const date = ref<any>(`${moment().startOf('month').format('YYYY-MM-DD')} to ${moment().format('YYYY-MM-DD')}`)
    const tahun = ref(new Date().getFullYear());
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
        paginate.value.refetch()
        axios.post(`/permohonan/titik/${selected.value}/status-tte`, { column: "status_tte" }).then(res => {
          if (res.data.status_tte === 1) toast.success('Pengajuan TTE Berhasil')
          else if (res.data.status_tte === 0) toast.error('Pengajuan TTE Gagal')
        })
      }
    });
    const { download: downloadReportWord } = useDownloadWord({
      onSuccess: () => paginate.value.refetch()
    });


    const columns = [
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
      column.accessor("tanggal_selesai", {
        header: "Tanggal Selesai",
      }),
      column.accessor("sertifikat", {
        header: "Salinan ke...",
        cell: cell => cell.getValue() ? h('span', { class: 'badge badge-light-info' }, `Salinan ke-${cell.getValue()}`) : h('span', { class: 'badge badge-light-warning' }, 'Belum Dicetak')
      }),
      column.accessor("tanggal_tte", {
        header: "Tanggal TTE",
      }),
      column.accessor("status_tte", {
        header: "Status TTE",
        cell: cell => {
          if (cell.getValue() === 1) return h('span', { class: 'badge badge-light-success' }, 'Berhasil')
          if (cell.getValue() === 0) return h('span', { class: 'badge badge-light-danger' }, 'Gagal')
          return ""
        }
      }),
      column.accessor("uuid", {
        header: "Aksi",
        cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
          h('div', { class: 'dropup' }, [
            h('button', {
              class: 'btn btn-sm btn btn-success',
              'data-bs-toggle': 'dropdown',
            }, [
              h('i', { class: 'la la-file-contract me-0 fs-2' }),
              h('span', { class: 'd-none d-md-inline me-2' }, 'TTE'),
              h('i', { class: 'la la-angle-down me-0 fs-2' }),
            ]),
            h('div', {
              class: 'dropdown-menu',
            }, [
              Boolean(cell.row.original.tte_lhu) && h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-danger', onClick: () => {
                    if (previewReport.value) {
                      block('#modal-report .modal-body')
                      reportUrl.value = `/api/v1/report/${cell.getValue()}/lhu/tte/download?token=${localStorage.getItem('auth_token')}`

                      iframeReport.value.contentWindow.location.reload()
                      $('#modal-report').modal('show')
                    } else {
                      downloadReport(`/report/${cell.getValue()}/lhu/tte/download`)
                    }
                  }
                }, [
                  h('i', { class: 'la la-file-pdf fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Download TTE')
                ]),
              ]),
              h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-success', onClick: () => {
                    selected.value = cell.getValue()
                    formTte.value = { tipe: "system" }
                    $("#modal-tte").modal("show")
                  }
                }, [
                  h('i', { class: 'la la-file-signature fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Ajukan TTE (System)')
                ]),
              ]),
              Boolean(cell.row.original.file_lhu) && h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-success', onClick: () => {
                    selected.value = cell.getValue()
                    formTte.value = { tipe: "manual" }
                    $("#modal-tte").modal("show")
                  }
                }, [
                  h('i', { class: 'la la-file-signature fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Ajukan TTE (Manual)')
                ]),
              ]),
            ])
          ]),
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
                      reportUrl.value = `/api/v1/report/${cell.getValue()}/lhu?token=${localStorage.getItem('auth_token')}`

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
              h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-primary', onClick: () => {
                    downloadReportWord(`/report/${cell.getValue()}/lhu/word`)
                  }
                }, [
                  h('i', { class: 'la la-file-word fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'WORD')
                ]),
              ]),
            ])
          ]),
          h('button', {
            class: 'btn btn-sm btn-light-primary', onClick: () => {
              selected.value = cell.getValue()
              $('#modal-upload').modal('show')
            }
          }, [
            h('i', { class: 'la la-file-upload fs-2' }),
            h('span', { class: 'd-none d-md-inline' }, 'Upload LHU')
          ]),
        ])
      }),
    ]

    const formTte = ref<any>({})
    const ttd = useTandaTangan()
    const ttds = computed(() => ttd.data.value?.map(item => ({
      id: item.id,
      text: `${item.bagian} - ${item.user?.nama} (${item.user?.nik})`
    })))

    return {
      columns,
      selected,
      openDetail,
      paginate,
      tahun,
      tahuns,
      bulan,
      bulans,
      reportUrl,
      block, unblock,
      iframeReport,
      refresh: () => {
        paginate.value?.refetch()
      },
      // date,
      files,
      fileTypes,
      onUpadateFiles,
      formTte,
      ttds,
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

      axios.post(`/report/${this.selected}/upload`, formData).then(() => {
        $('#modal-upload').modal('hide');
        this.paginate?.refetch();
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

      axios.post(`/permohonan/\w/${this.selected}/status-tte`, { column: "status_tte" }).then(res => {
        if (res.data.status_tte === 1) toast.success('Pengajuan TTE Berhasil')
        else if (res.data.status_tte === 0) toast.error('Pengajuan TTE Gagal')
      })
    }
  },
  computed: {
    start() {
      return this.date.split(' to ')[0]
    },
    end() {
      return this.date.split(' to ')[1]
    }
  },
  // mounted() {
  //     window.addEventListener('message', function (event) {
  //         console.log("Message received from the child: " + event.data); // Message received from child
  //     });
  // }
})
</script>
