import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useJasaPengambilan(options = {}) {
    return useQuery({
        queryKey: ['jasa-pengambilan'],
        queryFn: () => axios.get("/master/jasa-pengambilan").then((res: any) => res.data.data),
        ...options
    });
}