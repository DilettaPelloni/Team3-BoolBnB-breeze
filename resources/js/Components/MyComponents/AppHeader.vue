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
    <div style="border-bottom: 1px solid pink"
        class="container-header flex justify-between items-center py-[10px] sm:px-[100px] px-[10px] 2xl:flex-row xl:flex-row lg:flex-row">
        <div class="container-img h-[50px]">
            <Link :href="route('welcome')">
            <img src="/img/LogoBoolBnB.png" alt="Logo BoolBnB" class="object-contain h-full" />
            </Link>
        </div>
        <div class="flex flex-col">
            <div class="container-login ml-5 relative border border-[#c9c9c9] py-[4px] px-[14px] rounded-full">
                <font-awesome-icon :icon="['fas', 'bars']" @click="toggleVisibilty" />
                <font-awesome-icon :icon="['fas', 'circle-user']" style="color: rgb(254 91 95 / 78%); padding-left: 9px"
                    size="2xl" @click="toggleVisibilty" />
                <div class="absolute z-50 rounded-md shadow-lg w-48 origin-top-right right-0 text-right p-3 bg-white mt-3"
                    v-if="menuVisibility" id="loginMenu">
                    <!-- menu login -->
                    <div v-if="canLogin" class="text-center">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="font-semibold text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                        Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')"
                                class="font-semibold text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            Log in
                            </Link>
                            <Link v-if="canRegister" :href="route('register')"
                                class="ml-4 font-semibold text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            Registrati
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../../../scss/app.scss";

#loginMenu a:hover {
    color: $main-color;
}
.container-login:hover {
    box-shadow: 3px 3px 10px 0px rgba(117, 117, 117, 0.35);
}
</style>
