<template>
  <VForm class="card mb-10" @submit="submit">
      <div class="card-header align-items-center">
          <div class="d-flex align-items-center">
              <button type="button" class="btn btn-sm btn-light-danger btn-icon me-4" @click="$emit('close')">
                  <i class="la la-arrow-left fs-2"></i>
              </button>
              <h2 class="mb-0">{{ formData?.kode }}</h2>
          </div>
          <!-- <button v-if="formData.status >= 2" class="btn btn-sm btn btn-danger" type="button"
              @click="downloadReport(`/report/${formData.uuid}/tanda-terima`)">
              <i class="la la-file-pdf fs-2"></i>
              <span class="d-none d-md-inline">Cetak Tanda Terima</span>
          </button> -->
      </div>
      <div class="card-body p-4 p-md-8">
          <div class="row row-gap-8 row-gap-md-0">
              <div class="col-md-4">
                  <div class="card card-xl-stretch mb-md-8">
                      <!--begin::Header-->
                      <div class="card-header py-0 min-h-50px">
                          <h3 class="card-title align-items-start flex-column">
                              <span class="text-muted mt-1 fw-semibold fs-7">Informasi Pemohon</span>
                          </h3>
                      </div>
                      <!--end::Header-->

                      <!--begin::Body-->
                      <div class="card-body pt-5">
                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-user fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted">Customer</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.permohonan?.user?.nama }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->

                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-building fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted">Instansi</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.permohonan?.user?.detail?.instansi }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->

                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-map-marked fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted">Alamat</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.permohonan?.user?.detail?.alamat }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->

                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-phone fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted">No. Telepon/WhatsApp</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.permohonan?.user?.phone }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->
                      </div>
                      <!--end::Body-->
                  </div>
              </div>
              <div class="col-md-8">
                  <div class="card card-xl-stretch mb-md-8">
                      <!--begin::Header-->
                      <div class="card-header py-0 min-h-50px">
                          <h3 class="card-title align-items-start flex-column">
                              <span class="text-muted mt-1 fw-semibold fs-7">Detail Uji</span>
                          </h3>
                      </div>
                      <!--end::Header-->

                      <!--begin::Body-->
                      <div class="card-body pt-5">
                          <div class="row">
                              <div class="col-md-6">
                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-bullseye fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted">Lokasi/Titik Uji</span>
                                          <div class="text-dark text-hover-primary fs-6 fw-bold">
                                              {{ formData.lokasi }}
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->

                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-warehouse fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted">Nama Industri</span>
                                          <div class="text-dark text-hover-primary fs-6 fw-bold">
                                              {{ formData.permohonan?.industri }}
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->

                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-building fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted">Nama Industri</span>
                                          <div class="text-dark text-hover-primary fs-6 fw-bold">
                                              {{ formData.permohonan?.alamat }}
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->

                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-scroll fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted">Jenis Kegiatan Industri</span>
                                          <div class="text-dark text-hover-primary fs-6 fw-bold">
                                              {{ formData.permohonan?.kegiatan }}
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->
                              </div>
                              <div class="col-md-6">
                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-filter fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted">Jenis Sampel</span>
                                          <div class="text-dark text-hover-primary fs-6 fw-bold">
                                              {{ formData.jenis_sampel?.nama }}
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->
                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-prescription-bottle fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted">Jenis Wadah</span>
                                          <div class="text-dark text-hover-primary fs-6 fw-bold">
                                              {{ formData.jenis_wadahs?.map(a => `${a.nama}${a.keterangan ?
                                                  ` (${a.keterangan})` : ''}`).join(", ") }}
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->
                              </div>

                              <div class="separator my-8"></div>

                              <div class="col-md-6">
                                  <div class="fv-row mb-10">
                                      <label class="form-label fs-6">Kesimpulan Sampel</label>
                                      <div class="d-flex align-items-center gap-4">
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="0"
                                                  name="kesimpulan_sampel" id="status-menunggu"
                                                  v-model="formData.kesimpulan_sampel" @change="change()" />
                                              <label class="form-check-label" for="status-menunggu">
                                                  Menunggu
                                              </label>
                                          </div>
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="1"
                                                  name="kesimpulan_sampel" id="status-diterima"
                                                  v-model="formData.kesimpulan_sampel" @change="change()" />
                                              <label class="form-check-label" for="status-diterima">
                                                  Diterima
                                              </label>
                                          </div>
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="2"
                                                  name="kesimpulan_sampel" id="status-ditolak"
                                                  v-model="formData.kesimpulan_sampel" @change="change()" />
                                              <label class="form-check-label" for="status-ditolak">
                                                  Ditolak
                                              </label>
                                          </div>
                                      </div>
                                      <div class="fv-plugins-message-container">
                                          <div class="fv-help-block">
                                              <ErrorMessage name="kesimpulan_sampel" />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="fv-row mb-10">
                                      <label class="form-label fs-6">Tanggal Diterima</label>
                                      <Field v-model="formData.tanggal_diterima" name="tanggal_diterima">
                                          <date-picker v-model="formData.tanggal_diterima" @change="change()"
                                              name="tanggal_diterima" :config="{
                                                  enableTime: true,
                                                  dateFormat: 'Y-m-d H:i',
                                              }"></date-picker>
                                      </Field>
                                      <div class="fv-plugins-message-container">
                                          <div class="fv-help-block">
                                              <ErrorMessage name="tanggal_diterima" />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="fv-row mb-10">
                                      <label class="form-label fs-6">Pengawetan Dilakukan oleh</label>
                                      <div class="d-flex align-items-center gap-4">
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="Pelanggan"
                                                  name="pengawetan_oleh" id="pengawetan-pelanggan"
                                                  v-model="formData.pengawetan_oleh" @change="change()" />
                                              <label class="form-check-label" for="pengawetan-pelanggan">
                                                  Pelanggan
                                              </label>
                                          </div>
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="Laboratorium"
                                                  name="pengawetan_oleh" id="pengawetan-laboratorium"
                                                  v-model="formData.pengawetan_oleh" @change="change()" />
                                              <label class="form-check-label" for="pengawetan-laboratorium">
                                                  Laboratorium
                                              </label>
                                          </div>
                                      </div>
                                      <div class="fv-plugins-message-container">
                                          <div class="fv-help-block">
                                              <ErrorMessage name="pengawetan_oleh" />
                                          </div>
                                      </div>
                                  </div>
                                  <div class="fv-row mb-10">
                                      <label class="form-label fs-6">Interpretasi Hasil Pengujian</label>
                                      <div class="d-flex align-items-center gap-4">
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="1"
                                                  name="hasil_pengujian" id="interpretasi-1"
                                                  v-model="formData.hasil_pengujian" @change="change()" />
                                              <label class="form-check-label" for="interpretasi-1">
                                                  Ada
                                              </label>
                                          </div>
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="0"
                                                  name="hasil_pengujian" id="interpretasi-0"
                                                  v-model="formData.hasil_pengujian" @change="change()" />
                                              <label class="form-check-label" for="interpretasi-0">
                                                  Tidak Ada
                                              </label>
                                          </div>
                                          <!-- <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="2"
                                                  name="hasil_pengujian" id="interpretasi-2"
                                                  v-model="formData.hasil_pengujian" @change="change()" />
                                              <label class="form-check-label" for="interpretasi-2">
                                                  Memenuhi Persyaratan
                                              </label>
                                          </div>
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="3"
                                                  name="hasil_pengujian" id="interpretasi-3"
                                                  v-model="formData.hasil_pengujian" @change="change()" />
                                              <label class="form-check-label" for="interpretasi-3">
                                                  Tidak Memenuhi Persyaratan
                                              </label>
                                          </div> -->
                                      </div>
                                      <div class="fv-plugins-message-container">
                                          <div class="fv-help-block">
                                              <ErrorMessage name="hasil_pengujian" />
                                          </div>
                                      </div>
                                  </div>
                                  <div class="fv-row mb-10">
                                      <label class="form-label fs-6">Baku Mutu</label>
                                      <div class="d-flex align-items-center gap-4">
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="1"
                                                  name="baku_mutu" id="baku_mutu-1"
                                                  v-model="formData.baku_mutu" @change="change()" />
                                              <label class="form-check-label" for="baku_mutu-1">
                                                  Ada
                                              </label>
                                          </div>
                                          <div class="form-check form-check-custom form-check-solid">
                                              <input class="form-check-input" type="radio" value="0"
                                                  name="baku_mutu" id="baku_mutu-0"
                                                  v-model="formData.baku_mutu" @change="change()" />
                                              <label class="form-check-label" for="baku_mutu-0">
                                                  Tidak Ada
                                              </label>
                                          </div>
                                      </div>
                                      <div class="fv-plugins-message-container">
                                          <div class="fv-help-block">
                                              <ErrorMessage name="baku_mutu" />
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="fv-row mb-10">
                                      <label class="form-label fs-6">Kondisi Sampel saat Diterima</label>
                                      <div class="d-flex align-items-center gap-2">
                                          <span class="text-muted me-2">Abnormal</span>
                                          <vswitch class="form-check-custom form-check-solid" @change="change()"
                                              v-model="formData.kondisi_sampel">
                                          </vswitch>
                                          <span class="text-muted">Normal</span>
                                      </div>
                                      <div class="fv-plugins-message-container">
                                          <div class="fv-help-block">
                                              <ErrorMessage name="kondisi_sampel" />
                                          </div>
                                      </div>

                                      <div v-if="!formData.kondisi_sampel" class="fv-row">
                                          <Field class="form-control form-control-lg form-control-solid" type="text"
                                              @change="change()" name="keterangan_kondisi_sampel" autocomplete="off"
                                              placeholder="Jelaskan..." v-model="formData.keterangan_kondisi_sampel" />
                                          <div class="fv-plugins-message-container">
                                              <div class="fv-help-block">
                                                  <ErrorMessage name="keterangan_kondisi_sampel" />
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!--end::Body-->
                  </div>
              </div>

              <div class="col-12">
                  <div class="card card-xl-stretch mb-md-8">
                      <!--begin::Header-->
                      <div class="card-header py-0 min-h-50px">
                          <h3 class="card-title align-items-start flex-column">
                              <span class="text-muted mt-1 fw-semibold fs-7">Peraturan/Parameter</span>
                          </h3>
                      </div>
                      <!--end::Header-->

                      <!--begin::Body-->
                      <div class="card-body pt-5">
                          <div class="row">
                              <div class="col-lg-5 col-md-6">
                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-file-alt fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted">Peraturan</span>
                                          <div class="text-dark text-hover-primary fs-6 fw-bold">
                                              {{ formData.peraturan ? `${formData.peraturan?.nama} -
                                                                                              ${formData.peraturan?.nomor}` : '-' }}
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->
                              </div>
                              <div class="col-lg-7 col-md-6">
                                  <!--begin::Item-->
                                  <div class="mb-7">
                                      <div class="row">
                                          <div class="col-3 col-md-2">
                                              <!--begin::Symbol-->
                                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                                  <span class="symbol-label bg-light-success">
                                                      <i class="la la-vial fs-2x text-success"></i>
                                                  </span>
                                              </div>
                                              <!--end::Symbol-->
                                          </div>

                                          <div class="col-9 col-md-8 ms-n5">
                                              <!--begin::Text-->
                                              <div class="d-flex flex-column">
                                                  <span class="text-muted">Parameter</span>
                                              </div>
                                              <!--end::Text-->

                                              <div v-if="formData.parameters?.length" class="table-responsive">
                                                  <table class="table align-middle table-row-dashed fs-6 gy-3 no-footer">
                                                      <thead>
                                                          <tr
                                                              class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                              <th class="min-w-150px" tabindex="0">
                                                                  Nama
                                                              </th>
                                                              <th class="text-end pe-3 min-w-150px"
                                                                  v-if="formData.permohonan?.user?.golongan_id == 1">Harga
                                                              </th>
                                                          </tr>
                                                      </thead>
                                                      <tbody class="fw-bold text-gray-600">
                                                          <tr v-for="param in formData.parameters" :key="param.id">
                                                              <template v-if="param.is_dapat_diuji">
                                                                  <td>
                                                                      <span>{{ param.nama }} {{ param.keterangan ?
                                                                          `(${param.keterangan})` : '' }}</span>
                                                                      <button class="btn btn-icon btn-sm" type="button"
                                                                          data-bs-toggle="modal"
                                                                          :data-bs-target="`#modal-kajiulang-${param.pivot.parameter_id}`">
                                                                          <i class="la la-pencil"></i>
                                                                      </button>
                                                                  </td>
                                                                  <td class="text-end"
                                                                      v-if="formData.permohonan?.user?.golongan_id == 1">
                                                                      {{ currency(param.harga) }}</td>

                                                                  <div class="modal fade"
                                                                      :id="`modal-kajiulang-${param.pivot.parameter_id}`"
                                                                      tabindex="-1" aria-hidden="true">
                                                                      <div class="modal-dialog modal-dialog-centered">
                                                                          <div class="modal-content">
                                                                              <div class="modal-header">
                                                                                  <h1 class="modal-title fs-5">Hasil Kaji
                                                                                      Ulang Parameter: {{ param.nama }} {{
                                                                                          param.keterangan ?
                                                                                          `(${param.keterangan})` : '' }}
                                                                                  </h1>
                                                                                  <button type="button" class="btn-close"
                                                                                      data-bs-dismiss="modal"
                                                                                      aria-label="Close">
                                                                                  </button>
                                                                              </div>
                                                                              <div class="modal-body">
                                                                                  <div class="fv-row text-end">
                                                                                      <button type="button"
                                                                                          class="btn btn-light-primary btn-sm"
                                                                                          @click="checkKajiUlang(param)">Check
                                                                                          Semua</button>
                                                                                  </div>
                                                                                  <!--begin::Input group-->
                                                                                  <div class="fv-row mb-10">
                                                                                      <label
                                                                                          class="form-label fs-6">Personel
                                                                                          (Mampu)</label>
                                                                                      <vswitch
                                                                                          class="form-check-custom form-check-solid"
                                                                                          @change="change()"
                                                                                          v-model="param.pivot.personel">
                                                                                      </vswitch>
                                                                                      <div
                                                                                          class="fv-plugins-message-container">
                                                                                          <div class="fv-help-block">
                                                                                              <ErrorMessage
                                                                                                  name="personel" />
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                                  <!--end::Input group-->
                                                                                  <!--begin::Input group-->
                                                                                  <div class="fv-row mb-10">
                                                                                      <label
                                                                                          class="form-label fs-6">Metode
                                                                                          (Sesuai)</label>
                                                                                      <vswitch
                                                                                          class="form-check-custom form-check-solid"
                                                                                          @change="change()"
                                                                                          v-model="param.pivot.metode">
                                                                                      </vswitch>
                                                                                      <div
                                                                                          class="fv-plugins-message-container">
                                                                                          <div class="fv-help-block">
                                                                                              <ErrorMessage
                                                                                                  name="metode" />
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                                  <!--end::Input group-->
                                                                                  <!--begin::Input group-->
                                                                                  <div class="fv-row mb-10">
                                                                                      <label
                                                                                          class="form-label fs-6">Peralatan
                                                                                          (Lengkap)</label>
                                                                                      <vswitch
                                                                                          class="form-check-custom form-check-solid"
                                                                                          @change="change()"
                                                                                          v-model="param.pivot.peralatan">
                                                                                      </vswitch>
                                                                                      <div
                                                                                          class="fv-plugins-message-container">
                                                                                          <div class="fv-help-block">
                                                                                              <ErrorMessage
                                                                                                  name="peralatan" />
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                                  <!--end::Input group-->
                                                                                  <!--begin::Input group-->
                                                                                  <div class="fv-row mb-10">
                                                                                      <label
                                                                                          class="form-label fs-6">Reagen
                                                                                          (Lengkap)</label>
                                                                                      <vswitch
                                                                                          class="form-check-custom form-check-solid"
                                                                                          @change="change()"
                                                                                          v-model="param.pivot.reagen">
                                                                                      </vswitch>
                                                                                      <div
                                                                                          class="fv-plugins-message-container">
                                                                                          <div class="fv-help-block">
                                                                                              <ErrorMessage
                                                                                                  name="reagen" />
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                                  <!--end::Input group-->
                                                                                  <!--begin::Input group-->
                                                                                  <div class="fv-row mb-10">
                                                                                      <label
                                                                                          class="form-label fs-6">Akomodasi
                                                                                          (Baik)</label>
                                                                                      <vswitch
                                                                                          class="form-check-custom form-check-solid"
                                                                                          @change="change()"
                                                                                          v-model="param.pivot.akomodasi">
                                                                                      </vswitch>
                                                                                      <div
                                                                                          class="fv-plugins-message-container">
                                                                                          <div class="fv-help-block">
                                                                                              <ErrorMessage
                                                                                                  name="akomodasi" />
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                                  <!--end::Input group-->
                                                                                  <!--begin::Input group-->
                                                                                  <div class="fv-row mb-10">
                                                                                      <label class="form-label fs-6">Beban
                                                                                          Kerja
                                                                                          (Over)</label>
                                                                                      <vswitch
                                                                                          class="form-check-custom form-check-solid"
                                                                                          @change="change()"
                                                                                          v-model="param.pivot.beban_kerja">
                                                                                      </vswitch>
                                                                                      <div
                                                                                          class="fv-plugins-message-container">
                                                                                          <div class="fv-help-block">
                                                                                              <ErrorMessage
                                                                                                  name="beban_kerja" />
                                                                                          </div>
                                                                                      </div>
                                                                                  </div>
                                                                                  <!--end::Input group-->
                                                                              </div>
                                                                              <div class="modal-footer">
                                                                                  <button type="button"
                                                                                      class="btn btn-light"
                                                                                      data-bs-dismiss="modal">Tutup</button>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                              </template>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </div>
                                              <div v-else class="text-dark text-hover-primary fs-6 fw-bold">- </div>
                                          </div>
                                      </div>
                                  </div>
                                  <!--end::Item-->
                              </div>
                          </div>
                      </div>
                      <!--end::Body-->
                  </div>
              </div>

              <div class="col-12" v-if="formData.is_has_subkontrak">
                  <div class="card card-xl-stretch mb-md-8">
                      <!--begin::Header-->
                      <div class="card-header py-0 min-h-50px">
                          <h3 class="card-title align-items-start flex-column">
                              <span class="text-muted mt-1 fw-semibold fs-7">Detail Subkontrak</span>
                          </h3>
                      </div>
                      <!--end::Header-->

                      <!--begin::Body-->
                      <div class="card-body pt-5">
                          <div class="row">
                              <div class="col-lg-5 col-md-6">
                                  <!--begin::Item-->
                                  <div class="d-flex align-items-center mb-7">
                                      <!--begin::Symbol-->
                                      <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                          <span class="symbol-label bg-light-success">
                                              <i class="la la-archway fs-2x text-success"></i>
                                          </span>
                                      </div>
                                      <!--end::Symbol-->

                                      <!--begin::Text-->
                                      <div class="d-flex flex-column">
                                          <span class="text-muted mb-2 required">Nama Laboratorium Subkontrak</span>
                                          <div class="fv-row">
                                              <Field class="form-control form-control-lg form-control-solid" type="text"
                                                  @change="change()" name="lab_subkontrak" autocomplete="off"
                                                  v-model="formData.lab_subkontrak" />
                                              <div class="fv-plugins-message-container">
                                                  <div class="fv-help-block">
                                                      <ErrorMessage name="lab_subkontrak" />
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <!--end::Text-->
                                  </div>
                                  <!--end::Item-->
                              </div>
                              <div class="col-lg-7 col-md-6">
                                  <!--begin::Item-->
                                  <div class="mb-7">
                                      <div class="row">
                                          <div class="col-3 col-md-2">
                                              <!--begin::Symbol-->
                                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                                  <span class="symbol-label bg-light-success">
                                                      <i class="la la-vial fs-2x text-success"></i>
                                                  </span>
                                              </div>
                                              <!--end::Symbol-->
                                          </div>

                                          <div class="col-9 col-md-8 ms-n5">
                                              <!--begin::Text-->
                                              <div class="d-flex flex-column">
                                                  <span class="text-muted">Parameter</span>
                                              </div>
                                              <!--end::Text-->

                                              <div v-if="formData.parameters?.length" class="table-responsive">
                                                  <table class="table align-middle table-row-dashed fs-6 gy-3 no-footer">
                                                      <thead>
                                                          <tr
                                                              class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                              <th class="min-w-150px" tabindex="0">
                                                                  Nama
                                                              </th>
                                                          </tr>
                                                      </thead>
                                                      <tbody class="fw-bold text-gray-600">
                                                          <tr v-for="param in formData.parameters" :key="param.id">
                                                              <template v-if="!param.is_dapat_diuji">
                                                                  <td>
                                                                      <span>{{ param.nama }} {{ param.keterangan ?
                                                                          `(${param.keterangan})` : '' }}</span>
                                                                  </td>
                                                              </template>
                                                          </tr>
                                                      </tbody>
                                                  </table>
                                              </div>
                                              <div v-else class="text-dark text-hover-primary fs-6 fw-bold">- </div>
                                          </div>
                                      </div>
                                  </div>
                                  <!--end::Item-->
                              </div>
                          </div>
                      </div>
                      <!--end::Body-->
                  </div>
              </div>

              <div class="col-lg-6">
                  <div class="card card-xl-stretch mb-md-8">
                      <!--begin::Header-->
                      <div class="card-header py-0 min-h-50px">
                          <h3 class="card-title align-items-start flex-column">
                              <span class="text-muted mt-1 fw-semibold fs-7">Detail {{ formData.permohonan?.is_mandiri ?
                                  'Pengiriman' : 'Pengambilan' }}</span>
                          </h3>
                      </div>
                      <!--end::Header-->

                      <!--begin::Body-->
                      <div class="card-body pt-5">
                          <!--begin::Item-->
                          <div v-if="!formData.permohonan?.is_mandiri" class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-truck-loading fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted">Jasa Pengambilan</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.permohonan?.jasa_pengambilan?.wilayah }}
                                      <span v-if="formData.permohonan?.user?.golongan_id == 1">
                                          ({{ currency(formData.permohonan?.jasa_pengambilan?.harga) }})
                                      </span>
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->

                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-id-card-alt fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted mb-2">{{ formData.permohonan?.is_mandiri ? 'Pengirim' :
                                      'Petugas Pengambil' }}</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.pengambil?.nama ?? formData.nama_pengambil }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->

                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-calendar fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted mb-2">Tanggal/Jam</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.tanggal_pengambilan }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->

                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-tags fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted mb-2">Metode</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.acuan_metode?.nama }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->
                      </div>
                      <!--end::Body-->
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="card card-xl-stretch mb-md-8">
                      <!--begin::Header-->
                      <div class="card-header py-0 min-h-50px">
                          <h3 class="card-title align-items-start flex-column">
                              <span class="text-muted mt-1 fw-semibold fs-7">Detail Lokasi</span>
                          </h3>
                      </div>
                      <!--end::Header-->

                      <!--begin::Body-->
                      <div class="card-body pt-5">
                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-compass fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted mb-2">South</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.south }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->
                          <!--begin::Item-->
                          <div class="d-flex align-items-center mb-7">
                              <!--begin::Symbol-->
                              <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                  <span class="symbol-label bg-light-success">
                                      <i class="la la-compass fs-2x text-success"></i>
                                  </span>
                              </div>
                              <!--end::Symbol-->

                              <!--begin::Text-->
                              <div class="d-flex flex-column">
                                  <span class="text-muted mb-2">East</span>
                                  <div class="text-dark text-hover-primary fs-6 fw-bold">
                                      {{ formData.east }}
                                  </div>
                              </div>
                              <!--end::Text-->
                          </div>
                          <!--end::Item-->
                      </div>
                      <!--end::Body-->
                  </div>
              </div>
          </div>
      </div>
      <div class="card-footer d-flex">
          <button v-if="formData?.status == 1" type="submit" class="btn btn-sm btn-primary ms-auto" @click="status = 2">
              Konfirmasi
              <i class="la la-check fs-2 ms-2"></i>
          </button>
          <button v-if="formData?.status > 1" type="submit" class="btn btn-sm btn-light-danger ms-auto"
              @click="status = 1">
              Batalkan Konfirmasi
              <i class="la la-times fs-2 ms-2"></i>
          </button>
      </div>
  </VForm>
