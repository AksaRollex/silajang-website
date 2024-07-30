import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useJenisParameter(options = {}) {
    return useQuery({
        queryKey: ['jenis-parameter'],
        queryFn: () => axios.get("/master/jenis-parameter").then((res: any) => res.data.data),
        ...options
    });
}