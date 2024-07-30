<template>
    <div class="row">
        <div class="col-md-8 d-block d-md-none">
            <div class="mt-5 mt-md-15">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="p-4">
                            <span style="font-size: 16px;font-weight: bold;">Note:</span>
                            <ol style="padding-left: 12px;padding-top: 10px;">
                                <li>Scan QR Code dibawah untuk menghubungkan Whatsapp Anda.</li>
                                <li>Tunggu 20-30 detik atau reload setelah Scanning untuk melihat device sudah Connected
                                    atau belum.</li>
                                <li>Jika sudah terhubung anda akan mendapatkan gambar notifikasi terhubung.</li>
                            </ol>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div id="box_phone" class="card-body"
                style="position: relative; padding-left: 0;height: 655px; overflow: hidden" align="center">
                <div style="position: absolute; z-index: 3;width: 200px;margin-top: 54px;margin-left: 30px;">
                    <h3 style="color: white; margin: 0px; font-size: 14px;font-weight: 500;" id="status">{{
                        ucfirst(wa.auth) }}</h3>
                </div>

                <div style="position: absolute;z-index: 3;width: 50px;margin-top: 60px;margin-left: 250px;">
                    <a @click="checkWhatsapp()" href="javascript:void(0);"
                        style="color: white;margin: 0px;font-size: 14px;font-weight: 500;">
                        <i :class="['icon-rotate-cw3', spin]"></i>
                    </a>
                </div>

                <div v-if="wa.auth == 'scan'"
                    style="position: absolute;z-index: 10;width: 50px;margin-top: 280px;margin-left: 170px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64">
                        <path fill="#FFF"
                            d="M6.525 43.936a29.596 29.596 0 0 1-3.039-13.075C3.494 14.568 16.755 1.313 33.05 1.313c7.904.004 15.328 3.082 20.91 8.666 5.581 5.586 8.653 13.01 8.65 20.907-.007 16.294-13.266 29.549-29.558 29.549a29.648 29.648 0 0 1-12.508-2.771L1.391 62.687l5.134-18.751z">
                        </path>
                        <path fill="#123033"
                            d="M50.801 13.135c-4.739-4.742-11.039-7.354-17.752-7.357-13.837 0-25.094 11.253-25.099 25.085a25.039 25.039 0 0 0 3.349 12.541l-3.56 12.999 13.304-3.488a25.084 25.084 0 0 0 11.996 3.054h.011c13.83 0 25.088-11.256 25.095-25.087.002-6.703-2.607-13.005-7.344-17.747zM33.05 51.733h-.008a20.866 20.866 0 0 1-10.62-2.906l-.762-.452-7.894 2.07 2.108-7.694-.497-.789a20.802 20.802 0 0 1-3.189-11.097c.004-11.496 9.361-20.85 20.87-20.85a20.73 20.73 0 0 1 14.746 6.115 20.733 20.733 0 0 1 6.104 14.752c-.006 11.497-9.363 20.851-20.858 20.851z">
                        </path>
                        <path fill="#123033"
                            d="M25.429 19.26a8.65 8.65 0 0 0-1.028.011 2.352 2.352 0 0 0-.95.255c-.221.114-.427.277-.75.582-.305.288-.481.54-.668.782a6.974 6.974 0 0 0-1.443 4.291l.001.003a8.243 8.243 0 0 0 .844 3.607c1.043 2.307 2.763 4.746 5.035 7.008a24.676 24.676 0 0 0 1.657 1.6 24.145 24.145 0 0 0 9.814 5.229s.751.179 1.391.218c.021.001.04.003.061.003a9.207 9.207 0 0 0 1.422-.033 5.086 5.086 0 0 0 2.129-.59c.423-.225.623-.337.978-.561 0 0 .11-.072.319-.23.345-.257.558-.438.845-.736.211-.22.394-.479.534-.772.2-.417.401-1.213.481-1.874.061-.505.042-.781.036-.952-.011-.275-.238-.558-.487-.678l-1.486-.668s-2.222-.967-3.581-1.587a1.278 1.278 0 0 0-.452-.104c-.341-.021-.723.068-.966.324v-.004c-.013-.001-.182.145-2.031 2.385-.102.122-.341.387-.754.362a1.086 1.086 0 0 1-.185-.029 3.402 3.402 0 0 1-.49-.17c-.316-.134-.427-.185-.643-.278l-.013-.006a15.361 15.361 0 0 1-4.013-2.556 15.88 15.88 0 0 1-.927-.885c-1.074-1.041-1.953-2.148-2.607-3.24-.035-.06-.09-.146-.15-.242-.107-.174-.225-.381-.262-.523-.095-.376.157-.678.157-.678s.622-.68.911-1.05c.278-.356.518-.704.671-.952.301-.484.39-.982.238-1.37a216.767 216.767 0 0 0-2.219-5.215c-.156-.339-.598-.589-1.005-.636a6.284 6.284 0 0 0-.414-.041">
                        </path>
                    </svg>
                </div>

                <img v-if="wa.auth == 'loading'" id="qrcode"
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAXwAAAF8CAIAAABDhZedAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyRTdDNUE1QzAwOUUxMUU5QjQ5Q0JDODBFOUFGOEY3NSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyRTdDNUE1RDAwOUUxMUU5QjQ5Q0JDODBFOUFGOEY3NSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJFN0M1QTVBMDA5RTExRTlCNDlDQkM4MEU5QUY4Rjc1IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjJFN0M1QTVCMDA5RTExRTlCNDlDQkM4MEU5QUY4Rjc1Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+2Q4aqQAAB/5JREFUeNrs221o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"
                    style="position: absolute;z-index: 9;width: 250px;margin-top: 188px;margin-left: 25px;">
                <img v-else-if="wa.auth == 'connected'" id="qrcode"
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAXwAAAF8CAIAAABDhZedAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1MUIwNkYzNzA4QjExMUU5OEQ0QkZEMkM0NkVGMERBNiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1MUIwNkYzODA4QjExMUU5OEQ0QkZEMkM0NkVGMERBNiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjUxQjA2RjM1MDhCMTExRTk4RDRCRkQyQzQ2RUYwREE2IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjUxQjA2RjM2MDhCMTExRTk4RDRCRkQyQzQ2RUYwREE2Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Oqt8wAAAFIBJREFUeNrs3Qt0XGWBwPE7SdM0afpIX5TSUh4F1p6CIFWQFcVXFcEjCgIiyFHkcZAioAjtQncVaEVZQFoQUV4iirioyEEXWBEXlIeAQFkEoZW+0pY2tKRp0rxm9ktuenM7k7YZoSFpf78DPZPJndfNzL/f982dNJPL5SKA3lJiFwCiA4gOgOgAogMgOoDoAKIDIDqA6ACIDiA6AKIDiA4gOgCiA4gOgOgAogMgOoDoAKIDIDqA6ACIDiA6gOgAiA4gOgCiA4gOgOgAogOIDoDoAKIDIDqA6ACIDiA6gOgAiA4gOgCiA4gOgOgAogOIDoDoAKIDIDqA6ACiAyA6gOgAiA4gOgCiA4gOIDoAogOIDoDoAKIDIDqA6ACiAyA6gOgAiA4gOoDoAIgOIDoAogOIDoDoAKIDiA6A6ACiAyA6gOgAiA4gOoDoAIgOIDoAogP9WC4nOkAvymREB0B0ANEBEB1AdADRARAdQHQARAcQHQDRAUQHEB0A0QFEB0B0ANEBEB1AdADRARAdQHQARAcQHQDRAUQHEB0A0QFEB0B0ANEBRAdAdADRARAdQHQARAcQHUB0ALaVAXYB/Vc2F/32mej+Z6Olr0eDy6P9d4uOe280foQd06dlcrmcvUB/tHh1dMoN0fzFm5xZXhbNPCo6/cN2j+jAW+rFmujYq6PX6rr/7qyjozM/aieJDrxFnlscHfe9aM36zW5QVho98s1o4ii7qi+ykEw/88SC6JirtlScoKUt+skjdlUfZSGZ/uThF6OTvx81NG19y78ssLdEB96cB+ZHX74hamrp0cb1G+ww0YE34Z6nojNvjlpae7r9uGr7rI+ypkM/cOdj0Rk3FlGc4MNT7DbRgX/KrX+Mzrk1assWcZHxI9qPEkR0oGjXPxDNuKO44zqqBkU3nRENKrPz+ihrOvRd196Xu+yXHacyuUz4vwcXGVYZ3X5WtN+udl7f5eBA+qgr7s5d/dv2Z2cuyoQvc5mOp+sWLzJ8cHTH9PZPYCE6UITwlPzmndkbf59rz00m6mF3xgyN7jwn+pdx9p/oQDHastGFt2Xv/FM8xomS7sS52Vx3xo+IfnFutPto+090oMjinH9L2y8f7XhSZjLdd2fjtxJ77hT94hwH5ogOFKmlNTr7htb7ns7l2hOT6WF39hrbPsYZO8z+Ex0oRmNzdOa8lodf6Fw5LuxO1HnmJt2Zsmv087OjEVX2n+hAMRqaojPmNj/6t/anYq6zMunubDyxaXfePSm67azM0Ar7r59xnA5vs7r1uVOvbn5mQahNHJhQmEx7djoPzYkzk+sY8uQ6jtdp/94he2du+UqmapD9Z6QDxXi9LnfKFU0vLu2aVW18l2qT8U4Ur+x0ruNkPrRf5genZxxzbKQDxVm1Nnfqdze8XNORmqhjXNM1utlkvBN/EZ955NTomlMyA0rtv/7KZ6/6n5bmXH1dW38foS5dlT35ssaFy7KZ9ner2jOTyaX+7BiEp8/vyFJ07Hszc79cojimV/SGbDZ65PdvPHjv2sULm8IPbWB5Zr8DBx953MiJe5T3u8fy6vLs6Zc3rFwTJavF8dQp2/nWeCbv/PicEw8r/dYJJR1jHkSHbay5KXftnJrnnsr/zcAlpZkTTx/zwcP702EqLy9pO/Pyhtq6XEdQuu9L4fmnfrz0gqNLFWc7YE2nf7hl3srC4rQPf9pyP75uZUtzdtqn+scBuf+3oO3sK9a/UR9KEi/cxB9t6Fi0yXvfKrW+89WjBkz/pDmV6NBbFr604dGH6rawwc9+tCr82fe788xLreddsb5+Q/y+dxKaKNrky026E0Y53zi27EsfUxzRoRc9/vC6rW7T97vzxPyWC6+sb2zpWLZJv0W1+e6UlOQuPmng8YcpjujQu5Yvbe7JZn25O4881Xzx3Prm9uJEJe1hyWS76U7H0Tgbu1NakrvkS+Wf+lfFER16Xc9XT0N3WlpyRxwzok/d/wcfbbr0unWtbZnUMcdRSS7Kdj/AaX/AZaW5b58xaNpUxdkOOU6nHxg/sYg3xf/r1tX3372m79z5/35ow2Xz6tpac51H3OS6jsEpyeVK0ofkbDwwZ9CA3NXTFUd0ePsc/IEhRb1VHMY7faQ7v76v4Yof1OXaQlziphQkpqA7gwdl5p1X8f53Ko7o8PaZsHv5YR8v7kicvtCdn9+9/tqb6qKuuLQPbTq6kyvsTlyloZWZ675e8Z7JiiM6vN1OOG3MvgcO7kfd+fHP1910e12mYIBT0vXhhrxRT27EkMz1F1a+cy/F2c45IrnfaG1tPyj5mSfWF3WpY04e1cvryuEJdeNtdXfdU995hHHXccapjzsUnFk9rGTuhVV7TlAc0UF3iizOD29+4ze/q8+mP9nQXXfCn9mNZ44ZWXLNzKETxhp3iw66U4xsNpr3/df/5w8NG8vSkZVMt5+r6urO2NGl3/u3YePGKI7ooDtF3qurrq7906ONmw5wUpOp7rqz6/gB/zlj2OgRiiM66E4xWlpyV165+vHHG/M/Mr6xO52TqU27M2n3su/MGDZ8qOKIDrpTjKYNue98+7Vnn9uQ9wvVC7uTXkLee1LZ5TOGD6lSHNFBd4rR0JCdc8nKF19sSv1zMd12p2tKFbqz7+SBl3yjurLCb8cRHXSnGOvrs3O+ueLll5u6fn16D7oz9YDyi75WXT5QcUQH3SnGG2vbZs9avnhx88a49Kg7B02tmHFedVmZ4ogOulOM2lWts2fVLK9piTaJy1a684FDB597VnWpAwBFx17QnaKsfq1lzkU1K1e2bvoP/nZ2p9t/uCqcnjat6szTqv2SY0RHd4rrzvKlzd++eNnrtW2pEU3Snc3+g3mHHz7k1FMUB9HRnSK7s2hh03dnLaur6yhO50wq/x8aL+zOUZ8edtJJw/10EB3dKa47r7684Yp/X1a/LrtxGrVJd6KuyVTHlxtjdNwJ1cd8dpifC6KjO8V156XnG793ybLGhmznoKYH3cmURF/40shPHDnUTwTR0Z3iujP/qfXzZtc0N3c+VZLuRMm4puPMXKarO6E4p545+oMfGeJngejoTnHdCddw3eU1Lc2bPE+23J2S0pLTzh596GFVfgqIju4U153H/3fdD69a0dbazZNkc90pLSuZfv5OUw8ebP8jOrpTXHf+eN8bt167cgtPkMLuDCzPnDNz530PqLTnEZ0dV5gZzZ1dM/+p4rpz4Hurnn6sfqvPjlznn+1vV1VUlpw3a5e9Jw+yzxEd451/ZrzTQ/ETqLKq9Gv/scue+ygOosO2786Q4aXnXzJ+wm7l9jOiwzbvzvARA75+yfhddh1oDyM6bPPujBpTdv6l48fsXGbfIjps8+7sPH5gKE71yAH2KqLDNu/OrnuUf/1b44cM89txKI5fi70jGjAg85UZ4/Z/zz9//N5uew0KYxzFwUiH3hjv7DOl4qsX71JR6W8sRIdt3519Dxx81sxxA/1adUSHXuhOmJGdecG4MsVBdOiF7hz0/iGnnju2dIDiIDps++584GPDTv7KTn7JMaLDW6alOXfDlSue/NO6wm994pgRx3xhlOIgOrzFwnPh0YfqHvjN2kULNoTTJaWZvSdXHPHZEVP8qgpEh22quSm3fl1b1dBSa8aIDtC/Ob4LEB1AdABEBxAdANEBRAcQHQDRAUQHQHQA0QEQHUB0ANEBEB1AdABEBxAdANEBRAcQHQDRAUQHQHQA0QFEB6DXDLAL+rgNjdkXnqtfsqhp0YKm8OXEPcv3ekfF5H2r7JktePrxutrVLeFERWXp+z443A4RHXrqkT+svfOm1evWZpNz/vrnhihas/eU8i9OHzt2XPn29GDXrmm56yerwolTpo97k1d11221NYvaozNkeInomF7RUz+7eeWNV76WLk7i7883zb5gSRgEbTcP9oF7a2edveiR++tH7VT25seGcXGCSZMHeSKJDj19Ed7/yzfS54S/tNNfhhj96o5V282D/en1tXFeJ0x8s8O3ha80JKffsV+F55LpFT2aaIQXYfLlAYdUfuTI4fE6Tvz6jM9/9MF1n/viTulLPf/M+saGtngtY8r+g4dXl+Vd7Zra1vj07pMq/vFK47IlTWH7dx8yNL1lGCksX9YUn955l/JwqZolTbWrW/Y9oKpwQhc2Di/yZYs7t+92m2BFTdP8v9bHp3fZtTxZk4pv62/PNSZbNjRkw8bJlaQvOHJU2bsOGlp45S/Mr4/vQHjUUw8emtyZ+LY8nUSHrfvdr19PTu89pfy0c8YNqugc5hz6oep77lgTDwqSmVd46d7+oxVhbpJ3PdM+M+zTx49OLhuuNhk9hZB1LA+1CxV737SqZCXlycfqwrQuufUwldt4fbXjJpZdNm/35Pqffrzulnl5E8Dao06q/tSxo9O5uXnuitSVdF5tvCYVgvXdmTXpb4WbDvft7BnjQ+x+fP3K5E7Gxk2snT5zXDpJeVd+5/DVQ4aVdm0/XnREhx4IQ5jk9PGnjEmqEYTTMy+f0NiQrR45IB6ehOJc9a0lea/qWJyYZDT06t83JN/KezGHYB19Ykt8hUtebUovHqU3q1nUEkITDzfCibmXrii80V/ftqZycMlHjxgZR2H2BUsKl6XC1YZYzJgzMT0qSc+JQnFmnb2o8ILhDsydXROHLzzwcDpZvklmncmlQiLzxnpY0yHqdiaSftmEeVDeBuHv+XBm8nL61R2r0mkIY5bwX7o74QoLCzJkeEkYkoQxRXLOX/5cF594/qmGvOFS+K+rVk/UxzO1dHHibZJVp4d+VxdHIV2c8FjCLSbbhDsT5nfxqCc1kCkLd2nSPpVhjJO+4AlnjAx/Jt0J86lw4r57atPFCY86b9lrj30Mc4x06IEwiklOTzmwcqurP+n15vNnj4uXS0bttCqMOOIz5/+1PnQqfoUnwnApnBlevXlDnvRbP8H0i8aGcU36VtbXZ/MmgKEI8bgmGVuFa4gXmNLhiIcnEyaWJ7V65aWG+IJJDT9/+uhw/0Mlk3uVXHDfA6pmnL4oPjOMj/aYVJk8wNCaM74xNlww3Oi5X/hHcsd23UN0RIceWLakazwyasxWfkAL/96Y/qs+WaDd711VyWsyeYWnMxEvixSuuSZLyPH4JZ5J1SxtSs998iaATz5SH68Er1zWVas1ta1PP9a1xvTlc8bGJybvVzXrqgk771KezBnTq8jxEkyychy7Zs7Swgf+wnNd23zy+Or4gYfRX3oRKoyYtu+nSi4XZTKiw5s2YtSWfih337lq0YKmiXuWVw4uOfRD1fFxt7F9pnS9xhob2/IuuHhhVzjCqKHwzPgFn27TPpMrkpFFXpvSqy3dLieFCWB6DJVMEkNr8iaMr7ywIRmwxHPG1a+1phdx8lZtYukHno5L/bquOxbStn0/VfpjcUSnL6qoKE0PIpKZS9Tx3nA8folfz0k7Cmv17JPrk9MjR7W/khe+1JS8tpN3f559oiHvBZ/O0B57V2xuMFKUZNUmzN0efnBNyFZ4jHF6woQo6dc739PZjlUrWrayiypL4yMDYtUjBxTODcO8LL0Aj+gYkW5W+u/nMIh44N7aMKIJr59QnOu/07V2e8AhlaEdNam5WAhNPMv4xyuN6YWe0I5uD9JNv+CTM9NtStaqk8FI4ftByZrLipqme++qrawqDVPCdx+yydE0y5d23vR999Qmk754JSg9cUuWYMIMLhklJatUYT+E9oVvxUfrhC/Tc8x3HdR+r27/0YqeL4d5JotO741I+/hPK/TlfdOqkoNufnp9+9GAIQF57x8fe/Lo9GAk6ljEbahvW1+fTc9rpn1mWMhEehU5OUi3cKWm/TjALbYpeT8ouYdh+5/dvDLM9dJLSPHHLJNDgcLFr5mzdHBVSfpIonhOlJ64dYyn2gvb8a3Optz+g1WHH9368P1vxJO4cIUhcyE64SaSC94y77Uli5pWr2xJX/+E3cq374j00+LsoNOrvt+do08cHSY+6crkFWf6RZ2f9gxBCVlJxjV5xweGec2njx+dt1KTHKSbfsHHCSjMUN6ZyWDkiKNHJreV93GNcKNTD24f6XzkyOFJ/vLeIzvqpOp4ehVP/ZJtwn/hnoRvJcEKUUuOVIx9/vT2RzRl/8HpnZO3at7+MCeUb8fF6dd20Elv3J0+K6Rk5uUTkiNT8qYzs66akP40wOe+uFP6OJr0/OvcWRPidY1uF2XSZ8ZzusIMbe7MkLwQvrzjYvJuNEyLQlwK71j6kOXwQPIeZhyj084Zlz6GKJnxhRtN3qgKp7ewDwuPb+rjT8gd6NWX68svvh3e04/XJb9JJww90p9ayhMmUGE4E3ckbBmPF5LvJp9OCpKV6cIz0x90iheSNndmbENj9snH6pa82rRqRcvm7l588XDHwvQqDJTyPucVT9/+8ue6sMHosWX7TK5I9zTcw5f/1hgefvhWmC6FAVTe2nC47B8fWBs2iG89SaRfoyM6ANvj9Eo/QXRMjIHtNzqA6ACIDiA6gOj0e97MAtHpVd7MAtEBRGfHYKoFomOqBaIDIDqA6ACIDiA6AKIDiA4gOgCiA4gOgOiQ5nNniA69qtjPnYkUokOfjhSIDiA6YGaH6GBmh+hg2ILogGELogOIDmZJJmL0YAic8wMHjHQwMkJ0oGeDZ+vHiA4gOpg3ITpg3oToAKIDZmqIDmZqiA6A6ACiA4gObAvWjxEdepX1Y0QHEB3MgBAdzIBAdADRARAdQHQA0QEQHUB02LE4bAfRoVc5bAfRAUQHQHQA0QEQHYrk/SxEh17l/SxEBxAdANEBRAcQHQDRAUQHQHQA0QEQHUB0ANEBEB1AdABEBxAdANEBRAcQHQDRAUQHQHQA0QFEB0B0ANEBEB1AdABEBxAdQHQARAcQHQDRAUQHQHQA0QFEB0B0ANEBEB1AdADRARAdQHQARAcQHQDRAUQHEB0A0QFEB0B0ANEBEB1AdADRARAdQHQARAcQHQDRAUQHEB0A0QFEB0B0ANEBRAdAdADRARAdQHQAuvf/AgwABij/AEYuytQAAAAASUVORK5CYII="
                    style="position: absolute;z-index: 9;width: 250px;margin-top: 188px;margin-left: 25px;">
                <img v-else-if="wa.auth == 'scan'" id="qrcode" :src="wa.data"
                    style="position: absolute;z-index: 9;width: 250px;margin-top: 188px;margin-left: 25px;">
                <img id="phone_device" src="/media/frame.png"
                    style="position: relative; z-index: 2; height: 600px; border-radius: 10px;">
            </div>
        </div>
        <div class="col-md-8 d-none d-md-block">
            <div class="mt-5 mt-md-15">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="p-4">
                            <span style="font-size: 16px;font-weight: bold;">Note:</span>
                            <ol style="padding-left: 12px;padding-top: 10px;">
                                <li>Scan QR Code disamping untuk menghubungkan Whatsapp Anda.</li>
                                <li>Tunggu 20-30 detik atau reload setelah Scanning untuk melihat device sudah Connected
                                    atau belum.</li>
                                <li>Jika sudah terhubung anda akan mendapatkan gambar notifikasi terhubung.</li>
                            </ol>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
@keyframes fa-spin {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }
}

.fa-spin {
    -webkit-animation: fa-spin 2s infinite linear;
    animation: fa-spin 2s infinite linear;
}

.slow-spin {
    -webkit-animation: fa-spin 6s infinite linear;
    animation: fa-spin 6s infinite linear;
}
</style>

<script lang="ts">
import axios from '@/libs/axios'
import { ucfirst } from '@/libs/utils'
import { defineComponent, ref } from 'vue'

export default defineComponent({
    setup() {
        const wa = ref<any>({
            auth: 'loading'
        })
        const spin = ref<string>('')

        return {
            wa,
            spin,
            ucfirst
        }
    },
    methods: {
        checkWhatsapp() {
            this.spin = 'spinner'
            axios.get('/auth/whatsapp')
                .then(res => {
                    this.wa = res.data
                })
                .finally(() => {
                    this.spin = ''

                    setTimeout(() => {
                        this.checkWhatsapp()
                    }, 10000);
                })
        }
    },
    mounted() {
        this.checkWhatsapp()
    }
})
</script>
