<template>
  <div id="titik-parameter" class="card mb-10">
    <div class="card-header align-items-center">
      <h2 class="mb-0">{{ titik?.lokasi }} {{ titik?.kode.includes('(') ? titik?.kode : `(${titik?.kode})` }}:
        Pilih
        Peraturan/Parameter <div v-if="titik?.uuid && titik?.save_parameter && titik.status > 1"
          class="text-muted fw-normal fs-8">
          <em>Tidak
            bisa
            melakukan pengeditan karena status sudah dalam {{ mapStatusPengujian(titik.status) }}</em>
        </div>
      </h2>
      <button type="button" class="btn btn-sm btn-light-danger ms-auto" @click="close()">
        Tutup
        <i class="la la-times-circle p-0"></i>
      </button>
    </div>
    <div class="card-body">
      <div class="row row-gap-20">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center pt-2 pb-4 bg-hover-light"
            @click="showPeraturan = !showPeraturan" style="cursor: pointer;">
            <h5 class="mb-0 flex-fill">Pilih berdasarkan Peraturan:</h5>
            <button class="btn btn-sm btn-icon btn-light">
              <i class="fa fa-chevron-down"></i>
            </button>
          </div>
          <paginate ref="paginatePeraturan" id="table-peraturan" :url="`/permohonan/titik/${selected}/peraturan`"
            :margin="false" v-show="showPeraturan" :columns="columnsPeraturan">
          </paginate>
        </div>

        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center pt-2 pb-4 bg-hover-light"
            @click="showPaket = !showPaket" style="cursor: pointer;">
            <h5 class="mb-0 flex-fill">Pilih berdasarkan Paket:</h5>
            <button class="btn btn-sm btn-icon btn-light">
              <i class="fa fa-chevron-down"></i>
            </button>
          </div>
          <div v-show="showPaket" class="row">
            <div v-for="paket in pakets" :key="paket.id" class="col-lg-4 col-md-6">
              <div v-if="titik?.uuid && titik?.save_parameter && titik.status > 1"
                :class="`card ${titik?.pakets?.find(p => p.id == paket.id) ? 'border-2 border-primary' : ''}`">
                <div class="card-body p-4">
                  <h4>{{ paket.nama }}</h4>
                  <div>{{ currency(paket.harga) }}</div>
                  <div class="separator my-5"></div>
                  <div>{{ paket.parameters.map(param => `${param.nama} ${param.keterangan ?
        `(${param.keterangan})` : ''}`).join(", ") }}</div>
                </div>
              </div>
              <div v-else
                :class="`card bg-hover-light-primary ${titik?.pakets?.find(p => p.id == paket.id) ? 'border-2 border-primary' : ''}`"
                style="cursor: pointer;"
                @click="titik?.pakets?.find(p => p.id == paket.id) ? removeFromPaket(paket) : storeFromPaket(paket)">
                <div class="card-body p-4">
                  <h4>{{ paket.nama }}</h4>
                  <div>{{ currency(paket.harga) }}</div>
                  <div class="separator my-5"></div>
                  <div>{{ paket.parameters.map(param => `${param.nama} ${param.keterangan ?
        `(${param.keterangan})` : ''}`).join(", ") }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <h6 class="mb-8">Parameter Tersedia:</h6>
          <paginate ref="paginateParameter" id="table-parameter" url="/master/parameter" :columns="columnsParameter"
            :payload="{ except: selectedParameter }" :enabled="false">
          </paginate>
        </div>
        <div class="col-md-6">
          <h6 class="mb-8">Parameter yang Dipilih:</h6>
          <paginate ref="paginateSelectedParameter" id="table-peraturan"
            :url="`/permohonan/titik/${selected}/parameter`" :columns="columnsSelectedParameter"></paginate>

          <div class="d-flex fs-4 gap-4 justify-content-end mt-10">Total Harga: <strong>{{
        currency(titik?.harga)
      }}</strong></div>
        </div>
      </div>
    </div>
    <div v-if="!titik?.save_parameter || titik.status <= 1" class="card-footer d-flex justify-content-end">
      <button type="button" class="btn btn-sm btn-primary" @click="send">
        <i class="la la-save fs-4"></i>
        Simpan & Kirim
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, h, ref } from 'vue'

interface PivotTitikPermohonan {
  uuid: string,
  pivot: {
    harga: number,
  }
}

interface Parameter {
  uuid: string,
  nama: string,
  metode: string,
  harga: number,
  satuan: string,
  mdl: string,
  titik_permohonans: Array<PivotTitikPermohonan>
  jenis_parameter: {
    nama: string,
  }
}

