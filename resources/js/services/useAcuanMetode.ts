import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useAcuanMetode(options = {}) {
    return useQuery({
        queryKey: ['acuan-metode'],
        queryFn: () => axios.get("/master/acuan-metode").then((res: any) => res.data.data),
        ...options
    });
}