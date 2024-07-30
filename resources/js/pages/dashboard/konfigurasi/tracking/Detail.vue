<template>
    <div class="card">
        <div class="card-header align-items-center">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-light-danger btn-icon me-4" @click="$emit('close')">
                    <i class="la la-arrow-left fs-2"></i>
                </button>
                <h2 class="mb-0">({{ $props.selected?.kode }}) {{ $props.selected?.lokasi }}</h2>
            </div>
        </div>
        <div class="card-body d-flex flex-column gap-10">
            <div v-for="tracking in selected.trackings" :key="tracking.id"
                class="d-flex gap-4 align-items-center tracking-item">
                <div class="rounded-circle bg-light-primary d-flex justify-content-center align-items-center w-50px h-50px">
                    <i :class="`fs-1 text-primary ${icon(tracking.status)}`"></i>
                </div>
                <div>
                    <div class="text-muted">{{ moment(tracking.created_at).format('DD MMMM YYYY, HH:mm') }}</div>
                    <h4>{{ mapStatusPengujian(tracking.status) }}</h4>

                    <ul v-if="tracking.status == 3">
                        <template v-for="param in selected.parameters" :key="param.id">
                            <li v-if="param.is_dapat_diuji">
                                {{ param.nama }} {{ param.keterangan ? `(${param.keterangan})` : '' }}
                                <span class="badge badge-success" v-if="param.pivot?.acc_analis">Sudah Diuji</span>
                                <span class="badge badge-light-warning" v-else>Belum Diuji</span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.tracking-item {
    position: relative;

    &>* {
        position: relative;
        z-index: 1;
    }

    &:not(:last-child):before {
        content: '';
        position: absolute;
        top: 0;
        z-index: 0;
        left: 21px;
        width: 8px;
        height: calc(100% + 2.5rem);
        background-color: #f4f1ff;
    }
}
</style>

<script lang="ts">
import { defineComponent } from 'vue'
import moment from 'moment';
import { mapStatusPengujian } from '@/libs/utils';

export default defineComponent({
    props: {
        selected: {
            type: Object as () => any,
            required: true,
        },
    },
    setup() {
        return {
            moment,
            mapStatusPengujian,
        }
    },
    methods: {
        icon(status) {
            switch (status) {
                case -1:
                    return 'la la-exclamation-circle';
                    break;

                case 0:
                    return 'la la-envelope-square';
                    break;

                case 1:
                    return 'la la-archive';
                    break;

                case 2:
                    return 'la la-folder-open';
                    break;

                case 3:
                    return 'la la-prescription-bottle';
                    break;

                case 4:
                    return 'la la-clipboard-check';
                    break;

                case 5:
                    return 'la la-file-alt';
                    break;

                case 6:
                    return 'la la-pen-nib';
                    break;

                case 7:
                    return 'la la-spell-check';
                    break;

                case 8:
                    return 'la la-wallet';
                    break;

                case 9:
                    return 'la la-print';
                    break;

                case 10:
                    return 'la la-tablet';
                    break;

                case 11:
                    return 'la la-check-double';
                    break;

                default:
                    break;
            }
        }
    }
})
</script>
