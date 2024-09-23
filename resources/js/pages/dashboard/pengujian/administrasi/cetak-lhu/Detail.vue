<template>
  <div class="card mb-10" :validation-schema="formSchema">
    <div class="card-header align-items-center">
      <div class="d-flex align-items-center">
        <button type="button" class="btn btn-sm btn-light-danger btn-icon me-4" @click="$emit('close')">
          <i class="la la-arrow-left fs-2"></i>
        </button>
        <h2 class="mb-0">{{ formData?.kode }}</h2>
      </div>
      <!-- <button v-if="formData.status >= 1" class="btn btn-sm btn btn-danger" type="button"
              @click="downloadReport(`/administrasi/pengambil-sample/${formData.uuid}/report`)">
              <i class="la la-file-pdf fs-2"></i>
              <span class="d-none d-md-inline">Cetak Sampling</span>
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
                        {{ formData.jenis_wadah?.nama }}
                      </div>
                    </div>
                    <!--end::Text-->
                  </div>
                  <!--end::Item-->
                </div>

                <div class="separator my-8"></div>

                <div class="col-md-6">
                  <div class="fv-row mb-10">
                    <label class="form-label fs-6">Interpretasi Hasil Pengujian</label>
                    <div class="d-flex align-items-center gap-2">
                      <span class="text-muted me-2">Tidak</span>
                      <vswitch class="form-check-custom form-check-solid" @change="change()"
                        v-model="formData.hasil_pengujian">
                      </vswitch>
                      <span class="text-muted">Ada</span>
                    </div>
                    <div class="fv-plugins-message-container">
                      <div class="fv-help-block">
                        <ErrorMessage name="hasil_pengujian" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="fv-row mb-10">
                    <label class="form-label fs-6">Kesimpulan Permohonan</label>
                    <div class="d-flex align-items-center gap-4">
                      <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="0" name="kesimpulan_permohonan"
                          id="status-menunggu" v-model="formData.kesimpulan_permohonan" @change="change()" />
                        <label class="form-check-label" for="status-menunggu">
                          Menunggu
                        </label>
                      </div>
                      <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="1" name="kesimpulan_permohonan"
                          id="status-diterima" v-model="formData.kesimpulan_permohonan" @change="change()" />
                        <label class="form-check-label" for="status-diterima">
                          Diterima
                        </label>
                      </div>
                      <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" value="2" name="kesimpulan_permohonan"
                          id="status-ditolak" v-model="formData.kesimpulan_permohonan" @change="change()" />
                        <label class="form-check-label" for="status-ditolak">
                          Ditolak
                        </label>
                      </div>
                    </div>
                    <div class="fv-plugins-message-container">
                      <div class="fv-help-block">
                        <ErrorMessage name="kesimpulan_permohonan" />
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
                              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
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
                                    <button class="btn btn-icon btn-sm" type="button" data-bs-toggle="modal"
                                      :data-bs-target="`#modal-kajiulang-${param.pivot.parameter_id}`">
                                      <i class="la la-pencil"></i>
                                    </button>
                                  </td>
                                  <td class="text-end" v-if="formData.permohonan?.user?.golongan_id == 1">
                                    {{
    currency(param.harga) }}</td>
                                  <div class="modal fade" :id="`modal-kajiulang-${param.pivot.parameter_id}`"
                                    tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h1 class="modal-title fs-5">Hasil Kaji
                                            Ulang Parameter: {{ param.nama }} {{
    param.keterangan ?
      `(${param.keterangan})` : '' }}
                                          </h1>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="fv-row text-end">
                                            <button type="button" class="btn btn-light-primary btn-sm"
                                              @click="checkKajiUlang(param)">Check
                                              Semua</button>
                                          </div>
                                          <!--begin::Input group-->
                                          <div class="fv-row mb-10">
                                            <label class="form-label fs-6">Personel
                                              (Mampu)</label>
                                            <vswitch class="form-check-custom form-check-solid" @change="change()"
                                              v-model="param.pivot.personel">
                                            </vswitch>
                                            <div class="fv-plugins-message-container">
                                              <div class="fv-help-block">
                                                <ErrorMessage name="personel" />
                                              </div>
                                            </div>
                                          </div>
                                          <!--end::Input group-->
                                          <!--begin::Input group-->
                                          <div class="fv-row mb-10">
                                            <label class="form-label fs-6">Metode
                                              (Sesuai)</label>
                                            <vswitch class="form-check-custom form-check-solid" @change="change()"
                                              v-model="param.pivot.metode">
                                            </vswitch>
                                            <div class="fv-plugins-message-container">
                                              <div class="fv-help-block">
                                                <ErrorMessage name="metode" />
                                              </div>
                                            </div>
                                          </div>
                                          <!--end::Input group-->
                                          <!--begin::Input group-->
                                          <div class="fv-row mb-10">
                                            <label class="form-label fs-6">Peralatan
                                              (Lengkap)</label>
                                            <vswitch class="form-check-custom form-check-solid" @change="change()"
                                              v-model="param.pivot.peralatan">
                                            </vswitch>
                                            <div class="fv-plugins-message-container">
                                              <div class="fv-help-block">
                                                <ErrorMessage name="peralatan" />
                                              </div>
                                            </div>
                                          </div>
                                          <!--end::Input group-->
                                          <!--begin::Input group-->
                                          <div class="fv-row mb-10">
                                            <label class="form-label fs-6">Reagen
                                              (Lengkap)</label>
                                            <vswitch class="form-check-custom form-check-solid" @change="change()"
                                              v-model="param.pivot.reagen">
                                            </vswitch>
                                            <div class="fv-plugins-message-container">
                                              <div class="fv-help-block">
                                                <ErrorMessage name="reagen" />
                                              </div>
                                            </div>
                                          </div>
                                          <!--end::Input group-->
                                          <!--begin::Input group-->
                                          <div class="fv-row mb-10">
                                            <label class="form-label fs-6">Akomodasi
                                              (Baik)</label>
                                            <vswitch class="form-check-custom form-check-solid" @change="change()"
                                              v-model="param.pivot.akomodasi">
                                            </vswitch>
                                            <div class="fv-plugins-message-container">
                                              <div class="fv-help-block">
                                                <ErrorMessage name="akomodasi" />
                                              </div>
                                            </div>
                                          </div>
                                          <!--end::Input group-->
                                          <!--begin::Input group-->
                                          <div class="fv-row mb-10">
                                            <label class="form-label fs-6">Beban
                                              Kerja
                                              (Over)</label>
                                            <vswitch class="form-check-custom form-check-solid" @change="change()"
                                              v-model="param.pivot.beban_kerja">
                                            </vswitch>
                                            <div class="fv-plugins-message-container">
                                              <div class="fv-help-block">
                                                <ErrorMessage name="beban_kerja" />
                                              </div>
                                            </div>
                                          </div>
                                          <!--end::Input group-->
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-light"
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
                        <div v-else class="text-dark text-hover-primary fs-6 fw-bold">-</div>
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
                        <Field class="form-control form-control-lg form-control-solid" type="text" @change="change()"
                          name="lab_subkontrak" autocomplete="off" v-model="formData.lab_subkontrak" />
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
                              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
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
                <span class="text-muted mt-1 fw-semibold fs-7">Detail Pengambilan (Silahkan Isi Data Di
                  Bawah Ini)</span>
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
                  <span class="text-muted mb-2 required">Radius Pengambilan</span>
                  <div class="fv-row">
                    <Field v-model="formData.permohonan.radius_pengambilan_id" name="radius_pengambilan_id">
                      <select2 placeholder="Pilih Radius Pengambilan" class="form-select-solid mw-200px mw-md-100"
                        name="radius_pengambilan_id" @select="change()" :options="radiuses"
                        v-model="formData.permohonan.radius_pengambilan_id">
                      </select2>
                    </Field>
                    <div class="fv-plugins-message-container">
                      <div class="fv-help-block">
                        <ErrorMessage name="radius_pengambilan_id" />
                      </div>
                    </div>
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
                  <span class="text-muted mb-2 required">Petugas</span>
                  <div class="fv-row">
                    <Field v-model="formData.petugas_pengambil_ids" name="petugas_pengambil_ids">
                      <select2 placeholder="Pilih Petugas Pengambil" class="form-select-solid mw-200px mw-md-100"
                        name="petugas_pengambil_ids" @select="change()" :options="petugases"
                        v-model="formData.petugas_pengambil_ids" :disabled="user.role?.name === 'pengambil-sample'"
                        :settings="{ allowClear: true, multiple: true }">
                      </select2>
                    </Field>
                    <div class="fv-plugins-message-container">
                      <div class="fv-help-block">
                        <ErrorMessage name="petugas_pengambil_ids" />
                      </div>
                    </div>
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
                  <span class="text-muted mb-2 required">Tanggal/Jam</span>
                  <div class="fv-row">
                    <Field v-model="formData.tanggal_pengambilan" name="tanggal_pengambilan">
                      <date-picker v-model="formData.tanggal_pengambilan" name="tanggal_pengambilan" @change="change()"
                        :config="{
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
                  <span class="text-muted mb-2 required">Metode</span>
                  <div class="fv-row">
                    <Field v-model="formData.acuan_metode_id" name="acuan_metode_id">
                      <select2 placeholder="Pilih Metode" @select="change()"
                        class="form-select-solid mw-200px mw-md-100" name="acuan_metode_id" :options="acuanMetodes"
                        v-model="formData.acuan_metode_id">
                      </select2>
                    </Field>
                    <div class="fv-plugins-message-container">
                      <div class="fv-help-block">
                        <ErrorMessage name="acuan_metode_id" />
                      </div>
                    </div>
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
                    <i class="la la-archway fs-2x text-success"></i>
                  </span>
                </div>
                <!--end::Symbol-->
                <!--begin::Text-->
                <div class="d-flex flex-column">
                  <span class="text-muted mb-2">Obyek Pelayanan</span>
                  <div class="fv-row">
                    <Field class="form-control form-control-lg form-control-solid" type="text" @change="change()"
                      name="obyek_pelayanan" autocomplete="off" v-model="formData.obyek_pelayanan" />
                    <div class="fv-plugins-message-container">
                      <div class="fv-help-block">
                        <ErrorMessage name="obyek_pelayanan" />
                      </div>
                    </div>
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
  </div>
