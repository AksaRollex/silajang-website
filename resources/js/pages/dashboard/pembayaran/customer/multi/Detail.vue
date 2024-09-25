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
      <div class="row mb-10">
        <div class="col-8">
          <div class="form-group">
            <label class="form-label">Titik Permohonan Dipilih</label>
            <div class="d-flex bg-light rounded-3 gap-4 flex-wrap p-4">
              <span v-for="item in formData.multi_payments" :key="item.titik_permohonan.uuid"
                class="badge badge-light-primary">{{ item.titik_permohonan.kode
                }}</span>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="form-group">
            <label class="form-label">Total Harga</label>
            <h6>{{ currency(formData.jumlah) }}</h6>
          </div>
        </div>
      </div>
      <template v-if="!formData.qris_value && !formData.va_number && formData.status != 'success'">
        <div class="row">
          <div class="col-xl-3 col-sm-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Total Harga</label>
              <div class="fs-4">
                <strong>{{ currency(formData.jumlah) }}</strong>
              </div>
            </div>
            <!--end::Input group-->
          </div>
          <div class="col-xl-3 col-sm-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Atas Nama</label>
              <div class="fs-4">
                <strong>{{ formData.multi_payments?.[0]?.titik_permohonan?.permohonan?.user?.nama }}</strong>
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
            <h4 v-if="formData.type == 'va'" class="mb-1 text-dark">VA Pembayaran Belum Dibuat</h4>
            <h4 v-else-if="formData.type == 'qris'" class="mb-1 text-dark">QRIS Belum Dibuat</h4>
            <!--end::Title-->

            <!--begin::Content-->
            <span v-if="formData.type == 'va'">Silahkan klik Tombol Di Bawah untuk Membuat VA Pembayaran</span>
            <span v-else-if="formData.type == 'qris'">Silahkan klik Tombol Di Bawah untuk Membuat QRIS</span>
            <!--end::Content-->
          </div>
          <!--end::Wrapper-->
        </div>
      </template>
      <template v-else>
        <div class="row row-gap-8">
          <div class="col-12" v-if="formData.status === 'success'">
            <div class="bg-success text-white py-1 rounded-1 text-center">Pembayaran berhasil dilakukan pada: <strong>{{
          moment(formData.tanggal_bayar).format('DD-MM-YYYY') }}</strong></div>
          </div>
          <div class="col-12" v-else-if="formData.is_expired === false">
            <div class="bg-primary text-white py-1 rounded-1 text-center">Lakukan pembayaran sebelum: <strong>{{
          countdownExp }}</strong>
            </div>
          </div>
          <div class="col-12" v-else-if="formData.type == 'va'">
            <div class="bg-danger text-white py-1 rounded-1 text-center">VA Pembayaran telah kedaluwarsa</div>
            <div class="my-10">
              <div class="fs-3 text-center">Silakan Hubungi Admin Kami untuk Melakukan Permintaan Pembuatan VA
                Pembayaran
              </div>
              <div class="d-flex align-items-center justify-content-between mt-4 mx-auto flex-wrap gap-4"
                style="max-width: 560px">
                <div class="d-flex align-items-center gap-4">
                  <i class="fa fa-envelope text-dark fs-1"></i>
                  <div>
                    <div>Email :</div>
                    <H6>{{ setting?.email }}</H6>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                  <i class="fa fa-phone text-dark fs-1"></i>
                  <div>
                    <div>Telepon :</div>
                    <H6>{{ setting?.telepon }}</H6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12" v-else-if="formData.type == 'qris'">
            <div class="bg-danger text-white py-1 rounded-1 text-center">QRIS telah kedaluwarsa</div>
            <div class="my-10">
              <div class="fs-3 text-center">Silakan Hubungi Admin Kami untuk Melakukan Permintaan Pembuatan QRIS
              </div>
              <div class="d-flex align-items-center justify-content-between mt-4 mx-auto flex-wrap gap-4"
                style="max-width: 560px">
                <div class="d-flex align-items-center gap-4">
                  <i class="fa fa-envelope text-dark fs-1"></i>
                  <div>
                    <div>Email :</div>
                    <H6>{{ setting?.email }}</H6>
                  </div>
                </div>
                <div class="d-flex align-items-center gap-4">
                  <i class="fa fa-phone text-dark fs-1"></i>
                  <div>
                    <div>Telepon :</div>
                    <H6>{{ setting?.telepon }}</H6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div v-if="formData.type == 'va'" :class="`card ${formData.is_expired ? 'opacity-25' : ''}`"
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
            <div v-else-if="formData.type == 'qris'" :class="`card ${formData.is_expired ? 'opacity-25' : ''}`"
              :style="`cursor: ${formData.is_expired ? 'not-allowed' : 'default'}`">
              <div class="card-header align-items-center min-h-50px">
                <h5 class="mb-0">QRIS</h5>
              </div>
              <div class="card-body p-4">
                <div class="d-flex bg-light rounded-2 p-4 gap-8 flex-column align-items-center">
                  <img :src="qris" class="img-fluid" style="width: 300px">
                  <button class="btn text-success p-0" :disabled="formData.is_expired" @click="downloadQris()">Unduh
                    QRIS</button>
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
      </template>
    </div>
    <div v-if="formData.status !== 'success'" class="card-footer d-flex justify-content-end gap-4">
      <template v-if="formData.status > 1 && formData.status == 'pending' && !formData.is_expired">
        <button class="btn btn-sm btn-light-danger" type="button"
          @click="cancelPembayaran(`/pembayaran/multi-payment/${this.selected}/cancel`, 'POST')">
          Batalkan
        </button>
        <button v-if="formData.type == 'va'" class="btn btn-sm btn-light-primary" type="button"
          @click="checkPembayaran()">
          <i class="la la-refresh"></i>
          Cek Status
        </button>
      </template>
      <template v-if="formData.status == 'pending' || formData.status == 'failed' || formData.is_expired">
        <button v-if="formData.type == 'va'" type="button" class="btn btn-sm btn-primary" @click="generate()">
          Buat VA Pembayaran
        </button>
        <button v-else-if="formData.type == 'qris'" type="button" class="btn btn-sm btn-primary"
          @click="generateQris()">
          Buat QRIS
        </button>
      </template>
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
// import QRCode from 'qrcode';
import { useSetting } from '@/services';


