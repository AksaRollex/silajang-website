<template>
  <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema" id="form">
    <div class="card-header align-items-center">
      <h2 class="mb-0">{{ selected ? 'Edit' : 'Tambah' }} Permohonan</h2>
      <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')">
        Batal
        <i class="la la-times-circle p-0"></i>
      </button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Nama Industri</label>
            <Field class="form-control form-control-lg form-control-solid" type="text" name="industri"
              autocomplete="off" v-model="formData.industri" />
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="industri" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>
        <div class="col-md-6">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Kegiatan Industri</label>
            <Field class="form-control form-control-lg form-control-solid" type="text" name="kegiatan"
              autocomplete="off" v-model="formData.kegiatan" />
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="kegiatan" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>
        <div class="col-md-12">
          <!--begin::Input group-->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Alamat Industri</label>
            <Field name="alamat" autocomplete="off" v-model="formData.alamat">
              <textarea class="form-control form-control-lg form-control-solid" name="alamat" rows="3"
                v-model="formData.alamat"></textarea>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="alamat" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>
      </div>

      <div v-if="!$props.selected" class="row">
        <div class="col-md-6">
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Cara Pengambilan</label>
            <Field class="form-control form-control-lg form-control-solid" type="radio" name="is_mandiri"
              autocomplete="off" v-model="formData.is_mandiri">
              <!--begin::Option-->
              <input type="radio" class="btn-check" name="is_mandiri" value="1" id="kirim_mandiri"
                v-model="formData.is_mandiri" />
              <label
                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                for="kirim_mandiri">
                <i class="ki-duotone ki-delivery-3  fs-1 me-4">
                  <i class="path1"></i>
                  <i class="path2"></i>
                  <i class="path3"></i>
                </i>

                <span class="d-block fw-semibold text-start">
                  <span class="text-dark fw-bold d-block fs-3">Kirim Mandiri</span>
                  <span class="text-muted fw-semibold fs-6">
                    Kirim Sample Uji Anda Ke Laboratorium Dinas.
                  </span>
                </span>
              </label>
              <!--end::Option-->
            </Field>
            <Field class="form-control form-control-lg form-control-solid" type="radio" name="is_mandiri"
              autocomplete="off" v-model="formData.is_mandiri">
              <!--begin::Option-->
              <input type="radio" class="btn-check" name="is_mandiri" value="0" id="ambil_petugas"
                v-model="formData.is_mandiri" />
              <label
                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                for="ambil_petugas">
                <i class="ki-duotone ki-truck fs-1 me-4">
                  <i class="path1"></i>
                  <i class="path2"></i>
                  <i class="path3"></i>
                  <i class="path4"></i>
                  <i class="path5"></i>
                </i>

                <span class="d-block fw-semibold text-start">
                  <span class="text-dark fw-bold d-block fs-3">Ambil Petugas</span>
                  <span class="text-muted fw-semibold fs-6">
                    Petugas Akan Menghubungi Anda Untuk Konfirmasi Lokasi Pengambilan.
                  </span>
                </span>
              </label>
              <!--end::Option-->
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="is_mandiri" />
              </div>
            </div>
          </div>

          <!--begin::Input group-->
          <div v-if="formData.is_mandiri == 0" class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Wilayah Pengambilan</label>
            <Field v-model="formData.jasa_pengambilan_id" name="jasa_pengambilan_id">
              <select2 placeholder="Pilih Wilayah Pengambilan" class="form-select-solid" name="jasa_pengambilan_id"
                :options="jasaPengambilans" v-model="formData.jasa_pengambilan_id">
              </select2>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="jasa_pengambilan_id" />
              </div>
            </div>
          </div>
          <!--end::Input group-->
        </div>
        <div class="col-md-6">
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Opsi Pembayaran</label>
            <!-- <Field class="form-control form-control-lg form-control-solid" type="radio" name="pembayaran"
                          autocomplete="off" v-model="formData.pembayaran">
                          <input type="radio" class="btn-check" name="pembayaran" value="tunai" id="cash"
                              v-model="formData.pembayaran" />
                          <label
                              class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                              for="cash">
                              <i class="ki-duotone ki-dollar fs-1 me-4">
                                  <i class="path1"></i>
                                  <i class="path2"></i>
                                  <i class="path3"></i>
                              </i>

                              <span class="d-block fw-semibold text-start">
                                  <span class="text-dark fw-bold d-block fs-3">Cash <span
                                          class="fw-normal fs-6">(Tunai)</span></span>
                                  <span class="text-muted fw-semibold fs-6">
                                      Bayar Dimuka atau Ketika Sertifikat Sudah Jadi
                                  </span>
                              </span>
                          </label>
                      </Field> -->
            <Field class="form-control form-control-lg form-control-solid" type="radio" name="pembayaran"
              autocomplete="off" v-model="formData.pembayaran">
              <!--begin::Option-->
              <input type="radio" class="btn-check" name="pembayaran" value="transfer" id="transfer"
                v-model="formData.pembayaran" />
              <label
                class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5"
                for="transfer">
                <i class="ki-duotone ki-two-credit-cart fs-1 me-4">
                  <i class="path1"></i>
                  <i class="path2"></i>
                  <i class="path3"></i>
                  <i class="path4"></i>
                  <i class="path5"></i>
                </i>

                <span class="d-block fw-semibold text-start">
                  <span class="text-dark fw-bold d-block fs-3">
                    Transfer <span class="fw-normal fs-6">(non Tunai)</span></span>
                  <span class="text-muted fw-semibold fs-6">
                    Transfer Virtual Account Bank Jatim, Untuk Nomor VA Akan di Infomasikan oleh
                    Bendahara UPT. Atau Pembayaran bisa dilakukan menggunakan QRIS.
                  </span>
                </span>
              </label>
              <!--end::Option-->
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="pembayaran" />
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- <div class="border border-bottom border-gray mt-8 mb-12"></div> -->

      <div v-if="false" class="separator separator-content my-10 fw-bold text-dark fs-3" style="white-space: nowrap;">
        Detail Kontrak</div>

      <div v-if="false" class="row">
        <div class="col-md-6">
          <!-- begin::Input group -->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Nomor Surat</label>
            <Field class="form-control form-control-lg form-control-solid" type="text" name="nomor_surat"
              autocomplete="off" v-model="formData.kontrak.nomor_surat" />
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="nomor_surat" />
              </div>
            </div>
          </div>
          <!-- end::Input group -->
          <!-- begin::Input group -->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Tanggal Surat</label>
            <Field type="hidden" name="tanggal_surat" autocomplete="off" v-model="formData.kontrak.tanggal_surat">
              <date-picker v-model="formData.kontrak.tanggal_surat" name="tanggal_surat"
                placeholder="Pilih Tanggal"></date-picker>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="tanggal_surat" />
              </div>
            </div>
          </div>
          <!-- end::Input group -->
          <!-- begin::Input group -->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Bulan</label>
            <Field v-model="formData.kontrak.bulan" name="bulan[]">
              <select2 placeholder="Pilih Bulan" class="form-select-solid" name="bulan[]" multiple
                :settings="{ allowClear: true, multiple: true }" :options="bulanBerjalan"
                v-model="formData.kontrak.bulan">
              </select2>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="bulan" />
              </div>
            </div>
          </div>
          <!-- end::Input group -->
          <!-- begin::Input group -->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Perihal</label>
            <Field name="perihal" autocomplete="off" v-model="formData.kontrak.perihal">
              <textarea class="form-control form-control-lg form-control-solid" name="perihal" rows="4"
                v-model="formData.kontrak.perihal"></textarea>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="perihal" />
              </div>
            </div>
          </div>
          <!-- end::Input group -->
        </div>
        <div class="col-md-6">
          <!-- begin::Input group -->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 required">Dokumen Permohonan</label>
            <file-upload v-bind:files="dokumen_permohonan" :accepted-file-types="fileTypes"
              v-on:updatefiles="onUpdateFiles"></file-upload>
          </div>
          <!-- end::Input group -->
        </div>
      </div>

      <!-- <div class="row">
              <div class="col-md-6"> -->
      <!--begin::Input group-->
      <!-- <div class="fv-row mb-7">
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
                  </div> -->
      <!--end::Input group-->
      <!-- </div>
          </div> -->
    </div>
    <div class="card-footer d-flex">
      <button type="submit" class="btn btn-primary btn-sm ms-auto">
        Simpan
      </button>
    </div>
  </VForm>
