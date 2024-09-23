<template>
  <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema">
    <div class="card-header align-items-center">
      <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Titik Pengujian <div
          v-if="formData?.uuid && formData?.status > 2" class="text-muted fw-normal fs-8"><em>Tidak bisa
            melakukan pengeditan karena status sudah dalam {{ mapStatusPengujian(formData.status) }}</em></div>
      </h2>
      <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
        Batal
        <i class="la la-times-circle p-0"></i>
      </button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Metode Pembayaran</label>
            <div class="row">
              <div class="col-md-6">
                <Field class="form-control form-control-lg form-control-solid" type="radio" name="payment_type"
                  autocomplete="off" v-model="formData.payment_type">
                  <input type="radio" class="btn-check" name="payment_type" value="va" id="va"
                    v-model="formData.payment_type" />
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
                <Field class="form-control form-control-lg form-control-solid" type="radio" name="payment_type"
                  autocomplete="off" v-model="formData.payment_type">
                  <!--begin::Option-->
                  <input type="radio" class="btn-check" name="payment_type" value="qris" id="qris"
                    v-model="formData.payment_type" />
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
                <ErrorMessage name="payment_type" />
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Nama Lokasi/Titik Uji</label>
            <Field class="form-control form-control-lg form-control-solid" type="text" name="lokasi" autocomplete="off"
              v-model="formData.lokasi" />
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="lokasi" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>

        <div class="col-md-4">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Jenis Sampel</label>
            <Field v-model="formData.jenis_sampel_id" name="jenis_sampel_id">
              <select2 placeholder="Pilih Jenis Sampel" class="form-select-solid" name="jenis_sampel_id"
                :options="jenisSampels" v-model="formData.jenis_sampel_id">
              </select2>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="jenis_sampel_id" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>

        <div class="col-md-4">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Jenis Wadah</label>
            <Field v-model="formData.jenis_wadahs_id" name="jenis_wadahs_id">
              <select2 placeholder="Pilih Jenis Wadah" class="form-select-solid" name="jenis_wadahs_id" multiple
                :settings="{ allowClear: true, multiple: true }" :options="jenisWadahs"
                v-model="formData.jenis_wadahs_id">
              </select2>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="jenis_wadahs_id" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>

        <div class="col-md-12">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6">Keterangan</label>
            <Field name="keterangan" autocomplete="off" v-model="formData.keterangan">
              <textarea class="form-control form-control-lg form-control-solid" name="keterangan" rows="3"
                v-model="formData.keterangan"></textarea>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="keterangan" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>

        <template v-if="$props.permohonan.is_mandiri">
          <div class="separator separator-content my-10" style="white-space: nowrap;">Detail
            Pengiriman</div>

          <div class="col-md-4">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6 required">Nama Pengirim</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="nama_pengambil"
                autocomplete="off" v-model="formData.nama_pengambil" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="nama_pengambil" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>
          <div class="col-md-4">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6 required">Tanggal/Jam Pengiriman</label>
              <Field v-model="formData.tanggal_pengambilan" name="tanggal_pengambilan">
                <date-picker v-model="formData.tanggal_pengambilan" name="tanggal_pengambilan" :config="{
    enableTime: true,
    dateFormat: 'Y-m-d H:i',
  }"></date-picker>
              </Field>
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="tanggal_pengambilan" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>
          <div class="col-md-4">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6 required">Metode</label>
              <Field v-model="formData.acuan_metode_id" name="acuan_metode_id">
                <select2 placeholder="Pilih Metode" class="form-select-solid" name="acuan_metode_id"
                  :options="acuanMetodes" v-model="formData.acuan_metode_id">
                </select2>
              </Field>
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="acuan_metode_id" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="separator separator-content my-10" style="white-space: nowrap;">Detail Lokasi</div>

          <div class="col-md-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6 required">South</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="south" autocomplete="off"
                v-model="formData.south" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="south" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>
          <div class="col-md-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6 required">East</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="east" autocomplete="off"
                v-model="formData.east" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="east" />
                </div>
              </div>

              <div class="d-flex">
                <button type="button" class="btn btn-sm btn-light-primary mt-4 ms-auto" @click="getLatLong()">Lokasi
                  Saat Ini</button>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="separator separator-content my-10" style="white-space: nowrap;">Hasil Pengukuran Lapangan
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Suhu Air (t&deg;C)</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="suhu_air"
                autocomplete="off" v-model="formData.lapangan.suhu_air" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="suhu_air" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">pH</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="ph" autocomplete="off"
                v-model="formData.lapangan.ph" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="ph" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">DHL (µS/cm)</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="dhl" autocomplete="off"
                v-model="formData.lapangan.dhl" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="dhl" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Salinitas (‰)</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="salinitas"
                autocomplete="off" v-model="formData.lapangan.salinitas" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="salinitas" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">DO (mg/L)</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="do" autocomplete="off"
                v-model="formData.lapangan.do" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="do" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Kekeruhan</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="kekeruhan"
                autocomplete="off" v-model="formData.lapangan.kekeruhan" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="kekeruhan" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Klorin Bebas</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="klorin_bebas"
                autocomplete="off" v-model="formData.lapangan.klorin_bebas" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="klorin_bebas" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="separator separator-content my-10" style="white-space: nowrap;">Kondisi Lingkungan
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Suhu Udara (t&deg;C)</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="suhu_udara"
                autocomplete="off" v-model="formData.lapangan.suhu_udara" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="suhu_udara" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Cuaca</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="cuaca" autocomplete="off"
                v-model="formData.lapangan.cuaca" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="cuaca" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Arah Angin</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="arah_angin"
                autocomplete="off" v-model="formData.lapangan.arah_angin" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="arah_angin" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Kelembapan (%RH)</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="kelembapan"
                autocomplete="off" v-model="formData.lapangan.kelembapan" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="kelembapan" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

          <div class="col-xl-2 col-lg-3 col-md-4 col-6">
            <!--begin::Input group-->
            <div class="fv-row mb-7">
              <label class="form-label fw-bold text-dark fs-6">Kecepatan Angin</label>
              <Field class="form-control form-control-lg form-control-solid" type="text" name="kecepatan_angin"
                autocomplete="off" v-model="formData.lapangan.kecepatan_angin" />
              <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                  <ErrorMessage name="kecepatan_angin" />
                </div>
              </div>
            </div>
            <!--end::Input group-->
          </div>

        </template>
      </div>
    </div>
    <div class="card-footer d-flex">
      <button v-if="formData.kesimpulan_permohonan == 2 || formData.kesimpulan_sampel == 2" type="submit"
        @click="ajukanUlang" class="btn btn-warning btn-sm ms-auto">
        <i class="la la-refresh fs-4"></i>
        Ajukan Ulang
      </button>
      <button v-if="formData.status <= 2 || !formData.uuid" type="submit" class="btn btn-primary btn-sm ms-5">
        <i class="la la-save fs-4"></i>
        Simpan
      </button>
    </div>
  </VForm>
