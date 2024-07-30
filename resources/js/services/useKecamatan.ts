import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useKecamatan(pid?: any, id?: Number, options = {}) {
    return useQuery({
        queryKey: id ? ['kecamatan', id] : ['kecamatan'],
        queryFn: () => {
            return axios.get(`/wilayah/kota-kabupaten/${pid?.value || pid}/kecamatan${id ? `/${id}` : ''}`).then((res) => res.data.data)
        },
        ...options
    });
}