<script lang="ts">
import { block, unblock } from '@/libs/utils';
import { defineComponent, ref } from 'vue'
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import * as Yup from 'yup';
interface FormData {
  uuid: string;
  revisi: string;
}
export default defineComponent({
  props: {
    selected: {
      type: String,
      default: null
    }
  },
  setup() {
    const formData = ref<FormData>({} as FormData)
    const formSchema = Yup.object().shape({
      revisi: Yup.string().required('Revisi harus diisi'),
    })
    return {
      formData,
      formSchema,
    }
  },
  methods: {
    submit() {
      const data = new FormData(document.getElementById('form-revisi') as HTMLFormElement);
      block(this.$el)
      axios.post(`/verifikasi/koordinator-teknis/${this.selected}/revisi`, data)
        .then(() => {
          toast.success("berhasil menyimpan revisi")
          this.$emit('close')
          this.$emit('refresh')
        })
        .catch(err => {
          toast.error(err.response.data.message)
        })
        .finally(() => {
          unblock(this.$el)
        })
    },
  }
}
);
</script>

<template>
  <VForm class="card mb-10" @submit="submit" :validation-schema="formSchema" id="form-revisi">
    <div class="card-header align-items-center">
      <h2 class="mb-0">Revisi</h2>
      <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="$emit('close')"><i
          class="la la-times-circle fs-2"></i> Batal</button>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <!-- begin::input-group -->
          <div class="fv-row mb-7">
            <label class="form-label fw-bold text-dark fs-6 ">Keterangan Revisi</label>
            <Field class="form-control form-control-lg form-control-solid" type="text" name="revisi" autocomplete="off"
              v-model="formData.revisi">
              <textarea name="revisi" autocomplete="off" rows="3"
                class="form-control form-control-lg form-control-solid" v-model="formData.revisi"></textarea>
            </Field>
            <div class="fv-plugins-message-container">
              <div class="fv-help-block">
                <ErrorMessage name="revisi" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer d-flex">
      <button type="submit" class="btn btn-sm btn-primary ms-auto">
        Simpan
      </button>
    </div>
  </VForm>
</template>
