<script>
import { Link } from "@inertiajs/vue3";
export default {
    name: "AppHeader",
    components: {
        Link,
    },
    data() {
        return {
            menuVisibility: false,
        };
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    },
    methods: {
        toggleVisibilty() {
            this.menuVisibility = !this.menuVisibility;
        },
    },
};
</script>

<template>
    <div
        class="container-header flex justify-between items-center py-[5px] px-[185px] 2xl:flex-row xl:flex-row lg:flex-row md:flex-col sm:flex-col"
    >
        <div class="container-img h-[50px] w-[250px]">
            <img
                src="/img/LogoBoolBnB.png"
                alt="Logo BoolBnB"
                class="object-contain h-full"
            />
        </div>
        <div class="flex flex-col">
            <div class="container-login ml-5 relative">
                <font-awesome-icon
                    :icon="['fas', 'bars']"
                    @click="toggleVisibilty"
                />
                <font-awesome-icon
                    :icon="['fas', 'circle-user']"
                    style="color: rgb(254 91 95 / 78%); padding-left: 9px"
                    size="2xl"
                    @click="toggleVisibilty"
                />
                <!-- <font-awesome-icon :icon="['fas', 'bars']" /> -->
                <div
                    class="absolute z-50 rounded-md shadow-lg w-48 origin-top-right right-0 text-right p-3 bg-white mt-3"
                    v-if="menuVisibility"
                    id="loginMenu"
                >
                    <!-- menu login -->
                    <div v-if="canLogin">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="font-semibold text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="font-semibold text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="ml-4 font-semibold text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                Register
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-jumbotron">
        <h1 class="text-center">Quale sarà la tua prossima meta?</h1>
        <h2 class="text-center">Scegli subito la tua destinazione!</h2>
        <button class="button">Cerca la tua meta</button>
    </div>
</template>

<style lang="scss" scoped>
@import "../../../scss/app.scss";
#loginMenu a:hover {
    color: $main-color;
}

.container-login {
    border: 1px solid #c9c9c9;
    padding: 4px 14px;
    border-radius: 57px;
}

.container-login:hover {
    box-shadow: 3px 3px 10px 0px rgba(117, 117, 117, 0.35);
}

.container-jumbotron {
    background-image: url("/img/sfondo-oscurato.jpg");
    height: 505px;
    width: 100%;
    background-position: 36% 67%;
    background-repeat: no-repeat;
    background-size: cover;

    display: flex;
    justify-content: center;
    flex-direction: column;
    gap: 30px;
    align-items: center;
}

h1 {
    color: #fff;
    font-size: 53px;
}

h2 {
    color: #fff;
    font-size: 20px;
}

.button {
    background-color: #fe5b5f;
    padding: 10px 25px;
    color: #fff;
    border-radius: 50px;
    cursor: pointer;
}
</style>
