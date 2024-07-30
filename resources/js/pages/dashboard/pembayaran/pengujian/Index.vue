<template>
  <Detail :selected="selected" @close="openDetail = false" v-if="openDetail" @refresh="refresh" />

  <div v-if="!openDetail" class="card mb-10">
    <div class="card-header align-items-center">
      <h2 class="mb-0">Menunggu Pembayaran</h2>
      <div class="d-flex gap-4">
        <button @click="massReport" class="btn btn-light-danger btn-sm">
          <i class="la la-file-pdf fs-2"></i>
          Laporan
        </button>
        <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tahuns"
          v-model="tahun">
        </select2>
      </div>
    </div>
    <div class="card-body">
      <paginate ref="paginate" id="table-konfirmasi" url="/pembayaran/pengujian" :columns="columns"
        queryKey="pengujian-0" :payload="{ tahun: tahun }">
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
          <h3 class="modal-title">Ajukan TTE</h3>

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
import { useDownloadPdf } from "@/libs/hooks";

import { usePreviewReport } from '@/stores';
import { block, unblock } from '@/libs/utils';

import Detail from './Detail.vue';

interface TitikPermohonan {
  no: number,
  uuid: string,
  kode: string,
  lokasi: string,
  tgl_diterima: string,
  tgl_selesai: string,
  status: number,
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
  payment: {
    id: number,
    is_expired: boolean,
    status: string,
  },
}
import { createColumnHelper } from "@tanstack/vue-table";
import { currency } from '@/libs/utils';
import { useTandaTangan } from '@/services';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
const column = createColumnHelper<TitikPermohonan>();

