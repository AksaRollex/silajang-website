import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function usePengawetan(options = {}) {
    return useQuery({
        queryKey: ['pengawetan'],
        queryFn: () => axios.get("/master/pengawetan").then((res: any) => res.data.data),
        ...options
    });
}