</template>

<script lang="ts">
import { block, currency, unblock } from '@/libs/utils';
import { computed, defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useJasaPengambilan } from '@/services';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

interface FormData {
  industri: string;
  keterangan: string;
  kegiatan: string;
  alamat: string;
  pembayaran: string;
  is_mandiri: boolean | number;
  jasa_pengambilan_id?: number;

  kontrak: {
    nomor_surat: string,
    dokumen_permohonan: string,
    perihal: string,
    tanggal_surat: string,
    bulan: Array<string | number>,
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
  setup(props) {
    const { user } = useAuthStore()
    const formData = ref<FormData>({
      pembayaran: 'transfer',
      kontrak: {}
    } as FormData)

    const router = useRouter()
    const dokumen_permohonan = ref<Array<File | String>>([])
    const fileTypes = (['application/pdf'])
    const onUpdateFiles = (newFiles: Array<File | String>) => {
      dokumen_permohonan.value = newFiles
    }
    const bulan = ref(new Date().getMonth() + 1);
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
    const bulanBerjalan = ref<any[]>([])
    for (let i = bulan.value; i <= 12; i++) {
      bulanBerjalan.value.push({ id: i, text: bulans.value[i - 1].text });
    }

    const formSchema = Yup.object().shape({
      industri: Yup.string().required('Nama Industri harus diisi'),
      kegiatan: Yup.string().required('Kegiatan Industri harus diisi'),
      alamat: Yup.string().required('Alamat Industri harus diisi'),
      ...(!props.selected && {
        pembayaran: Yup.string().required('Harap pilih Opsi Pembayaran'),
        is_mandiri: Yup.string().required('Harap pilih Cara Pengambilan'),
        jasa_pengambilan_id: Yup.string().when('is_mandiri', function (is_mandiri: any) {
          return is_mandiri == 0 ? Yup.string().required('Wilayah Pengambilan harus diisi') : Yup.string()
        }),
        // nomor_surat: Yup.string().when('is_mandiri', function (is_mandiri: any) {
        //   return is_mandiri == 0 ? Yup.string().required('Nomor Surat harus diisi') : Yup.string()
        // }),
        // perihal: Yup.string().when('is_mandiri', function (is_mandiri: any) {
        //   return is_mandiri == 0 ? Yup.string().required('Perihal harus diisi') : Yup.string()
        // }),
      }),
    })

    const jasaPengambilan = useJasaPengambilan()
    const jasaPengambilans = computed(() => jasaPengambilan.data.value?.map(item => ({
      id: item.id,
      text: `${item.wilayah} - ${currency(item.harga)}`
    })))

    return {
      user,
      formData,
      formSchema,
      jasaPengambilans,
      router,
      dokumen_permohonan,
      fileTypes,
      onUpdateFiles,
      bulan,
      bulans,
      bulanBerjalan,
    }
  },
  methods: {
    getEdit() {
      block(this.$el)

      axios.get(`/permohonan/${this.selected}/edit`)
        .then(res => {
          this.formData = res.data.data
          // this.dokumen_permohonan = res.data.data.kontrak.dokumen_permohonan
          //   ? ["/storage/" + res.data.data.kontrak.dokumen_permohonan]
          //   : [];
        })
        .catch(err => {
          toast.error(err.response.data.message)
        })
        .finally(() => {
          unblock(this.$el)
        })
    },
    submit() {
      // if (!this.dokumen_permohonan[0] && this.formData.is_mandiri == 0) {
      //   toast.error('File tidak boleh kosong')
      // }

      block(this.$el)

      const formData = new FormData(document.querySelector('#form'))
      // if (this.formData.is_mandiri == 0) {
      //   formData.append('dokumen_permohonan', this.dokumen_permohonan[0].file as File)
      // }
      axios.post(this.selected ? `/permohonan/${this.selected}/update` : '/permohonan/store', formData)
        .then((res) => {
          if (this.$props.selected) {
            this.$emit('close')
            this.$emit('refresh')
            toast.success('Data berhasil disimpan')
          } else {
            // this.router.push(`/dashboard/pengujian/permohonan/${res.data.data.uuid}`)
            this.$emit('close')
            this.$emit('refresh')
            toast.success('Data berhasil disimpan')
            // if (this.formData.is_mandiri == 0) {
            //   toast.success('Silahkan menunggu konfirmasi dari admin')
            // } else {
            //   toast.success('Data berhasil disimpan')
            // }
          }
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
    this.formData.industri = this.user.detail?.instansi ?? ''
    this.formData.kegiatan = this.user.detail?.jenis_kegiatan ?? ''
    this.formData.alamat = this.user.detail?.alamat ?? ''

    if (this.selected) {
      this.getEdit()
    }
  },
  watch: {
    selected() {
      if (this.selected) {
        this.getEdit()
      }
    },
    'formData.is_mandiri': function (val: any) {
      if (val == 1) {
        this.formData.jasa_pengambilan_id = undefined
      }
    }
  }
})
</script>