export default defineComponent({
  components: {
    Detail,
  },
  setup() {
    const { previewReport } = usePreviewReport()
    const reportUrl = ref<string>("");
    const iframeReport = ref<any>(null);

    const paginate = ref<any>(null);

    const selected = ref<string | any>("");
    const openDetail = ref<boolean>(false);

    const tahun = ref(new Date().getFullYear());
    const tahuns = ref<any[]>([]);
    for (let i = tahun.value; i >= 2022; i--) {
      tahuns.value.push({ id: i, text: i });
    }

    const { download: downloadReport } = useDownloadPdf({
      onSuccess: () => {
        paginate.value.refetch()

        axios.post(`/permohonan/titik/${selected.value}/status-tte`, { column: `status_tte_${formTte.value.type}` }).then(res => {
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
      column.accessor("harga", {
        header: "Harga",
        cell: cell => currency(cell.getValue())
      }),
      column.accessor("payment", {
        header: "Status Pembayaran",
        cell: cell => h('div', [
          cell.row.original.payment?.is_expired ? h('span', { class: `badge badge-light-danger` }, 'Kedaluwarsa') : h('span', { class: `badge badge-light-${cell.getValue()?.status == 'pending' ? 'info' : (cell.getValue()?.status == 'success' ? 'success' : 'danger')}` }, cell.row.original.text_status_pembayaran)
        ])
      }),
      column.accessor("uuid", {
        header: "Aksi",
        cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
          h('button', {
            class: 'btn btn-sm btn-info',
            onClick: () => {
              openDetail.value = true;
              selected.value = cell.getValue();
            },
            style: {
              whiteSpace: 'nowrap'
            }
          }, [h('i', { class: 'la la-credit-card fs-2' }), 'Detail']),
          !!cell.row.original.payment?.id && h('div', { class: 'dropup' }, [
            h('button', {
              class: 'btn btn-sm btn btn-primary',
              'data-bs-toggle': 'dropdown',
            }, [
              h('i', { class: 'la la-file-contract me-0 fs-2' }),
              h('span', { class: 'd-none d-md-inline me-2' }, 'TTE SKRD'),
              h('i', { class: 'la la-angle-down me-0 fs-2' }),
            ]),
            h('div', {
              class: 'dropdown-menu',
            }, [
              Boolean(cell.row.original.tte_skrd) && h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-danger', onClick: () => {
                    if (previewReport.value) {
                      block('#modal-report .modal-body')
                      reportUrl.value = `/api/v1/report/${cell.getValue()}/skrd/tte/download?token=${localStorage.getItem('auth_token')}`

                      iframeReport.value.contentWindow.location.reload()
                      $('#modal-report').modal('show')
                    } else {
                      downloadReport(`/report/${cell.getValue()}/skrd/tte/download`)
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
                    formTte.value = { type: 'skrd' }
                    $("#modal-tte").modal("show")
                  }
                }, [
                  h('i', { class: 'la la-file-signature fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Ajukan TTE')
                ]),
              ]),
            ])
          ]),
          cell.row.original.payment?.is_lunas == 1 && h('div', { class: 'dropup' }, [
            h('button', {
              class: 'btn btn-sm btn btn-warning',
              'data-bs-toggle': 'dropdown',
            }, [
              h('i', { class: 'la la-file-contract me-0 fs-2' }),
              h('span', { class: 'd-none d-md-inline me-2' }, 'TTE Kwitansi'),
              h('i', { class: 'la la-angle-down me-0 fs-2' }),
            ]),
            h('div', {
              class: 'dropdown-menu',
            }, [
              Boolean(cell.row.original.tte_kwitansi) && h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-danger', onClick: () => {
                    if (previewReport.value) {
                      block('#modal-report .modal-body')
                      reportUrl.value = `/api/v1/report/${cell.getValue()}/kwitansi/tte/download?token=${localStorage.getItem('auth_token')}`

                      iframeReport.value.contentWindow.location.reload()
                      $('#modal-report').modal('show')
                    } else {
                      downloadReport(`/report/${cell.getValue()}/kwitansi/tte/download`)
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
                    formTte.value = { type: 'kwitansi' }
                    $("#modal-tte").modal("show")
                  }
                }, [
                  h('i', { class: 'la la-file-signature fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Ajukan TTE')
                ]),
              ]),
            ])
          ]),
          h('div', { class: 'dropup' }, [
            h('button', {
              class: 'btn btn-sm btn btn-light-danger',
              'data-bs-toggle': 'dropdown',
            }, [
              h('i', { class: 'la la-file-pdf me-0 fs-2' }),
              h('span', { class: 'd-none d-md-inline me-2' }, 'PDF'),
              h('i', { class: 'la la-angle-down me-0 fs-2' }),
            ]),
            h('div', {
              class: 'dropdown-menu',
            }, [
              h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-light-primary', onClick: () => {
                    if (previewReport.value) {
                      block('#modal-report .modal-body')
                      reportUrl.value = `/api/v1/report/${cell.getValue()}/skrd?token=${localStorage.getItem('auth_token')}`

                      iframeReport.value.contentWindow.location.reload()
                      $('#modal-report').modal('show')
                    } else {
                      downloadReport(`/report/${cell.getValue()}/skrd`)
                    }
                  }
                }, [
                  h('i', { class: 'la la-file-pdf fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'SKRD')
                ]),
              ]),
              cell.row.original.payment?.is_lunas == 1 && h('div', { class: 'dropdown-item px-3' }, [
                h('button', {
                  class: 'btn btn-sm w-100 text-start btn-light-warning', onClick: () => {
                    if (previewReport.value) {
                      block('#modal-report .modal-body')
                      reportUrl.value = `/api/v1/report/${cell.getValue()}/kwitansi?token=${localStorage.getItem('auth_token')}`

                      iframeReport.value.contentWindow.location.reload()
                      $('#modal-report').modal('show')
                    } else {
                      downloadReport(`/report/${cell.getValue()}/kwitansi`)
                    }
                  }
                }, [
                  h('i', { class: 'la la-file-pdf fs-2' }),
                  h('span', { class: 'd-none d-md-inline' }, 'Kwitansi')
                ]),
              ]),
            ])
          ])
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
      downloadReport,
      previewReport,
      refresh: () => {
        paginate.value.refetch()
      },
      iframeReport,
      formTte,
      ttd, ttds,
    }
  },
  methods: {
    massReport() {
      if (this.previewReport) {
        block('#modal-report .modal-body')
        this.reportUrl = `/api/v1/report/pembayaran/pengujian?tahun=${this.tahun}&token=${localStorage.getItem('auth_token')}`
        $('#modal-report').modal('show')
      } else {
        this.downloadReport(`/report/pembayaran/pengujian?tahun=${this.tahun}`)
      }
    },
    sendTteLhu() {
      $('#modal-tte').modal('hide')

      if (this.previewReport) {
        block('#modal-report .modal-body')
        this.reportUrl = `/api/v1/report/${this.selected}/${this.formTte.type}/tte?token=${localStorage.getItem('auth_token')}&tanda_tangan_id=${this.formTte.tanda_tangan_id}&passphrase=${btoa(this.formTte.passphrase)}`

        this.iframeReport.contentWindow.location.reload()
        $('#modal-report').modal('show')
      } else {
        this.downloadReport(`/report/${this.selected}/${this.formTte.type}/tte?tanda_tangan_id=${this.formTte.tanda_tangan_id}&passphrase=${btoa(this.formTte.passphrase)}`)
      }
    },
    onLoadIframe() {
      this.unblock('#modal-report .modal-body')
      this.refresh()

      axios.post(`/permohonan/titik/${this.selected}/status-tte`, { column: `status_tte_${this.formTte.type}` }).then(res => {
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
  }
})
</script>