</template>

<script lang="ts">
import { block, convertToDMS, mapStatusPengujian, unblock } from '@/libs/utils';
import { computed, defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useAcuanMetode, useJenisSampel, useJenisWadah } from '@/services';

interface FormData {
  uuid: string;
  lokasi: string;
  jenis_sampel_id: number;
  jenis_wadah_id: number;
  jenis_wadahs_id: number[];
  nama_pengambil: string;
  tanggal_pengambilan: string;
  acuan_metode_id: number;
  south: string;
  east: string;
  permohonan_uuid: string;
  keterangan: string;
  status: number;
  kesimpulan_permohonan: number;
  kesimpulan_sampel: number;
  payment_type: string;
  lapangan: {
    suhu_air: string,
    ph: string,
    dhl: string,
    do: string,
    salinitas: string,
    kekeruhan: string,
    klorin_bebas: string,

    suhu_udara: string,
    arah_angin: string,
    kelembapan: string,
    kecepatan_angin: string,
    cuaca: string
  }
}

export default defineComponent({
  props: {
    selected: {
      type: String,
      default: null
    },
    permohonan: {
      type: Object,
      required: true
    }
  },
  emits: ['close', 'refresh', 'next-parameter'],
  setup(props) {
    const formData = ref<FormData>({
      permohonan_uuid: props.permohonan.uuid,
      lapangan: {}
    } as FormData)

    const formSchema = Yup.object().shape({
      payment_type: Yup.string().required('Metode Pembayaran harus diisi'),
      lokasi: Yup.string().required('Lokasi harus diisi'),
      jenis_sampel_id: Yup.number().required('Jenis sampel harus diisi'),
      // jenis_wadah_id: Yup.number().required('Jenis wadah harus diisi'),
      jenis_wadahs_id: Yup.array().min(1, 'Jenis wadah harus diisi'),
      ...(props.permohonan.is_mandiri && {
        nama_pengambil: Yup.string().required('Nama petugas harus diisi'),
        tanggal_pengambilan: Yup.string().required('Tanggal/jam pengiriman harus diisi'),
        south: Yup.string().required('South harus diisi'),
        east: Yup.string().required('East harus diisi'),
        acuan_metode_id: Yup.number().required('Acuan metode harus diisi'),
      })
    })

    const jenisSampel = useJenisSampel()
    const jenisSampels = computed(() => jenisSampel.data.value?.map(item => ({
      id: item.id,
      text: item.nama
    })))

    const jenisWadah = useJenisWadah()
    const jenisWadahs = computed(() => jenisWadah.data.value?.map(item => ({
      id: item.id,
      text: `${item.nama} ${item.keterangan ? `(${item.keterangan})` : ''}`
    })))

    const acuanMetode = useAcuanMetode()
    const acuanMetodes = computed(() => acuanMetode.data.value?.map(item => ({
      id: item.id,
      text: item.nama
    })))

    return {
      formData,
      formSchema,
      jenisSampels,
      jenisWadahs,
      acuanMetodes,
      mapStatusPengujian
    }
  },
  methods: {
    ajukanUlang() {
      this.formData.ajukan_ulang = true
    },
    getEdit() {
      block(this.$el)

      axios.get(`/permohonan/titik/${this.selected}/edit`)
        .then(res => {
          this.formData = res.data.data
          this.formData.permohonan_uuid = this.permohonan.uuid
          this.formData.lapangan = res.data.data.lapangan || {}
        })
        .catch(err => {
          toast.error(err.response.data.message)
        })
        .finally(() => {
          unblock(this.$el)
        })
    },
    submit() {
      const vm = this
      if (this.formData.status > 2 && (this.formData.kesimpulan_permohonan != 2 && this.formData.kesimpulan_sampel != 2)) return
      block(this.$el)

      axios.post(this.selected ? `/permohonan/titik/${this.selected}/update` : '/permohonan/titik/store', this.formData)
        .then((res) => {
          this.$emit('close')
          this.$emit('refresh')
          toast.success('Data berhasil disimpan')

          if (!this.formData.ajukan_ulang) {
            vm.$emit('next-parameter', res.data.data.uuid)
          }
        })
        .catch(err => {
          toast.error(err.response.data.message)
        })
        .finally(() => {
          unblock(this.$el)
        })
    },
    getLatLong() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.formData.south = convertToDMS(position.coords.latitude)
        this.formData.east = convertToDMS(position.coords.longitude)
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
