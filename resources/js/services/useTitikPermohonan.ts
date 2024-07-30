import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useTitikPermohonan(uuid: string | string[], options = {}) {
    return useQuery({
        queryKey: ['permohonan', 'titik', uuid],
        queryFn: () => axios.get(`/permohonan/titik/${uuid}`).then((res: any) => res.data.data),
        ...options
    });
}