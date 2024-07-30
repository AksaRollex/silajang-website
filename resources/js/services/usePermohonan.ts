import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function usePermohonan(uuid: string | string[], options = {}) {
    return useQuery({
        queryKey: ['permohonan', uuid],
        queryFn: () => axios.get(`/permohonan/${uuid}`).then((res: any) => res.data.data),
        ...options
    });
}