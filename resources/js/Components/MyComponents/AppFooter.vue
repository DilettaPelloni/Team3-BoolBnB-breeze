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
                        <p class="pb-5 text-[20px] text-white">
                            Level 13, 2 Elizabeth St,<br />Melbourne,
                            Victoria<br />3000, Australia
                        </p>
                        <p class="pb-2 text-white">
                            Opening hours: Mon - Sat: 9 AM - 6 PM
                        </p>
                    </div>
                    <div class="socialIcon">
                        <div class="cont-icon">
                            <font-awesome-icon
                                class="social-icon"
                                :icon="['fab', 'facebook-f']"
                            />
                        </div>

                        <div class="cont-icon">
                            <font-awesome-icon
                                class="social-icon"
                                :icon="['fab', 'instagram']"
                            />
                        </div>
                    </div>
                </div>
                <div class="contact text-center">
                    <div class="text pt-[50px]">
                        <h2 class="pb-[25px] text-[20px] text-white">
                            Contattaci
                        </h2>
                        <p class="text-[30px] pb-[35px] text-white">
                            +61 (0) 3 8376 6284
                        </p>
                        <a class="button" href="#">Chiama</a>
                    </div>
                </div>
                <div class="linkUtili text-right">
                    <p class="text-[20px] pb-5 pt-[50px] text-white">
                        Link Utili
                    </p>
                    <ul>
                        <li>
                            <a class="link text-white" href="#">Contattaci</a>
                        </li>
                        <li>
                            <a class="link text-white" href="#">Destinazioni</a>
                        </li>
                        <li>
                            <a class="link text-white" href="#"
                                >Privacy Policy</a
                            >
                        </li>
                        <li>
                            <a class="link text-white" href="#"
                                >Cookie Policy</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.pink-text {
    color: #fe5b5f;
    font-weight: 900;
}

.footer {
    padding-bottom: 40px;
    background-image: url("img/mappa.jpg");
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

.flex-container > * {
    flex: 1;
}

.cont-icon {
    width: 27px;
    height: 27px;
    background-color: #fe5b5f;
    border-radius: 50px;
    position: relative;
    margin-right: 10px;
    cursor: pointer;
    transition: transform 0.2s;
}

.cont-icon:hover {
    transform: scale(1.8);
}

.social-icon {
    color: #fff;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}

.socialIcon {
    display: flex;
    flex-direction: row;
}

/* bottone */
.button {
    padding: 11px 20px;
    border-radius: 50px;
    border: none;
    background-color: #fe5b5f;
    color: #fff;
    font-family: "Figtree";
    font-size: 17px;
    cursor: pointer;
    margin-top: 80px;
}

.button:hover {
    background-color: #fd4e4e;
}

.button:active {
    background-color: #fc9aa1;
    box-shadow: 0 5px #dd5b5f;
    transform: translateY(4px);
}

@media (max-width: 768px) {
    .logo img {
        margin: auto;
    }

    .contact {
        padding-bottom: 59px;
        margin-top: 36px;
    }

    .footer {
        height: auto;
    }

    .socialIcon {
        justify-content: center;
        margin-top: 20px;
    }

    .linkUtili {
        text-align: center;
    }
}
</style>
