import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useRadiusPengambilan(options = {}) {
    return useQuery({
        queryKey: ['radius-pengambilan'],
        queryFn: () => axios.get("/master/radius-pengambilan").then((res: any) => res.data.data),
        ...options
    });
}