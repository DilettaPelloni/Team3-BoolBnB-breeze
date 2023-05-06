<script>
export default {
    name: "AppFooter",
};
</script>

<template>
    <div class="footer pb-[40px] w-full bg-no-repeat bg-cover">
        <div class="container">
            <div class="flex-container flex flex-col text-center 2xl:justify-between xl:justify-between lg:justify-between md:justify-center sm:justify-center 2xl:flex-row xl:flex-row lg:flex-row md:flex-col sm:flex-col 2xl:text-left xl:text-left lg:text-left md:text-center sm:text-center">
                <div class="logo">
                    <img src="/img/LogoBoolBnB.png" alt="Logo BoolBnB"
                        class="object-contain w-[230px] pb-5 2xl:ms-0 xl:ms-0 lg:ms-0 m-auto" />

                    <div class="text text-white">
                        <p class="pb-5 text-[20px]">
                            Viale Booleaner 4<br />Milano,
                            Lombardia<br />20100, Italia
                        </p>
                        <p class="pb-2">
                            Orari di apertura: Lun - Ven: 9 AM - 6 PM
                        </p>
                    </div>
                    <div class="socialIcon text-white flex justify-center 2xl:justify-start xl:justify-start lg:justify-start md:justify-center">
                        <div class="cont-icon cursor-pointer">
                            <font-awesome-icon class="social-icon me-5" :icon="['fab', 'facebook-f']" />
                        </div>

                        <div class="cont-icon cursor-pointer">
                            <font-awesome-icon class="social-icon" :icon="['fab', 'instagram']" />
                        </div>
                    </div>
                </div>
                <div class="contact text-center">
                    <div class="text pt-[50px] text-white">
                        <h2 class="pb-[25px] text-[20px]">
                            Contattaci
                        </h2>
                        <p class="text-[30px] pb-[35px]">
                            +39 334 837 662842
                        </p>
                        <a class="button py-[11px] px-[20px] rounded-full bg-mainColor-300 text-white text-lg cursor-pointer mt-[80px] hover:bg-[#fd4e4e]" href="tel:+39334837662842">Chiama</a>
                    </div>
                </div>
                <div class="linkUtili text-center 2xl:text-end lg:text-end md:text-center md:m-auto sm:text-center m-auto text-white">
                    <p class="text-[20px] pb-5 pt-[50px]">
                        Link Utili
                    </p>
                    <ul>
                        <li>
                            <a class="link text-white hover:text-mainColor-300" href="#">Contattaci</a>
                        </li>
                        <li>
                            <a class="link text-white hover:text-mainColor-300" href="#">Destinazioni</a>
                        </li>
                        <li>
                            <a class="link text-white hover:text-mainColor-300" href="#">Privacy Policy</a>
                        </li>
                        <li>
                            <a class="link text-white hover:text-mainColor-300" href="#">Cookie Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.footer {
    background-image: url("img/mappa.jpg");
    background-position: 41% 11%;
}
.flex-container>* {
    flex: 1;
}
</style>
