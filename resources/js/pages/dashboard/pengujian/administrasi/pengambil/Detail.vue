<template>
    <VForm class="card mb-10" @submit="submit">
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
                                                {{ formData.jenis_wadahs?.map(a => `${a.nama}${a.keterangan ?
                                                    `${a.keterangan}` : ''}`).join(", ") }}
                                            </div>
                                        </div>
                                        <!--end::Text-->
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
                                    <span class="text-muted">Radius Pengambilan</span>
                                    <div class="text-dark text-hover-primary fs-6 fw-bold">
                                        {{ formData.permohonan?.radius_pengambilan?.radius }}m
                                        <span v-if="formData.permohonan?.user?.golongan_id == 1">
                                            ({{ currency(formData.permohonan?.radius_pengambilan?.harga) }})
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
                                    <span class="text-muted">Petugas</span>
                                    <ul>
                                        <li v-for="petugas in formData.petugas_pengambils" :key="petugas.id">
                                            <div class="text-dark text-hover-primary fs-6 fw-bold">
                                                {{ petugas.nama }}
                                            </div>
                                        </li>
                                    </ul>
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
                                    <span class="text-muted">Tanggal/Jam</span>
                                    <div class="text-dark text-hover-primary fs-6 fw-bold">
                                        {{ formData.tanggal_pengambilan_indo }}
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
                                    <span class="text-muted">Metode</span>
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
                                <span class="text-muted mt-1 fw-semibold fs-7">Detail Lokasi (Silahkan Isi Data Di
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
                                        <i class="la la-compass fs-2x text-success"></i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <span class="text-muted mb-2">South</span>
                                    <div class="fv-row mw-200px mw-md-100">
                                        <Field class="form-control form-control-lg form-control-solid" type="text"
                                            @change="change()" name="south" autocomplete="off" v-model="formData.south" />
                                        <div class="fv-plugins-message-container">
                                            <div class="fv-help-block">
                                                <ErrorMessage name="south" />
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
                                        <i class="la la-compass fs-2x text-success"></i>
                                    </span>
                                </div>
                                <!--end::Symbol-->

                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <span class="text-muted mb-2">East</span>
                                    <div class="fv-row mw-200px mw-md-100">
                                        <Field class="form-control form-control-lg form-control-solid" type="text"
                                            @change="change()" name="east" autocomplete="off" v-model="formData.east" />
                                        <div class="fv-plugins-message-container">
                                            <div class="fv-help-block">
                                                <ErrorMessage name="east" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Item-->

                            <button type="button" class="btn btn-sm btn-light-primary mt-4 ms-auto"
                                @click="getLatLong()">Lokasi Saat Ini</button>
                        </div>
                        <!--end::Body-->
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-xl-stretch mb-md-8">
                        <!--begin::Header-->
                        <div class="card-header py-0 min-h-50px">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="text-muted mt-1 fw-semibold fs-7">Hasil Pengukuran Lapangan (Silahkan Isi Data
                                    Di
                                    Bawah Ini)</span>
                            </h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clipboard-check fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Suhu Air (t&deg;C)</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="suhu_air" autocomplete="off"
                                                    v-model="formData.lapangan.suhu_air" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="suhu_air" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clipboard-check fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">pH</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="ph" autocomplete="off"
                                                    v-model="formData.lapangan.ph" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="ph" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clipboard-check fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">DHL (µS/cm)</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="dhl" autocomplete="off"
                                                    v-model="formData.lapangan.dhl" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="dhl" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clipboard-check fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Salinitas (‰)</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="salinitas" autocomplete="off"
                                                    v-model="formData.lapangan.salinitas" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="salinitas" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clipboard-check fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">DO (mg/L)</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="do" autocomplete="off"
                                                    v-model="formData.lapangan.do" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="do" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clipboard-check fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Kekeruhan</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="kekeruhan" autocomplete="off"
                                                    v-model="formData.lapangan.kekeruhan" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="kekeruhan" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-clipboard-check fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Klorin Bebas</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="klorin_bebas" autocomplete="off"
                                                    v-model="formData.lapangan.klorin_bebas" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="klorin_bebas" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
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
                                <span class="text-muted mt-1 fw-semibold fs-7">Kondisi Lingkungan (Silahkan Isi Data
                                    Di
                                    Bawah Ini)</span>
                            </h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            <div class="row">
                                <div class="col-xl-6 col-lg-12 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-seedling fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Suhu Udara (t&deg;C)</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="suhu_udara" autocomplete="off"
                                                    v-model="formData.lapangan.suhu_udara" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="suhu_udara" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-6 col-lg-12 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-seedling fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Cuaca</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="cuaca" autocomplete="off"
                                                    v-model="formData.lapangan.cuaca" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="cuaca" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-6 col-lg-12 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-seedling fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Arah Angin</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="arah_angin" autocomplete="off"
                                                    v-model="formData.lapangan.arah_angin" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="arah_angin" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-6 col-lg-12 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-seedling fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Kelembapan (%RH)</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="kelembapan" autocomplete="off"
                                                    v-model="formData.lapangan.kelembapan" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="kelembapan" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
                                </div>
                                <div class="col-xl-6 col-lg-12 col-sm-6">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-7">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-40px symbol-md-50px me-4 me-md-5">
                                            <span class="symbol-label bg-light-success">
                                                <i class="la la-seedling fs-2x text-success"></i>
                                            </span>
                                        </div>
                                        <!--end::Symbol-->

                                        <!--begin::Text-->
                                        <div class="d-flex flex-column">
                                            <span class="text-muted mb-2">Kecepatan Angin</span>
                                            <div class="fv-row mw-200px mw-md-100">
                                                <Field class="form-control form-control-lg form-control-solid" type="text"
                                                    @change="change()" name="kecepatan_angin" autocomplete="off"
                                                    v-model="formData.lapangan.kecepatan_angin" />
                                                <div class="fv-plugins-message-container">
                                                    <div class="fv-help-block">
                                                        <ErrorMessage name="kecepatan_angin" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Text-->
                                    </div>
                                    <!--end::Item-->
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
                                <span class="text-muted mt-1 fw-semibold fs-7">Foto Lapangan/Lokasi</span>
                            </h3>
                        </div>
                        <!--end::Header-->

                        <div class="card-body">
                            <file-upload v-bind:files="photos" :accepted-file-types="fileTypes" :allow-multiple="true"
                                class="multiple" v-on:updatefiles="onUpdateFiles"></file-upload>
                            <div class="d-flex">
                                <button type="button" class="btn btn-light-primary btn-sm ms-auto mt-4"
                                    @click="uploadPhotos">Simpan &
                                    Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex">
            <button v-if="formData?.status == 0" type="submit" class="btn btn-sm btn-primary ms-auto" @click="status = 1">
                Konfirmasi
                <i class="la la-check fs-2 ms-2"></i>
            </button>
            <button v-if="formData?.status > 0 && formData?.status < 2" type="submit"
                class="btn btn-sm btn-light-danger ms-auto" @click="status = 0">
                Batalkan Konfirmasi
                <i class="la la-times fs-2 ms-2"></i>
            </button>
        </div>
    </VForm>
</template>

<style>
.multiple .filepond--item {
    width: calc(33.33% - 0.5em);
}
</style>

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
    jenis_wadahs: [
        {
            nama: string;
            keterangan: string;
        }
    ],
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
        radius_pengambilan?: {
            radius: string;
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
    },
    photos: [
        {
            foto: string;
        }
    ]
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

        const photos = ref<Array<File | String>>([])
        const fileTypes = ref(['image/jpeg', 'image/png'])

        return {
            user,
            formData,
            radiuses,
            petugases,
            acuanMetodes,
            currency,
            status,
            downloadReport,
            photos,
            fileTypes,
        }
    },
    methods: {
        onUpdateFiles(files: Array<File | String>) {
            this.photos = files
        },
        uploadPhotos() {
            block(this.$el)

            const formData = new FormData()
            this.photos.forEach((item: any) => {
                formData.append('photos[]', item.file)
            })

            axios.post(`/administrasi/pengambil-sample/${this.selected}/upload-photo`, formData)
                .then(res => {
                    toast.success('Foto berhasil diupload')
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock(this.$el)
                })
        },
        getEdit() {
            block(this.$el)

            axios.get(`/administrasi/pengambil-sample/${this.selected}`)
                .then(res => {
                    this.formData = res.data.data
                    this.status = res.data.data.status
                    this.formData.lapangan = res.data.data.lapangan || {}

                    this.photos = this.formData.photos.map(item => item.foto)
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
        submit() {
            block(this.$el)

            axios.post(`/administrasi/pengambil-sample/${this.selected}/update-status`, { status: this.status })
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
        getLatLong() {
            navigator.geolocation.getCurrentPosition((position) => {
                this.formData.south = convertToDMS(position.coords.latitude)
                this.formData.east = convertToDMS(position.coords.longitude)

                this.change()
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
        },
    }
})
</script>
