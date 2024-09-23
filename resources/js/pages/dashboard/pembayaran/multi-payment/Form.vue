<template>
  <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
    <div class="card-header align-items-center">
      <div class="d-flex align-items-center">
        <h2 class="mb-0">{{ selected ? 'Edit' : 'Buat' }} Multi Payment</h2>
      </div>
      <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
        Batal
        <i class="la la-times-circle p-0"></i>
      </button>
    </div>
    <div class="card-body">
      <div class="row mb-10">
        <div class="col-12">
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Metode Pembayaran</label>
            <div class="row">
              <div class="col-md-6">
                <Field class="form-control form-control-lg form-control-solid" type="radio" name="type"
                  autocomplete="off" v-model="formData.type">
                  <input type="radio" class="btn-check" name="type" value="va" id="va" v-model="formData.type" />
                  <label
                    class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                    for="va">
                    <i class="ki-duotone ki-finance-calculator fs-2x me-4">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                      <span class="path5"></span>
                      <span class="path6"></span>
                      <span class="path7"></span>
                    </i>

                    <span class="d-block fw-semibold text-start">
                      <span class="text-dark fw-bold d-block fs-3">Virtual Account</span>
                      <span class="text-muted fw-semibold fs-6">
                        Transfer melalui Virtual Account Bank Jatim
                      </span>
                    </span>
                  </label>
                </Field>
              </div>
              <div class="col-md-6">
                <Field class="form-control form-control-lg form-control-solid" type="radio" name="type"
                  autocomplete="off" v-model="formData.type">
                  <!--begin::Option-->
                  <input type="radio" class="btn-check" name="type" value="qris" id="qris" v-model="formData.type" />
                  <label
                    class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                    for="qris">
                    <i class="ki-duotone ki-barcode fs-2x me-4">
                      <span class="path1"></span>
                      <span class="path2"></span>
                      <span class="path3"></span>
                      <span class="path4"></span>
                      <span class="path5"></span>
                      <span class="path6"></span>
                      <span class="path7"></span>
                      <span class="path8"></span>
                    </i>

                    <span class="d-block fw-semibold text-start">
                      <span class="text-dark fw-bold d-block fs-3">
                        QRIS</span>
                      <span class="text-muted fw-semibold fs-6">
                        Scan dan Bayar melalui QRIS
                      </span>
                    </span>
                  </label>
                  <!--end::Option-->
                </Field>
              </div>
            </div>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="type" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-8">
          <div class="form-group">
            <label class="form-label">Titik Permohonan Dipilih</label>
            <div class="d-flex bg-light rounded-3 gap-4 flex-wrap p-4">
              <span v-for="item in selectedTitik" :key="item.uuid" class="badge badge-light-primary">{{ item.kode
                }}</span>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="form-label">Total Harga</label>
            <h6>{{ currency(totalHarga) }}</h6>
          </div>
        </div>
      </div>
      <paginate v-if="formData.type" ref="paginate" id="table-konfirmasi" url="/pembayaran/multi-payment/titiks"
        :columns="columns" :payload="{ type: formData.type }">
      </paginate>
    </div>
    <div class="card-footer d-flex">
      <button type="submit" class="btn btn-primary btn-sm ms-auto">
        Simpan
      </button>
    </div>
  </VForm>
</template>

<script lang="ts">
import { block, unblock, currency, copyString } from '@/libs/utils';
import { computed, defineComponent, ref, h } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useKodeRetribusi } from '@/services';
import moment from 'moment';

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
    tanggal_bayar: string,
  },
}
import { createColumnHelper } from "@tanstack/vue-table";
const column = createColumnHelper<TitikPermohonan>();


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
  type: string
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
      type: Yup.string().required('Metode Pembayaran harus diisi'),
    })

    const kodeRetribusi = useKodeRetribusi()
    const kodeRetribusis = computed(() => kodeRetribusi.data.value?.map(item => ({
      id: item.id,
      text: item.nama
    })))

    const dateExp = ref<any>(null)
    const dateExpInterval = ref<any>(null)
    const now = ref(moment())

    const selectedTitik = ref<Array<TitikPermohonan>>([])

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
      column.accessor("uuid", {
        header: "Aksi",
        cell: (cell) => h('div', { class: 'd-flex gap-2 flex-wrap' }, [
          h('button', {
            type: 'button',
            class: `btn btn-sm w-100 ${selectedTitik.value.find(item => item.uuid == cell.getValue()) ? 'btn-primary' : 'btn-light'}`,
            onClick: () => {
              if (selectedTitik.value.find(item => item.uuid == cell.getValue())) {
                selectedTitik.value = selectedTitik.value.filter(item => item.uuid != cell.getValue())
              } else {
                selectedTitik.value.push(cell.row.original)
              }
            },
            style: {
              whiteSpace: 'nowrap'
            }
          }, [h('i', { class: 'la la-check-circle fs-2' }), selectedTitik.value.find(item => item.uuid == cell.getValue()) ? '' : ' Pilih']),
        ])
      }),
    ]

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
      columns,
      selectedTitik
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
      block(this.$el)

      axios.post('/pembayaran/multi-payment/store', {
        ...this.formData,
        multiPayments: this.selectedTitik.map(item => ({
          titik_permohonan_id: item.id
        }))
      })
        .then((res) => {
          toast.success('Data berhasil disimpan')

          this.$emit('close')
          this.$emit('refresh')
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
    },
    totalHarga() {
      return this.selectedTitik.reduce((acc, item) => acc + item.harga, 0)
    }
  },
  watch: {
    selected() {
      if (this.selected) {
        this.getEdit()
      }
    },
    'formData.type': function () {
      this.selectedTitik = []
    }
  }
})
</script>