</template>

<script lang="ts">
import { block, unblock, currency } from '@/libs/utils';
import { computed, defineComponent, ref } from 'vue'
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useAuthStore } from '@/stores/auth';
import { useDownloadPdf } from '@/libs/hooks';

interface FormData {
  uuid: string;
  kode: string;
  lokasi: string;
  jenis_sampel: {
      nama: string;
  },
  jenis_wadah: {
      nama: string;
  },
  jenis_wadahs: [
      {
          nama: string;
          keterangan: string;
      }
  ],
  pengambil_id: number;
  pengambil: {
      nama: string;
  },
  nama_pengambil: string;
  tanggal_pengambilan: string;
  tanggal_diterima: string;
  acuan_metode_id: number;
  acuan_metode: {
      nama: string;
  },
  south: string;
  east: string;
  keterangan: string;
  status: number;
  peraturan: {
      nama: string;
      nomor: string;
  },
  is_has_subkontrak: boolean | number;
  lab_subkontrak: string;
  baku_mutu: boolean | number;
  hasil_pengujian: boolean | number;
  kesimpulan_permohonan: boolean | number;
  kesimpulan_sampel: boolean | number;
  kondisi_sampel: boolean | number;
  keterangan_kondisi_sampel: boolean | number;
  pengawetan_oleh: string;
  parameters: [
      {
          id: number;
          nama: string;
          harga: number;
          is_dapat_diuji: boolean | number;
          pivot: {
              harga: number;
              jumlah: number;
              parameter_id: number;
              personel: boolean | number,
              metode: boolean | number,
              peralatan: boolean | number,
              reagen: boolean | number,
              akomodasi: boolean | number,
              beban_kerja: boolean | number,
          }
      }
  ],
  permohonan: {
      industri: string;
      keterangan: string;
      kegiatan: string;
      alamat: string;
      pembayaran: string;
      is_mandiri: boolean | number;
      jasa_pengambilan_id?: number;
      jasa_pengambilan?: {
          wilayah: string;
          harga: number;
      },
      user: {
          nama: string;
          phone: string;
          detail: {
              instansi: string;
              alamat: string;
          }
      }
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
  setup() {
      const status = ref(0)
      const { user } = useAuthStore();
      const formData = ref<FormData>({} as FormData)

      const { download: downloadReport } = useDownloadPdf();

      return {
          user,
          formData,
          currency,
          status,
          downloadReport
      }
  },
  methods: {
      getEdit() {
          block(this.$el)

          axios.get(`/administrasi/penerima-sample/${this.selected}`)
              .then(res => {
                  this.formData = res.data.data
                  this.status = res.data.data.status

                  if (!this.formData.tanggal_diterima) {
                      this.formData.tanggal_diterima = this.formData.tanggal_pengambilan
                  }
              })
              .catch(err => {
                  toast.error(err.response.data.message)
              })
              .finally(() => {
                  unblock(this.$el)
              })
      },
      change() {
          block(this.$el)

          axios.post(`/administrasi/penerima-sample/${this.selected}/update`, { ...this.formData })
              .catch(err => {
                  toast.error(err.response.data.message)
              })
              .finally(() => {
                  unblock(this.$el)
              })
      },
      submit() {
          block(this.$el)

          axios.post(`/administrasi/penerima-sample/${this.selected}/update-status`, { status: this.status })
              .then(res => {
                  this.$emit('close')
                  this.$emit('refresh')
                  toast.success('Data berhasil disimpan')
              })
              .catch(err => {
                  toast.error(err.response.data.message)
              })
              .finally(() => {
                  unblock(this.$el)
              })
      },
      checkKajiUlang(param) {
          param.pivot.personel = true
          param.pivot.metode = true
          param.pivot.peralatan = true
          param.pivot.reagen = true
          param.pivot.akomodasi = true
          param.pivot.beban_kerja = true
          this.change()
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