</template>
<script lang="ts">
import { block, unblock, currency, convertToDMS } from '@/libs/utils';
import { computed, defineComponent, ref } from 'vue'
import * as Yup from 'yup';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useAcuanMetode, usePetugasPengambil, useRadiusPengambilan } from '@/services';
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
  pengambil_id: number;
  petugas_pengambil_ids: number[];
  nama_pengambil: string;
  tanggal_pengambilan: string;
  acuan_metode_id: number;
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
  hasil_pengujian: boolean | number;
  kesimpulan_permohonan: boolean | number;
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
    radius_pengambilan_id?: number;
    jasa_pengambilan?: {
      wilayah: string;
      harga: number;
    },
    user: {
      nama: string;
      phone: string;
      golongan_id: number;
      detail: {
        instansi: string;
        alamat: string;
      }
    }
  },
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
  },
  emits: ['close', 'refresh'],
  setup() {
    const status = ref(0)
    const { user } = useAuthStore();
    const formData = ref<FormData>({
      lapangan: {},
      permohonan: {}
    } as FormData)
    const formSchema = computed(() => Yup.object().shape({
      petugas_pengambil_ids: Yup.array().min(1, 'Petugas Pengambil harus diisi'),
      acuan_metode_id: Yup.number().required('Metode harus diisi'),
      radius_pengambilan_id: Yup.number().required('Radius Pengambilan harus diisi'),
      tanggal_pengambilan: Yup.string().required('Tanggal Pengambilan harus diisi'),
      ...(formData.value.is_has_subkontrak && {
        lab_subkontrak: Yup.string().required('Lab Subkontrak harus diisi'),
      })
    }))
    const radius = useRadiusPengambilan()
    const radiuses = computed(() => radius.data.value?.map(item => ({
      id: item.id,
      text: `${item.radius}m ${formData.value.permohonan?.user?.golongan_id == 1 ? `- ${currency(item.harga)}` : ''}`
    })))
    const petugas = usePetugasPengambil()
    const petugases = computed(() => petugas.data.value?.map(item => ({
      id: item.id,
      text: item.nama
    })))
    const acuanMetode = useAcuanMetode()
    const acuanMetodes = computed(() => acuanMetode.data.value?.map(item => ({
      id: item.id,
      text: item.nama
    })))
    const { download: downloadReport } = useDownloadPdf();
    return {
      user,
      formData,
      formSchema,
      radiuses,
      petugases,
      acuanMetodes,
      currency,
      status,
      downloadReport,
    }
  },
  methods: {
    getEdit() {
      block(this.$el)
      axios.get(`/administrasi/pengambil-sample/${this.selected}`)
        .then(res => {
          this.formData = res.data.data
          this.status = res.data.data.status
          this.formData.lapangan = res.data.data.lapangan || {}
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
      axios.post(`/administrasi/pengambil-sample/${this.selected}/update`, { ...this.formData })
        .catch(err => {
          toast.error(err.response.data.message)
        })
        .finally(() => {
          unblock(this.$el)
        })
    },
    // submit() {
    //     block(this.$el)
    //     axios.post(`/administrasi/pengambil-sample/${this.selected}/update-status`, { status: this.status })
    //         .then(res => {
    //             this.$emit('close')
    //             this.$emit('refresh')
    //             toast.success('Data berhasil disimpan')
    //         })
    //         .catch(err => {
    //             toast.error(err.response.data.message)
    //         })
    //         .finally(() => {
    //             unblock(this.$el)
    //         })
    // },
    getLatLong() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.formData.south = convertToDMS(position.coords.latitude)
        this.formData.east = convertToDMS(position.coords.longitude)
        this.change()
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
    },
  }
})
</script>
