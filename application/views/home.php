<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .div {
        background-color: #fff;
        display: flex;
        flex-direction: column;
    }

    .div-2 {
        background: linear-gradient(243deg, #1c66be 0%, #02f0f0 94.74%);
        align-self: stretch;
        display: flex;
        width: 100%;
        padding-top: 40px;
        padding-right: 20px;
        padding-bottom: 40px;
        padding-left: 20px;
        flex-direction: column;
    }

    @media (max-width: 991px) {
        .div-2 {
            max-width: 100%;
        }
    }

    .div-3 {
        align-self: center;
        margin-top: 194px;
        margin-bottom: 127px;
        width: 100%;
        max-width: 1222px;
    }

    @media (max-width: 991px) {
        .div-3 {
            max-width: 100%;
        }
    }

    .div-4 {
        gap: 20px;
        display: flex;
    }

    @media (max-width: 991px) {
        .div-4 {
            flex-direction: column;
            align-items: stretch;
            gap: 0px;
        }
    }

    .column {
        display: flex;
        flex-direction: column;
        line-height: normal;
        width: 63%;
        margin-left: 0px;
    }

    @media (max-width: 991px) {
        .column {
            width: 100%;
        }
    }

    .div-5 {
        display: flex;
        margin-top: auto;
        margin-bottom: auto;
        flex-direction: column;
    }

    @media (max-width: 991px) {
        .div-5 {
            max-width: 100%;
            margin-top: 50px;
        }
    }

    .div-6 {
        color: #fff;
        font-family: Rockabye, sans-serif;
        font-size: 70px;
        font-weight: 400;
        align-self: start;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .div-6 {
            font-size: 40px;
            white-space: initial;
        }
    }

    .div-7 {
        color: #090909;
        font-family: Roboto, sans-serif;
        font-size: 30px;
        font-weight: 400;
        align-self: start;
        margin-top: 23px;
        width: 716px;
        max-width: 100%;
    }

    .div-8 {
        color: #090909;
        font-family: Roboto, sans-serif;
        font-size: 20px;
        font-weight: 400;
        align-self: start;
        margin-top: 50px;
        width: 716px;
        max-width: 100%;
    }

    .img {
        aspect-ratio: 87.13;
        object-fit: cover;
        object-position: center;
        width: 697px;
        stroke-width: 8px;
        stroke: #fff;
        overflow: hidden;
        align-self: start;
        margin-top: 36px;
    }

    @media (max-width: 991px) {
        .img {
            max-width: 100%;
        }
    }

    .column-2 {
        display: flex;
        flex-direction: column;
        line-height: normal;
        width: 37%;
        margin-left: 20px;
    }

    @media (max-width: 991px) {
        .column-2 {
            width: 100%;
        }
    }

    .div-9 {
        border-radius: 20px;
        background-color: #fffdfd;
        display: flex;
        margin-left: auto;
        margin-right: auto;
        width: 413px;
        max-width: 100%;
        flex-grow: 1;
        padding-top: 34px;
        padding-right: 15px;
        padding-bottom: 40px;
        padding-left: 20px;
        flex-direction: column;
    }

    @media (max-width: 991px) {
        .div-9 {
            margin-top: 50px;
        }
    }

    .img-2 {
        aspect-ratio: 1;
        object-fit: cover;
        object-position: center;
        width: 92px;
        overflow: hidden;
        align-self: center;
        margin-left: 8px;
    }

    .div-10 {
        color: #010000;
        font-family: Montserrat, sans-serif;
        font-size: 40px;
        font-weight: 400;
        align-self: center;
        margin-top: 9px;
        margin-left: 6px;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .div-10 {
            white-space: initial;
        }
    }

    .div-11 {
        border-radius: 100px;
        background-color: var(--, #d9d9d9);
        align-self: stretch;
        display: flex;
        margin-top: 33px;
        margin-left: 3px;
        margin-right: 4px;
        width: 100%;
        padding-top: 18px;
        padding-right: 20px;
        padding-bottom: 18px;
        padding-left: 20px;
        flex-direction: column;
    }

    .div-12 {
        color: rgba(0, 0, 0, 0.45);
        font-family: Montserrat, sans-serif;
        font-size: 20px;
        font-weight: 400;
        align-self: center;
        margin-top: 1px;
        margin-left: 9px;
        margin-bottom: -1px;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .div-12 {
            white-space: initial;
        }
    }

    .div-13 {
        border-radius: 100px;
        background-color: var(--, #d9d9d9);
        align-self: stretch;
        display: flex;
        margin-top: 46px;
        margin-left: 3px;
        margin-right: 4px;
        width: 100%;
        padding-top: 24px;
        padding-right: 20px;
        padding-bottom: 16px;
        padding-left: 20px;
        flex-direction: column;
    }

    .div-14 {
        color: rgba(0, 0, 0, 0.45);
        font-family: Montserrat, sans-serif;
        font-size: 20px;
        font-weight: 400;
        align-self: center;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .div-14 {
            white-space: initial;
        }
    }

    .div-15 {
        border-radius: 100px;
        background-color: var(--, #d9d9d9);
        align-self: stretch;
        display: flex;
        margin-top: 19px;
        margin-left: 7px;
        width: 100%;
        padding-top: 18px;
        padding-right: 20px;
        padding-bottom: 18px;
        padding-left: 20px;
        flex-direction: column;
    }

    .div-16 {
        color: rgba(0, 0, 0, 0.45);
        font-family: Montserrat, sans-serif;
        font-size: 20px;
        font-weight: 400;
        align-self: center;
        margin-top: 2px;
        margin-bottom: -2px;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .div-16 {
            white-space: initial;
        }
    }

    .div-17 {
        color: rgba(0, 0, 0, 0.45);
        font-family: Montserrat, sans-serif;
        font-size: 20px;
        font-weight: 400;
        align-self: center;
        white-space: nowrap;
        border-radius: 100px;
        background-color: var(--toska-agak-tua, #0ac2c2);
        margin-top: 35px;
        margin-bottom: 30px;
        width: 111px;
        max-width: 100%;
        padding-top: 14px;
        padding-right: 20px;
        padding-bottom: 12px;
        padding-left: 20px;
    }

    @media (max-width: 991px) {
        .div-17 {
            white-space: initial;
        }
    }
</style>

<body>
    <div class="div">
        <div class="div-2">
            <div class="div-3">
                <div class="div-4">
                    <div class="column">
                        <div class="div-5">
                            <div class="div-6">Selamat Datang</div>
                            <div class="div-7">
                                di sistem Informasi Akademik SMP Al-ghuroba’
                            </div>
                            <div class="div-8">
                                Kami dengan senang hati menyambut Anda di Sistem Informasi
                                Akademik berbasis website Sekolah Menengah Pertama Al-Ghuroba'.
                                Sistem ini didesain untuk memberikan kemudahan akses kepada
                                seluruh stakeholder pendidikan, termasuk siswa, orang tua, guru,
                                dan staf sekolah. Tujuan utama dari sistem ini adalah untuk
                                memfasilitasi manajemen data akademik, melacak perkembangan siswa,
                                dan meningkatkan komunikasi antara semua pihak yang terlibat dalam
                                proses pendidikan.
                            </div>
                            <img loading="lazy" srcset="..." class="img" />
                        </div>
                    </div>
                    <div class="column-2">
                        <div class="div-9">
                            <img loading="lazy" srcset="..." class="img-2" />
                            <div class="div-10">Silahkan Login</div>
                            <div class="div-11">
                                <div class="div-12">Silahkan pilih user</div>
                            </div>
                            <div class="div-13">
                                <div class="div-14">Masukkan username</div>
                            </div>
                            <div class="div-15">
                                <div class="div-16">Masukkan password</div>
                            </div>
                            <div class="div-17">LOGIN</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>