export default defineComponent({
  props: {
    selected: {
      type: String,
      default: null
    },
  },
  emits: ['close', 'refresh'],
  setup(props, ctx) {
    const formData = ref<any>({} as any)
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

    const qris = ref()

    const { data: setting = {} } = useSetting()

    return {
      formData,
      cancelPembayaran,
      currency,
      copyString,
      dateExp,
      dateExpInterval,
      moment,
      now,
      qris,
      setting
    }
  },
  methods: {
    getEdit() {
      block(this.$el)

      axios.get(`/pembayaran/multi-payment/${this.selected}`)
        .then(res => {
          this.formData = res.data.data

          if (this.formData) {
            this.dateExp = this.formData.tanggal_exp

            clearInterval(this.dateExpInterval)
            this.dateExpInterval = setInterval(() => {
              this.dateExp = moment(this.dateExp).subtract(1, 'seconds').format('YYYY-MM-DD HH:mm:ss')

              if (this.countdownExp == '00:00:00') {
                clearInterval(this.dateExpInterval)
              }
            }, 1000)

            if (this.formData.type == 'qris') {
              QRCode.toDataURL(this.formData.qris_value)
                .then(url => {
                  this.qris = url
                })
                .catch(err => {
                  console.error(err)
                })
            }
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

      axios.post(`/pembayaran/multi-payment/${this.selected}/va`)
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
    generateQris() {
      block(this.$el)

      axios.post(`/pembayaran/multi-payment/${this.selected}/qris`)
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
    checkPembayaran() {
      block(this.$el)

      axios.post(`/pembayaran/multi-payment/${this.selected}/check`)
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
    downloadQris() {
      var a = document.createElement("a");
      a.href = this.qris;
      a.download = "Pembayaran QRIS.png";
      a.click();
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
  },
  mounted() {
    if (this.selected) {
      this.getEdit()
    }
  },

})
</script>
