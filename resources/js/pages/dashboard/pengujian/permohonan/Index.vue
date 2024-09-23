<template>
  <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

  <div class="card">
    <div class="card-header align-items-center">
      <h2 class="mb-0">Permohonan</h2>
      <div class="ms-auto d-flex align-items-center gap-4">
        <div v-if="user.has_tagihan" class="alert alert-warning mt-2">
          <h6 class="text-dark mb-0">Tidak dapat membuat Permohonan Baru</h6>
          <span class="text-dark fs-8">Harap selesaikan tagihan pembayaran Anda terlebih dahulu.</span>
        </div>
        <select2 placeholder="Pilih Tahun" class="form-select-solid mw-200px mw-md-100" name="tahun" :options="tahuns"
          v-model="tahun">
        </select2>
        <button type="button" class="btn btn-sm btn-primary" v-if="!openForm && !user.has_tagihan" @click="open">
          Tambah
          <i class="la la-plus"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      <paginate ref="paginate" id="table-permohonan" url="/permohonan" :columns="columns" :payload="{ tahun }">
      </paginate>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" id="modal-umpan-balik">
    <form @submit.prevent="sendUmpanBalik" class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Mohon Berikan Umpan Balik Pelayanan UPT</h3>
          <!--begin::Close-->
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-auto" data-bs-dismiss="modal" aria-label="Close">
            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
          </div>
          <!--end::Close-->
        </div>

        <div class="modal-body">
          <ol>
            <li v-for="umpan in umpanBaliks" :key="umpan.id"
              class="d-flex gap-4 align-items-center justify-content-between pb-4 mb-4 border-bottom">
              <h5>{{ umpan.keterangan }}</h5>
              <star-rating v-model:rating="formRating[umpan.kode]" :max-rating="10" :show-rating="false"
                :star-size="20"></star-rating>
            </li>
          </ol>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script lang="ts">
import StarRating from 'vue-star-rating'

import { defineComponent, h, ref } from 'vue'
import { useDelete } from "@/libs/hooks";

import Form from './Form.vue';

interface Permohonan {
  no: number,
  uuid: string,
  industri: string,
  kegiatan: string,
  alamat: string,
  is_mandiri: boolean | number,
  tanggal: string,
  pembayaran: string,
  editable: boolean,
  jasa_pengambilan: {
    wilayah: string;
    harga: number
  },
  jenis_contoh: {
    nama: string;
  },
  kesimpulan_kontrak: boolean | number,
}
import { createColumnHelper } from "@tanstack/vue-table";
import { block, currency, unblock } from '@/libs/utils';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';
import { toast } from 'vue3-toastify';
import axios from '@/libs/axios';
import { useUmpanBalik } from '@/services';
const column = createColumnHelper<Permohonan>();

export default defineComponent({
  components: {
    Form,
    StarRating
  },
  setup() {
    const paginate = ref<any>(null);
    const selected = ref<string>("");
    const openForm = ref<boolean>(false);
    const router = useRouter();
    const { user, verifyAuth } = useAuthStore();

    const { data: umpanBaliks } = useUmpanBalik()
    const formRating = ref<any>({})

    const { delete: deletePermohonan } = useDelete({
      onSuccess: () => paginate.value.refetch(),
    });

    const hasUmpanBalik = ref<Boolean>(false)

    const columns = [
      column.accessor("no", {
        header: "#"
      }),
      column.accessor("industri", {
        header: "Nama Industri",
      }),
      column.accessor("alamat", {
        header: "Alamat",
      }),
      column.accessor("pembayaran", {
        header: "Pembayaran",
        cell: cell => h('span', {
          class: 'badge badge-success'
        }, cell.getValue().toUpperCase())
      }),
      column.accessor("is_mandiri", {
        header: "Cara Pengambilan",
        cell: cell => cell.getValue() == 1 ? h('span', {
          class: 'badge badge-info'
        }, 'KIRIM MANDIRI') : h('div', [h('span', {
          class: 'badge badge-info mb-2'
        }, 'AMBIL PETUGAS'), h('div', `${cell.row.original.jasa_pengambilan.wilayah} - ${currency(cell.row.original.jasa_pengambilan.harga)}`)])
      }),
      // column.accessor("kesimpulan_kontrak", {
      //   header: "Kontrak",
      //   cell: cell => cell.getValue() == 1 && cell.row.original.is_mandiri == 1 ? h('span', {
      //     class: 'badge badge-secondary'
      //   }, '-') : cell.getValue() == 1 ? h('span', {
      //     class: 'badge badge-success'
      //   }, 'Diterima') : cell.getValue() == 2 ? h('span', {
      //     class: 'badge badge-danger'
      //   }, 'Ditolak') : h('span', {
      //     class: 'badge badge-primary'
      //   }, 'Menunggu')
      // }),
      column.accessor("tanggal", {
        header: "Tanggal",
      }),
      column.accessor("uuid", {
        header: "Aksi",
        cell: (cell) => h('div', { class: 'd-flex gap-2' }, [
          h('button', {
            class: 'btn btn-sm btn-success d-flex', onClick: () => {
              router.push(`/dashboard/pengujian/permohonan/${cell.getValue()}`);
            },
            style: {
              whiteSpace: 'nowrap'
            }
          }, [h('i', { class: 'la la-list fs-2' }), ' Titik Uji']),
          cell.row.original.editable && h('button', {
            class: 'btn btn-sm btn-icon btn-info', onClick: () => {
              selected.value = cell.getValue();
              openForm.value = true;
            }
          }, h('i', { class: 'la la-pencil fs-2' })),
          cell.row.original.editable && h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => deletePermohonan(`/permohonan/${cell.getValue()}`) }, h('i', { class: 'la la-trash fs-2' }))
        ])
      }),
    ]

    const tahun = ref(new Date().getFullYear());
    const tahuns = ref<any[]>([]);
    for (let i = tahun.value; i >= 2022; i--) {
      tahuns.value.push({ id: i, text: i });
    }


    return {
      columns,
      selected,
      openForm,
      paginate,
      refresh: () => paginate.value.refetch(),
      tahun,
      tahuns,
      user,
      verifyAuth,
      umpanBaliks,
      formRating,
      hasUmpanBalik
    }
  },
  methods: {
    open() {
      if (!this.user.has_umpan_balik && !this.hasUmpanBalik) {
        $('#modal-umpan-balik').modal('show');
      } else {
        this.openForm = true
      }
    },
    sendUmpanBalik() {
      const vm = this
      block("#modal-umpan-balik form")

      axios.post('/konfigurasi/umpan-balik/send', this.formRating)
        .then(async (res) => {
          vm.verifyAuth()
          $('#modal-umpan-balik').modal('hide')
          this.openForm = true
          this.hasUmpanBalik = true

          toast.success('Umpan Balik Berhasil Dikirim')
        })
        .catch(err => {
          toast.error(err.response.data.message)
        })
        .finally(() => {
          unblock("#modal-umpan-balik form")
        })
    },
  },
  watch: {
    openForm(val) {
      if (!val) {
        this.selected = "";
      }
      window.scrollTo(0, 0);
    }
  }
})
</script>
