import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useKabKota(id?: Number, options = {}) {
    return useQuery({
        queryKey: id ? ['kabkota', id] : ['kabkota'],
        queryFn: () => axios.get(`/wilayah/kota-kabupaten${id ? `/${id}` : ''}`).then((res) => res.data.data),
        ...options
    });
}