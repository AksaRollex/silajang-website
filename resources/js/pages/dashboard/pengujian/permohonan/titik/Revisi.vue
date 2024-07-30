<template>
    <div class="modal fade" id="modal-revisi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
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
                                readonly rows="3" v-model="formData.keterangan_revisi"></textarea>
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
                    <button type="button" class="btn btn-info"
                        @click="$emit('go-to-edit', $props.selected.uuid)">Edit</button>
                </div>
            </div>
        </div>
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
    emits: ['go-to-edit'],
    setup(props) {
        const formData = ref<any>({} as any);

        return {
            formData,
        }
    },
    watch: {
        selected: {
            immediate: true,
            handler(selected) {
                if (selected?.uuid) {
                    this.formData = selected;
                }
            }
        }
    }
})
</script>
