import { useQuery } from "@tanstack/vue-query";
import axios from "@/libs/axios";

export function useProdukHukum(options = {}, slug: String | null | String[] = null) {
    return useQuery({
        queryKey: slug ? ["produk-hukum", slug] : ["produk-hukum"],
        queryFn: () => axios.get(slug ? `/konfigurasi/produk-hukum/${slug}` : "/konfigurasi/produk-hukum").then((res: any) => res.data.data),
        ...options
    });
}