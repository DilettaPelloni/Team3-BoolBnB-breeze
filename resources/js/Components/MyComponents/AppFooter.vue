<script>
export default {
    name: "AppFooter",
};
</script>

<template>
    <div class="footer">
        <div class="container">
            <div
                class="flex-container flex align-middle 2xl:justify-between xl:justify-between lg:justify-between md:justify-center sm:justify-center 2xl:flex-row xl:flex-row lg:flex-row md:flex-col sm:flex-col 2xl:text-left xl:text-left lg:text-left md:text-center sm:text-center"
            >
                <div class="logo">
                    <img
                        src="/img/LogoBoolBnB.png"
                        alt="Logo BoolBnB"
                        class="object-contain w-[230px] pb-5"
                    />

                    <div class="text">
                        <p class="pb-5 text-[20px]">
                            Level 13, 2 Elizabeth St,<br />Melbourne,
                            Victoria<br />3000, Australia
                        </p>
                        <p class="pb-2">
                            Opening hours: Mon - Sat: 9 AM - 6 PM
                        </p>
                    </div>
                    <div class="socialIcon">
                        <font-awesome-icon :icon="['fab', 'facebook-f']" />
                        <font-awesome-icon :icon="['fab', 'instagram']" />
                        <font-awesome-icon :icon="['fab', 'pinterest-p']" />
                    </div>
                </div>
                <div class="contact text-center">
                    <div class="text pt-[50px]">
                        <h2 class="pb-[25px] text-[20px]">Contattaci</h2>
                        <p class="text-[30px] pink-text pb-[35px]">
                            +61 (0) 3 8376 6284
                        </p>
                        <a class="button" href="#">Chiama</a>
                    </div>
                </div>
                <div class="linkUtili">
                    <p class="text-[20px] pb-5 pt-[50px]">Link Utili</p>
                    <ul>
                        <li><a class="link" href="#">Contattaci</a></li>
                        <li><a class="link" href="#">Destinazioni</a></li>
                        <li><a class="link" href="#">Privacy Policy</a></li>
                        <li><a class="link" href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.button {
    background-color: #fe5b5f;
    padding: 10px 25px;
    color: #fff;
    border-radius: 50px;
    cursor: pointer;
}

.pink-text {
    color: #fe5b5f;
    font-weight: 900;
}

.footer {
    padding-bottom: 40px;

    height: 355px;
    width: 100%;
    background-position: 41% 11%;
    background-repeat: no-repeat;
    background-size: cover;
}
.logo {
    display: block;
}

.link:hover {
    color: #fe5b5f;
}

@media (max-width: 768px) {
    .logo img {
        margin: auto;
    }

    .contact {
        background-color: #ffeeee;
        padding-bottom: 59px;
        margin-top: 36px;
    }
}
</style>
