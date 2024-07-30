import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useKelurahan(pid?: any, id?: Number, options = {}) {
    return useQuery({
        queryKey: id ? ['kelurahan', id] : ['kelurahan'],
        queryFn: () => {
            return axios.get(`/wilayah/kecamatan/${pid?.value || pid}/kelurahan${id ? `/${id}` : ''}`).then((res) => res.data.data)
        },
        ...options
    });
}