interface Peraturan {
  no: number,
  nama: string,
  nomor: string,
  tentang: string,
  uuid: string,
  selected: boolean,
}

import { createColumnHelper } from "@tanstack/vue-table";
import { block, currency, unblock, mapStatusPengujian } from '@/libs/utils';
import { useMutation, useQuery } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { usePaket, useTitikPermohonan } from '@/services';
import Swal from 'sweetalert2';
const column = createColumnHelper<Parameter>();
const columnP = createColumnHelper<Peraturan>();

export default defineComponent({
  props: {
    selected: {
      type: String,
      required: true,
    },
  },
  emits: ['close'],
  setup(props) {
    const { data: titik = {}, refetch } = useTitikPermohonan(props.selected, { cacheTime: 0 })

    const { mutate: addPeraturan } = useMutation((uuid: string) => axios.post(`/permohonan/titik/${props.selected}/peraturan/store`, { uuid }), {
      onMutate: () => {
        block(paginatePeraturan.value.$el)
      },
      onSuccess: () => {
        refetch();
        paginatePeraturan.value.refetch();
        selectedParameter.refetch();
        paginateSelectedParameter.value.refetch();
      },
      onSettled: () => {
        unblock(paginatePeraturan.value.$el)
      }
    })

    const { mutate: removePeraturan } = useMutation((uuid: string) => axios.post(`/permohonan/titik/${props.selected}/peraturan/destroy`, { uuid }), {
      onMutate: () => {
        block(paginateSelectedParameter.value.$el)
      },
      onSuccess: () => {
        refetch();
        paginatePeraturan.value.refetch();
        selectedParameter.refetch();
        paginateSelectedParameter.value.refetch();
      },
      onSettled: () => {
        unblock(paginateSelectedParameter.value.$el)
      }
    })

    const paginatePeraturan = ref<any>(null);
    const columnsPeraturan = [
      columnP.accessor("no", {
        header: "#",
        cell: cell => h('div', {
          class: cell.row.original.selected && 'text-primary fw-bold'
        }, cell.getValue())
      }),
      columnP.accessor("nama", {
        header: "Nama",
        cell: cell => h('div', {
          class: cell.row.original.selected && 'text-primary fw-bold'
        }, cell.getValue())
      }),
      columnP.accessor("nomor", {
        header: "Nomor",
        cell: cell => h('div', {
          class: cell.row.original.selected && 'text-primary fw-bold'
        }, cell.getValue())
      }),
      columnP.accessor("tentang", {
        header: "Tentang",
        cell: cell => h('div', {
          class: cell.row.original.selected && 'text-primary fw-bold'
        }, cell.getValue())
      }),
      columnP.accessor("uuid", {
        header: "Aksi",
        cell: (cell) => (!titik.value?.save_parameter || titik.value.status <= 1) && h('div', { class: 'd-flex gap-2' }, [
          cell.row.original.selected ? h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => removePeraturan(cell.getValue()) }, h('i', { class: 'la la-times fs-2' })) : h('button', { class: 'btn btn-sm btn-icon btn-primary', onClick: () => addPeraturan(cell.getValue()) }, h('i', { class: 'la la-plus fs-2' }))
        ])
      }),
    ]

    const paginateParameter = ref<any>(null);
    const paginateSelectedParameter = ref<any>(null);

    const selectedParameter = useQuery({
      queryKey: ['selectedParameter', props.selected],
      queryFn: () => axios.get(`/permohonan/titik/${props.selected}/parameter`).then(res => res.data.data),
      cacheTime: 0,
    })

    const { mutate: addParameter } = useMutation((uuid: string) => axios.post(`/permohonan/titik/${props.selected}/parameter/store`, { uuid }), {
      onMutate: () => {
        block(paginateParameter.value.$el)
      },
      onSuccess: () => {
        refetch();
        selectedParameter.refetch();
        paginateSelectedParameter.value.refetch();
      },
      onSettled: () => {
        unblock(paginateParameter.value.$el)
      }
    })

    const { mutate: storeFromPaket } = useMutation((paket: any) => axios.post(`/permohonan/titik/${props.selected}/parameter/store/paket`, { paket_id: paket.id }), {
      onMutate: () => {
        block('#titik-parameter')
      },
      onSuccess: () => {
        refetch();
        selectedParameter.refetch();
        paginateSelectedParameter.value.refetch();
      },
      onSettled: () => {
        unblock('#titik-parameter')
      }
    })

    const { mutate: removeFromPaket } = useMutation((paket: any) => axios.post(`/permohonan/titik/${props.selected}/parameter/destroy/paket`, { paket_id: paket.id }), {
      onMutate: () => {
        block('#titik-parameter')
      },
      onSuccess: () => {
        refetch();
        selectedParameter.refetch();
        paginateSelectedParameter.value.refetch();
      },
      onSettled: () => {
        unblock('#titik-parameter')
      }
    })

    const { mutate: removeParameter } = useMutation((uuid: string) => axios.post(`/permohonan/titik/${props.selected}/parameter/destroy`, { uuid }), {
      onMutate: () => {
        block(paginateSelectedParameter.value.$el)
      },
      onSuccess: () => {
        refetch();
        selectedParameter.refetch();
        paginatePeraturan.value.refetch();
        paginateSelectedParameter.value.refetch();
      },
      onSettled: () => {
        unblock(paginateSelectedParameter.value.$el)
      }
    })

    const columnsParameter = [
      column.accessor("nama", {
        header: "Nama",
        cell: cell => h('div', [`${cell.getValue()} ${cell.row.original.keterangan ? `(${cell.row.original.keterangan})` : ''}`, h('span', { class: 'text-muted ms-3 fs-8' }, cell.row.original.jenis_parameter.nama)])
      }),
      column.accessor("harga", {
        header: "Harga",
        cell: cell => currency(cell.getValue())
      }),
      column.accessor("uuid", {
        header: "Aksi",
        cell: (cell) => (!titik.value?.save_parameter || titik.value.status <= 1) && h('div', { class: 'd-flex gap-2' }, [
          h('button', { class: 'btn btn-sm btn-icon btn-primary', onClick: () => addParameter(cell.getValue()) }, h('i', { class: 'la la-plus fs-2' }))

        ])
      }),
    ]

    const columnsSelectedParameter = [
      column.accessor("nama", {
        header: "Nama",
        cell: cell => h('div', [`${cell.getValue()} ${cell.row.original.keterangan ? `(${cell.row.original.keterangan})` : ''}`, h('span', { class: 'text-muted ms-3 fs-8' }, cell.row.original.jenis_parameter.nama)])
      }),
      column.accessor("titik_permohonans", {
        header: "Harga",
        cell: cell => checkParameterPaket(cell.row.original) ? h('span', { style: { 'text-decoration': 'line-through' } }, [currency(cell.getValue()[0].pivot.harga)]) : currency(cell.getValue()[0].pivot.harga)
      }),
      column.accessor("uuid", {
        header: "Aksi",
        cell: (cell) => (!titik.value?.save_parameter || titik.value.status <= 1) && h('div', { class: 'd-flex gap-2' }, [
          // h('button', { class: 'btn btn-sm btn-icon btn-info', onClick: () => addParameter(cell.getValue()) }, h('i', { class: 'la la-pencil fs-2' })),
          h('button', { class: 'btn btn-sm btn-icon btn-danger', onClick: () => removeParameter(cell.getValue()) }, h('i', { class: 'la la-trash fs-2' })),
        ])
      }),
    ]


    const { data: pakets = [] } = usePaket()
    function checkParameterPaket(param) {
      return titik?.value.pakets.find(paket => Boolean(paket.parameters.find(p => p.id == param.id)))
    }

    return {
      titik,
      pakets,
      columnsPeraturan,
      columnsParameter,
      columnsSelectedParameter,
      paginatePeraturan,
      paginateParameter,
      paginateSelectedParameter,
      selectedParameter: selectedParameter.data,
      currency,
      mapStatusPengujian,
      storeFromPaket,
      removeFromPaket
    }
  },
  data() {
    return {
      showPeraturan: false,
      showPaket: false
    }
  },
  methods: {
    send() {
      Swal.fire({
        icon: 'warning',
        title: 'Apakah Anda yakin?',
        text: "Setelah menyimpan Data, Anda tidak dapat mengubah Parameter",
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: `Batal`,
        reverseButtons: true,
        confirmButtonColor: '#5b3eff',
      }).then((result) => {
        if (result.isConfirmed) {
          block(this.$el)

          axios.post(`/permohonan/titik/${this.selected}/save-parameter`).then(res => {
            Swal.fire('Berhasil', 'Data berhasil disimpan', 'success');
            this.$emit('close')
            location.reload()
          }).finally(() => {
            unblock(this.$el)
          })
        }
      })
    },
    close() {
        this.$emit('close')
        location.reload()
    },
  }
})
</script>
