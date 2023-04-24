<script>
import { Link } from "@inertiajs/vue3";
export default {
    name: "Jumbotron",
    components: {
        Link,
    },
}
</script>

<template>
    <div class="container-jumbotron">
        <!-- video -->
        <video autoplay muted loop class="video-bg">
            <source src="/img/sfondo.mp4" type="video/mp4" />
        </video>
        <!-- fine video -->
        <h1 class="text-center text-white text-[53px]">Quale sarà la tua prossima meta?</h1>
        <h2 class="text-center text-white text-[20px]">Scegli subito la tua destinazione!</h2>
        <Link :href="route('search')">
            <button class="button">Cerca la tua meta</button>
        </Link>
    </div>
</template>

<style lang="scss" scoped>
.button {
    background-color: #fe5b5f;
    padding: 10px 25px;
    color: #fff;
    border-radius: 50px;
    cursor: pointer;
}
.video-bg {
    position: absolute;
    top: 0;
    left: 0;
    min-width: 100%;
    min-height: 100%;
    z-index: -9;
}

.container-jumbotron {
    // background-image: url("/img/sfondo-oscurato.jpg");
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

    position: relative;
}
</style>
