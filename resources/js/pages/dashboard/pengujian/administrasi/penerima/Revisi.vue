<template>
    <div class="modal fade" id="modal-revisi" tabindex="-1" aria-hidden="true">
        <VForm class="modal-dialog modal-dialog-centered" @submit="submit" :validation-schema="formSchema">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">
                        Revisi: {{ selected?.kode }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <!--begin::Input group-->
                    <div class="fv-row mb-7">
                        <label class="form-label fw-bold text-dark fs-6">Keterangan</label>
                        <Field name="keterangan_revisi" autocomplete="off" v-model="formData.keterangan_revisi">
                            <textarea class="form-control form-control-lg form-control-solid" name="keterangan_revisi"
                                rows="3" v-model="formData.keterangan_revisi"></textarea>
                        </Field>
                        <div class="fv-plugins-message-container">
                            <div class="fv-help-block">
                                <ErrorMessage name="keterangan_revisi" />
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Kirim Revisi</button>
                </div>
            </div>
        </VForm>
    </div>
</template>

<script lang="ts">
import axios from '@/libs/axios';
import { block, unblock } from '@/libs/utils';
import { defineComponent, ref } from 'vue'
import { toast } from 'vue3-toastify';
import * as Yup from 'yup';

export default defineComponent({
    props: {
        selected: {
            type: Object,
            required: true,
        }
    },
    setup() {
        const formData = ref<any>({});

        const formSchema = Yup.object({
            keterangan_revisi: Yup.string().required('Keterangan revisi harus diisi'),
        });

        return {
            formData,
            formSchema,
        }
    },
    methods: {
        submit() {
            block('#modal-revisi .modal-content')

            axios.post(`/administrasi/penerima-sample/${this.selected.uuid}/revisi`, this.formData)
                .then(res => {
                    $('#modal-revisi').modal('hide')
                    this.$emit('refresh')
                    toast.success('Revisi berhasil dikirim')

                    this.formData = {}
                })
                .catch(err => {
                    toast.error(err.response.data.message)
                })
                .finally(() => {
                    unblock('#modal-revisi .modal-content')
                })
        }
    }
})
</script>
