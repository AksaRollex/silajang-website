<template>
  <div class="card">
    <div class="card-header align-items-center">
      <h2 class="mb-0">Kendali Mutu</h2>
      <div>
        <date-picker v-model="date" :config="{ mode: 'range' }" style="width: 225px"></date-picker>
      </div>
    </div>
    <div class="card-body">
      <paginate ref="paginate" id="table-diambil" url="/report" :columns="columns" queryKey="kendali-mutu"
        :payload="{ status: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11], start, end }">
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

  <div class="modal fade" tabindex="-1" id="modal-tte">
    <form class="modal-dialog modal-dialog-centered" @submit.prevent="sendTteLhu" id="form-tte">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Ajukan TTE Kendali Mutu</h3>

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
import { defineComponent, h, ref, computed } from 'vue'
import { useDownloadPdf } from "@/libs/hooks";

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
  text_status: string,
  status_pembayaran: number,
  text_status_pembayaran: string,
  harga: number,
  is_has_subkontrak: boolean,
  nama_pengambil: string,
  tanggal_diterima: string,
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
import { useTandaTangan } from '@/services'
import moment from 'moment';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';

export default defineComponent({
  setup() {
    const { previewReport } = usePreviewReport()
    const reportUrl = ref<string>("");
    const iframeReport = ref<any>(null);

    const paginate = ref<any>(null);

    const selected = ref<string | any>("");
    const openDetail = ref<boolean>(false);

    const date = ref<any>(`${moment().startOf('month').format('YYYY-MM-DD')} to ${moment().format('YYYY-MM-DD')}`)
    const tahun = ref(new Date().getFullYear());
    const tahuns = ref<any[]>([]);
    for (let i = tahun.value; i >= 2022; i--) {
      tahuns.value.push({ id: i, text: i });
    }

    const { download: downloadReport } = useDownloadPdf({
      onSuccess: () => {
        paginate.value.refetch()

        axios.post(`/permohonan/titik/${selected.value}/status-tte`, { column: "status_tte_kendali_mutu" }).then(res => {
          if (res.data.status_tte === 1) toast.success('Pengajuan TTE Berhasil')
          else if (res.data.status_tte === 0) toast.error('Pengajuan TTE Gagal')
        })
      }
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
        cell: cell => cell.getValue().user.nama
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
      column.accessor("status_tte_kendali_mutu", {
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
              Boolean(cell.row.original.tte_kendali_mutu) && h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-danger', onClick: () => {
                    if (previewReport.value) {
                      block('#modal-report .modal-body')
                      reportUrl.value = `/api/v1/report/${cell.getValue()}/kendali-mutu/tte/download?token=${localStorage.getItem('auth_token')}`

                      iframeReport.value.contentWindow.location.reload()
                      $('#modal-report').modal('show')
                    } else {
                      downloadReport(`/report/${cell.getValue()}/kendali-mutu/tte/download`)
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
                    formTte.value = {}
                    $("#modal-tte").modal("show")
                  }
                }, [
                  h('i', { class: 'la la-file-signature fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Ajukan TTE')
                ]),
              ]),
            ]),
          ]),
          h('button', {
            class: 'btn btn-sm btn-light-danger', onClick: () => {
              if (previewReport.value) {
                block('#modal-report .modal-body')
                reportUrl.value = `/api/v1/report/${cell.getValue()}/kendali-mutu?token=${localStorage.getItem('auth_token')}`

                iframeReport.value.contentWindow.location.reload()
                $('#modal-report').modal('show')
              } else {
                downloadReport(`/report/${cell.getValue()}/kendali-mutu`)
              }
            }
          }, [
            h('i', { class: 'la la-file-pdf fs-2' }),
            h('span', { class: 'd-none d-md-inline' }, 'PDF')
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
      reportUrl,
      block, unblock,
      refresh: () => {
        paginate.value.refetch()
      },
      date,
      iframeReport,
      formTte,
      ttd, ttds,
      previewReport,
      downloadReport
    }
  },
  methods: {
    sendTteLhu() {
      $('#modal-tte').modal('hide')

      if (this.previewReport) {
        block('#modal-report .modal-body')
        this.reportUrl = `/api/v1/report/${this.selected}/kendali-mutu/tte?token=${localStorage.getItem('auth_token')}&tanda_tangan_id=${this.formTte.tanda_tangan_id}&passphrase=${btoa(this.formTte.passphrase)}`

        this.iframeReport.contentWindow.location.reload()
        $('#modal-report').modal('show')
      } else {
        this.downloadReport(`/report/${this.selected}/kendali-mutu/tte?tanda_tangan_id=${this.formTte.tanda_tangan_id}&passphrase=${btoa(this.formTte.passphrase)}`)
      }
    },
    onLoadIframe() {
      this.unblock('#modal-report .modal-body')
      this.refresh()

      axios.post(`/permohonan/titik/${this.selected}/status-tte`, { column: "status_tte_kendali_mutu" }).then(res => {
        if (res.data.status_tte === 1) toast.success('Pengajuan TTE Berhasil')
        else if (res.data.status_tte === 0) toast.error('Pengajuan TTE Gagal')
      })
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
  computed: {
    start() {
      return this.date.split(' to ')[0]
    },
    end() {
      return this.date.split(' to ')[1]
    }
  }
})
</script>
