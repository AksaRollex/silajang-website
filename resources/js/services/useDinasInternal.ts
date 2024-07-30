import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useDinasInternal(options = {}) {
    return useQuery({
        queryKey: ['dinas-internal'],
        queryFn: () => axios.get("/master/user?golongan_id=2").then((res: any) => res.data.data),
        ...options
    });
}